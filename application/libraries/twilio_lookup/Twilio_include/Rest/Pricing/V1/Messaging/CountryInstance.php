<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Pricing\V1\Messaging;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/InstanceResource;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Version;

/**
 * @property string country
 * @property string isoCountry
 * @property string outboundSmsPrices
 * @property string inboundSmsPrices
 * @property string priceUnit
 * @property string url
 */
class CountryInstance extends InstanceResource {
    /**
     * Initialize the CountryInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $isoCountry The iso_country
     * @return \Twilio\Rest\Pricing\V1\Messaging\CountryInstance 
     */
    public function __construct(Version $version, array $payload, $isoCountry = null) {
        parent::__construct($version);
        
        // Marshaled Properties
        $this->properties = array(
            'country' => $payload['country'],
            'isoCountry' => $payload['iso_country'],
            'url' => $payload['url'],
            'outboundSmsPrices' => array_key_exists('outbound_sms_prices', $payload) ? $payload['outbound_sms_prices'] : null,
            'inboundSmsPrices' => array_key_exists('inbound_sms_prices', $payload) ? $payload['inbound_sms_prices'] : null,
            'priceUnit' => array_key_exists('price_unit', $payload) ? $payload['price_unit'] : null,
        );
        
        $this->solution = array(
            'isoCountry' => $isoCountry ?: $this->properties['isoCountry'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Pricing\V1\Messaging\CountryContext Context for this
     *                                                          CountryInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new CountryContext(
                $this->version,
                $this->solution['isoCountry']
            );
        }
        
        return $this->context;
    }

    /**
     * Fetch a CountryInstance
     * 
     * @return CountryInstance Fetched CountryInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
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
        return '[Twilio.Pricing.V1.CountryInstance ' . implode(' ', $context) . ']';
    }
}