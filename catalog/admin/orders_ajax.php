<?php
/*
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
*/
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  function tep_db_update_totals($order_id) {
        #Define Tables to Variables
        $tablename_o = TABLE_ORDERS;
        $tablename_ot = TABLE_ORDERS_TOTAL;
        $tablename_p = TABLE_PRODUCTS;
        $tablename_a = TABLE_PRODUCTS_ATTRIBUTES;
        $tablename_ad = TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD;
        $tablename_op = TABLE_ORDERS_PRODUCTS;
        $tablename_opa = TABLE_ORDERS_PRODUCTS_ATTRIBUTES;
        $tablename_po = TABLE_PRODUCTS_OPTIONS;
        $tablename_pov = TABLE_PRODUCTS_OPTIONS_VALUES;
        $tablename_opd = TABLE_ORDERS_PRODUCTS_DOWNLOAD;
        $tablename_s = TABLE_SPECIALS;
        $tablename_tc = TABLE_TAX_CLASS;
        $tablename_tr = TABLE_TAX_RATES;
        $currencies = new currencies();
  //we have to update the orders_total table
        $products_total_query = mysqli_prepared_query("SELECT final_price, products_quantity, products_tax from " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id = ?", "i", array($order_id));
        $price = 0;
        $total = 0;
        $taxes = array();
        if (count($products_total_query) > 0) {
          foreach ($products_total_query as $products_total) {
                $iva = round((100 + (float)$products_total['products_tax']) / 100, 4);
                $price += (float)round(((float)$products_total['final_price'] * (int)$products_total['products_quantity']) * $iva, 2);
          //fill the array of taxes to know which tax is used.
                if (tep_not_null($products_total['products_tax']) && $products_total['products_tax'] > 0) {
                  $tax_description = mysqli_prepared_query("SELECT tax_description from " . TABLE_TAX_RATES . " WHERE tax_rate = ?", "d", array($products_total['products_tax']));
                  $tax_description = $tax_description[0];
                  if (sizeof($taxes)) {
                        $ya_esta = false;
                        for ($i=0; $i<sizeof($taxes); $i++) {
                          if (in_array($tax_description['tax_description'], $taxes[$i])) {
                                $ya_esta = $i;
                          }
                        }
                        if ($ya_esta === false) {
                          $taxes[] = array('description' => $tax_description['tax_description'], 'value' => round(((((float)$products_total['final_price'] * (int)$products_total['products_quantity']) * (float)$products_total['products_tax']) / 100), 4));
                        } else {
                          $taxes[$ya_esta]['value'] += round(((((float)$products_total['final_price'] * (int)$products_total['products_quantity']) * (float)$products_total['products_tax']) / 100), 4);
                        }
                  } else {
                        $taxes[] = array('description' => $tax_description['tax_description'], 'value' => round(((((float)$products_total['final_price'] * (int)$products_total['products_quantity']) * (float)$products_total['products_tax']) / 100), 4));
                  }
                }
          }
        }
        $orders_total_query = mysqli_prepared_query("SELECT * from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? and class != 'ot_tax' order by sort_order", "i", array($order_id));
        $others_tax = mysqli_prepared_query("SELECT tc.tax_class_title, tr.tax_rate FROM $tablename_tc tc LEFT JOIN $tablename_tr tr ON (tc.tax_class_id = tr.tax_class_id) WHERE tc.tax_class_id = 1");
        foreach ($orders_total_query as $order_total) {
          if ($order_total['class'] == 'ot_subtotal') {
                $new_value = (float)$price;
                $new_text = $currencies->format($new_value);
                $total += (float)$new_value;
                $params = array($new_text, $new_value, $order_total['orders_total_id']);
                mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET text = ?, value = ? WHERE orders_total_id = ?", "sdi", $params);
          } elseif ($order_total['class'] == 'ot_total') {
                $new_value = (float)$total;
                $new_text = '<strong>' . $currencies->format(round($new_value)) . '</strong>';
                $params = array($new_text, $new_value, $order_total['orders_total_id']);
                mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET text = ?, value = ? WHERE orders_total_id = ?", "sdi", $params);
          } else {
                $updated = false;
                $other_tax = $order_total['value'] - ($order_total['value'] / ($others_tax[0]['tax_rate'] / 100 + 1));
                for ($i=0; $i<sizeof($taxes); $i++) {
                  if ($taxes[$i]['description'] == $others_tax[0]['tax_class_title']) {
                        $taxes[$i]['value'] += (float)$other_tax;
                        $updated = true;
                        break;
                  }
                }
                if ($updated === false) {
                  $taxes[] = array('description' => $others_tax[0]['tax_class_title'], 'value' => $other_tax);
                }
                $total += round((float)$order_total['value'], 4);
          }
        }
  //the taxes
        if (sizeof($taxes)) {
          $orders_total_tax_query = mysqli_prepared_query("SELECT * from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? and class = 'ot_tax'", "i", array($order_id));
         
        //update the ot_tax with the same title
        //if title doesn't exist, INSERT it
          $tax_updated = array();
          foreach ($orders_total_tax_query as $orders_total_tax) {
                $eliminate_tax = true;
                for ($i=0; $i<sizeof($taxes); $i++) {
                  if (in_array($orders_total_tax['title'], $taxes[$i])) {
                        $eliminate_tax = false;
                                                                          //keep in variable that this tax is done
                        $tax_updated[] = $orders_total_tax['title'];
                                                                          //prepare text (value with currency)
                        $texto = number_format((float)$taxes[$i]['value'], 2);
                        $new_text = $currencies->format($texto);
                        $params = array($new_text, $taxes[$i]['value'], $orders_total_tax['orders_total_id']);
                        mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET text = ?, value = ? WHERE orders_total_id = ? and class = 'ot_tax'", "sdi", $params);
                  }
                }
          //we have eliminate the last product of one tax_rate->eliminate the ot_field
                if ($eliminate_tax == true) {
                  mysqli_prepared_query("delete from " . TABLE_ORDERS_TOTAL . " WHERE orders_total_id = ? limit 1", "i", array($orders_total_tax['orders_total_id']));
                }
          }
        //INSERT a new tax rate in the orders_total table, if all of taxes[] is not in $tax_updated[]
          for ($i=0; $i<sizeof($taxes); $i++) {
                if ((!in_array($taxes[$i]['description'], $tax_updated)) && ((float)$taxes[$i]['value'] > 0)) {
                                                          //prepare text (value with currency)
                  $texto = round((float)$taxes[$i]['value'], 2);
                                                          //$texto = (string)$texto . $currency['symbol_right'];
                  $texto = $currencies->format($texto);
                  if ($taxes[$i]['description'] !== null)
                        $params = array($order_id, $taxes[$i]['description'], $texto, $taxes[$i]['value']);
                  mysqli_prepared_query("INSERT INTO " . TABLE_ORDERS_TOTAL . " (orders_id, title, text, value, class, sort_order) VALUES (?, ?, ?, ?, 'ot_tax', 3)", "issd", $params);
                }
          }
        }
  }

  #Define Tables to Variables
  $tablename_o = TABLE_ORDERS;
  $tablename_ot = TABLE_ORDERS_TOTAL;
  $tablename_p = TABLE_PRODUCTS;
  $tablename_a = TABLE_PRODUCTS_ATTRIBUTES;
  $tablename_ad = TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD;
  $tablename_op = TABLE_ORDERS_PRODUCTS;
  $tablename_opa = TABLE_ORDERS_PRODUCTS_ATTRIBUTES;
  $tablename_po = TABLE_PRODUCTS_OPTIONS;
  $tablename_pov = TABLE_PRODUCTS_OPTIONS_VALUES;
  $tablename_opd = TABLE_ORDERS_PRODUCTS_DOWNLOAD;
  $tablename_s = TABLE_SPECIALS;
  $tablename_tc = TABLE_TAX_CLASS;
  $action = $_GET['action'];
  if (($action == 'eliminate_field') || ($action == 'eliminate') || ($action == 'update_product')) {
        if ($action == 'eliminate') {
          mysqli_prepared_query("delete from " . TABLE_ORDERS_PRODUCTS . " WHERE orders_products_id = ? limit 1", "i", array($_GET['pID']));
          $attributes_query = mysqli_prepared_query("SELECT orders_products_attributes_id from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id = ?", "i", array($_GET['pID']));
        //if the products has attributes, eliminate them
          if (count($attributes_query) > 0) {
                foreach ($attributes_query as $attributes) {
                  mysqli_prepared_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_attributes_id = ? limit 1", "i", array($attributes['orders_products_attributes_id']));
                }
          }
          $message = "Product Removed.";
        } elseif ($action == 'eliminate_field') {
          $oID = (int)$_GET['oID'];
          $class = $_POST['total_class'];
          $title = urldecode($_POST['title']);
          $params = array($oID, $title, $class);
          mysqli_prepared_query("delete from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? AND title = ? AND class = ? limit 1", "iss", $params);
          tep_db_update_totals($oID);
          $message = "Field Removed.";
        } else {
  // get the price to change order totals
  // but first, change it if we change price of attributes (so we get directly the good final_price)
          $field = $_GET['field'];
          if ($field == 'options') {
                $params = array( $_GET['new_value'], round((float)$_GET['option_price'], 4), $_GET['pID'], $_GET['extra']);
                mysqli_prepared_query("update " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " SET products_options_VALUES = ?,  options_values_price = ? WHERE orders_products_id = ? and products_options = ?", "sdis", $params);

                $params = array(round((float)$_GET['option_price'], 4), $_GET['pID']);
                mysqli_prepared_query("update " . TABLE_ORDERS_PRODUCTS . " SET final_price = (products_price + ?) WHERE orders_products_id = ?", "di", $params);
                $message = "Product Options Updated.";
        } elseif (stristr($field, 'price')) {
                $adapt_price_query = mysqli_prepared_query("SELECT options_values_price from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id = ? and options_values_price != 0", "i", array($_GET['pID']));
                if (count($adapt_price_query)) {
                  $adapt_price = $adapt_price_query[0];
                  $option_price = (float)$adapt_price['options_values_price'];
                } else {
                  $option_price = 0;
                }
                if (stristr($field, '_excl')) {
                  $new_price = round((float)$_GET['new_value'], 4);
                } else {
                  $tax_query = mysqli_prepared_query("SELECT products_tax from " . TABLE_ORDERS_PRODUCTS . " WHERE orders_products_id = ? and products_tax != 0", "i", array($_GET['pID']));
                  if (count($tax_query)) {
                        $tax_ = $tax_query[0];
                        $percent = (float)$tax_['products_tax'];
                        $percent = round(($percent/100), 4);
                        $percent = $percent + 1;
                        $new_price = round(round((float)$_GET['new_value']/$percent, 4), 4);
                  } else {
                        $new_price = round((float)$_GET['new_value'], 4);
                  }
                }
                $params = array($new_price, ($new_price - $option_price), $_GET['pID']);
                mysqli_prepared_query("update " . TABLE_ORDERS_PRODUCTS . " SET final_price = ?, products_price = ? WHERE orders_products_id = ?", "ddi", $params);
                $message = "Product Price Updated.";
          } else {
                if (tep_not_null($field) && tep_not_null($_GET['new_value'])) {
                  $params = array($_GET['new_value'], $_GET['pID']);
                  mysqli_prepared_query("update " . TABLE_ORDERS_PRODUCTS . " SET ".tep_db_input($field)." = ? WHERE orders_products_id = ?", "si", $params);
                  $message = "Order Updated.";
                }
          }
        }
        #we have to update the orders_total table
        tep_db_update_totals($_GET['order']);
        #Send Success Message
        header('Content-Type: application/json');
        die( json_encode( array( 'status' => 'success', 'message' => $message ) ) );
  } elseif ($action == 'update_order_field') {
        $params = array($_GET['new_value'], $_GET['oID']);
        //mysqli_prepared_query("update ".tep_db_input($_GET['db_table'])." SET ".tep_db_input($_GET['field'])." = ? WHERE orders_id = ?", "si", $params);
        mysqli_prepared_query("UPDATE orders SET ".tep_db_input($_GET['field'])." = ? WHERE orders_id = ?", "si", $params);
        #Send Success Message
        header('Content-Type: application/json');
        die( json_encode( array( 'status' => 'success', 'message' => 'Field updated.' ) ) );
  } elseif ($action == 'search_orders') {
        $params = array($_GET['q'], '%'.$_GET['q'].'%', '%'.$_GET['q'].'%', '%'.$_GET['q'].'%', '%'.$_GET['q'].'%', $_GET['page_limit']);
        $orders_query = mysqli_prepared_query("SELECT orders_id, customers_name, customers_email_address, date_purchased FROM $tablename_o WHERE (orders_id = ? OR customers_name LIKE ? OR customers_email_address LIKE ? OR delivery_name LIKE ? OR billing_name LIKE ?) LIMIT ?", "issssi", $params);
        if (count($orders_query)) {
          $return_arr = array();
          foreach ($orders_query as $orders) {
                $row_array['id'] = tep_href_link(FILENAME_ORDERS_HANDLER, 'oID=' . $orders['orders_id'] . '&action=edit');
                $row_array['text'] = $orders['orders_id'] . ' - ' . $orders['customers_name'] . ' - ' . $orders['date_purchased'];
                array_push($return_arr, $row_array);
          }
        } else {
          $return_arr = array('value' => PRODUCTS_SEARCH_NO_RESULTS);
        }
        header('Content-Type: application/json');
        die( json_encode($return_arr) );
  } elseif ($action == 'search') { //search products in the db.
        $params = array('%'.$_GET['term'].'%', '%'.$_GET['term'].'%', $languages_id);
        $products_query = mysqli_prepared_query("SELECT distinct p.products_id, pd.products_name, p.products_model from " . TABLE_PRODUCTS_DESCRIPTION . " pd left join " . TABLE_PRODUCTS . " p on (p.products_id = pd.products_id) WHERE (pd.products_name like ? or  p.products_model like ?) and  pd.language_id = ? and p.products_status = '1' order  by pd.products_name asc limit 20", "ssi", $params);
        if (count($products_query)) {
          $return_arr = array();
          foreach ($products_query as $products) {
                $row_array['id'] = 'javascript:$( this ).selectProduct(\'' .  $products['products_id'] . '\', \'' .  addslashes(tep_output_string_protected($products['products_name'])) . '\');';
                $row_array['value'] = $products['products_name'] . (($products['products_model'] != '') ? ' (' . $products['products_model'] . ')' : '');
                array_push($return_arr, $row_array);
          }
        } else {
          $return_arr = array('value' => PRODUCTS_SEARCH_NO_RESULTS);
        }
        header('Content-Type: application/json');
        die( json_encode($return_arr) );
  } elseif ($action == 'attributes') {
  //we create an AJAX form
        $attributes = '<form name="attributes" id="attributes" action="" onsubmit="return( $( this ).setAttr() )"><input type="hidden" name="products_id" value="' . (int)$_GET['prID'] . '">';
  //this part comes integraly from OSC catalog/product_info.php
        $params = array($_GET['prID'], $languages_id);
        $products_attributes_query = mysqli_prepared_query("SELECT count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib WHERE patrib.products_id = ? and patrib.options_id = popt.products_options_id and popt.language_id = ?", "ii", $params);
        $products_attributes = $products_attributes_query[0];
        if ($products_attributes['total'] > 0) {
          $attributes .= '<table border="0" cellspacing="0" cellpadding="2" class="dataTableRow" width="100%"><tr><td class="dataTableContent" colspan="2">' . TEXT_PRODUCT_OPTIONS . '</td>                    </tr>';
          $params = array($_GET['prID'], $languages_id);
          $products_options_name_query = mysqli_prepared_query("SELECT distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib WHERE patrib.products_id = ? and patrib.options_id = popt.products_options_id and popt.language_id = ? order by popt.products_options_name", "ii", $params);
          foreach ($products_options_name_query as $products_options_name) {
                $products_options_array = array();
                $params = array($_GET['prID'], $products_options_name['products_options_id'], $languages_id);
                $products_options_query = mysqli_prepared_query("SELECT pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov WHERE pa.products_id = ? and pa.options_id = ? and pa.options_values_id = pov.products_options_values_id and pov.language_id = ?", "iii", $params);
                foreach ($products_options_query as $products_options) {
                  $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
                  if ($products_options['options_values_price'] != '0') {
                        $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
                  }
                }
                $attributes .= '<tr><td class="main">' . $products_options_name['products_options_name'] . ':</td><td class="main">' . tep_draw_pull_down_menu('atrid_' . $products_options_name['products_options_id'], $products_options_array, $selected_attribute) . '</td></tr>';
          }
          $button = '<span><button type="submit" onmouseover="$( this ).addClass( \'ui-state-hover\' );" onmouseout="$( this ).removeClass( \'ui-state-hover\' );" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-secondary ui-priority-secondary" role="button" aria-disabled="false" style="margin-bottom: 5px;"><span class="ui-button-icon-secondary ui-icon ui-icon-disk"></span><span class="ui-button-text">' . IMAGE_CONFIRM . '</span></button></span>';
          $attributes .= '<tr><td colspan="2">' . $button . '</td></tr></table></form>';
        } else {
          $button = '<span><button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-secondary ui-priority-secondary" role="button" aria-disabled="false" style="margin-bottom: 5px;" onmouseover="$( this ).addClass( \'ui-state-hover\' );" onmouseout="$( this ).removeClass( \'ui-state-hover\' );"><span class="ui-button-icon-secondary ui-icon ui-icon-disk"></span><span class="ui-button-text">' . IMAGE_CONFIRM . '</span></button></span>';
          $attributes .= $button;
        }
        echo $attributes;
  } elseif ($action == 'set_attributes') {
        $attributes = array();
        $products_id = 0;
        $products_quantity = 0;
        foreach($_POST as $key => $value) {
          if ($key == 'products_id') {
                $products_id = $value;
          } elseif ($key == 'products_quantity') {
                $products_quantity = $value;
          } elseif (stristr($key, 'trid_')) {
                $attributes[] = array(substr($key, 6), $value);
          }
        }
        $orders_id = $_GET['oID'];
        $params = array($products_id, $languages_id);
        $product_info_query = mysqli_prepared_query("SELECT p.products_model, pd.products_name, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id WHERE p.products_id = ? and pd.language_id = ?", "ii", $params);
        $product_info = $product_info_query[0];
        if (DISPLAY_PRICE_WITH_TAX == 'true') {
          $tax_query = mysqli_prepared_query("SELECT tax_rate, tax_description from " . TABLE_TAX_RATES . " WHERE tax_rates_id = ?", "i", array($product_info['products_tax_class_id']));
          $tax_ = $tax_query[0];
          $tax = $tax_['tax_rate'];
          $tax_desc = $tax_['tax_description'];
        } else {
          $tax = 0;
        }
        $attribute_price_sum = 0;
        $attribute_update = false;
        if (sizeof($attributes) > 0) {
          $attribute_update = true;
          for ($j=0; $j<sizeof($attributes); $j++) {
                $attribute_price_query = mysqli_prepared_query("SELECT options_values_price, price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " WHERE products_id = ? and options_id = ? and options_values_id = ?", "iii", array($products_id, $attributes[$j][0], $attributes[$j][1]));
                $attribute_price = $attribute_price_query[0];
                if ($attribute_price['price_prefix'] == '+') {
                  $attribute_price_sum += (float)$attribute_price['options_values_price'];
                } else {
                  $attribute_price_sum -= (float)$attribute_price['options_values_price'];
                }
                $attribute_name_query = mysqli_prepared_query("SELECT products_options_name from " . TABLE_PRODUCTS_OPTIONS . " WHERE products_options_id = ? and language_id = ?", "ii", array($attributes[$j][0], $languages_id));
                $attribute_name = $attribute_name_query[0];
                $options_name_query = mysqli_prepared_query("SELECT products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " WHERE products_options_values_id = ? and language_id = ?", "ii", array($attributes[$j][1], $languages_id));
                $options_name = $options_name_query[0];
                $params = array($orders_id, $attribute_name['products_options_name'], $options_name['products_options_values_name'], $attribute_price['options_values_price'], $attribute_price['price_prefix']);
                mysqli_prepared_query("INSERT INTO " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " (orders_id, orders_products_id, products_options, products_options_values, options_values_price, price_prefix) VALUES (?, 0, ?, ?, ?, ?)", "issds", $params);
          }
        }
        $special_price = mysqli_prepared_query("
          SELECT specials_new_products_price
          FROM $tablename_s
          WHERE products_id = ?
          AND status = 1", "i", array($products_id));
        $new_price = $special_price[0];

        if ($new_price) {
          $final_price = (float)$new_price['specials_new_products_price']+ (float)$attribute_price_sum;
        } else {
          $final_price = (float)$product_info['products_price'] + (float)$attribute_price_sum;
        }
        $params = array($orders_id, $products_id, $product_info['products_model'], $product_info['products_name'], $product_info['products_price'], $final_price, $tax, $products_quantity);
        mysqli_prepared_query("INSERT INTO $tablename_op (orders_id, products_id, products_model, products_name, products_price, final_price, products_tax, products_quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", "iissdddi", $params);
        $orders_products_id = tep_db_insert_id();
        if ($attribute_update == true){
          mysqli_prepared_query("UPDATE $tablename_opa SET orders_products_id = ? WHERE orders_products_id = 0", "i", array($orders_products_id));
        }
        tep_db_update_totals($orders_id);
        #Send Success Message
        header('Content-Type: application/json');
        die( json_encode( array( 'status' => 'success', 'message' => 'Product added.' ) ) );
  } elseif ($action == 'orders_total_update') {
        if ($_GET['column'] == 'value') {
        #Get the order's currency
          $currency_query = mysqli_prepared_query("SELECT currency, currency_value from " . TABLE_ORDERS . " WHERE orders_id = ?", "i", array($_GET['oID']));
          $currency = $currency_query[0];
          $text = $currencies->format((float)$_GET['new_value'], true, $currency['currency'], $currency['currency_value']);
          mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET text = ? WHERE orders_id = ? and class = ?", "sis", array($text, $_GET['oID'], $_GET['class']));
        }
        mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET " . tep_db_input($_GET['column']) . " = ? WHERE orders_id = ? and class = ?", "sis", array($_GET['new_value'], $_GET['oID'], $_GET['class']));
        tep_db_update_totals($_GET['oID']);
        #Send Success Message
        header('Content-Type: application/json');
        die( json_encode( array( 'status' => 'success', 'message' => 'Total Updated.' ) ) );
  } elseif ($action == 'new_order_total') {
        $sort_order_query = mysqli_prepared_query("SELECT max(sort_order) as maxim from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? and class != 'ot_total'", "i", array($_GET['oID']));
        $sort_order = $sort_order_query[0];
        $new_sort_order = (int)$sort_order['maxim'] + 1;
   #Get the order's currency
        $currency_query = mysqli_prepared_query("SELECT currency, currency_value from " . TABLE_ORDERS . " WHERE orders_id = ?", "i", array($_GET['oID']));
        $currency = $currency_query[0];
        $class_query = mysqli_prepared_query("SELECT class from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? and class like '%ot_extra_%'", "i", array($_GET['oID']));
        $classs = 'ot_extra_' . (count($class_query) + 1);
        $new_order_total_value_txt = $currencies->format($_GET['value'], true, $currency['currency'], $currency['currency_value']);
        mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET sort_order = ? WHERE orders_id = ? and class = 'ot_total'", "ii", array(((int)$new_sort_order + 1), $_GET['oID']));
        #Fix Taxes
        if ( isset($_GET['add_tax']) && $_GET['add_tax'] == "1" ) {
          $selected_tax_query = mysqli_prepared_query("SELECT * from " . TABLE_TAX_RATES . " WHERE tax_class_id = ?", "i", array($_GET['tax_value']));
          $selected_tax = $selected_tax_query[0];
          $new_tax = $_GET['value'] * ( $selected_tax['tax_rate'] / 100 );
          $new_text = $currencies->format($new_tax, true, $currency['currency'], $currency['currency_value']);
          $orders_total_tax_query = mysqli_prepared_query("SELECT * from " . TABLE_ORDERS_TOTAL . " WHERE orders_id = ? and class = 'ot_tax'", "i", array($_GET['oID']));
          $tax_updated = false;
          foreach ($orders_total_tax_query as $orders_total_tax) {
                if ( $tax_updated === false ) {
                  if ( $orders_total_tax['title'] == $selected_tax['tax_description'] ) {
                        $new_tax += $orders_total_tax['value'];
                        $new_text = $currencies->format($new_tax, true, $currency['currency'], $currency['currency_value']);
                        mysqli_prepared_query("update " . TABLE_ORDERS_TOTAL . " SET text = ?, value = ? WHERE orders_total_id = ? and class = 'ot_tax'", "sdi", array($new_text, number_format($new_tax, 4), $orders_total_tax['orders_total_id']));
                        $tax_updated = true;
                        break;
                  }
                }
          }
          if ( $tax_updated === false ) {
                mysqli_prepared_query("INSERT INTO " . TABLE_ORDERS_TOTAL . " (orders_id, title, text, value, class, sort_order) VALUES (?, ?, ?, ?, 'ot_tax', 3)", "issd", array($_GET['oID'], $selected_tax['tax_description'], $new_text, $new_tax));
          }
        }
        mysqli_prepared_query("INSERT INTO " . TABLE_ORDERS_TOTAL . " (orders_id, title, text, value, class, sort_order) VALUES (?, ?, ?, ?, ?, ?)", "issdsi", array($_GET['oID'], $_GET['title'] . ':', $new_order_total_value_txt, round((float)$_GET['value'], 4), $classs, $new_sort_order));
   
  #Send Success Message
  header('Content-Type: application/json');
  die( json_encode( array( 'status' => 'success', 'message' => 'New Field Added.' ) ) );
  }
  ?>