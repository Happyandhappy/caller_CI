<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Taskrouter\V1\Workspace;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

class WorkspaceStatisticsContext extends InstanceContext {
    /**
     * Initialize the WorkspaceStatisticsContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkspaceStatisticsContext 
     */
    public function __construct(Version $version, $workspaceSid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Statistics';
    }

    /**
     * Fetch a WorkspaceStatisticsInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return WorkspaceStatisticsInstance Fetched WorkspaceStatisticsInstance
     */
    public function fetch($options = array()) {
        $options = new Values($options);
        
        $params = Values::of(array(
            'Minutes' => $options['minutes'],
            'StartDate' => $options['startDate'],
            'EndDate' => $options['endDate'],
        ));
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new WorkspaceStatisticsInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid']
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
        return '[Twilio.Taskrouter.V1.WorkspaceStatisticsContext ' . implode(' ', $context) . ']';
    }
}