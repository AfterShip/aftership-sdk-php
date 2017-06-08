<?php

namespace AfterShip\Core;

use AfterShip\Exception;

class Request
{
    private $_api_url = 'https://api.aftership.com';
    protected $_api_key = '';
    private $_api_version = 'v4';

    public function __construct()
    {
    }

    protected function send($url, $request_type, array $data = array())
    {
        $headers = array(
            'aftership-api-key' => $this->_api_key,
            'content-type' => 'application/json'
        );

        switch (strtoupper($request_type)) {
            case 'GET':
                return $this->callGET($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, $data);
            case 'POST':
                return $this->callPOST($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
            case 'PUT':
                return $this->callPUT($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
            case 'DELETE':
                return $this->callDELETE($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, json_encode($data));
            default:
                throw new Exception("Method $request_type is currently not supported.");
        }
    }

    private function call($method, $parameters = [])
    {
        $body = '';
        if (isset($parameters['body'])) {
            $body = $parameters['body'];
        }
        $headers = [];
        foreach ($parameters['headers'] as $key => $value) {
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
        $curl_params = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers
        ];
        if ($method != 'GET') {
            $curl_params[CURLOPT_POSTFIELDS] = $body;
        }
        curl_setopt_array($curl, $curl_params);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            throw new Exception("failed to request: $err");
        }
        $info = curl_getinfo($curl);
        $code = $info['http_code'];
        if ($code < 200 || $code >= 300) {
            $parsed = json_decode($response);

            if ($parsed === null) {
                throw new Exception("Error processing request - received HTTP error code $code", $code);
            }

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
            throw new Exception("$err_type: $err_code - $err_message", $err_code);
        }
        curl_close($curl);
        return json_decode($response, true);
    }

    private function callGET($url, $headers, $body)
    {
        $parameters = [
            'query' => $body,
            'headers' => $headers,
            'url' => $url
        ];
        return $this->call('GET', $parameters);
    }

    private function callPOST($url, $headers, $body)
    {
        $parameters = compact('url', 'headers', 'body');
        return $this->call('POST', $parameters);
    }

    private function callPUT($url, $headers, $body)
    {
        $parameters = compact('url', 'headers', 'body');
        return $this->call('PUT', $parameters);
    }

    private function callDELETE($url, $headers, $body)
    {
        $parameters = compact('url', 'headers', 'body');
        return $this->call('DELETE', $parameters);
    }
}
