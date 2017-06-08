<?php
require('../vendor/autoload.php');


use \AfterShip\AfterShipException;

$key = '';

$couriers = new AfterShip\Couriers($key);
$trackings = new AfterShip\Trackings($key);
$last_check_point = new AfterShip\LastCheckPoint($key);

//$response = $couriers->get();

//$response = $trackings->get('china-ems', 'EV942706669CN');
//$response = $trackings->get('china-ems', 'EV942706669CN', array('lang' => 'en'));
//$response = $trackings->get('china-ems', 'EV942706669CN', array('fields' => 'title,tracking_destination_country', 'lang' => 'en'));

//$response = $couriers->detect('41910575873');

$tracking_info = [
    'slug'    => 'aramex',
    'title'   => 'My Title',
];
//$response = $trackings->create('41910575873', $tracking_info);

//$response = $trackings->delete('rocketparcel', '100006802232');

$response = null;

// $response = $trackings->get_all('', array('slug' => 'austrian-post-registered'));

try {
    $response = $trackings->create('', $tracking_info);
} catch (AfterShipException $e) {
    echo $e->getMessage();
}

//$response = $last_check_point->get_by_id('5694783e6e61b7bd427c1b8a');

print_r($response);
