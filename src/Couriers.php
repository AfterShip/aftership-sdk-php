<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception\AfterShipException;

class Couriers extends Request
{
    /**
     * Get your selected couriers list
     * Return a list of user couriers enabled by user's account along their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers
     *
     * @return array Response body
     */
    public function get()
    {
        return $this->send('couriers', 'GET');
    }

    /**
     * Get all our supported couriers list
     * Return a list of system couriers supported by AfterShip along with their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers-all
     *
     * @return array Response body
     */
    public function getAll()
    {
        return $this->send('couriers/all', 'GET');
    }

    /**
     * Detect courier by tracking number
     * Return a list of matched couriers of a tracking based on the tracking number format. User can limit number of
     * matched couriers and change courier priority at courier settings. Or, passing the parameter `slugs` to detect.
     * https://www.aftership.com/docs/api/4/couriers/post-couriers-detect
     *
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params          The optional parameters
     *
     * @return array Response Body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function detect($trackingNumber, array $params = [])
    {
        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        // Fill the tracking number into the params array
        $params['tracking_number'] = $trackingNumber;

        return $this->send('couriers/detect/', 'POST', ['tracking' => $params]);
    }
}
