<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Rest/Taskrouter\V1\Workspace\Worker\ReservationList;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Rest/Taskrouter\V1\Workspace\Worker\WorkerChannelList;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Rest/Taskrouter\V1\Workspace\Worker\WorkerStatisticsList;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsList statistics
 * @property \Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationList reservations
 * @property \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelList workerChannels
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsContext statistics()
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationContext reservations(string $sid)
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelContext workerChannels(string $sid)
 */
class WorkerContext extends InstanceContext {
    protected $_statistics = null;
    protected $_reservations = null;
    protected $_workerChannels = null;

    /**
     * Initialize the WorkerContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $workspaceSid The workspace_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\WorkerContext 
     */
    public function __construct(Version $version, $workspaceSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'workspaceSid' => $workspaceSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Workspaces/' . rawurlencode($workspaceSid) . '/Workers/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a WorkerInstance
     * 
     * @return WorkerInstance Fetched WorkerInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new WorkerInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Update the WorkerInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return WorkerInstance Updated WorkerInstance
     */
    public function update($options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'ActivitySid' => $options['activitySid'],
            'Attributes' => $options['attributes'],
            'FriendlyName' => $options['friendlyName'],
        ));
        
        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new WorkerInstance(
            $this->version,
            $payload,
            $this->solution['workspaceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Deletes the WorkerInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->version->delete('delete', $this->uri);
    }

    /**
     * Access the statistics
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerStatisticsList 
     */
    protected function getStatistics() {
        if (!$this->_statistics) {
            $this->_statistics = new WorkerStatisticsList(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->_statistics;
    }

    /**
     * Access the reservations
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Worker\ReservationList 
     */
    protected function getReservations() {
        if (!$this->_reservations) {
            $this->_reservations = new ReservationList(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->_reservations;
    }

    /**
     * Access the workerChannels
     * 
     * @return \Twilio\Rest\Taskrouter\V1\Workspace\Worker\WorkerChannelList 
     */
    protected function getWorkerChannels() {
        if (!$this->_workerChannels) {
            $this->_workerChannels = new WorkerChannelList(
                $this->version,
                $this->solution['workspaceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->_workerChannels;
    }

    /**
     * Magic getter to lazy load subresources
     * 
     * @param string $name Subresource to return
     * @return \Twilio\ListResource The requested subresource
     * @throws \Twilio\Exceptions\TwilioException For unknown subresources
     */
    public function __get($name) {
        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }
        
        throw new TwilioException('Unknown subresource ' . $name);
    }

    /**
     * Magic caller to get resource contexts
     * 
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return \Twilio\InstanceContext The requested resource context
     * @throws \Twilio\Exceptions\TwilioException For unknown resource
     */
    public function __call($name, $arguments) {
        $property = $this->$name;
        if (method_exists($property, 'getContext')) {
            return call_user_func_array(array($property, 'getContext'), $arguments);
        }
        
        throw new TwilioException('Resource does not have a context');
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
        return '[Twilio.Taskrouter.V1.WorkerContext ' . implode(' ', $context) . ']';
    }
}