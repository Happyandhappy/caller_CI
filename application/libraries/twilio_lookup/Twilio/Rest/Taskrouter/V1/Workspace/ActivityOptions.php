<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Rest\Taskrouter\V1\Workspace;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class ActivityOptions {
    /**
     * @param string $friendlyName The friendly_name
     * @param string $available The available
     * @return ReadActivityOptions Options builder
     */
    public static function read($friendlyName = Values::NONE, $available = Values::NONE) {
        return new ReadActivityOptions($friendlyName, $available);
    }
}

class ReadActivityOptions extends Options {
    /**
     * @param string $friendlyName The friendly_name
     * @param string $available The available
     */
    public function __construct($friendlyName = Values::NONE, $available = Values::NONE) {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['available'] = $available;
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
     * The available
     * 
     * @param string $available The available
     * @return $this Fluent Builder
     */
    public function setAvailable($available) {
        $this->options['available'] = $available;
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
        return '[Twilio.Taskrouter.V1.ReadActivityOptions ' . implode(' ', $options) . ']';
    }
}