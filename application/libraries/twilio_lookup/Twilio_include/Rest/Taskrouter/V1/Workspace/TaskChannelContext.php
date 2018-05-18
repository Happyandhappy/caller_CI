<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

class TaskChannelContext extends InstanceContext {
    /**
     * Initialize the TaskChannelContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\TaskChannelContext 
     */
    public function __construct(Version $version, $workspaceSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/TaskChannels/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a TaskChannelInstance
     * 
     * @return TaskChannelInstance Fetched TaskChannelInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new TaskChannelInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['sid']
        );
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
        return '[Twilio.Taskrouter.V1.TaskChannelContext ' . implode(' ', $context) . ']';
    }
}