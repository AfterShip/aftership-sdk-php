<?php

namespace AfterShip;

use AfterShip\core\request;

class Tracking extends request
{
	public function __construct($api_key) {
		if (empty($api_key))
			throw new \Exception('API Key is missing');
		$this->_api_key = $api_key;

	}

	public function create(array $data) {
		return $this->send('/trackings', 'POST', $data);
	}

	public function get(array $options) {
		return $this->send('/trackings', 'GET', $options);
	}

	public function info($slug, $tracking_number, array $fields) {
		return $this->send('/trackings/' . $slug . '/' . $tracking_number, 'GET', implode(',', $fields));
	}

	public function update($slug, $tracking_number, array $options) {
		return $this->send('/trackings/' . $slug . '/' . $tracking_number, 'PUT', $options);
	}
}