<?php

namespace AfterShip;

class Trackings extends BackwardCompatible
{
    private $request;

    /**
     * The Trackings constructor.
     *
     * @param string $apiKey The AfterShip API Key.
     * @param array|null the request curl opt
     * @param Requestable $request
     * @throws AfterShipException
     */
    public function __construct($apiKey = '', Requestable $request = null, $curlOpt = null)
    {
        if (empty($apiKey)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($apiKey, $curlOpt);
    }

    /**
     * Create a tracking.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws AfterShipException
     */
    public function create($trackingNumber, array $params = [])
    {
        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        $params['tracking_number'] = $trackingNumber;
        return $this->request->send('POST', 'trackings', ['tracking' => $params]);
    }

    /**
     * Create multiple trackings.
     * (Will be available soon)
     * @return null
     * @throws AfterShipException
     * @internal param array $tracking_numbers The set of tracking number which is provider by tracking provider
     */
    public function createMultiple()
    {
        throw new AfterShipException('Sorry! It will be available soon.');
    }

    /**
     * Delete a tracking number by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $additionalFields The tracking additional_fields required by some courier
     * @return array Response body
     * @throws AfterShipException
     */
    public function delete($slug, $trackingNumber, $additionalFields = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('DELETE', 'trackings/' . $slug . '/' . $trackingNumber . TrackingAdditionalFields::buildQuery($additionalFields, '?'));
    }

    /**
     * Delete a tracking number by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws AfterShipException
     */
    public function deleteById($trackingId)
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('DELETE', 'trackings/' . $trackingId);
    }

    /**
     * Get tracking results of multiple trackings.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings
     * @param array $params The optional parameters
     * @return array Response body
     */
    public function all(array $params = [])
    {
        return $this->request->send('GET', 'trackings', $params);
    }

    /**
     * Get tracking results of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function get($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('GET', 'trackings/' . $slug . '/' . $trackingNumber, $params);
    }

    /**
     * Get tracking results of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function getById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('GET', 'trackings/' . $trackingId, $params);
    }

    /**
     * Update a tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function update($slug, $trackingNumber, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('PUT', 'trackings/' . $slug . '/' . $trackingNumber, ['tracking' => $params]);
    }

    /**
     * Update a tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function updateById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('PUT', 'trackings/' . $trackingId, ['tracking' => $params]);
    }

    /**
     * Retrack an expired tracking once by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     * @param string $slug The slug of tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $additionalFields The tracking additional_fields required by some courier
     * @return array Response body
     * @throws AfterShipException
     */
    public function retrack($slug, $trackingNumber, $additionalFields = [])
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('POST', 'trackings/' . $slug . '/' . $trackingNumber . '/retrack' . TrackingAdditionalFields::buildQuery($additionalFields, '?'));
    }

    /**
     * Retrack an expired tracking once by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws \AfterShip\AfterShipException
     */
    public function retrackById($trackingId)
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('POST', 'trackings/' . $trackingId . '/retrack');
    }

    /**
     * Mark a tracking as completed once by slug and tracking number.
     * https://www.aftership.com/docs/tracking/16935744036c1-mark-tracking-as-completed-legacy
     * @param string $slug The slug of tracking provider
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $additionalFields The tracking additional_fields required by some courier
     * @return array Response body
     * @throws AfterShipException
     */
    public function markAsCompleted($slug, $trackingNumber, $additionalFields = [], array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('POST', 'trackings/' . $slug . '/' . $trackingNumber . '/mark-as-completed' . TrackingAdditionalFields::buildQuery($additionalFields, '?'), $params);
    }

    /**
     * Mark a tracking as completed once by tracking ID.
     * https://www.aftership.com/docs/tracking/272f444a1eb42-mark-tracking-as-completed-by-id
     * @param string $trackingId The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws \AfterShip\AfterShipException
     */
    public function markAsCompletedById($trackingId, array $params = [])
    {
        if (empty($trackingId)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('POST', 'trackings/' . $trackingId . '/mark-as-completed', $params);
    }

}
