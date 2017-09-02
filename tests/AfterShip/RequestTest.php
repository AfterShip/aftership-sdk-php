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
    function it_could_handle_json_object_depth_too_large()
    {
        $request = new Request('api_key');
        $json_last_error = $this->getFunctionMock(__NAMESPACE__, 'json_last_error');
        $json_last_error
            ->expects($this->once())
            ->willReturn(JSON_ERROR_DEPTH);
        try {
            $request->safeJsonEncode(['abc' => 'def']);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AftershipException::class, $e);
            $this->assertEquals('Maximum stack depth exceeded', $e->getMessage());
        }
    }

    /** @test */
    function it_could_handle_unknown_json_error()
    {
        $request = new Request('api_key');
        $json_last_error = $this->getFunctionMock(__NAMESPACE__, 'json_last_error');
        $json_last_error
            ->expects($this->once())
            ->willReturn(12);
        try {
            $request->safeJsonEncode(['abc' => 'def']);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AftershipException::class, $e);
            $this->assertEquals('json_encode Error: 12', $e->getMessage());
        }
    }

    /** @test */
    function it_could_handle_non_utf8_in_json_error()
    {
        $request = new Request('api_key');
        $result  = $request->safeJsonEncode(['abc' => iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Ýÿ')]);
        $this->assertEquals($result, '{"abc":"\u00dd\u00ff"}');
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

    /** @test */
    function it_could_handle_error_from_curl()
    {
        $curl_init         = $this->getFunctionMock(__NAMESPACE__, 'curl_init');
        $curl_close        = $this->getFunctionMock(__NAMESPACE__, 'curl_close');
        $curl_exec         = $this->getFunctionMock(__NAMESPACE__, 'curl_exec');
        $curl_setopt_array = $this->getFunctionMock(__NAMESPACE__, 'curl_setopt_array');
        $curl_error        = $this->getFunctionMock(__NAMESPACE__, 'curl_error');
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
        $curl_error->expects($this->once())->willReturn('curl_error');

        try {
            $request->send('post', 'endpoint', ['param1' => 'param1']);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'failed to request: curl_error');
        }
    }

    /** @test */
    function it_could_handle_http_error_code()
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
            ->willReturn(json_encode([
                'meta' => [
                    'code'    => 500,
                    'type'    => 'INTERNAL_ERROR',
                    'message' => 'something goes south with our server'
                ],
                'data' => [
                    'some' => 'data'
                ]
            ]));
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
        $curl_getinfo->expects($this->once())->willReturn([
            'http_code' => 500
        ]);

        try {
            $request->send('post', 'endpoint', ['param1' => 'param1']);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'INTERNAL_ERROR: 500 - something goes south with our server');
            $this->assertEquals($e->getCode(), 500);
        }
    }

    /**
     * @test
     */
    function non_success_http_code_returns_non_json()
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
            ->willReturn('{{}');
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
        $curl_getinfo->expects($this->once())->willReturn([
            'http_code' => 500
        ]);

        try {
            $request->send('post', 'endpoint', ['param1' => 'param1']);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Error processing request - received HTTP error code 500');
            $this->assertEquals($e->getCode(), 500);
        }
    }

}
