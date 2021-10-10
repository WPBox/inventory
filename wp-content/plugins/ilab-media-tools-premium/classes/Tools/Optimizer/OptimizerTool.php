<?php

// Copyright (c) 2016 Interfacelab LLC. All rights reserved.
//
// Released under the GPLv3 license
// http://www.gnu.org/licenses/gpl-3.0.html
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************

namespace MediaCloud\Plugin\Tools\Optimizer;

use MediaCloud\Plugin\Tools\Storage\StorageGlobals;
use MediaCloud\Plugin\Tools\Storage\StorageInterface;
use MediaCloud\Plugin\Tools\Storage\StorageToolSettings;
use MediaCloud\Plugin\Tasks\TaskManager;
use MediaCloud\Plugin\Tasks\TaskSchedule;
use MediaCloud\Plugin\Tools\MediaUpload\UploadToolSettings;
use MediaCloud\Plugin\Tools\Optimizer\Models\BackgroundOptimization;
use MediaCloud\Plugin\Tools\Optimizer\Models\Data\BackgroundData;
use MediaCloud\Plugin\Tools\Optimizer\Models\Data\OptimizerData;
use MediaCloud\Plugin\Tools\Optimizer\Models\OptimizationStats;
use MediaCloud\Plugin\Tools\Optimizer\Models\PendingOptimization;
use MediaCloud\Plugin\Tools\Optimizer\Tasks\BackgroundOptimizeTask;
use MediaCloud\Plugin\Tools\Storage\StorageTool;
use MediaCloud\Plugin\Tools\Tool;
use MediaCloud\Plugin\Tools\ToolsManager;
use MediaCloud\Plugin\Utilities\Logging\Logger;
use MediaCloud\Plugin\Utilities\NoticeManager;
use MediaCloud\Plugin\Utilities\View;
use function MediaCloud\Plugin\Utilities\arrayPath;

class OptimizerTool extends Tool {
	/** @var null|OptimizerToolSettings */
	protected $settings = null;

	protected $registry = [];

	/** @var OptimizerInterface  */
	protected $driver = null;

	public function __construct($toolName, $toolInfo, $toolManager) {
		$this->settings = OptimizerToolSettings::instance();

		if (!empty($toolInfo['optimizationDrivers'])) {
			foreach($toolInfo['optimizationDrivers'] as $key => $data) {
				if (empty($data['name']) || empty($data['class']) || empty($data['config'])) {
					throw new \Exception("Optimization configuration file is malformed.  Optimization drivers are missing required information.");
				}

				$configFile = ILAB_CONFIG_DIR . $data['config'];
				if (!file_exists($configFile)) {
					throw new \Exception("Missing driver config file '$configFile'. ");
				}

				$config = include $configFile;
				$this->registry[$key] = [
					'name' => $data['name'],
					'class' => $data['class'],
					'config' => $config,
					'help' => arrayPath($data, 'help', null)
				];
			}
		}


		$driverConfigs = [];
		foreach($this->registry as $key => $driver) {
			$driverConfigs[$key] = $driver['config'];
		}

		$toolInfo = $this->mergeSettings($toolInfo, $driverConfigs);

		parent::__construct($toolName, $toolInfo, $toolManager);
	}

	//region Statoc
	public static function instance() {
		return ToolsManager::instance()->tools['optimizer'];
	}
	//endregion

	//region Tool Overrides
	public function hasSettings() {
		return true;
	}

	public function setup() {
		if ($this->enabled()) {
			if ($this->driver->supportsWebhooks()) {
				add_filter('template_include', [$this, 'handleWebhook']);
			}
		}
	}

