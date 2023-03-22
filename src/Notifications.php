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
     * @param array|null the request curl opt
     * @param Requestable|null $request
     * @throws AfterShipException
     */
    public function __construct($apiKey, Requestable $request = null, $curlOpt = null)
    {
        if (empty($apiKey)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($apiKey, $curlOpt);
    }

    /**
     * Create a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
     * @param $slug
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @param array $additionalFields The tracking additional_fields required by some courier
     * @return array Response Body
     * @throws AfterShipException
     */
    public function create($slug, $trackingNumber, array $params = array(), $additionalFields = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('POST', 'notifications/' . $slug . '/' . $trackingNumber . '/add' . TrackingAdditionalFields::buildQuery($additionalFields, '?'),
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

        return $this->request->send('POST', 'notifications/' . $trackingId . '/add', ['notification' => $params]);
    }

    /**
     * Delete a notification by slug and tracking number.
     * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params
     * @param array $additionalFields The tracking additional_fields required by some courier
     * @return array Response body
     * @throws AfterShipException
     */
    public function delete($slug, $trackingNumber, array $params = [], $additionalFields = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('POST', 'notifications/' . $slug . '/' . $trackingNumber . '/remove' . TrackingAdditionalFields::buildQuery($additionalFields, '?'),
            ['notification' => $params]);
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

        return $this->request->send('POST', 'notifications/' . $trackingId . '/remove', ['notification' => $params]);
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
    public function get($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('GET', 'notifications/' . $slug . '/' . $trackingNumber, $params);
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

        return $this->request->send('GET', 'notifications/' . $trackingId, $params);
    }
}
