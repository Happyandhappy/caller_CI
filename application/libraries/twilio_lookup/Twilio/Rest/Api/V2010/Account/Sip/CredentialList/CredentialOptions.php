<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Api\V2010\Account\Sip\CredentialList;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class CredentialOptions {
    /**
     * @param string $password The password
     * @return UpdateCredentialOptions Options builder
     */
    public static function update($password = Values::NONE) {
        return new UpdateCredentialOptions($password);
    }
}

class UpdateCredentialOptions extends Options {
    /**
     * @param string $password The password
     */
    public function __construct($password = Values::NONE) {
        $this->options['password'] = $password;
    }

    /**
     * The password
     * 
     * @param string $password The password
     * @return $this Fluent Builder
     */
    public function setPassword($password) {
        $this->options['password'] = $password;
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
        return '[Twilio.Api.V2010.UpdateCredentialOptions ' . implode(' ', $options) . ']';
    }
}