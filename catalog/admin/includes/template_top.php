<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<meta name="robots" content="noindex,nofollow">
<title><?php echo TITLE; ?></title>
<base href="<?php echo HTTP_SERVER . DIR_WS_ADMIN; ?>" />
<!--[if IE]><script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/excanvas.min.js'); ?>"></script><![endif]-->
<?php
/* Pages that use new version of jQuery & jQuery-UI */
  if ($PHP_SELF == 'order_handler.php') { ?>
<link rel="stylesheet" type="text/css" href="<?php echo tep_catalog_href_link('ext/jquery/ui/redmond/jquery-ui-1.10.4.css'); ?>">
<link rel="stylesheet" type="text/css" href="css/bootstrap-3.1.1.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.3.1.1.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-multiselect-3.1.1.css">
<link rel="stylesheet" type="text/css" href="css/tikslusdialog.css">
<!-- <link rel="stylesheet" type="text/css" href="css/avgrund.css"> -->
<link rel="stylesheet" type="text/css" href="css/select2.css">
<link rel="stylesheet" type="text/css" href="css/line/red.css">
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/jquery-2.1.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<?php
/* Pages that use old version of jQuery & jQuery-UI */
  } else {
?>
<link rel="stylesheet" type="text/css" href="<?php echo tep_catalog_href_link('ext/jquery/ui/redmond/jquery-ui-1.8.22.css'); ?>">
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/jquery-1.8.0.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/jquery-ui-1.8.22.min.js'); ?>"></script>
<?php
  }
?>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

<script type="text/javascript">
// fix jQuery 1.8.0 and jQuery UI 1.8.22 bug with dialog buttons; http://bugs.jqueryui.com/ticket/8484
if ( $.attrFn ) { $.attrFn.text = true; }
</script>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/i18n/jquery.ui.datepicker-' . JQUERY_DATEPICKER_I18N_CODE . '.js'); ?>"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.js'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.time.min.js'); ?>"></script>
<script type="text/javascript" src="includes/general.js"></script>
<?php
if (!defined('USE_CKEDITOR_ADMIN_TEXTAREA')) {
tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) values ('', 'Use CKEditor', 'USE_CKEDITOR_ADMIN_TEXTAREA','true','Use CKEditor for WYSIWYG editing of textarea fields in admin',1,99,now(),'tep_cfg_select_option(array(\'true\', \'false\'),' )");
define ('USE_CKEDITOR_ADMIN_TEXTAREA','true');
}
if (USE_CKEDITOR_ADMIN_TEXTAREA == "true") {
?>
<script type="text/javascript" src="<?php echo tep_href_link('ext/ckeditor/ckeditor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_href_link('ext/ckeditor/adapters/jquery.js'); ?>"></script>
<script type="text/javascript">
$(function() {
var $editors = $('textarea');
if ($editors.length) {
$editors.each(function() {
var editorID = $(this).attr("id");
var instance = CKEDITOR.instances[editorID];
if (instance) { CKEDITOR.remove(instance); }
CKEDITOR.replace(editorID);
});
}
});
</script>
<?php
}
?>

</head>
<body>

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php
  if (tep_session_is_registered('admin')) {
    include(DIR_WS_INCLUDES . 'column_left.php');
  } else {
?>

<style>
#contentText {
  margin-left: 0;
}
</style>

<?php
  }
?>

<div id="contentText">
