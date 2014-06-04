<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

	require('includes/application_top.php');
	include(DIR_WS_LANGUAGES . $language . '/order_handler.php'); 

	$action = (isset($_GET['action']) ? $_GET['action'] : '');

  if ($action == "duplicate_order" || $action == "mail_confirmation") {
    require(DIR_WS_CLASSES . 'currencies.php');
    $currencies = new currencies();

    include(DIR_WS_CLASSES . 'order.php');
    $oID = (int)$_GET['get_order'];
    $customer_id = (int)$_GET['cID'];
    $order = new order($oID);

    #Define Tables to Variables
    $tablename_o = TABLE_ORDERS;
    $tablename_ot = TABLE_ORDERS_TOTAL;
    $tablename_p = TABLE_PRODUCTS;
    $tablename_a = TABLE_PRODUCTS_ATTRIBUTES;
    $tablename_ad = TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD;
    $tablename_op = TABLE_ORDERS_PRODUCTS;
    $tablename_po = TABLE_PRODUCTS_OPTIONS;
    $tablename_pov = TABLE_PRODUCTS_OPTIONS_VALUES;
    $tablename_opd = TABLE_ORDERS_PRODUCTS_DOWNLOAD;


    #Error Handling
    if (!is_numeric($oID) || !is_numeric($customer_id) || is_null($order->customer['format_id'])) {
      $message = "";
      if (!is_numeric($oID)) $message .= "Not a numeric order number.<br>" . "\n";
      if (!is_numeric($customer_id)) $message .= "Not a numeric customer ID.<br>" . "\n";
      if (is_null($order->customer['format_id'])) $message .= "Order does not exist.";
      header('Content-Type: application/json');
      die( json_encode( array( 'status' => 'error', 'message' => $message ) ) );
    }

    if ($action != "mail_confirmation") {

    #Start Order Duplication
    $sql_data_array = array('customers_id' => $customer_id,
      'customers_name' => $order->customer['name'],
      'customers_company' => $order->customer['company'],
      'customers_street_address' => $order->customer['street_address'],
      'customers_suburb' => $order->customer['suburb'],
      'customers_city' => $order->customer['city'],
      'customers_postcode' => $order->customer['postcode'], 
      'customers_state' => $order->customer['state'], 
      'customers_country' => $order->customer['country'], 
      'customers_telephone' => $order->customer['telephone'], 
      'customers_email_address' => $order->customer['email_address'],
      'customers_address_format_id' => $order->customer['format_id'], 
      'delivery_name' => trim($order->delivery['name']),
      'delivery_company' => $order->delivery['company'],
      'delivery_street_address' => $order->delivery['street_address'], 
      'delivery_suburb' => $order->delivery['suburb'], 
      'delivery_city' => $order->delivery['city'], 
      'delivery_postcode' => $order->delivery['postcode'], 
      'delivery_state' => $order->delivery['state'], 
      'delivery_country' => $order->delivery['country'], 
      'delivery_address_format_id' => $order->delivery['format_id'], 
      'billing_name' => $order->billing['name'],
      'billing_company' => $order->billing['company'],
      'billing_street_address' => $order->billing['street_address'], 
      'billing_suburb' => $order->billing['suburb'], 
      'billing_city' => $order->billing['city'], 
      'billing_postcode' => $order->billing['postcode'], 
      'billing_state' => $order->billing['state'], 
      'billing_country' => $order->billing['country'], 
      'billing_address_format_id' => $order->billing['format_id'], 
      'payment_method' => $order->info['payment_method'], 
      'cc_type' => $order->info['cc_type'], 
      'cc_owner' => $order->info['cc_owner'], 
      'cc_number' => $order->info['cc_number'], 
      'cc_expires' => $order->info['cc_expires'], 
      'date_purchased' => 'now()', 
      'orders_status' => '1', 
      'currency' => $order->info['currency'], 
      'currency_value' => $order->info['currency_value']);
tep_db_prepared_perform(TABLE_ORDERS, $sql_data_array);

$insert_id = tep_db_insert_id();
for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  $sql_data_array = array('orders_id' => $insert_id,
    'title' => $order->totals[$i]['title'],
    'text' => $order->totals[$i]['text'],
    'value' => $order->totals[$i]['value'], 
    'class' => $order->totals[$i]['class'], 
    'sort_order' => $i);
  tep_db_prepared_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
}

$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
$sql_data_array = array('orders_id' => $insert_id, 
  'orders_status_id' => '1', 
  'date_added' => 'now()', 
  'customer_notified' => $customer_notification);
tep_db_prepared_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

// initialized for the email confirmation
$products_ordered = '';

for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
// Stock Update - Joao Correia
  if (STOCK_LIMITED == 'true') {
    if (DOWNLOAD_ENABLED == 'true') {
      $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename 
      FROM $tablename_p p
      LEFT JOIN $tablename_a pa
      ON p.products_id=pa.products_id
      LEFT JOIN $tablename_pad pad
      ON pa.products_attributes_id=pad.products_attributes_id
      WHERE p.products_id = ?";
      $params[] = tep_get_prid($order->products[$i]['id']);
      $typeDef = 'i';
// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
      $products_attributes = (isset($order->products[$i]['attributes'])) ? $order->products[$i]['attributes'] : '';
      if (is_array($products_attributes)) {
        $stock_query_raw .= " AND pa.options_id = ? AND pa.options_values_id = '" . (int)$products_attributes[0]['value_id'] . "'";
        $params[] = $products_attributes[0]['option_id'];
        $typeDef .= 'i';
      }
      $stock_query = mysqli_prepared_query($stock_query_raw, $typeDef, $params);
    } else {
      $stock_query = mysqli_prepared_query("SELECT products_quantity FROM $tablename_p WHERE products_id = ?", "i", array(tep_get_prid($order->products[$i]['id'])));
    }
    if (count($stock_query) > 0) {
      $stock_values = $stock_query[0];
// do not decrement quantities if products_attributes_filename exists
      if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
        $stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
      } else {
        $stock_left = $stock_values['products_quantity'];
      }
      mysqli_prepared_query("UPDATE $tablename_p SET products_quantity = ? WHERE products_id = ?", "ii", array($stock_left, tep_get_prid($order->products[$i]['id'])));
      if ( ($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false') ) {
        mysqli_prepared_query("UPDATE $tablename_p SET products_status = '0' WHERE products_id = ?", "i", array(tep_get_prid($order->products[$i]['id'])));
      }
    }
  }

// Update products_ordered (for bestsellers list)
  mysqli_prepared_query("UPDATE $tablename_p SET products_ordered = products_ordered + ? WHERE products_id = ?", "ii", array(sprintf('%d', $order->products[$i]['qty']), tep_get_prid($order->products[$i]['id'])));

  $sql_data_array = array('orders_id' => $insert_id, 
    'products_id' => tep_get_prid($order->products[$i]['id']), 
    'products_model' => $order->products[$i]['model'], 
    'products_name' => $order->products[$i]['name'], 
    'products_price' => $order->products[$i]['price'], 
    'final_price' => $order->products[$i]['final_price'], 
    'products_tax' => $order->products[$i]['tax'], 
    'products_quantity' => $order->products[$i]['qty']);
  tep_db_prepared_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
  $order_products_id = tep_db_insert_id();

//------insert customer choosen option to order--------
  $attributes_exist = '0';
  $products_ordered_attributes = '';
  if (isset($order->products[$i]['attributes'])) {
    $attributes_exist = '1';
    for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

      $sql_data_array = array('orders_id' => $insert_id, 
        'orders_products_id' => $order_products_id, 
        'products_options' => $order->products[$i]['attributes'][$j]['option'],
        'products_options_values' => $order->products[$i]['attributes'][$j]['value'], 
        'options_values_price' => $order->products[$i]['attributes'][$j]['price'], 
        'price_prefix' => $order->products[$i]['attributes'][$j]['prefix']);
      tep_db_prepared_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

      if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
        $sql_data_array = array('orders_id' => $insert_id, 
          'orders_products_id' => $order_products_id, 
          'orders_products_filename' => $attributes_values['products_attributes_filename'], 
          'download_maxdays' => $attributes_values['products_attributes_maxdays'], 
          'download_count' => $attributes_values['products_attributes_maxcount']);
        tep_db_prepared_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
      }
      $products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
    }
  }

