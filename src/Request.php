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
    const API_VERSION = 'tracking/2024-01';
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    private $apiSecret = '';
    /**
     * @var string
     */
    private $encryptionMethod = '';
    /**
     * @var string
     */
    private $encryptionPassword = '';
    /**
     *
     * @var array
     */
    private $curlOpt;
    /**
     * Request constructor.
     *
     * @param $apiKey
     */
    function __construct($apiKey, $curlOpt)
    {
        $apiSecret = '';
        $encryptionMethod = '';
        $encryptionPassword= '';
        $asApiKey=$apiKey;

        if (is_array($apiKey)) {
            if (array_key_exists('api_secret', $apiKey)) {
                $apiSecret = $apiKey['api_secret'];
            }
            if (array_key_exists('encryption_method', $apiKey)) {
                $encryptionMethod = $apiKey['encryption_method'];
            }
            if (array_key_exists('encryption_password', $apiKey)) {
                $encryptionPassword = $apiKey['encryption_password'];
            }
            if (array_key_exists('api_key', $apiKey)) {
                $asApiKey = $apiKey['api_key'];
            }
        }

        $this->apiKey = $asApiKey;
        $this->apiSecret = $apiSecret;
        $this->encryptionMethod = $encryptionMethod;
        $this->encryptionPassword = $encryptionPassword;
        $this->curlOpt = $curlOpt;
    }

    /**
     * @param $path
     * @param $method
     * @param array $data
     *
     * @return mixed
     */
    public function send($method, $path, array $data = [])
    {
        $url = self::API_URL . '/' . self::API_VERSION . '/' . $path;
        $methodUpper = strtoupper($method);
        $parameters  = [
            'url'     => $url,
        ];

        if ($methodUpper == 'GET' && $data > 0) {
            $parameters['url'] = $parameters['url'] . '?' . http_build_query($data);
        } else if ($methodUpper != 'GET') {
            $parameters['body'] = $this->safeJsonEncode($data);
        }

        $headers     = $this->getHeaders($method, $parameters['url'], $data);
        $parameters['headers'] = array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($headers), $headers);

        return $this->call($methodUpper, $parameters);
    }

    private function call($method, $parameters = [])
    {
        $curl       = curl_init();
        // user custom curl opt
        if (!empty($this->curlOpt)) {
            curl_setopt_array($curl, $this->curlOpt);
        }
        $curlParams = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $parameters['url'],
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $parameters['headers'],
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

    function getCanonicalizedHeaders($headers)
    {
        $filtered_headers = [];

        foreach ($headers as $key => $value) {
            // Check if the header key starts with "as-"
            if (strpos($key, 'as-') === 0) {
                // Convert header key to lowercase and trim leading/trailing spaces
                $key = strtolower(trim($key));

                // Trim leading/trailing spaces from header value
                $value = trim($value);

                // Concatenate header key and value
                $filtered_headers[] = "{$key}:{$value}";
            }
        }

        // Sort headers in ASCII code order
        sort($filtered_headers, SORT_STRING);

        // Concatenate header pairs with new line character
        $header_string = implode("\n", $filtered_headers);

        return $header_string;
    }

    function getCanonicalizedResource($url)
    {
        $path = "";
        $query = "";
        $parse_url = parse_url($url);
        if (array_key_exists('path', $parse_url)) {
            $path = $parse_url['path'];
        }
        if (array_key_exists('query', $parse_url)) {
            $query = $parse_url['query'];
        }
        if ($query === "") {
            return $path;
        }

        $params = explode("&", $query);
        sort($params);
        $queryStr = implode("&", $params);
        $path .= "?" . $queryStr;

        return $path;
    }

    function getSignString($method, $url, $data, $headers)
    {
        $contentMD5 = "";
        $contentType = "";
        if (!empty($data) && $method != "GET") {
            $contentMD5 = strtoupper(md5($this->safeJsonEncode($data)));
            $contentType = "application/json";
        }

        $canonicalizedHeaders = $this->getCanonicalizedHeaders($headers);
        $canonicalizedResource = $this->getCanonicalizedResource($url);
        return mb_convert_encoding($method."\n".$contentMD5."\n".$contentType."\n".$headers['date']."\n".$canonicalizedHeaders."\n".$canonicalizedResource, 'UTF-8');
    }

    private function getHeaders($method, $url, $data)
    {
        $isRSAEncryptionMethod = strcmp($this->encryptionMethod, Encryption::ENCRYPTION_RSA) == 0;
        $isAESEncryptionMethod = strcmp($this->encryptionMethod, Encryption::ENCRYPTION_AES) == 0;

        // if not RSA or AES encryption, just return the legacy headers
        if (!$isRSAEncryptionMethod && !$isAESEncryptionMethod) {
            return [
                'as-api-key' => $this->apiKey,
                'content-type'      => 'application/json'
            ];
        }

        $encryption = new Encryption($this->apiSecret, $this->encryptionMethod, $this->encryptionPassword);
        // get the header `date`
        date_default_timezone_set('UTC');
        $date = gmdate('D, d M Y H:i:s \G\M\T', time());
        $contentType = "";

        // get the header `content-type`
        if (!empty($data) && $method != "GET") {
            $contentType = "application/json";
        }

        $headers = [
            'as-api-key' => $this->apiKey,
            'date' => $date,
            'content-type' => $contentType,
        ];
        $signString = $this->getSignString($method, $url, $data, $headers);

        if ($isRSAEncryptionMethod) {
            $rsa = $encryption->rsaPSSSha256Encrypt($signString);
            $headers['as-signature-rsa-sha256'] = $rsa;

            return $headers;
        }
        if ($isAESEncryptionMethod) {
            $rsa = $encryption->hmacSha256Encrypt($signString);
            $headers['as-signature-hmac-sha256'] = $rsa;

            return $headers;
        }
    }
}
