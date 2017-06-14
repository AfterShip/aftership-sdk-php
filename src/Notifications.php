<?php

namespace AfterShip;

/**
 * Class Notifications
 * @package AfterShip
 */
class Notifications
{
    private $request;

    /**
     * Notifications constructor.
     * @param $apiKey
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
     * Create a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param $slug
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws AfterShipException
     */
    public function create($slug, $trackingNumber, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('notifications/' . $slug . '/' . $trackingNumber . '/add', 'POST',
            ['notification' => $params]);
    }

    /**
     * Create a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function createById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('notifications/' . $trackingId . '/add', 'POST', array('notification' => $params));
    }

    /**
     * Delete a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function delete($slug, $trackingNumber, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('notifications/' . $slug . '/' . $trackingNumber . '/remove', 'POST',
            array('notification' => $params));
    }

    /**
     * Delete a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function deleteById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('notifications/' . $trackingId . '/remove', 'POST', array('notification' => $params));
    }

    /**
     * Get notification of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function get($slug, $trackingNumber, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('notifications/' . $slug . '/' . $trackingNumber, 'GET', $params);
    }

    /**
     * Get notification of a single tracking by tracking ID
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function getById($trackingId, array $params = array())
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('notifications/' . $trackingId, 'GET', $params);
    }
}