//------insert customer choosen option eof ----
  $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
}

}

if ($action == "mail_confirmation") {
  $products_ordered = '';
  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    //------insert customer choosen option to order--------
  $attributes_exist = '0';
  $products_ordered_attributes = '';
  if (isset($order->products[$i]['attributes'])) {
    $attributes_exist = '1';
    for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
      if (DOWNLOAD_ENABLED == 'true') {
        $attributes_query = "SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename 
        FROM $tablename_po popt, $tablename_pov poval, $tablename_a pa 
        LEFT JOIN $tablename_pad pad
        ON pa.products_attributes_id=pad.products_attributes_id
        WHERE pa.products_id = ? 
        AND pa.options_id = ? 
        AND pa.options_id = popt.products_options_id 
        AND pa.options_values_id = ? 
        AND pa.options_values_id = poval.products_options_values_id 
        AND popt.language_id = ? 
        AND poval.language_id = ?";
        $params = array((int)$order->products[$i]['id'], (int)$order->products[$i]['attributes'][$j]['option_id'], (int)$order->products[$i]['attributes'][$j]['value_id'], (int)$languages_id, (int)$languages_id);
        $attributes = mysqli_prepared_query($attributes_query, "iiiii", $params);
      } else {
        $attributes = mysqli_prepared_query("SELECT popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix FROM $tablename_po popt, $tablename_pov poval, $tablename_a pa WHERE pa.products_id = ? AND pa.options_id = ? AND pa.options_id = popt.products_options_id AND pa.options_values_id = ? AND pa.options_values_id = poval.products_options_values_id AND popt.language_id = ? AND poval.language_id = ?", "iiiii", array((int)$order->products[$i]['id'], (int)$order->products[$i]['attributes'][$j]['option_id'], (int)$order->products[$i]['attributes'][$j]['value_id'], (int)$languages_id, (int)$languages_id));
      }
      $attributes_values = $attributes[0];

      $sql_data_array = array('orders_id' => $insert_id, 
        'orders_products_id' => $order_products_id, 
        'products_options' => $attributes_values['products_options_name'],
        'products_options_values' => $attributes_values['products_options_values_name'], 
        'options_values_price' => $attributes_values['options_values_price'], 
        'price_prefix' => $attributes_values['price_prefix']);
      tep_db_prepared_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

      if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
        $sql_data_array = array('orders_id' => $insert_id, 
          'orders_products_id' => $order_products_id, 
          'orders_products_filename' => $attributes_values['products_attributes_filename'], 
          'download_maxdays' => $attributes_values['products_attributes_maxdays'], 
          'download_count' => $attributes_values['products_attributes_maxcount']);
        tep_db_prepared_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
      }
      $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
    }
  }

    $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
  }
}

