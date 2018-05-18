<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string accountSid
 * @property string age
 * @property string assignmentStatus
 * @property string attributes
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string priority
 * @property string reason
 * @property string sid
 * @property string taskQueueSid
 * @property string taskChannelSid
 * @property string taskChannelUniqueName
 * @property string timeout
 * @property string workflowSid
 * @property string workspaceSid
 */
class TaskInstance extends InstanceResource {
    protected $_reservations = null;

    /**
     * Initialize the TaskInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $workspaceSid The workspace_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\TaskInstance 
     */
    public function __construct(Version $version, array $payload, $workspaceSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'accountSid' => $payload['account_sid'],
            'age' => $payload['age'],
            'assignmentStatus' => $payload['assignment_status'],
            'attributes' => $payload['attributes'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'priority' => $payload['priority'],
            'reason' => $payload['reason'],
            'sid' => $payload['sid'],
            'taskQueueSid' => $payload['task_queue_sid'],
            'taskChannelSid' => $payload['task_channel_sid'],
            'taskChannelUniqueName' => $payload['task_channel_unique_name'],
            'timeout' => $payload['timeout'],
            'workflowSid' => $payload['workflow_sid'],
            'workspaceSid' => $payload['workspace_sid'],
        );
        
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\TaskContext Context for this
     *                                                          TaskInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new TaskContext(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a TaskInstance
     * 
     * @return TaskInstance Fetched TaskInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Update the TaskInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return TaskInstance Updated TaskInstance
     */
    public function update($options = array()) {
        return $this->proxy()->update(
            $options
        );
    }

    /**
     * Deletes the TaskInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Access the reservations
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Task\ReservationList 
     */
    protected function getReservations() {
        return $this->proxy()->reservations;
    }

    /**
     * Magic getter to access properties
     * 
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }
        
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        
        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Taskrouter.V1.TaskInstance ' . implode(' ', $context) . ']';
    }
}