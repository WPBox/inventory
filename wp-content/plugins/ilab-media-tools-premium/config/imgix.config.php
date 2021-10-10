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

if (!defined('ABSPATH')) { header('Location: /'); die; }

return [
    "id" => "imgix",
    "name" => "Imgix",
	"description" => "Serve your media through <a target='_blank' href='https://imgix.com'>Imgix</a>, a real-time dynamic image processing service and CDN.",
	"class" => "MediaCloud\\Plugin\\Tools\\Imgix\\ImgixTool",
	"env" => "ILAB_MEDIA_IMGIX_ENABLED",
	"dependencies" => [
		"crop",
		"storage",
		"!optimizer"
	],
    "related" => ["media-upload", "crop"],
	"helpers" => [
		"ilab-imgix-helpers.php"
	],
	"imageOptimizers" => include 'image-optimizers.config.php',
    "incompatiblePlugins" => [
        "Smush" => [
            "plugin" => "wp-smushit/wp-smush.php",
            "description" => "The free version of this plugin does not optimize the main image, only thumbnails.  When the Imgix tool is enabled, thumbnails are not generated - therefore this plugin isn't any use.  The Pro (paid) version of this plugin DOES optimize the main image though."
        ],
	    "EDD Free Downloads" => [
		    "plugin" => "edd-free-downloads/edd-free-downloads.php",
		    "description" => "EDD Free Downloads do not work with Imgix images.  For other types of files, EDD Free Downloads works great."
	    ],
    ],
    "badPlugins" => [
    ],
	"settings" => [
		"options-page" => "media-tools-imgix",
		"options-group" => "ilab-media-imgix",
		"groups" => [
			"ilab-media-imgix-settings" => [
				"title" => "Imgix Settings",
				"doc_link" => 'https://support.mediacloud.press/articles/documentation/imgix/imgix-settings',
				"description" => "Required settings for getting the Imgix integration working.",
				"options" => [
					"mcloud-imgix-domains" => [
						"title" => "Imgix Domains",
						"description" => "List of your source domains.  For more information, please read the <a href='https://www.imgix.com/docs/tutorials/creating-sources' target='_blank'>imgix documentation</a>",
						"type" => "text-area"
					],
					"mcloud-imgix-signing-key" => [
						"title" => "Imgix Signing Key",
						"description" => "Optional signing key to create secure URLs.  <strong>Recommended</strong>.  For information on setting it up, refer to the <a href='https://www.imgix.com/docs/tutorials/securing-images' target='_blank'>imgix documentation</a>.",
						"type" => "password"
					],
					"mcloud-imgix-use-https" => [
						"title" => "Use HTTPS",
						"description" => "Use HTTPS for image URLs",
						"type" => "checkbox",
                        "default" => true
					]
				]
			],
			"ilab-media-imgix-image-settings" => [
				"title" => "Imgix Image Settings",
				"doc_link" => 'https://support.mediacloud.press/articles/documentation/imgix/imgix-image-settings',
				"options" => [
					"mcloud-imgix-crop-mode" => [
						"title" => "Crop Mode",
						"description" => "Controls the mode when rendering cropped images.  Multiple crop modes means that the crop will first try to center the crop on any detected faces, but if no faces are detected than the next crop mode will be used.  Note that any settings specified in the Image Size Manager or Image Editor will override this.",
						"type" => "select",
						"options" => [
							"" => "Default",
							'faces,position' => 'Faces, Position',
							'faces,edges' => 'Faces, Edges',
							'faces,entropy' => 'Faces, Entropy',
						],
						"default" => null
					],
					"mcloud-imgix-crop-position" => [
						"title" => "Crop Position",
						"description" => "Controls the default position of the crop.",
						"type" => "select",
						"options" => [
							"center" => "Center",
							'top,left' => "Top Left",
							'top' => 'Top',
							'top,right' => "Top Right",
							'right' => 'Right',
							'bottom,right' => 'Bottom Right',
							'bottom' => 'Bottom',
							'bottom, left' => 'Bottom Left',
							'left' => 'Left',
						],
						"default" => 'center'
					],
					"mcloud-imgix-serve-private-images" => [
						"title" => "Serve Private Images",
						"description" => "When enabled, private images, or image sizes that have had their privacy level set to private, will be rendered through imgix.  When disabled, any private images or private image sizes will be served from cloud storage using signed URLs, if enabled.",
						"type" => "checkbox",
						"default" => true
					],
					"mcloud-imgix-default-quality" => [
						"title" => "Lossy Image Quality",
                        "description" => "This controls the quality of any lossy images generated by Imgix.",
						"type" => "number"
					],
					"mcloud-imgix-auto-format" => [
						"title" => "Auto Format",
						"description" => "Allows imgix to choose the most appropriate file format to deliver your image based on the requesting web browser.",
						"type" => "checkbox"
					],
					"mcloud-imgix-auto-compress" => [
						"title" => "Auto Compress",
						"description" => "Allows imgix to automatically compress your images.",
						"type" => "checkbox"
					],
                    "mcloud-imgix-enable-alt-formats" => [
                        "title" => "Enable Alternative Formats",
                        "description" => "Allow uploads of Photoshop PSDs, TIFF images and Adobe Illustrator documents.  Note that if you enable this, you'll only be able to view them as images on your site while Imgix is enabled.  Basically, once you head down this path, you cannot go back.",
                        "type" => "checkbox"
                    ],
                    "mcloud-imgix-generate-thumbnails" => [
                        "title" => "Keep WordPress Thumbnails",
                        "description" => "Because Imgix can dynamically create new sizes for existing images, having WordPress create thumbnails is potentially pointless, a probable waste of space and definitely slows down uploads.  However, if you plan to stop using Imgix, having those thumbnails on S3 or locally will save you having to regenerate thumbnails later.  <strong>IMPORTANT:</strong> Thumbnails will not be generated when you perform a direct upload because those uploads are sent directly to S3 without going through your WordPress server.",
                        "type" => "checkbox",
                        "default" => true
                    ],
					"mcloud-imgix-render-pdf-files" => [
						"title" => "Render PDF Files",
						"description" => "Render PDF files as images.  Like the <em>Enable Alternative Formats</em>, once you enable this option, you'll only be able to see the PDFs as images while Imgix is enabled.",
						"type" => "checkbox"
					],
					"mcloud-imgix-render-svg-files" => [
						"title" => "Render SVG Files",
						"description" => "Render SVG files as bitmap images.  <em>This only affects image sizes other than <strong>full</strong>.</em>  When this is enabled, the other image sizes will be rendered as PNG images, this might not be what you want.",
						"type" => "checkbox",
						"default" => false,
					],
					"mcloud-imgix-detect-faces" => [
						"title" => "Detect Faces",
						"description" => "After each upload Media Cloud will use Imgix's face detection API to detect faces in the image.  This can be used with Focus Crop in the image editor, or on the front-end however you choose.  <strong>Note:</strong> If you are relying on this functionality, the better option would be to use the <a href='admin.php?page=media-cloud-settings&tab=vision'>Vision</a> tool.  It is more accurate with less false positives.  If Vision is enabled, this setting is ignored in favor of Vision's results.",
						"type" => "checkbox",
						"default" => false
					],
					"mcloud-imgix-remove-extra-variables" => [
						"title" => "Remove Extra Query Variables",
						"description" => "Removes extra query variables from the imgix URL such as the <code>ixlib</code> and <code>wpsize</code> variables.",
						"type" => "checkbox",
						"default" => false
					]
				]
			],
			"ilab-media-imgix-gif-settings" => [
				"title" => "Imgix GIF Settings",
				"description" => "Controls how animated gifs appear on the site.  <strong>You must have a premium Imgix account to have animated GIF support.</strong>  <a target='_blank' href='https://docs.imgix.com/apis/url/format/fm'>See here for more details</a> or <a target='_blank' href='https://www.imgix.com/contact-us'>contact their sales team</a> for more information.",
				"options" => [
                    "mcloud-imgix-enable-gifs" => [
                        "title" => "Enable GIFs",
                        "description" => "Enables support for animated GIFs.  If this is not enabled, any uploaded GIFs will be converted.  <strong>Note that this is a feature of premium Imgix accounts only.  GIF support is not enabled on standard Imgix accounts by default.  Contact Imgix sales for more information.</strong>",
                        "type" => "checkbox",
                        "default" => false
                    ],
                    "mcloud-imgix-skip-gifs" => [
                        "title" => "Serve GIFs from Storage",
                        "description" => "If this option is enabled, GIFs will be served straight from S3, or whatever storage provider you are using, and not from Imgix.  If <strong>Enable GIFs</strong> is enabled, this setting is ignored.",
                        "type" => "checkbox",
                        "default" => false
                    ],
					"mcloud-imgix-no-gif-sizes" => [
						"title" => "Disallow Animated GIFs for Sizes",
						"description" => "List the sizes that aren't allowed to have animated GIFs.  These sizes will display jpegs instead.",
						"type" => "text-area"
					]
				]
			]
		],
		"params" => [
			"adjust" => [
                "Orientation" => [
                    "or" => [
                        "type" => "pillbox",
                        "radio" => true,
                        "no-icon" => true,
                        "options" => [
                            "90" => [
                                "title" => "90°",
                                "default" => 0
                            ],
                            "180" => [
                                "title" => "180°",
                                "default" => 0
                            ],
                            "270" => [
                                "title" => "270°",
                                "default" => 0
                            ],
                        ],
                        "selected" => function($settings, $currentValue, $selectedOutput, $unselectedOutput){
                            if (isset($settings['or']) && ($settings['or'] == $currentValue)) {
                                return $selectedOutput;
                            }

                            return $unselectedOutput;
                        }
                    ]
                ],
                "Flip" => [
                    "flip" => [
                        "type" => "pillbox",
                        "options" => [
                            "h" => [
                                "title" => "Horizontal",
                                "default" => 0
                            ],
                            "v" => [
                                "title" => "Vertical",
                                "default" => 0
                            ]
                        ],
                        "selected" => function($settings, $currentValue, $selectedOutput, $unselectedOutput){
                            if (isset($settings['flip'])) {
                                $parts=explode(',',$settings['flip']);
                                foreach($parts as $part) {
                                    if ($part==$currentValue) {
                                        return $selectedOutput;
                                    }
                                }
                            }

                            return $unselectedOutput;
                        }
                    ]
                ],
                "Transform" => [
                    "rot" => [
                        "title" => "Rotation",
                        "type" => "slider",
	                    "suffix" => "°",
                        "min" => -359,
                        "max" => 359,
                        "default" => 0
                    ]
                ],
                "Enhance" => [
                    "auto" => [
                        "type" => "pillbox",
                        "options" => [
                            "enhance" => [
                                "title" => "Auto Enhance",
                                "default" => 0
                            ],
                            "redeye" => [
                                "title" => "Remove Red Eye",
                                "default" => 0
                            ]
                        ],
                        "selected" => function($settings, $currentValue, $selectedOutput, $unselectedOutput){
                            if (isset($settings['auto'])) {
                                $parts=explode(',',$settings['auto']);
                                foreach($parts as $part) {
                                    if ($part==$currentValue) {
                                        return $selectedOutput;
                                    }
                                }
                            }

                            return $unselectedOutput;
                        }
                    ]
                ],
				"Luminosity Controls" => [
					"bri" => [
						"title" => "Brightness",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"con" => [
						"title" => "Contrast",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"exp" => [
						"title" => "Exposure",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"gam" => [
						"title" => "Gamma",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"high" => [
						"title" => "Highlight",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"shad" => [
						"title" => "Shadow",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					]
				],
				"Color Controls" => [
					"hue" => [
						"title" => "Hue",
						"type" => "slider",
						"min" => -359,
						"max" => 359,
						"default" => 0
					],
					"sat" => [
						"title" => "Saturation",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"vib" => [
						"title" => "Vibrancy",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					]
				],
				"Noise/Sharpen/Blur" => [
					"sharp" => [
						"title" => "Sharpen",
						"type" => "slider",
						"min" => 0,
						"max" => 100,
						"default" => 0
					],
                    "usm" => [
                        "title" => "Unsharp Mask",
                        "type" => "slider",
                        "min" => -100,
                        "max" => 100,
                        "default" => 0
                    ],
                    "usmrad" => [
                        "title" => "Unsharp Mask Radius",
                        "type" => "slider",
                        "min" => 0,
                        "max" => 500,
                        "default" => 0
                    ],
					"nr" => [
						"title" => "Noise Reduction",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"nrs" => [
						"title" => "Noise Reduction Sharpen Bound",
						"type" => "slider",
						"min" => -100,
						"max" => 100,
						"default" => 0
					],
					"blur" => [
						"title" => "Blur",
						"type" => "slider",
						"min" => 0,
						"max" => 2000,
						"default" => 0
					]
				],
			],
			"stylize" => [
				"Stylize" => [
					"blend" => [
						"title" => "Tint",
						"type" => "blend-color",
						"blend-param" => "bm",
						"blends" => [
							"none" => "Normal",
							"color" => "Color",
							"burn" => "Burn",
							"dodge" => "Dodge",
							"darken" => "Darken",
							"difference" => "Difference",
							"exclusion" => "Exclusion",
							"hardlight" => "Hard Light",
							"hue" => "Hue",
							"lighten" => "Lighten",
							"luminosity" => "Luminosity",
							"multiply" => "Multiply",
							"overlay" => "Overlay",
							"saturation" => "Saturation",
							"screen" => "Screen",
							"softlight" => "Soft Light"
						]
					],
					"htn" => [
						"title" => "Halftone",
						"type" => "slider",
						"min" => 0,
						"max" => 100,
						"default" => 0
					],
					"px" => [
						"title" => "Pixellate",
						"type" => "slider",
						"suffix" => "px",
						"min" => 0,
						"max" => 100,
						"default" => 0
					],
					"mono" => [
						"title" => "Monochrome",
						"type" => "color"
					],
					"sepia" => [
						"title" => "Sepia",
						"type" => "slider",
						"min" => 0,
						"max" => 100,
						"default" => 0
					]
				],
				"Border" => [
					"border-color" => [
						"title" => "Border Color",
						"type" => "color"
					],
					"border-width" => [
						"title" => "Border Width",
						"type" => "slider",
						"suffix" => "px",
						"min" => 0,
						"max" => 500,
						"default" => 0
					]
				],
				"Padding" => [
					"padding-color" => [
						"title" => "Padding Color",
						"type" => "color"
					],
					"padding-width" => [
						"title" => "Padding Width",
						"type" => "slider",
						"suffix" => "px",
						"min" => 0,
						"max" => 500,
						"default" => 0
					]
				]
			],
			"watermark" => [
				"Watermark Media" => [
					"media" => [
						"title" => "Watermark Image",
						"type" => "media-chooser",
						"imgix-param" => "mark",
						"dependents" => [
							"markalign",
							"markalpha",
							"markpad",
							"markscale"
						]
					]
				],
				"Watermark Settings" => [
					"markalign" => [
						"title" => "Watermark Alignment",
						"type" => "alignment"
					],
					"markalpha" => [
						"title" => "Watermark Alpha",
						"type" => "slider",
						"min" => 0,
						"max" => 100,
						"default" => 100
					],
					"markpad" => [
						"title" => "Watermark Padding",
						"type" => "slider",
						"min" => 0,
						"max" => 3000,
						"suffix" => "px",
						"default" => 0
					],
				],
				"Watermark Size" => [
					"markfit" => [
						"type" => "pillbox",
						"radio" => true,
						"options" => [
							"clip" => [
								"title" => "Clip",
								"default" => 0
							],
							"crop" => [
								"title" => "Crop",
								"default" => 0
							],
							"max" => [
								"title" => "Max",
								"default" => 0
							],
							"scale" => [
								"title" => "Scale",
								"default" => 0
							]
						],
						"selected" => function($settings, $currentValue, $selectedOutput, $unselectedOutput){
							if (isset($settings['markfit']) && ($settings['markfit'] == $currentValue)) {
								return $selectedOutput;
							}

							return $unselectedOutput;
						}
					],
					"markscale" => [
						"title" => "Watermark Scale",
						"type" => "slider",
						"suffix" => "%",
						"min" => 0,
						"max" => 200,
						"default" => 0
					],
					"markw" => [
						"title" => "Watermark Width",
						"type" => "slider",
						"suffix" => "px",
						"min" => 0,
						"max" => 3000,
						"default" => 0
					],
					"markh" => [
						"title" => "Watermark Height",
						"type" => "slider",
						"suffix" => "px",
						"min" => 0,
						"max" => 3000,
						"default" => 0
					],
				]
			],
			"focus-crop" => [
				"Focus" => [
					"focalpoint" => [
						"type" => "pillbox",
						"exclusive" => true,
						"options" => [
							"focalpoint" => [
								"title" => "Focal Point",
								"default" => 0
							],
							"usefaces" => [
								"title" => "Use Faces",
								"default" => 0
							],
							"entropy" => [
								"title" => "Entropy",
								"default" => 0
							],
							"edges" => [
								"title" => "Edges",
								"default" => 0
							]
						],
						"selected" => function($settings, $currentValue, $selectedOutput, $unselectedOutput){
							if (isset($settings['focalpoint']) && ($settings['focalpoint'] == $currentValue)) {
								return $selectedOutput;
							}

							return $unselectedOutput;
						}
					]
				],
				"Focal Point" => [
					"fp-z" => [
						"title" => "Focal Point Zoom",
						"type" => "slider",
						"suffix" => "x",
						"min" => 0,
						"max" => 10,
						"default" => 1
					]
				],
				"Faces" => [
					"faceindex" => [
						"title" => "Face Index",
						"type" => "slider",
						"min" => 0,
						"max" => 10,
						"default" => 0
					]
				]
			]
		]
	]
];