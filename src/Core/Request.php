<?php

namespace AfterShip\Core;

use GuzzleHttp\ClientInterface;
use AfterShip\Exception\AfterShipException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class Request
{
    const API_URL     = 'https://api.aftership.com';
    const API_VERSION = 'v4';

    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var Client
     */
    protected $client;

    /**
     * Request constructor.
     *
     * @param $apiKey
     *
     * @throws AfterShipException
     */
    public function __construct($apiKey)
    {
        if (empty($apiKey)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->apiKey = $apiKey;
    }

    /**
     * @param ClientInterface $client
     *
     * @return $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param string $url
     * @param string $requestType
     * @param array  $data
     *
     * @return mixed
     * @throws AfterShipException
     * @throws GuzzleException
     * @throws \Exception
     */
    protected function send($url, $requestType, array $data = [])
    {
        $headers = [
            'aftership-api-key' => $this->apiKey,
            'Content-Type'      => 'application/json'
        ];

        $url     = self::API_URL . '/' . self::API_VERSION . '/' . $url;
        $options = [
            'headers' => $headers,
            'body'    => json_encode($data),
        ];
        try {
            switch (strtoupper($requestType)) {
                case 'GET':
                    $result = $this->getClient()->get($url, ['headers' => $headers, 'query' => $data]);
                    break;
                case 'POST':
                    $result = $this->getClient()->post($url, $options);
                    break;
                case 'PUT':
                    $result = $this->getClient()->put($url, $options);
                    break;
                case 'DELETE':
                    $result = $this->getClient()->delete($url, $options);
                    break;
                default:
                    throw new AfterShipException("Method $requestType is currently not supported.");
            }
        } catch (BadResponseException $exception) {
            $result = $exception->getResponse();
        } catch (GuzzleException $exception) {
            throw $exception;
        }

        try {
            $response = json_decode($result->getBody());
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $response;
    }
}
