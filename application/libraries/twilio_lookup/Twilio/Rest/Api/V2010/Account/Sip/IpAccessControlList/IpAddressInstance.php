<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string sid
 * @property string accountSid
 * @property string friendlyName
 * @property string ipAddress
 * @property string ipAccessControlListSid
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string uri
 */
class IpAddressInstance extends InstanceResource {
    /**
     * Initialize the IpAddressInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The account_sid
     * @param string $ipAccessControlListSid The ip_access_control_list_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList\IpAddressInstance 
     */
    public function __construct(Version $version, array $payload, $accountSid, $ipAccessControlListSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'sid' => $payload['sid'],
            'accountSid' => $payload['account_sid'],
            'friendlyName' => $payload['friendly_name'],
            'ipAddress' => $payload['ip_address'],
            'ipAccessControlListSid' => $payload['ip_access_control_list_sid'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'uri' => $payload['uri'],
        );
        
        $this->solution = array(
            'accountSid' => $accountSid,
            'ipAccessControlListSid' => $ipAccessControlListSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlList\IpAddressContext Context for this
     *                                                                                 IpAddressInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new IpAddressContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['ipAccessControlListSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a IpAddressInstance
     * 
     * @return IpAddressInstance Fetched IpAddressInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Update the IpAddressInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return IpAddressInstance Updated IpAddressInstance
     */
    public function update($options = array()) {
        return $this->proxy()->update(
            $options
        );
    }

    /**
     * Deletes the IpAddressInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
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
        return '[Twilio.Api.V2010.IpAddressInstance ' . implode(' ', $context) . ']';
    }
}