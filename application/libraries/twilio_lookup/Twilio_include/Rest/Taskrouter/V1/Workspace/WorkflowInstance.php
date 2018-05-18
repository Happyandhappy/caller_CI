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
 * @property string assignmentCallbackUrl
 * @property string configuration
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string documentContentType
 * @property string fallbackAssignmentCallbackUrl
 * @property string friendlyName
 * @property string sid
 * @property string taskReservationTimeout
 * @property string workspaceSid
 */
class WorkflowInstance extends InstanceResource {
    protected $_statistics = null;

    /**
     * Initialize the WorkflowInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $workspaceSid The workspace_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkflowInstance 
     */
    public function __construct(Version $version, array $payload, $workspaceSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'accountSid' => $payload['account_sid'],
            'assignmentCallbackUrl' => $payload['assignment_callback_url'],
            'configuration' => $payload['configuration'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'documentContentType' => $payload['document_content_type'],
            'fallbackAssignmentCallbackUrl' => $payload['fallback_assignment_callback_url'],
            'friendlyName' => $payload['friendly_name'],
            'sid' => $payload['sid'],
            'taskReservationTimeout' => $payload['task_reservation_timeout'],
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
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkflowContext Context for
     *                                                              this
     *                                                              WorkflowInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new WorkflowContext(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a WorkflowInstance
     * 
     * @return WorkflowInstance Fetched WorkflowInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Update the WorkflowInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return WorkflowInstance Updated WorkflowInstance
     */
    public function update($options = array()) {
        return $this->proxy()->update(
            $options
        );
    }

    /**
     * Deletes the WorkflowInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Access the statistics
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsList 
     */
    protected function getStatistics() {
        return $this->proxy()->statistics;
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
        return '[Twilio.Taskrouter.V1.WorkflowInstance ' . implode(' ', $context) . ']';
    }
}