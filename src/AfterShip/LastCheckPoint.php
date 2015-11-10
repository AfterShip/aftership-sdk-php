<?php

namespace AfterShip;

use AfterShip\Core\Request;
use AfterShip\Exception\AftershipException;

/**
 * Get tracking information of the last checkpoint of a tracking.
 * Class LastCheckPoint
 * @package AfterShip
 */
class LastCheckPoint extends Request
{

    /**
     * The LastCheckPoint constructor.
     *
     * @param string $api_key The AfterShip API Key.
     * @param array $guzzle_plugins Guzzle Plugins
     *
     * @throws \AftershipException
     */
	public function __construct($api_key, array $guzzle_plugins = array())
    {
        if (empty($api_key)) {
            throw new AftershipException('API Key is missing');
        }

        $this->_api_key = $api_key;

        if (count($guzzle_plugins) > 0) {
            $this->_guzzle_plugins = $guzzle_plugins;
        }

        parent::__construct();
    }

	/**
	 * Return the tracking information of the last checkpoint of a single tracking by slug and tracking number.
	 * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
	 * @param string $slug The slug of the tracking provider
	 * @param string $tracking_number The tracking number which is provider by tracking provider
	 * @param array $params The optional parameters
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function get($slug, $tracking_number, array $params = array())
    {
        if (empty($slug)) {
            throw new AftershipException("Slug cannot be empty");
        }

        if (empty($tracking_number)) {
            throw new AftershipException('Tracking number cannot be empty');
        }

        return $this->send('last_checkpoint/' . $slug . '/' . $tracking_number, 'GET', $params);
    }

	/**
	 * Return the tracking information of the last checkpoint of a single tracking by tracking ID.
	 * https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
	 * @param string $id The tracking ID which is provided by AfterShip
	 * @param array $params The optional parameters
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function get_by_id($id, array $params = array()){
		if (empty($id)) {
			throw new AftershipException('Tracking ID cannot be empty');
		}

		return $this->send('last_checkpoint/' . $id, 'GET', $params);
	}
} 