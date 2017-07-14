<?php

use AfterShip\AfterShipException;
use AfterShip\Couriers;
use AfterShip\Requestable;
use PHPUnit\Framework\TestCase;

class CouriersTest extends TestCase
{
    /** @test */
    public function it_could_not_be_instantiated_without_api_keys()
    {
        try {
            new Couriers();
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @test */
    public function it_gets_all_couriers_when_calling_get()
    {
        list($request, $couriers) = $this->buildCouriers();

        $request
            ->with(
                $this->equalTo('couriers'),
                $this->equalTo('GET')
            );

        $couriers->get();
    }

    /** @test */
    public function it_will_get_all_couriers_available()
    {
        list($request, $couriers) = $this->buildCouriers();

        $request
            ->with(
                $this->equalTo('couriers/all'),
                $this->equalTo('GET')
            );

        $couriers->all();
    }

    /** @test */
    public function it_will_throw_error_if_no_tracking_number_to_detect()
    {
        $this->throwsError('detect', [''], 'Tracking number cannot be empty');

    }

    /** @test */
    public function it_will_call_detect_endpoint()
    {
        list($request, $couriers) = $this->buildCouriers();

        $request
            ->with(
                $this->equalTo('couriers/detect/'),
                $this->equalTo('POST'),
                $this->equalTo([
                    'tracking' => [
                        'tracking_number' => 'tracking_number',
                    ]
                ])
            );

        $couriers->detect('tracking_number');
    }

    private function buildRequest()
    {
        return $this
            ->getMockBuilder(Requestable::class)
            ->setMethods(['send'])
            ->getMock();
    }

    /**
     * @param string $apiKey
     * @return array
     */
    private function buildCouriers($apiKey = 'test_key')
    {
        $request = $this->buildRequest();
        $tracking = new Couriers($apiKey, $request);

        return [
            $request
                ->expects($this->once())
                ->method('send'),
            $tracking
        ];
    }

    private function throwsError($method, $args, $errorMessage)
    {
        $tracking = new Couriers('test_key');

        try {
            call_user_func_array([$tracking, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }
}
