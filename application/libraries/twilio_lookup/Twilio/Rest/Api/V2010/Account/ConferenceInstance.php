<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Api\V2010\Account;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string accountSid
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string apiVersion
 * @property string friendlyName
 * @property string sid
 * @property string status
 * @property string uri
 */
class ConferenceInstance extends InstanceResource {
    protected $_participants = null;

    /**
     * Initialize the ConferenceInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The unique sid that identifies this account
     * @param string $sid Fetch by unique conference Sid
     * @return \Twilio\Rest\Api\V2010\Account\ConferenceInstance 
     */
    public function __construct(Version $version, array $payload, $accountSid, $sid = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'accountSid' => $payload['account_sid'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'apiVersion' => $payload['api_version'],
            'friendlyName' => $payload['friendly_name'],
            'sid' => $payload['sid'],
            'status' => $payload['status'],
            'uri' => $payload['uri'],
        );
        
        $this->solution = array(
            'accountSid' => $accountSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Api\V2010\Account\ConferenceContext Context for this
     *                                                          ConferenceInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new ConferenceContext(
                $this->version,
                $this->solution['accountSid'],
                $this->solution['sid']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a ConferenceInstance
     * 
     * @return ConferenceInstance Fetched ConferenceInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Access the participants
     * 
     * @return \Twilio\Rest\Api\V2010\Account\Conference\ParticipantList 
     */
    protected function getParticipants() {
        return $this->proxy()->participants;
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
        return '[Twilio.Api.V2010.ConferenceInstance ' . implode(' ', $context) . ']';
    }
}