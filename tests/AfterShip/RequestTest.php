<?php

namespace AfterShip;

use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    use PHPMock;

    /* @test */
    function it_should_have_correct_url_and_api_version_constants()
    {
        $this->equalTo(Request::API_URL, 'https://api.aftership.com');
        $this->equalTo(Request::API_VERSION, 'v4');
    }

    /** @test */
    function it_should_have_made_a_succeed_get_request_with_query_params()
    {
        $curl_init         = $this->getFunctionMock(__NAMESPACE__, 'curl_init');
        $curl_close        = $this->getFunctionMock(__NAMESPACE__, 'curl_close');
        $curl_exec         = $this->getFunctionMock(__NAMESPACE__, 'curl_exec');
        $curl_setopt_array = $this->getFunctionMock(__NAMESPACE__, 'curl_setopt_array');
        $curl_error        = $this->getFunctionMock(__NAMESPACE__, 'curl_error');
        $curl_getinfo      = $this->getFunctionMock(__NAMESPACE__, 'curl_getinfo');
        $request           = new Request('api_key');
        $curl_init
            ->expects($this->once())->willReturn('ch');
        $curl_close
            ->expects($this->once())
            ->with($this->equalTo('ch'));
        $curl_exec
            ->expects($this->once())
            ->willReturn('{}');
        $curl_getinfo
            ->expects($this->once())
            ->with($this->equalTo('ch'))
            ->willReturn(['http_code' => 200]);
        $curl_setopt_array
            ->expects($this->once())
            ->with(
                $this->equalTo('ch'),
                $this->equalTo([
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL            => 'https://api.aftership.com/v4/endpoint?param1=param1',
                    CURLOPT_CUSTOMREQUEST  => 'GET',
                    CURLOPT_HTTPHEADER     => [
                        'aftership-api-key: api_key',
                        'content-type: application/json'
                    ]
                ])
            );
        $curl_close->expects($this->once())->with($this->equalTo('ch'));
        $curl_error->expects($this->once())->willReturn(null);

        $request->send('get', 'endpoint', ['param1' => 'param1']);
    }

    /** @test */
    function it_should_have_made_post_request_with_body()
    {
        $curl_init         = $this->getFunctionMock(__NAMESPACE__, 'curl_init');
        $curl_close        = $this->getFunctionMock(__NAMESPACE__, 'curl_close');
        $curl_exec         = $this->getFunctionMock(__NAMESPACE__, 'curl_exec');
        $curl_setopt_array = $this->getFunctionMock(__NAMESPACE__, 'curl_setopt_array');
        $curl_error        = $this->getFunctionMock(__NAMESPACE__, 'curl_error');
        $curl_getinfo      = $this->getFunctionMock(__NAMESPACE__, 'curl_getinfo');
        $request           = new Request('api_key');
        $curl_init
            ->expects($this->once())
            ->willReturn('ch');
        $curl_close
            ->expects($this->once())
            ->with($this->equalTo('ch'));
        $curl_exec
            ->expects($this->once())
            ->willReturn('{}');
        $curl_getinfo
            ->expects($this->once())
            ->with($this->equalTo('ch'))
            ->willReturn(['http_code' => 200]);
        $curl_setopt_array
            ->expects($this->once())
            ->with(
                $this->equalTo('ch'),
                $this->equalTo([
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_URL            => 'https://api.aftership.com/v4/endpoint',
                    CURLOPT_CUSTOMREQUEST  => 'POST',
                    CURLOPT_HTTPHEADER     => [
                        'aftership-api-key: api_key',
                        'content-type: application/json'
                    ],
                    CURLOPT_POSTFIELDS     => '{"param1":"param1"}'
                ])
            );
        $curl_close->expects($this->once())->with($this->equalTo('ch'));
        $curl_error->expects($this->once())->willReturn(null);

        $request->send('post', 'endpoint', ['param1' => 'param1']);
    }


}