// lets start with the email confirmation

if (!isset($insert_id)) $insert_id = (int)$_GET['get_order'];

$email_order = STORE_NAME . "\n" . 
EMAIL_SEPARATOR . "\n" . 
EMAIL_TEXT_ORDER_NUMBER . ' ' . $insert_id . "\n" .
EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false) . "\n" .
EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";

$email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
EMAIL_SEPARATOR . "\n" . 
$products_ordered . 
EMAIL_SEPARATOR . "\n";

for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
  $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
}

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

    if ($action == "mail_confirmation") {
      $message = "Order Confirmation mailed to " . trim($order->delivery['name']) . ".";
    } else {
      $message = "New order created for customer " . trim($order->delivery['name']) . " with order number " . $insert_id . ".";
    }

    header('Content-Type: application/json');
    die( json_encode( array( 'status' => 'success', 'message' => $message ) ) );
  }

  if ($action == "get_order") {
    include(DIR_WS_CLASSES . 'order.php');
    $oID = (int)tep_db_prepare_input($_GET['get_order']);
    $order = new order($oID);

    if (!is_numeric($oID) || is_null($order->customer['format_id'])) {
      $message = "Error<br>" . "\n";
      if (!is_numeric($oID)) $message .= "Not a numeric order number.<br>" . "\n";
      if (is_null($order->customer['format_id'])) $message .= "Order does not exist.";
      die( $message );
    }

    require(DIR_WS_CLASSES . 'currencies.php');
    $currencies = new currencies();
    ?>
<div id="ajax-cart-body">
  <div id="ajax_cart_top"><h2>Quick Order Editor<button type="button" class="closeWindow close">×</button></h2></div>
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="ui-widget-content infoBoxContents" id="boxcart-content-table">
<tr id="new_row">
  <td class="main" valign="top" style="">
    <table cellpadding="5" width="100%">
      
      <tr>
            <td align="left" width="50%"><table id="productTotals"><tr><td><table border="0" cellspacing="0" cellpadding="2" align="left" width="100%">
              <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="3"><?php echo sprintf(TABLE_HEADING_PRODUCTS, $oID); ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
              <?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="left" width="3%"><a data-product="' . $order->products[$i]['id'] . '" data-field="" data-action="eliminate" data-extra="" data-pred="" href="#" class="ajaxLinkProduct">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td><td width="10px" align="left"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_quantity" data-action="update" data-extra="" data-pred="'.$order->products[$i]['qty'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['qty'] . '&nbsp;x</a></td>' . "\n" .
     '            <td class="dataTableContent" valign="top">' . 
           '<a data-product="' . $order->products[$i]['id'] . '" data-field="products_name" data-action="update" data-extra="" data-pred="'.$order->products[$i]['name'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['name'] . '</a>';

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br><nobr><small>&nbsp;<i> - <a data-product="' . $order->products[$i]['id'] . '" data-field="options" data-action="update" data-extra="' . $order->products[$i]['attributes'][$j]['option'] . '" data-pred="'.$order->products[$i]['option'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          echo '</a></i></small></nobr>';
        }
      }

      echo '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_model" data-action="update" data-extra="" data-pred="'.$order->products[$i]['model'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['model'] . '</a></td>' . "\n" .
           '            <td class="dataTableContent tax" data-tax="'.(float)tep_display_tax_value($order->products[$i]['tax']).'" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_excl" data-action="update" data-extra="" data-pred="'.$order->products[$i]['final_price'].'" href="#" class="ajaxLinkProduct">' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
               '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_incl" data-action="update" data-extra="" data-pred="'.tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true).'" href="#" class="ajaxLinkProduct">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true), true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
      echo '          </tr>' . "\n";
    }
