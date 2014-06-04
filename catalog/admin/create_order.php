<?php
/*
  $Id: create_order.php,v 1 2003/08/17 23:21:34 frankl Exp $

  Updated 2014/05/09 - Dr. Rolex

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  #Connect
  $link = "db_link";
  global $$link;


  #Define Tables to Variables
  $tablename_c = TABLE_CUSTOMERS;
  $tablename_ab = TABLE_ADDRESS_BOOK;
  $tablename_z = TABLE_ZONES;
  $tablename_cs = TABLE_CURRENCIES;

  #Customer Search from jQuery Autocomplete
  if ( isset($_GET['term']) && !empty($_GET['term']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) {


    #Get Available Customers
	  $customers_name_test = preg_match_all('/([^\s]+)/', $_GET['term'], $customers_name);

    if ( count($customers_name[1]) > 1 ) {
      $params = array('ss', '%'.$customers_name[1][0].'%', '%'.$customers_name[1][1].'%');
      $typeDef = "ss";
      $search_query = " AND (customers_firstname like ? AND customers_lastname like ?) ";
    } else {
      $params = array('s', '%'.$customers_name[1][0].'%');
      $typeDef = "s";
      $search_query = " AND customers_firstname like ? ";
    }

    $sql_se = "select a.customers_id, a.customers_firstname, a.customers_lastname, CONCAT(a.customers_firstname, ' ', a.customers_lastname) as customers_name, CONCAT(ab.entry_street_address, ', ', ab.entry_postcode, ', ', ab.entry_city) as custeroms_address, ab.entry_company, ab.entry_city, z.zone_code from $tablename_c a, $tablename_ab ab LEFT JOIN $tablename_z z ON (ab.entry_zone_id = z.zone_id) WHERE a.customers_default_address_id = ab.address_book_id" . $search_query . "ORDER BY entry_company,customers_lastname";

    $stmt_se = $$link->stmt_init();

    #Create the prepared statement
    if(!$stmt_se->prepare($sql_se))
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the SELECT statement failed: ' . htmlspecialchars($$link->error) ) ) );

    #Bind parameters to the query
    $ref = new ReflectionClass('mysqli_stmt');
    $method = $ref->getMethod("bind_param");
    $method->invokeArgs($stmt_se, $params);

    #Run the prepared statement
    if(!$stmt_se->execute())
      die( json_encode( array( 'status' => 'error', 'message' => 'Executing ORDERS failed: ' . htmlspecialchars($stmt_se->error) ) ) );

    #Get the customers info
    $res = $stmt_se->get_result();
    while (($row = $res->fetch_assoc()))
        $order_query[] = $row;

    #Close open connections
    $stmt_se->close();

      $return_arr = array();
      foreach ($order_query as $row) {
        $row_array['id'] = tep_href_link(FILENAME_CREATE_ORDER, 'Customer=' . (int)$row['customers_id']);
        $row_array['value'] = $row['customers_name'] . ': ' . $row['custeroms_address'];

        array_push($return_arr, $row_array); 
      }

      echo json_encode($return_arr);
      tep_exit();
    }

    if (isset($_GET['Customer_nr'])) $_GET['Customer'] = $_GET['Customer_nr'];

    $sql_se = "SELECT c.customers_id, c.customers_firstname, c.customers_lastname, ab.entry_company, ab.entry_city, z.zone_code FROM $tablename_c c, $tablename_ab ab LEFT JOIN $tablename_z z ON (ab.entry_zone_id = z.zone_id) WHERE c.customers_default_address_id = ab.address_book_id  ORDER BY entry_company, customers_lastname LIMIT 100";

    //$stmt_se = $$link->stmt_init();

    #Execute Query
    $rs = $$link->query($sql_se);
    if ($rs === false)
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the SELECT statement failed: ' . htmlspecialchars($$link->error) ) ) );

    #Store all values to Array & Get Customer Count
    $result = $rs->fetch_all(MYSQLI_ASSOC);
    $customer_count = $rs->num_rows;

    if (count($result)) {
    #Create Selection Drop Down
    $SelectCustomerBox = "<select name=\"Customer\" id=\"Customer\"><option value=\"\">" . TEXT_SELECT_CUST . "</option>\n";

    foreach ($result as $db_Row) {

      $SelectCustomerBox .= "<option value=\"" . $db_Row['customers_id'] . "\"";

      if( isset($_GET['Customer']) && $db_Row['customers_id'] == $_GET['Customer'] ){
        $SelectCustomerBox .= " SELECTED ";
        $SelectCustomerBox .= ">" . (empty($db_Row['entry_company']) ? "": strtoupper($db_Row['entry_company']) . " - " ) . $db_Row['customers_lastname'] . " , " . $db_Row['customers_firstname'] . " - " . $db_Row['entry_city'] . ", " . $db_Row['zone_code'] . "</option>\n";
      }else{
        $SelectCustomerBox .= ">" . (empty($db_Row['entry_company']) ? "": strtoupper($db_Row['entry_company']) . " - " ) . $db_Row['customers_lastname'] . " , " . $db_Row['customers_firstname'] . " - " . $db_Row['entry_city'] . ", " . $db_Row['zone_code'] . "</option>\n";
      }
    }

    $SelectCustomerBox .= "</select>\n";
  }

	$sql = "SELECT code, value FROM $tablename_cs ORDER BY code";
  $rs = $$link->query($sql);

  if($rs === false)
    die( json_encode( array( 'status' => 'error', 'message' => 'Preparing the SELECT statement failed: ' . htmlspecialchars($$link->error) ) ) );
  
  $rs->data_seek(0);

	if (count($rs)){
	  // Query Successful
	  $SelectCurrencyBox = "<select name=\"Currency\"><option value=\"\">" . TEXT_SELECT_CURRENCY . "</option>\n";
	  while($db_Row = $rs->fetch_assoc()){
	    $SelectCurrencyBox .= "<option value='" . $db_Row["code"] . "," . $db_Row["value"] . "'";

	    if ($db_Row["code"] == DEFAULT_CURRENCY){
	      $SelectCurrencyBox .= " SELECTED ";
	    }

	    $SelectCurrencyBox .= ">" . $db_Row["code"] . "</option>\n";
	  }
	  $SelectCurrencyBox .= "</select>\n";
	}

  $rs->free();

// load all enabled payment modules
  $dir = getcwd();
  chdir("../");
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment;
  $selection = $payment_modules->selection();  
  
  if (sizeof($selection) > 1) {
    $SelectPaymentBox = '<select name="payment">' . "\n";
    for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
      $SelectPaymentBox .= '<option value="' . $selection[$i]['id'] .'">' . $selection[$i]['module'];
    }
    $SelectPaymentBox .= "</select>\n";
  } else {
    $SelectPaymentBox = tep_draw_hidden_field('payment', $selection[$i]['id']);
  }

  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping;

// get all available shipping quotes
  $quotes = $shipping_modules->quote();
  
  if (sizeof($selection) > 1) {
    $SelectShippingBox = '<select name="shipping">' . "\n";
    for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
      $SelectShippingBox .= '<option value="' . $quotes[$i]['id'] .'">' . $quotes[$i]['module'];
    }
    $SelectShippingBox .= "</select>\n";
  } else {
    $SelectShippingBox = tep_draw_hidden_field('shipping', $quotes[$i]['id']);
  }
  chdir($dir);


	if(isset($_GET['Customer'])){
    #SQL Query
    $sql_account = "SELECT * FROM $tablename_c WHERE customers_id = ?";
    $sql_address = "SELECT * FROM $tablename_ab WHERE customers_id = ?";

    #Prepare statements
    $stmt_ac = $$link->prepare($sql_account);
    if($stmt_ac === false)
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing '.$sql_account.' failed: ' . htmlspecialchars($$link->error) ) ) );
    $stmt_ad = $$link->prepare($sql_address);
    if($stmt_ad === false)
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing '.$sql_address.' failed: ' . htmlspecialchars($$link->error) ) ) );

    #Bind parameters. Types: s = string, i = integer, d = double,  b = binary
    $stmt_ac->bind_param('i', $_GET['Customer']);
    $stmt_ad->bind_param('i', $_GET['Customer']);

    #Execute statement
    $stmt_ac->execute();

    $rs = $stmt_ac->get_result();
    $arr = $rs->fetch_all(MYSQLI_ASSOC);
    $account = $arr[0];
    $customers_id = $arr[0]['customers_id'];
    $stmt_ac->close();

    #Execute statement
    $stmt_ad->execute();

    $rs = $stmt_ad->get_result();
    $arr = $rs->fetch_all(MYSQLI_ASSOC);
    $address = $arr[0];
    $stmt_ad->close();

	} elseif (isset($_GET['Customer_email'])) {
    #SQL Query
    $sql_account = "SELECT * FROM $tablename_c WHERE customers_email_address = ?";
    $sql_address = "SELECT * FROM $tablename_ab WHERE customers_id = ?";

    #Prepare statements
    $stmt_ac = $$link->prepare($sql_account);
    if($stmt_ac === false)
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing '.$sql_account.' failed: ' . htmlspecialchars($$link->error) ) ) );
    $stmt_ad = $$link->prepare($sql_address);
    if($stmt_ad === false)
      die( json_encode( array( 'status' => 'error', 'message' => 'Preparing '.$sql_address.' failed: ' . htmlspecialchars($$link->error) ) ) );

    #Bind parameters. Types: s = string, i = integer, d = double,  b = binary
    $stmt_ac->bind_param('s', $_GET['Customer_email']);
    $stmt_ad->bind_param('i', $customers_id);

    #Execute statement
    $stmt_ac->execute();

    $rs = $stmt_ac->get_result();
    $arr = $rs->fetch_all(MYSQLI_ASSOC);
    $account = $arr[0];
    $customers_id = $arr[0]['customers_id'];
    $stmt_ac->close();

    #Execute statement
    $stmt_ad->execute();

    $rs = $stmt_ad->get_result();
    $arr = $rs->fetch_all(MYSQLI_ASSOC);
    $address = $arr[0];
    $stmt_ad->close();

	}

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ORDER_PROCESS);

  if (!isset($_GET['ajax'])) {
    require(DIR_WS_INCLUDES . 'template_top.php');
  } else {
     echo '
     <div class="ajaxCreateOrder">
       <div id="ajax_cart_top"><button type="button" class="closeWindow close">×</button></div>';
  }

  require('includes/form_check.js.php');
  $JQUERY_DATEPICKER_FORMAT = JQUERY_DATEPICKER_FORMAT;
  echo <<<EOD
  <script type="text/javascript">
    JQUERY_DATEPICKER_FORMAT = '$JQUERY_DATEPICKER_FORMAT';
  </script>
EOD;
  ?>

<script language="javascript" type="text/javascript"><!--
$(function() {
  var cache = {};
  $("#cust_select_name_field").autocomplete({
     // source: "autocomplete.php",
      minLength: 2,
      select: function(event, ui) {
        window.location  = (ui.item.id);
      },
      source: function( request, response ) {
        var term = request.term;
        if ( term in cache ) {
          response( cache[ term ] );
          return;
        }

        $.getJSON( "create_order.php", request, function( data, status, xhr ) {
          cache[ term ] = data;
          response( data );
        });
      }
  }).data("ui-autocomplete")._renderItem = function( ul, item ) {
      return $( "<li></li>" )
      .data( "item.autocomplete", item )
      .append( "<a href='" + item.id + "' onClick='return false;'>"+ item.value + "</a>" )
      .appendTo( ul );
  };

  $('#customers_dob').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>'
, changeMonth: true, changeYear: true, yearRange: '-100:-18', defaultDate: "-30y"});

  $( "body" ).on('change', '#Customer', function( event ) {
    $( this ).closest( "form" ).submit();
  });

  $( "body" ).on( "click", ".create_and_send", function( event ) {
    var form = this.form,
        input = '<input type="hidden" name="email_customer" value="true">';

    if ( check_form( form ) === false ) return false;

    $( form ).append( input );
    return form.submit();
  });

});

function selectExisting() {
  document.create_order.customers_create_type.value = 'existing';
  selectorsStatus(false);
  selectorsExtras(true);
}
function selectNew() {
  document.create_order.customers_create_type.value = 'new';
  selectorsStatus(true);
  selectorsExtras(false);
}
function selectNone() {
  document.create_order.customers_create_type.value = 'none';
  selectorsStatus(true);
  selectorsExtras(true);
}
function selectorsStatus(status) {
  document.cust_select.Customer.disabled = status;
  $( "#cust_select_id_field" ).prop( 'disabled', status );
  $( "#cust_select_id_button" ).prop( 'disabled', status );
  $( "#cust_select_email_field" ).prop( 'disabled', status );
  $( "#cust_select_email_button" ).prop( 'disabled', status );
  $( "#cust_select_name_field" ).prop( 'disabled', status );
  $( "#cust_select_name_button" ).prop( 'disabled', status );
}
function selectorsExtras(status) {
  $( "#customers_password" ).prop( 'disabled', status );
  $( "#customers_newsletter" ).prop( 'disabled', status );
<?php if (ACCOUNT_DOB == 'true') { ?>
  $( "#customers_dob" ).prop( 'disabled', status );
<?php } ?>
<?php if (ACCOUNT_GENDER == 'true') { ?>
  document.create_order.customers_gender[0].disabled = status;
  document.create_order.customers_gender[1].disabled = status;
<?php } ?>
}
//--></script>

<div id="createOrderTable" class="contentContainer" onLoad="selectorsExtras(true)" style="text-align:left;float:left;width:500px;">

    <h2 class="pageHeading" style="text-align:center;"><?php echo HEADING_TITLE; ?></h2>
        
    <table border="0" width="100%" class="dataTableHeadingRow">
      <tr>
        <td class="dataTableHeadingContent"><?php echo TEXT_STEP_1; ?></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="boxcart-content-table">
      <tr>
        <td class="main" valign="top">

            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="formArea">
              <tr>
                <td class="main" valign="top">

                <table width="100%" border="0" cellpadding="3" cellspacing="0">
                  <tr>
                    <td class="main" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                    <td class="main" valign="top"></td>
                  </tr>
                <?php if ($customer_count > 0){ ?>
                  <tr>
                    <td class="main" valign="top"><input name="handle_customer" id="existing_customer" value="existing" type="radio" checked="checked" onClick="selectExisting();" /></td>
                    <td class="main" valign="top"><label for="existing_customer" style="cursor:pointer;"><?php echo CREATE_ORDER_TEXT_EXISTING_CUST; ?></label></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"></td>
                    <td class="main" valign="top">
                    <?php
                    echo "<form action='".tep_href_link(FILENAME_CREATE_ORDER)."' method=\"GET\" name=\"cust_select\" id=\"cust_select\">\n";
                    echo tep_hide_session_id();
                    echo "<table width='100%' border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
                    echo "<tr>\n";
                    echo "<td>$SelectCustomerBox</td>\n";
                   // echo "<td width='20%'><input type=\"submit\" value=\"" . BUTTON_SUBMIT . "\" name=\"cust_select_button\" id=\"cust_select_button\"></td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "</form>\n";
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"></td>
                    <td class="main" valign="top"></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"></td>
                    <td class="main" valign="top">
                    <?php
                    echo "<form action='".tep_href_link(FILENAME_CREATE_ORDER)."' method=\"GET\" name=\"cust_select_id\" id=\"cust_select_id\">\n";
                    echo tep_hide_session_id();
                    echo "<table width='100%' border=\"0\" cellspacing=\"0\" cellpadding=\"4\">\n";
                    echo "<tr>\n";
                    echo "<td width='75%'>" . TEXT_OR_BY_ID . "<font class=main><input type=text name=\"Customer_nr\" name=\"cust_select_id_field\" id=\"cust_select_id_field\"></td>\n";
                    echo "<td width='10%'><input type=\"submit\" value=\"" . BUTTON_SUBMIT . "\" name=\"cust_select_id_button\" id=\"cust_select_id_button\"></td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "</form>\n";
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"></td>
                    <td class="main" valign="top">
                    <?php
                    echo "<form action='".tep_href_link(FILENAME_CREATE_ORDER)."' method=\"GET\" name=\"cust_select_email\" id=\"cust_select_email\">\n";
                    echo tep_hide_session_id();
                    echo "<table width='100%' border=\"0\" cellspacing=\"0\" cellpadding=\"4\">\n";
                    echo "<tr>\n";
                    echo "<td width='75%'>" . TEXT_OR_BY_EMAIL . tep_draw_input_field('Customer_email', '', 'id="cust_select_email_field"') . "</td>\n";
                    echo "<td width='10%'><input type=\"submit\" value=\"" . BUTTON_SUBMIT . "\" name=\"cust_select_email_button\" id=\"cust_select_email_button\"></td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "</form>\n";
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"></td>
                    <td class="main" valign="top">
                    <?php
                    echo "<form action='".tep_href_link(FILENAME_CREATE_ORDER)."' method=\"GET\" name=\"cust_select_name\" id=\"cust_select_name\">\n";
                    echo tep_hide_session_id();
                    echo "<table width='100%' border=\"0\" cellspacing=\"0\" cellpadding=\"4\">\n";
                    echo "<tr>\n";
                    echo "<td width='75%'>" . TEXT_OR_BY_NAME . tep_draw_input_field('Customer_name', '', 'id="cust_select_name_field"') . "</td>\n";
                    echo "<td width='10%'><input type=\"submit\" value=\"" . BUTTON_SUBMIT . "\" name=\"cust_select_name_button\" id=\"cust_select_name_button\"></td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "</form>\n";
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                    <td class="main" valign="top"></td>
                  </tr>
               <?php } ?>
                  <tr>
                    <td class="main" valign="top"><input name="handle_customer" id="new_customer" value="new" type="radio" onClick="selectNew();"></td>
                    <td class="main" valign="top"><label for="new_customer" style="cursor:pointer;"><?php echo CREATE_ORDER_TEXT_NEW_CUST; ?></label></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                    <td class="main" valign="top"></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><input name="handle_customer" id="no_customer" value="none" type="radio" onClick="selectNone();"></td>
                    <td class="main" valign="top"><label for="no_customer" style="cursor:pointer;"><?php echo CREATE_ORDER_TEXT_NO_CUST; ?></label></td>
                  </tr>
                  <tr>
                    <td class="main" valign="top"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                    <td class="main" valign="top"></td>
                  </tr>
                </table>

                </td>
              </tr>
            </table>

        </td>
      </tr>
    </table>
    <?php if (!empty($_GET['message'])) { ?>
    <br>
    <table border="0" width="100%" style=" background-color:#FF0000; height:40px;">
      <tr>
        <td class="dataTableHeadingContent"><?php echo $_GET['message']; ?></td>
      </tr>
    </table>
    <?php } ?>
    <br>
    <table border="0" width="100%" class="dataTableHeadingRow">
      <tr>
        <td class="dataTableHeadingContent"><?php echo TEXT_STEP_2; ?></td>
      </tr>
    </table>

    <?php echo tep_draw_form('create_order', FILENAME_CREATE_ORDER_PROCESS, '', 'post', (!isset($_GET['ajax']) ? 'onsubmit="return check_form(this);" id="create_order"' : 'id="create_order"')) . tep_draw_hidden_field('customers_create_type', 'existing', 'id="customers_create_type"') . tep_hide_session_id(); ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><?php
          require(DIR_WS_MODULES . 'create_order_details.php');
        ?>
      </td>
    </tr>
    <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
    </tr>
    <tr>
      <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class="main" align="left">
			<?php echo (isset($_GET['ajax']) ? tep_draw_button(IMAGE_BACK, 'triangle-1-w', null, 'secondary', array('params' => 'class="closeWindow"')) : ''); ?></td>
          <td class="main" align="right"><?php echo tep_draw_button(IMAGE_SEND_EMAIL . ' & '.IMAGE_SAVE, null, null, 'secondary', array('type' => 'button', 'params' => 'class="create_and_send"')); ?></td>
          <td class="main" align="right"><?php echo tep_draw_button(IMAGE_SAVE, null, null, 'primary'); ?></td>
        </tr>
      </table></td>
    </tr>
  </table></form></td>
<!-- body_text_eof //-->
  </tr>
</table>
<?php
if (isset($_GET['ajax'])) {
  echo <<<EOD
  <script type="text/javascript">
  $(function(){
    var width = $('#boxcart-content-table').width();
    var height = $('#boxcart-content-table').height();

    $('.ajax_cart')
      .css("width", width);
    $( "#ajax_cart_dialog" ).dialog( "option", "position", { my: "center", at: "center" } );
  });
  selectorsExtras(true);
  </script>
EOD;
  echo '</div></div>';
  tep_exit();
} ?>

<script language="javascript" type="text/javascript"><!--
selectorsExtras(true);
//--></script>

</div>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>