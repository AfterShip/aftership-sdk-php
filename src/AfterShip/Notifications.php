<?php

namespace AfterShip;

use AfterShip\Core\Request;
use Aftership\Exception\AftershipException;

class Notifications extends Request
{

    /**
     * The Notifications constructor.
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
	 * Create a notification by slug and tracking number.
	 * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
	 * @param string $tracking_number The tracking number which is provider by tracking provider
	 * @param array $params The optional parameters
	 * @return array Reponse Body
	 * @throws \AftershipException
	 */
	public function create($slug, $tracking_number, array $params = array())
	{
		if (empty($slug)) {
			throw new AftershipException('Slug cannot be empty');
		}

		if (empty($tracking_number)) {
			throw new AftershipException('Tracking number cannot be empty');
		}

		return $this->send('notifications/' . $slug . '/' . $tracking_number . '/add', 'POST', array('notification' => $params));
	}

	/**
	 * Create a notification by tracking ID.
	 * https://www.aftership.com/docs/api/4/notifications/post-add-notifications
	 * @param string $id The tracking ID which is provided by AfterShip
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function create_by_id($id, array $params = array())
	{
		if (empty($id)) {
			throw new AftershipException('Tracking ID cannot be empty');
		}

		return $this->send('notifications/' . $id . '/add', 'POST', array('notification' => $params));
	}

	/**
	 * Delete a notification by slug and tracking number.
	 * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
	 * @param string $slug The slug of the tracking provider
	 * @param string $tracking_number The tracking number which is provider by tracking provider
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function delete($slug, $tracking_number, array $params = array())
	{
		if (empty($slug)) {
			throw new AftershipException('Slug cannot be empty');
		}

		if (empty($tracking_number)) {
			throw new AftershipException('Tracking number cannot be empty');
		}

		return $this->send('notifications/' . $slug . '/' . $tracking_number . '/remove', 'POST', array('notification' => $params));
	}

	/**
	 * Delete a notification by tracking ID.
	 * https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
	 * @param string $id The tracking ID which is provided by AfterShip
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function delete_by_id($id, array $params = array()){
		if (empty($id)) {
			throw new AftershipException('Tracking ID cannot be empty');
		}

		return $this->send('notifications/' . $id . '/remove', 'POST', array('notification' => $params));
	}

	/**
	 * Get notification of a single tracking by slug and tracking number.
	 * https://www.aftership.com/docs/api/4/notifications/get-notifications
	 * @param string $slug The slug of the tracking provider
	 * @param string $tracking_number The tracking number which is provider by tracking provider
	 * @param array $params The optional parameters
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function get($slug, $tracking_number, array $params = array())
	{
		if (empty($slug)) {
			throw new AftershipException('Slug cannot be empty');
		}

		if (empty($tracking_number)) {
			throw new AftershipException('Tracking number cannot be empty');
		}

		return $this->send('notifications/' . $slug . '/' . $tracking_number, 'GET', $params);
	}

	/**
	 * Get notification of a single tracking by tracking ID
	 * https://www.aftership.com/docs/api/4/notifications/get-notifications
	 * @param string $id The tracking ID which is provided by AfterShip
	 * @param array $params The optional parameters
	 * @return array Response body
	 * @throws \AftershipException
	 */
	public function get_by_id($id, array $params = array()){
		if (empty($id)) {
			throw new AftershipException('Tracking ID cannot be empty');
		}

		return $this->send('notifications/' . $id, 'GET', $params);
	}
}
