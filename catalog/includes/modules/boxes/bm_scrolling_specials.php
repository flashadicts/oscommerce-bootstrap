<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_scrolling_specials {
    var $code = 'bm_scrolling_specials';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $pages;
    
    function bm_scrolling_specials() {
      $this->title = MODULE_BOXES_SCROLLING_SPECIALS_TITLE;
      $this->description = MODULE_BOXES_SCROLLING_SPECIALS_DESCRIPTION;

      if ( defined('MODULE_BOXES_SCROLLING_SPECIALS_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SCROLLING_SPECIALS_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SCROLLING_SPECIALS_STATUS == 'True');
        $this->pages = MODULE_BOXES_SCROLLING_SPECIALS_DISPLAY_PAGES;
        $this->group = ((MODULE_BOXES_SCROLLING_SPECIALS_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
        global $HTTP_GET_VARS, $languages_id, $currencies, $oscTemplate;
        
        if (!isset($HTTP_GET_VARS['products_id'])) {
            $rp_query = tep_db_query("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c  where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added DESC");

            if (tep_db_num_rows($rp_query)) {
            
                while ($random_product = tep_db_fetch_array($rp_query)) {
                
                    $rp .= '<li>' .
                    '<div class="thumbnail">' .
                    '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name']) . '</a>' .
                    '</div>' .
                    '<div class="info">' .
                    '<h5><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">' . $random_product['products_name'] . '</a></h5>' .
                    '<span class="price">' . $currencies->display_price($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>' .
                    '</div>' .
                    tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post') . tep_draw_hidden_field('cart_quantity', '1') . tep_draw_hidden_field('products_id', $random_product['products_id']) .
                    tep_draw_button('<span class="glyphicon glyphicon-shopping-cart"></span>', '', null,'specials',null, 'btn btn-default btn-sm')                    .
                    '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '" class="btn btn-default btn-sm">' .
                    '<span class="new-button-details">Details</span>' .
                    '</a>' .
                    '</form>' .
                    '<div class="clear"></div>' .
                    '</li>';

          
                }
                $data = '<div class="panel panel-default specials hidden-sm">' .
                        '<div class="panel-heading"><a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . MODULE_BOXES_SCROLLING_SPECIALS_BOX_TITLE . '</a></div>' .
                        '<div class="panel-body">' .
                        '<div id="specials-scroll">' .
                        '<div class="specials-jcarousellite">' .
                        '<ul>'.$rp.'</ul>' .
                        '</div>' .
                        '</div>' .
                        '</div>' .
                        '</div>' .
                        '</div>';
        
                $oscTemplate->addBlock($data, $this->group);
            }
        }
    }
    
    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SCROLLING_SPECIALS_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Scrolling Specials Module', 'MODULE_BOXES_SCROLLING_SPECIALS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SCROLLING_SPECIALS_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SCROLLING_SPECIALS_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Display in pages.', 'MODULE_BOXES_SCROLLING_SPECIALS_DISPLAY_PAGES', 'all', 'select pages where this box should be displayed. ', '6', '0','tep_cfg_select_pages(' , now())");
      }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SCROLLING_SPECIALS_STATUS', 'MODULE_BOXES_SCROLLING_SPECIALS_CONTENT_PLACEMENT', 'MODULE_BOXES_SCROLLING_SPECIALS_SORT_ORDER', 'MODULE_BOXES_SCROLLING_SPECIALS_DISPLAY_PAGES');
    }
  }
?>
