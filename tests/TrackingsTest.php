<?php

use AfterShip\Trackings;

class TrackingsTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_could_not_be_instantiated_without_api_keys()
    {
        try {
            new Trackings();
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Aftership\Exception', $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @test */
    public function it_could_be_initialized_with_api_keys()
    {

    }


}
