<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_free_shipping {
    var $code = 'bm_free_shipping';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_free_shipping() {
      $this->title = MODULE_BOXES_FREE_SHIPPING_TITLE;
      $this->description = MODULE_BOXES_FREE_SHIPPING_DESCRIPTION;

      if ( defined('MODULE_BOXES_FREE_SHIPPING_STATUS') ) {
        $this->sort_order = MODULE_BOXES_FREE_SHIPPING_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_FREE_SHIPPING_STATUS == 'True');
        $this->pages = MODULE_BOXES_FREE_SHIPPING_DISPLAY_PAGES;
        $this->info = MODULE_BOXES_FREE_SHIPPING_INFO_PAGE;

        $this->group = ((MODULE_BOXES_FREE_SHIPPING_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;
        
        $data = '<div class="panel panel-default shipping">'.
			  '<div class="panel-body">'.
				'<h3>FREE SHIPPING</h3>'.
				'<p>'.MODULE_BOXES_FREE_SHIPPING_CONDITIONS.'</p>'.
				'<a href="'.tep_href_link(FILENAME_INFORMATION, 'info_id=' . MODULE_BOXES_FREE_SHIPPING_INFO_PAGE).'" class="btn btn-info btn-sm">Learn More</a>'.
			  '</div>'.
			'</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_FREE_SHIPPING_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Free Shipping Module', 'MODULE_BOXES_FREE_SHIPPING_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_FREE_SHIPPING_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_FREE_SHIPPING_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display in pages.', 'MODULE_BOXES_FREE_SHIPPING_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', '6', '0','tep_cfg_select_pages(' , now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Information page.', 'MODULE_BOXES_FREE_SHIPPING_INFO_PAGE', '1', 'Enter information page to point to.', '6', '1', now())");
      }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_FREE_SHIPPING_STATUS', 'MODULE_BOXES_FREE_SHIPPING_CONTENT_PLACEMENT', 'MODULE_BOXES_FREE_SHIPPING_SORT_ORDER', 'MODULE_BOXES_FREE_SHIPPING_INFO_PAGE', 'MODULE_BOXES_FREE_SHIPPING_DISPLAY_PAGES');
    }
  }
?>
