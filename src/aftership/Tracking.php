<?php

namespace AfterShip;

use AfterShip\core\request;

require_once 'config.php';
class Tracking extends request
{
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