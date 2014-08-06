![Picture](https://www.aftership.com/assets/common/img/logo-aftership-premium-bright.png)
#AfterShip API PHP SDK
aftership-php is a PHP SDK (module) for [AfterShip API](https://www.aftership.com/docs/api/4/). Module provides clean and elegant way to access API endpoints. **Compatible with Afership API**

Contact: <support@aftership.com>

## Installation
#####Using Composer
```
 "require": {
        ....
        "aftership/aftership-php-sdk": "1.0"
    },
```
Run the following command in the command line
```
composer install
```

## Testing
1. Execulte the file: aftership-php/test/testing.php at your browser
2. Insert your AfterShip API Key. [How to generate AfterShip API Key](http://aftership.uservoice.com/knowledgebase/articles/401963)
3. Click the request all button or the button of the represented request


## Couriers
##### Get your selected couriers list
https://www.aftership.com/docs/api/4/couriers/get-couriers
```
require 'vendor/autoload.php';

$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $couriers->get();
```

##### Get all our supported couriers list
https://www.aftership.com/docs/api/4/couriers/get-couriers-all
```
require 'vendor/autoload.php';

$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $couriers->get_all();
```

##### Detect courier by tracking number
https://www.aftership.com/docs/api/4/couriers/post-couriers-detect
```
require 'vendor/autoload.php';

$courier = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $courier->detect('1234567890Z');
```

## Trackings
##### Create a new tracking
https://www.aftership.com/docs/api/4/trackings/post-trackings
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$tracking_info = array(
    'slug'    => 'dhl',
    'title'   => 'My Title',
);
$response = $trackings->create('RA123456789US', $tracking_info);
```

##### Create multiple trackings
(Will be available soon)

##### Delete a tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/delete-trackings
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->delete('dhl', 'RA123456789US');
```

##### Delete a tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/delete-trackings
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->delete_by_id('53df4a90868a6df243b6efd8');
```

#####Get tracking results of multiple trackings
https://www.aftership.com/docs/api/4/trackings/get-trackings
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$options = array(
    'page'=>1,
    'limit'=>10
);
$response = $trackings->get_all($options)
```

#####Get tracking results of a single tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get('dhl', 'RA123456789US', array('title','order_id'));
```

#####Get tracking results of a single tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get_by_id('53df4a90868a6df243b6efd8', array('title','order_id'));
```

#####Update a tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
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
$response = $trackings->update('dhl', 'RA123456789US', $params);
```

#####Update a tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
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
$response = $trackings->update_by_id('53df4a90868a6df243b6efd8', $params);
```

#####Reactivate Tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->retrack('dhl','RA123456789US');
```

#####Reactivate Tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
```
require 'vendor/autoload.php';

$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->retrack_by_id('53df4a90868a6df243b6efd8');
```

##Last Check Point
#####Return the tracking information of the last checkpoint of a single tracking by slug and tracking number
https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
```
require 'vendor/autoload.php';

$last_check_point = new AfterShip\LastCheckPoint('AFTERSHIP_API_KEY');
$response = $last_check_point->get('dhl','RA123456789US');
```

#####Return the tracking information of the last checkpoint of a single tracking by tracking ID
https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
```
require 'vendor/autoload.php';

$last_check_point = new AfterShip\LastCheckPoint('AFTERSHIP_API_KEY');
$response = $last_check_point->get_by_id('53df4a90868a6df243b6efd8');
```

##Adding Guzzle Plugins
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


## Contributors
These amazing people have contributed code to this project:

- Abishek R Srikaanth - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=abishekrsrikaanth)
- Luis Cordova - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=cordoval)
- Russell Davies - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=russelldavies)
- akovalyov - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=akovalyov)
- Robert Basic - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=robertbasic)

