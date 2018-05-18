<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Tests\Integration\Api\V2010\Account;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/DeserializeException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Http/Response;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\HolodeckTestCase;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\Request;

class SandboxTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->api->v2010->accounts("ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                     ->sandbox()->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://api.twilio.com/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Sandbox.json'
        ));
    }

    public function testFetchResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "application_sid": "APaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "api_version": "2008-08-01",
                "date_created": "Sun, 15 Mar 2009 02:08:47 +0000",
                "date_updated": "Fri, 18 Feb 2011 17:37:18 +0000",
                "phone_number": "4155992671",
                "pin": "66528411",
                "sms_method": "POST",
                "sms_url": "http://demo.twilio.com/welcome/sms",
                "status_callback": null,
                "status_callback_method": null,
                "uri": "/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Sandbox.json",
                "voice_method": "POST",
                "voice_url": "http://www.digg.com"
            }
            '
        ));
        
        $actual = $this->twilio->api->v2010->accounts("ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                           ->sandbox()->fetch();
        
        $this->assertNotNull($actual);
    }

    public function testUpdateRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->api->v2010->accounts("ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                     ->sandbox()->update();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'post',
            'https://api.twilio.com/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Sandbox.json'
        ));
    }

    public function testUpdateResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "application_sid": "APaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "api_version": "2008-08-01",
                "date_created": "Sun, 15 Mar 2009 02:08:47 +0000",
                "date_updated": "Fri, 18 Feb 2011 17:37:18 +0000",
                "phone_number": "4155992671",
                "pin": "66528411",
                "sms_method": "POST",
                "sms_url": "http://demo.twilio.com/welcome/sms",
                "status_callback": null,
                "status_callback_method": null,
                "uri": "/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Sandbox.json",
                "voice_method": "POST",
                "voice_url": "http://www.digg.com"
            }
            '
        ));
        
        $actual = $this->twilio->api->v2010->accounts("ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                           ->sandbox()->update();
        
        $this->assertNotNull($actual);
    }
}