?>
    </table>
    <table width="300px" border="0" cellspacing="0" cellpadding="2" align="right" class="dataTableContent">
        <?php
            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
              if (($order->totals[$i]['class'] != 'ot_subtotal') && ($order->totals[$i]['class'] != 'ot_total') && ($order->totals[$i]['class'] != 'ot_tax')) {
                echo '              <tr>' . "\n" .
                     '                <td class="dataTableContent" valign="top" align="right" width="3%"><a data-class="' . $order->totals[$i]['class'] . '" data-action="eliminate" data-title="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" href="' . tep_href_link('orders_ajax.php', tep_get_all_get_params(array('action', 'page', 'status', 'ajax')) . 'action=eliminate_field') . '" class="ajaxLinkTotals">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td>' . "\n" .
                     '                <td align="right" class="smallText" colspan="4"><a id="'.$order->totals[$i]['class'].'_title" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" data-column="title" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['title'] . '</a></td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="2"><a id="'.$order->totals[$i]['class'].'_value" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.$order->totals[$i]['value'].'" data-column="value" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['text'] . '</a></td>' . "\n" .
                   '              </tr>' . "\n";
              } else {
                echo '              <tr>' . "\n" .
                   '                <td align="right" class="smallText" colspan="6">' . $order->totals[$i]['title'] . '</td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="1" style="width:100px;">' . $order->totals[$i]['text'] . '</td>' . "\n" .
                   '              </tr>' . "\n";
              }
            }
            //link to create a new order_total
            echo '              <tr>' . "\n" .
               '              <td align="right" class="smallText" colspan="7"><a id="createOrdersTotal" href="#">'.ENTRY_ADD_FIELD.'</a></td>' . "\n" .
               '              </tr>' . "\n";
        ?>
    </table>
  </td>
  </tr>
  </table>
  </td>
  <td class="main" valign="top">
    <table>
      <tr>
        <td align="left"><b><?php echo EMAIL_TEXT_ORDER_NUMBER; ?></b></td>
        <td align="right"><font color="#FF0000"><b id="order_number"><?php echo $oID ?></b></font><br></td>
      </tr>
      <tr>
        <td align="left">
          <b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b>
        </td>
        <td align="right">
          <a id="customers_telephone" data-table="orders" data-field="customers_telephone" href="#" class="ajaxLink"><?php echo ((isset($order->customer['telephone']) && $order->customer['telephone'] != '') ? $order->customer['telephone'] : '___'); ?></a>
        </td>
      </tr>
      <tr>
        <td align="left">
          <b><?php echo ENTRY_EMAIL_ADDRESS; ?></b>
        </td>
        <td align="right">
          <a id="customers_email_address" data-table="orders" data-field="customers_email_address" href="#" class="ajaxLink"><?php echo $order->customer['email_address']; ?></a>
        </td>
      </tr>
    </table>
  </td>
  <td class="dataTableContent" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main" valign="top" align="left"><b><?php echo ENTRY_CUSTOMER; ?></b><br \>
          <!--<td class="main">--><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>', 'customers_'); ?></td>
        </tr>
      </table>
    </td>
    <td class="dataTableContent" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td class="main" valign="top" align="left"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b><br \>
            <!--<td class="main">--><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>', 'delivery_'); ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
<div style="clear: both;"></div>
<script type="text/javascript">
$(function(){
  var width = $('#boxcart-content-table').width();
  var height = $('#boxcart-content-table').height();

  $('.ajax_cart')
  .css("width", width + 650);
  $( "#ajax_cart_dialog" ).dialog( "option", "position", { my: "center", at: "center" } );
});
</script>

