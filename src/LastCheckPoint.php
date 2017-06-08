<?php

namespace AfterShip;

/**
 * Get tracking information of the last checkpoint of a tracking.
 * Class LastCheckPoint
 * @property string _api_key
 * @package AfterShip
 */
class LastCheckPoint
{
    private $request;

    /**
     * The LastCheckPoint constructor.
     *
     * @param string $api_key The AfterShip API Key.
     *
     * @param Requestable|null $request
     * @throws AfterShipException
     */
    public function __construct($api_key, Requestable $request = null)
    {
        if (empty($api_key)) {
            throw new AfterShipException('API Key is missing');
        }

        $this->request = $request ? $request : new Request($api_key);
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking by slug and tracking number.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     * @param string $slug The slug of the tracking provider
     * @param string $tracking_number The tracking number which is provider by tracking provider
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function get($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new AfterShipException("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new AfterShipException('Tracking number cannot be empty');
        }

        return $this->request->send('last_checkpoint/' . $slug . '/' . $tracking_number, 'GET', $params);
    }

    /**
     * Return the tracking information of the last checkpoint of a single tracking by tracking ID.
     * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
     * @param string $id The tracking ID which is provided by AfterShip
     * @param array $params The optional parameters
     * @return array Response body
     * @throws \Exception
     */
    public function findById($id, array $params = [])
    {
        if (empty($id)) {
            throw new AfterShipException('Tracking ID cannot be empty');
        }

        return $this->request->send('last_checkpoint/' . $id, 'GET', $params);
    }

    function __call($name, $arguments)
    {
        $method = lcfirst(str_replace('_', '', ucwords('get_by_id', '_')));

        call_user_func_array([$this, $method], $arguments);
    }
}
