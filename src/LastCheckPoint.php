<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception\AfterShipException;

/**
 * Get tracking information of the last checkpoint of a tracking.
 * Class LastCheckPoint
 *
 * @package AfterShip
 */
class LastCheckPoint extends Request
{
    /**
     * Return the tracking information of the last checkpoint of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     *
     * @param string $slug           The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params         The optional parameters
     *
     * @return array Response body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function get($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('last_checkpoint/' . $slug . '/' . $trackingNumber, 'GET', $params);
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     *
     * @param string $id     The tracking ID which is provided by AfterShip
     * @param array  $params The optional parameters
     *
     * @return array Response body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function getById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('last_checkpoint/' . $id, 'GET', $params);
    }
} 