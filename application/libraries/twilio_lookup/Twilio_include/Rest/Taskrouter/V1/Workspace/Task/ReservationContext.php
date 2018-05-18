<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Task;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

class ReservationContext extends InstanceContext {
    /**
     * Initialize the ReservationContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @param string $taskSid The task_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Task\ReservationContext 
     */
    public function __construct(Version $version, $workspaceSid, $taskSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'taskSid' => $taskSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Tasks/' . rawurlencode($taskSid) . '/Reservations/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a ReservationInstance
     * 
     * @return ReservationInstance Fetched ReservationInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new ReservationInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['taskSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the ReservationInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return ReservationInstance Updated ReservationInstance
     */
    public function update($options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'ReservationStatus' => $options['reservationStatus'],
            'WorkerActivitySid' => $options['workerActivitySid'],
            'Instruction' => $options['instruction'],
            'DequeuePostWorkActivitySid' => $options['dequeuePostWorkActivitySid'],
            'DequeueFrom' => $options['dequeueFrom'],
            'DequeueRecord' => $options['dequeueRecord'],
            'DequeueTimeout' => $options['dequeueTimeout'],
            'DequeueTo' => $options['dequeueTo'],
            'DequeueStatusCallbackUrl' => $options['dequeueStatusCallbackUrl'],
            'CallFrom' => $options['callFrom'],
            'CallRecord' => $options['callRecord'],
            'CallTimeout' => $options['callTimeout'],
            'CallTo' => $options['callTo'],
            'CallUrl' => $options['callUrl'],
            'CallStatusCallbackUrl' => $options['callStatusCallbackUrl'],
            'CallAccept' => $options['callAccept'],
            'RedirectCallSid' => $options['redirectCallSid'],
            'RedirectAccept' => $options['redirectAccept'],
            'RedirectUrl' => $options['redirectUrl'],
        ));
        
        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new ReservationInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['taskSid'],
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
        return '[Twilio.Taskrouter.V1.ReservationContext ' . implode(' ', $context) . ']';
    }
}