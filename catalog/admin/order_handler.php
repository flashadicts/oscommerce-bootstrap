<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

  require('includes/application_top.php');

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

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'update_order':
        $oID = tep_db_prepare_input($_GET['oID']);
        $status = tep_db_prepare_input($_POST['status']);
        $comments = tep_db_prepare_input($_POST['comments']);

        $order_updated = false;
        $check_status_query = mysqli_prepared_query("select customers_id, customers_name, customers_email_address, payment_method, date_purchased, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = ?", "i", array($_GET['oID']));
        $check_status = $check_status_query[0];

        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments)) {
          mysqli_prepared_query("update " . TABLE_ORDERS . " set orders_status = ?, last_modified = now() where orders_id = ?", "ii", array($status, $_GET['oID']));

          $customer_notified = '0';
          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
            $notify_comments = '';
            if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on')) {
              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
            }

            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);

            tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

            $customer_notified = '1';
          }

          mysqli_prepared_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values (?, ?, now(), ?, ?)", "iiis", array($_GET['oID'], $status, $customer_notified, $comments));

          $order_updated = true;
        }

        if ($order_updated == true) {
         //$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
          $comment_table =
'<table border="1" cellspacing="0" cellpadding="5">' .
'          <tr>' .
'            <td class="smallText" align="center"><b>' . TABLE_HEADING_DATE_ADDED . '</b></td>' .
'            <td class="smallText" align="center"><b>' . TABLE_HEADING_CUSTOMER_NOTIFIED . '</b></td>' .
'            <td class="smallText" align="center"><b>' . TABLE_HEADING_STATUS . '</b></td>' .
'            <td class="smallText" align="center"><b>' . TABLE_HEADING_COMMENTS . '</b></td>' .
'          </tr>';

    $orders_history_query = mysqli_prepared_query("select orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = ? order by date_added", "i", array($oID));
    if (count($orders_history_query)) {
      foreach ($orders_history_query as $orders_history) {
        $comment_table .=
             '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history['customer_notified'] == '1') {
          $comment_table .=
          tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
        } else {
          $comment_table .=
          tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
        }
        $comment_table .=
             '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
             '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
      }
    } else {
      $comment_table .=
             '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
$comment_table .=
'</table>';

          #Success
          header('Content-Type: application/json');
          die( json_encode( array( 'status' => 'success', 'message' => preg_replace('/^.+:/', '', SUCCESS_ORDER_UPDATED), 'html' => json_encode( $comment_table ) ) ) );
        } else {

          #Error
          header('Content-Type: application/json');
          die( json_encode( array( 'status' => 'error', 'message' => preg_replace('/^.+:/', '', WARNING_ORDER_NOT_UPDATED) ) ) );
        }

        tep_redirect(tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action')) . 'action=edit'));
        break;
      case 'deleteconfirm':
        $oID = tep_db_prepare_input($_GET['oID']);

        tep_remove_order($oID, $_POST['restock']);

        tep_redirect(tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action'))));
        break;
    }
  }

  if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = tep_db_prepare_input($_GET['oID']);

    $orders_query = mysqli_prepared_query("select orders_id from " . TABLE_ORDERS . " where orders_id = ?", "i", array($oID));
    $order_exists = true;
    if (!count($orders_query)) {
      $order_exists = false;
      //$messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }

  include(DIR_WS_CLASSES . 'order.php');

  if (!isset($_GET['ajax'])) $_GET['ajax'] = null;

if ($_GET['ajax'] != '1') {
  require(DIR_WS_INCLUDES . 'template_top.php');
}
?>
<div id="ajax_loader">
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
<div id="add-Product" class="addProduct" style="position:fixed;">
  <h4><?php echo DIV_ADD_PRODUCT_HEADING; ?></h4>
  <div id="add-product-product" class="addProductContents"><?php echo ADD_PRODUCT_SELECT_PRODUCT; ?></div>
  <div id="addProductSearch" class="addProductContentsSearch"><?php require (DIR_WS_INCLUDES . 'advanced_search.php'); ?></div>
  <div id="addProductFind"><span id="addProdName"></span></div>
  <div id="ProdAttr">&nbsp;</div>
  <?php echo '<span class="tdbLink"><a id="tdbCancel" href="javascript: $( this ).hideAddProducts();">' . IMAGE_CANCEL . '</a></span><script type="text/javascript">$("#tdbCancel").button({icons:{primary:"ui-icon-close"}}).addClass("ui-priority-secondary").parent().removeClass("tdbLink");</script>'; ?>
</div>
<!-- Modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" id="myModalButton" data-target="#myModal"></button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Batch Delete</h4>
      </div>
      <div class="modal-body" id="ajaxOrderDelete">
      </div>
      <div class="modal-footer">
        <div id="sortByProduct" class="input-group btn-group navbar-form navbar-left" style="width: 500px;" data-toggle="buttons">
          <span class="input-group-addon"><b class="glyphicon"></b><?php echo TEXT_INFO_RESTOCK_PRODUCT_QUANTITY; ?></span>
          <label class="btn btn-lg btn-default">
            <?php echo tep_draw_checkbox_field('restock'); ?>
            X
          </label>
        </div>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" name="batch_confirm" data-href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action')) . 'ajax=1'); ?>" id="batch_confirm" class="btn btn-danger"><?php echo IMAGE_DELETE; ?></button>
      </div>
    </div>
  </div>
</div>
<div id="orderTable">
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);

    if ($_GET['ajax'] != '1') {
?>

<script type="text/javascript">
//var btn = $.fn.button.noConflict(); // reverts $.fn.button to jqueryui btn
//$.fn.btn = btn; // assigns bootstrap button functionality to $.fn.btn
polling = false;
$(function(){
  $( "#navigationBottom" ).hide();
  $( "#navigationTop" ).hide();
});
</script>
<?php
    }

    echo tep_draw_form('batch_orders', 'print_batch_process_2.php', '', 'post', 'id="batch_orders"') . tep_draw_hidden_field('batch_order_numbers[' . (int)$_GET['oID'] . ']', 'No') . '</form>';
