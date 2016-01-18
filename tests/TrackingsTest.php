<?php

namespace AfterShip;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class TrackingsTest extends \PHPUnit_Framework_TestCase
{
    public function getTrackings($responseJson)
    {
        $trackings = new Trackings('api-key');

        $mock = new MockHandler(
            [
                new Response(200, ['Content-Encoding' => 'gzip', 'Content-Type' => 'application/json'], $responseJson),
                new Response(202, ['Content-Length' => 0]),
                new RequestException("Error Communicating with Server", new Request('GET', 'test'))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);

        $trackings->setClient($client);

        return $trackings;
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking number cannot be empty
     */
    public function testInvalidTrackingNumberCreate()
    {
        $this->getTrackings('')->create('');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testCreate($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->create('tracking - number', ['foo' => 'bar']);

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking number cannot be empty
     */
    public function testInvalidTrackingNumberDelete()
    {
        $this->getTrackings('')->delete('slug', '');
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Slug cannot be empty
     */
    public function testInvalidSlugDelete()
    {
        $this->getTrackings('')->delete('', '');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testDelete($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->delete('slug', 'tracking - number');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking ID cannot be empty
     */
    public function testInvalidTrackingNumberDeleteById()
    {
        $this->getTrackings('')->deleteById('');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testDeleteById($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->deleteById('tracking - id');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testGetAll($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->getAll();

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking number cannot be empty
     */
    public function testInvalidTrackingNumberGet()
    {
        $this->getTrackings('')->get('slug', '');
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Slug cannot be empty
     */
    public function testInvalidSlugGet()
    {
        $this->getTrackings('')->get('', '');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testGet($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->get('slug', 'tracking - number');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking ID cannot be empty
     */
    public function testInvalidTrackingNumberGetById()
    {
        $this->getTrackings('')->getById('');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testGetById($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->getById('tracking - id');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking number cannot be empty
     */
    public function testInvalidTrackingNumberUpdate()
    {
        $this->getTrackings('')->update('slug', '');
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Slug cannot be empty
     */
    public function testInvalidSlugUpdate()
    {
        $this->getTrackings('')->update('', '');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testUpdate($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->update('slug', 'tracking - number');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking ID cannot be empty
     */
    public function testInvalidTrackingNumberUpdateById()
    {
        $this->getTrackings('')->updateById('');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testUpdateById($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->updateById('tracking - id');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking number cannot be empty
     */
    public function testInvalidTrackingNumberReTrack()
    {
        $this->getTrackings('')->reTrack('slug', '');
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Slug cannot be empty
     */
    public function testInvalidSlugReTrack()
    {
        $this->getTrackings('')->reTrack('', '');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testReTrack($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->reTrack('slug', 'tracking - number');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    /**
     * @expectedException \AfterShip\Exception\AfterShipException
     * @expectedExceptionMessage Tracking ID cannot be empty
     */
    public function testInvalidTrackingNumberReTrackById()
    {
        $this->getTrackings('')->reTrackById('');
    }

    /**
     * @param $responseJson
     * @param $result
     *
     * @dataProvider requestProvider
     */
    public function testReTrackById($responseJson, $result)
    {
        $response = $this->getTrackings($responseJson)->reTrackById('tracking - id');

        static::assertEquals(json_decode(json_encode($result)), $response);
    }

    public function requestProvider()
    {
        return [
            [
                'responseJson' => '{
                    "meta": {
                        "code": 201
                    },
                    "data": {
                        "tracking": {
                            "id": "53aa7b5c415a670000000021",
                            "created_at": "2014-06-25T07:33:48+00:00",
                            "updated_at": "2014-06-25T07:33:48+00:00",
                            "tracking_number": "123456789",
                            "tracking_account_number": null,
                            "tracking_postal_code": null,
                            "tracking_ship_date": null,
                            "slug": "dhl",
                            "active": true,
                            "custom_fields": {
                                "product_price": "USD19.99",
                                "product_name": "iPhone Case"
                            },
                            "customer_name": null,
                            "destination_country_iso3": null,
                            "emails": [
                                "email@yourdomain.com",
                                "another_email@yourdomain.com"
                            ],
                            "expected_delivery": null,
                            "note": null,
                            "order_id": "ID 1234",
                            "order_id_path": "http://www.aftership.com/order_id=1234",
                            "origin_country_iso3": null,
                            "shipment_package_count": 0,
                            "shipment_type": null,
                            "signed_by": null,
                            "smses": [],
                            "source": "api",
                            "tag": "Pending",
                            "title": "Title Name",
                            "tracked_count": 0,
                            "unique_token": "xy_fej9Llg",
                            "checkpoints": []
                        }
                    }
                }',
                'result'       => [
                    'meta' => [
                        'code' => 201,
                    ],
                    'data' => [
                        'tracking' => [
                            'id'                       => '53aa7b5c415a670000000021',
                            'created_at'               => '2014-06-25T07:33:48+00:00',
                            'updated_at'               => '2014-06-25T07:33:48+00:00',
                            'tracking_number'          => '123456789',
                            'tracking_account_number'  => null,
                            'tracking_postal_code'     => null,
                            'tracking_ship_date'       => null,
                            'slug'                     => 'dhl',
                            'active'                   => true,
                            'custom_fields'            => [
                                'product_price' => 'USD19.99',
                                'product_name'  => 'iPhone Case'
                            ],
                            'customer_name'            => null,
                            'destination_country_iso3' => null,
                            'emails'                   => [
                                "email@yourdomain.com",
                                "another_email@yourdomain.com"
                            ],
                            'expected_delivery'        => null,
                            'note'                     => null,
                            'order_id'                 => 'ID 1234',
                            'order_id_path'            => 'http://www.aftership.com/order_id=1234',
                            'origin_country_iso3'      => null,
                            'shipment_package_count'   => 0,
                            'shipment_type'            => null,
                            'signed_by'                => null,
                            'smses'                    => [],
                            'source'                   => 'api',
                            'tag'                      => 'Pending',
                            'title'                    => 'Title Name',
                            'tracked_count'            => 0,
                            'unique_token'             => 'xy_fej9Llg',
                            'checkpoints'              => []
                        ]
                    ]
                ],
            ]
        ];
    }
}