	public function enabled() {
		$enabled = parent::enabled();

		if($enabled) {
			OptimizerData::init();
			BackgroundData::init();

			TaskManager::registerTask(BackgroundOptimizeTask::class);

			if (isset($this->registry[$this->settings->provider])) {
				$class = $this->registry[$this->settings->provider]['class'];
				$this->driver = new $class();
			}

			$enabled = $this->driver->enabled();
		}

		if (!empty($enabled) && ToolsManager::instance()->toolEnabled('media-upload') && (!empty(UploadToolSettings::instance()->uploadImages))) {
			NoticeManager::instance()->displayAdminNotice('warning', "The image optimizer will not process any image uploads done via Direct Uploads.  But it will process any images generated by other processes like the crop tool or when generating preview images for video encoding.", true, 'media-cloud-optimizer-direct-uploads', 365);
		}

		return $enabled;
	}
	//endregion

	//region Properties

	/**
	 * The driver in use
	 * @return OptimizerInterface
	 */
	public function driver() {
		return $this->driver;
	}

	//endregion

	//region Settings

	public function providerOptions() {
		$providers = [];
		foreach($this->registry as $id => $driver) {
			$providers[$id] = $driver['name'];
		}

		return $providers;
	}

	public function providerHelp() {
		$help = [];
		foreach($this->registry as $id => $driver) {
			$helpData = arrayPath($driver, 'help', null);
			if (!empty($helpData)) {
				$help[$id] = $helpData;
			}
		}

		return $help;
	}

	//endregion


	//region Webhook

	public function debugHandleWebhook($body, $bodyData) {
		$uploadDirInfo = wp_upload_dir();
		$basePath = trailingslashit($uploadDirInfo['basedir']).'webhook/optimize/'.time();

		@mkdir($basePath, 0700, true);

		file_put_contents($basePath.'.raw.txt', $body);
		file_put_contents($basePath.'.json', json_encode($bodyData, JSON_PRETTY_PRINT));
	}

	public function handleWebhook($template) {
		$hookUrlInfo = parse_url($this->settings->webhookUrl);

		if (strpos($_SERVER['REQUEST_URI'], $hookUrlInfo['path']) === 0) {
			$body = file_get_contents('php://input');
			if (!empty($body)) {
				if($_SERVER["CONTENT_TYPE"] === 'application/x-www-form-urlencoded') {
					parse_str($body, $data);
				} else {
					$data = json_decode($body, true);
				}
			}

			if (!empty($data)) {
				$this->debugHandleWebhook($body, $data);
				Logger::info("Handling optimizer webhook", [], __METHOD__, __LINE__);
				$this->driver->handleWebhook($data);
			} else {
				Logger::warning("Empty data", [], __METHOD__, __LINE__);
			}

			wp_send_json(['status' => 'ok'], 200);
		}

		return $template;
	}


	//endregion

	//region Image Optimization

	public function startProcessing($postId) {
		if (empty($postId) || empty($this->driver->shouldUseWebhook())) {
			return;
		}

		update_post_meta($postId, '_mcloud_optimize_lock', time());
	}

	public function endProcessing($postId, $data) {
		if (empty($postId) || empty($this->driver->shouldUseWebhook())) {
			delete_post_meta($postId, '_mcloud_optimize_lock');
			return $data;
		}

		$deferred = get_post_meta($postId, '_mcloud_deferred_opts', true);
		delete_post_meta($postId, '_mcloud_deferred_opts');

		if (empty($deferred)) {
			delete_post_meta($postId, '_mcloud_optimize_lock');
			return $data;
		}

		if (isset($deferred['s3'])) {
			$data['s3'] = $deferred['s3'];
		}

		if (isset($deferred['original_image_s3'])) {
			$data['original_image_s3'] = $deferred['original_image_s3'];
		}

		$sizes = arrayPath($deferred, 'sizes', []);
		foreach($sizes as $size => $sizeS3) {
			if (isset($data['sizes'][$size])) {
				$data['sizes'][$size]['s3'] = $sizeS3['s3'];
			}
		}

		delete_post_meta($postId, '_mcloud_optimize_lock');
		return $data;
	}

