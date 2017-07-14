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
    const API_URL = 'https://api.aftership.com';
    /**
     * @var string
     */
    const API_VERSION = 'v4';
    /**
     * @var string
     */
    protected $apiKey = '';


    /**
     * Request constructor.
     * @param $apiKey
     */
    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $url
     * @param $method
     * @param array $data
     * @return mixed
     */
    public function send($url, $method, array $data = [])
    {
        $methodUpper = strtoupper($method);
        $parameters = [
            'url' => self::API_URL. '/' . self::API_VERSION . '/' . $url,
            'headers' => [
                'aftership-api-key' => $this->apiKey,
                'content-type'      => 'application/json'
            ]
        ];
        if ($methodUpper == 'GET') {
            $parameters['query'] = $data;
        } else {
            $parameters['body'] = json_encode($data);
        }

        return $this->call($methodUpper, $parameters);
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
        $curlParams = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers
        ];
        if ($method != 'GET') {
            $curlParams[CURLOPT_POSTFIELDS] = $parameters['body'];
        }
        curl_setopt_array($curl, $curlParams);
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

            $errCode = '';
            $errMessage = '';
            $errType = '';
            if (isset($parsed->meta->code)) {
                $errCode = $parsed->meta->code;
            }
            if (isset($parsed->meta->message)) {
                $errMessage = $parsed->meta->message;
            }
            if (isset($parsed->meta->type)) {
                $errType = $parsed->meta->type;
            }
            throw new AfterShipException("$errType: $errCode - $errMessage", $errCode);
        }
        curl_close($curl);
        return json_decode($response, true);
    }
}
