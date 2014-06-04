<?php

  require_once('includes/application_top.php');

  require_once(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  include_once(DIR_WS_CLASSES . 'order.php');


?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" class="ajaxOrderDelete">

	<tr>
		<td>
			<form name="delete" id="formDelete" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="action" value="deleteconfirm">
			<input type="hidden" name="batch_confirm_x" value="1"><input type="hidden" name="batch_delete_y" value="1">
			<table border="0" width="100%" cellspacing="1" cellpadding="2" bgcolor="#000000">
				<tr class="dataTableHeadingRow">
					<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDER_NUMBER; ?></td>
					<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
					<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
					<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
					<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
				</tr>
				<?php
					foreach($batch_order_numbers as $oID) {
						$order = new order($oID);
						?>
							<tr class="dataTableRow">
								<td class="dataTableContent"><input type="hidden" name="order_nums[]" value="<?=$oID?>"><?php echo $oID; ?></td>
								<td class="dataTableContent"><?php echo $order->customer['name']; ?></td>
								<td class="dataTableContent"><?php echo $order->info['order_total']; ?></td>
								<td class="dataTableContent"><?php echo $order->info['date_purchased']; ?></td>
								<td class="dataTableContent"><?php echo tep_get_orders_status_name($order->info['orders_status'], $languages_id); ?></td>
							</tr>

						<?php
					}
				?>
			
			</form>
		</td>
	</tr>
	</table>
<?php
tep_exit();
?>