<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_CATALOG,
    'apps' => array(
      array(
        'code' => FILENAME_CATEGORIES,
        'title' => BOX_CATALOG_CATEGORIES_PRODUCTS,
        'link' => tep_href_link(FILENAME_CATEGORIES)
      ),
      array(
        'code' => FILENAME_PRODUCTS_ATTRIBUTES,
        'title' => BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES,
        'link' => tep_href_link(FILENAME_PRODUCTS_ATTRIBUTES)
      ),
      array(
        'code' => FILENAME_MANUFACTURERS,
        'title' => BOX_CATALOG_MANUFACTURERS,
        'link' => tep_href_link(FILENAME_MANUFACTURERS)
      ),
      array(
        'code' => FILENAME_SLIDESHOW,
        'title' => BOX_CATALOG_SLIDESHOW,
        'link' => tep_href_link(FILENAME_SLIDESHOW)
      ),
      array(
        'code' => FILENAME_REVIEWS,
        'title' => BOX_CATALOG_REVIEWS,
        'link' => tep_href_link(FILENAME_REVIEWS)
      ),
      array(
        'code' => FILENAME_SPECIALS,
        'title' => BOX_CATALOG_SPECIALS,
        'link' => tep_href_link(FILENAME_SPECIALS)
      ),
      // BOF: Featured Products
        array(
        'code' => FILENAME_FEATURED,
        'title' => BOX_CATALOG_FEATURED_PRODUCTS,
        'link' => tep_href_link(FILENAME_FEATURED)
      ),
      // EOF: Featured Products
      // BOF Product Extra Fields
      array(
        'code' => FILENAME_PRODUCTS_EXTRA_FIELDS,
        'title' => BOX_CATALOG_PRODUCTS_EXTRA_FIELDS,
        'link' => tep_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS)
      ),
      // EOF Product Extra Fields  
      array(
        'code' => FILENAME_PRODUCTS_EXPECTED,
        'title' => BOX_CATALOG_PRODUCTS_EXPECTED,
        'link' => tep_href_link(FILENAME_PRODUCTS_EXPECTED)
      )
    )
  );
?>
