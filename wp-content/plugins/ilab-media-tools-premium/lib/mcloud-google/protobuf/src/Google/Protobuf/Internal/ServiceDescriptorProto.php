<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/protobuf/descriptor.proto

namespace MediaCloud\Vendor\Google\Protobuf\Internal;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBWire;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\InputStream;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * Describes a service.
 *
 * Generated from protobuf message <code>google.protobuf.ServiceDescriptorProto</code>
 */
class ServiceDescriptorProto extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     */
    protected $name = '';
    private $has_name = false;
    /**
     * Generated from protobuf field <code>repeated .google.protobuf.MethodDescriptorProto method = 2;</code>
     */
    private $method;
    private $has_method = false;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.ServiceOptions options = 3;</code>
     */
    protected $options = null;
    private $has_options = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *     @type \MediaCloud\Vendor\Google\Protobuf\Internal\MethodDescriptorProto[]|\Google\Protobuf\Internal\RepeatedField $method
     *     @type \MediaCloud\Vendor\Google\Protobuf\Internal\ServiceOptions $options
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>optional string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;
        $this->has_name = true;

        return $this;
    }

    public function hasName()
    {
        return $this->has_name;
    }

    /**
     * Generated from protobuf field <code>repeated .google.protobuf.MethodDescriptorProto method = 2;</code>
     * @return \MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Generated from protobuf field <code>repeated .google.protobuf.MethodDescriptorProto method = 2;</code>
     * @param \MediaCloud\Vendor\Google\Protobuf\Internal\MethodDescriptorProto[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMethod($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \MediaCloud\Vendor\Google\Protobuf\Internal\GPBType::MESSAGE, \MediaCloud\Vendor\Google\Protobuf\Internal\MethodDescriptorProto::class);
        $this->method = $arr;
        $this->has_method = true;

        return $this;
    }

    public function hasMethod()
    {
        return $this->has_method;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.ServiceOptions options = 3;</code>
     * @return \MediaCloud\Vendor\Google\Protobuf\Internal\ServiceOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Generated from protobuf field <code>optional .google.protobuf.ServiceOptions options = 3;</code>
     * @param \MediaCloud\Vendor\Google\Protobuf\Internal\ServiceOptions $var
     * @return $this
     */
    public function setOptions($var)
    {
        GPBUtil::checkMessage($var, \MediaCloud\Vendor\Google\Protobuf\Internal\ServiceOptions::class);
        $this->options = $var;
        $this->has_options = true;

        return $this;
    }

    public function hasOptions()
    {
        return $this->has_options;
    }

}

