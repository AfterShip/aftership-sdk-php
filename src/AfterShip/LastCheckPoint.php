<?php

namespace AfterShip;

use AfterShip\Core\Request;

/**
 * Get tracking information of the last checkpoint of a tracking.
 * Class LastCheckPoint
 * @package AfterShip
 */
class LastCheckPoint extends Request
{
    public function __construct ($api_key, $guzzle_plugins = array())
    {
        if (empty($api_key)) {
            throw new \Exception('API Key is missing');
        }

        $this->_api_key = $api_key;

        if (count($guzzle_plugins) > 0) {
            $this->_guzzle_plugins = $guzzle_plugins;
        }

        parent::__construct();
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking.
     *
     * @param $slug
     * @param $tracking_number
     *
     * @return mixed
     * @throws \Exception
     */
    public function get ($slug, $tracking_number)
    {
        if (empty($slug)) {
            throw new \Exception("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new \Exception('Tracking number cannot be empty');
        }

        return $this->send('last_checkpoint/' . $slug . '/' . $tracking_number, 'GET');
    }
} 