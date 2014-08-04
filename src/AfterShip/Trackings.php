<?php

namespace AfterShip;

use AfterShip\Core\Request;

class Trackings extends Request
{
	public function __construct($api_key, $guzzle_plugins = array())
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

	public function create($tracking_number, array $params = array())
	{
		if (empty($tracking_number)) {
			throw new \Exception('Tracking number cannot be empty');
		}

		return $this->send('trackings', 'POST', $params);
	}

	public function batch_create(array $tracking_numbers = array())
	{
		throw new \Exception('Sorry! It will be available soon.');
	}

	public function delete($slug, $tracking_number)
	{
		if (empty($slug)) {
			throw new \Exception('Slug cannot be empty');
		}

		if (empty($tracking_number)) {
			throw new \Exception('Tracking number cannot be empty');
		}

		return $this->send('trackings/' . $slug . '/' . $tracking_number, 'DELETE');
	}

	public function delete_by_id($id){
		//TODO
	}

	public function get_all(array $params = array()){
		return $this->send('trackings', 'GET', $params);
	}

	public function get($slug, $tracking_number, array $params = array())
	{
		if (empty($slug)) {
			throw new \Exception('Slug cannot be empty');
		}

		if (empty($tracking_number)) {
			throw new \Exception('Tracking number cannot be empty');
		}

		return $this->send('trackings/' . $slug . '/' . $tracking_number, 'GET', $params);
	}

	public function get_by_id($id, $params){
		//TODO
	}

	public function update($slug, $tracking_number, array $params = array())
	{
		if (empty($slug)) {
			throw new \Exception("Slug cannot be empty");
		}

		if (empty($tracking_number)) {
			throw new \Exception('Tracking number cannot be empty');
		}

		return $this->send('trackings/' . $slug . '/' . $tracking_number, 'PUT', $params);
	}

	public function update_by_id($id, array $fields = array())
	{
		//TODO
		if (empty($id)) {
			throw new \Exception('Tracking ID cannot be empty');
		}

		return $this->send('trackings/' . $id, 'PUT', $fields);
	}

	public function retrack($slug, $tracking_number)
	{
		if (empty($slug)) {
			throw new \Exception("Slug cannot be empty");
		}

		if (empty($tracking_number)) {
			throw new \Exception('Tracking number cannot be empty');
		}

		return $this->send('trackings/' . $slug . '/' . $tracking_number . '/retrack', 'POST');
	}

	public function retrack_by_id($id){
		//TODO
	}
}
