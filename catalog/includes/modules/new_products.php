<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {

    // BOF Enable & Disable Categories
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, ". TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
    //$new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
    // EOF Enable & Disable Categories
  } else {
    // BOF Enable & Disable Categories
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_date_added, p.products_last_modified, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, ". TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by rand() desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
    //$new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status='1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by rand() desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
    //$new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
    // BOF Enable & Disable Categories
  }
?>
<div class="row">
  <h2><?php echo sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')); ?></h2>
<?php
  $num_new_products = tep_db_num_rows($new_products_query);
        if ($num_new_products > 0) {
            $row = 0;
            while ($new_products = tep_db_fetch_array($new_products_query)) {
                $row++;
                
            if ($new_price = tep_get_products_special_price($new_products['products_id'])) {
				$products_price = '<div class="product_price_wrapper price"><b>Price:&nbsp;&nbsp;</b><del>' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span></div>';
				$persent = ($currencies->display_sale_percent($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']), $new_price) * -1);
				$sale_percent = '<div class="sale_percent"><strong>'.$persent.'%</strong></div>';
            } else {
				$products_price = '<div class="product_price_wrapper price"><b>Price:&nbsp;&nbsp;</b><span class="productSpecialPrice">' .$currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])).'</span></div>';
                $sale_percent = '';
            }   
        ?>
        
      <div class="col-md-4 col-sm-6">
        <div class="panel panel-default categories">
          <div class="panel-body">
            <div class="product_block equal-height_new_products_block">
              <div style="">
                <div class="product_pic_wrapper">
                <?php echo $sale_percent;?>
                  <a class="product_img" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']); ?>">
                    <img src="<?php echo DIR_WS_IMAGES . $new_products['products_image'].'" title="'. $new_products['products_name']; ?>" class="img-responsive">
                  </a>
                </div>
                <div class="product_info_wrapper">
                  <div class="row_01">
                    <h4>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']); ?>"><?php echo $new_products['products_name']; ?></a>
                    </h4>
                  </div>
                  <div class="row_02">
                    <div class="cl_both block">
                      <?php echo $products_price;?>
                    </div>
                    <div class="product_button_wrapper">
                    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
                     <?php echo tep_draw_hidden_field('products_id', $new_products['products_id']); ?>
                      <button class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                      </button>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']); ?>" class="btn btn-default btn-sm new-button-details">Details</a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        if ((($row / 3) == floor($row / 3))) {
      ?>
    </div>
    <div class="row">
    <?php
        }
        }
        }
    ?>
    </div>