<?php
    tep_exit();
  }

    if ($action == 'update_orders_status') {
        #Set Header to JSON
        header('Content-Type: application/json');

        $autoupdatestatus = $_POST['autoupdatestatus'];
        $notify = (int)$_POST['notify'];
        $autostatus = (int)$_POST['autostatus'];

        #Sort Orders to be Updated
        if($_POST['batch_order_numbers']){
         foreach($_POST['batch_order_numbers'] as $order_number => $print_order) {
          $batch_order_numbers[] = $order_number;
        }
      }

      sort($batch_order_numbers);

      #Here we set the Progress Total Size
      $count_orders = count($batch_order_numbers);
      header("Content-Length: " . $count_orders);

	   #Begin error handling
      if (!(is_array($batch_order_numbers))){
        die( json_encode( array( 'status' => 'error', 'message' => ERROR_NO_ORDERS_SELECTED ) ) );
      }

        #Get the name of the Order Status
        $orders_statuses = array();
        $orders_status_array = array();
        $orders_status_query = mysqli_prepared_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = ? AND orders_status_id = ?", "ii", array($languages_id, $autostatus));
        $orders_status = $orders_status_query[0]['orders_status_name'];


        // Kiss Error Debugger
        //$start_time = microtime( true );

        #Connect
        $link = "db_link";
        global $$link;

        #SQL Query
        $tablename_o    = TABLE_ORDERS;
        $tablename_osh  = TABLE_ORDERS_STATUS_HISTORY;
        $sql_se         = "SELECT customers_id, customers_name, customers_email_address, payment_method, date_purchased, orders_status, date_purchased FROM $tablename_o WHERE orders_id = ?";
        $sql_in         = "INSERT INTO $tablename_osh(orders_id, orders_status_id, date_added, customer_notified) VALUES (?, ?, now(), ?)";
        $sql_up         = "UPDATE $tablename_o SET orders_status = ? WHERE orders_id = ?";


        #Create the prepared statement
        $stmt_se        = $$link->prepare($sql_se);
        $stmt_in        = $$link->prepare($sql_in);
        $stmt_up        = $$link->prepare($sql_up);


        #Error checking the prepared statement
        if ( false === $stmt_se )        {
                        die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the SELECT statement failed: ' . htmlspecialchars($$link->error) ) ) );
        }
        if ( false === $stmt_in )        {
                        die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the INSERT statement failed: ' . htmlspecialchars($$link->error) ) ) );
        }
        if ( false === $stmt_up )        {
                        die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the UPDATE statement failed: ' . htmlspecialchars($$link->error) ) ) );
        }


        #Bind parameters to the query
        $bp_se = $stmt_se->bind_param("i", $oID);
        $bp_in = $stmt_in->bind_param("iii", $oID, $autostatus, $customer_notified);
        $bp_up = $stmt_up->bind_param("ii", $autostatus, $oID);


        #Error checking for binded parameters
        if ( false === $bp_se )        {
            die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for SELECT failed: ' . htmlspecialchars($stmt_se->error) ) ) );
        }
        if ( false === $bp_in )        {
            die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for INSERT failed: ' . htmlspecialchars($stmt_in->error) ) ) );
        }
        if ( false === $bp_up )        {
            die( json_encode( array( 'status' => 'error', 'message' => 'Binding parameters for UPDATE failed: ' . htmlspecialchars($stmt_up->error) ) ) );
        }

        #Let's iterate the array
        foreach ($batch_order_numbers as $order_number) {

            $oID = $order_number;
            $check_status = array();
            if ($autoupdatestatus == 'Yes' && is_numeric($autostatus)) {

                #Run the prepared statement
                $bp_se = $stmt_se->execute();

                #Error checking the execution of the prepared statement
                if ( false === $bp_se )        {
                    die( json_encode( array( 'status' => 'error', 'message' => 'Executing SELECT failed: ' . htmlspecialchars($stmt_se->error) ) ) );
                }

                #Get the customers info
                $res = $stmt_se->get_result();
                while (($row = $res->fetch_assoc()))
                  $check_status[] = $row;

                #Start, if selected, with E-Mail Status Update
                $customer_notified = '0';
                if ($notify=='Yes') {

                  $myemail_number = '<a href="' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . '">Click Here</a>';

                  $email = "\n" .
                  STORE_NAME . "\n\n" .
                  EMAIL_SEPARATOR . "\n" .
                  EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" .
                  EMAIL_TEXT_INVOICE_URL . ' ' . $myemail_number . "\n" .
                  EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status[0]['date_purchased']) . "\n\n" . EMAIL_SEPARATOR . "\n" .
                  sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status);

                  $email_subj = EMAIL_TEXT_ORDER_NUMBER .  ' ' . $oID . " (Status: " . $orders_status .")";

                  tep_mail($check_status[0]['customers_name'], $check_status[0]['customers_email_address'], $email_subj, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

                  $customer_notified = '1';
                }

                #Run the prepared statements
                $bp_in = $stmt_in->execute();
                $bp_up = $stmt_up->execute();


                #Error checking the execution of the prepared statement
                if ( false === $bp_in )        {
                    die( json_encode( array( 'status' => 'error', 'message' => 'Executing INSERT failed: ' . htmlspecialchars($stmt_in->error) ) ) );
                }
                if ( false === $bp_up )        {
                    die( json_encode( array( 'status' => 'error', 'message' => 'Executing UPDATE failed: ' . htmlspecialchars($stmt_up->error) ) ) );
                }

              }
              #Output Progress
              echo "1";
              ob_flush();
              flush();
        }

        ob_end_flush();

        #Close open connections
        $stmt_se->close();
        $stmt_in->close();
        $stmt_up->close();

        // Kiss Error Debugger
        /*if ( class_exists( 'KissER' ) ) {
            KissER::q( round( ( microtime( true ) - $start_time ), 4 ), $sql_se.'<br \>'.$sql_in.'<br \>'.$sql_up );
        }*/

        #Return Success
        if ($autoupdatestatus == 'Yes') {
            //die( json_encode( array( 'status' => 'success' ) ) );
        }

		tep_exit();
    }

	$oID = (int)tep_db_prepare_input($_GET['oID']);

	$orders_query = mysqli_prepared_query("select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_id = ? and o.orders_status = s.orders_status_id and s.language_id = ? and ot.class = 'ot_total' order by o.orders_id DESC", "ii", array($oID, $languages_id));
	$orders = $orders_query[0];

	require(DIR_WS_CLASSES . 'currencies.php');
    $currencies = new currencies();

    $orders_statuses = array();
    $orders_status_array = array();
    $orders_status_query = mysqli_prepared_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = ?", "i", array($languages_id));
    foreach ($orders_status_query as $orders_status) {
        $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
  		                           'text' => $orders_status['orders_status_name']);
        $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
    }

    include(DIR_WS_CLASSES . 'order.php');
    $order = new order($oID);

	$heading = array();
	$contents = array();

	if ($action == 'update_products') {
		$output = '
		<table border="0" width="100%" cellspacing="0" cellpadding="2" id="productTotals">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="3">' . sprintf(TABLE_HEADING_PRODUCTS, $oID) . '</td>' .
           '<td class="dataTableHeadingContent">' . TABLE_HEADING_PRODUCTS_MODEL . '</td>' .
           '<td class="dataTableHeadingContent" align="right">' . TABLE_HEADING_TAX . '</td>
            <td class="dataTableHeadingContent" align="right">' . TABLE_HEADING_PRICE_EXCLUDING_TAX . '</td>
            <td class="dataTableHeadingContent" align="right">' . TABLE_HEADING_PRICE_INCLUDING_TAX . '</td>
            <td class="dataTableHeadingContent" align="right">' . TABLE_HEADING_TOTAL_EXCLUDING_TAX . '</td>
            <td class="dataTableHeadingContent" align="right">' . TABLE_HEADING_TOTAL_INCLUDING_TAX . '</td>
          </tr>';

    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
$output .= '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="left" width="3%"><a data-product="' . $order->products[$i]['id'] . '" data-field="" data-action="eliminate" data-extra="" data-pred="" href="#" class="ajaxLinkProduct">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td><td width="10px" align="left"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_quantity" data-action="update" data-extra="" data-pred="'.$order->products[$i]['qty'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['qty'] . '&nbsp;x</a></td>' . "\n" .
     '            <td class="dataTableContent" valign="top">' . 
           '<a data-product="' . $order->products[$i]['id'] . '" data-field="products_name" data-action="update" data-extra="" data-pred="'.$order->products[$i]['name'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['name'] . '</a>';

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
     $output .= '<br><nobr><small>&nbsp;<i> - <a data-product="' . $order->products[$i]['id'] . '" data-field="options" data-action="update" data-extra="' . $order->products[$i]['attributes'][$j]['option'] . '" data-pred="'.$order->products[$i]['option'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') $output .= ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
     $output .= '</a></i></small></nobr>';
        }
      }

$output .= '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_model" data-action="update" data-extra="" data-pred="'.$order->products[$i]['model'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['model'] . '</a></td>' . "\n" .
           '            <td class="dataTableContent tax" data-tax="'.(float)tep_display_tax_value($order->products[$i]['tax']).'" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_excl" data-action="update" data-extra="" data-pred="'.$order->products[$i]['final_price'].'" href="#" class="ajaxLinkProduct">' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
               '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_incl" data-action="update" data-extra="" data-pred="'.tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true).'" href="#" class="ajaxLinkProduct">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true), true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
$output .= '          </tr>' . "\n";
    }
$output .= '
          <tr>
            <td align="right" colspan="10"><table width="300px" border="0" cellspacing="0" cellpadding="2" class="dataTableContent">';
        
            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
              if (($order->totals[$i]['class'] != 'ot_subtotal') && ($order->totals[$i]['class'] != 'ot_total') && ($order->totals[$i]['class'] != 'ot_tax')) {
          $output .= '              <tr>' . "\n" .
                    '                <td class="dataTableContent" valign="top" align="right" width="3%"><a data-class="' . $order->totals[$i]['class'] . '" data-action="eliminate" data-title="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" href="' . tep_href_link('orders_ajax.php', tep_get_all_get_params(array('action', 'page', 'status', 'ajax')) . 'action=eliminate_field') . '" class="ajaxLinkTotals">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="9"><a id="'.$order->totals[$i]['class'].'_title" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" data-column="title" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['title'] . '</a></td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="1"><a id="'.$order->totals[$i]['class'].'_value" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.$order->totals[$i]['value'].'" data-column="value" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['text'] . '</a></td>' . "\n" .
                   '              </tr>' . "\n";
              } else {
          $output .= '             <tr>' . "\n" .
                   '                <td align="right" class="smallText" colspan="10">' . $order->totals[$i]['title'] . '</td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="1" style="width:100px;">' . $order->totals[$i]['text'] . '</td>' . "\n" .
                   '              </tr>' . "\n";
              }
            }
            //link to create a new order_total
    $output .= '              <tr>' . "\n" .
               '              <td align="right" class="smallText" colspan="11"><a id="createOrdersTotal" href="#">'.ENTRY_ADD_FIELD.'</a></td>' . "\n" .
               '              </tr>' . "\n" .
        
           '</table>';

    echo $output;
    tep_exit();	
	}

	if (($action == 'edit') && is_numeric($oID)) {
		$orders_query = mysqli_prepared_query("select orders_id from " . TABLE_ORDERS . " where orders_id = ?", "i", array($oID));
    $order_exists = true;
    if (!count($orders_query)) {
      $order_exists = false;
      //$messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }

    ?>
    <div id="orderTable">
      <?php echo tep_draw_form('batch_orders', 'print_batch_process_2.php', '', 'post', 'id="batch_orders"') . tep_draw_hidden_field('batch_order_numbers[' . (int)$_GET['oID'] . ']', 'No'); ?></form>
      <?php echo tep_draw_form('status', FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action')) . 'action=update_order', 'post', 'id="update_status"'); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td id="pageHeading"><h1><?php echo HEADING_TITLE; ?> <small>Rev 2</small></h1></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo tep_draw_button(TOOLTIP_DUPLICATE_ORDER, 'trash', tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$_GET['oID'] . '&cID=' . $_GET['cID'] . '&action=duplicate_order'), 'secondary', array('params' => 'class="duplicate_order"')) . '<span class="ajax_disable">' . tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link("oc_batch_delete_confirm.php", 'oID=' . (int)$_GET['oID']), 'secondary', array('params' => 'class="batch_delete"')) . '</span>' . '<span class="ajax_disable">' . tep_draw_button(IMAGE_CREATE_ORDER, 'document', tep_href_link(FILENAME_CREATE_ORDER, 'Customer_nr=' . (int)$_GET['cID'])) . '</span>' . tep_draw_button(IMAGE_ORDERS_INVOICE, 'document', tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . (int)$_GET['oID']), null, array('newwindow' => true)) . tep_draw_button(IMAGE_ORDERS_PACKINGSLIP, 'document', tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . (int)$_GET['oID']), null, array('newwindow' => true)) . tep_draw_button(IMAGE_BACK, 'back', tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action'))), 'secondary', array('params' => 'class="ajax_button"')); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo tep_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo EMAIL_TEXT_ORDER_NUMBER; ?></b></td>
                  <td class="main"><font color="#FF0000"><b id="order_number"><?php echo $oID ?></b></font><br></td>
                  </tr>
                  <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>', 'customers_'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>
                <td class="main"><a id="customers_telephone" data-table="orders" data-field="customers_telephone" href="#" class="ajaxLink"><?php echo ((isset($order->customer['telephone']) && $order->customer['telephone'] != '') ? $order->customer['telephone'] : '___'); ?></a></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main"><a id="customers_email_address" data-table="orders" data-field="customers_email_address" href="#" class="ajaxLink"><?php echo $order->customer['email_address'] . '</a>'; ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>', 'delivery_'); ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, '', '<br>', 'billing_'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
            <td class="main"><a id="payment_method"  data-table="orders" data-field="payment_method" href="#" class="ajaxLink"><?php echo $order->info['payment_method']; ?></a></td>
          </tr>
