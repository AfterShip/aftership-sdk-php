<?php
namespace AfterShip\core;

use Guzzle\Http\Client;

class request
{
	private $_api_url = 'https://api.aftership.com';
	protected $_api_key = '';
	private $_api_version = 'v3';

	protected function send($url, $request_type, $data) {
		$client  = new Client();
		$headers = array(
			'aftership-api-key' => $this->_api_key
		);
		switch (strtoupper($request_type)) {
			case "GET":
				$request = $client->get($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, array('query' => $data));
				break;
			case "POST":
				$request = $client->post($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, $data);
				break;
			case "PUT":
				$request = $client->put($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, http_build_query($data));
				break;
		}

		$response = $request->send()->json();

		return $response;
	}
}