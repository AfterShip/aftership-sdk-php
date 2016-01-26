<?php

namespace AfterShip\Core;

use AfterShip\Exception\AftershipException;

class Request
{
	private $_api_url = 'https://api.aftership.com';
	protected $_api_key = '';
	private $_api_version = 'v4';
	private $_client;

	protected function __construct()
	{
	}

	protected function send($url, $request_type, array $data = array())
	{

		$headers = array(
			'aftership-api-key' => $this->_api_key,
			'content-type' => 'application/json'
		);

		switch (strtoupper($request_type)) {
			case "GET":
				$request = $this->get($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, array('query' => $data));
				break;
			case "POST":
				$request = $this->post($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
			case "PUT":
				$request = $this->put($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
			case "DELETE":
				$request = $this->delete($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
				break;
			default:
                		throw new AftershipException("Method $request_type is currently not supported.");
		}

		return $request;
	}

	private function call($method, $parameters = array()) {
		$body = '';
		if (isset($parameters['body'])) {
			$body = $parameters['body'];
		}
		$headers = array();
		foreach($parameters['headers'] as $key => $value) {
			array_push($headers, "$key: $value");
		}
		$url = $parameters['url'];
		if ($method != 'POST') {
			if (isset($parameters['query'])) {
				if (count($parameters['query']) > 0) {
					$url = $url . '?' . http_build_query($parameters['query']);
				}
			}	
		}
		$curl = curl_init();
		$curl_params = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => $headers
		);
		if ($method != 'GET') {
			$curl_params[CURLOPT_POSTFIELDS] = $body;
		}
		curl_setopt_array($curl, $curl_params);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		if ($err) {
			throw new AftershipException("failed to request: $err");
		}
		$info = curl_getinfo($curl);
		$code = $info['http_code'];
		if ($code < 200 || $code >= 300) {
			$parsed = json_decode($response);
			$err_code = '';
			$err_message = '';
			$err_type = '';
			if (isset($parsed->meta->code)) {
				$err_code = $parsed->meta->code;
			}
			if (isset($parsed->meta->message)) {
				$err_message = $parsed->meta->message;
			}
			if (isset($parsed->meta->type)) {
				$err_type = $parsed->meta->type;
			}
			throw new AftershipException("$err_type: $err_code - $err_message");
		}
		curl_close($curl);
		return json_decode($response, true);
	}

	private function GET($url, $headers, $body) {
		$parameters = array();
		$parameters['query'] = $body;
		$parameters['headers'] = $headers;
		$parameters['url'] = $url;
		return $this->call('GET', $parameters);
	}

	private function POST($url, $headers, $body) {
		$parameters = array();
		$parameters['body'] = $body;
		$parameters['headers'] = $headers;
		$parameters['url'] = $url;
		return $this->call('POST', $parameters);
	}

	private function PUT($url, $headers, $body) {
		$parameters = array();
		$parameters['body'] = $body;
		$parameters['headers'] = $headers;
		$parameters['url'] = $url;
		return $this->call('PUT', $parameters);
	}

	private function DELETE($url, $headers, $body) {
		$parameters = array();
		$parameters['body'] = $body;
		$parameters['headers'] = $headers;
		$parameters['url'] = $url;
		return $this->call('DELETE', $parameters);
	}

}