?>

      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td id="pageHeading" <?php echo ($_GET == array('ajax' => null) ? 'style="visibility:hidden;"' : ''); ?>><h1><?php echo HEADING_TITLE; ?> <small>Rev 2</small></h1></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText ajax_disable" align="right"><?php echo tep_draw_button(TOOLTIP_DUPLICATE_ORDER, 'trash', tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$_GET['oID'] . '&cID=' . $_GET['cID'] . '&action=duplicate_order'), 'secondary', array('params' => 'class="duplicate_order"')) . '<span class="ajax_disable">' . tep_draw_button(IMAGE_DELETE, 'trash', tep_href_link("oc_batch_delete_confirm.php", 'oID=' . (int)$_GET['oID']), 'secondary', array('params' => 'class="batch_delete"')) . '</span>' . tep_draw_button(IMAGE_CREATE_ORDER, 'document', tep_href_link(FILENAME_CREATE_ORDER, tep_get_all_get_params(array('action', 'oID', 'ajax')) . 'Customer_nr=' . $_GET['cID'])) . tep_draw_button(IMAGE_ORDERS_INVOICE, 'document', tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']), null, array('newwindow' => true)) . tep_draw_button(IMAGE_ORDERS_PACKINGSLIP, 'document', tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']), null, array('newwindow' => true)) . tep_draw_button(IMAGE_BACK, 'back', tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action'))), 'secondary', array('params' => 'class="ajax_button"')); ?></td>
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
                     '                <td class="dataTableContent" valign="top" align="right" width="3%"><a data-class="' . $order->totals[$i]['class'] . '" data-action="eliminate" data-title="'.addslashes(htmlspecialchars($order->totals[$i]['title'])).'" href="' . tep_href_link('orders_ajax.php', tep_get_all_get_params(array('action', 'page', 'status', 'ajax')) . 'action=eliminate_field') . '" class="ajaxLinkTotals">' . tep_image(DIR_WS_ICONS . 'delete.png', ICON_TICK) . '</a></td>' . "\n" .
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
      <tr><?php echo tep_draw_form('status', FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action')) . 'action=update_order', 'post', 'id="update_status"'); ?>
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
            
            <td class="smallText" align="right"><?php echo tep_draw_button(IMAGE_CREATE_ORDER, 'document', tep_href_link(FILENAME_CREATE_ORDER, 'Customer=' . (int)$_GET['cID'])) . tep_draw_button(IMAGE_ORDERS_INVOICE, 'document', tep_href_link(FILENAME_ORDERS_INVOICE, 'oID=' . $_GET['oID']), 'secondary', array('params' => 'target="_blank"')) . tep_draw_button(IMAGE_ORDERS_PACKINGSLIP, 'document', tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $_GET['oID']), 'secondary', array('params' => 'target="_blank"')) . tep_draw_button(IMAGE_BACK, 'back', tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action'))), 'secondary', array('params' => 'target="_blank" class="ajax_button"')); ?></td>
          </tr>
        </table></td>
      </form>
    </tr>
  </table>
<?php
  } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td id="pageHeading" <?php echo ($_GET == array('ajax' => null) ? 'style="visibility:hidden;"' : ''); ?> ><h1><?php echo HEADING_TITLE; ?> <small>Rev 2</small></h1>
        </td>
      </tr>
    </table></td>
