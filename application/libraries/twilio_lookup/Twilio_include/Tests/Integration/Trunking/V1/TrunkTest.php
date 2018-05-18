<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Trunking\V1;

include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/DeserializeException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Exceptions/TwilioException');
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Http/Response;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\HolodeckTestCase;
include_once(APPPATH.'libraries/twilio_lookup/Twilio/Tests\Request;

class TrunkTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ));
    }

    public function testFetchResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "domain_name": "test.pstn.twilio.com",
                "disaster_recovery_method": "POST",
                "disaster_recovery_url": "http://disaster-recovery.com",
                "friendly_name": "friendly_name",
                "secure": false,
                "recording": {
                    "mode": "do-not-record",
                    "trim": "do-not-trim"
                },
                "auth_type": "",
                "auth_type_set": [],
                "date_created": "2015-01-02T11:23:45Z",
                "date_updated": "2015-01-02T11:23:45Z",
                "url": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "origination_urls": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/OriginationUrls",
                    "credential_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/CredentialLists",
                    "ip_access_control_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IpAccessControlLists",
                    "phone_numbers": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers"
                }
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->fetch();
        
        $this->assertNotNull($actual);
    }

    public function testDeleteRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->delete();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'delete',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ));
    }

    public function testDeleteResponse() {
        $this->holodeck->mock(new Response(
            204,
            null
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->delete();
        
        $this->assertTrue($actual);
    }

    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks->create();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'post',
            'https://trunking.twilio.com/v1/Trunks'
        ));
    }

    public function testCreateResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "sid": "TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "domain_name": "test.pstn.twilio.com",
                "disaster_recovery_method": "POST",
                "disaster_recovery_url": "http://disaster-recovery.com",
                "friendly_name": "friendly_name",
                "secure": false,
                "recording": {
                    "mode": "do-not-record",
                    "trim": "do-not-trim"
                },
                "auth_type": "",
                "auth_type_set": [],
                "date_created": "2015-01-02T11:23:45Z",
                "date_updated": "2015-01-02T11:23:45Z",
                "url": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "origination_urls": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/OriginationUrls",
                    "credential_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/CredentialLists",
                    "ip_access_control_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IpAccessControlLists",
                    "phone_numbers": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers"
                }
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks->create();
        
        $this->assertNotNull($actual);
    }

    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'get',
            'https://trunking.twilio.com/v1/Trunks'
        ));
    }

    public function testReadFullResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://trunking.twilio.com/v1/Trunks?PageSize=1&Page=0",
                    "key": "trunks",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 1,
                    "previous_page_url": null,
                    "url": "https://trunking.twilio.com/v1/Trunks?PageSize=1&Page=0"
                },
                "trunks": [
                    {
                        "sid": "TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "domain_name": "test.pstn.twilio.com",
                        "disaster_recovery_method": "POST",
                        "disaster_recovery_url": "http://disaster-recovery.com",
                        "friendly_name": "friendly_name",
                        "secure": false,
                        "recording": {
                            "mode": "do-not-record",
                            "trim": "do-not-trim"
                        },
                        "auth_type": "",
                        "auth_type_set": [],
                        "date_created": "2015-01-02T11:23:45Z",
                        "date_updated": "2015-01-02T11:23:45Z",
                        "url": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "links": {
                            "origination_urls": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/OriginationUrls",
                            "credential_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/CredentialLists",
                            "ip_access_control_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IpAccessControlLists",
                            "phone_numbers": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers"
                        }
                    }
                ]
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks->read();
        
        $this->assertGreaterThan(0, count($actual));
    }

    public function testReadEmptyResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://trunking.twilio.com/v1/Trunks?PageSize=1&Page=0",
                    "key": "trunks",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 1,
                    "previous_page_url": null,
                    "url": "https://trunking.twilio.com/v1/Trunks?PageSize=1&Page=0"
                },
                "trunks": []
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks->read();
        
        $this->assertNotNull($actual);
    }

    public function testUpdateRequest() {
        $this->holodeck->mock(new Response(500, ''));
        
        try {
            $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->update();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}
        
        $this->assertRequest(new Request(
            'post',
            'https://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ));
    }

    public function testUpdateResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "sid": "TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "domain_name": "test.pstn.twilio.com",
                "disaster_recovery_method": "GET",
                "disaster_recovery_url": "http://updated-recovery.com",
                "friendly_name": "updated_name",
                "secure": true,
                "recording": {
                    "mode": "do-not-record",
                    "trim": "do-not-trim"
                },
                "auth_type": "",
                "auth_type_set": [],
                "date_created": "2015-01-02T11:23:45Z",
                "date_updated": "2015-01-02T11:23:45Z",
                "url": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "links": {
                    "origination_urls": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/OriginationUrls",
                    "credential_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/CredentialLists",
                    "ip_access_control_lists": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/IpAccessControlLists",
                    "phone_numbers": "http://trunking.twilio.com/v1/Trunks/TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/PhoneNumbers"
                }
            }
            '
        ));
        
        $actual = $this->twilio->trunking->v1->trunks("TRaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")->update();
        
        $this->assertNotNull($actual);
    }
}