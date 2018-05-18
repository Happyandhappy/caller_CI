<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Message;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class FeedbackOptions {
    /**
     * @param string $outcome The outcome
     * @return CreateFeedbackOptions Options builder
     */
    public static function create($outcome = Values::NONE) {
        return new CreateFeedbackOptions($outcome);
    }
}

class CreateFeedbackOptions extends Options {
    /**
     * @param string $outcome The outcome
     */
    public function __construct($outcome = Values::NONE) {
        $this->options['outcome'] = $outcome;
    }

    /**
     * The outcome
     * 
     * @param string $outcome The outcome
     * @return $this Fluent Builder
     */
    public function setOutcome($outcome) {
        $this->options['outcome'] = $outcome;
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
        return '[Twilio.Api.V2010.CreateFeedbackOptions ' . implode(' ', $options) . ']';
    }
}