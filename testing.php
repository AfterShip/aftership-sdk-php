<?php
/**
 * Created by PhpStorm.
 * User: sunny chow
 * Date: 4/8/14
 * Time: 1:05 PM
 */
?>

<html>
<head>
<title>HI</title>
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script type="text/javascript">
$(function(){
	//$( ".response" ).hide();
	$(".link").click(function(){
		$(this).next().toggle();
	}).css('cursor', 'pointer');
});
</script>
</head>

<body>
<?
echo 'start ';
$api_key = '56d415ae-a358-4bd6-ae5d-fcea547f5a8a';
echo $api_key;
print '</br>';
print '</br>';


include_once('vendor/autoload.php');

function p($arr){
	print '<div class="link">Show/Hide</div>';
	print '<div class="response">';
	print '<pre style="width: 800px; height: 20pc; overflow-y: scroll; background-color:#CCCCCC">';
	print_r($arr);
	print '</pre>';
	print '</div>';
	print '</br>';
}

/*
$couriers = new AfterShip\Couriers($api_key);
echo '<h1>Couriers</h1>';
echo 'get user\'s couriers';
print '</br>';
p($couriers->get());

echo 'get all couriers';
print '</br>';
p($couriers->get_all());

echo 'detect courier by tracking number';
print '</br>';
p($couriers->detect('1ZV90R483A33906706'));
*/

/*
$trackings = new AfterShip\Trackings($api_key);
echo '<h1>Trackings</h1>';
echo 'create tracking';
print '</br>';
p($trackings->create('2254095771'));

echo 'batch create';
print '</br>';
p($trackings->batch_create(array('1ZV90R483A33906706')));


echo 'delete tracking';
print '</br>';
p($trackings->delete('ups', '1ZV90R483A33906706'));

echo 'delete tracking by id';
print '</br>';
p($trackings->delete_by_id('53df4d66868a6df243b6f882'));


echo 'get all trackings';
print '</br>';
p($trackings->get_all(array(
	'slug' => 'dhl',
	'fields' => 'title,order_id,message,country_name'
)));

echo 'get a tracking';
print '</br>';
p($trackings->get('dhl', '2254095771'));


echo 'get a tracking by id';
print '</br>';
p($trackings->get_by_id('53df4a90868a6df243b6efd8', array(
	'fields' => 'customer_name'
)));



echo 'update a tracking';
print '</br>';
p($trackings->update('ups', '1ZV90R483A33906706', array(
	'title' => 'haha'
)));

echo 'update a tracking by id';
print '</br>';
p($trackings->update_by_id('53df4a90868a6df243b6efd8'), array(
	'title' => 'T1',
	'customer_name' => 'Sunny'
));


echo 'retrack a tracking';
print '</br>';
p($trackings->retrack('dhl', '2254095771'));


echo 'retrack a tracking by id';
print '</br>';
p($trackings->retrack_by_id('53df4a90868a6df243b6efd8'));
*/


$last_check_point = new AfterShip\LastCheckPoint($api_key);
echo '<h1>Last Check Point</h1>';
echo 'get';
print '</br>';
p($last_check_point->get('dhl', '2254095771'));

echo 'get by id';
print '</br>';
p($last_check_point->get_by_id('53df4a90868a6df243b6efd8', array(
	'fields' => 'city,zip,state'
)));

?>
</body>
</html>