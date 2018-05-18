<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Deserialize;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string accountSid
 * @property string addressRequirements
 * @property string apiVersion
 * @property string beta
 * @property string capabilities
 * @property \DateTime dateCreated
 * @property \DateTime dateUpdated
 * @property string friendlyName
 * @property string phoneNumber
 * @property string sid
 * @property string smsApplicationSid
 * @property string smsFallbackMethod
 * @property string smsFallbackUrl
 * @property string smsMethod
 * @property string smsUrl
 * @property string statusCallback
 * @property string statusCallbackMethod
 * @property string uri
 * @property string voiceApplicationSid
 * @property string voiceCallerIdLookup
 * @property string voiceFallbackMethod
 * @property string voiceFallbackUrl
 * @property string voiceMethod
 * @property string voiceUrl
 */
class LocalInstance extends InstanceResource {
    /**
     * Initialize the LocalInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $ownerAccountSid A 34 character string that uniquely
     *                                identifies this resource.
     * @return \Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\LocalInstance 
     */
    public function __construct(Version $version, array $payload, $ownerAccountSid) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'accountSid' => $payload['account_sid'],
            'addressRequirements' => $payload['address_requirements'],
            'apiVersion' => $payload['api_version'],
            'beta' => $payload['beta'],
            'capabilities' => $payload['capabilities'],
            'dateCreated' => Deserialize::iso8601DateTime($payload['date_created']),
            'dateUpdated' => Deserialize::iso8601DateTime($payload['date_updated']),
            'friendlyName' => $payload['friendly_name'],
            'phoneNumber' => $payload['phone_number'],
            'sid' => $payload['sid'],
            'smsApplicationSid' => $payload['sms_application_sid'],
            'smsFallbackMethod' => $payload['sms_fallback_method'],
            'smsFallbackUrl' => $payload['sms_fallback_url'],
            'smsMethod' => $payload['sms_method'],
            'smsUrl' => $payload['sms_url'],
            'statusCallback' => $payload['status_callback'],
            'statusCallbackMethod' => $payload['status_callback_method'],
            'uri' => $payload['uri'],
            'voiceApplicationSid' => $payload['voice_application_sid'],
            'voiceCallerIdLookup' => $payload['voice_caller_id_lookup'],
            'voiceFallbackMethod' => $payload['voice_fallback_method'],
            'voiceFallbackUrl' => $payload['voice_fallback_url'],
            'voiceMethod' => $payload['voice_method'],
            'voiceUrl' => $payload['voice_url'],
        );
        
        $this->solution = array(
            'ownerAccountSid' => $ownerAccountSid,
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
        return '[Twilio.Api.V2010.LocalInstance]';
    }
}