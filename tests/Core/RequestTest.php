<?php

namespace AfterShip;

use AfterShip\Core\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage API Key is missing
     */
    public function testInvalidApiKey()
    {
        new Request(null);
    }
}
