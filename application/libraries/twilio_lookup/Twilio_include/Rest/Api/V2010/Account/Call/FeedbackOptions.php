<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Call;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class FeedbackOptions {
    /**
     * @param string $issue The issue
     * @return CreateFeedbackOptions Options builder
     */
    public static function create($issue = Values::NONE) {
        return new CreateFeedbackOptions($issue);
    }

    /**
     * @param string $issue Issues experienced during the call
     * @return UpdateFeedbackOptions Options builder
     */
    public static function update($issue = Values::NONE) {
        return new UpdateFeedbackOptions($issue);
    }
}

class CreateFeedbackOptions extends Options {
    /**
     * @param string $issue The issue
     */
    public function __construct($issue = Values::NONE) {
        $this->options['issue'] = $issue;
    }

    /**
     * The issue
     * 
     * @param string $issue The issue
     * @return $this Fluent Builder
     */
    public function setIssue($issue) {
        $this->options['issue'] = $issue;
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

class UpdateFeedbackOptions extends Options {
    /**
     * @param string $issue Issues experienced during the call
     */
    public function __construct($issue = Values::NONE) {
        $this->options['issue'] = $issue;
    }

    /**
     * One or more of the issues experienced during the call
     * 
     * @param string $issue Issues experienced during the call
     * @return $this Fluent Builder
     */
    public function setIssue($issue) {
        $this->options['issue'] = $issue;
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
        return '[Twilio.Api.V2010.UpdateFeedbackOptions ' . implode(' ', $options) . ']';
    }
}