</tr>
          
<?php 
if (!isset($_GET['order'])) $_GET['order'] = "DESC";
if (!isset($_GET['sortby'])) $_GET['sortby'] = "orders_id";

echo 
tep_draw_form('batch_orders', 'print_batch_process_2.php', '', 'post', 'target="_newtab" id="batch_orders"'). "\n"; ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
 <td valign="top"><table width="99%" class="ordersTable table table-hover table-condensed table-bordered" id="ordersTable">

  <thead>
    <tr class="dataTableHeadingRow" style="background-image:linear-gradient(to bottom, rgb(66, 139, 202) 0%, rgb(48, 113, 169) 100%)">
      <td class="dataTableHeadingContent" align="left" style=""><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby','order', 'action', 'ajax')) . 'sortby=customers_name') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo TABLE_HEADING_CUSTOMERS; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'customers_name') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      <td class="dataTableHeadingContent" align="left" style=""><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby','order', 'action', 'ajax')) . 'sortby=value') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'value') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      <td class="dataTableHeadingContent" align="left" style=""><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby','order', 'action', 'ajax')) . 'sortby=date_purchased') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'date_purchased') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      <td class="dataTableHeadingContent" align="left"><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby', 'order', 'action', 'ajax')) . 'sortby=orders_status') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo TABLE_HEADING_STATUS; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'orders_status') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      
      <?php
      echo (isset($_GET['order_by_prod_quantity']) ? '<td class="dataTableHeadingContent" align="center"><a class="dataTableHeadingContent ajax_button" href="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby','order', 'action', 'ajax')) . 'sortby=products_quantity') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC') . '">'.TABLE_HEADING_QUANTITY.'</a><span class="' . (($_GET['sortby'] == 'products_quantity') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span></td>' : '');
      ?></td>
      <td class="dataTableHeadingContent" align="center"><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby', 'order', 'action', 'ajax')) . 'sortby=orders_id') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo ENTRY_ORDER_NUMBER; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'orders_id') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      <td class="dataTableHeadingContent" align="left"><a class="dataTableHeadingContent ajax_button" href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('sortby', 'order', 'action', 'ajax')) . 'sortby=payment_method') . (($_GET['order'] == 'DESC') ? '&order=ASC' : '&order=DESC'); ?>"><?php echo EMAIL_TEXT_PAYMENT_METHOD; ?></a><?php echo '<span class="' . (($_GET['sortby'] == 'payment_method') ? (($_GET['order'] == 'DESC') ? 'fa fa-caret-up' : 'fa fa-caret-down'): '') . '" style="margin-right:7px;margin-left: 13px;float:right;"></span>'; ?></td>
      <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
      <td class="dataTableHeadingContent" align="right"><input name="allbox" type="checkbox" value="Check All" onclick="CheckAll(document.batch_orders);" /></td>
      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
    </tr>
  </thead>
                
<?php

