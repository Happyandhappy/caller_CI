<?php

//namespace Twilio\Tests;

//include_once(APPPATH.'libraries/twilio_lookup/\PHPUnit_Framework_TestCase;
//include_once(APPPATH.'libraries/twilio_lookup/Twilio/Rest/Client;


class HolodeckTestCase extends PHPUnit_Framework_TestCase
{
    /** @var Holodeck $holodeck */
    protected $holodeck = null;
    /** @var Client $twilio */
    protected $twilio = null;

    protected function setUp() {
        $this->holodeck = new Holodeck();
        $this->twilio = new Client('ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'AUTHTOKEN', null, null, $this->holodeck);
    }

    protected function tearDown() {
        $this->twilio = null;
        $this->holodeck = null;
    }

    public function assertRequest($request) {
        $this->holodeck->assertRequest($request);
        $this->assertTrue(true);
    }
}