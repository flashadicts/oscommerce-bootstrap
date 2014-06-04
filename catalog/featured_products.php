<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_FEATURED_PRODUCTS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_FEATURED_PRODUCTS));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
  <div class="contentText">

<?php
	$featured_products_array = array();
	$featured_products_query_raw = "select p.products_id, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, p.products_date_added, m.manufacturers_name
   from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id
   left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "'
   left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
   left join " . TABLE_FEATURED . " f on p.products_id = f.products_id
   where p.products_status = '1' and f.status = '1' order by p.products_date_added DESC, pd.products_name";
   $featured_products_split = new splitPageResults($featured_products_query_raw, MAX_DISPLAY_FEATURED_PRODUCTS);
	if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
	?>

    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

      <span><?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_FEATURED_PRODUCTS); ?></span>
    </div>

    <br />

	<?php
	  }
	?>

<?php
  if ($featured_products_split->number_of_rows > 0) {
?>

    <table border="0" width="100%" cellspacing="2" cellpadding="2">

<?php
    $featured_query = tep_db_query($featured_products_split->sql_query);
    while ($featured = tep_db_fetch_array($featured_query)) {
      if ($new_price = tep_get_products_special_price($featured['products_id'])) {
        $products_price = '<del>' . $currencies->display_price($featured['products_price'], tep_get_tax_rate($featured['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($featured['products_tax_class_id'])) . '</span>';
      } else {
        $products_price = $currencies->display_price($featured['products_price'], tep_get_tax_rate($featured['products_tax_class_id']));
      }
?>
      <tr>
        <td width="<?php echo SMALL_IMAGE_WIDTH + 10; ?>" valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $featured['products_image'], $featured['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>'; ?></td>
        <td valign="top" class="main"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured['products_id']) . '"><strong><u>' . $featured['products_name'] . '</u></strong></a><br />' . TEXT_DATE_ADDED . ' ' . tep_date_long($featured['products_date_added']) . '<br />' . TEXT_MANUFACTURER . ' ' . $featured['manufacturers_name'] . '<br /><br />' . TEXT_PRICE . ' ' . $products_price; ?></td>
        <td align="right" valign="middle" class="smallText"><?php echo tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $featured['products_id'])); ?></td>
      </tr>
<?php
    }
?>

    </table>

<?php
  } else {
?>

    <div>
      <?php echo TEXT_NO_NEW_PRODUCTS; ?>
    </div>

<?php
  }

  if (($featured_products_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

    <br />

    <div>
      <span style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $featured_products_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>

      <span><?php echo $featured_products_split->display_count(TEXT_DISPLAY_NUMBER_OF_FEATURED_PRODUCTS); ?></span>
    </div>

<?php
  }
?>

  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
