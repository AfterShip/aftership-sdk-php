<?php

namespace AfterShip;

use AfterShip\Core\Request;
use Aftership\Exception\AfterShipException;

class Notifications extends Request
{
    /**
     * Create a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     *
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array  $params         The optional parameters
     *
     * @return array Reponse Body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function create($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send(
            'notifications/' . $slug . '/' . $trackingNumber . '/add',
            'POST',
            ['notification' => $params]
        );
    }

    /**
     * Create a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     *
     * @param string $id The tracking ID which is provided by AfterShip
     *
     * @return array Response body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function createById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id . '/add', 'POST', ['notification' => $params]);
    }

    /**
     * Delete a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     *
     * @param string $slug           The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     *
     * @return array Response body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function delete($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send(
            'notifications/' . $slug . '/' . $trackingNumber . '/remove',
            'POST',
            ['notification' => $params]
        );
    }

    /**
     * Delete a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     *
     * @param string $id The tracking ID which is provided by AfterShip
     *
     * @return array Response body
     * @throws \AfterShipException
     * @throws \Exception
     */
    public function deleteById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id . '/remove', 'POST', ['notification' => $params]);
    }

    /**
     * Get notification of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
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
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('notifications/' . $slug . '/' . $trackingNumber, 'GET', $params);
    }

    /**
     * Get notification of a single tracking by tracking ID
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
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

        return $this->send('notifications/' . $id, 'GET', $params);
    }
}
