<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/vision/v1/image_annotator.proto

namespace MediaCloud\Vendor\Google\Cloud\Vision\V1;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * Response to a batch image annotation request.
 *
 * Generated from protobuf message <code>google.cloud.vision.v1.BatchAnnotateImagesResponse</code>
 */
class BatchAnnotateImagesResponse extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * Individual responses to image annotation requests within the batch.
     *
     * Generated from protobuf field <code>repeated .google.cloud.vision.v1.AnnotateImageResponse responses = 1;</code>
     */
    private $responses;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \MediaCloud\Vendor\Google\Cloud\Vision\V1\AnnotateImageResponse[]|\Google\Protobuf\Internal\RepeatedField $responses
     *           Individual responses to image annotation requests within the batch.
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Cloud\Vision\V1\ImageAnnotator::initOnce();
        parent::__construct($data);
    }

    /**
     * Individual responses to image annotation requests within the batch.
     *
     * Generated from protobuf field <code>repeated .google.cloud.vision.v1.AnnotateImageResponse responses = 1;</code>
     * @return \MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Individual responses to image annotation requests within the batch.
     *
     * Generated from protobuf field <code>repeated .google.cloud.vision.v1.AnnotateImageResponse responses = 1;</code>
     * @param \MediaCloud\Vendor\Google\Cloud\Vision\V1\AnnotateImageResponse[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setResponses($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \MediaCloud\Vendor\Google\Protobuf\Internal\GPBType::MESSAGE, \MediaCloud\Vendor\Google\Cloud\Vision\V1\AnnotateImageResponse::class);
        $this->responses = $arr;

        return $this;
    }

}

