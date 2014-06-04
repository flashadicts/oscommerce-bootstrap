<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  if (!isset($HTTP_GET_VARS['products_id'])) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

  // BOF Enable & Disable Categories
  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p.products_id = p2c.products_id left join " . TABLE_CATEGORIES . " c on p2c.categories_id = c.categories_id, " . TABLE_PRODUCTS_DESCRIPTION . "  pd where c.categories_status = '1' and p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  //$product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  // EOF Enable & Disable Categories

  $product_check = tep_db_fetch_array($product_check_query);

  require(DIR_WS_INCLUDES . 'template_top.php');

  if ($product_check['total'] < 1) {
?>

<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_PRODUCT_NOT_FOUND; ?>
  </div>

  <div style="float: right;">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
  </div>
</div>

<?php
  } else {
    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_specification, p.products_model, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);

    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");

    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price = 'Price: <span class="price">' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span><h1 class="special-price">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</h1>';
    } else {
      $products_price = '<h1 class="special-price">'.$currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])).'</h1>';
    }

    if (tep_not_null($product_info['products_model'])) {
      $products_name = $product_info['products_name'] . '<br /><span class="smallText">[' . $product_info['products_model'] . ']</span>';
    } else {
      $products_name = $product_info['products_name'];
    }
?>

      <div class="row">
		<div class="col-md-9">
          <h2><?php echo $product_info['products_name']; ?></h2>
          <section id="product-info">
            <div class="row">
              <div class="col-md-4">
                <div class="main-image">
                  <?php echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '" data-imagelightbox="f">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], $product_info['products_name'], 'img-responsive', PROD_INFO_IMAGE_WIDTH, PROD_INFO_IMAGE_HEIGHT, '') . '</a>'; ?>
                  
                </div>
              </div>
              <div class="col-md-8">
                <div class="col-md-8">
                  <ul class="list-unstyled">
                    <li><strong>Advantage Id:</strong> <?php echo $product_info['products_id']; ?></li>
                    <li><strong>Model:</strong> <?php echo $product_info['products_model']; ?></li>
                    <?php
                        // START: Extra Fields Contribution v2.0b - mintpeel display fix	  
                        $extra_fields_query = tep_db_query("SELECT pef.products_extra_fields_order, pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef LEFT JOIN ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf ON ptf.products_extra_fields_id=pef.products_extra_fields_id WHERE ptf.products_id=". (int)$HTTP_GET_VARS['products_id'] ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".(int)$languages_id."') and pef.products_extra_fields_order != '99' ORDER BY pef.products_extra_fields_order");
                        while ($extra_fields = tep_db_fetch_array($extra_fields_query)) {
                          if (! $extra_fields['status'])  // show only enabled extra field
                            continue;
                            echo'<li><strong>'.$extra_fields['name'].':</strong> ' . stripslashes($extra_fields['value']).'</li>';
                          }
                        // END: Extra Fields Contribution - mintpeel display fix
                    ?>
                    <?php
                        if($product_info['quantity'] > 0){
                    ?>
                    <li><strong>Availability:</strong> 1-3 days</li>
                    <?php
                        }else{
                    ?>
                    <li><strong>Availability:</strong> Please call</li>
                    <?php
                    }
                    ?>
                  </ul>
                  <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'), 'post', 'class="form-inline"'); ?>
                  <div class="form-group">
                    <label for="quantity">QTY: </label>
                    <select id="quantity" name="cart_quantity" class="form-control qty-selector">
                      <?php
                      for($i=1;$i<=15;$i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                      ?>
                    </select>
                  </div>
                    <?php
                    //$reviews_query = tep_db_query("select count(*) as count from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and reviews_status = 1");
                    //$reviews = tep_db_fetch_array($reviews_query);
                    ?>
                    
                  <?php echo tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button('<span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart', 'cart',  null,'primary', null, 'btn btn-default btn-lg'); ?>
                  <?php //echo tep_draw_button(IMAGE_BUTTON_REVIEWS . (($reviews['count'] > 0) ? ' (' . //$reviews['count'] . ')' : ''), 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params())); ?>
                  </form>
                </div>
                <div class="col-md-4">
                  <div class="pricing-info">
                    <?php echo $products_price; ?>
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <?php
                          if(DISPLAY_PRICE_WITH_TAX === 'true') { 
                            echo '<input type="checkbox" checked="checked" onclick=\'window.location.assign("' . tep_href_link(FILENAME_DEFAULT, 'action=toggle_tax&display_tax=false&uri='. urlencode($_SERVER['REQUEST_URI'])) . '")\'>';
                          }else{
                            echo '<input type="checkbox" onclick=\'window.location.assign("' . tep_href_link(FILENAME_DEFAULT, 'action=toggle_tax&display_tax=true&uri='. urlencode($_SERVER['REQUEST_URI'])) . '")\'>';
                            }
                            ?>GST inclusive
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
                    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
                    $products_attributes = tep_db_fetch_array($products_attributes_query);
                    if ($products_attributes['total'] > 0) {
                ?>

                    <p><?php echo TEXT_PRODUCT_OPTIONS; ?></p>

                    <p>
                <?php
                      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
                      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
                        $products_options_array = array();
                        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
                        while ($products_options = tep_db_fetch_array($products_options_query)) {
                          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
                          if ($products_options['options_values_price'] != '0') {
                            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
                          }
                        }

                        if (is_string($HTTP_GET_VARS['products_id']) && isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
                          $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
                        } else {
                          $selected_attribute = false;
                        }
                ?>
                      <strong><?php echo $products_options_name['products_options_name'] . ':'; ?></strong><br /><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?><br />
                <?php
                      }
                ?>
                    </p>

                <?php
                    }
                ?>

                    <div style="clear: both;"></div>

                <?php
                    if ($product_info['products_date_available'] > date('Y-m-d H:i:s')) {
                ?>

                    <p style="text-align: center;"><?php echo sprintf(TEXT_DATE_AVAILABLE, tep_date_long($product_info['products_date_available'])); ?></p>

                <?php
                    }
                ?>


                <?php
                    
                ?>

                <?php
                    if ((USE_CACHE == 'true') && empty($SID)) {
                      echo tep_cache_also_purchased(3600);
                    } else {
                      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
                    }
                ?>  
            </div>   
          </section>
          <section id="product-details">
            <ul id="pinfo-tab" class="nav nav-tabs">
              <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
              <li><a href="#specifications" data-toggle="tab">Specifications</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="details">
                <p><?php echo stripslashes($product_info['products_description']); ?></p>
              </div>
              <div class="tab-pane fade" id="specifications">
                <p><?php echo stripslashes($product_info['products_specification']); ?></p>
              </div>
            </div>
            
          </section>
          
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
            <p></p>
              <div class="service-info-block">
                <p>Although we try to make sure that all information displayed on our products is correct sometimes there maybe mistakes. For up to date info please <a title="Contact Us" href="http://www.advantage.co.nz/contact-us/">contact us</a> check the manufacturers website.</p>
              </div>
              <p></p>
            </div>
          </div>
<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
