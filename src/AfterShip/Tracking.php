<?php

namespace AfterShip;

use AfterShip\Core\Request;

class Tracking extends Request
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

    public function create (array $data)
    {
        if (empty($data)) {
            throw new \Exception('Tracking Request cannot be empty');
        }

        return $this->send('trackings', 'POST', json_encode(array('tracking' => $data)));
    }

    public function get (array $options = array())
    {
        return $this->send('trackings', 'GET', $options);
    }

    public function info ($slug, $tracking_number, array $fields = array())
    {
        if (empty($slug)) {
            throw new \Exception("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new \Exception('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $tracking_number, 'GET', $fields);
    }

    public function update ($slug, $tracking_number, array $options)
    {
        if (empty($slug)) {
            throw new \Exception("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new \Exception('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $tracking_number, 'PUT', json_encode(array('tracking' => $options)));
    }

    public function reactivate ($slug, $tracking_number)
    {
        if (empty($slug)) {
            throw new \Exception("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new \Exception('Tracking number cannot be empty');
        }

        return $this->send('trackings/' . $slug . '/' . $tracking_number . '/reactivate', 'POST');
    }
}
