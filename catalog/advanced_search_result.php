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
  // START: Extra Fields Contribution Search Fields 1.0
  $pef_fields = array();
  $pef_fields_query = tep_db_query("SELECT products_extra_fields_id, products_extra_fields_name FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " WHERE (languages_id = 0 OR languages_id = " . (int)$languages_id . ") AND products_extra_fields_status ORDER BY products_extra_fields_order");
  while ($field = tep_db_fetch_array($pef_fields_query))
  {
    $pef_fields[] = $field;
  }
  $pef_empty = true;
  foreach ($pef_fields as $field)
  {
	$pef_id = 'pef_'.$field['products_extra_fields_id'];
	if (isset($HTTP_GET_VARS[$pef_id]) && !empty($HTTP_GET_VARS[$pef_id]))
	  $pef_empty = false;
    }
   // END: Extra Fields Contribution

  $error = false;

  if ( (isset($HTTP_GET_VARS['keywords']) && empty($HTTP_GET_VARS['keywords'])) && $pef_empty &&
       (isset($HTTP_GET_VARS['dfrom']) && (empty($HTTP_GET_VARS['dfrom']) || ($HTTP_GET_VARS['dfrom'] == DOB_FORMAT_STRING))) &&
       (isset($HTTP_GET_VARS['dto']) && (empty($HTTP_GET_VARS['dto']) || ($HTTP_GET_VARS['dto'] == DOB_FORMAT_STRING))) &&
       (isset($HTTP_GET_VARS['pfrom']) && !is_numeric($HTTP_GET_VARS['pfrom'])) &&
       (isset($HTTP_GET_VARS['pto']) && !is_numeric($HTTP_GET_VARS['pto'])) ) {
    $error = true;

    $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
  } else {
    $dfrom = '';
    $dto = '';
    $pfrom = '';
    $pto = '';
    $keywords = '';
    // START: Extra Fields Contribution Search Fields 1.0
    $pef_values = array();
    foreach ($pef_fields as $field){
      if (isset($HTTP_GET_VARS['pef_'.$field['products_extra_fields_id']]) && !empty($HTTP_GET_VARS['pef_'.$field['products_extra_fields_id']])) {
		$pef_values[$field['products_extra_fields_id']] = $HTTP_GET_VARS['pef_'.$field['products_extra_fields_id']]; 
      }
    }
    // END: Extra Fields Contribution


    if (isset($HTTP_GET_VARS['dfrom'])) {
      $dfrom = (($HTTP_GET_VARS['dfrom'] == DOB_FORMAT_STRING) ? '' : $HTTP_GET_VARS['dfrom']);
    }

    if (isset($HTTP_GET_VARS['dto'])) {
      $dto = (($HTTP_GET_VARS['dto'] == DOB_FORMAT_STRING) ? '' : $HTTP_GET_VARS['dto']);
    }

    if (isset($HTTP_GET_VARS['pfrom'])) {
      $pfrom = $HTTP_GET_VARS['pfrom'];
    }

    if (isset($HTTP_GET_VARS['pto'])) {
      $pto = $HTTP_GET_VARS['pto'];
    }

    if (isset($HTTP_GET_VARS['keywords'])) {
      $keywords = tep_db_prepare_input($HTTP_GET_VARS['keywords']);
    }

    $date_check_error = false;
    if (tep_not_null($dfrom)) {
      if (!tep_checkdate($dfrom, DOB_FORMAT_STRING, $dfrom_array)) {
        $error = true;
        $date_check_error = true;

        $messageStack->add_session('search', ERROR_INVALID_FROM_DATE);
      }
    }

    if (tep_not_null($dto)) {
      if (!tep_checkdate($dto, DOB_FORMAT_STRING, $dto_array)) {
        $error = true;
        $date_check_error = true;

        $messageStack->add_session('search', ERROR_INVALID_TO_DATE);
      }
    }

    if (($date_check_error == false) && tep_not_null($dfrom) && tep_not_null($dto)) {
      if (mktime(0, 0, 0, $dfrom_array[1], $dfrom_array[2], $dfrom_array[0]) > mktime(0, 0, 0, $dto_array[1], $dto_array[2], $dto_array[0])) {
        $error = true;

        $messageStack->add_session('search', ERROR_TO_DATE_LESS_THAN_FROM_DATE);
      }
    }

    $price_check_error = false;
    if (tep_not_null($pfrom)) {
      if (!settype($pfrom, 'double')) {
        $error = true;
        $price_check_error = true;

        $messageStack->add_session('search', ERROR_PRICE_FROM_MUST_BE_NUM);
      }
    }

    if (tep_not_null($pto)) {
      if (!settype($pto, 'double')) {
        $error = true;
        $price_check_error = true;

        $messageStack->add_session('search', ERROR_PRICE_TO_MUST_BE_NUM);
      }
    }

    if (($price_check_error == false) && is_float($pfrom) && is_float($pto)) {
      if ($pfrom >= $pto) {
        $error = true;

        $messageStack->add_session('search', ERROR_PRICE_TO_LESS_THAN_PRICE_FROM);
      }
    }

    if (tep_not_null($keywords)) {
      if (!tep_parse_search_string($keywords, $search_keywords)) {
        $error = true;

        $messageStack->add_session('search', ERROR_INVALID_KEYWORDS);
      }
    }
    // START: Extra Fields Contribution Search Fields 1.0
    if (tep_not_null($pef_values)) {
      foreach ($pef_values as $pef_value) {
        if (!tep_parse_search_string($pef_value, $pef_value_keywords)) {
          $error = true;
          $messageStack->add_session('search', ERROR_INVALID_KEYWORDS . $pef_value );
        }
      }
    }
    // END: Extra Fields Contribution

  }

  if (empty($dfrom) && empty($dto) && empty($pfrom) && empty($pto) && empty($keywords) 
  // START: Extra Fields Contribution Search Fields 1.0
  && !tep_not_null($pef_values)
  // END: Extra Fields Contribution Search Fields 1.0
  ) {

    $error = true;

    $messageStack->add_session('search', ERROR_AT_LEAST_ONE_INPUT);
  }

  if ($error == true) {
    tep_redirect(tep_href_link(FILENAME_ADVANCED_SEARCH, tep_get_all_get_params(), 'NONSSL', true, false));
  }

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ADVANCED_SEARCH));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, tep_get_all_get_params(), 'NONSSL', true, false));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
      <div class="row">
		<div class="col-md-9">
	  <!-- main tab - start -->
            <div class="row">
              <div class="col-md-12">
                <h2><?php echo HEADING_TITLE_2; ?></h2>
              </div> 
            </div>
            <div class="row" style="margin-bottom: 15px;">
              <div class="col-md-9">
              <?php

