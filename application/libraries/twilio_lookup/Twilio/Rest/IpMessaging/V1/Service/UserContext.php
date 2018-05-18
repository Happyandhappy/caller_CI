<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\IpMessaging\V1\Service;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceContext;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

class UserContext extends InstanceContext {
    /**
     * Initialize the UserContext
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param string $serviceSid The service_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\IpMessaging\V1\Service\UserContext 
     */
    public function __construct(Version $version, $serviceSid, $sid) {
        parent::__construct($version);
        
        // Path Solution
        $this->solution = array(
            'serviceSid' => $serviceSid,
            'sid' => $sid,
        );
        
        $this->uri = '/Services/' . rawurlencode($serviceSid) . '/Users/' . rawurlencode($sid) . '';
    }

    /**
     * Fetch a UserInstance
     * 
     * @return UserInstance Fetched UserInstance
     */
    public function fetch() {
        $params = Values::of(array());
        
        $payload = $this->version->fetch(
            'GET',
            $this->uri,
            $params
        );
        
        return new UserInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
            $this->solution['sid']
        );
    }

    /**
     * Deletes the UserInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->version->delete('delete', $this->uri);
    }

    /**
     * Update the UserInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return UserInstance Updated UserInstance
     */
    public function update($options = array()) {
        $options = new Values($options);
        
        $data = Values::of(array(
            'RoleSid' => $options['roleSid'],
            'Attributes' => $options['attributes'],
            'FriendlyName' => $options['friendlyName'],
        ));
        
        $payload = $this->version->update(
            'POST',
            $this->uri,
            array(),
            $data
        );
        
        return new UserInstance(
            $this->version,
            $payload,
            $this->solution['serviceSid'],
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
        return '[Twilio.IpMessaging.V1.UserContext ' . implode(' ', $context) . ']';
    }
}