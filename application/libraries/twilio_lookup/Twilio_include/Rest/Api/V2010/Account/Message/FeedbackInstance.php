<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Message;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string accountSid
 * @property string messageSid
 * @property string outcome
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string uri
 */
class FeedbackInstance extends InstanceResource {
    /**
     * Initialize the FeedbackInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The account_sid
     * @param string $messageSid The message_sid
     * @return \Twilio\Rest\Api\V2010\Account\Message\FeedbackInstance 
     */
    public function __construct(Version $version, array $payload, $accountSid, $messageSid) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'accountSid' => $payload['account_sid'],
            'messageSid' => $payload['message_sid'],
            'outcome' => $payload['outcome'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'uri' => $payload['uri'],
        );
        
        $this->solution = array(
            'accountSid' => $accountSid,
            'messageSid' => $messageSid,
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
        return '[Twilio.Api.V2010.FeedbackInstance]';
    }
}