	private function downloadUrl($url, $filename, $try = 1) {
		$downloadResult = wp_remote_get($url, [
			'stream' => true,
			'timeout' => (10 + (($try - 1) * 5)),
			'filename' => $filename
		]);

		if (is_wp_error($downloadResult)) {
			Logger::error("Error downloading file {$url} to {$filename} on try #{$try}: ".$downloadResult->get_error_message(),  [], __METHOD__, __LINE__);

			if ($try === 4) {
				return false;
			}

			return $this->downloadUrl($url, $filename, $try + 1);
		}

		return true;
	}

	/**
	 * Performs an image optimization
	 * @param StorageInterface $client
	 * @param int $postId
	 * @param string $uploadPath
	 * @param string $filename
	 * @param string $prefix
	 * @param string $bucketFilename
	 * @param string $privacy
	 * @param string $providerId
	 * @param string $currentSize
	 * @param bool $noBackground
	 *
	 * @return array [
	 *   'status' => int,
	 *   'results' => OptimizerResultsInterface
	 * ]
	 * @throws \Exception
	 */
	public function performOptimization($client, $postId, $uploadPath, $filename, $prefix, $bucketFilename, $privacy, $providerId, $currentSize, $noBackground = false) {
		if (!file_is_displayable_image(trailingslashit($uploadPath).$filename)) {
			return [
				'status' => OptimizerConsts::SKIPPED,
				'results' => null
			];
		}

		if (($currentSize === 'original') && (empty($this->settings->optimizeOriginal))) {
			return [
				'status' => OptimizerConsts::SKIPPED,
				'results' => null
			];
		}

		if (strpos($filename, '/') !== false) {
			$uploadPath = trailingslashit($uploadPath) . pathinfo($filename, PATHINFO_DIRNAME);
			$filename = pathinfo($filename, PATHINFO_BASENAME);
		}

		$noBackground = apply_filters('media-cloud/optimizer/no-background', $noBackground);
		if ($this->settings->backgroundMode && empty($noBackground)) {
			$bg = new BackgroundOptimization();
			$bg->postId = $postId;
			$bg->createdAt = time();
			$bg->uploadPath = $uploadPath;
			$bg->filename = $filename;
			$bg->prefix = $prefix;
			$bg->bucketFilename = $bucketFilename;
			$bg->privacy = $privacy;
			$bg->provider = $providerId;
			$bg->currentSize = $currentSize;
			$bg->save();

			Logger::info("Queueing optimization to background task {$bg->id()}", [], __METHOD__, __LINE__);

			$task = TaskSchedule::nextScheduledTaskOfType(BackgroundOptimizeTask::identifier(), 0.5);
			if (!empty($task)) {
				$task->selection = array_merge($task->selection, [$bg->id()]);
				$task->save();
			} else {
				BackgroundOptimizeTask::scheduleIn(1, [], [$bg->id()]);
			}

			return [
				'status' => OptimizerConsts::DEFERRED,
				'results' => null
			];
		}

		$cloudInfo = null;

		if ($this->driver->supportsCloudStorage($providerId)) {
			$cloudInfo = $client->prepareOptimizationInfo();
			$cloudInfo = array_merge($cloudInfo, [
				'path' => $prefix.$bucketFilename,
				'acl' => $privacy,
				'headers' => [
					"Cache-Control" => StorageToolSettings::cacheControl(),
					"Expires" => StorageToolSettings::expires(),
				]
			]);
		}

		$mimeType = wp_get_image_mime(trailingslashit($uploadPath).$filename);

		$s3Data = [
			'bucket' => $client->bucket(),
			'privacy' => $privacy,
			'key' => $prefix.$bucketFilename,
			'provider' =>  $providerId,
			'mimeType' => $mimeType,
			'v' => MEDIA_CLOUD_INFO_VERSION
		];

		$shouldUpload = $this->driver->shouldUpload();
		$shouldUpload = apply_filters('media-cloud/optimizer/can-upload', $shouldUpload);

		if (!empty($shouldUpload) && $this->driver->supportsUploads()) {
			$result = $this->driver->optimizeFile(trailingslashit($uploadPath).$filename, $cloudInfo, $currentSize);
		} else {
			$uploadDir = wp_get_upload_dir();
			$remoteUrl = str_replace($uploadDir['basedir'], $uploadDir['baseurl'], trailingslashit($uploadPath).$filename);

			if (defined('MEDIACLOUD_DEV_MODE') && defined('MEDIACLOUD_IMAGE_SERVER') && !empty(constant('MEDIACLOUD_IMAGE_SERVER'))) {
				// DEBUG ONLY
				$remoteUrl = str_replace(home_url(), constant('MEDIACLOUD_IMAGE_SERVER'), $remoteUrl);
			}

			$result = $this->driver->optimizeUrl($remoteUrl, trailingslashit($uploadPath).$filename, $cloudInfo, $currentSize);
		}

		if (!empty($result)) {
			if ($result->success()) {
				Logger::info("Optimization success.",  [], __METHOD__, __LINE__);
				if (!empty($result->optimizedUrl()) && empty($cloudInfo)) {
					Logger::info("Downloading optimized file {$result->optimizedUrl()}",  [], __METHOD__, __LINE__);
					if (!$this->downloadUrl($result->optimizedUrl(), trailingslashit($uploadPath).'optimized-'.$filename)) {
						Logger::error("Could not download {$result->optimizedUrl()} skipping.",  [], __METHOD__, __LINE__);
						return [
							'status' => OptimizerConsts::SKIPPED,
							'results' => null
						];
					}

					@unlink(trailingslashit($uploadPath).$filename);
					@rename(trailingslashit($uploadPath).'optimized-'.$filename, trailingslashit($uploadPath).$filename);

					Logger::info("Download complete for {$result->optimizedUrl()}",  [], __METHOD__, __LINE__);
				}

				if (!empty($postId) && !empty($currentSize)) {
					Logger::info("Saving statistics.",  [], __METHOD__, __LINE__);
					$optStats = new OptimizationStats($postId);
					$optStats->saveResult($currentSize, $result->originalSize(), $result->optimizedSize());
				}

				return [
					'status' => (empty($cloudInfo)) ? OptimizerConsts::SUCCESS : OptimizerConsts::SUCCESS_CLOUD,
					'results' => $result
				];
			} else if (!empty($result->id())) {
				$pending = PendingOptimization::fromResult($result);
				$pending->wordpressSize = $currentSize;
				$pending->s3Data = $s3Data;
				$pending->savedToCloud = !empty($cloudInfo);
				$pending->postId = $postId;

				$pending->save();

				return [
					'status' => OptimizerConsts::DEFERRED,
					'results' => $result
				];
			}
		}

		return [
			'status' => OptimizerConsts::SKIPPED,
			'results' => null
		];
	}