<?php
    if (tep_not_null($order->info['cc_type']) || tep_not_null($order->info['cc_owner']) || tep_not_null($order->info['cc_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><a id="cc_type"  data-table="orders" data-field="cc_type" href="#" class="ajaxLink"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></a></td>
            <td class="main"><?php echo $order->info['cc_type']; ?></td>
          </tr>
          <tr>
            <td class="main"><a id="cc_owner"  data-table="orders" data-field="cc_owner" href="#" class="ajaxLink"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></a></td>
            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
          </tr>
          <tr>
            <td class="main"><a id="cc_number"  data-table="orders" data-field="cc_number" href="#" class="ajaxLink"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></a></td>
            <td class="main"><?php echo $order->info['cc_number']; ?></td>
          </tr>
          <tr>
            <td class="main"><a id="cc_expires"  data-table="orders" data-field="cc_expires" href="#" class="ajaxLink"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></a></td>
            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2" id="productTotals">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="3"><?php echo sprintf(TABLE_HEADING_PRODUCTS, $oID); ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
<?php
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="left" width="3%"><a data-product="' . $order->products[$i]['id'] . '" data-field="" data-action="eliminate" data-extra="" data-pred="" href="#" class="ajaxLinkProduct">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td><td width="10px" align="left"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_quantity" data-action="update" data-extra="" data-pred="'.$order->products[$i]['qty'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['qty'] . '&nbsp;x</a></td>' . "\n" .
     '            <td class="dataTableContent" valign="top">' . 
           '<a data-product="' . $order->products[$i]['id'] . '" data-field="products_name" data-action="update" data-extra="" data-pred="'.$order->products[$i]['name'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['name'] . '</a>';

      if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br><nobr><small>&nbsp;<i> - <a data-product="' . $order->products[$i]['id'] . '" data-field="options" data-action="update" data-extra="' . $order->products[$i]['attributes'][$j]['option'] . '" data-pred="'.$order->products[$i]['option'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          echo '</a></i></small></nobr>';
        }
      }

      echo '            </td>' . "\n" .
           '            <td class="dataTableContent" valign="top"><a data-product="' . $order->products[$i]['id'] . '" data-field="products_model" data-action="update" data-extra="" data-pred="'.$order->products[$i]['model'].'" href="#" class="ajaxLinkProduct">' . $order->products[$i]['model'] . '</a></td>' . "\n" .
           '            <td class="dataTableContent tax" data-tax="'.(float)tep_display_tax_value($order->products[$i]['tax']).'" align="right" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_excl" data-action="update" data-extra="" data-pred="'.$order->products[$i]['final_price'].'" href="#" class="ajaxLinkProduct">' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
               '            <td class="dataTableContent" align="right" valign="top"><b><a data-product="' . $order->products[$i]['id'] . '" data-field="products_price_incl" data-action="update" data-extra="" data-pred="'.tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true).'" href="#" class="ajaxLinkProduct">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true), true, $order->info['currency'], $order->info['currency_value']) . '</a></b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax'], true) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
      echo '          </tr>' . "\n";
    }
