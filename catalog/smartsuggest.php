<?php
/*
  $Id: smart_search.php 1739 2013-10-03 00:52:16Z fur $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

//Send some headers to keep the user's browser from caching the response.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
header("Cache-Control: no-cache, must-revalidate" ); 
header("Pragma: no-cache" );
header("Content-Type: text/plain; charset=utf-8");

//Get our database abstraction file
require('includes/application_top.php');

///Make sure that a value was sent.
if (SIMPLESUGGEST_ACTIVE != 'false' && (isset($_GET['keywords']) && $_GET['keywords'] != '')) {
  
  $keywords = $_GET['keywords'];
    
  if (tep_not_null($keywords)) {
    if (!tep_parse_search_string($keywords, $search_keywords))
      exit();
  }
  
  if (SMARTSUGGEST_RESULT == 'Product Names') {
    $where_str = "p.products_status = '1' and pd.language_id = '" . (int)$languages_id . "'";
  } else {
    $where_str = "1";
  }	
  
  if (isset($search_keywords) && (sizeof($search_keywords) > 0)) {
    $where_str .= " and (";
	$replace_str = "keywords";
    for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
      switch ($search_keywords[$i]) {
      case '(':
      case ')':
      case 'and':
      case 'or':
        $where_str .= " " . $search_keywords[$i] . " ";
        break;
      default:
        if (SMARTSUGGEST_RESULT == 'Product Names') {
          $where_str .= "pd.products_name like '%" . tep_db_input($search_keywords[$i]) . "%'";
		} else {
		  $where_str .= "keywords LIKE '%". tep_db_input($search_keywords[$i]) . "%'";
		}
        break;
      }
    }
    $where_str .= ")";
  }

  //Get every page title for the site.
  if (SMARTSUGGEST_RESULT == 'Product Names') {
    if (SMARTSUGGEST_PRODUCTS_SORT == 'Product Names') {
      $suggest_query = tep_db_query("SELECT p.products_image as image, pd.products_name as result
                                     FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd USING(products_id)
                                     WHERE $where_str
                                     ORDER BY pd.products_name
                                     LIMIT " . SMARTSUGGEST_LIMIT);
    } else {
      $suggest_query = tep_db_query("SELECT p.products_image as image, pd.products_name as result, k.keywords, count(*) as count_searched, count(orders_id IS NOT NULL) as count_ordered
                                     FROM " . TABLE_PRODUCTS . " p LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd USING(products_id) LEFT JOIN " . TABLE_MANUFACTURERS . " m USING(manufacturers_id) LEFT JOIN " . TABLE_SEARCHED_KEYWORDS . " k ON pd.products_name = k.keywords
                                     WHERE $where_str
                                     GROUP BY result
                                     ORDER BY k.keywords IS NULL, count_searched DESC, count_ordered, pd.products_name
                                     LIMIT " . SMARTSUGGEST_LIMIT);
    }
  } else {
    $suggest_query = tep_db_query("SELECT keywords as result, count(*) as count_searched, count(orders_id IS NOT NULL) as count_ordered
                                   FROM " . TABLE_SEARCHED_KEYWORDS . " 
                                   WHERE $where_str
                                     AND number_of_results > 0
                                   GROUP BY keywords 
                                   ORDER BY count_searched DESC, count_ordered
                                   LIMIT " . SMARTSUGGEST_LIMIT);
  }

  while($suggest = tep_db_fetch_array($suggest_query)) {
    //Return each product name seperated by a newline.
    $display_name = htmlentities($suggest['result']);
    $display_image = htmlentities($suggest['image']);
    if(SMARTSUGGEST_MARK_SEARCH_CHAR != 'false'){
      for ($i=0, $n=sizeof($search_keywords); $i<$n; $i++ ) {
        
        switch ($search_keywords[$i]) {
          case '(':
          case ')':
          case 'and':
          case 'or':
            break;
          default:
            $keyword_no_stroke = str_replace('-', '', $search_keywords[$i]);
            if($keyword_no_stroke == 'b') break;
            
            if(($pos = stripos($display_name, $keyword_no_stroke)) !== FALSE) {
              $search_string = substr($display_name, $pos, strlen($keyword_no_stroke));
              $display_name = str_ireplace($search_string, '<b>' . $search_string . '</b>', $display_name);
            }
            
            if(($display_name_no_stroke = str_replace('-', '', $display_name)) != $display_name && ($pos = stripos($display_name_no_stroke, $keyword_no_stroke)) !== FALSE) {
              $match_patten = '';
              for($j = 0, $n = strlen($keyword_no_stroke); $j < $n; $j++){
                if($j) $match_patten .= '[-]*';
                $match_patten .= $keyword_no_stroke[$j];
              }
              preg_match('/' . $match_patten . '/i', $display_name, $matches);
              if(strcmp($matches[0], str_replace('-', '', $matches[0])) != 0) // avoid strong again
                $display_name = str_ireplace($matches[0], '<b>' . $matches[0] . '</b>', $display_name);
            }
            break;
        }
      }
    }
    echo $display_name . "\n";
    //echo "<img src=\"" . DIR_WS_IMAGES ."". $display_image ."\" height=\"64px\"  />  ".$display_name . "\n";
  }
}
?>