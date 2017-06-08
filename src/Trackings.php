<?php

namespace AfterShip;

class Trackings extends BackwardCompatible
{
    private $request;

    /**
     * The Trackings constructor.
     *
     * @param string $api_key The AfterShip API Key.
     *
     * @param Requestable $request
     * @throws AfterShipException
     */
    public function __construct($api_key = '', Requestable $request = null)
    {
        if (empty($api_key)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($api_key);
    }

    /**
     * Create a tracking.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws AfterShipException
     */
    public function create($tracking_number, array $params = [])
    {
        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        $params['tracking_number'] = $tracking_number;
        return $this->request->send('trackings', 'POST', ['tracking' => $params]);
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

    /** @deprecated */
    public function create_multiple()
    {
        return $this->createMultiple();
    }

    /**
     * Delete a tracking number by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @return array Response body
     * @throws AfterShipException
     */
    public function delete($slug, $tracking_number)
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('trackings/' . $slug . '/' . $tracking_number, 'DELETE');
    }

    /**
     * Delete a tracking number by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/delete-trackings
     * @param string $id The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws AfterShipException
     */
    public function deleteById($id)
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('trackings/' . $id, 'DELETE');
    }

    /**
     * Get tracking results of multiple trackings.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings
     * @param array $params The optional parameters
     * @return array Response body
     */
    public function all(array $params = [])
    {
        return $this->request->send('trackings', 'GET', $params);
    }

    public function get_all($params)
    {
        return $this->all($params);
    }

    /**
     * Get tracking results of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function get($slug, $tracking_number, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException('Slug cannot be empty');
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('trackings/' . $slug . '/' . $tracking_number, 'GET', $params);
    }

    /**
     * Get tracking results of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function getById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('trackings/' . $id, 'GET', $params);
    }

    /**
     * Update a tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function update($slug, $tracking_number, array $params = [])
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('trackings/' . $slug . '/' . $tracking_number, 'PUT', ['tracking' => $params]);
    }

    /**
     * Update a tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws AfterShipException
     */
    public function updateById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('trackings/' . $id, 'PUT', ['tracking' => $params]);
    }

    /**
     * Retrack an expired tracking once by slug and tracking number.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     * @param string $slug The slug of tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @return array Response body
     * @throws AfterShipException
     */
    public function retrack($slug, $tracking_number)
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('trackings/' . $slug . '/' . $tracking_number . '/retrack', 'POST');
    }

    /**
     * Retrack an expired tracking once by tracking ID.
     * https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
     * @param string $id The tracking ID which is provided by AfterShip
     * @return array Response body
     * @throws \AfterShip\AfterShipException
     */
    public function retrackById($id)
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('trackings/' . $id . '/retrack', 'POST');
    }

}
