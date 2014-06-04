<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_enhanced_categories {
    var $code = 'bm_enhanced_categories';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_enhanced_categories() {
      $this->title = MODULE_BOXES_ENHANCED_CATEGORIES_TITLE;
      $this->description = MODULE_BOXES_ENHANCED_CATEGORIES_DESCRIPTION;

      if ( defined('MODULE_BOXES_ENHANCED_CATEGORIES_STATUS') ) {
        $this->sort_order = MODULE_BOXES_ENHANCED_CATEGORIES_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_ENHANCED_CATEGORIES_STATUS == 'True');

        $this->group = ((MODULE_BOXES_ENHANCED_CATEGORIES_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $category_info_array, $cPath, $cPath_array, $current_category_id, $PHP_SELF, $oscTemplate, $hiddencats;
      
      if (!isset($category_info_array) || !is_array($category_info_array)) $category_info_array = tep_build_category_info_array();
      $cat_pdown = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
      $count = '';
      $categories_string = '';
      if (tep_not_null($cPath)) {
        $shown_path = $cPath_array;
        $shown_path[] = 0;
      } else {
        $shown_path = array(0);
      }
      $subcat_pointer = '<span class="ui-icon ui-icon-triangle-1-e" style="display: inline-block; vertical-align: middle;"></span>';
      foreach ($category_info_array as $id => $cat) {
        if ($cat['hidden']) continue;
        if (SHOW_COUNTS == 'true') {
          $count = '<small>&nbsp;(' . $cat['prod_count'] . ')</small>';
        }
        $cat_pdown[] = array('id' => $cat['path'], 'text' => $cat['indent'] . $cat['name'] . strip_tags($count));
        if (in_array($cat['parent'], $shown_path)) {
          $categories_string .= $cat['indent'] . '<a href="' . tep_href_link(FILENAME_DEFAULT, 'cPath=' . $cat['path']) . '">';
          if (isset($cPath_array) && in_array($id, $cPath_array)) {
            $categories_string .= '<strong>';
          }
          if ($id == $current_category_id) {
            $categories_string .= '<span class="errorText">';
          }
          $categories_string .= $cat['name']; // display category name
          if ($id == $current_category_id) {
		    	  $categories_string .= '</span>';
          }
          if (isset($cPath_array) && in_array($id, $cPath_array)) {
            $categories_string .= '</strong>';
          }
          $categories_string .= '</a>';
          if ($cat['has_subcat']) {
            $categories_string .= $subcat_pointer;
          }
          $categories_string .= $count . "<br />\n";
        }
      }
      $numspecials = '';
      if (SHOW_COUNTS == 'true') {
        $hiddenlist = ""; 
        if (!empty($hiddencats)) {
          $hiddenlist = " and (not (p2c.categories_id in (" . implode(',', $hiddencats) . ")))";
        }
        $specials_query = tep_db_query('select count(distinct s.products_id) as total from ' . TABLE_SPECIALS . ' s join ' . TABLE_PRODUCTS . ' p, ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c where p.products_status = 1 and s.products_id = p.products_id and s.status = 1 and p2c.products_id = p.products_id' . $hiddenlist);
        $specials_count = tep_db_fetch_array($specials_query);
        $numspecials = '<small>&nbsp;(' . $specials_count['total'] . ')</small>';
      }
      if ( (basename($PHP_SELF) != FILENAME_SPECIALS)) {
        $categories_string .= '<strong><a href="' . tep_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '">' . MODULE_BOXES_ENHANCED_CATEGORIES_SPECIALS . '</a></strong>' . $numspecials;
      } else {
        $categories_string .= '<strong><a href="' . tep_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '"><span class="errorText">' . MODULE_BOXES_ENHANCED_CATEGORIES_SPECIALS . '</span></a></strong>' . $numspecials;
      }
      $categories_string .= "<br />\n";
      if ( (basename($PHP_SELF) != FILENAME_PRODUCTS_NEW)) {
        $categories_string .= '<strong><a href="' . tep_href_link(FILENAME_PRODUCTS_NEW, '', 'NONSSL') . '">' . MODULE_BOXES_ENHANCED_CATEGORIES_NEWEST . '</a></strong>';
      } else {
         $categories_string .= '<strong><a href="' . tep_href_link(FILENAME_PRODUCTS_NEW, '', 'NONSSL') . '"><span class="errorText">' . MODULE_BOXES_ENHANCED_CATEGORIES_NEWEST . '</span></a></strong>';
      }
      $categories_string .= "<br />\n" . tep_draw_form('categories', tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get') . '<strong>' . MODULE_BOXES_ENHANCED_CATEGORIES_GOTO . '</strong><br />' . tep_draw_pull_down_menu('cPath', $cat_pdown, $cPath, 'onchange="this.form.submit();" style="width: 100%"') . tep_hide_session_id() . '</form>';

      $output = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_ENHANCED_CATEGORIES_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents">' . $categories_string . '</div>' .
              '</div>';

      $oscTemplate->addBlock($output, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_ENHANCED_CATEGORIES_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Enhanced Categories Module', 'MODULE_BOXES_ENHANCED_CATEGORIES_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_ENHANCED_CATEGORIES_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_ENHANCED_CATEGORIES_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_ENHANCED_CATEGORIES_STATUS', 'MODULE_BOXES_ENHANCED_CATEGORIES_CONTENT_PLACEMENT', 'MODULE_BOXES_ENHANCED_CATEGORIES_SORT_ORDER');
    }
  }
?>
