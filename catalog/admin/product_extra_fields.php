<?php
/*
  $Id: product_extra_field.php,v 2.0 2004/11/09 22:50:52 ChBu Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  * 
  * v2.0: added languages support
*/
require('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
// Has "Remove" button been pressed?
if (isset($_POST['remove_x']) || isset($_POST['remove_y'])) $action='remove';

if (tep_not_null($action)) {
  switch ($action) {
    case 'setflag':
      $sql_data_array = array('products_extra_fields_status' => tep_db_prepare_input($_GET['flag']));
	  tep_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'update', 'products_extra_fields_id=' . $_GET['id']);
      tep_redirect(tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));	
	  break;
    case 'add':
      $sql_data_array = array('products_extra_fields_name' => tep_db_prepare_input($_POST['field']['name']),
	                          'languages_id' => tep_db_prepare_input ($_POST['field']['language']),
	                          'category_id' =>  tep_db_prepare_input ($_POST['field']['category']),
	                          'google_only' =>  tep_db_prepare_input ($_POST['field']['google']),
							  'products_extra_fields_order' => tep_db_prepare_input($_POST['field']['order']));
			tep_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'insert');

      tep_redirect(tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));
      break;
    case 'update':
      foreach ($_POST['field'] as $key=>$val) {
        $sql_data_array = array('products_extra_fields_name' => tep_db_prepare_input($val['name']),
		                        'languages_id' =>  tep_db_prepare_input($val['language']),
		                        'category_id' =>  tep_db_prepare_input($val['category']),
		                        'google_only' =>  tep_db_prepare_input($val['google']),
			   					'products_extra_fields_order' => tep_db_prepare_input($val['order']));
			  tep_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'update', 'products_extra_fields_id=' . $key);
      }
      tep_redirect(tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));

      break;
    case 'remove':
      //print_r($_POST['mark']);
      if ($_POST['mark']) {
        foreach ($_POST['mark'] as $key=>$val) {
          tep_db_query("DELETE FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " WHERE products_extra_fields_id=" . tep_db_input($key));
          tep_db_query("DELETE FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_extra_fields_id=" . tep_db_input($key));
        }
        tep_redirect(tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));
      }

      break;
  }
}

// Put languages information into an array for drop-down boxes
  $languages=tep_get_languages();
  $values[0]=array ('id' =>'0', 'text' => TEXT_ALL_LANGUAGES);
  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	$values[$i+1]=array ('id' =>$languages[$i]['id'], 'text' =>$languages[$i]['name']);
  }

  $google_only_array = array(array('id' => '1', 'text' => ENTRY_GOOGLE_ONLY_YES),
                             array('id' => '0', 'text' => ENTRY_GOOGLE_ONLY_NO));

require(DIR_WS_INCLUDES . 'template_top.php');
		 
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

    <tr>
     <td width="100%">
      <!--
      <div style="font-family: verdana; font-weight: bold; font-size: 17px; margin-bottom: 8px; color: #727272;">
       <?php echo SUBHEADING_TITLE; ?>
      </div>
      -->
      <br />
      <?php //echo tep_draw_form("add_field", FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=add', 'post'); ?>
	  
	  <?php echo tep_draw_form('add_field', FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=add', 'post'); ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="20">&nbsp;</td>
		<td class="dataTableHeadingContent" width="40%"><?php echo TABLE_HEADING_FIELDS; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_ORDER; ?></td>
		<td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_LANGUAGE; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_CATEGORY; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_GOOGLE_ONLY; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ACTION; ?></td>
       </tr>

       <tr>
        <td class="dataTableHeadingContent" width="20">&nbsp;</td>
        <td class="dataTableContent">
         <?php echo tep_draw_input_field('field[name]', $field['name'], 'size=30', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php echo tep_draw_input_field('field[order]', $field['order'], 'size=5', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php
		 echo tep_draw_pull_down_menu('field[language]', $values, '0', '');?>
        </td>		
        <td class="dataTableContent" align="center">
          <?php echo tep_draw_input_field('field[category]', $field['category'], 'size=10', false, 'text', true);?>
        </td>
        <td class="dataTableContent" align="center">
          <?php echo tep_draw_pull_down_menu('field[google]', $google_only_array, (($field['google'] == '1') ? '1' : '0'));?>
        </td>
        <td class="dataTableHeadingContent" align="center">
	<?php echo tep_image_submit('button_add_field.gif',IMAGE_ADD_FIELD)?>
        </td>
       </tr>
       </form>
      </table>
      <br>
      <hr />
      <br>
      <?php
       echo tep_draw_form('extra_fields', FILENAME_PRODUCTS_EXTRA_FIELDS,'action=update','post');
      ?>
      <?php echo $action_message; ?>
      <table border="0" width="100%" cellspacing="0" cellpadding="2">
       <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="20">&nbsp;</td>
        <td class="dataTableHeadingContent" width="40%"><?php echo TABLE_HEADING_FIELDS; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_ORDER; ?></td>
		<td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_LANGUAGE; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_CATEGORY; ?></td>
        <td class="dataTableHeadingContent" align="center" width="10%"><?php echo TABLE_HEADING_GOOGLE_ONLY; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
       </tr>
<?php
$products_extra_fields_query = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");
while ($extra_fields = tep_db_fetch_array($products_extra_fields_query)) {
?>
       <tr>
        <td width="20">
         <?php echo tep_draw_checkbox_field('mark['.$extra_fields['products_extra_fields_id'].']', 1) ?>
        </td>
        <td class="dataTableContent">
         <?php echo tep_draw_input_field('field['.$extra_fields['products_extra_fields_id'].'][name]', $extra_fields['products_extra_fields_name'], 'size=30', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php echo tep_draw_input_field('field['.$extra_fields['products_extra_fields_id'].'][order]', $extra_fields['products_extra_fields_order'], 'size=5', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
		 <?php echo tep_draw_pull_down_menu('field['.$extra_fields['products_extra_fields_id'].'][language]', $values, $extra_fields['languages_id'], ''); ?>
        </td>	
        <td class="dataTableContent" align="center">
         <?php echo tep_draw_input_field('field['.$extra_fields['products_extra_fields_id'].'][category]', $extra_fields['category_id'], 'size=10', false, 'text', true);?>
        </td>
        <td class="dataTableContent" align="center">
		 <?php echo tep_draw_pull_down_menu('field['.$extra_fields['products_extra_fields_id'].'][google]', $google_only_array, $extra_fields['google_only'], ''); ?>
        </td>
		<td  class="dataTableContent" align="center">
         <?php
          if ($extra_fields['products_extra_fields_status'] == '1') {
            echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=setflag&flag=0&id=' . $extra_fields['products_extra_fields_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
          }
          else {
            echo '<a href="' . tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=setflag&flag=1&id=' . $extra_fields['products_extra_fields_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
          }
         ?>
        </td>
       </tr>
<?php } ?>
       <tr>
        <td colspan="7">
      <hr />
      <br>

         <?php echo tep_image_submit('button_update_fields.gif',IMAGE_UPDATE_FIELDS)?> 
         &nbsp;&nbsp;
		 <?php echo tep_image_submit('button_remove_fields.gif',IMAGE_REMOVE_FIELDS,'name="remove"')?> 
        </td>
       </tr>
	   <tr>
	   <td colspan="7" class="smallText"><br><?php echo TEXT_CATEGORIES_INFO; ?></td>
	   </tr>
       </form>
      </table>
     </td>
    </tr>
   </table>

<?php 
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php'); 
?>