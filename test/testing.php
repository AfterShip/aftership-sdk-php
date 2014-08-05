<?php

?>

<html>
<head>
	<title>Testing</title>
	<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.btn').click(function(){
				var value = $(this).val();
				$('#hidden').val(value);
				$('#form').submit();
			});
		});
	</script>
</head>

<body>
<?
include_once('config.php');
include_once('../vendor/autoload.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

global $api_key;
echo 'API KEY: ' . $api_key;
print '</br>';
echo 'ACTION: '. $action;
print '</br>';
echo 'Request All: '. $request_all;
print '</br>';


if (isset($api_key)){
	echo '</br>';
	echo '<b>Plase input API key first</b>';
	exit;
}


function p($arr)
{
	print '<div class="response">';
	print '<pre style="width: 800px; height: 20pc; overflow-y: scroll; background-color:#CCCCCC">';
	print_r($arr);
	print '</pre>';
	print '</div>';
	print '</br>';
}


echo '<form action="testing.php" method="get" id="form">';
echo '<input type="hidden" name="action" id="hidden"/>';

$couriers = new AfterShip\Couriers($api_key);
echo '<h1>Couriers</h1>';
echo '<input type="button" value="couriers_get" class="btn">' . 'get user\'s couriers' . '</br>';
if ($request_all || $action == 'couriers_get') {
	p($couriers->get());
}

echo '<input type="button" value="couriers_get_all" class="btn">' . 'get all couriers' . '</br>';
if ($request_all || $action == 'couriers_get_all') {
	p($couriers->get_all());
}

echo '<input type="button" value="couriers_detect" class="btn">' . 'detect courier by tracking number' . '</br>';
if ($request_all || $action == 'couriers_detect') {
	p($couriers->detect('1ZV90R483A33906706'));
}


$trackings = new AfterShip\Trackings($api_key);
echo '<h1>Trackings</h1>';
echo '<input type="button" value="trackings_create" class="btn">' . 'create tracking' . '</br>';
if ($request_all || $action == 'trackings_create') {
	p($trackings->create('2254095771'));
}

/*
echo '<input type="button" value="couriers_get" class="btn">'.'batch create'.'</br>';
if ($request_all || $action == 'couriers_get'){
p($trackings->batch_create(array('1ZV90R483A33906706')));
}
*/

echo '<input type="button" value="trackings_delete" class="btn">' . 'delete tracking' . '</br>';
if ($request_all || $action == 'trackings_delete') {
	p($trackings->delete('ups', '1ZV90R483A33906706'));
}

echo '<input type="button" value="trackings_delete_by_id" class="btn">' . 'delete tracking by id' . '</br>';
if ($request_all || $action == 'trackings_delete_by_id') {
	p($trackings->delete_by_id('53df4d66868a6df243b6f882'));
}

echo '<input type="button" value="trackings_get_all" class="btn">' . 'get all trackings' . '</br>';
if ($request_all || $action == 'trackings_get_all') {
	p($trackings->get_all(array(
		'slug' => 'dhl',
		'fields' => 'title,order_id,message,country_name'
	)));
}

echo '<input type="button" value="trackings_get" class="btn">' . 'get a tracking' . '</br>';
if ($request_all || $action == 'trackings_get') {
	p($trackings->get('dhl', '2254095771'));
}

echo '<input type="button" value="trackings_get_by_id" class="btn">' . 'get a tracking by id' . '</br>';
if ($request_all || $action == 'trackings_get_by_id') {
	p($trackings->get_by_id('53df4a90868a6df243b6efd8', array(
		'fields' => 'customer_name'
	)));
}


echo '<input type="button" value="trackings_update" class="btn">' . 'update a tracking' . '</br>';
if ($request_all || $action == 'trackings_update') {
	p($trackings->update('ups', '1ZV90R483A33906706', array(
		'title' => 'haha'
	)));
}

echo '<input type="button" value="trackings_update_by_id" class="btn">' . 'update a tracking by id' . '</br>';
if ($request_all || $action == 'trackings_update_by_id') {
	p($trackings->update_by_id('53df4a90868a6df243b6efd8'), array(
		'title' => 'T1',
		'customer_name' => 'Sunny'
	));
}


echo '<input type="button" value="trackings_retrack" class="btn">' . 'retrack a tracking' . '</br>';
if ($request_all || $action == 'trackings_retrack') {
	p($trackings->retrack('dhl', '2254095771'));
}

echo '<input type="button" value="trackings_retrack_by_id" class="btn">' . 'retrack a tracking by id' . '</br>';
if ($request_all || $action == 'trackings_retrack_by_id') {
	p($trackings->retrack_by_id('53df4a90868a6df243b6efd8'));
}


$last_check_point = new AfterShip\LastCheckPoint($api_key);
echo '<h1>Last Check Point</h1>';
echo '<input type="button" value="last_check_point_get" class="btn">' . 'get' . '</br>';
if ($request_all || $action == 'last_check_point_get') {
	p($last_check_point->get('dhl', '2254095771'));
}

echo '<input type="button" value="last_check_point_get_by_id" class="btn">' . 'get by id' . '</br>';
if ($request_all || $action == 'last_check_point_get_by_id') {
	p($last_check_point->get_by_id('53df4a90868a6df243b6efd8', array(
		'fields' => 'city,zip,state'
	)));
}

echo '</form>';
?>
</body>
</html>