	/**
	 * @param BackgroundOptimization $bg
	 */
	public function performBackgroundOptimization($bg) {
		/** @var StorageTool $storage */
		$storage = ToolsManager::instance()->tools['storage'];

		$result = $this->performOptimization($storage->client(), $bg->postId, $bg->uploadPath, $bg->filename, $bg->prefix, $bg->bucketFilename, $bg->privacy, $bg->provider, $bg->currentSize, true);

		$toDelete = [];

		if (in_array($result['status'], [OptimizerConsts::SUCCESS, OptimizerConsts::SUCCESS_CLOUD])) {
			Logger::info("Optimization was successful: {$result['status']}", null, __METHOD__, __LINE__);
			$s3Data = [
				'bucket' => $storage->client()->bucket(),
				'privacy' => $bg->privacy,
				'key' => $bg->prefix.$bg->bucketFilename,
				'provider' =>  $bg->provider,
				'v' => MEDIA_CLOUD_INFO_VERSION
			];

			if ($result['status'] === OptimizerConsts::SUCCESS) {
				Logger::info("Uploading {$bg->filename} to cloud storage", [], __METHOD__, __LINE__);
				$optimizedUrl = $storage->client()->upload(trailingslashit($bg->prefix).$bg->bucketFilename, trailingslashit($bg->uploadPath).$bg->filename, $bg->privacy, StorageGlobals::cacheControl(), StorageGlobals::cacheControl());
				$toDelete[] = trailingslashit($bg->uploadPath).$bg->filename;
				Logger::info("Finished uploading {$bg->filename} to cloud storage", [], __METHOD__, __LINE__);
			} else {
				$optimizedUrl = $result['results']->optimizedUrl();
			}

			$this->processCloudMetadata($optimizedUrl, $bg->postId, $bg->currentSize, $s3Data);
		} else {
			Logger::info("Optimization result: {$result['status']}", [], __METHOD__, __LINE__);
		}

		$canDelete = apply_filters('media-cloud/storage/delete_uploads', true);
		if (!empty($toDelete) && !empty($canDelete) && StorageToolSettings::deleteOnUpload()) {
			foreach($toDelete as $fileToDelete) {
				@unlink($fileToDelete);
			}
		}

		$bg->delete();
	}

