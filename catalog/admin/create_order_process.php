<?php
/*
  $Id: account_edit_process.php,v 1.2 2002/11/28 23:39:44 wilt Exp $
  Update by Dr.Rolex - 2014-05-11

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require_once('includes/functions/password_funcs.php');

  #Define Tables to Variables
  $tablename_c = TABLE_CUSTOMERS;
  $tablename_ci = TABLE_CUSTOMERS_INFO;
  $tablename_z = TABLE_ZONES;

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS);

  $customers_id = (empty($_POST['customers_id']) ? 0 : (int)$_POST['customers_id']);
  $gender = $_POST['customers_gender'];
  $firstname = $_POST['customers_firstname'];
  $lastname = $_POST['customers_lastname'];
  $dob = $_POST['customers_dob'];
  $email_address = $_POST['customers_email_address'];
  $telephone = $_POST['customers_telephone'];
  $fax = $_POST['customers_fax'];
  $newsletter = $_POST['newsletter'];
  $confirmation = $_POST['confirmation'];
  $street_address = $_POST['entry_street_address'];
  $company = $_POST['entry_company'];
  $suburb = $_POST['entry_suburb'];
  $postcode = $_POST['entry_postcode'];
  $city = $_POST['entry_city'];
  $zone_id = (empty($_POST['zone_id']) ? 0 : $_POST['zone_id']) ;
  $state = $_POST['entry_state'];
  $country =  tep_get_country_name($_POST['entry_country']);
  $country_id = (int)$_POST['entry_country'];
  $customers_newsletter = $_POST['customers_newsletter'];
  $customers_password = $_POST['customers_password'];
  $payment_method = $_POST['payment'];
  $shipping_method = $_POST['shipping'];

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

// load selected payment module
  $dir = getcwd();
  chdir("../");
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment_method);
  $payment_method = $payment_modules->selection()[0]['module'];

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping_method);
  $shipping_cost = $shipping_modules->quote($shipping_method)[0]['methods'][0]['cost'];
  chdir($dir);

  $format_id = tep_get_address_format_id($country_id);
  $size = "1";
  //$payment_method = DEFAULT_PAYMENT_METHOD;
  $new_value = "1";
  $error = false; // reset error flag

  $currency_text = DEFAULT_CURRENCY . ", 1";
  if(isset($_POST['Currency']))
  {
  	$currency_text = $_POST['Currency'];
  }

  $currency_array = explode(",", $currency_text);

  $currency = $currency_array[0];
  $currency_value = $currency_array[1];

  //$customer_service_id = tep_db_prepare_input($_POST['cust_service']);

  // we are creating a customer account for this one
  if ($_POST['customers_create_type'] == 'new') {

    $inuse_query = mysqli_prepared_query("SELECT customers_id, customers_email_address FROM $tablename_c WHERE customers_email_address = ?", "s", array($email_address));
	if (count($inuse_query)) {
	    tep_redirect(tep_href_link(FILENAME_CREATE_ORDER, 'Customer=' . $inuse_query['customers_id'] . '&cust_select_button=Select&message='. urlencode(TEXT_EMAIL_EXISTS_ERROR), 'SSL'));
	}

    // do customers table entry
	$sql_data_array = array('customers_firstname' => $firstname,
							'customers_lastname' => $lastname,
							'customers_email_address' => $email_address,
							'customers_telephone' => $telephone,
							'customers_fax' => $fax,
							'customers_newsletter' => $customers_newsletter);

	if (!empty($customers_password)) $sql_data_array['customers_password'] = tep_encrypt_password($customers_password);
	if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
	if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);

	tep_db_prepared_perform(TABLE_CUSTOMERS, $sql_data_array);

    $customers_id = tep_db_insert_id();

	// do customers info entry
	$sql_data_array = array('customers_info_id' => $customers_id,
							'customers_info_number_of_logons' => 0,
							'global_product_notifications' => 0);

	tep_db_prepared_perform(TABLE_CUSTOMERS_INFO, $sql_data_array);

	mysqli_prepared_query("UPDATE $tablename_ci SET customers_info_date_account_created = now() WHERE customers_info_id = ?", "i", array($customers_id));

	// do address book entry
	$sql_data_array = array('customers_id' => (int)$customers_id,
							'entry_firstname' => $firstname,
							'entry_lastname' => $lastname,
							'entry_street_address' => $street_address,
							'entry_postcode' => $postcode,
							'entry_city' => $city,
							'entry_country_id' => $country_id);

	if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
	if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
	if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;

	if (ACCOUNT_STATE == 'true') {
	  $zone_query = mysqli_prepared_query("SELECT zone_id FROM $tablename_z WHERE zone_country_id = ? AND zone_name = ?", "is", array($country_id, $state));
	  if (count($zone_query)) {
		$zone = $zone_query[0];
		$zone_id = $zone['zone_id'];
	  }

	  if ($zone_id > 0) {
		$sql_data_array['entry_zone_id'] = $zone_id;
		$sql_data_array['entry_state'] = '';
	  } else {
		$sql_data_array['entry_zone_id'] = '0';
		$sql_data_array['entry_state'] = $state;
	  }
	}

	tep_db_prepared_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

	$default_address_id = tep_db_insert_id();

	mysqli_prepared_query("UPDATE $tablename_c SET customers_default_address_id = ? WHERE customers_id = ?", "ii", array($default_address_id, $customers_id));

  }


    $sql_data_array = array('customers_id' => $customers_id,
							'customers_name' => $firstname . ' ' . $lastname,
							'customers_company' => $company,

							'customers_street_address' => $street_address,
							'customers_suburb' => $suburb,
							'customers_city' => $city,
							'customers_postcode' => $postcode,
							'customers_state' => $state,
							'customers_country' => $country,

							'customers_telephone' => $telephone,
                            'customers_email_address' => $email_address,
							'customers_address_format_id' => $format_id,
							'delivery_name' => $firstname . ' ' . $lastname,
							'delivery_company' => $company,
                            'delivery_street_address' => $street_address,
							'delivery_suburb' => $suburb,
							'delivery_city' => $city,
							'delivery_postcode' => $postcode,
							'delivery_state' => $state,
							'delivery_country' => $country,
							'delivery_address_format_id' => $format_id,
							'billing_name' => $firstname . ' ' . $lastname,
							'billing_company' => $company,
							'billing_street_address' => $street_address,
							'billing_suburb' => $suburb,
							'billing_city' => $city,
							'billing_postcode' => $postcode,
							'billing_state' => $state,
							'billing_country' => $country,
							'billing_address_format_id' => $format_id,
							'date_purchased' => 'now()',
							'orders_status' => DEFAULT_ORDERS_STATUS_ID,
							'currency' => $currency,
							'currency_value' => $currency_value,

							//'customer_service_id' => $customer_service_id,
							'payment_method' => $payment_method
							);

  //old
  tep_db_prepared_perform(TABLE_ORDERS, $sql_data_array);
  $insert_id = tep_db_insert_id();


  $sql_data_array = array('orders_id' => $insert_id,
                          'orders_status_id' => DEFAULT_ORDERS_STATUS_ID,
                          'date_added' => 'now()');
  tep_db_prepared_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

      if (defined('MODULE_ORDER_TOTAL_INSTALLED') && tep_not_null(MODULE_ORDER_TOTAL_INSTALLED)) {
        $order_total_modules = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
        $co_modules = array();
        $total = 0;

        foreach($order_total_modules as $key => $value) {
          include(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/order_total/' . $value);
          include(DIR_FS_CATALOG . DIR_WS_MODULES . 'order_total/' . $value);

          $class = substr($value, 0, strrpos($value, '.'));
          $co_modules[$class] = new $class;

          if ($co_modules[$class]->enabled) {

            if ( $co_modules[$class]->code == "ot_shipping" ) {
              $text = $currencies->format($shipping_cost, true, $currency, $currency_value);
              $value = $shipping_cost;
              $total += $value;
            } elseif ( $co_modules[$class]->code == "ot_total" ) {
              $text = '<strong>' . $currencies->format($total, true, $currency, $currency_value) . '</strong>';
              $value = $total;
            } else {
              $text = $currencies->format(0, true, $currency, $currency_value);
              $value = 0;
            }


			       $sql_data_array = array('orders_id' => $insert_id,
									'title' => $co_modules[$class]->title,
									'text' => $text,
									'value' => number_format($value, 4),
									'class' => $co_modules[$class]->code,
									'sort_order' => $co_modules[$class]->sort_order);
			       tep_db_prepared_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

          }
        }
      }

      if (isset($_POST['email_customer'])) {
        // lets start with the email confirmation

        include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_HANDLER);

        require_once(DIR_WS_CLASSES . 'order.php');
        $order = new order($insert_id);

        $email_order = STORE_NAME . "\n" . 
        EMAIL_SEPARATOR . "\n" . 
        EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
        EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false) . "\n" .
        EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";


        if (!isset($order->content_type)) $order->content_type = null;
        if ($order->content_type != 'virtual') {
          $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
          EMAIL_SEPARATOR . "\n" .
          tep_address_format($order->customer['format_id'], $order->delivery, 0, '', "\n") . "\n";
        }

        $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
        EMAIL_SEPARATOR . "\n" .
        tep_address_format($order->customer['format_id'], $order->billing, 0, '', "\n") . "\n\n";
        $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
        EMAIL_SEPARATOR . "\n";
        $email_order .= $order->info['payment_method'] . "\n\n";

        tep_mail($order->customer['name'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

      // send emails to other people
        if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
          tep_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
        }
      }

  tep_redirect(tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action', 'email_customer')) . 'oID=' . $insert_id . '&action=edit'));

?>