/* Orders Selection Queries */

  #Sort by Search
    if(isset($_GET['search']) && !empty($_GET['search'])) {
      $orderby = (isset($_GET['sortby']) && !empty($_GET['sortby']) ? (($_GET['sortby'] == 'value') ? 'ot.' : '') . $_GET['sortby'] : 'o.orders_id ') . ' ' . (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'DESC');
      $params = array('%'.$_GET['search'].'%', '%'.$_GET['search'].'%', $_GET['search'], $_GET['search'], $languages_id);
      $typeDef = "sssii";
	 		$orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.customers_id, 				
			o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, 			
			s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . 			
			TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id) left join " .      
            TABLE_ORDERS_STATUS . " s on (o.orders_status=s.orders_status_id) where      
            (o.customers_name like ? or o.customers_email_address like ? or o.customers_id like ? or o.orders_id = ?) and s.language_id = ?
            and ot.class = 'ot_total' order by ".$orderby;
          $query_num_rows_query = array("SELECT count(*) as total FROM orders WHERE (customers_name like ? or customers_email_address like ? or customers_id like ?)", "sss", array('%'.$_GET['search'].'%', '%'.$_GET['search'].'%', '%'.$_GET['search'].'%'));

		} elseif (isset($_GET['status']) && $_GET['status'] > '0' && !isset($_GET['order_by_prod_quantity'])) {

    #Sort by Status
      $orderby = (isset($_GET['sortby']) && !empty($_GET['sortby']) ? (($_GET['sortby'] == 'value') ? 'ot.' : '') . $_GET['sortby'] : 'o.orders_id ') . ' ' . (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'DESC');
      $params = array($languages_id, $_GET['status']);
      $typeDef = "ii";

		  $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o join " . TABLE_ORDERS_STATUS_HISTORY . " osh left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and o.orders_id = osh.orders_id and osh.orders_status_id = '1' and s.language_id = ? and s.orders_status_id = ? and ot.class = 'ot_total' GROUP BY o.orders_id order by ".$orderby;
      $query_num_rows_query = array("SELECT count(*) as total FROM orders WHERE orders_status = ?", "i", array($_GET['status']));

		} elseif (isset($_GET['order_by_prod_quantity'])) {
    
    #Sort by Products Quantity
      $orderby = (isset($_GET['sortby']) && !empty($_GET['sortby']) ? (($_GET['sortby'] == 'value') ? 'ot.' : '') . $_GET['sortby'] : 'o.orders_id ') . ' ' . (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'DESC');
      $params = array($languages_id);
      $typeDef = "i";

      if(isset($_GET['status']) && is_numeric($_GET['status'])) $status = "AND o.orders_status = '" . (int)$_GET['status'] . "'";

      $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total, sum(op.products_quantity) AS products_quantity from " . TABLE_ORDERS . " o LEFT JOIN " . TABLE_ORDERS_TOTAL . " ot ON (o.orders_id = ot.orders_id) LEFT JOIN " . TABLE_ORDERS_PRODUCTS . " op ON (o.orders_id = op.orders_id), " . TABLE_ORDERS_STATUS . " s WHERE s.language_id = ? " . (isset($status)?$status:''). " AND s.orders_status_id = o.orders_status AND ot.class = 'ot_total' GROUP BY op.orders_id ORDER BY ".$orderby;
      $query_num_rows_query = array("SELECT count(*) as total FROM orders " . (isset($status)?"WHERE orders_status = '".(int)$_GET['status']."'" : ''));

    } else {

      #Default Sort
      $orderby = (isset($_GET['sortby']) && !empty($_GET['sortby']) ? (($_GET['sortby'] == 'value') ? 'ot.' : '') . $_GET['sortby'] : 'o.orders_id ') . ' ' . (isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'DESC');
      $params = array($languages_id);
      $typeDef = "i";

		  $orders_query_raw = "select o.orders_id, o.customers_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = ? and ot.class = 'ot_total' order by ".$orderby;
      $query_num_rows_query = array("SELECT count(*) as total FROM orders");

    }

    $query_num_rows = mysqli_prepared_query($query_num_rows_query[0], (isset($query_num_rows_query[1]) ? $query_num_rows_query[1] : false), (isset($query_num_rows_query[2]) ? $query_num_rows_query[2] : false));
    $query_num_rows = $query_num_rows[0]['total'];

    $orders_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $orders_query_raw, $orders_query_numrows, $query_num_rows);

    $orders_query = mysqli_prepared_query($orders_query_raw, $typeDef, $params);

    $link = "db_link";
    global $$link;

    /* prepare statement */
    $sql = "SELECT comments FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_id = ? AND comments != '' ORDER BY date_added ASC LIMIT 1";
    $stmt = mysqli_prepare($$link, $sql);

    /* bind parameters to prepared statement */
    mysqli_stmt_bind_param($stmt, 'i', $orders_id);

    foreach ($orders_query as $orders) {

      // Kiss Error Debugger
      $start_time = microtime( true );

      $orders_id = $orders['orders_id'];
      mysqli_stmt_execute($stmt);

      /* bind variables to prepared statement */
      mysqli_stmt_bind_result($stmt, $comments);

      /* fetch values */
      mysqli_stmt_fetch($stmt);

      // Kiss Error Debugger
      if ( class_exists( 'KissER' ) ) {
        KissER::q( round( ( microtime( true ) - $start_time ), 4 ), $sql );
      }

      if (isset($comments)) {
        $orders['comments'] = $comments;
      } else {
        $orders['comments'] = '';
      }



      if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders);
      }

      if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
        echo '              <tr class="dataTableRow info ' . (int)$orders['orders_id'] . '" data-customers_name="' . $orders['customers_name'] . '" data-order_total="' . strip_tags($orders['order_total']) . '" id="defaultSelected" data-link="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . (int)$orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . "\n";
        //$link = 'data-link="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '"';
      } else {
        echo '              <tr class="dataTableRow ' . (int)$orders['orders_id'] . '" data-customers_name="' . $orders['customers_name'] . '" data-order_total="' . strip_tags($orders['order_total']) . '" data-link="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . (int)$orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . "\n";
        //$link = 'data-link="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '"';
      }

