<?php

use AfterShip\AfterShipException;
use AfterShip\LastCheckPoint;
use AfterShip\Requestable;
use PHPUnit\Framework\TestCase;

class LastCheckPointTest extends TestCase
{
    /** @test */
    public function it_could_not_be_instantiated_without_api_keys()
    {
        try {
            new LastCheckPoint();
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @test */
    public function it_throws_error_if_slug_is_empty()
    {
        $this->throwsError('get', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function it_throws_error_if_tracking_number_is_empty()
    {
        $this->throwsError('get', ['slug', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function it_should_get_last_checkpoint_by_slug_and_tracking_number()
    {
        list($request, $lastTrackingNumber) = $this->buildLastCheckPoint();
        $request
            ->with(
                $this->equalTo('last_checkpoint/ups/tracking_number'),
                $this->equalTo('GET')
            );
        $lastTrackingNumber->get('ups', 'tracking_number');
    }

    /** @test */
    public function it_throws_error_if_tracking_id_is_empty()
    {
        $this->throwsError('getById', [''], 'Tracking ID cannot be empty');
    }

    /** @test */
    public function it_should_get_last_checkpoint_by_id()
    {
        list($request, $lastTrackingNumber) = $this->buildLastCheckPoint();
        $request
            ->with(
                $this->equalTo('last_checkpoint/last_checkpoint_id'),
                $this->equalTo('GET')
            );
        $lastTrackingNumber->getById('last_checkpoint_id');
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
    private function buildLastCheckPoint($apiKey = 'test_key')
    {
        $request = $this->buildRequest();
        $lastTrackPoint = new LastCheckPoint($apiKey, $request);

        return [
            $request
                ->expects($this->once())
                ->method('send'),
            $lastTrackPoint
        ];
    }

    private function throwsError($method, $args, $errorMessage)
    {
        $tracking = new LastCheckPoint('test_key');

        try {
            call_user_func_array([$tracking, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }

}
