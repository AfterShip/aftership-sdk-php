<?php
require(__DIR__ . '/../vendor/autoload.php');


use \AfterShip\AfterShipException;

$key = '';

$couriers = new AfterShip\Couriers($key);
$trackings = new AfterShip\Trackings($key);
$last_check_point = new AfterShip\LastCheckPoint($key);
$estimated_delivery_dates = new AfterShip\EstimatedDeliveryDates($key);

$tracking_info = [
    'slug'    => 'aramex',
    'title'   => 'My Title',
];

$response = null;

try {
    $response = $couriers->all();
} catch (AfterShipException $e) {
    echo $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