?>
                <?php
        echo '<td class="dataTableContent">' . "\n" .
              '<a class="edit_order tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_EDIT_ORDERS . '" href="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . '<span class="glyphicon glyphicon-pencil"></span>' .
              '</a>' . $orders['customers_name']; ?></td>

                <?php
        echo '<td class="dataTableContent">' . "\n" .
              strip_tags($orders['order_total']); ?></td>

                <?php
	  if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
        echo '<td class="dataTableContent">' . "\n";
      } else {
        echo '<td class="dataTableContent" style="width: 200px;">' . "\n";
      }
?><?php echo tep_datetime_short($orders['date_purchased']); ?></td>

                <?php
        echo '<td class="dataTableContent">' . "\n" .
              $orders['orders_status_name']; ?></td>

                <?php
    if (isset($_GET['order_by_prod_quantity'])) {
      if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
        echo '<td align="center" style="font-weight: bold;" class="dataTableContent">' . "\n";
      } else {
        echo '<td class="dataTableContent" align="center" style="font-weight: bold;" data-link="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . "\n";
      }
?><?php echo (int)$orders['products_quantity']; ?></td>

				<?php
    }
		if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
			echo '<td align="center" style="font-weight: bold;" class="dataTableContent">' . "\n";
		} else {
			echo '<td class="dataTableContent" align="center" style="font-weight: bold;" onmouseover="" onmouseout="" data-link="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id'] . '&cID=' . (int)$orders['customers_id']) . '">' . "\n";
		}
?><?php echo $orders['orders_id']; ?></td>

<?php
if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
echo '<td class="dataTableContent">' . "\n";
} else {
echo '<td class="dataTableContent" style="width:200px;">' . "\n";
}
?><?php echo $orders['payment_method']; ?></td>

<?php
if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
echo '<td class="dataTableContent">' . "\n";
} else {
echo '<td class="dataTableContent" style="">' . "\n";
}
?><?php echo '<span class="comments" data-placement="bottom" title="' . tep_output_string_protected($orders['comments']) . '">' . tep_output_string_protected($orders['comments']) . '</span>' ?></td>

				<td class="dataTableContent ajax_disable" align="right" style="width: 30px;"><?php echo tep_draw_checkbox_field('batch_order_numbers[' . $orders['orders_id'] . ']', 'no', '' , 'yes', 'onclick="CheckCheckAll(document.trackunread)'); ?></td>
				<td class="dataTableContent ajax_disable" align="right"><?php echo '<a class="mail_confirmation tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_MAIL_CONFIRMATION . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&cID=' . $orders['customers_id'] . '&action=mail_confirmation') . '">' . '<span class="fa fa-envelope"></span>' . '</a>' . '<a class="duplicate_order tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_DUPLICATE_ORDER . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&cID=' . $orders['customers_id'] . '&action=duplicate_order') . '">' . '<span class="fa fa-files-o"></span>' . '</a>' . '<a class="expand_order tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_EXPAND_ORDER . '" style="margin-right:10px;" href="' . tep_href_link('ajax_handler.php', tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'get_order=' . (int)$orders['orders_id'] . '&action=get_order') . '">' . '<span class="glyphicon glyphicon glyphicon-resize-full"></span>' . '</a>' . '<a class="create_order tooltip_set" data-placement="bottom" data-original-title="' . IMAGE_CREATE_ORDER . '" style="margin-right:10px;" href="' . tep_href_link(FILENAME_CREATE_ORDER, tep_get_all_get_params(array('action', 'oID', 'ajax')) . 'Customer=' . $orders['customers_id']) . '">' . '<span class="glyphicon glyphicon-plus"></span>' . '</a>' . '<a class="edit_order tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_EDIT_ORDERS . '" href="' . tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('oID', 'action', 'ajax')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . '<span class="glyphicon glyphicon-pencil"></span>' . '</a>'; ?>&nbsp;</td>

      </tr>
              

