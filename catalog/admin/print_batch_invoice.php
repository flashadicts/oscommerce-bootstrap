<?php

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_HANDLER);

  $currencies = new currencies();

  $order->query($order_id);
  $orders_history_query = array();

  //$orders_history_query = mysqli_prepared_query("SELECT orders_status_id, date_added, customer_notified, comments FROM $tablename_osh WHERE orders_id = ? ORDER BY date_added", "i", array($order_id));

  #Run the prepared statement
  $bp_se = $stmt_se->execute();

  #Error checking the execution of the prepared statement
  if ( false === $bp_se )        {
    die( json_encode( array( 'status' => 'error', 'message' => 'Executing SELECT failed: ' . htmlspecialchars($stmt_se->error) ) ) );
  }

  #Get the customers info
  $res = $stmt_se->get_result();
  while (($row = $res->fetch_assoc()))
    $orders_history_query[] = $row;

  $date = date('M d, Y');
?>

<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="30%" align="left"><span class="pageHeadingSM"><FONT FACE="Verdana" SIZE="1" COLOR="#000000"><img src="../images/store_logo.png" width="205" height="62"></font></span></td>
    <td width="30%" align="left"><span class="pageHeadingSM"><FONT FACE="Verdana" SIZE="1" COLOR="#000000"><strong><?php echo nl2br(STORE_NAME_ADDRESS); ?></strong></font></span></td>
    <TD width="40%" ALIGN="right" VALIGN="top"><FONT FACE="Verdana" SIZE="2"><strong><span class="style2"><?php echo ENTRY_INVOICE; ?>&nbsp;#</span></strong></font><FONT FACE="Verdana" SIZE="2" COLOR="#000000"><strong><?php echo $order_id; ?><BR><?php echo ENTRY_DATE_PURCHASED; ?>&nbsp;<?php echo tep_date_short($order->info['date_purchased']); ?><br><?php echo ENTRY_PRINT_DATE; ?>&nbsp;<?php echo $date; ?></strong></font></TD>
  </tr>
  <tr>
    <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <TD><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                      <td width="10%"><hr size="2"></td>
                      <td align="center" class="pageHeading"><em><b><?php echo ENTRY_INVOICE; ?></b></em></td>
                      <td width="100%"><hr size="2"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '100', '5'); ?></td>
              </tr>
              <tr>
                <td width="48%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="11"><img src="../images/borders/mainwhite_01.gif" width="11" height="16" alt=""></td>
                      <td background="../images/borders/mainwhite_02.gif"><img src="../images/borders/mainwhite_02.gif" width="24" height="16" alt="" ></td>
                      <td width="19"><img src="../images/borders/mainwhite_03.gif" width="19" height="16" alt=""></td>
                    </tr>
                    <tr>
                      <td background="../images/borders/mainwhite_04.gif"><img src="../images/borders/mainwhite_04.gif" width="11" height="21" alt=""></td>
                      <td align="center" bgcolor="#F2F2F2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="main">
                          <tr>
                            <td align="left" valign="top"><b><?php echo ENTRY_SOLD_TO; ?></b></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>&nbsp;&nbsp;&nbsp;&nbsp;'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->customer['telephone']; ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $order->customer['email_address']; ?></td>
                          </tr>
                          <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '7'); ?></td>
                          </tr>
                        </table></td>
                      <td background="../images/borders/mainwhite_06.gif"><img src="../images/borders/mainwhite_06.gif" width="19" height="21" alt=""></td>
                    </tr>
                    <tr>
                      <td><img src="../images/borders/mainwhite_07.gif" width="11" height="18" alt=""></td>
                      <td background="../images/borders/mainwhite_08.gif"><img src="../images/borders/mainwhite_08.gif" width="24" height="18" alt=""></td>
                      <td><img src="../images/borders/mainwhite_09.gif" width="19" height="18" alt=""></td>
                    </tr>
                  </table></td>
                <td width="4%"></td>
                <td width="48%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="11"><img src="../images/borders/mainwhite_01.gif" width="11" height="16" alt=""></td>
                      <td background="../images/borders/mainwhite_02.gif"><img src="../images/borders/mainwhite_02.gif" width="24" height="16" alt=""></td>
                      <td width="19"><img src="../images/borders/mainwhite_03.gif" width="19" height="16" alt=""></td>
                    </tr>
                    <tr>
                      <td background="../images/borders/mainwhite_04.gif"><img src="../images/borders/mainwhite_04.gif" width="11" height="21" alt=""></td>
                      <td align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="main">
                          <tr>
                            <td align="left" valign="top"><b><?php echo ENTRY_SHIP_TO; ?></b></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>&nbsp;&nbsp;&nbsp;&nbsp;'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                          <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '7'); ?></td>
                          </tr>
                        </table></td>
                      <td background="../images/borders/mainwhite_06.gif"><img src="../images/borders/mainwhite_06.gif" width="19" height="21" alt=""></td>
                    </tr>
                    <tr>
                      <td><img src="../images/borders/mainwhite_07.gif" width="11" height="18" alt=""></td>
                      <td background="../images/borders/mainwhite_08.gif"><img src="../images/borders/mainwhite_08.gif" width="24" height="18" alt=""></td>
                      <td><img src="../images/borders/mainwhite_09.gif" width="19" height="18" alt=""></td>
                    </tr>
                  </table></td>
              </tr>
            </table></TD>
        </tr>
        <tr>
          <TD COLSPAN="2"><?php echo tep_draw_separator('pixel_trans.gif', '100', '15'); ?></td>
        </tr>
        <tr>
          <TD COLSPAN="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="9"></td>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="11"><img src="../images/borders/mainwhite_01.gif" width="11" height="16" alt=""></td>
                      <td background="../images/borders/mainwhite_02.gif"><img src="../images/borders/mainwhite_02.gif" width="24" height="16" alt="" ></td>
                      <td width="19"><img src="../images/borders/mainwhite_03.gif" width="19" height="16" alt=""></td>
                    </tr>
                    <tr>
                      <td background="../images/borders/mainwhite_04.gif"><img src="../images/borders/mainwhite_04.gif" width="11" height="21" alt=""></td>
                      <td align="center" bgcolor="#F2F2F2"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="main">
                          <tr>
                            <td width="33%">&nbsp;<b><?php echo EMAIL_TEXT_ORDER_NUMBER; ?>&nbsp;</b> <?php echo (int)$order_id; ?></td>
                            <td width="33%">&nbsp;<b><?php echo ENTRY_DATE_PURCHASED; ?>&nbsp;</b><?php echo tep_date_short($order->info['date_purchased']); ?></td>
                            <td>&nbsp;<b><?php echo ENTRY_PAYMENT_METHOD; ?></b>&nbsp;<?php echo tep_db_output($order->info['payment_method']); ?></td>
                          </tr>
                          <tr>
                            <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '7'); ?></td>
                          </tr>
                        </table></td>
                      <td background="../images/borders/mainwhite_06.gif"><img src="../images/borders/mainwhite_06.gif" width="19" height="21" alt=""></td>
                    </tr>
                    <tr>
                      <td><img src="../images/borders/mainwhite_07.gif" width="11" height="18" alt=""></td>
                      <td background="../images/borders/mainwhite_08.gif"><img src="../images/borders/mainwhite_08.gif" width="24" height="18" alt=""></td>
                      <td><img src="../images/borders/mainwhite_09.gif" width="19" height="18" alt=""></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <TD COLSPAN="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '15'); ?></td>
        </tr>
        <?php
