<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Page;

class WorkflowStatisticsPage extends Page {
    public function __construct($version, $response, $solution) {
        parent::__construct($version, $response);
        
        // Path Solution
        $this->solution = $solution;
    }

    public function buildInstance(array $payload) {
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
        return '[Twilio.Taskrouter.V1.WorkflowStatisticsPage]';
    }
}