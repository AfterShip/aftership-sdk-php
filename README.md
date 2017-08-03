# AfterShip API PHP SDK

[![Build Status](https://travis-ci.org/AfterShip/aftership-sdk-php.svg?branch=master)](https://travis-ci.org/AfterShip/aftership-sdk-php)
[![Code Climate](https://codeclimate.com/github/AfterShip/aftership-sdk-php/badges/gpa.svg)](https://codeclimate.com/github/AfterShip/aftership-sdk-php)
[![Issue Count](https://codeclimate.com/github/AfterShip/aftership-sdk-php/badges/issue_count.svg)](https://codeclimate.com/github/AfterShip/aftership-sdk-php)
[![codecov](https://codecov.io/gh/AfterShip/aftership-sdk-php/branch/master/graph/badge.svg)](https://codecov.io/gh/AfterShip/aftership-sdk-php)
[![Latest Stable Version](https://poser.pugx.org/aftership/aftership-php-sdk/v/stable)](https://packagist.org/packages/aftership/aftership-php-sdk)
[![Monthly Downloads](https://poser.pugx.org/aftership/aftership-php-sdk/d/monthly)](https://packagist.org/packages/aftership/aftership-php-sdk)
[![License](https://poser.pugx.org/aftership/aftership-php-sdk/license)](https://packagist.org/packages/aftership/aftership-php-sdk)

aftership-php is a PHP SDK (module) for [AfterShip API](https://www.aftership.com/docs/api/4/). Module provides clean and elegant way to access API endpoints. **Compatible with Afership API**

Contact: <support@aftership.com>

## Index
1. [Installation](https://github.com/AfterShip/aftership-sdk-php#installation)
2. [Testing](https://github.com/AfterShip/aftership-sdk-php#testing)
3. SDK
    1. [Couriers](https://github.com/AfterShip/aftership-sdk-php#couriers)
    2. [Trackings](https://github.com/AfterShip/aftership-sdk-php#trackings)
    3. [Last Check Point](https://github.com/AfterShip/aftership-sdk-php#last-check-point)
    4. [Notifications](https://github.com/AfterShip/aftership-sdk-php#notifications)
4. [Webhook](https://github.com/AfterShip/aftership-sdk-php#webhook)
5. [Contributors](https://github.com/AfterShip/aftership-sdk-php#contributors)

## Installation
##### Option 1 (recommended): Download and Install Composer. https://getcomposer.org/download/

Run the following command to require AfterShip PHP SDK
```
composer require aftership/aftership-php-sdk
```
Use autoloader to import SDK files
```php
require 'vendor/autoload.php';

$key = 'AFTERSHIP API KEY';

$couriers = new AfterShip\Couriers($key);
$trackings = new AfterShip\Trackings($key);
$last_check_point = new AfterShip\LastCheckPoint($key);
```

##### Option 2: Manual installation
1. Download or clone this repository to desired location
2. Reference files of this SDK in your project. Absolute path should be prefered.

```php
require('/path/to/repository/src/AfterShipException.php');
require('/path/to/repository/src/BackwardCompatible.php');
require('/path/to/repository/src/Couriers.php');
require('/path/to/repository/src/LastCheckPoint.php');
require('/path/to/repository/src/Notifications.php');
require('/path/to/repository/src/Requestable.php');
require('/path/to/repository/src/Request.php');
require('/path/to/repository/src/Trackings.php');

$key = 'AFTERSHIP API KEY';

$couriers = new AfterShip\Couriers($key);
$trackings = new AfterShip\Trackings($key);
$notifications = new AfterShip\Notifications($key);
$last_check_point = new AfterShip\LastCheckPoint($key);
```

#### Please ensure you have installed the PHP extension CURL, you could run the following command to install it
```
sudo apt-get install php5-curl
```
and restart the web server and PHP process.


## Testing
1. Execute the file:
 * If you are install manually, please execute 'test/testing.php' on your browser.
 * If you are install by composer, please execute 'vendor/aftership/aftership-php-sdk/test/testing.php' on your browser.
2. Insert your AfterShip API Key. [How to generate AfterShip API Key](https://help.aftership.com/hc/en-us/articles/115008353227-How-to-generate-AfterShip-API-Key-)
3. Click the request all button or the button of the represented request.


## Couriers
##### Get your selected couriers list
https://www.aftership.com/docs/api/4/couriers/get-couriers
```php
$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $couriers->get();
```

##### Get all our supported couriers list
https://www.aftership.com/docs/api/4/couriers/get-couriers-all
```php
$couriers = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $couriers->all();
```

##### Detect courier by tracking number
https://www.aftership.com/docs/api/4/couriers/post-couriers-detect
```php
$courier = new AfterShip\Couriers('AFTERSHIP_API_KEY');
$response = $courier->detect('1234567890Z');
```

## Trackings
##### Create a new tracking
https://www.aftership.com/docs/api/4/trackings/post-trackings
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$tracking_info = [
    'slug'    => 'dhl',
    'title'   => 'My Title',
];
$response = $trackings->create('RA123456789US', $tracking_info);
```

##### Create multiple trackings
(Will be available soon)

##### Delete a tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/delete-trackings
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->delete('dhl', 'RA123456789US');
```

##### Delete a tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/delete-trackings
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->deleteById('53df4a90868a6df243b6efd8');
```

##### Get tracking results of multiple trackings
https://www.aftership.com/docs/api/4/trackings/get-trackings
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$options = [
    'page'  => 1,
    'limit' => 10
];
$response = $trackings->all($options)
```

##### Get tracking results of a single tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get('dhl', 'RA123456789US', array('title','order_id'));
```

##### Get tracking results of a single tracking by slug and tracking number with custom display fields
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get('dhl', 'RA123456789US', array('fields' => 'title,order_id'));
```

##### Get tracking results of a single tracking by slug and tracking number in custom language
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number

In case of `china-post` and `china-ems` it is possible to customize language of checkpoint messages.

```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->get('dhl', 'RA123456789US', array('lang' => 'en'));
```

##### Get tracking results of a single tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/get-trackings-slug-tracking_number
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->getById('53df4a90868a6df243b6efd8', array('title','order_id'));
```

##### Update a tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$params = array(
    'smses'             => [],
    'emails'            => [],
    'title'             => '',
    'customer_name'     => '',
    'order_id'          => '',
    'order_id_path'     => '',
    'custom_fields'     => []
);
$response = $trackings->update('dhl', 'RA123456789US', $params);
```

##### Update a tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/put-trackings-slug-tracking_number
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$params = array(
    'smses'             => [],
    'emails'            => [],
    'title'             => '',
    'customer_name'     => '',
    'order_id'          => '',
    'order_id_path'     => '',
    'custom_fields'     => []
);
$response = $trackings->updateById('53df4a90868a6df243b6efd8', $params);
```

##### Reactivate Tracking by slug and tracking number
https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->retrack('dhl','RA123456789US');
```

##### Reactivate Tracking by tracking ID
https://www.aftership.com/docs/api/4/trackings/post-trackings-slug-tracking_number-retrack
```php
$trackings = new AfterShip\Trackings('AFTERSHIP_API_KEY');
$response = $trackings->retrackById('53df4a90868a6df243b6efd8');
```

## Last Check Point
##### Return the tracking information of the last checkpoint of a single tracking by slug and tracking number
https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
```php
$last_check_point = new AfterShip\LastCheckPoint('AFTERSHIP_API_KEY');
$response = $last_check_point->get('dhl','RA123456789US');
```

##### Return the tracking information of the last checkpoint of a single tracking by tracking ID
https://www.aftership.com/docs/api/4/last_checkpoint/get-last_checkpoint-slug-tracking_number
```php
$last_check_point = new AfterShip\LastCheckPoint('AFTERSHIP_API_KEY');
$response = $last_check_point->getById('53df4a90868a6df243b6efd8');
```

## Notifications
##### Create a new notification by slug and tracking number
https://www.aftership.com/docs/api/4/notifications/post-add-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->create('ups', '1ZV90R483A33906706', [
                'emails' => ['youremail@yourdomain.com']
            ])
```

##### Create a new notification by tracking ID
https://www.aftership.com/docs/api/4/notifications/post-add-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->createById('53df4a90868a6df243b6efd8');
```

##### Delete a notification by slug and tracking number.
https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->delete('ups', '1ZV90R483A33906706', [
                  'emails' => ['youremail@yourdomain.com']
              ]);
```

##### Delete a notification by tracking ID.
https://www.aftership.com/docs/api/4/notifications/post-remove-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->deleteById('53df4d66868a6df243b6f882'));
```

##### Get notification of a single tracking by slug and tracking number.
https://www.aftership.com/docs/api/4/notifications/get-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->get('dhl', '2254095771'));
```

##### Get notification of a single tracking by tracking ID
https://www.aftership.com/docs/api/4/notifications/get-notifications
```php
$notifications = new AfterShip\Notifications('AFTERSHIP_API_KEY');
$response = $notifications->getById('53df4a90868a6df243b6efd8', ['fields' => 'customer_name']);
```

## Webhook
https://www.aftership.com/docs/api/4/webhook
You could find the example code at [here](https://github.com/AfterShip/aftership-sdk-php/blob/master/examples/webhook.php)

## Contributors
These amazing people have contributed code to this project:

- Teddy Chan - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=teddychan)
- Sunny Chow - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=sunnychow)
- Abishek R Srikaanth - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=abishekrsrikaanth)
- Luis Cordova - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=cordoval)
- Russell Davies - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=russelldavies)
- akovalyov - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=akovalyov)
- Robert Basic - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=robertbasic)
- Marek Narozniak - [view contributions](https://github.com/AfterShip/aftership-php/commits?author=marekyggdrasil)