//PAYPAL INFO FRO INVOICE
if (strtolower($order->info['payment_method']) == 'paypal')
   include(DIR_FS_CATALOG_MODULES . 'payment/paypal/admin/TransactionSummaryLogs.inc.php');
//END PAYPAY?>
        <tr>
          <TD COLSPAN="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
        </tr>
        <tr>
          <TD COLSPAN="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_QUANTITY; ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_PRODUCT; ?></td>
                <td class="dataTableHeadingContent" align="left">&nbsp;<?php echo TABLE_HEADING_TAX; ?></td>
	            <td class="dataTableHeadingContent" align="right">&nbsp;<font color="#000000" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
	            <td class="dataTableHeadingContent" align="right">&nbsp;<font color="#000000" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
	            <td class="dataTableHeadingContent" align="right">&nbsp;<font color="#000000" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
	            <td class="dataTableHeadingContent" align="right">&nbsp;<font color="#000000" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
	          </tr>
              <?php
	   for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
		  echo '      <tr class="dataTableRow" ' . (( $order->products[$i]['qty'] > 1 ) ? 'style="font-weight: bold;"' : '' ) . '>' . "\n" .
				 '        <td WIDTH="20" class="dataTableContent" align="left" valign="top" style="text-align:left;">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
				 '        <td class="dataTableContent" valign="top" align="left" style="text-align:left;font-size:14px;">' . $order->products[$i]['name'];
	     if (isset($order->products[$i]['attributes']) && (($k = sizeof($order->products[$i]['attributes'])) > 0)) {
	       for ($j = 0; $j < $k; $j++) {
	         echo '<br><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
	         if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
	         echo '</i></small></nobr>';
	       }
	     }

	      echo '	   		     </td>' . "\n"; //.
	           '	   		     <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n";
	      echo '	   		     <td WIDTH="80" class="dataTableContent" align="left" valign="top">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
	           '	   		     <td WIDTH="80" class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
	           '	   		     <td WIDTH="80" class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
	           '	   		     <td WIDTH="80" class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
	           '	   		     <td WIDTH="80" class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
	      echo '		        </tr>' . "\n";
	   }
	?>
              <tr>
                <td align="right" colspan="8"><table border="0" cellspacing="0" cellpadding="2">
                    <?php
 for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
   echo '         <tr>' . "\n" .
        '          <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .
        '          <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .
        '         </tr>' . "\n";
 }
?>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <br/>

        <table width="100%"  border="0" cellspacing="0" cellpadding="0">

   <tr>
     <td width="100%" colspan="3"><table class="main" width="100%"  border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td colspan="2"><div align="left"><?php
	// retrieve and include comments
           if (count($orders_history_query)) {
             $commentnumber = 1;
             foreach ($orders_history_query as $orders_history) {
               $thecomment = tep_db_output($orders_history['comments']);
               if (tep_not_null($thecomment)) {
                echo 'Comment ' . $commentnumber . ': '.nl2br($thecomment) . '<br/>';
              }
              $commentnumber++;
            }
          }
          $percentComplete = ($invoice / $total_invoices) * 100;

		 ?></div></td>
         </tr>
       </table>
     </td>
   </tr>
 </table></td>
  </tr>
</table>
<script type="text/javascript">
$( ".progress" ).show();
var percentComplete = <?php echo $percentComplete; ?>;
var invoice = <?php echo $invoice; ?>;
var total_invoices = <?php echo $total_invoices; ?>;

console.log(percentComplete);
$('#progress-bar').css( "width", percentComplete + "%" );
$( "#progress-bar" ).find( "span" ).html( invoice + "/" + total_invoices + " Updated" );
</script>