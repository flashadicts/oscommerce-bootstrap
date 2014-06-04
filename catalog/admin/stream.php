<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

  require('includes/application_top.php');

  $last_order_number = isset( $_GET['oID'] ) && !empty( $_GET['oID'] ) ? (int)$_GET['oID'] : null;
  $poll_timer = isset( $_GET['poll_timer'] ) && !empty( $_GET['poll_timer'] ) && is_numeric( $_GET['poll_timer'] ) ? (int)$_GET['poll_timer'] : 20;

  if( empty( $last_order_number ) || is_null($last_order_number) || !is_numeric($last_order_number) || !is_numeric($poll_timer) ){
    die( json_encode( array( 'status' => 'error' ) ) );
  }

  $query = "SELECT orders_id FROM orders WHERE orders_id > ? ORDER BY orders_id DESC LIMIT 1";

  for($i = 1; $i < 3; $i++) {
    $new_order_check = mysqli_prepared_query( $query, "i", array( $last_order_number ) );
    $num_rows = count( $new_order_check );
    if ( $num_rows >= 1 ) {
      $row = $new_order_check[0];
      //$_GET['oID'] = $row['orders_id'];
      header('Content-Type: text/html; charset=utf-8');
      $output = '<tr id="last_order_number" data-order="'.$row['orders_id'].'" style="display:none;"><td>' . $row['orders_id'] . '</td></tr>';
      include('order_poller.php');
      //die( json_encode( array( 'status' => 'results', 'oID' => $row['orders_id'] ) ) );
    }
    sleep($poll_timer);
  }

  header('Content-Type: application/json');
  die( json_encode( array( 'status' => 'no-results', 'oID' => $last_order_number ) ) );
?>