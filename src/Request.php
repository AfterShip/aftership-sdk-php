<?php

namespace AfterShip;

/**
 * Class Request
 * @package AfterShip
 */
/**
 * Class Request
 * @package AfterShip
 */
class Request implements Requestable
{
    /**
     * @var string
     */
    private $API_URL = 'https://api.aftership.com';
    /**
     * @var string
     */
    private $API_VERSION = 'v4';
    /**
     * @var string
     */
    protected $api_key = '';


    /**
     * Request constructor.
     * @param $api_key
     */
    function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * @param $url
     * @param $method
     * @param array $data
     * @return mixed
     */
    public function send($url, $method, array $data = [])
    {
        $headers = [
            'aftership-api-key' => $this->api_key,
            'content-type'      => 'application/json'
        ];

        $method_upper = strtoupper($method);
        $parameters = [
            'url' => "{$this->API_URL}/{$this->API_VERSION}/{$url}",
            'headers' => $headers,
        ];
        if ($method_upper == 'GET') {
            $parameters['query'] = $data;
        } else {
            $parameters['body'] = json_encode($data);
        }

        return $this->call($method_upper, $parameters);
    }

    private function call($method, $parameters = [])
    {
        $url = $parameters['url'];
        $headers = $parameters['headers'];

        $headers = array_map(function($key, $value) {
            return "$key: $value";
        }, array_keys($headers), $headers);

        if ($method == 'GET') {
            $query = $parameters['query'];
            if ($query > 0) {
                $url = $url . '?' . http_build_query($query);
            }
        }
        $curl = curl_init();
        $curl_params = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers
        ];
        if ($method != 'GET') {
            $curl_params[CURLOPT_POSTFIELDS] = $parameters['body'];
        }
        curl_setopt_array($curl, $curl_params);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            throw new AfterShipException("failed to request: $err");
        }
        $info = curl_getinfo($curl);
        $code = $info['http_code'];
        if ($code < 200 || $code >= 300) {
            $parsed = json_decode($response);

            if ($parsed === null) {
                throw new AfterShipException("Error processing request - received HTTP error code $code", $code);
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
            throw new AfterShipException("$err_type: $err_code - $err_message", $err_code);
        }
        curl_close($curl);
        return json_decode($response, true);
    }
}
