<?php
/*
  $Id: slideshow.php,v 1.1 2011/04/19 12:00 parorrey
 
  Ali Qureshi - PI Media
  http://www.parorrey.com

  Copyright (c) 2011 PI Media

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

 $slideshow_dir = 'slideshow/';
  
  define('DIR_FS_CATALOG_SLIDES', DIR_FS_CATALOG_IMAGES . $slideshow_dir);
  define('DIR_WS_CATALOG_SLIDES', DIR_WS_CATALOG_IMAGES . $slideshow_dir);

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($HTTP_GET_VARS['slideID'])) $slideshow_id = tep_db_prepare_input($HTTP_GET_VARS['slideID']);
        $slideshow_name = tep_db_prepare_input($HTTP_POST_VARS['slideshow_name']);
		 $slideshow_url = tep_db_prepare_input($HTTP_POST_VARS['slideshow_url']);
		 $slideshow_addtocart = tep_db_prepare_input($HTTP_POST_VARS['slideshow_addtocart']);
		 $slideshow_description = tep_db_prepare_input($HTTP_POST_VARS['slideshow_description']);

        $sql_data_array = array('slideshow_name' => $slideshow_name,
								'slideshow_url' => $slideshow_url,
								'slideshow_addtocart' => $slideshow_addtocart,
		                        'slideshow_description' => $slideshow_description);

        if ($action == 'insert') {
          $insert_sql_data = array('date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          tep_db_perform(TABLE_SLIDESHOW, $sql_data_array);
          $slideshow_id = tep_db_insert_id();
        } elseif ($action == 'save') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          tep_db_perform(TABLE_SLIDESHOW, $sql_data_array, 'update', "slideshow_id = '" . (int)$slideshow_id . "'");
        }

	 
	  if($_FILES['slideshow_image']['size']!=0){
	  
	  $slideshow_image = new upload('slideshow_image', DIR_FS_CATALOG_SLIDES);
	    
	    if ($slideshow_image) {
          tep_db_query("update " . TABLE_SLIDESHOW . " set slideshow_image = '" .$slideshow_dir . $slideshow_image->filename . "' where slideshow_id = '" . (int)$slideshow_id . "'");
        }
        
	  }
       
	if (USE_CACHE == 'true') {
          tep_reset_cache_block('slideshow');
        }

        tep_redirect(tep_href_link(FILENAME_SLIDESHOW, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'slideID=' . $slideshow_id));
        break;
      case 'deleteconfirm':
        $slideshow_id = tep_db_prepare_input($HTTP_GET_VARS['slideID']);

        if (isset($HTTP_POST_VARS['delete_image']) && ($HTTP_POST_VARS['delete_image'] == 'on')) {
          $slideshow_query = tep_db_query("select slideshow_image from " . TABLE_SLIDESHOW . " where slideshow_id = '" . (int)$slideshow_id . "'");
          $slideshow = tep_db_fetch_array($slideshow_query);

          $image_location = DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG_SLIDES . $slideshow['slideshow_image'];

          if (file_exists($image_location)) @unlink($image_location);
        }

        tep_db_query("delete from " . TABLE_SLIDESHOW . " where slideshow_id = '" . (int)$slideshow_id . "'");
       
        if (USE_CACHE == 'true') {
          tep_reset_cache_block('slideshow');
        }

        tep_redirect(tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page']));
        break;
    }
  }
  
require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SLIDESHOW; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $slideshow_query_raw = "select slideshow_id, slideshow_name, slideshow_description, slideshow_image, slideshow_url, slideshow_addtocart, date_added, last_modified from " . TABLE_SLIDESHOW . " order by slideshow_id";
  $slideshow_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $slideshow_query_raw, $slideshow_query_numrows);
  $slideshow_query = tep_db_query($slideshow_query_raw);
  
  
  while ($slideshow = tep_db_fetch_array($slideshow_query)) {
  
   if ((!isset($HTTP_GET_VARS['slideID']) || (isset($HTTP_GET_VARS['slideID']) && ($HTTP_GET_VARS['slideID'] == $slideshow['slideshow_id']))) && !isset($sdInfo) && (substr($action, 0, 3) != 'new')) {
     
      $sdInfo = new objectInfo($slideshow);
    }
 if (isset($sdInfo) && is_object($sdInfo) && ($slideshow['slideshow_id'] == $sdInfo->slideshow_id)) {
      echo '<tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $slideshow['slideshow_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '<tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $slideshow['slideshow_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $slideshow['slideshow_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($sdInfo) && is_object($sdInfo) && ($slideshow['slideshow_id'] == $sdInfo->slideshow_id)) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $slideshow['slideshow_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $slideshow_split->display_count($slideshow_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_SLIDES); ?></td>
                    <td class="smallText" align="right"><?php echo $slideshow_split->display_links($slideshow_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id . '&action=new') . '">' . tep_image_button('button_insert.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_SLIDE . '</b>');

      $contents = array('form' => tep_draw_form('slideshow', FILENAME_SLIDESHOW, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_NAME . '<br>' . tep_draw_input_field('slideshow_name'));
	  $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_DESCRIPTION . '<br>' . tep_draw_textarea_field('slideshow_description','',50,10));
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_IMAGE . '<br>' . tep_draw_file_field('slideshow_image'));
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_URL . '<br>' . tep_draw_input_field('slideshow_url'));
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_ADD_TO_CART . '<br>' . tep_draw_input_field('slideshow_addtocart'));
	   
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $HTTP_GET_VARS['slideID']) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_SLIDE . '</b>');

      $contents = array('form' => tep_draw_form('slideshow', FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_NAME . '<br>' . tep_draw_input_field('slideshow_name', $sdInfo->slideshow_name));
     $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_DESCRIPTION . '<br>' . tep_draw_textarea_field('slideshow_description', 'soft',50,10,$sdInfo->slideshow_description));
	 
	 if($sdInfo->slideshow_image) $slideshow_image_src = '<img src="'.DIR_WS_CATALOG_IMAGES.$sdInfo->slideshow_image. '">';
	  
	  $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_IMAGE . '<br>' . tep_draw_file_field('slideshow_image') . '<br>' . $slideshow_image_src);
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_URL . '<br>' . tep_draw_input_field('slideshow_url', $sdInfo->slideshow_url));
      $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_ADD_TO_CART . '<br>' . tep_draw_input_field('slideshow_addtocart', $sdInfo->slideshow_addtocart));
      
	  $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_save.gif', IMAGE_SAVE) . ' <a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_SLIDE . '</b>');

      $contents = array('form' => tep_draw_form('slideshow', FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $sdInfo->slideshow_name . '</b>');
	  $contents[] = array('text' => '<br><b>' . $sdInfo->slideshow_description . '</b>');
      $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);
      $contents[] = array('text' => '<br><b>' . $sdInfo->slideshow_url . '</b>');
      $contents[] = array('text' => '<br><b>' . $sdInfo->slideshow_addtocart . '</b>');
     
	
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (isset($sdInfo) && is_object($sdInfo)) {
        $heading[] = array('text' => '<b>' . $sdInfo->slideshow_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_SLIDESHOW, 'page=' . $HTTP_GET_VARS['page'] . '&slideID=' . $sdInfo->slideshow_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . tep_date_short($sdInfo->date_added));
	
        if (tep_not_null($sdInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . tep_date_short($sdInfo->last_modified));
        $contents[] = array('text' => '<br>' . tep_info_image($sdInfo->slideshow_image, $sdInfo->slideshow_name));
        $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_URL . ' ' . $sdInfo->slideshow_url);
        $contents[] = array('text' => '<br>' . TEXT_SLIDESHOW_URL . ' ' . $sdInfo->slideshow_addtocart);
      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
