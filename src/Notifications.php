<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception;

class Notifications extends Request
{

    /**
     * The Notifications constructor.
     *
     * @param string $api_key The AfterShip API Key.
     *
     * @throws \Exception
     */
    public function __construct($api_key)
    {
        if (empty($api_key)) {
            throw new Exception('API Key is missing');
        }

        $this->_api_key = $api_key;

        parent::__construct();
    }

    /**
     * Create a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Reponse Body
     * @throws \Exception
     */
    public function create($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new Exception('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new Exception('Tracking number cannot be empty');
        }

        return $this->send('notifications/' . $slug . '/' . $tracking_number . '/add', 'POST', array('notification' => $params));
    }

    /**
     * Create a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws \Exception
     */
    public function createById($id, array $params = [])
    {
        if (empty($id)) {
            throw new Exception('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id . '/add', 'POST', array('notification' => $params));
    }

    /**
     * Delete a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @return array Response body
     * @throws \Exception
     */
    public function delete($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new Exception('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new Exception('Tracking number cannot be empty');
        }

        return $this->send('notifications/' . $slug . '/' . $tracking_number . '/remove', 'POST', array('notification' => $params));
    }

    /**
     * Delete a notification by tracking ID.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws \Exception
     */
    public function deleteById($id, array $params = [])
    {
        if (empty($id)) {
            throw new Exception('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id . '/remove', 'POST', array('notification' => $params));
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
            throw new Exception('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new Exception('Tracking number cannot be empty');
        }

        return $this->send('notifications/' . $slug . '/' . $tracking_number, 'GET', $params);
    }

    /**
     * Get notification of a single tracking by tracking ID
     * https://www.aftership.com/docs/api/4/notifications/get-notifications
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function getById($id, array $params = array())
    {
        if (empty($id)) {
            throw new Exception('Tracking ID cannot be empty');
        }

        return $this->send('notifications/' . $id, 'GET', $params);
    }
}
