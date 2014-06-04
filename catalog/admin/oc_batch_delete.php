<?php

require_once('includes/application_top.php');

$batch_order_numbers = isset($HTTP_POST_VARS['order_nums']) ? $HTTP_POST_VARS['order_nums'] : array();
$restock = false;

if (isset($_POST['restock']))
	$restock = true;

foreach($batch_order_numbers as $oID) {
	tep_remove_order($oID, $restock);
}

?>
<h4 class="close" data-dismiss="modal" style="font-family: sans-serif;text-align: center;width: 100%;top: 6px;position: absolute;"><?php echo TEXT_INFO_ORDER_DELETED; ?></h4>
<?php
tep_exit();
?>