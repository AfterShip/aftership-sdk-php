###Aftership PHP SDK

#### Installation
**Using Composer**
```
 "require": {
        ....
        "abishekrsrikaanth/aftership-php-sdk": "dev-master"
    },
```

#### Get all our supported couriers list.

```
require 'vendor/autoload.php';

$courier = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $courier->get();
```

#### Create a new tracking number
[List of data for the API](https://www.aftership.com/docs/api/3.0/tracking/post-trackings#request)
```
require 'vendor/autoload.php';

$tracking = new AfterShip\Tracking('AFTERSHIP_API_KEY);
$tracking_info = array(
    'slug'              => 'dhl',
    'tracking_number'   => 'RA123456789US',

);
$response = $tracking->create($tracking_info);
```


####Return the latest 100 created trackings in past 30 days from the user account.
[List of allowed parameters for the options](https://www.aftership.com/docs/api/3.0/tracking/get-trackings#request)

```
require 'vendor/autoload.php';

$tracking = new AfterShip\Tracking('AFTERSHIP_API_KEY);
$options = array(
    'page'=>1,
    'limit'=>10
);

$response = $tracking->get($options)
```

####Return a tracking result with all the detail checkpoints
[Fields for the request](https://www.aftership.com/docs/api/3.0/tracking/get-trackings-slug-tracking_number#request)

```
require 'vendor/autoload.php';

$tracking = new AfterShip\Tracking('AFTERSHIP_API_KEY);
$response = $tracking->info('dhl','RA123456789US',array('title','order_id'));
```

####Update tracking record and return all the detail, exclude the checkpoints
[List of allowed parameters](https://www.aftership.com/docs/api/3.0/tracking/put-trackings-slug-tracking_number#request)

```
require 'vendor/autoload.php';

$tracking = new AfterShip\Tracking('AFTERSHIP_API_KEY);
$params = array(
    'smses'             => array(),
    'emails'            => array(),
    'title'             => '',
    'customer_name'     => '',
    'order_id'          => '',
    'order_id_path'     => '',
    'custom_fields'     => array()
);
$response = $tracking->update('dhl','RA123456789US',$params);
```
