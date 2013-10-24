<?php
namespace aftership\core;

use Guzzle\Http\Client;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class request
{
    private $_api_url = 'https://api.aftership.com';
    protected $_api_key = '';
    private $_api_version = 'v3';
    protected $_guzzle_plugins = array();
	private $_client;

	protected function __construct(){
		$this->_client  = new Client();

		if(count($this->_guzzle_plugins) > 0){
			foreach($this->_guzzle_plugins as $plugin)
				if($plugin instanceof EventSubscriberInterface)
					$this->_client->addSubscriber($plugin);
		}
	}
    protected function send($url, $request_type, $data = array())
    {

        $headers = array(
            'aftership-api-key' => $this->_api_key
        );
        switch (strtoupper($request_type)) {
            case "GET":
                $request = $this->_client->get($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, array('query' => $data));
                break;
            case "POST":
                $request = $this->_client->post($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, $data);
                break;
            case "PUT":
                $request = $this->_client->put($this->_api_url . '/' . $this->_api_version . '/' . $url, $headers, $data);
                break;
        }

        $response = $request->send()->json();

        return $response;
    }
}
