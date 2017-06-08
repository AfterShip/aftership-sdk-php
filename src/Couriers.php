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
     * @param string $api_key The AfterShip API Key.
     *
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
     * Get your selected couriers list
     * Return a list of user couriers enabled by user's account along their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers
     * @return array Response body
     */
    public function get()
    {
        return $this->request->send('couriers', 'GET');
    }

    /**
     * Get all our supported couriers list
     * Return a list of system couriers supported by AfterShip along with their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers-all
     * @return array Response body
     */
    public function all()
    {
        return $this->request->send('couriers/all', 'GET');
    }

    /**
     * Detect courier by tracking number
     * Return a list of matched couriers of a tracking based on the tracking number format. User can limit number of
     * matched couriers and change courier priority at courier settings. Or, passing the parameter `slugs` to detect.
     * https://www.aftership.com/docs/api/4/couriers/post-couriers-detect
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response Body
     * @throws \Exception
     */
    public function detect($tracking_number, array $params = array())
    {
        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        // Fill the tracking number into the params array
        $params['tracking_number'] = $tracking_number;
        return $this->request->send('couriers/detect/', 'POST', ['tracking' => $params]);
    }
}