	public function processCloudMetadata($url, $postId, $wordpressSize, $s3Data) {
		$isProcessing = false;

		if (!empty(get_post_meta($postId, '_mcloud_optimize_lock', true))) {
			Logger::info("Metadata is locked for {$postId}", [], __METHOD__, __FUNCTION__);

			$isProcessing = true;
			$meta = get_post_meta($postId, '_mcloud_deferred_opts', true);
			if (empty($meta)) {
				$meta = [];
			}
		} else {
			$meta = get_post_meta($postId, '_wp_attachment_metadata', true);
			if (empty($meta)) {
				Logger::error("Attachment metadata is missing or empty for {$postId}", [], __METHOD__, __LINE__);
				return;
			}
		}

		Logger::info("Found metadata for {$postId} for size {$wordpressSize}", [], __METHOD__, __LINE__);

		$s3Info = $s3Data;
		$s3Info['url'] = $url;
		unset($s3Info['mimeType']);

		$updated = false;
		if ($wordpressSize === 'full') {
			$meta['s3'] = $s3Info;
			$meta['s3']['optimized'] = true;
			$updated = true;
		} else if ($wordpressSize === 'original') {
			$meta['original_image_s3'] = $s3Info;
			$meta['original_image_s3']['optimized'] = true;
			$updated = true;
		} else if ($isProcessing) {
			if (!isset($meta['sizes'])) {
				$meta['sizes'] = [];
			}

			$meta['sizes'][$wordpressSize] = ['s3' => $s3Info];
			$meta['sizes'][$wordpressSize]['s3']['optimized'] = true;
			$updated = true;
		}  else {
			$sizes = arrayPath($meta, 'sizes', []);
			if (!empty($sizes) && isset($sizes[$wordpressSize])) {
				$sizes[$wordpressSize]['s3'] = $s3Info;
				$sizes[$wordpressSize]['s3']['optimized'] = true;
				$meta['sizes'] = $sizes;
				$updated = true;
			} else {
				Logger::warning("Size {$wordpressSize} missing from metadata sizes.", [], __METHOD__, __LINE__);
			}
		}

		if ($updated) {
			Logger::info("Metadata updated for {$wordpressSize}", [], __METHOD__, __LINE__);
			if ($isProcessing) {
				update_post_meta($postId, '_mcloud_deferred_opts', $meta);
			} else {
				update_post_meta($postId, '_wp_attachment_metadata', $meta);
			}
		}
	}
	//endregion

	//region Stats
	public static function renderStats() {
		/** @var OptimizerAccountStatus $accountStatus */
		$accountStatus = null;

		/** @var OptimizerTool $optimizerTool */
		$optimizerTool = ToolsManager::instance()->tools['optimizer'];

		if (empty($optimizerTool->driver())) {
			return;
		}

		if ($optimizerTool->driver()->enabled()) {
			$accountStatus = $optimizerTool->driver()->accountStats();
		}

		$globalStats = get_option('mcloud-optimize-stats');

		echo View::render_view('admin.optimizer.stats', ['accountStatus' => $accountStatus, 'globalStats' => $globalStats]);
	}
	//endregion
}