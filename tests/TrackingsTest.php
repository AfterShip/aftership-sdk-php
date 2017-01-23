<?php

use AfterShip\Trackings;
use AfterShip\Exception;

class TrackingsTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_could_not_be_instantiated_without_api_keys()
    {
        try {
            $trackings = new Trackings();
        } catch (\Exception $e) {
            $this->assertInstanceOf(Exception::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

}
