<?php
/*
  $Id: contact_us.php,v 1.5 2010/02/02 Spooks Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTACT_US);

  $error = false;
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    $name = tep_db_prepare_input($_POST['name']);
    $email = tep_db_prepare_input($_POST['email']);
    $enquiry = tep_db_prepare_input($_POST['enquiry']);
		$subject = tep_db_prepare_input($_POST['subject']);
		$phone = tep_db_prepare_input($_POST['phone']);
		$date = 'Date Sent: ' . date("d M Y H:i:s");
		$orders_id = tep_not_null($_POST['orders_id']) ? $_POST['orders_id'] : false;
		$xipaddress = $_SERVER["REMOTE_ADDR"];
		$subject = $subject ? $subject : EMAIL_SUBJECT; 
		
	
		//$enquiry = preg_replace('/\r/','\', \'',$enquiry);
		//$enquiry = preg_replace('/\(|\)/','\'',$enquiry);
		//$_POST['enquiry'] = $result;
		
		if (strlen($name) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('contact', ENTRY_LAST_NAME_ERROR);
    }
		if (strlen($enquiry) < 8) {
      $error = true;

      $messageStack->add('contact', ENTRY_ERROR_ENQUIRY);
    }
		if (!tep_validate_email($email)) {
			$error = true;

      $messageStack->add('contact', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }
    if (!$error) {
		  $enquiry = MESSAGE_FROM . $name . "\n" . $date . "\n" . ($phone ? ENTRY_TELEPHONE_NUMBER .  $phone . "\n" : '' ) . ($customer_id ? MAIL_CLIENT_ID .  $customer_id . "\n" : '')  . ($orders_id ? MAIL_ORDER_ID .  $orders_id . "\n" : '') . "\n" . MAIL_IP . $xipaddress . '.' . "\n\n" . ENTRY_ENQUIRY . "\n" . $enquiry;
      tep_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $subject, $enquiry, $name, $email);

      tep_redirect(tep_href_link(FILENAME_CONTACT_US, 'action=success'));
    } 
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CONTACT_US));
  require(DIR_WS_INCLUDES . 'template_top.php');
  $account = array();$orders = array();$name = '';$email = '';$phone = '';
	if (tep_session_is_registered('customer_id')) {
			$account_query = tep_db_query("select customers_firstname, customers_lastname, customers_telephone, customers_id, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
			$account = tep_db_fetch_array($account_query);
			$name = $account['customers_firstname'].' '.$account['customers_lastname'] ;
			$email = $account['customers_email_address'] ;
			$phone = $account['customers_telephone'] ;
			$history_query = tep_db_query("select orders_id, date_purchased from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by orders_id DESC");
			$orders[0] = array('id' => '0', 'text' => ENTRY_ORDER_ID);
			while ($history = tep_db_fetch_array($history_query)) {
				$orders[] = array('id' => $history['orders_id'], 'text' => $history['orders_id'] . ENTRY_ORDERED . tep_date_short($history['date_purchased']));

			} 
	}		
echo tep_draw_form('contact_us', tep_href_link(FILENAME_CONTACT_US, 'action=send'), 'post', 'class="form-horizontal"');
 ?>
	<div class="row">
		<div class="col-md-9">
        <h1><?php echo HEADING_TITLE; ?></h1>
 <?php
  if ($messageStack->size('contact') > 0) {
?>
      <?php echo $messageStack->output('contact'); ?>
<?php
  }

  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>
   <?php echo TEXT_SUCCESS.'<br />'; ?>


        <a href="<?php echo tep_href_link(tep_href_link(FILENAME_DEFAULT));?>" class="btn btn-default btn-lg">
            <span class="new-button-details"><?php echo IMAGE_BUTTON_CONTINUE;?></span>
        </a>

<?php
  } else {
	echo tep_draw_hidden_field('phone',$phone);
?>
        <div class="row">
          <div class="col-md-4">
            <b><?php echo nl2br(STORE_NAME_ADDRESS); ?></b><br><br>
                <?php echo (OPENING_HOURS); ?>
          </div>    
          <div class="col-md-8">   
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label"><?php echo ENTRY_NAME; ?></label>
              <div class="col-sm-9">
                <?php echo (isset($account['customers_lastname']) ? $name . tep_draw_hidden_field('name',$name) : tep_draw_input_field('name', $name, 'class="form-control"')); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label"><?php echo ENTRY_EMAIL; ?></label>
              <div class="col-sm-9">
                <?php echo tep_draw_input_field('email', $email, 'class="form-control""'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="subject" class="col-sm-3 control-label"><?php echo BOX_HEADING_SUBJECT; ?></label>
              <div class="col-sm-9">
                <?php echo tep_draw_input_field('subject', '', 'class="form-control""'); ?>
              </div>
            </div>
            <?php
            if (sizeof($orders) > 1) {
            ?>
            <div class="form-group">
              <label for="orders_id" class="col-sm-3 control-label">Order</label>
              <div class="col-sm-9">
                <?php echo tep_draw_pull_down_menu('orders_id', $orders, '', 'class="form-control"');  ?>
              </div>
            </div>
            <?php
            }
            ?>
            <div class="form-group">
              <label for="enquiry" class="col-sm-3 control-label"><?php echo ENTRY_ENQUIRY; ?></label>
              <div class="col-sm-9">
                <?php echo tep_draw_textarea_field('enquiry', 'soft', 45, 10, '', 'class="form-control"'); ?>
              </div>
            </div>
              
            <div class="row">
              <div class="col-md-3">
              </div>
              <div class="col-md-9">
                <?php echo tep_draw_button('Send', 'triangle-1-e', null, 'primary', null, 'btn btn-default btn-lg'); ?>
              </div>
            </div>
          
          </div>
        </div>

<?php
  }
?>
      </form>
    </div>
<?php 
  require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
