<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class NotificationOptions {
    /**
     * @param string $log Filter by log level
     * @param string $messageDateBefore Filter by date
     * @param string $messageDate Filter by date
     * @param string $messageDateAfter Filter by date
     * @return ReadNotificationOptions Options builder
     */
    public static function read($log = Values::NONE, $messageDateBefore = Values::NONE, $messageDate = Values::NONE, $messageDateAfter = Values::NONE) {
        return new ReadNotificationOptions($log, $messageDateBefore, $messageDate, $messageDateAfter);
    }
}

class ReadNotificationOptions extends Options {
    /**
     * @param string $log Filter by log level
     * @param string $messageDateBefore Filter by date
     * @param string $messageDate Filter by date
     * @param string $messageDateAfter Filter by date
     */
    public function __construct($log = Values::NONE, $messageDateBefore = Values::NONE, $messageDate = Values::NONE, $messageDateAfter = Values::NONE) {
        $this->options['log'] = $log;
        $this->options['messageDateBefore'] = $messageDateBefore;
        $this->options['messageDate'] = $messageDate;
        $this->options['messageDateAfter'] = $messageDateAfter;
    }

    /**
     * Only show notifications for this log level
     * 
     * @param string $log Filter by log level
     * @return $this Fluent Builder
     */
    public function setLog($log) {
        $this->options['log'] = $log;
        return $this;
    }

    /**
     * Only show notifications for this date. Should be formatted as YYYY-MM-DD. You can also specify inequalities.
     * 
     * @param string $messageDateBefore Filter by date
     * @return $this Fluent Builder
     */
    public function setMessageDateBefore($messageDateBefore) {
        $this->options['messageDateBefore'] = $messageDateBefore;
        return $this;
    }

    /**
     * Only show notifications for this date. Should be formatted as YYYY-MM-DD. You can also specify inequalities.
     * 
     * @param string $messageDate Filter by date
     * @return $this Fluent Builder
     */
    public function setMessageDate($messageDate) {
        $this->options['messageDate'] = $messageDate;
        return $this;
    }

    /**
     * Only show notifications for this date. Should be formatted as YYYY-MM-DD. You can also specify inequalities.
     * 
     * @param string $messageDateAfter Filter by date
     * @return $this Fluent Builder
     */
    public function setMessageDateAfter($messageDateAfter) {
        $this->options['messageDateAfter'] = $messageDateAfter;
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
        return '[Twilio.Api.V2010.ReadNotificationOptions ' . implode(' ', $options) . ']';
    }
}