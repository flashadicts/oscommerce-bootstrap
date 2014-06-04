<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

  require_once('includes/application_top.php');
  $link = "db_link";
  global $batch_order_numbers, $$link;

    include_once(DIR_WS_LANGUAGES . $language . '/order_handler.php');

    include_once(DIR_WS_CLASSES . 'order.php');

    if ( $_GET['action'] == "duplicate" ) {

      $query = "SELECT orders_id FROM orders ORDER BY orders_id DESC LIMIT 1";
      $new_order_check = mysqli_prepared_query( $query );
      $_GET['oID'] = $new_order_check[0]['orders_id'];
      header('Content-Type: text/html; charset=utf-8');
      $output = '<tr id="last_order_number" data-order="'.$_GET['oID'].'" style="display:none;"><td>' . $_GET['oID'] . '</td></tr>';
      $_GET['oID']--;
    }


    $params = array($_GET['oID'], $languages_id);

    if ( isset( $_GET['order_by_prod_quantity'] ) ) {
      $orders_data = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total, sum(op.products_quantity) AS products_quantity from " . TABLE_ORDERS . " o LEFT JOIN " . TABLE_ORDERS_TOTAL . " ot ON (o.orders_id = ot.orders_id) LEFT JOIN " . TABLE_ORDERS_PRODUCTS . " op ON (o.orders_id = op.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_id > ? AND s.language_id = ? AND ot.class = 'ot_total' AND o.orders_status = '1' AND s.orders_status_id = '1' GROUP BY o.orders_id, products_quantity ORDER BY products_quantity, o.orders_id DESC";
    } else {
     $orders_data = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o join " . TABLE_ORDERS_STATUS_HISTORY . " osh left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_id > ? and o.orders_status = s.orders_status_id and o.orders_id = osh.orders_id and osh.orders_status_id = '1' and s.language_id = ? and s.orders_status_id = '1' and ot.class = 'ot_total' GROUP BY o.orders_id order by o.orders_id DESC";
    }

    $order_data = mysqli_prepared_query($orders_data, "ii", $params);

    /* prepare statement */
    $stmt = mysqli_prepare($$link, "SELECT comments FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_id = ? AND comments != '' ORDER BY date_added ASC LIMIT 1");
    mysqli_stmt_bind_param($stmt, 'i', $orders_id);

    foreach ( $order_data as $orders ) {

      $orders_id = $orders['orders_id'];
      mysqli_stmt_execute($stmt);

      /* bind variables to prepared statement */
      mysqli_stmt_bind_result($stmt, $comments);

      /* fetch values */
      mysqli_stmt_fetch($stmt);

      if (isset($comments)) {
        $orders['comments'] = $comments;
      } else {
        $orders['comments'] = '';
      }

      $output .=  '
              <tr class="dataTableRow ' . (int)$orders['orders_id'] . '" data-customers_name="' . $orders['customers_name'] . '" data-order_total="' . strip_tags($orders['order_total']) . '" data-link="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . (int)$orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . "\n";

      $output .= '<td class="dataTableContent">' . "\n" .
                  '<a class="ajax_disable" href="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . '<span class="glyphicon glyphicon-pencil"></span>' . '</a>&nbsp;' . $orders['customers_name'] .
                '</td>' .

                '<td class="dataTableContent">' . strip_tags($orders['order_total']) . '</td>' . "\n" .
                '<td class="dataTableContent" style="width: 200px;">' . tep_datetime_short($orders['date_purchased']) . '</td>' . "\n" .
                '<td class="dataTableContent">' . strip_tags($orders['orders_status_name']) . '</td>' . "\n" .
                (isset($_GET['order_by_prod_quantity']) ? '<td align="center" style="font-weight: bold;" class="dataTableContent">' . (int)$orders['products_quantity'] . '</td>' . "\n" : '') .
                '<td class="dataTableContent" align="center" style="font-weight: bold;" onmouseover="" onmouseout="" data-link="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . strip_tags($orders['orders_id']) . '</td>' . "\n" .
                '<td class="dataTableContent" style="width:200px;">' . $orders['payment_method'] . '</td>' . "\n" .
                '<td class="dataTableContent">' . '<span class="comments" data-placement="bottom" title="' . tep_output_string_protected($orders['comments']) . '">' . tep_output_string_protected($orders['comments']) . '</span>' . '</td>' . "\n" .
                '<td class="dataTableContent ajax_disable" align="right" style="width: 30px;">' . tep_draw_checkbox_field('batch_order_numbers[' . $orders['orders_id'] . ']', 'no', '' , 'yes', 'onclick="CheckCheckAll(document.trackunread)') . '</td>' . "\n" .
                '<td class="dataTableContent ajax_disable" align="right">' . '<a class="mail_confirmation tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_MAIL_CONFIRMATION . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&cID=' . $orders['customers_id'] . '&action=mail_confirmation') . '">' . '<span class="fa fa-envelope"></span>' . '</a>' . '<a class="duplicate_order tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_DUPLICATE_ORDER . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&cID=' . $orders['customers_id'] . '&action=duplicate_order') . '">' . '<span class="fa fa-files-o"></span>' . '</a>' . '<a class="expand_order tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_EXPAND_ORDER . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&action=get_order') . '">' . '<span class="glyphicon glyphicon glyphicon-resize-full"></span>' . '</a>' . '<a class="ajax_disable tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_CREATE_ORDER . '" style="margin-right:10px;" href="' . tep_href_link(FILENAME_CREATE_ORDER, tep_get_all_get_params(array('action', 'oID', 'ajax')) . 'Customer_nr=' . $orders['customers_id']) . '">' . '<span class="glyphicon glyphicon-plus"></span>' . '</a>' . '<a class="ajax_disable tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_EDIT . '" href="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . '<span class="glyphicon glyphicon-pencil"></span>' . '</a>' . '</td>' . "\n" .
                '</tr>' . "\n";


    $batch_order_numbers[] = $orders['orders_id'];

  }

  /* close statement */
  mysqli_stmt_close($stmt);

  echo $output;
  tep_exit();
?>