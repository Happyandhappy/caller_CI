<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

//namespace Twilio\Tests\Integration\Trunking\V1\Trunk;

//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/DeserializeException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException.php');
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Http/Response;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\HolodeckTestCase;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\Request;

class PhoneNumberTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                       ->phoneNumbers("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ));
    }

    public function testFetchResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "date_created": "2010-12-10T17:27:34Z",
                "date_updated": "2015-10-09T11:36:32Z",
                "friendly_name": "(415) 867-5309",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "phone_number": "+14158675309",
                "api_version": "2010-04-01",
                "voice_caller_id_lookup": null,
                "voice_url": "",
                "voice_method": "POST",
                "voice_fallback_url": null,
                "voice_fallback_method": null,
                "status_callback": "",
                "status_callback_method": "POST",
                "voice_application_sid": null,
                "trunk_sid": "TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "sms_url": "",
                "sms_method": "POST",
                "sms_fallback_url": "",
                "sms_fallback_method": "POST",
                "sms_application_sid": "",
                "address_requirements": "none",
                "beta": false,
                "url": "https://trunking.twilio.com/v1/Trunks/TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "capabilities": {
                    "voice": true,
                    "sms": true,
                    "mms": true
                },
                "links": {
                    "phone_number": "https://api.twilio.com/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IncomingPhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.json"
                }
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                             ->phoneNumbers("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->fetch();
        
        $this->assertNotNull($actual);
    }

    public function testDeleteRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                       ->phoneNumbers("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->delete();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'delete',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ));
    }

    public function testDeleteResponse() {
        $this->holodeck->mock(new Response(
            204,
            null
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                             ->phoneNumbers("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->delete();
        
        $this->assertTrue($actual);
    }

    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                       ->phoneNumbers->create("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $values = array(
            'PhoneNumberSid' => "PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
        );
        
        $this->assertRequest(new Request(
            'post',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers',
            null,
            $values
        ));
    }

    public function testCreateResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "sid": "PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "date_created": "2010-12-10T17:27:34Z",
                "date_updated": "2015-10-09T11:36:32Z",
                "friendly_name": "(415) 867-5309",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "phone_number": "+14158675309",
                "api_version": "2010-04-01",
                "voice_caller_id_lookup": null,
                "voice_url": "",
                "voice_method": "POST",
                "voice_fallback_url": null,
                "voice_fallback_method": null,
                "status_callback": "",
                "status_callback_method": "POST",
                "voice_application_sid": null,
                "trunk_sid": "TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "sms_url": "",
                "sms_method": "POST",
                "sms_fallback_url": "",
                "sms_fallback_method": "POST",
                "sms_application_sid": "",
                "address_requirements": "none",
                "beta": false,
                "url": "https://trunking.twilio.com/v1/Trunks/TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "capabilities": {
                    "voice": true,
                    "sms": true,
                    "mms": true
                },
                "links": {
                    "phone_number": "https://api.twilio.com/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IncomingPhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.json"
                }
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                             ->phoneNumbers->create("PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
        
        $this->assertNotNull($actual);
    }

    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                       ->phoneNumbers->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers'
        ));
    }

    public function testReadFullResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers?PageSize=1&Page=0",
                    "key": "phone_numbers",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 1,
                    "previous_page_url": null,
                    "url": "https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers?PageSize=1&Page=0"
                },
                "phone_numbers": [
                    {
                        "sid": "PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "date_created": "2010-12-10T17:27:34Z",
                        "date_updated": "2015-10-09T11:36:32Z",
                        "friendly_name": "(415) 867-5309",
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "phone_number": "+14158675309",
                        "api_version": "2010-04-01",
                        "voice_caller_id_lookup": null,
                        "voice_url": "",
                        "voice_method": "POST",
                        "voice_fallback_url": null,
                        "voice_fallback_method": null,
                        "status_callback": "",
                        "status_callback_method": "POST",
                        "voice_application_sid": null,
                        "trunk_sid": "TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "sms_url": "",
                        "sms_method": "POST",
                        "sms_fallback_url": "",
                        "sms_fallback_method": "POST",
                        "sms_application_sid": "",
                        "address_requirements": "none",
                        "beta": false,
                        "url": "https://trunking.twilio.com/v1/Trunks/TKaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "capabilities": {
                            "voice": true,
                            "sms": true,
                            "mms": true
                        },
                        "links": {
                            "phone_number": "https://api.twilio.com/2010-04-01/Accounts/ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IncomingPhoneNumbers/PNaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.json"
                        }
                    }
                ]
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                             ->phoneNumbers->read();
        
        $this->assertGreaterThan(0, count($actual));
    }

    public function testReadEmptyResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers?PageSize=1&Page=0",
                    "key": "phone_numbers",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 1,
                    "previous_page_url": null,
                    "url": "https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers?PageSize=1&Page=0"
                },
                "phone_numbers": []
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                                             ->phoneNumbers->read();
        
        $this->assertNotNull($actual);
    }
}