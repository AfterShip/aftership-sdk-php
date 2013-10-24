<?php
namespace aftership;

use AfterShip\core\Request;

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
        return $this->send('/couriers', 'GET');
    }
}
