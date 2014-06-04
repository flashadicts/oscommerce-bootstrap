<?php
/*

	batch-invoice-printing-v1.1
	2004-12-18
	by PandA.nl
	Update by Dr.Rolex - 2014-05-11

	Modified by Dr. Rolex 2014-05-06

*/

	require('includes/application_top.php');

	require(DIR_WS_CLASSES . 'currencies.php');

	$target_file = $_POST['target_file'];
	$autoupdatestatus = $_POST['autoupdatestatus'];
	$notify = $_POST['notify'];
	$autostatus = $_POST['autostatus'];

	#Define Tables to Variables
	$tablename_o = TABLE_ORDERS;
	$tablename_ot = TABLE_ORDERS_TOTAL;
	$tablename_c = TABLE_COUNTRIES;
	$tablename_osh = TABLE_ORDERS_STATUS_HISTORY;


	unset($batch_order_numbers);
	if($_POST['batch_order_numbers']){
		foreach($_POST['batch_order_numbers'] as $order_number => $print_order) {
			$batch_order_numbers[] = $order_number;
		}
	}

	#Begin error handling
	if (!(is_array($batch_order_numbers)) && !isset($HTTP_POST_VARS['order_nums'])){
		tep_session_close();
		exit('Error: no orders selected!&nbsp;&nbsp;<A href="javascript: self.close ()">Close this Window</A>');
	} else if (isset($HTTP_POST_VARS['batch_delete_x']) || isset($HTTP_POST_VARS['batch_delete_y'])) {
		include(DIR_WS_LANGUAGES . $language . '/order_handler.php');
		if (isset($HTTP_POST_VARS['batch_confirm_x']) || isset($HTTP_POST_VARS['batch_confirm_y'])) {
			include('oc_batch_delete.php');
			die;
		} else {
			include('oc_batch_delete_confirm.php');
			die;
		}
	}
	#End error handling

	include(DIR_WS_CLASSES . 'order_prepared.php');
	$order = new order();

	//sort($batch_order_numbers);

	if($target_file == 'export') {

		#Export to XML
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: text/xml');
		header('Content-Disposition: attachment; filename="'.date('Ymdhis').'.xml"');
		$buffer[] = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
		$buffer[] = '<your_shipping_here>'."\r\n";
		foreach ($batch_order_numbers as $order_id) {
			if($order_id != "null")
			{
				$db_get = "SELECT o.orders_id,o.customers_id,o.customers_name,o.payment_method,o.delivery_name,o.delivery_company,o.delivery_street_address,o.delivery_suburb,o.delivery_city,o.delivery_postcode,o.delivery_state,o.delivery_country,o.customers_telephone,o.customers_email_address,ot.value,c.countries_iso_code_2 FROM $tablename_o o, $tablename_ot ot, $tablename_c c WHERE (o.orders_id = ot.orders_id AND ot.class = 'ot_total') AND (o.orders_id = ? AND o.delivery_country = c.countries_name) ORDER BY orders_id DESC LIMIT 1";
				$db_res = mysqli_prepared_query($db_get, "i", array($order_id));
				$db_ary = $db_res[0];
				$buffer[] = "\t".'<receiver rcvid="'.$db_ary['orders_id'].'">'."\r\n";
				$buffer[] = "\t\t".'<val n="name">'.$db_ary['delivery_name'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="address1">'.$db_ary['delivery_street_address'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="address2">'.$db_ary['delivery_suburb'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="zipcode">'.$db_ary['delivery_postcode'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="city">'.$db_ary['delivery_city'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="country">'.$db_ary['countries_iso_code_2'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="contact">'.$db_ary['customers_name'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="phone">'.$db_ary['customers_telephone'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="email">'.$db_ary['customers_email_address'].'</val>'."\r\n";
				$buffer[] = "\t\t".'<val n="sms">'.$db_ary['customers_telephone'].'</val>'."\r\n";
				$buffer[] = '</val>'."\r\n";
				$buffer[] = "\t\t".'</container>'."\r\n";
				$buffer[] = "\t".'</shipment>'."\r\n";
			}
		}
		$buffer[] = '</your_shipping_here>'."\r\n";
		die( implode('',$buffer) );

	}

  #Connect
  $link = "db_link";
  global $$link;

  #SQL Query
  $tablename_op    = TABLE_ORDERS_PRODUCTS;
  $tablename_opa   = TABLE_ORDERS_PRODUCTS_ATTRIBUTES;
  $sql_se 				 = "SELECT orders_status_id, date_added, customer_notified, comments FROM $tablename_osh WHERE orders_id = ? ORDER BY date_added";
  $sql_o           = "SELECT customers_name, customers_company, customers_street_address, customers_suburb, customers_city, customers_postcode, customers_state, customers_country, customers_telephone, customers_email_address, customers_address_format_id, delivery_name, delivery_company, delivery_street_address, delivery_suburb, delivery_city, delivery_postcode, delivery_state, delivery_country, delivery_address_format_id, billing_name, billing_company, billing_street_address, billing_suburb, billing_city, billing_postcode, billing_state, billing_country, billing_address_format_id, payment_method, cc_type, cc_owner, cc_number, cc_expires, currency, currency_value, date_purchased, orders_status, last_modified FROM $tablename_o WHERE orders_id = ?";
  $sql_ot         = "SELECT title, text, value, class FROM $tablename_ot WHERE orders_id = ? ORDER BY sort_order";
  $sql_op         = "SELECT orders_products_id, products_name, products_model, products_price, products_tax, products_quantity, final_price FROM $tablename_op WHERE orders_id = ?";
  $sql_opa        = "SELECT products_options, products_options_values, options_values_price, price_prefix FROM $tablename_opa WHERE orders_id = ? AND orders_products_id = ?";

   // Kiss Error Debugger
   /*$start_time_o = microtime( true );
   $start_time_ot = microtime( true );
   $start_time_op = microtime( true );
   $start_time_opa = microtime( true );*/

   #Create the prepared statement
   $stmt_se       = $$link->prepare($sql_se);
   $stmt_o        = $$link->prepare($sql_o);
   $stmt_ot       = $$link->prepare($sql_ot);
   $stmt_op       = $$link->prepare($sql_op);
   $stmt_opa      = $$link->prepare($sql_opa);

   #Error checking the prepared statement
   if ( false === $stmt_se )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the SELECT statement failed: ' . htmlspecialchars($mysqli->error) ) ) );
   }
   if ( false === $stmt_o )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the ORDERS statement failed: ' . htmlspecialchars($mysqli->error) ) ) );
   }
   if ( false === $stmt_ot )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the ORDERS_TOTAL statement failed: ' . htmlspecialchars($mysqli->error) ) ) );
   }
   if ( false === $stmt_op )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the ORDERS_PRODUCTS statement failed: ' . htmlspecialchars($mysqli->error) ) ) );
   }
   if ( false === $stmt_opa )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the TABLE_ORDERS_PRODUCTS_ATTRIBUTES statement failed: ' . htmlspecialchars($mysqli->error) ) ) );
   }


   #Bind parameters to the query
   $bp_se 				 = $stmt_se->bind_param("i", $order_id);
   $bp_o           = $stmt_o->bind_param("i", $order_id);
   $bp_ot          = $stmt_ot->bind_param("i", $order_id);
   $bp_op          = $stmt_op->bind_param("i", $order_id);
   $bp_opa         = $stmt_opa->bind_param("ii", $order_id, $orders_products['orders_products_id']);


   #Error checking for binded parameters
   if ( false === $bp_se )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for SELECT failed: ' . htmlspecialchars($stmt_se->error) ) ) );
   }
   if ( false === $bp_o )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for ORDERS failed: ' . htmlspecialchars($stmt_o->error) ) ) );
   }
   if ( false === $bp_ot )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for ORDERS_TOTAL failed: ' . htmlspecialchars($stmt_o->error) ) ) );
   }
   if ( false === $bp_op )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for ORDERS_PRODUCTS failed: ' . htmlspecialchars($stmt_op->error) ) ) );
   }
   if ( false === $bp_opa )        {
   	die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for TABLE_ORDERS_PRODUCTS_ATTRIBUTES failed: ' . htmlspecialchars($stmt_opa->error) ) ) );
   }


	if($target_file == 'labels') {

		#Create CSV for Envelope
		header ('Content-type: application/csv');
		header ('Content-Disposition: inline; filename="customers.csv"');

		echo "Name;Street address;Postcode;City;Country\n";

		foreach ($batch_order_numbers as $order_id) {
			$order->query($order_id);

			echo "" . $order->delivery['name'] . ";" . $order->delivery['street_address'] . ";" . $order->delivery['postcode'] . ";" . $order->delivery['city'] . ";" . $order->delivery['country'] . "\n";
		}

	} else {

		?>
		<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html <?php echo HTML_PARAMS; ?>>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
			<meta name="robots" content="noindex,nofollow">
			<title><?php echo TITLE . $autostatus; ?></title>
			<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/jquery-2.1.0.min.js'); ?>"></script>
		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<div id="ajax_loader" style="display:block;">
  <div id="loader_content">
    <div class="circle"></div>
    <div class="circle1"></div>

    <div class="progress progress-striped active">
      <div class="progress-bar" id="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        <span class="" style="color: rgb(255, 255, 255);font-weight: 400;">0 Updated</span>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$( ".progress" ).show();
</script>
			<?php
			$firstinvoice=1;
			$invoice = 0;
			$total_invoices = count($batch_order_numbers);

			#Let's iterate the Invoices
			foreach ($batch_order_numbers as $order_id) {
				if($firstinvoice) {
					$firstinvoice = 0;
				} else {
					echo '<br style="page-break-before:always;">';
				}

				$invoice++;
				include('print_batch_invoice.php');
			}

			?>
<script type="text/javascript">
$(function(){
	$( "#ajax_loader" ).remove();
});

</script>
		</BODY></HTML>
		<?php
	}

	#Close open connections
	$stmt_se->close();
	$stmt_o->close();
	$stmt_ot->close();
	$stmt_op->close();
	$stmt_opa->close();

  #Kiss Error Debugger
	/*if ( class_exists( 'KissER' ) ) {
  		KissER::q( round( ( microtime( true ) - $start_time_o ), 4 ), $sql_o );
      KissER::q( round( ( microtime( true ) - $start_time_ot ), 4 ), $sql_ot );
      KissER::q( round( ( microtime( true ) - $start_time_op ), 4 ), $sql_op );
      KissER::q( round( ( microtime( true ) - $start_time_opa ), 4 ), $sql_opa );
    }*/

	require(DIR_WS_INCLUDES . 'application_bottom.php');
	?>