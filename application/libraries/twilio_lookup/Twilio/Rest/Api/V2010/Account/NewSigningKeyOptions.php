<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Api\V2010\Account;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class NewSigningKeyOptions {
    /**
     * @param string $friendlyName The friendly_name
     * @return CreateNewSigningKeyOptions Options builder
     */
    public static function create($friendlyName = Values::NONE) {
        return new CreateNewSigningKeyOptions($friendlyName);
    }
}

class CreateNewSigningKeyOptions extends Options {
    /**
     * @param string $friendlyName The friendly_name
     */
    public function __construct($friendlyName = Values::NONE) {
        $this->options['friendlyName'] = $friendlyName;
    }

    /**
     * The friendly_name
     * 
     * @param string $friendlyName The friendly_name
     * @return $this Fluent Builder
     */
    public function setFriendlyName($friendlyName) {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Api.V2010.CreateNewSigningKeyOptions ' . implode(' ', $options) . ']';
    }
}