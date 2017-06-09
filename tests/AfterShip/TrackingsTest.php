<?php

namespace AfterShip;

use PHPUnit\Framework\TestCase;

class TrackingsTest extends TestCase
{

    /** @test */
    public function it_could_not_be_instantiated_without_api_keys()
    {
        try {
            new Trackings();
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'API Key is missing');
        }
    }

    /** @test */
    public function tracking_number_cant_be_empty()
    {
        $this->throwsError('create', [''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function it_could_send_tracking_object_to_api_when_creating_tracking()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings'),
                $this->equalTo('POST'),
                $this->equalTo([
                    'tracking' => [
                        'tracking_number' => 'tracking_number'
                    ]
                ])
            );

        $tracking->create('tracking_number');
    }

    /** @test */
    public function it_could_send_all_other_parameters_into_tracking_object_when_create_tracking()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings'),
                $this->equalTo('POST'),
                $this->equalTo([
                    'tracking' => [
                        'tracking_number' => 'tracking_number',
                        'slug'            => ['dhl', 'dpd-uk']
                    ]
                ])
            );

        $tracking->create('tracking_number', ['slug' => ['dhl', 'dpd-uk']]);
    }

    /** @test */
    public function it_will_not_succeed_with_empty_slug_when_deleting()
    {
        $this->throwsError('delete', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function it_will_throw_exception_when_tracking_number_is_empty()
    {
        $this->throwsError('delete', ['dhl', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function it_will_call_delete_trackings_slug_tracing_number_when_successfully_deleted()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings/dhl/tracking_number'),
                $this->equalTo('DELETE')
            );

        $tracking->delete('dhl', 'tracking_number');
    }

    /** @test */
    public function delete_will_fail_when_empty_id_provided()
    {
        $request = $this->buildRequest();
        $tracking = new Trackings('test_api_key', $request);

        try {
            $tracking->deleteById('');
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking ID cannot be empty');
        }
    }

    /** @test */
    public function it_could_delete_by_id()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings/tracking_id'),
                $this->equalTo('DELETE')
            );

        $tracking->deleteById('tracking_id');
    }

    /** @test */
    public function it_could_get_all_trackings()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings'),
                $this->equalTo('GET'),
                $this->equalTo([])
            );

        $tracking->all();
    }

    /** @test */
    public function it_throw_error_when_seeing_empty_slug_when_get()
    {
        $this->throwsError('get', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function it_throw_error_when_seeing_empty_tracking_number_when_get()
    {
        $this->throwsError('get', ['dhl', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function it_could_get_tracking_by_slug_and_tracking_number()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings/dhl/tracking_number'),
                $this->equalTo('GET'),
                $this->equalTo([])
            );

        $tracking->get('dhl', 'tracking_number');
    }

    /** @test */
    public function it_throws_error_when_get_by_empty_id()
    {
        $this->throwsError('getById', [''], 'Tracking ID cannot be empty');
    }

    /** @test */
    public function it_could_get_by_id()
    {
        list($request, $tracking) = $this->buildTracking();

        $request
            ->with(
                $this->equalTo('trackings/tracking_id'),
                $this->equalTo('GET'),
                $this->equalTo([])
            );

        $tracking->getById('tracking_id');
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
    private function buildTracking($apiKey = 'test_key')
    {
        $request = $this->buildRequest();
        $tracking = new Trackings($apiKey, $request);

        return [
            $request
                ->expects($this->once())
                ->method('send'),
            $tracking
        ];
    }

    private function throwsError($method, $args, $errorMessage)
    {
        $tracking = new Trackings('test_key');

        try {
            call_user_func_array([$tracking, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }
}
