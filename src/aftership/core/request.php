<?php
namespace AfterShip\core;

use Guzzle\Http\Client;

class request
{
	private $_api_url = 'https://api.aftership.com';
	protected $_api_key = '';

	protected function send($url, $request_type, array $data = array()) {
		$client  = new Client($this->_api_url);
		$headers = array(
			'aftership-api-key' => $this->_api_key
		);
		switch (strtoupper($request_type)) {
			case "GET":
				$request = $client->get($url, $headers, array('query' => $data));
				break;
			case "POST":
				$request = $client->post($url, $headers, $data);
				break;
			case "PUT":
				$request = $client->put($url, $headers, http_build_query($data));
				break;
		}

		$response = $request->send()->json();

		return $response;
	}
}