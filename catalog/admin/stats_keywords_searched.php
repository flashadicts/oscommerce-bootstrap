<?php
/*
  $Id: stats_keywords_searched.php,v 1.29 2013/10/04 22:50:52 fur Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
    
  require('includes/application_top.php');
  
  require(DIR_WS_INCLUDES . 'template_top.php');
  
  $count_by = $_GET['count_by'] ? $_GET['count_by'] : 'newest';
  
  $date_from = $_GET['date_from'] ? $_GET['date_from'] : '';
  $date_to = $_GET['date_to'] ? $_GET['date_to'] : date('Y-m-d');
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="center">
              <?php echo tep_draw_form('filter', FILENAME_STATS_KEYWORDS_SEARCHED, '', 'get'); ?>
              <table style="border: 1px dashed black;">
                <tr>
                  <td class="main">Count By:</td>
                  <td class="main" colspan="2"><?php
                  echo '<label><input type="radio" name="count_by" value="newest" ' . ($count_by == 'newest' ? 'CHECKED ' : '') . 'onchange="this.form.submit();"/> Newest</label>';
                  echo '<label><input type="radio" name="count_by" value="keywords" ' . ($count_by == 'keywords' ? 'CHECKED ' : '') . 'onchange="this.form.submit();"/> Keywords</label>'; 
                  echo '<label><input type="radio" name="count_by" value="customers_id" ' . ($count_by == 'customers_id' ? 'CHECKED ' : '') . 'onchange="this.form.submit();"/> Customer</label>';
                  echo '<label><input type="radio" name="count_by" value="ip" ' . ($count_by == 'newest' ? 'ip ' : '') . 'onchange="this.form.submit();"/> IP</label>';
                  ?></td>
                </tr>
                <tr>
                  <td class="main">Date:</td>
                  <td class="main" colspan="2"><?php echo tep_draw_input_field('date_from', '', 'id="date_from"'); ?> to <?php echo tep_draw_input_field('date_to', '', 'id="date_to"'); ?></td>
                </tr>
                <tr>
                  <td class="main">Pages:</td>
                  <td><?php
                  foreach(range(1,30) as $i)
                    $pages_options[] = array('id' => $i, 'text' => '>=' . $i);
                  echo tep_draw_pull_down_menu('pages', $pages_options, $_GET['pages'], 'onchange="this.form.submit();"');
                  ?></td>
                  <td align="right"><?php echo tep_image_submit('button_search.gif', 'Search'); ?></td>
                </tr>
              </table>
              <?php echo '</form>'; ?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">No.</td>
                <?php
                if ($_GET['keywords'] || $_GET['customers_id'] || $_GET['ip'])
                  $count_by = 'newest';
                
                switch($count_by){
                  case 'keywords':
                    $headings = array(TABLE_HEADING_KEYWORDS, TABLE_HEADING_NUM_RESULTS, TABLE_HEADING_LAST_SEARCHED_DATE, TABLE_HEADING_NUM_SEARCHED);
                    break;
                  case 'customers_id':
                    $headings = array(TABLE_HEADING_CUSTOMERS, TABLE_HEADING_LAST_SEARCHED_DATE, TABLE_HEADING_LAST_SEARCHED_DATE, TABLE_HEADING_NUM_SEARCHED);
                    break;
                  case 'ip':
                    $headings = array(TABLE_HEADING_IP, TABLE_HEADING_LAST_SEARCHED_DATE, TABLE_HEADING_LAST_SEARCHED_DATE, TABLE_HEADING_NUM_SEARCHED);
                    break;
                  case 'newest';
                    $headings = array(TABLE_HEADING_KEYWORDS, TABLE_HEADING_NUM_RESULTS, TABLE_HEADING_CUSTOMERS, TABLE_HEADING_IP, TABLE_HEADING_PAGES, TABLE_HEADING_PRODUCT_IDS, TABLE_HEADING_ORDER_ID, TABLE_HEADING_DATE_SEARCHED);
                    break;
                }
                foreach($headings as $heading){
                ?>
                <td class="dataTableHeadingContent"><?php echo $heading; ?></td>
                <?php
                }
                ?>
              </tr>
              <?php
                if (isset($_GET['page']) && ($_GET['page'] > 1))
                  $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS - MAX_DISPLAY_SEARCH_RESULTS;
                              
                if ($_GET['keywords']) {
                  $where_str = "where keywords = '" . tep_db_input($_GET['keywords']) . "' ";
                } elseif ($_GET['customers_id']) {
                  $where_str = "where customers_id = '" . tep_db_input($_GET['customers_id']) . "' ";
                } elseif ($_GET['ip']) {
                  $where_str = "where ip = '" . tep_db_input($_GET['ip']) . "' ";
                } else {
				  $where_str = "where 1 ";
				}
                
                switch($count_by){
                  case 'newest':
                    $select_str = "select * ";
                    $from_str = "from " . TABLE_SEARCHED_KEYWORDS . " ";
                    $order_by_str = "order by date_added desc ";
                    $columns = array('keywords', 'number_of_results', 'customers_id', 'ip', 'pages', 'products_ids', 'orders_id', 'date_added');
                    break;
                  default:
                    if($count_by == 'keywords'){
                      $select_str = "select keywords, number_of_results, date_added, count ";
                      $columns = array('keywords', 'number_of_results', 'date_added', 'count');
                    }else{
                      $select_str = "select $count_by, keywords, date_added, count ";
                      $columns = array($count_by, 'keywords', 'date_added', 'count');
                    }
                    $from_str = "from " . TABLE_SEARCHED_KEYWORDS . " sk right join (select $count_by as group_$count_by, count(*) as count, max(date_added) as last_date from " . TABLE_SEARCHED_KEYWORDS . " GROUP BY $count_by) skg on sk.$count_by = skg.group_$count_by and sk.date_added = skg.last_date ";
                    $where_str .= "and $count_by is not null ";
                    $order_by_str = "order by count desc ";
                    break;
                }
                
                if ($_GET['date_from'])
                  $where_str .= "and date_added >= '" . tep_db_input($_GET['date_from']) . "' ";
                if ($_GET['date_to'])
                  $where_str .= "and date_added <= '" . tep_db_input($_GET['date_to']) . " 23:59:59' ";
                
                if ($_GET['pages'] > 1)
                  $where_str .= "and (length(pages) - length(replace(pages, ',', '')) >= " . ((int)$_GET['pages'] - 1) . ") ";
               
                $searched_keywords_query_raw = $select_str . $from_str . $where_str . $order_by_str;

                $searched_keywords_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $searched_keywords_query_raw, $searched_keywords_query_numrows);
                $searched_keywords_query = tep_db_query($searched_keywords_query_raw);
                while ($searched_keywords = tep_db_fetch_array($searched_keywords_query)) {
                  $rows++;
              ?>
              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" <?php if($count_by != 'newest'){ ?>onclick="document.location.href='<?php echo tep_href_link(FILENAME_STATS_KEYWORDS_SEARCHED, tep_get_all_get_params() . $count_by . '=' . $searched_keywords[$count_by], 'NONSSL'); ?>'"<?php }?>>
                <td class="dataTableContent"><?php echo str_pad($rows, 3, '0', STR_PAD_LEFT); ?></td>
                <?php
                foreach($columns as $column){
                  $column_text = $searched_keywords[$column];
                  if($column == 'keywords'){
                    $column_text = '<a href="' . tep_href_link('../advanced_search_result.php', 'keywords=' . $column_text, 'NONSSL') . '" target="_blank">' . $column_text . '</a>';
                  }elseif($column == 'customers_id'){
                    $customer_query = tep_db_query("select customers_id, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$column_text . "'");
                    $customer = tep_db_fetch_array($customer_query);
                    $column_text = '<a href="' . tep_href_link(FILENAME_CUSTOMERS, 'action=edit&cID=' . $customer['customers_id']) . '" target="_blank">' . $customer['customers_firstname'] . ' ' . $customer['customers_lastname'] . '</a>';
                  }elseif($column == 'ip'){
                    $column_text = '<a href="http://ipshark.net/?domain=' . $column_text . '" target="_blank">' . $column_text . '</a>
                                    <a href="http://www.infosniper.net/index.php?ip_address=' . $column_text . '" target="_blank">' . tep_image(DIR_WS_ICONS . 'preview.gif', 'Location Map of IP') . '</a>';
                  }
                ?>
                <td class="dataTableContent"><?php echo $column_text; ?></td>
                <?php
                }
                ?>
              </tr>
              <?php
                }
              ?>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $searched_keywords_split->display_count($searched_keywords_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_KEYWORDS); ?></td>
                <td class="smallText" align="right"><?php echo $searched_keywords_split->display_links($searched_keywords_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], tep_get_all_get_params(array('pages'))); ?></td>
              </tr>
            </table></td>
          </tr>
          <?php if ($_GET['keywords'] || $_GET['customers_id'] || $_GET['ip']){ ?>
          <tr>
            <td><a href="<?php echo tep_href_link(FILENAME_STATS_KEYWORDS_SEARCHED, tep_get_all_get_params(array('keywords', 'customers_id', 'ip'))); ?>"><?php echo tep_image_button('button_back.gif', 'Back'); ?></a></td>
          </tr>
          <?php } ?>
        </table></td>
      </tr>
    </table>
    <script type="text/javascript">
    $(document).ready(function(){
      $('td.dataTableContent a').click(stopPropagation);
	  
	  $('#date_from').datepicker({
        dateFormat: 'yy-mm-dd'
      });
	  
	  $('#date_to').datepicker({
        dateFormat: 'yy-mm-dd'
      });
    });
    function stopPropagation(e){
      e.stopPropagation();
    }
    </script>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>