?>
          <tr>
            <td align="right" colspan="9"><table width="300px" border="0" cellspacing="0" cellpadding="2" class="dataTableContent">
        <?php
            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
              if (($order->totals[$i]['class'] != 'ot_subtotal') && ($order->totals[$i]['class'] != 'ot_total') && ($order->totals[$i]['class'] != 'ot_tax')) {
                echo '              <tr>' . "\n" .
                    '                <td class="dataTableContent" valign="top" align="left" width="3%"><a data-class="' . $order->totals[$i]['class'] . '" data-action="eliminate" data-title="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" href="' . tep_href_link('orders_ajax.php', tep_get_all_get_params(array('action', 'page', 'status', 'ajax')) . 'action=eliminate_field') . '" class="ajaxLinkTotals">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="3"><a id="'.$order->totals[$i]['class'].'_title" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" data-column="title" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['title'] . '</a></td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="2"><a id="'.$order->totals[$i]['class'].'_value" data-class="' . $order->totals[$i]['class'] . '" data-pred="'.$order->totals[$i]['value'].'" data-column="value" href="#" class="ajaxLinkTotals">' . $order->totals[$i]['text'] . '</a></td>' . "\n" .
                   '              </tr>' . "\n";
              } else {
                echo '              <tr>' . "\n" .
                   '                <td align="right" class="smallText" colspan="4">' . $order->totals[$i]['title'] . '</td>' . "\n" .
                   '                <td align="right" class="smallText" colspan="2" style="width:100px;">' . $order->totals[$i]['text'] . '</td>' . "\n" .
                   '              </tr>' . "\n";
              }
            }
            //link to create a new order_total
            echo '              <tr>' . "\n" .
               '              <td align="right" class="smallText" colspan="2"><a id="createOrdersTotal" href="#">'.ENTRY_ADD_FIELD.'</a></td>' . "\n" .
               '              </tr>' . "\n";
        ?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" id="comment_table"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
          </tr>
