<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Taskrouter\V1\Workspace;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string realtime
 * @property string cumulative
 * @property string accountSid
 * @property string workspaceSid
 */
class WorkspaceStatisticsInstance extends InstanceResource {
    /**
     * Initialize the WorkspaceStatisticsInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $workspaceSid The workspace_sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsInstance 
     */
    public function __construct(Version $version, array $payload, $workspaceSid) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'realtime' => $payload['realtime'],
            'cumulative' => $payload['cumulative'],
            'accountSid' => $payload['account_sid'],
            'workspaceSid' => $payload['workspace_sid'],
        );
        
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsContext Context for this WorkspaceStatisticsInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new WorkspaceStatisticsContext(
                $this->version,
                $this->solution['workspaceSid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a WorkspaceStatisticsInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return WorkspaceStatisticsInstance Fetched WorkspaceStatisticsInstance
     */
    public function fetch($options = array()) {
        return $this->proxy()->fetch(
            $options
        );
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
        return '[Twilio.Taskrouter.V1.WorkspaceStatisticsInstance ' . implode(' ', $context) . ']';
    }
}