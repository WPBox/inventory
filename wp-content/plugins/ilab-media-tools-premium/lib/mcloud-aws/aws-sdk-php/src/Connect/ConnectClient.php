<?php

namespace MediaCloud\Vendor\Aws\Connect;
use MediaCloud\Vendor\Aws\AwsClient;

/**
 * This client is used to interact with the **Amazon Connect Service** service.
 * @method \MediaCloud\Vendor\Aws\Result createUser(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise createUserAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result deleteUser(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise deleteUserAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result describeUser(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise describeUserAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result describeUserHierarchyGroup(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise describeUserHierarchyGroupAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result describeUserHierarchyStructure(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise describeUserHierarchyStructureAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result getContactAttributes(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise getContactAttributesAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result getCurrentMetricData(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise getCurrentMetricDataAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result getFederationToken(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise getFederationTokenAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result getMetricData(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise getMetricDataAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listContactFlows(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listContactFlowsAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listHoursOfOperations(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listHoursOfOperationsAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listPhoneNumbers(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listPhoneNumbersAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listQueues(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listQueuesAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listRoutingProfiles(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listRoutingProfilesAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listSecurityProfiles(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listSecurityProfilesAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listTagsForResource(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listUserHierarchyGroups(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listUserHierarchyGroupsAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result listUsers(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise listUsersAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result resumeContactRecording(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise resumeContactRecordingAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result startChatContact(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise startChatContactAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result startContactRecording(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise startContactRecordingAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result startOutboundVoiceContact(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise startOutboundVoiceContactAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result stopContact(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise stopContactAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result stopContactRecording(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise stopContactRecordingAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result suspendContactRecording(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise suspendContactRecordingAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result tagResource(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result untagResource(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateContactAttributes(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateContactAttributesAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateUserHierarchy(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateUserHierarchyAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateUserIdentityInfo(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateUserIdentityInfoAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateUserPhoneConfig(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateUserPhoneConfigAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateUserRoutingProfile(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateUserRoutingProfileAsync(array $args = [])
 * @method \MediaCloud\Vendor\Aws\Result updateUserSecurityProfiles(array $args = [])
 * @method \MediaCloud\Vendor\GuzzleHttp\Promise\Promise updateUserSecurityProfilesAsync(array $args = [])
 */
class ConnectClient extends AwsClient {}
