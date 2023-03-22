<?php

namespace AfterShip;

/**
 * @property string $api_key
 */
class Couriers extends BackwardCompatible
{
    private $request;

    /**
     * The Couriers Constructor.
     *
     * @param string $apiKey The AfterShip API Key.
     *
     * @param Requestable|null $request
     * @param array|null the request curl opt
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
     * Get your selected couriers list
     * Return a list of user couriers enabled by user's account along their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers
     * @return array Response body
     */
    public function get()
    {
        return $this->request->send('GET', 'couriers');
    }

    /**
     * Get all our supported couriers list
     * Return a list of system couriers supported by AfterShip along with their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers-all
     * @return array Response body
     */
    public function all()
    {
        return $this->request->send('GET', 'couriers/all');
    }

    /**
     * Detect courier by tracking number
     * Return a list of matched couriers of a tracking based on the tracking number format. User can limit number of
     * matched couriers and change courier priority at courier settings. Or, passing the parameter `slugs` to detect.
     * https://www.aftership.com/docs/api/4/couriers/post-couriers-detect
     * @param string $trackingNumber The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws \Exception
     */
    public function detect($trackingNumber, array $params = array())
    {
        if (empty($trackingNumber)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        // Fill the tracking number into the params array
        $params['tracking_number'] = $trackingNumber;
        return $this->request->send('POST', 'couriers/detect/', ['tracking' => $params]);
    }
}
