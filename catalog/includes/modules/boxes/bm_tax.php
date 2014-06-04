<?php

  class bm_tax {
    
    function bm_tax() {
      global $HTTP_SERVER_VARS;
    
      $this->code = 'bm_tax';
      
      $this->moduleinfo = array(
        'name'        => 'Tax Switch',
        'description' => 'This module lets customers choose wheither to display prices with or without tax.',
        'changelog'   => array(
          //'x.x' => '*/+/- Your changelog text.',
          '1.0' => '+ Module created /Tim',
        ),
        'author'      => 'T. Almroth',
        'platform'    => 'osCommerce 2.3',
        'homepage'    => 'http://www.tim-international.net',
        'support'     => 'http://forums.oscommerce.com',
      );
      
      if (basename($HTTP_SERVER_VARS['PHP_SELF']) == 'modules.php') {
        
        $this->title = '[TiM\'s osC Modules] '. $this->moduleinfo['name'] . ' version ' . key($this->moduleinfo['changelog']);
        
        $this->description = $this->moduleinfo['description'] . '<br><br>
          <script language="javascript">
          function changeloggg() {
            alert(\'* = Ändrat\\\\n+ = Tillagt\\\n- = Borttaget\\\n\\\n' . implode('\\\n', array_reverse($this->moduleinfo['changelog'])) . '\')
          }
          </script>
          <table border="0" cellpadding="2" cellspacing="0" bgcolor="#F0F1F1" align="center">
            <tr class"dataTableHeadingRow">
              <th colspan="2" class="dataTableHeadingContent" bgcolor="#cecbce" nowrap="nowrap"><strong>Information</strong></th>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Module Name: </strong></td>
              <td class="dataTableContent">'. $this->moduleinfo['name'] .'</td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Author: </strong></td>
              <td class="dataTableContent">'. $this->moduleinfo['author'] .'</td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Platform:</strong></td>
              <td class="dataTableContent">'. $this->moduleinfo['platform'] .'</td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Module Version:</strong></td>
              <td class="dataTableContent">'. key($this->moduleinfo['changelog']) .'</td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Changelog:</strong></td>
              <td class="dataTableContent"><a href="javascript:changeloggg();">&lt;Klicka to view&gt;</a></td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Application Link:</strong></td>
              <td class="dataTableContent"><a href="'. $this->moduleinfo['homepage'] .'" target="_blank">'. substr($this->moduleinfo['homepage'], 0, 18) .'...</a></td>
            </tr>
            <tr class"dataTableRow">
              <td class="dataTableContent" nowrap="nowrap"><strong>Support Link:</strong></td>
              <td class="dataTableContent"><a href="'. $this->moduleinfo['support'] .'" target="_blank">'. substr($this->moduleinfo['support'], 0, 18) .'...</a></td>
            </tr>
            <tr class"dataTableRow">
              <td valign="top" class="dataTableContent" nowrap="nowrap"><strong>Capability Test:</strong></td>
              <td valign="top" class="dataTableContent">
              <table>
                <tr class"dataTableRow">
                  <td valign="top" class="dataTableContent" nowrap="nowrap">PHP5+</td>
                  <td valign="top" class="dataTableContent" nowrap="nowrap" style="padding-left: 10px;">'. ((version_compare(PHP_VERSION, '5.0.0', '>')) ? '<span style="color: #009900;">'. phpversion() .'</span>' : '<span style="color: #FF0000;">'. phpversion() .'</span>') .'</td>
                </tr>
              </table>
              </td>
            </tr>
          </table>';
        
      } else {
        
        $this->title = $this->moduleinfo['name'];
      }
      
      if (defined('MODULE_BOXES_TAX_STATUS')) {
        $this->sort_order = MODULE_BOXES_TAX_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_TAX_STATUS == 'True');
        $this->group = ((MODULE_BOXES_TAX_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate, $PHP_SELF;
      
      $data = '<div class="ui-widget infoBoxContainer">' .
              '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_TAX_BOX_TITLE . '</div>' .
              '  <div class="ui-widget-content infoBoxContents">' .
              '    ' . ((DISPLAY_PRICE_WITH_TAX == 'true') ? '<strong>' . TEXT_DISPLAYING_PRICES_WITH_TAX . '</strong>' : '<a href="' . tep_href_link(FILENAME_DEFAULT, 'action=toggle_tax&display_tax=true&uri='. urlencode($_SERVER['REQUEST_URI'])) . '">' . TEXT_DISPLAY_PRICES_WITH_TAX . '</a>') . '<br />' .
              '    ' . ((DISPLAY_PRICE_WITH_TAX == 'false') ? '<strong>' . TEXT_DISPLAYING_PRICES_WITHOUT_TAX . '</strong>' : '<a href="' . tep_href_link(FILENAME_DEFAULT, 'action=toggle_tax&display_tax=false&uri='. urlencode($_SERVER['REQUEST_URI'])) . '">' . TEXT_DISPLAY_PRICES_WITHOUT_TAX . '</a>') . 
              '  </div>' .
              '</div>';

      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_TAX_STATUS');
    }

    function install() {
      $this->remove();
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Module', 'MODULE_BOXES_TAX_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_TAX_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_TAX_SORT_ORDER', '5091', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
        'MODULE_BOXES_TAX_STATUS',
        'MODULE_BOXES_TAX_CONTENT_PLACEMENT',
        'MODULE_BOXES_TAX_SORT_ORDER'
      );
    }
  }
  
?>