<?php
    // begin batch printing by DS
    $batch_order_numbers[] = $orders['orders_id'];

    if ( !isset($last_order_number) )
      $last_order_number = (int)$orders['orders_id'];
    // end batch printing by DS
    }

    $polling = "false";

    /* close statement */
    mysqli_stmt_close($stmt);

    if ( isset($_GET['status']) && $_GET['status'] == "1" || isset( $_GET['order_by_prod_quantity'] ) || !isset($last_order_number) ) {

      if ( $query_num_rows <= 0 || $last_order_number == null || isset( $_GET['order_by_prod_quantity'] ) ) {
        $last_order = mysqli_prepared_query("SELECT DISTINCT orders_id FROM " . TABLE_ORDERS . " ORDER BY orders_id DESC LIMIT 1");
        $last_order_number = (int)$last_order[0]['orders_id'];
      }

      if ( $_GET['status'] == "1" )
        $polling = "true";
    }

    echo <<<EOD
<script type="text/javascript">
polling = $polling;
last_order_number = '$last_order_number';
languages_id = '$languages_id';
window.name = "parent";

$(function(){
  //$('.comments').tooltip('toggle').tooltip('hide');
  if ( polling === false ) {
    var cog = $( "#poller" ).find( "i.fa-cog" ),
        success = $( "#poller" ).find( "label" ).eq( 0 ),
        danger = $( "#poller" ).find( "label" ).eq( 1 );

    cog.className = "fa fa-cog fa-spin noAnimation";
    danger.className = "btn btn-lg btn-danger active";
    success.className = "btn btn-lg btn-default";
    polling = false;
    //return $( this ).gritter( "Ajax Long-Polling", "Polling has been Disabled.", true );
  } else {
    setTimeout( function(){ $( "#poller" ).find( "label" ).eq( 0 ).click(); },1000);
  }
});
</script>
EOD;
?>
</form>

        <thead>
         <tr>
          <td colspan="10"><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
              <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('page', 'oID', 'action', 'ajax'))); ?></td>
            </tr>
            </table>
          </td>
        </thead>
      </table></td>
    </td>
  </tr>
</table></td>

</tr>
<?php
  }
?>
  
<!-- body_text_eof //-->
  </tr>
</table>
</div>
<!-- body_eof //-->

