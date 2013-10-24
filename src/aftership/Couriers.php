<?php
namespace aftership;

use AfterShip\core\request;

class Couriers extends request
{
    public function __construct($api_key)
    {
        if (empty($api_key))
            throw new \Exception('API Key is missing');
        $this->_api_key = $api_key;

    }

    public function get()
    {
        return $this->send('/couriers', 'GET');
    }
}
