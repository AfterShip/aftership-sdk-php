<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception;

class Couriers extends Request
{

    /**
     * The Couriers Constructor.
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
     * Get your selected couriers list
     * Return a list of user couriers enabled by user's account along their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers
     * @return array Response body
     */
    public function get()
    {
        return $this->send('couriers', 'GET');
    }

    /**
     * Get all our supported couriers list
     * Return a list of system couriers supported by AfterShip along with their names, URLs, slugs, required fields.
     * https://www.aftership.com/docs/api/4/couriers/get-couriers-all
     * @return array Response body
     */
    public function all()
    {
        return $this->send('couriers/all', 'GET');
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
            throw new Exception('Tracking number cannot be empty');
        }

        // Fill the tracking number into the params array
        $params['tracking_number'] = $tracking_number;
        return $this->send('couriers/detect/', 'POST', array('tracking' => $params));
    }
}