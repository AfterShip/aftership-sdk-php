<?php

use AfterShip\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /* @test */
    function it_should_have_correct_url_and_api_version_constants()
    {
        $this->equalTo(Request::API_URL, 'https://api.aftership.com');
        $this->equalTo(Request::API_VERSION, 'v4');
    }
}
