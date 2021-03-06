<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Pricing\V1\Messaging;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/DeserializeException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Http/Response;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\HolodeckTestCase;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\Request;

class CountryTest extends HolodeckTestCase {
    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->pricing->v1->messaging
                                      ->countries->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://pricing.twilio.com/v1/Messaging/Countries'
        ));
    }

    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->pricing->v1->messaging
                                      ->countries("US")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://pricing.twilio.com/v1/Messaging/Countries/US'
        ));
    }
}