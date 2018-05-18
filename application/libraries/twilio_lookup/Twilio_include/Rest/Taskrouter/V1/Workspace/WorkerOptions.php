<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Options;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Values;

abstract class WorkerOptions {
    /**
     * @param string $activityName The activity_name
     * @param string $activitySid The activity_sid
     * @param string $available The available
     * @param string $friendlyName The friendly_name
     * @param string $targetWorkersExpression The target_workers_expression
     * @param string $taskQueueName The task_queue_name
     * @param string $taskQueueSid The task_queue_sid
     * @return ReadWorkerOptions Options builder
     */
    public static function read($activityName = Values::NONE, $activitySid = Values::NONE, $available = Values::NONE, $friendlyName = Values::NONE, $targetWorkersExpression = Values::NONE, $taskQueueName = Values::NONE, $taskQueueSid = Values::NONE) {
        return new ReadWorkerOptions($activityName, $activitySid, $available, $friendlyName, $targetWorkersExpression, $taskQueueName, $taskQueueSid);
    }

    /**
     * @param string $activitySid The activity_sid
     * @param string $attributes The attributes
     * @return CreateWorkerOptions Options builder
     */
    public static function create($activitySid = Values::NONE, $attributes = Values::NONE) {
        return new CreateWorkerOptions($activitySid, $attributes);
    }

    /**
     * @param string $activitySid The activity_sid
     * @param string $attributes The attributes
     * @param string $friendlyName The friendly_name
     * @return UpdateWorkerOptions Options builder
     */
    public static function update($activitySid = Values::NONE, $attributes = Values::NONE, $friendlyName = Values::NONE) {
        return new UpdateWorkerOptions($activitySid, $attributes, $friendlyName);
    }
}

class ReadWorkerOptions extends Options {
    /**
     * @param string $activityName The activity_name
     * @param string $activitySid The activity_sid
     * @param string $available The available
     * @param string $friendlyName The friendly_name
     * @param string $targetWorkersExpression The target_workers_expression
     * @param string $taskQueueName The task_queue_name
     * @param string $taskQueueSid The task_queue_sid
     */
    public function __construct($activityName = Values::NONE, $activitySid = Values::NONE, $available = Values::NONE, $friendlyName = Values::NONE, $targetWorkersExpression = Values::NONE, $taskQueueName = Values::NONE, $taskQueueSid = Values::NONE) {
        $this->options['activityName'] = $activityName;
        $this->options['activitySid'] = $activitySid;
        $this->options['available'] = $available;
        $this->options['friendlyName'] = $friendlyName;
        $this->options['targetWorkersExpression'] = $targetWorkersExpression;
        $this->options['taskQueueName'] = $taskQueueName;
        $this->options['taskQueueSid'] = $taskQueueSid;
    }

    /**
     * The activity_name
     * 
     * @param string $activityName The activity_name
     * @return $this Fluent Builder
     */
    public function setActivityName($activityName) {
        $this->options['activityName'] = $activityName;
        return $this;
    }

    /**
     * The activity_sid
     * 
     * @param string $activitySid The activity_sid
     * @return $this Fluent Builder
     */
    public function setActivitySid($activitySid) {
        $this->options['activitySid'] = $activitySid;
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
     * The target_workers_expression
     * 
     * @param string $targetWorkersExpression The target_workers_expression
     * @return $this Fluent Builder
     */
    public function setTargetWorkersExpression($targetWorkersExpression) {
        $this->options['targetWorkersExpression'] = $targetWorkersExpression;
        return $this;
    }

    /**
     * The task_queue_name
     * 
     * @param string $taskQueueName The task_queue_name
     * @return $this Fluent Builder
     */
    public function setTaskQueueName($taskQueueName) {
        $this->options['taskQueueName'] = $taskQueueName;
        return $this;
    }

    /**
     * The task_queue_sid
     * 
     * @param string $taskQueueSid The task_queue_sid
     * @return $this Fluent Builder
     */
    public function setTaskQueueSid($taskQueueSid) {
        $this->options['taskQueueSid'] = $taskQueueSid;
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
        return '[Twilio.Taskrouter.V1.ReadWorkerOptions ' . implode(' ', $options) . ']';
    }
}

class CreateWorkerOptions extends Options {
    /**
     * @param string $activitySid The activity_sid
     * @param string $attributes The attributes
     */
    public function __construct($activitySid = Values::NONE, $attributes = Values::NONE) {
        $this->options['activitySid'] = $activitySid;
        $this->options['attributes'] = $attributes;
    }

    /**
     * The activity_sid
     * 
     * @param string $activitySid The activity_sid
     * @return $this Fluent Builder
     */
    public function setActivitySid($activitySid) {
        $this->options['activitySid'] = $activitySid;
        return $this;
    }

    /**
     * The attributes
     * 
     * @param string $attributes The attributes
     * @return $this Fluent Builder
     */
    public function setAttributes($attributes) {
        $this->options['attributes'] = $attributes;
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
        return '[Twilio.Taskrouter.V1.CreateWorkerOptions ' . implode(' ', $options) . ']';
    }
}

class UpdateWorkerOptions extends Options {
    /**
     * @param string $activitySid The activity_sid
     * @param string $attributes The attributes
     * @param string $friendlyName The friendly_name
     */
    public function __construct($activitySid = Values::NONE, $attributes = Values::NONE, $friendlyName = Values::NONE) {
        $this->options['activitySid'] = $activitySid;
        $this->options['attributes'] = $attributes;
        $this->options['friendlyName'] = $friendlyName;
    }

    /**
     * The activity_sid
     * 
     * @param string $activitySid The activity_sid
     * @return $this Fluent Builder
     */
    public function setActivitySid($activitySid) {
        $this->options['activitySid'] = $activitySid;
        return $this;
    }

    /**
     * The attributes
     * 
     * @param string $attributes The attributes
     * @return $this Fluent Builder
     */
    public function setAttributes($attributes) {
        $this->options['attributes'] = $attributes;
        return $this;
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
        return '[Twilio.Taskrouter.V1.UpdateWorkerOptions ' . implode(' ', $options) . ']';
    }
}