<?php

namespace AfterShip;

/**
 * Get tracking information of the last checkpoint of a tracking.
 * Class LastCheckPoint
 * @property string _api_key
 * @package AfterShip
 */
class LastCheckPoint extends BackwardCompatible
{
    private $request;

    /**
     * The LastCheckPoint constructor.
     *
     * @param string $apiKey The AfterShip API Key.
     *
     * @param Requestable|null $request
     * @throws AfterShipException
     */
    public function __construct($apiKey, Requestable $request = null)
    {
        if (empty($apiKey)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($apiKey);
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function get($slug, $trackingNumber, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('last_checkpoint/' . $slug . '/' . $trackingNumber, 'GET', $params);
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function getById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('last_checkpoint/' . $trackingId, 'GET', $params);
    }
}