// optional Product List Filter
    if (PRODUCT_LIST_FILTER > 0) {
      if (isset($HTTP_GET_VARS['manufacturers_id'])) {
        $filterlist_sql = "select distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "' order by cd.categories_name";
      } else {
        $filterlist_sql= "select distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m where p.products_status = '1' and p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";
      }
      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 0) {
        echo tep_draw_form('filter', tep_href_link( FILENAME_DEFAULT ), 'get', 'class="form-horizontal" role="form"') . '<label for="filter_id" class="col-sm-2 control-label">' . TEXT_SHOW . '</label><div class="col-sm-4">';
        if (isset($HTTP_GET_VARS['manufacturers_id'])) {
          echo tep_draw_hidden_field('manufacturers_id', $HTTP_GET_VARS['manufacturers_id']);
          $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));
        } else {
          echo tep_draw_hidden_field('cPath', $cPath);
          $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));
        }
        echo tep_draw_hidden_field('sort', $HTTP_GET_VARS['sort']);
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);
        }
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($HTTP_GET_VARS['filter_id']) ? $HTTP_GET_VARS['filter_id'] : ''), 'onchange="this.form.submit()" class="form-control"');
        echo tep_hide_session_id() . '</div></form>' . "\n";
      }
      
      
      // Additional Products Sort
      echo tep_draw_form('sort', FILENAME_DEFAULT, 'get', 'class="form-horizontal" role="form"') . '<label for="sort" class="col-sm-2 control-label">Sort by:</label><div class="col-sm-4">';


      if (isset($HTTP_GET_VARS['manufacturers_id'])) {
        echo tep_draw_hidden_field('manufacturers_id', $HTTP_GET_VARS['manufacturers_id']);
      }else{
        echo tep_draw_hidden_field('cPath', $cPath);
      }

      $sort_list = array('2a' => 'A to Z',
                        '2d' => 'Z to A',
                        '3a' => 'Price Low to High',
                        '3d' => 'Price High to Low');
      foreach($sort_list as $id=>$text) {
        $sort_range[] = array('id' => $id, 'text' => $text);
      }

      echo tep_draw_pull_down_menu('sort', $sort_range, (isset($HTTP_GET_VARS['sort']) ? $HTTP_GET_VARS['sort'] : ''), 'onchange="this.form.submit()" class="form-control"');
      echo tep_draw_hidden_field('filter_id', (isset($HTTP_GET_VARS['filter_id']) ? $HTTP_GET_VARS['filter_id'] : ''));
      echo '</div></form>' . "\n";
 // End Additional Products Sort
    }
