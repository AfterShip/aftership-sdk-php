<?php

namespace AfterShip;

use PHPUnit\Framework\TestCase;

class NotificationsTest extends TestCase
{
    /** @test */
    public function it_should_throw_an_error_if_no_api_key_pass_in_for_constructor()
    {
        try {
            new Notifications('');
        } catch (AftershipException $e) {
            $this->assertEquals($e->getMessage(), 'API Key is missing');
            $this->assertInstanceOf(AfterShipException::class, $e);
        }
    }

    /** @test */
    public function it_should_create_a_notfication()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('notifications/dhl/tracking_number/add'),
                $this->equalTo([
                    'notification' => []
                ])
            );

        $notification->create('dhl', 'tracking_number');
    }

    /** @test */
    public function create_throws_an_error_when_empty_slug()
    {
        $this->throwsError('create', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function create_throws_an_error_when_empty_tracking_number()
    {
        $this->throwsError('create', ['dhl', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function could_create_notification_by_id()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('notifications/tracking_id/add'),
                $this->equalTo([
                    'notification' => []
                ])
            );

        $notification->createById('tracking_id');
    }

    /** @test */
    public function create_by_id_throws_error_when_empty_id_passed_in()
    {
        $this->throwsError('createById', [''], 'Tracking ID cannot be empty');
    }

    /** @test */
    public function it_should_delete_a_notfication()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('notifications/dhl/tracking_number/remove'),
                $this->equalTo([
                    'notification' => []
                ])
            );

        $notification->delete('dhl', 'tracking_number');
    }

    /** @test */
    public function delete_throws_an_error_when_empty_slug()
    {
        $this->throwsError('delete', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function delete_throws_an_error_when_empty_tracking_number()
    {
        $this->throwsError('delete', ['dhl', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function could_delete_notification_by_id()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('notifications/tracking_id/remove'),
                $this->equalTo([
                    'notification' => []
                ])
            );

        $notification->deleteById('tracking_id');
    }

    /** @test */
    public function delete_by_id_throws_error_when_empty_id_passed_in()
    {
        $this->throwsError('deleteById', [''], 'Tracking ID cannot be empty');
    }

    /** @test */
    public function it_should_get_a_notfication()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('notifications/dhl/tracking_number')
            );

        $notification->get('dhl', 'tracking_number');
    }

    /** @test */
    public function get_throws_an_error_when_empty_slug()
    {
        $this->throwsError('get', ['', 'tracking_number'], 'Slug cannot be empty');
    }

    /** @test */
    public function get_throws_an_error_when_empty_tracking_number()
    {
        $this->throwsError('get', ['dhl', ''], 'Tracking number cannot be empty');
    }

    /** @test */
    public function could_get_notification_by_id()
    {
        list($request, $notification) = $this->buildNotification();

        $request
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('notifications/tracking_id')
            );

        $notification->getById('tracking_id');
    }

    /** @test */
    public function get_by_id_throws_error_when_empty_id_passed_in()
    {
        $this->throwsError('getById', [''], 'Tracking ID cannot be empty');
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
    private function buildNotification($apiKey = 'test_key')
    {
        $request = $this->buildRequest();
        $notification = new Notifications($apiKey, $request);

        return [
            $request
                ->expects($this->once())
                ->method('send'),
            $notification
        ];
    }

    private function throwsError($method, $args, $errorMessage)
    {
        $tracking = new Notifications('test_key');

        try {
            call_user_func_array([$tracking, $method], $args);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), $errorMessage);
        }
    }
}