<?php
    $orders_history_query = mysqli_prepared_query("select orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = ? order by date_added", "i", array($oID));
    if (count($orders_history_query)) {
      foreach ($orders_history_query as $orders_history) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history['customer_notified'] == '1') {
          echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
             '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo tep_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo ENTRY_STATUS; ?></b> <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status'], ''); ?></td>
                <td class="smallText" valign="top" align="right"><?php echo tep_draw_button(IMAGE_UPDATE, 'disk', null, 'primary', array('params' => 'class="ajax_button"')); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '4', '5'); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td>
              </tr>
            </table></td>
            
            <td class="smallText" align="right"><?php echo '<span class="ajax_disable">' . tep_draw_button(IMAGE_CREATE_ORDER, 'document', tep_href_link(FILENAME_CREATE_ORDER, tep_get_all_get_params(array('action', 'oID', 'ajax')) . 'Customer=' . (int)$HTTP_GET_VARS['cID'])) . '</span>' . tep_draw_button(IMAGE_ORDERS_INVOICE, 'document', tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']), 'secondary', array('params' => 'target="_blank"')) . tep_draw_button(IMAGE_ORDERS_PACKINGSLIP, 'document', tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']), 'secondary', array('params' => 'target="_blank"')) . tep_draw_button(IMAGE_BACK, 'back', tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action'))), 'secondary', array('params' => 'target="_blank" class="ajax_button"')); ?></td>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
  </div>
<?php
		tep_exit();
  }
  tep_exit();
?>