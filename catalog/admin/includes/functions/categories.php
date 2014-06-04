<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  //added by Kevin L. Shelton
  function tep_build_category_info_array($lid = '') {
    global $languages_id;
    if ($lid == '') $lid = $languages_id;
    if(!function_exists('bci_get_paths')){ 
        function bci_get_paths($lid, $categories_array = '', $parent_id = 0, $level = 0, $path='') {
          if (!is_array($categories_array)) $categories_array = array();
          $categories_query = tep_db_query("select * from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where parent_id = " . (int)$parent_id . " and c.categories_id = cd.categories_id and cd.language_id = " . (int)$lid . " order by sort_order, cd.categories_name");
          while ($categories = tep_db_fetch_array($categories_query)) {
            if (SHOW_COUNTS == 'true') {
              $count_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = p2c.products_id and p.products_status = 1 and p2c.categories_id = " . (int)$categories['categories_id']);
              $products = tep_db_fetch_array($count_query);
              $count = $products['total'];
            } else {
              $count = 0;
            }
              $categories_array[$categories['categories_id']] = array('name' => $categories['categories_name'],
                                      'path' => $path . $categories['categories_id'],
                                      'id' => $categories['categories_id'],
                                      'hidden' => (($categories['status_categ'] != 1) || ($categories_array[$parent_id]['hidden'] === true)),
                                      'indent' => str_repeat('&nbsp;&nbsp;', $level),
                                      'level' => $level,
                                      'has_subcat' => false,
                                      'prod_count' => $count,
                                      'parent' => $parent_id,
                                      'direct_children' => array(),
                                      'all_children' => array(),
                                      'with_children' => array($categories['categories_id']));
            $categories_array[$parent_id]['has_subcat'] = true;
            $categories_array[$parent_id]['direct_children'][] = $categories['categories_id'];
            if ($categories['categories_id'] != $parent_id) {
              $categories_array = bci_get_paths($lid, $categories_array, $categories['categories_id'], $level + 1, $path . $categories['categories_id'] . '_');
            }
          }
          return $categories_array;
        }
    } // end bci_get_paths

    $cat_array = bci_get_paths($lid);
    unset($cat_array[0]);
    foreach ($cat_array as $cat) {
      $parent = $cat['parent'];
      while ($parent > 0) {
        // add category product count to parent category product counts
        if (!$cat['hidden'] || (HIDE_HIDDEN_CAT_PRODS != 'true')) $cat_array[$parent]['prod_count'] += $cat['prod_count'];
        // build all_children and with_children arrays
        $cat_array[$parent]['all_children'][] = $cat['id'];
        $cat_array[$parent]['with_children'][] = $cat['id'];
        $parent = $cat_array[$parent]['parent'];
      }
    }
    return $cat_array;
  } // end tep_build_category_info_array
  
// this version of tep_get_subcategories uses cache when available
  function get_subcategories($subcategories_array, $parent_id = 0) {
    global $category_info_array;
    if (!is_array($subcategories_array)) $subcategories_array = array();
    if (!isset($category_info_array) || !is_array($category_info_array)) $category_info_array = tep_build_category_info_array();
    if ($parent_id > 0) return array_merge($subcategories_array, $category_info_array[$parent_id]['all_children']);
    $cats = array();
    foreach ($category_info_array as $c) $cats[] = $c['id'];
    return array_merge($subcategories_array, $cats);
  }


  function build_hidden_category_array() {
    global $category_info_array;
    if (!isset($category_info_array) || !is_array($category_info_array)) $category_info_array = tep_build_category_info_array();
    $hidden = array();
    foreach ($category_info_array as $c) {
     if ($c['hidden']) $hidden[] = $c['id'];
    }
    return array_unique($hidden);
  }
  
  /* pass something like array(array('id' => '', 'text' => PULL_DOWN_DEFAULT)) for the first
  argument if you want to list something besides just the categories in the pull down
  pass false for the second argument to have the pull down return the category id
  pass true for the second argument to have the pull down return the category path
  pass true for the third argument to include the category product count in the pull down text if
  category product counts are set to be displayed
  pass false for the third argument to force no count displayed regardless of config setting
  pass true for the last argument to include hidden categories in the pull down
  pass false for the last argument to only include categories visible in the catalog  */ 
  function build_category_pull_down_from_cache($category_array = '', $use_path = false, $include_counts = false, $include_hidden = false) {
    global $category_info_array;
    // category_info_array is normally loaded in the cache but create it if not already set
    if (!isset($category_info_array) || !is_array($category_info_array)) $category_info_array = tep_build_category_info_array();
    if (!is_array($category_array)) $category_array = array();
    foreach ($category_info_array as $cid => $cat) {
      if ($include_hidden || !$cat['hidden']) {
        if ($use_path) {
          $id = $cat['path'];
        } else {
          $id = $cat['id'];
        }
        if ($include_counts && (SHOW_COUNTS == 'true')) {
          $count = ' (' . $cat['prod_count'] . ')';
        } else {
          $count = '';
        }
        $category_array[] = array('id' => $id, 'text' => $cat['indent'] . $cat['name'] . $count);
      }
    }
    return $category_array;
  }

function write_category_cache_file() {
  global $languages_id;
  $cache_dir = rtrim(DIR_FS_CACHE, '/');
  if (!is_dir($cache_dir)) {
    if (!mkdir($cache_dir, 0755)) return false;
  }
  if (!tep_is_writable($cache_dir)) return false;
  $cache_file = DIR_FS_CACHE . FILENAME_CATEGORY_CACHE;
  $cache_output = "<?php\n" . "$" . "complete_category_info = array (\n";
  $query = tep_db_query('select languages_id from ' . TABLE_LANGUAGES);
  $ca = array();
  $lidcnt = 0;
  while ($lid = tep_db_fetch_array($query)) {
    $ca[$lid['languages_id']] = tep_build_category_info_array($lid['languages_id']);
    $lidcnt++;
  }
  $cnt = 0;
  foreach ($ca as $lid => $cat_array) {
    $cnt++;
    $cache_output .= '  ' . $lid . " => array(\n";
    $text = array();
    foreach ($cat_array as $id => $cat) {
      $subtext = array();
      foreach ($cat as $key => $value) {
        if (is_bool($value)) {
          $subtext[] = "'" . $key . "' => " . ($value ? 'true' : 'false');
        } elseif (is_array($value)) {
          $subtext[] = "'" . $key . "' => array(" . addslashes(implode(', ', $value)) . ")";
        } else {
          $subtext[] = "'" . $key . "' => '" . addslashes($value) . "'";
        }
      }
      $text[] = '    ' . $id . ' => array(' . implode(', ', $subtext) . ')';
    }
    $cache_output .= implode(",\n", $text) . "\n";
    $cache_output .= '  )' . (($cnt == $lidcnt) ? '' : ',') . "\n";
  }
  $cache_output .= ");\n";
  $cache_output .= "$" . "category_info_array =& " . "$" . "complete_category_info[" . "$" . "languages_id];\n";
  if (HIDE_HIDDEN_CAT_PRODS == 'true') {
    $h = build_hidden_category_array();
  } else {
    $h = array();
  }
  $cache_output .= "$" . 'hiddencats = array(' . implode(", ", $h) . ");\n";
  $cache_output .= "return 'Category Cache Success';\n";
  $cache_output .= '?>';
  if (file_exists($cache_file))
    @unlink($cache_file);
  $fp = fopen($cache_file, 'w');
  if ($fp === false) return false;
  $fout = fwrite($fp, $cache_output);
  fclose($fp);
  return ($fout == strlen($cache_output));
}
?>