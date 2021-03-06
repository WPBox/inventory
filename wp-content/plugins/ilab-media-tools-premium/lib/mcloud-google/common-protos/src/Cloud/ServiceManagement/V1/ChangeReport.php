<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/servicemanagement/v1/resources.proto

namespace MediaCloud\Vendor\Google\Cloud\ServiceManagement\V1;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * Change report associated with a particular service configuration.
 * It contains a list of ConfigChanges based on the comparison between
 * two service configurations.
 *
 * Generated from protobuf message <code>google.api.servicemanagement.v1.ChangeReport</code>
 */
class ChangeReport extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * List of changes between two service configurations.
     * The changes will be alphabetically sorted based on the identifier
     * of each change.
     * A ConfigChange identifier is a dot separated path to the configuration.
     * Example: visibility.rules[selector='LibraryService.CreateBook'].restriction
     *
     * Generated from protobuf field <code>repeated .google.api.ConfigChange config_changes = 1;</code>
     */
    private $config_changes;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \MediaCloud\Vendor\Google\Api\ConfigChange[]|\Google\Protobuf\Internal\RepeatedField $config_changes
     *           List of changes between two service configurations.
     *           The changes will be alphabetically sorted based on the identifier
     *           of each change.
     *           A ConfigChange identifier is a dot separated path to the configuration.
     *           Example: visibility.rules[selector='LibraryService.CreateBook'].restriction
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Api\Servicemanagement\V1\Resources::initOnce();
        parent::__construct($data);
    }

    /**
     * List of changes between two service configurations.
     * The changes will be alphabetically sorted based on the identifier
     * of each change.
     * A ConfigChange identifier is a dot separated path to the configuration.
     * Example: visibility.rules[selector='LibraryService.CreateBook'].restriction
     *
     * Generated from protobuf field <code>repeated .google.api.ConfigChange config_changes = 1;</code>
     * @return \MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField
     */
    public function getConfigChanges()
    {
        return $this->config_changes;
    }

    /**
     * List of changes between two service configurations.
     * The changes will be alphabetically sorted based on the identifier
     * of each change.
     * A ConfigChange identifier is a dot separated path to the configuration.
     * Example: visibility.rules[selector='LibraryService.CreateBook'].restriction
     *
     * Generated from protobuf field <code>repeated .google.api.ConfigChange config_changes = 1;</code>
     * @param \MediaCloud\Vendor\Google\Api\ConfigChange[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setConfigChanges($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \MediaCloud\Vendor\Google\Protobuf\Internal\GPBType::MESSAGE, \MediaCloud\Vendor\Google\Api\ConfigChange::class);
        $this->config_changes = $arr;

        return $this;
    }

}

