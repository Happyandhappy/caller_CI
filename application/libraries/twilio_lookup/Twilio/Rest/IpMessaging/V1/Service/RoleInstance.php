<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\IpMessaging\V1\Service;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string sid
 * @property string accountSid
 * @property string serviceSid
 * @property string friendlyName
 * @property string type
 * @property string permissions
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string url
 */
class RoleInstance extends InstanceResource {
    /**
     * Initialize the RoleInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $serviceSid The service_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\IpMessaging\V1\Service\RoleInstance 
     */
    public function __construct(Version $version, array $payload, $serviceSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'sid' => $payload['sid'],
            'accountSid' => $payload['account_sid'],
            'serviceSid' => $payload['service_sid'],
            'friendlyName' => $payload['friendly_name'],
            'type' => $payload['type'],
            'permissions' => $payload['permissions'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'url' => $payload['url'],
        );
        
        $this->solution = array(
            'serviceSid' => $serviceSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\IpMessaging\V1\Service\RoleContext Context for this
     *                                                         RoleInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new RoleContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a RoleInstance
     * 
     * @return RoleInstance Fetched RoleInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the RoleInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Update the RoleInstance
     * 
     * @param string $permission The permission
     * @return RoleInstance Updated RoleInstance
     */
    public function update($permission) {
        return $this->proxy()->update(
            $permission
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
        return '[Twilio.IpMessaging.V1.RoleInstance ' . implode(' ', $context) . ']';
    }
}