<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception\AfterShipException;

class Trackings extends Request
{
    /**
     * Create a tracking.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings
     *
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params         The optional parameters
     *
     * @return array Reponse Body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function create($trackingNumber, array $params = [])
    {
        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        $params['tracking_number'] = $trackingNumber;

        return $this->send('trackings', 'POST', ['tracking' => $params]);
    }

    /**
     * Delete a tracking number by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     *
     * @param string $slug           The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function delete($slug, $trackingNumber)
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $trackingNumber, 'DELETE');
    }

    /**
     * Delete a tracking number by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     *
     * @param string $id The tracking ID which is provided by AfterShip
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function deleteById($id)
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('trackings/' . $id, 'DELETE');
    }

    /**
     * Get tracking results of multiple trackings.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings
     *
     * @param array $params The optional parameters
     *
     * @return array Response body
     */
    public function getAll(array $params = [])
    {
        return $this->send('trackings', 'GET', $params);
    }

    /**
     * Get tracking results of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     *
     * @param string $slug           The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params         The optional parameters
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function get($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $trackingNumber, 'GET', $params);
    }

    /**
     * Get tracking results of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     *
     * @param string $id     The tracking ID which is provided by AfterShip
     * @param array  $params The optional parameters
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function getById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('trackings/' . $id, 'GET', $params);
    }

    /**
     * Update a tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     *
     * @param string $slug           The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params         The optional parameters
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function update($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $trackingNumber, 'PUT', ['tracking' => $params]);
    }

    /**
     * Update a tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     *
     * @param string $id     The tracking ID which is provided by AfterShip
     * @param array  $params The optional parameters
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function updateById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('trackings/' . $id, 'PUT', ['tracking' => $params]);
    }

    /**
     * Retrack an expired tracking once by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     *
     * @param string $slug           The slug of tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function reTrack($slug, $trackingNumber)
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $trackingNumber . '/retrack', 'POST');
    }

    /**
     * Retrack an expired tracking once by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     *
     * @param string $id The tracking ID which is provided by AfterShip
     *
     * @return array Response body
     * @throws AfterShipException
     * @throws \Exception
     */
    public function reTrackById($id)
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('trackings/' . $id . '/retrack', 'POST');
    }
}
