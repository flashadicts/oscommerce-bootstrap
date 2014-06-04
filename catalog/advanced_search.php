<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ADVANCED_SEARCH);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ADVANCED_SEARCH));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<script type="text/javascript" src="includes/general.js"></script>
<?php
// START: Extra Fields Contribution Search Fields 1.0
$pef_fields = array();
$pef_fields_query = tep_db_query("SELECT products_extra_fields_id, products_extra_fields_name FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " WHERE (languages_id = 0 OR languages_id = " . (int)$languages_id . ") AND products_extra_fields_status ORDER BY products_extra_fields_order");
while ($field = tep_db_fetch_array($pef_fields_query))
  {
	$pef_fields[] = $field;
  }
// END: Extra Fields Contribution
?>
<script type="text/javascript">
$('#helpSearch').dialog({
  autoOpen: false,
  buttons: {
    Ok: function() {
      $(this).dialog('close');
    }
  }
});
</script>
<script type="text/javascript"><!--
function check_form() {
  var error_message = "<?php echo JS_ERROR; ?>";
  var error_found = false;
  var error_field;
  var keywords = document.advanced_search.keywords.value;
  var dfrom = document.advanced_search.dfrom.value;
  var dto = document.advanced_search.dto.value;
  var pfrom = document.advanced_search.pfrom.value;
  var pto = document.advanced_search.pto.value;
  var pfrom_float;
  var pto_float;
<?php
// START: Extra Fields Contribution Search Fields 1.0
foreach ($pef_fields as $field){	
echo '  var pef_'.$field['products_extra_fields_id'].' = document.advanced_search.pef_'.$field['products_extra_fields_id'].".value;\n";}?> 

if ( ((keywords == '') || (keywords.length < 1)) && ((dfrom == '') || (dfrom.length < 1)) && ((dto == '') || (dto.length < 1)) && ((pfrom == '') || (pfrom.length < 1)) && ((pto == '') || (pto.length < 1)) ) {
<?php
// START: Product Extra Fields Contribution Search Fields 1.0
foreach ($pef_fields as $field)
{	
     $fieldid =  'pef_'.$field['products_extra_fields_id'];	
     echo " && (( $fieldid == '' ) || ($fieldid.length < 1))";
}
// END: Extra Fields Contribution
?>
) {    
    error_message = error_message + "* <?php echo ERROR_AT_LEAST_ONE_INPUT; ?>\n";    
    error_field = document.advanced_search.keywords;    
    error_found = true;  
  }


  if (dfrom.length > 0) {
    if (!IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dfrom;
      error_found = true;
    }
  }

  if (dto.length > 0) {
    if (!IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>')) {
      error_message = error_message + "* <?php echo ERROR_INVALID_TO_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if ((dfrom.length > 0) && (IsValidDate(dfrom, '<?php echo DOB_FORMAT_STRING; ?>')) && (dto.length > 0) && (IsValidDate(dto, '<?php echo DOB_FORMAT_STRING; ?>'))) {
    if (!CheckDateRange(document.advanced_search.dfrom, document.advanced_search.dto)) {
      error_message = error_message + "* <?php echo ERROR_TO_DATE_LESS_THAN_FROM_DATE; ?>\n";
      error_field = document.advanced_search.dto;
      error_found = true;
    }
  }

  if (pfrom.length > 0) {
    pfrom_float = parseFloat(pfrom);
    if (isNaN(pfrom_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_FROM_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pfrom;
      error_found = true;
    }
  } else {
    pfrom_float = 0;
  }

  if (pto.length > 0) {
    pto_float = parseFloat(pto);
    if (isNaN(pto_float)) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_MUST_BE_NUM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  } else {
    pto_float = 0;
  }

  if ( (pfrom.length > 0) && (pto.length > 0) ) {
    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
      error_message = error_message + "* <?php echo ERROR_PRICE_TO_LESS_THAN_PRICE_FROM; ?>\n";
      error_field = document.advanced_search.pto;
      error_found = true;
    }
  }

  if (error_found == true) {
    alert(error_message);
    error_field.focus();
    return false;
  } else {
    return true;
  }
}

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<div class="row">
  <div class="col-md-9">
    <h1><?php echo HEADING_TITLE_1; ?></h1>

<?php
  if ($messageStack->size('search') > 0) {
    echo $messageStack->output('search');
  }
?>

    <?php echo tep_draw_form('advanced_search', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'onsubmit="return check_form(this);"') . tep_hide_session_id(); ?>

    <h2><?php echo HEADING_SEARCH_CRITERIA; ?></h2>


    <div class="input-group">
      <?php echo tep_draw_input_field('keywords', '', 'class="form-control" style="width: 100%"');?>
      <span class="input-group-btn">
        <?php echo tep_draw_button(IMAGE_BUTTON_SEARCH, 'search', null, 'primary', null, 'btn btn-default" type="button'); ?>
      </span>
    </div>
    <?php echo tep_draw_hidden_field('search_in_description', '1'); ?>
    <span><?php echo '<a href="' . tep_href_link(FILENAME_POPUP_SEARCH_HELP) . '" target="_blank" onclick="$(\'#helpSearch\').dialog(\'open\'); return false;">' . TEXT_SEARCH_HELP_LINK . '</a>'; ?></span>
      
    <div class="row">
      <div class="col-md-6">
        <div id="helpSearch" title="<?php echo HEADING_SEARCH_HELP; ?>">
          <p><?php echo TEXT_SEARCH_HELP; ?></p>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group" style="
    height: 30px;">   
          <label for="categories_id" class="col-sm-6 control-label"><?php echo ENTRY_CATEGORIES; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_pull_down_menu('categories_id', tep_get_categories(array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES))), null, 'class="form-control"'); ?>
          </div>
        </div>
        
        <div class="form-group" style="
    height: 30px;">
          <div class="col-sm-12">
              <?php echo tep_draw_checkbox_field('inc_subcat', '1', true) . ' ' . ENTRY_INCLUDE_SUBCATEGORIES; ?>
          </div>
        </div>
        
        <div class="form-group" style="
    height: 30px;">
          <label for="manufacturers_id" class="col-sm-6 control-label"><?php echo ENTRY_MANUFACTURERS; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_pull_down_menu('manufacturers_id', tep_get_manufacturers(array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS))), null, 'class="form-control"'); ?>
          </div>
        </div>
      
      <?php
        // START: Extra Fields Contribution Search Fields 1.0
        /*$pef_fields = tep_db_query("SELECT products_extra_fields_id, products_extra_fields_name FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " WHERE (languages_id = 0 OR languages_id = " . (int)$languages_id . ") AND products_extra_fields_status ORDER BY products_extra_fields_order");
        while ($field = tep_db_fetch_array($pef_fields))
        {
        ?>
        <div class="form-group">
          <label for="<?php echo 'pef_'.$field['products_extra_fields_id'];?>" class="col-sm-6 control-label"><?php echo $field['products_extra_fields_name']; ?></label>
          <div class="col-sm-6"><?php echo tep_draw_input_field('pef_'.$field['products_extra_fields_id'], '', ''); ?></div>
        </div>

        <?php
        }
        // END: Extra Fields Contribution*/
        ?>
        <div class="form-group" style="
    height: 30px;">
          <label for="pfrom" class="col-sm-6 control-label"><?php echo ENTRY_PRICE_FROM; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_input_field('pfrom', null, 'class="form-control"'); ?>
          </div>
        </div>
      
        <div class="form-group" style="
    height: 30px;">
          <label for="pto" class="col-sm-6 control-label"><?php echo ENTRY_PRICE_TO; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_input_field('pto', null, 'class="form-control"'); ?>
          </div>
        </div>
      
        <div class="form-group" style="
    height: 30px;">
          <label for="dfrom" class="col-sm-6 control-label"><?php echo ENTRY_DATE_FROM; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_input_field('dfrom', '', 'id="dfrom" class="form-control"'); ?><script type="text/javascript">$('#dfrom').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});</script>
          </div>
        </div>
      
        <div class="form-group">
          <label for="dto" class="col-sm-6 control-label"><?php echo ENTRY_DATE_TO; ?></label>
          <div class="col-sm-6">
            <?php echo tep_draw_input_field('dto', '', 'id="dto" class="form-control"'); ?><script type="text/javascript">$('#dto').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-10:+0'});</script>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
