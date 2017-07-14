<?php
require( '../vendor/autoload.php' );

$action      = isset( $_GET['action'] ) ? $_GET['action'] : '';
$api_key     = isset( $_GET['api_key'] ) ? $_GET['api_key'] : '';
$request_all = ( $action == 'ALL' );

function presult( callable $func, $parse_json = true ) {
	try {
		$response = $func();
		// somehow if the array too large json_encode will break... so use print_r for walk-around
		$result   = $parse_json ? json_encode( $response, JSON_PRETTY_PRINT ) : print_r( $response, true );
	} catch ( Exception $e ) {
		$result = $e->getMessage();
	}
	?>
    <div class="response">
        <pre style="max-height: 400px"><code class="language-json"><?= ( $result ) ?></code></pre>
    </div>
	<?php
}

?>
<html>
<head>
    <title>Testing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/themes/prism.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/components/prism-json.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
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
<div class="jumbotron">
    <div class="container">
        <h1>
            AfterShip API PHP SDK Testing
        </h1>
        <h2>This is the official PHP SDK of AfterShip API. Provided by AfterShip</h2>
        <a href="mailto:support@aftership.com">support@aftership.com</a>
    </div>
</div>

<main class="container">
    <form action="testing.php" method="GET" id="form" class="form">
        <div class="form-group">
            <label for="api_key">API KEY:</label>
            <input value="<?= $api_key ?>" name="api_key" id="api_key" size="45" class="form-control"/>
            <div class="help-block">
                <a href="http://aftership.uservoice.com/knowledgebase/articles/401963">How to generate AfterShip API
                    Key?</a>
            </div>
        </div>
        <button type="submit" value="ALL" class="btn btn-primary">Request All</button>
        <div class="help-block"> ACTION: <?= $action ?></div>

		<?php if ( ! $api_key ): ?>
            <b class="text-danger">Please input API key first</b>
			<?php exit ?>
		<?php endif; ?>

        <hr>

        <input type="hidden" name="action" id="hidden"/>

		<?php
		$couriers         = new AfterShip\Couriers( $api_key );
		$trackings        = new AfterShip\Trackings( $api_key );
		$last_check_point = new AfterShip\LastCheckPoint( $api_key );
		$notifications    = new AfterShip\Notifications( $api_key );
		?>

        <h2>Couriers</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td style="width: 80px">Description</td>
                <td>Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>get user's couriers</td>
                <td>
                    <input type="button" value="couriers_get" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'couriers_get' ) {
						presult( function () use ( $couriers ) {
							return $couriers->get();
						}, false );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get all couriers</td>
                <td>
                    <input type="button" value="couriers_get_all" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'couriers_get_all' ) {
						presult( function () use ( $couriers ) {
							return $couriers->all();
						}, false );
					} ?>
                </td>
            </tr>
            <tr>
                <td>detect courier by tracking number</td>
                <td>
                    <input type="button" value="couriers_detect" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'couriers_detect' ) {
						presult( function () use ( $couriers ) {
							return $couriers->detect( '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            </tbody>
        </table>


        <h2>Trackings</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Description</td>
                <td>Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>create tracking</td>
                <td>
                    <input type="button" value="trackings_create" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_create' ) {
						presult( function () use ( $trackings ) {
							return $trackings->create( '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="button" value="trackings_delete" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_delete' ) {
						presult( function () use ( $trackings ) {
							return $trackings->delete( 'ups', '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>delete tracking by id</td>
                <td>
                    <input type="button" value="trackings_delete_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_delete_by_id' ) {
						presult( function () use ( $trackings ) {
							return $trackings->deleteById( '53df4d66868a6df243b6f882' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="button" value="trackings_get_all" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_get_all' ) {
						presult( function () use ( $trackings ) {
							return $trackings->all( [
								'slug'   => 'ups',
								'fields' => 'title,order_id,message,country_name'
							] );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get a tracking</td>
                <td>
                    <input type="button" value="trackings_get" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_get' ) {
						presult( function () use ( $trackings ) {
							return $trackings->get( 'ups', '1ZV90R483A33906705' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get a tracking by id</td>
                <td>
                    <input type="button" value="trackings_get_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_get_by_id' ) {
						presult( function () use ( $trackings ) {
							return $trackings->getById( '53df4a90868a6df243b6efd8' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>update a tracking</td>
                <td>
                    <input type="button" value="trackings_update" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_update' ) {
						presult( function () use ( $trackings ) {
							return $trackings->update( 'ups', '1ZV90R483A33906706', [
								'title' => 'haha'
							] );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>update a tracking by id</td>
                <td>
                    <input type="button" value="trackings_update_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'trackings_update_by_id' ) {
						presult( function () use ( $trackings ) {
							return $trackings->updateById( '53df4a90868a6df243b6efd8', [
								'title'         => 'T1',
								'customer_name' => 'Sunny'
							] );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>retrack a tracking</td>
                <td><input type="button" value="trackings_retrack" class="btn btn-primary"></td>
                <td>
					<?php if ( $request_all || $action == 'trackings_retrack' ) {
						presult( function () use ( $trackings ) {
							return $trackings->retrack( 'ups', '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>retrack a tracking by id</td>
                <td><input type="button" value="trackings_retrack_by_id" class="btn btn-primary"></td>
                <td>
					<?php if ( $request_all || $action == 'trackings_retrack_by_id' ) {
						presult( function () use ( $trackings ) {
							return $trackings->retrackById( '53df4a90868a6df243b6efd8' );
						} );
					} ?>
                </td>
            </tr>
            </tbody>
        </table>


        <h2>Last Check Point</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>Description</td>
                <td>Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>get</td>
                <td>
                    <input type="button" value="last_check_point_get" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'last_check_point_get' ) {
						presult( function () use ( $last_check_point ) {
							return $last_check_point->get( 'ups', '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get by id</td>
                <td>
                    <input type="button" value="last_check_point_get_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'last_check_point_get_by_id' ) {
						presult( function () use ( $last_check_point ) {
							return $last_check_point->getById( '53df4a90868a6df243b6efd8', [
								'fields' => 'city,zip,state'
							] );
						} );
					} ?>
                </td>
            </tr>
            </tbody>
        </table>

        <h2>Notifications</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td width="80">Description</td>
                <td>Action</td>
                <td>Response</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>create notification</td>
                <td>
                    <input type="button" value="notifications_create" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_create' ) {
						presult( function () use ( $notifications ) {
							return $notifications->create( 'ups', '1ZV90R483A33906706', [
								'emails' => [ 'youremail@yourdomain.com' ]
							] );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>create notification by id</td>
                <td>
                    <input type="button" value="notifications_create_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_create_by_id' ) {
						presult( function () use ( $notifications ) {
							return $notifications->createById( '53df4a90868a6df243b6efd8' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>delete notification</td>
                <td>
                    <input type="button" value="notifications_delete" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_delete' ) {
						presult( function () use ( $notifications ) {
							return $notifications->delete( 'ups', '1ZV90R483A33906706', [
								'emails' => [ 'youremail@yourdomain.com' ]
							] );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>delete notification by id</td>
                <td>
                    <input type="button" value="notifications_delete_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_delete_by_id' ) {
						presult( function () use ( $notifications ) {
							return $notifications->deleteById( '53df4d66868a6df243b6f882' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get a notification</td>
                <td>
                    <input type="button" value="notifications_get" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_get' ) {
						presult( function () use ( $notifications ) {
							return $notifications->get( 'ups', '1ZV90R483A33906706' );
						} );
					} ?>
                </td>
            </tr>
            <tr>
                <td>get a notification by id</td>
                <td>
                    <input type="button" value="notifications_get_by_id" class="btn btn-primary">
                </td>
                <td>
					<?php if ( $request_all || $action == 'notifications_get_by_id' ) {
						presult( function () use ( $notifications ) {
							return $notifications->getById( '53df4a90868a6df243b6efd8', [
								'fields' => 'customer_name'
							] );
						} );
					} ?>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</main>
</body>
</html>