?>

<?php
// create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                       'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                       'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                       'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                       'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                       'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                       'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                       'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort($define_list);

  $column_list = array();
  reset($define_list);
  while (list($key, $value) = each($define_list)) {
    if ($value > 0) $column_list[] = $key;
  }

  $select_column_list = '';

  for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
    switch ($column_list[$i]) {
      case 'PRODUCT_LIST_MODEL':
        $select_column_list .= 'p.products_model, ';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $select_column_list .= 'm.manufacturers_name, ';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $select_column_list .= 'p.products_quantity, ';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $select_column_list .= 'p.products_image, ';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $select_column_list .= 'p.products_weight, ';
        break;
    }
  }

  $select_str = "select distinct " . $select_column_list . " m.manufacturers_id, p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price ";

  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
    $select_str .= ", SUM(tr.tax_rate) as tax_rate ";
  }

  // START: Extra Fields Contribution
  //  $from_str = "from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m using(manufacturers_id) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id";
  $from_str = "from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " p2pef on p.products_id=p2pef.products_id left join ".TABLE_MANUFACTURERS . " m on p.manufacturers_id=m.manufacturers_id left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id";
  // END: Extra Fields Contribution


  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
    if (!tep_session_is_registered('customer_country_id')) {
      $customer_country_id = STORE_COUNTRY;
      $customer_zone_id = STORE_ZONE;
    }
    $from_str .= " left join " . TABLE_TAX_RATES . " tr on p.products_tax_class_id = tr.tax_class_id left join " . TABLE_ZONES_TO_GEO_ZONES . " gz on tr.tax_zone_id = gz.geo_zone_id and (gz.zone_country_id is null or gz.zone_country_id = '0' or gz.zone_country_id = '" . (int)$customer_country_id . "') and (gz.zone_id is null or gz.zone_id = '0' or gz.zone_id = '" . (int)$customer_zone_id . "')";
  }

    $from_str .= ", " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c";

    // BOF Enable & Disable Categories
    $where_str = " where p.products_status = '1' and c.categories_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id ";
    //$where_str = " where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id "; 
    // EOF Enable & Disable Categories

  if (isset($HTTP_GET_VARS['categories_id']) && tep_not_null($HTTP_GET_VARS['categories_id'])) {
    if (isset($HTTP_GET_VARS['inc_subcat']) && ($HTTP_GET_VARS['inc_subcat'] == '1')) {
      $subcategories_array = array();
      tep_get_subcategories($subcategories_array, $HTTP_GET_VARS['categories_id']);

      $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and (p2c.categories_id = '" . (int)$HTTP_GET_VARS['categories_id'] . "'";

      for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
        $where_str .= " or p2c.categories_id = '" . (int)$subcategories_array[$i] . "'";
      }

      $where_str .= ")";
    } else {
      $where_str .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$HTTP_GET_VARS['categories_id'] . "'";
    }
  }

  if (isset($HTTP_GET_VARS['manufacturers_id']) && tep_not_null($HTTP_GET_VARS['manufacturers_id'])) {
    $where_str .= " and m.manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'";
  }

  if (isset($search_keywords) && (sizeof($search_keywords) > 0)) {
    $where_str .= " and (";
    for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
      switch ($search_keywords[$i]) {
        case '(':
        case ')':
        case 'and':
        case 'or':
          $where_str .= " " . $search_keywords[$i] . " ";
          break;
        default:
          $keyword = tep_db_prepare_input($search_keywords[$i]);
          // START: Extra Fields Contribution
          // $where_str .= "(pd.products_name like '%" . tep_db_input($keyword) . "%' or p.products_model like '%" . tep_db_input($keyword) . "%' or m.manufacturers_name like '%" . tep_db_input($keyword) . "%'";
          $where_str .= "(pd.products_name like '%" . tep_db_input($keyword) . "%' or p.products_model like '%" . tep_db_input($keyword) . "%' or m.manufacturers_name like '%" . tep_db_input($keyword) . "%' or p2pef.products_extra_fields_value like '%" . tep_db_input($keyword) . "%'";
          // END: Extra Fields Contribution

          if (isset($HTTP_GET_VARS['search_in_description']) && ($HTTP_GET_VARS['search_in_description'] == '1')) $where_str .= " or pd.products_description like '%" . tep_db_input($keyword) . "%'";
          $where_str .= ')';
          break;
      }
    }
    $where_str .= " )";
  }
  
  // START: Extra Fields Contribution Search Fields 1.0
    foreach ($pef_values as $pef_id => $pef_value)
    {
      tep_parse_search_string($pef_value, $pef_value_keywords);
      if (isset($pef_value_keywords) && (sizeof($pef_value_keywords) > 0)) {
        $where_str .= " and (";
        for ($i=0, $n=sizeof($pef_value_keywords); $i<$n; $i++ ) {
          switch ($pef_value_keywords[$i]) {
            case '(':
            case ')':
            case 'and':
            case 'or':
              $where_str .= " " . $pef_value_keywords[$i] . " ";
              break;
            default:
              $keyword = tep_db_prepare_input($pef_value_keywords[$i]);
              $where_str .= "(p2pef.products_extra_fields_value like '%" . tep_db_input($keyword) . "%'";
              $where_str .= " AND p2pef.products_extra_fields_id = ". (int)$pef_id;
              $where_str .= ')';
              break;
          }
        }
        $where_str .= " )";
      }
    }
    // END: Extra Fields Contribution

  if (tep_not_null($dfrom)) {
    $where_str .= " and p.products_date_added >= '" . tep_date_raw($dfrom) . "'";
  }

  if (tep_not_null($dto)) {
    $where_str .= " and p.products_date_added <= '" . tep_date_raw($dto) . "'";
  }

  if (tep_not_null($pfrom)) {
    if ($currencies->is_set($currency)) {
      $rate = $currencies->get_value($currency);

      $pfrom = $pfrom / $rate;
    }
  }

  if (tep_not_null($pto)) {
    if (isset($rate)) {
      $pto = $pto / $rate;
    }
  }

  if (DISPLAY_PRICE_WITH_TAX == 'true') {
    if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) >= " . (double)$pfrom . ")";
    if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) <= " . (double)$pto . ")";
  } else {
    if ($pfrom > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) >= " . (double)$pfrom . ")";
    if ($pto > 0) $where_str .= " and (IF(s.status, s.specials_new_products_price, p.products_price) <= " . (double)$pto . ")";
  }

  if ( (DISPLAY_PRICE_WITH_TAX == 'true') && (tep_not_null($pfrom) || tep_not_null($pto)) ) {
    $where_str .= " group by p.products_id, tr.tax_priority";
  }

  if ( (!isset($HTTP_GET_VARS['sort'])) || (!preg_match('/^[1-8][ad]$/', $HTTP_GET_VARS['sort'])) || (substr($HTTP_GET_VARS['sort'], 0, 1) > sizeof($column_list)) ) {
    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {
      if ($column_list[$i] == 'PRODUCT_LIST_NAME') {
        $HTTP_GET_VARS['sort'] = $i+1 . 'a';
        $order_str = " order by pd.products_name";
        break;
      }
    }
  } else {
    $sort_col = substr($HTTP_GET_VARS['sort'], 0 , 1);
    $sort_order = substr($HTTP_GET_VARS['sort'], 1);

    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $order_str = " order by p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_NAME':
        $order_str = " order by pd.products_name " . ($sort_order == 'd' ? 'desc' : '');
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $order_str = " order by m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $order_str = " order by p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_IMAGE':
        $order_str = " order by pd.products_name";
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $order_str = " order by p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
      case 'PRODUCT_LIST_PRICE':
        $order_str = " order by final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;
    }
  }

  $listing_sql = $select_str . $from_str . $where_str . $order_str;
  
  // MOD: BOF - SmartSuggest BEGIN
  if (SMARTSUGGEST_ENABLED == 'true' && SMARTSUGGEST_RECORD_KEYWORDS == 'true') {
    if (isset($_GET['keywords'])) {
	  if (!isset($_GET['page'])) $_GET['page'] = '1';
	  $searched_keywords_query = tep_db_query("select searched_keywords_id, pages
                                               from " . TABLE_SEARCHED_KEYWORDS . "
                                               where ip = '" . tep_db_input(tep_get_ip_address()) . "'
                                                 and keywords = '" . tep_db_input($_GET['keywords']) . "'
                                                 and date_added > '" . date('Y-m-d H:i:s', strtotime('-30 minutes')) . "'
                                               order by date_added desc");
      if ($searched_keywords = tep_db_fetch_array($searched_keywords_query)) {
        $pages = explode(',', $searched_keywords['pages']);
        if ($_GET['page'] != $pages[count($pages) - 1]) // only update if not the last visited page
          tep_db_perform('searched_keywords', array('pages' => $searched_keywords['pages'] . ',' . (int)$_GET['page']), 'update', "searched_keywords_id = '" . (int)$searched_keywords['searched_keywords_id'] . "'");
      } else {
        $input = array('keywords' => tep_db_prepare_input(tep_db_input($_GET['keywords'])),
                       'number_of_results' => (int)tep_db_num_rows(tep_db_query($listing_sql)),
                       'date_added' => date('Y-m-d H:i:s'),
                       'ip' => tep_get_ip_address(),
                       'pages' => (int)$_GET['page']);
        if ($customer_id) $input['customers_id'] = (int)$customer_id;
        if ($cart->count_contents() > 0) {
          $products = $cart->get_products();
          foreach ($products as $product)
            $products_ids[] = $product['id'];
          $input['products_ids'] = implode(',', $products_ids);
        }
        tep_db_perform(TABLE_SEARCHED_KEYWORDS, $input);
        tep_session_register('searched_keywords_id');
        $searched_keywords_id = tep_db_insert_id();
      }
    }
  }
  // MOD: EOF - SmartSuggest BEGIN
  ?>
            </div>
              <div class="col-md-3 hidden-xs">
                <ul id="display-tab" class="nav nav-tabs tabs-right tabs-prod-list">
                  <li>
                    <a href="#grid" data-toggle="tab">
                      <span class="glyphicon glyphicon-th"></span>
                    </a>
                  </li>
                  <li class="hidden-sm">
                    <a href="#list" data-toggle="tab">
                      <span class="glyphicon glyphicon-list"></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
<?php
  require(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING);
?>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
