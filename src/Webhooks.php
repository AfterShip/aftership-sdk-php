<?php

namespace AfterShip;


class Webhooks
{
    private $secret;

    /**
     * Webhooks constructor.
     * @param $secret
     * @throws AfterShipException
     */
    public function __construct($secret)
    {
        if (empty($secret)) {
            throw new AfterShipException('Webhooks secret is missing');
        }

        $this->secret = $secret;
    }

    /**
     * calculateSignature method
     * @param $body string
     * @return string
     */
    public function calculateSignature($body)
    {
        $calculatedSignature = hash_hmac('sha256', $body, $this->secret, true);

        return base64_encode($calculatedSignature);
    }

    /**
     * validateWebhook method
     * @param $body string
     * @param $hmac string
     * @return boolean
     */
    public function validateWebhook($body, $hmac)
    {
        $signature = $this->calculateSignature($body);

        return $signature === $hmac;
    }
}
