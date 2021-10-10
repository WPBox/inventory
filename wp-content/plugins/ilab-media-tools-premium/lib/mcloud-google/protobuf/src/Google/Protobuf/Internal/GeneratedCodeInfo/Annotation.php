<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/protobuf/descriptor.proto

namespace MediaCloud\Vendor\Google\Protobuf\Internal\GeneratedCodeInfo;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBWire;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\InputStream;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>google.protobuf.GeneratedCodeInfo.Annotation</code>
 */
class Annotation extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * Identifies the element in the original source .proto file. This field
     * is formatted the same as SourceCodeInfo.Location.path.
     *
     * Generated from protobuf field <code>repeated int32 path = 1 [packed = true];</code>
     */
    private $path;
    private $has_path = false;
    /**
     * Identifies the filesystem path to the original source .proto.
     *
     * Generated from protobuf field <code>optional string source_file = 2;</code>
     */
    protected $source_file = '';
    private $has_source_file = false;
    /**
     * Identifies the starting offset in bytes in the generated code
     * that relates to the identified object.
     *
     * Generated from protobuf field <code>optional int32 begin = 3;</code>
     */
    protected $begin = 0;
    private $has_begin = false;
    /**
     * Identifies the ending offset in bytes in the generated code that
     * relates to the identified offset. The end offset should be one past
     * the last relevant byte (so the length of the text = end - begin).
     *
     * Generated from protobuf field <code>optional int32 end = 4;</code>
     */
    protected $end = 0;
    private $has_end = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int[]|\Google\Protobuf\Internal\RepeatedField $path
     *           Identifies the element in the original source .proto file. This field
     *           is formatted the same as SourceCodeInfo.Location.path.
     *     @type string $source_file
     *           Identifies the filesystem path to the original source .proto.
     *     @type int $begin
     *           Identifies the starting offset in bytes in the generated code
     *           that relates to the identified object.
     *     @type int $end
     *           Identifies the ending offset in bytes in the generated code that
     *           relates to the identified offset. The end offset should be one past
     *           the last relevant byte (so the length of the text = end - begin).
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifies the element in the original source .proto file. This field
     * is formatted the same as SourceCodeInfo.Location.path.
     *
     * Generated from protobuf field <code>repeated int32 path = 1 [packed = true];</code>
     * @return \MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Identifies the element in the original source .proto file. This field
     * is formatted the same as SourceCodeInfo.Location.path.
     *
     * Generated from protobuf field <code>repeated int32 path = 1 [packed = true];</code>
     * @param int[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPath($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \MediaCloud\Vendor\Google\Protobuf\Internal\GPBType::INT32);
        $this->path = $arr;
        $this->has_path = true;

        return $this;
    }

    public function hasPath()
    {
        return $this->has_path;
    }

    /**
     * Identifies the filesystem path to the original source .proto.
     *
     * Generated from protobuf field <code>optional string source_file = 2;</code>
     * @return string
     */
    public function getSourceFile()
    {
        return $this->source_file;
    }

    /**
     * Identifies the filesystem path to the original source .proto.
     *
     * Generated from protobuf field <code>optional string source_file = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSourceFile($var)
    {
        GPBUtil::checkString($var, True);
        $this->source_file = $var;
        $this->has_source_file = true;

        return $this;
    }

    public function hasSourceFile()
    {
        return $this->has_source_file;
    }

    /**
     * Identifies the starting offset in bytes in the generated code
     * that relates to the identified object.
     *
     * Generated from protobuf field <code>optional int32 begin = 3;</code>
     * @return int
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Identifies the starting offset in bytes in the generated code
     * that relates to the identified object.
     *
     * Generated from protobuf field <code>optional int32 begin = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setBegin($var)
    {
        GPBUtil::checkInt32($var);
        $this->begin = $var;
        $this->has_begin = true;

        return $this;
    }

    public function hasBegin()
    {
        return $this->has_begin;
    }

    /**
     * Identifies the ending offset in bytes in the generated code that
     * relates to the identified offset. The end offset should be one past
     * the last relevant byte (so the length of the text = end - begin).
     *
     * Generated from protobuf field <code>optional int32 end = 4;</code>
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Identifies the ending offset in bytes in the generated code that
     * relates to the identified offset. The end offset should be one past
     * the last relevant byte (so the length of the text = end - begin).
     *
     * Generated from protobuf field <code>optional int32 end = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setEnd($var)
    {
        GPBUtil::checkInt32($var);
        $this->end = $var;
        $this->has_end = true;

        return $this;
    }

    public function hasEnd()
    {
        return $this->has_end;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Annotation::class, \MediaCloud\Vendor\Google\Protobuf\Internal\GeneratedCodeInfo_Annotation::class);