<div id="dialog-form" title="Add a new field">
  <p class="validateTips"></p>
 
  <?php echo tep_draw_form('new_field', FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action', 'ajax')), 'post', 'id="new_field"') . tep_draw_hidden_field('action', 'new_order_total', 'id="new_order_total"');

  $tax_class_array = array(array('id' => '0', 'text' => TEXT_NONE));
  $tax_class_query = mysqli_prepared_query("select tax_class_id, tax_rate, tax_description from " . TABLE_TAX_RATES . " order by tax_class_id");
  foreach ($tax_class_query as $tax_class) {
    $tax_class_array[] = array('id' => $tax_class['tax_class_id'],
                               'text' => $tax_class['tax_description'] . " (" . round($tax_class['tax_rate'], 2) . "%)");
  }
  ?>
    <fieldset>
      <label for="title">Name</label>
      <input type="text" name="title" id="title" class="text ui-widget-content ui-corner-all">
      <label for="value">Value (incl. any VAT)</label>
      <input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all">
      <label for="taxvalue">Add tax</label>
    </fieldset>
    <div class="input-group navbar-form btn-group navbar-left" style="width:130px;margin-left:1%;margin-right:2%;padding:0;" data-toggle="buttons">
      <span class="input-group-addon"><i class="fa fa-plus-square fa-2"></i>
      </span>
      <label class="btn btn-sm btn-info">
        Yes<input type="radio" name="add_tax" value="1"></label>
        <label class="btn btn-sm btn-info active">
          <input type="radio" name="add_tax" value="0" checked="checked">No        </label>
    </div>
    <div class="input-group tax_drop" style="margin-top: 14px;height: 30px;margin-right:16px;">
      <?php echo tep_draw_pull_down_menu('tax_value', $tax_class_array, (isset($pInfo->products_tax_class_id) ? $pInfo->products_tax_class_id : ''), 'id="tax_value" style="width: 120px;padding: 0.6em;float:right;height: 30px;" class="form-control"'); ?>
      <i class="input-group-addon">%</i>

    </div>
  </form>
</div>

<div id="parseTime"><div><h2 id="pTime"></h2><span id="kiss_info"></span></div></div>
<?php
  if ($_GET['ajax'] == '1')
    tep_exit();

?>
<!-- Top Navbar -->
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation" id="navigationTop">
  <div class="navbarOverlay"></div>
  <div class="container-fluid">
    <div class="input-group btn-group navbar-form navbar-left tooltip_set" data-placement="bottom" data-original-title="<?php echo TOOLTIP_ADMIN_MENU; ?>" style="width:130px;padding-left:40px;">
      <input type="checkbox" class="js-switch" checked />
    </div>
    <div class="input-group btn-group navbar-form navbar-left" style="width:15%;min-width:250px;" data-toggle="buttons">
      <input type="checkbox" name="order_by_prod_quantity" <?php echo (isset($_GET['order_by_prod_quantity']) ? 'checked="checked"' : ''); ?> id="order_by_prod_quantity">
      <label for="order_by_prod_quantity"><?php echo TEXT_INFO_ORDER_BY_PRODUCTS_QUANTITY; ?></label>
    </div>
    <?php
    echo
    tep_draw_form('search', FILENAME_ORDERS_HANDLER, '', 'get', 'class="navbar-form" role="search"') .
      '<div class="form-group navbar-left navbar-form" style="width: 25%;margin-left: 10%;">' .
        tep_draw_input_field('search', '', 'class="bigdrop" placeholder="Search by Name, E-Mail, Order Number, Customer Number" id="search_orders" style="min-width:335px;"') .
      '</div>' .
    '</form>'; ?>
    <?php
    echo
    tep_draw_form('status', FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action', 'status', 'order_by_prod_quantity', 'order')) . 'order=' . ($_GET['order'] == "DESC" ? "ASC" : "DESC"), 'get', 'id="select_status"') .
      '<div class="form-group navbar-left navbar-form tooltip_set" data-placement="bottom" data-original-title="' . TOOLTIP_SORT_STATUS . '" style="width:20%;margin-left: 8%;">' .
        tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'id="status" style="width:100%;"') .
      '</div>' .
    '</form>'; ?>
    <div class="input-group btn-group navbar-form navbar-right" style="width:50px;" data-toggle="buttons">
      <label class="btn btn-lg btn-danger" style="display:none;padding: 0px 5px 0px 5px;z-index:100;margin-right:20px;" id="gritterRemove">
          <i class="fa fa-times fa-2 tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_DISABLE_POLLING; ?>" style="width: 20px;font-size:1.5em;z-index:0;"></i>
          <?php echo tep_draw_checkbox_field('long_poller'); ?>
        </label>
    </div>
    <!--div class="navbar-header navbar-left">
      <i class="fa fa-money fa-2x" style="color: rgb(255, 196, 20);margin: 10px;padding-left: 50px;"></i>
    </div-->
  </div>
</nav>
<!-- Top Navbar -->
<?php
echo tep_draw_form('navbar', 'print_batch_process_2.php', '', 'post', 'target="_newtab" id="navbar"'); ?>
<!-- Bottom Navbar -->
  <nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse" role="navigation" id="navigationBottom">
    <div class="navbarOverlay"></div>
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

      </button>
      <a class="navbar-brand" href="javascript:void(0);">Menu</a>
    </div>

    <div class="container-fluid">
      <div class="btn-group navbar-form navbar-left" style="width: 325px;" data-toggle="buttons">
        <label class="btn btn-lg btn-primary active">
          <?php echo tep_draw_radio_field('target_file', FILENAME_ORDERS_INVOICE, true) . ENTRY_INVOICE; ?>
        </label>
        <label class="btn btn-lg btn-primary">
          <?php echo tep_draw_radio_field('target_file', 'labels') . ENTRY_ENVELOPE; ?>
        </label>
        <label class="btn btn-lg btn-primary">
          <?php echo tep_draw_radio_field('target_file', 'export') . ENTRY_EXPORT; ?>
        </label>
      </div>

      <div class="input-group navbar-form btn-group navbar-left" style="margin-left:1%;margin-right:2%;width: 180px;padding:0;" data-toggle="buttons">
        <span class="input-group-addon"><b class="glyphicon glyphicon-envelope"></b></span>
        <label class="btn btn-lg btn-info tooltip_set" data-placement="top" data-original-title="<?php echo IMAGE_SEND_EMAIL; ?>">
          <?php echo ENTRY_NOTIFY_YES . tep_draw_radio_field('notify', 'Yes'); ?>
        </label>
        <label class="btn btn-lg btn-info active tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_DO_NOT . IMAGE_SEND_EMAIL; ?>" style="border-bottom-right-radius:4px;border-top-right-radius:4px;">
          <?php echo tep_draw_radio_field('notify', 'No', true) . ENTRY_NOTIFY_NO; ?>
        </label>
      </div>

      <div class="input-group btn-group navbar-form navbar-left" style="width: 500px;" data-toggle="buttons">
        <span class="input-group-addon"><b class="glyphicon"></b><?php echo ENTRY_UPDATE_STATUS; ?></span>
        <label class="btn btn-lg btn-info tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_UPDATE_STATUS; ?>">
          <?php echo ENTRY_NOTIFY_YES . tep_draw_radio_field('autoupdatestatus', 'Yes'); ?>
        </label>
        <label class="btn btn-lg btn-info active tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_DO_NOT . TOOLTIP_UPDATE_STATUS; ?>">
          <?php echo tep_draw_radio_field('autoupdatestatus', 'No', true) . ENTRY_NOTIFY_NO; ?>
        </label>
        <?php echo tep_draw_pull_down_menu('autostatus', $orders_statuses, 3, 'id="autostatus" class="multiselect btn btn-lg btn-info"'); ?>
      </div>


      <div class="btn-group navbar-form navbar-left" style="">
        <a href="<?php echo tep_href_link(FILENAME_ORDERS_HANDLER, tep_get_all_get_params(array('action'))); ?>" target="_newtab" type="submit" class="submit_button btn btn-lg btn-success ui-priority-primary"><?php echo IMAGE_CONFIRM; ?></a>
      </div>

      <div class="input-group input-group-lg btn-group navbar-form navbar-left" style="width:250px;" id="poller" data-toggle="buttons">
        <span class="input-group-addon"><i class="fa fa-cog fa-spin noAnimation"></i></span>

          <?php echo tep_draw_input_field('poll_timer', '5', 'id="poll_timer" class="form-control tooltip_set" data-placement="top" data-original-title="' . TOOLTIP_TIMEOUT . '" placeholder="20" style="width:55px;"'); ?>

        <label class="btn btn-lg btn-default" style="padding: 9px 16px 8px 10px;">
          <i class="fa fa-check fa-2 tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_ENABLE_POLLING; ?>" style="width: 20px;font-size:1.5em;"></i>
          <?php echo tep_draw_checkbox_field('long_poller'); ?>
        </label>
        <label class="btn btn-lg btn-danger active" style="padding: 9px 14px 8px 12px;z-index:100;">
          <i class="fa fa-times fa-2 tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_DISABLE_POLLING; ?>" style="width: 20px;font-size:1.5em;z-index:0;"></i>
          <?php echo tep_draw_checkbox_field('long_poller'); ?>
        </label>

      </div>

      <div class="btn-group navbar-form navbar-right" style="/*position:absolute;right:0;top:0;*/">
        <button type="button" id="batch_delete" name="batch_delete" class="btn btn-lg btn-danger navbar-right ui-priority-secondary tooltip_set" data-placement="top" data-original-title="<?php echo TOOLTIP_DELETE_ORDERS; ?>"><?php echo IMAGE_DELETE; ?></button>
      </div>

    </div>
  </nav>
</form>
<!-- Bottom Navbar -->

<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap-multiselect-3.1.1.js"></script>
<script type="text/javascript" src="js/select2.js"></script>
<script type="text/javascript" src="js/icheck.js"></script>
<script type="text/javascript" src="js/switchery.js"></script>
<script type="text/javascript" src="js/order_handler.js"></script>
<script type="text/javascript" src="js/jquery.gritter.js"></script>
<script type="text/javascript" src="js/tikslusdialog.js"></script>
<script type="text/javascript" src="js/history.js"></script>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>