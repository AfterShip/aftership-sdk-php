<?php

namespace AfterShip;

use AfterShip\Core\Request;

class Couriers extends Request
{
    public function __construct($api_key, $guzzle_plugins = array())
    {
        if (empty($api_key))
            throw new \Exception('API Key is missing');

        $this->_api_key = $api_key;

        if (count($guzzle_plugins) > 0) {
            $this->_guzzle_plugins = $guzzle_plugins;
        }

        parent::__construct();
    }

    public function get()
    {
        return $this->send('couriers', 'GET');
    }

	public function get_all(){
		return $this->send('couriers/all', 'GET');
	}

    public function detect($tracking_number, array $params = array())
    {
        if (empty($tracking_number)) {
            throw new \Exception('Tracking number cannot be empty');
        }

		//TODO
		$params['tracking_number'] = $tracking_number;
        return $this->send('couriers/detect/', 'POST', array('tracking' => $params));
    }
}
