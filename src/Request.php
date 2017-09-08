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
     *
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
     *
     * @return mixed
     */
    public function send($method, $url, array $data = [])
    {
        $methodUpper = strtoupper($method);
        $headers     = [
            'aftership-api-key' => $this->apiKey,
            'content-type'      => 'application/json'
        ];
        $parameters  = [
            'url'     => self::API_URL . '/' . self::API_VERSION . '/' . $url,
            'headers' => array_map(function ($key, $value) {
                return "$key: $value";
            }, array_keys($headers), $headers)
        ];
        if ($methodUpper == 'GET' && $data > 0) {
            $parameters['url'] = $parameters['url'] . '?' . http_build_query($data);
        } else if ($methodUpper != 'GET') {
            $parameters['body'] = $this->safeJsonEncode($data);
        }

        return $this->call($methodUpper, $parameters);
    }

    private function call($method, $parameters = [])
    {
        $curl       = curl_init();
        $curlParams = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $parameters['url'],
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $parameters['headers']
        ];
        if ($method != 'GET') {
            $curlParams[CURLOPT_POSTFIELDS] = $parameters['body'];
        }
        curl_setopt_array($curl, $curlParams);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        if ($err) {
            curl_close($curl);
            throw new AfterShipException("failed to request: $err");
        }
        $info = curl_getinfo($curl);
        $code = $info['http_code'];
        if ($code < 200 || $code >= 300) {
            $this->handleHttpStatusError($response, $curl, $code);
        }
        curl_close($curl);

        return json_decode($response, true);
    }

    public function safeJsonEncode($mixed)
    {
        $encoded = json_encode($mixed);
        $error   = json_last_error();
        switch ($error) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                throw new AfterShipException('Maximum stack depth exceeded'); // or trigger_error() or throw new Exception()
            case JSON_ERROR_UTF8:
                $clean = $this->utf8ize($mixed);

                return $this->safeJsonEncode($clean);
            default:
                throw new AfterShipException("json_encode Error: $error");
        }
    }

    private function utf8ize($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } else if (is_string($mixed)) {
            return utf8_encode($mixed);
        }

        return $mixed;
    }

    /**
     * @param $response
     * @param $curl
     * @param $code
     *
     * @throws AfterShipException
     */
    private function handleHttpStatusError($response, $curl, $code)
    {
        $parsed = json_decode($response);
        if ($parsed === null) {
            curl_close($curl);
            throw new AfterShipException("Error processing request - received HTTP error code $code", $code);
        }
        $errCode    = '';
        $errMessage = '';
        $errType    = '';
        if (isset($parsed->meta->code)) {
            $errCode = $parsed->meta->code;
        }
        if (isset($parsed->meta->message)) {
            $errMessage = $parsed->meta->message;
        }
        if (isset($parsed->meta->type)) {
            $errType = $parsed->meta->type;
        }
        curl_close($curl);
        throw new AfterShipException("$errType: $errCode - $errMessage", $errCode);
    }
}
