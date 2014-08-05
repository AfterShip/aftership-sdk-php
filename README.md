![Picture](https://www.aftership.com/assets/common/img/logo-aftership-premium-bright.png)
###Aftership PHP SDK

#### Installation
**Using Composer**
```
 "require": {
        ....
        "aftership/aftership-php-sdk": "1.0"
    },
```
#### 
#### Get all our supported couriers list.

```
require 'vendor/autoload.php';

$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $couriers->get();
```

#### Detect courier by tracking number

```
require 'vendor/autoload.php';

$courier = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $courier->detect('1234567890Z');
```

#### Create a new tracking number
[List of data for the API](https://www.aftership.com/docs/api/3.0/tracking/post-trackings#request)
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$tracking_info = array(
    'slug'              => 'dhl',
    'tracking_number'   => 'RA123456789US',

);
$response = $trackings->create($tracking_info);
```


####Return the latest 100 created trackings in past 30 days from the user account.
[List of allowed parameters for the options](https://www.aftership.com/docs/api/3.0/tracking/get-trackings#request)

```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$options = array(
    'page'=>1,
    'limit'=>10
);

$response = $trackings->get_all($options)
```

####Return a tracking result with all the detail checkpoints
[Fields for the request](https://www.aftership.com/docs/api/3.0/tracking/get-trackings-slug-tracking_number#request)

```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get('dhl','RA123456789US',array('title','order_id'));
```

####Update tracking record and return all the detail, exclude the checkpoints
[List of allowed parameters](https://www.aftership.com/docs/api/3.0/tracking/put-trackings-slug-tracking_number#request)

```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$params = array(
    'smses'             => array(),
    'emails'            => array(),
    'title'             => '',
    'customer_name'     => '',
    'order_id'          => '',
    'order_id_path'     => '',
    'custom_fields'     => array()
);
$response = $trackings->update('dhl','RA123456789US',$params);
```

####Reactivate Tracking

```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->retrack('dhl','RA123456789US');
```

####Finding Last Checkpoint

```
require 'vendor/autoload.php';

$last_check_point = new AfterShip\LastCheckPoint('AFTERSHIP_API_KEY');
$response = $last_check_point->get('dhl','RA123456789US');
```

####Adding Guzzle Plugins
[Guzzle Plugins](http://guzzlephp.org/plugins/plugins-overview.html)

```
require 'vendor/autoload.php';

$history = new HistoryPlugin();
$async = new AsyncPlugin();
$logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);

$guzzlePlugins = array($history, $async, $logPlugin);

$tracking = new AfterShip\Tracking('AFTERSHIP_API_KEY', $guzzlePlugins);
$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY', $guzzlePlugins);
```
