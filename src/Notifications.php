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
     * @param $api_key
     * @param Requestable|null $request
     * @throws AfterShipException
     */
    public function __construct($api_key, Requestable $request = null)
    {
        if (empty($api_key)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($api_key);
    }

    /**
     * Create a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param $slug
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws AfterShipException
     */
    public function create($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('notifications/' . $slug . '/' . $tracking_number . '/add', 'POST',
            array('notification' => $params));
    }

    /**
     * Create a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function createById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('notifications/' . $id . '/add', 'POST', array('notification' => $params));
    }

    /**
     * Delete a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function delete($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->send('notifications/' . $slug . '/' . $tracking_number . '/remove', 'POST',
            array('notification' => $params));
    }

    /**
     * Delete a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params
     * @return array Response body
     * @throws AfterShipException
     */
    public function deleteById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('notifications/' . $id . '/remove', 'POST', array('notification' => $params));
    }

    /**
     * Get notification of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function get($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('notifications/' . $slug . '/' . $tracking_number, 'GET', $params);
    }

    /**
     * Get notification of a single tracking by tracking ID
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function getById($id, array $params = array())
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id, 'GET', $params);
    }
}
