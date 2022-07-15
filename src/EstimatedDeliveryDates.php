<?php

namespace AfterShip;

class EstimatedDeliveryDates extends BackwardCompatible
{
    private $request;

    /**
     * @param string $apiKey The AfterShip API Key.
     *
     * @param Requestable $request
     * @throws AfterShipException
     */
    public function __construct($apiKey = '', Requestable $request = null)
    {
        if (empty($apiKey)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($apiKey);
    }

    /**
     * @return array Response Body
     * @throws AfterShipException
     */
    public function batchPredict(array $params = [])
    {
        return $this->request->send('POST', 'estimated-delivery-date/predict-batch', ['estimated_delivery_dates' => $params]);
    }
}
