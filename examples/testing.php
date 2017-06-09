<html>
<head>
    <title>Testing</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".btn").click(function () {
                var value = $(this).val();
                $("#hidden").val(value);
                $("#form").submit();
            });
        });
    </script>
</head>

<body>
<?php
require('../vendor/autoload.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';
$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : '';
$request_all = ($action == 'ALL');
?>

<h1>AfterShip API PHP SDK Testing</h1>
This is the official PHP SDK of AfterShip API. Provided by AfterShip
<a href="support@aftership.com">support@aftership.com</a>
</br>

<form action="testing.php" method="GET" id="form">
    API KEY:
    <input type="text" value="<?= $api_key ?>" name="api_key" size="45"/>
    <a href="http://aftership.uservoice.com/knowledgebase/articles/401963">How to generate AfterShip API Key?</a>
    <br/>
    Request All:
    <input type="button" value="ALL" class="btn"/>
    <br/>
    ACTION: <?= $action ?>;
    <br/>

    <hr>

    <?php if (!$api_key): ?>
        <br/>
        <b>Plase input API key first</b>
        <?php exit ?>
    <?php endif; ?>

    <?php
    function presult($arr)
    {
        print '<div class="response">';
        print '<pre style="width: 800px; height: 20pc; overflow-y: scroll; background-color:#CCCCCC">';
        print_r($arr);
        print '</pre>';
        print '</div>';
        print '</br>';
    }


    echo '<input type="hidden" name="action" id="hidden"/>';

    $couriers = new AfterShip\Couriers($api_key);

    echo '<h2>Couriers</h2>';
    echo '<input type="button" value="couriers_get" class="btn">' . 'get user\'s couriers' . '</br>';
    if ($request_all || $action == 'couriers_get') {
        try {
            presult($couriers->get());
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="couriers_get_all" class="btn">' . 'get all couriers' . '</br>';
    if ($request_all || $action == 'couriers_get_all') {
        try {
            presult($couriers->get_all());
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="couriers_detect" class="btn">' . 'detect courier by tracking number' . '</br>';
    if ($request_all || $action == 'couriers_detect') {
        try {
            presult($couriers->detect('1ZV90R483A33906706'));
        } catch (Exception $e) {
            presult($e);
        }
    }


    $trackings = new AfterShip\Trackings($api_key);
    echo '<h2>Trackings</h2>';
    echo '<input type="button" value="trackings_create" class="btn">' . 'create tracking' . '</br>';
    if ($request_all || $action == 'trackings_create') {
        try {
            presult($trackings->create('1ZV90R483A33906705'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    /*
    echo '<input type="button" value="couriers_get" class="btn">'.'batch create'.'</br>';
    if ($request_all || $action == 'couriers_get'){
    p($trackings->batch_create(array('1ZV90R483A33906706')));
    }
    */

    echo '<input type="button" value="trackings_delete" class="btn">' . 'delete tracking' . '</br>';
    if ($request_all || $action == 'trackings_delete') {
        try {
            presult($trackings->delete('ups', '1ZV90R483A33906705'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_delete_by_id" class="btn">' . 'delete tracking by id' . '</br>';
    if ($request_all || $action == 'trackings_delete_by_id') {
        try {
            presult($trackings->delete_by_id('53df4d66868a6df243b6f882'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_get_all" class="btn">' . 'get all trackings' . '</br>';
    if ($request_all || $action == 'trackings_get_all') {
        try {
            presult($trackings->get_all([
                'slug'   => 'ups',
                'fields' => 'title,order_id,message,country_name'
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_get" class="btn">' . 'get a tracking' . '</br>';
    if ($request_all || $action == 'trackings_get') {
        try {
            presult($trackings->get('ups', '1ZV90R483A33906706'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_get_by_id" class="btn">' . 'get a tracking by id' . '</br>';
    if ($request_all || $action == 'trackings_get_by_id') {
        try {
            presult($trackings->get_by_id('53df4a90868a6df243b6efd8', [
                'fields' => 'customer_name'
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_update" class="btn">' . 'update a tracking' . '</br>';
    if ($request_all || $action == 'trackings_update') {
        try {
            presult($trackings->update('ups', '1ZV90R483A33906706', [
                'title' => 'haha'
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_update_by_id" class="btn">' . 'update a tracking by id' . '</br>';
    if ($request_all || $action == 'trackings_update_by_id') {
        try {
            presult($trackings->update_by_id('53df4a90868a6df243b6efd8'), [
                'title'         => 'T1',
                'customer_name' => 'Sunny'
            ]);
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_retrack" class="btn">' . 'retrack a tracking' . '</br>';
    if ($request_all || $action == 'trackings_retrack') {
        try {
            presult($trackings->retrack('ups', '1ZV90R483A33906706'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="trackings_retrack_by_id" class="btn">' . 'retrack a tracking by id' . '</br>';
    if ($request_all || $action == 'trackings_retrack_by_id') {
        try {
            presult($trackings->retrack_by_id('53df4a90868a6df243b6efd8'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    $last_check_point = new AfterShip\LastCheckPoint($api_key);
    echo '<h2>Last Check Point</h2>';
    echo '<input type="button" value="last_check_point_get" class="btn">' . 'get' . '</br>';
    if ($request_all || $action == 'last_check_point_get') {
        try {
            presult($last_check_point->get('ups', '1ZV90R483A33906706'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="last_check_point_get_by_id" class="btn">' . 'get by id' . '</br>';
    if ($request_all || $action == 'last_check_point_get_by_id') {
        try {
            presult($last_check_point->get_by_id('53df4a90868a6df243b6efd8', [
                'fields' => 'city,zip,state'
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }


    $notifications = new AfterShip\Notifications($api_key);
    echo '<h2>Notifications</h2>';

    echo '<input type="button" value="notifications_create" class="btn">' . 'create notification' . '</br>';
    if ($request_all || $action == 'notifications_create') {
        try {
            presult($notifications->create('ups', '1ZV90R483A33906706', [
                'emails' => ['youremail@yourdomain.com']
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="notifications_create_by_id" class="btn">' . 'create notification by id' . '</br>';
    if ($request_all || $action == 'notifications_create_by_id') {
        try {
            presult($notifications->create_by_id('53df4a90868a6df243b6efd8'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="notifications_delete" class="btn">' . 'delete notification' . '</br>';
    if ($request_all || $action == 'notifications_delete') {
        try {
            presult($notifications->delete('ups', '1ZV90R483A33906706', [
                'emails' => ['youremail@yourdomain.com']
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="notifications_delete_by_id" class="btn">' . 'delete notification by id' . '</br>';
    if ($request_all || $action == 'notifications_delete_by_id') {
        try {
            presult($notifications->delete_by_id('53df4d66868a6df243b6f882'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="notifications_get" class="btn">' . 'get a notification' . '</br>';
    if ($request_all || $action == 'notifications_get') {
        try {
            presult($notifications->get('ups', '1ZV90R483A33906706'));
        } catch (Exception $e) {
            presult($e);
        }
    }

    echo '<input type="button" value="notifications_get_by_id" class="btn">' . 'get a notification by id' . '</br>';
    if ($request_all || $action == 'notifications_get_by_id') {
        try {
            presult($notifications->get_by_id('53df4a90868a6df243b6efd8', [
                'fields' => 'customer_name'
            ]));
        } catch (Exception $e) {
            presult($e);
        }
    }
    ?>


</form>

</body>
</html>
