<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
?>
<!-- main tab - start -->
<ul id="main-tab" class="nav nav-tabs">
    <li class="active"><a href="#categories" data-toggle="tab">Categories</a></li>
    <li><a href="#new" data-toggle="tab">New</a></li>
    <li><a href="#featured" data-toggle="tab">Featured</a></li>
    <li><a href="#popular" data-toggle="tab">Popular</a></li>
    <li><a href="#specials" data-toggle="tab">Specials</a></li>
</ul>

<div class="tab-content front-tab-content">
  <div class="tab-pane active" id="categories">
    <div class="row">
      <?php
        $categories_query = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id, c.categories_image from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '0' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$languages_id ."' and c.categories_status = '1' order by sort_order, cd.categories_name limit " . MAX_DISPLAY_TAB_CATEGORIES);
        $row = 0;
        while ($categories = tep_db_fetch_array($categories_query)) {
            $row++;
            
      ?>
      <div class="col-md-4 col-sm-6">
        <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$categories['categories_id']); ?>">
        <div class="panel panel-default categories">
          <div class="panel-heading"><?php echo $categories['categories_name']; ?></div>
          <div class="panel-body">
            <img src="images/<?php echo $categories['categories_image']; ?>" title="<?php echo $categories['categories_name']; ?>" alt="<?php echo $categories['categories_name']; ?>" class="img-responsive">
          </div>
        </div>
        </a>
      </div>
      <?php
        if ((($row / 3) == floor($row / 3))) {
      ?>
    </div>
    <div class="row">
    <?php
        }
        }
    ?>
    </div>
  </div>
  <!-- start new tab -->
  <div class="tab-pane" id="new">
    <div class="row">
        <?php
		$new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, p.products_date_added, p.products_last_modified, s.specials_new_products_price, p.products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, ". TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status= '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
	    
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
  </div>
  <div class="tab-pane" id="featured">
    <div class="row">
    <?php
    $query = 'SELECT p.products_id, p.products_image, p.products_tax_class_id, IF (s.status, s.specials_new_products_price, NULL) AS specials_new_products_price, p.products_price, pd.products_name FROM ' . TABLE_PRODUCTS . ' p LEFT JOIN ' . TABLE_SPECIALS . ' s ON p.products_id = s.products_id LEFT JOIN ' . TABLE_PRODUCTS_DESCRIPTION . " pd ON p.products_id = pd.products_id AND pd.language_id = '" . $languages_id . "' LEFT JOIN " . TABLE_FEATURED . " f ON p.products_id = f.products_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where c.categories_status= '1' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id AND p.products_status = '1' AND f.status = '1' order by rand($mtm) DESC limit " . MAX_DISPLAY_FEATURED_PRODUCTS;
    
    $featured_products_query = tep_db_query( $query );
    $num_featured_products = tep_db_num_rows($featured_products_query);
    if ($num_featured_products > 0) {
    $row = 0;

        while ($featured_products = tep_db_fetch_array($featured_products_query)) {
            $row++;
            
            if ($new_price = tep_get_products_special_price($featured_products['products_id'])) {
				$products_price = '<div class="product_price_wrapper price"><b>Price:&nbsp;&nbsp;</b><del>' . $currencies->display_price($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($featured_products['products_tax_class_id'])) . '</span></div>';
				$persent = ($currencies->display_sale_percent($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id']), $new_price) * -1);
				$sale_percent = '<div class="sale_percent"><strong>'.$persent.'%</strong></div>';
            } else {
				$products_price = '<div class="product_price_wrapper price"><b>Price:&nbsp;&nbsp;</b><span class="productSpecialPrice">' .$currencies->display_price($featured_products['products_price'], tep_get_tax_rate($featured_products['products_tax_class_id'])).'</span></div>';
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
                  <a class="product_img" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']); ?>">
                    <img src="<?php echo DIR_WS_IMAGES . $featured_products['products_image'].'" title="'. $featured_products['products_name']; ?>" class="img-responsive">
                  </a>
                </div>
                <div class="product_info_wrapper">
                  <div class="row_01">
                    <h4>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']); ?>"><?php echo $featured_products['products_name']; ?></a>
                    </h4>
                  </div>
                  <div class="row_02">
                    <div class="cl_both block">
                      <?php echo $products_price;?>
                    </div>
                    <div class="product_button_wrapper">
                    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
                     <?php echo tep_draw_hidden_field('products_id', $featured_products['products_id']); ?>
                      <button class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                      </button>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $featured_products['products_id']); ?>" class="btn btn-default btn-sm new-button-details">Details</a>
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
  </div>
  <div class="tab-pane" id="popular">
    <div class="row">
    <?php
    if (isset($current_category_id) && ($current_category_id > 0)) {
        $query = "select distinct p.products_id, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name, p.products_date_added, p.products_last_modified, s.specials_new_products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and '" . (int)$current_category_id . "' in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit " . MAX_DISPLAY_BESTSELLERS;
    } else {
        $query = "select distinct p.products_id, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name, p.products_date_added, p.products_last_modified, s.specials_new_products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' ".$order_by." limit " . MAX_DISPLAY_BESTSELLERS;
    }
    $best_sellers_query = tep_db_query($query);
    $num_best_sellers = tep_db_num_rows($best_sellers_query);
    if ($num_best_sellers > 0) {
    $row = 0;
        while ($best_sellers = tep_db_fetch_array($best_sellers_query)) {
            $row++;
    ?>
      <div class="col-md-4 col-sm-6">
        <div class="panel panel-default categories">
          <div class="panel-body">
            <div class="product_block equal-height_new_products_block">
              <div style="">
                <div class="product_pic_wrapper">
                <?php echo $sale_percent;?>
                  <a class="product_img" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']); ?>">
                    <img src="<?php echo DIR_WS_IMAGES . $best_sellers['products_image'].'" title="'. $best_sellers['products_name']; ?>" class="img-responsive">
                  </a>
                </div>
                <div class="product_info_wrapper">
                  <div class="row_01">
                    <h4>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']); ?>"><?php echo $best_sellers['products_name']; ?></a>
                    </h4>
                  </div>
                  <div class="row_02">
                    <div class="cl_both block">
                      <?php echo $products_price;?>
                    </div>
                    <div class="product_button_wrapper">
                    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
                     <?php echo tep_draw_hidden_field('products_id', $best_sellers['products_id']); ?>
                      <button class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                      </button>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_sellers['products_id']); ?>" class="btn btn-default btn-sm new-button-details">Details</a>
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
  </div>
  <div class="tab-pane" id="specials">
    <div class="row">
    <?php
    $specials_query_raw = "select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by RAND()";
    
    $specials_query = tep_db_query($specials_query_raw);
    $num_specials = tep_db_num_rows($specials_query);
    if ($num_specials > 0) {
    $row = 0;
        while ($specials = tep_db_fetch_array($specials_query)) {
            $row++;
            $new_price = tep_get_products_special_price($specials['products_id']);
            $products_price = '<div class="product_price_wrapper price"><b>Price:&nbsp;&nbsp;</b><del>' . $currencies->display_price($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id'])) . '</del> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($specials['products_tax_class_id'])) . '</span></div>';
            $persent = ($currencies->display_sale_percent($specials['products_price'], tep_get_tax_rate($specials['products_tax_class_id']), $new_price) * -1);
            $sale_percent = '<div class="sale_percent"><strong>'.$persent.'%</strong></div>';
    ?>
      <div class="col-md-4 col-sm-6">
        <div class="panel panel-default categories">
          <div class="panel-body">
            <div class="product_block equal-height_new_products_block">
              <div style="">
                <div class="product_pic_wrapper">
                <?php echo $sale_percent;?>
                  <a class="product_img" href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']); ?>">
                    <img src="<?php echo DIR_WS_IMAGES . $specials['products_image'].'" title="'. $specials['products_name']; ?>" class="img-responsive">
                  </a>
                </div>
                <div class="product_info_wrapper">
                  <div class="row_01">
                    <h4>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']); ?>"><?php echo $specials['products_name']; ?></a>
                    </h4>
                  </div>
                  <div class="row_02">
                    <div class="cl_both block">
                      <?php echo $products_price;?>
                    </div>
                    <div class="product_button_wrapper">
                    <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>
                     <?php echo tep_draw_hidden_field('products_id', $specials['products_id']); ?>
                      <button class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-shopping-cart"></span>
                      </button>
                      <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $specials['products_id']); ?>" class="btn btn-default btn-sm new-button-details">Details</a>
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
  </div>
</div>