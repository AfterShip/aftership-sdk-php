<?php
namespace AfterShip;

use AfterShip\core\request;

require_once 'config.php';
class Couriers extends request
{
	public function get() {
		return $this->send('/couriers', 'GET');
	}
}