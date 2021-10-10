<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/admin/v1/iam.proto

namespace MediaCloud\Vendor\Google\Iam\Admin\V1;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBType;
use MediaCloud\Vendor\Google\Protobuf\Internal\RepeatedField;
use MediaCloud\Vendor\Google\Protobuf\Internal\GPBUtil;

/**
 * The service account key delete request.
 *
 * Generated from protobuf message <code>google.iam.admin.v1.DeleteServiceAccountKeyRequest</code>
 */
class DeleteServiceAccountKeyRequest extends \MediaCloud\Vendor\Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the service account key in the following format:
     * `projects/{PROJECT_ID}/serviceAccounts/{ACCOUNT}/keys/{key}`.
     * Using `-` as a wildcard for the `PROJECT_ID` will infer the project from
     * the account. The `ACCOUNT` value can be the `email` address or the
     * `unique_id` of the service account.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name of the service account key in the following format:
     *           `projects/{PROJECT_ID}/serviceAccounts/{ACCOUNT}/keys/{key}`.
     *           Using `-` as a wildcard for the `PROJECT_ID` will infer the project from
     *           the account. The `ACCOUNT` value can be the `email` address or the
     *           `unique_id` of the service account.
     * }
     */
    public function __construct($data = NULL) { \MediaCloud\Vendor\GPBMetadata\Google\Iam\Admin\V1\Iam::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the service account key in the following format:
     * `projects/{PROJECT_ID}/serviceAccounts/{ACCOUNT}/keys/{key}`.
     * Using `-` as a wildcard for the `PROJECT_ID` will infer the project from
     * the account. The `ACCOUNT` value can be the `email` address or the
     * `unique_id` of the service account.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the service account key in the following format:
     * `projects/{PROJECT_ID}/serviceAccounts/{ACCOUNT}/keys/{key}`.
     * Using `-` as a wildcard for the `PROJECT_ID` will infer the project from
     * the account. The `ACCOUNT` value can be the `email` address or the
     * `unique_id` of the service account.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

