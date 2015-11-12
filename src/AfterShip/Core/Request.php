<?php

namespace AfterShip\Core;

use AfterShip\Exception\AftershipException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Exception\GuzzleException;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

class Request
{
	private $_api_url = 'https://api.aftership.com';
	protected $_api_key = '';
	private $_api_version = 'v4';
	protected $_guzzle_plugins = array();
	private $_client;

	protected function __construct()
	{
		$this->_client = new Client();

		if (count($this->_guzzle_plugins) > 0) {
			foreach ($this->_guzzle_plugins as $plugin) {
				if ($plugin instanceof EventSubscriberInterface) {
					$this->_client->addSubscriber($plugin);
				}
			}
		}
	}

	protected function send($url, $request_type, array $data = array())
	{
		$headers = array(
			'aftership-api-key' => $this->_api_key,
			'content-type' => 'application/json'
		);

		switch (strtoupper($request_type)) {
			case "GET":
				$request = $this->_client->get($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, array('query' => $data));
				break;
			case "POST":
				$request = $this->_client->post($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
			case "PUT":
				$request = $this->_client->put($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
			case "DELETE":
				$request = $this->_client->delete($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
            default:
                throw new AftershipException("Method $request_type is currently not supported.");
		}

		try {
			$result = $request->send();
		} catch (BadResponseException $exception) {
			// http://guzzle3.readthedocs.org/http-client/request.html#http-request-messages
			$result = $exception->getResponse();
		} catch (GuzzleException $exception) {
			throw $exception;
		}

		try {
			$json = $result->json();
		} catch (Exception $exception) {
			throw $exception;
		}

		return $json;
	}
}
