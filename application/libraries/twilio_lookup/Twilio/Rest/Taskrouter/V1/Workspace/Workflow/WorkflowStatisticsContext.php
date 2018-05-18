<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

class WorkflowStatisticsContext extends InstanceContext {
    /**
     * Initialize the WorkflowStatisticsContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @param string $workflowSid The workflow_sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Workflow\WorkflowStatisticsContext 
     */
    public function __construct(Version $version, $workspaceSid, $workflowSid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'workflowSid' => $workflowSid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workflows/' . rawurlencode($workflowSid) . '/Statistics';
    }

    /**
     * Fetch a WorkflowStatisticsInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return WorkflowStatisticsInstance Fetched WorkflowStatisticsInstance
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
        
        return new WorkflowStatisticsInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['workflowSid']
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
        return '[Twilio.Taskrouter.V1.WorkflowStatisticsContext ' . implode(' ', $context) . ']';
    }
}