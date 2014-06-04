<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require("includes/application_top.php");

  if ($cart->count_contents() > 0) {
    include(DIR_WS_CLASSES . 'payment.php');
    $payment_modules = new payment;
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOPPING_CART);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHOPPING_CART));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

  <div class="row">
	<div class="col-md-9">
      <h1><?php echo HEADING_TITLE; ?></h1>

<?php
  if ($cart->count_contents() > 0) {
?>

<?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_SHOPPING_CART, 'action=update_product')); ?>

      <h2><?php echo TABLE_HEADING_PRODUCTS; ?></h2>
        


<?php
    $any_out_of_stock = 0;
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . (int)$products[$i]['id'] . "'
                                       and pa.options_id = '" . (int)$option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . (int)$value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . (int)$languages_id . "'
                                       and poval.language_id = '" . (int)$languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }
?>


<?php

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
?>
    <div class="row product-block">
      <div class="col-md-2 product-image">
        <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']);?>"><?php echo tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], NULL,SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?> </a>
      </div>
      
      <div class="col-md-5 product-details">
        <h4><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']);?>"><?php echo $products[$i]['name'];?></a></h4>
          <ul class="list-unstyled">
            <li><strong>Advantage Id:</strong> <?php echo $products[$i]['id']; ?></li>
            <li><strong>Model:</strong> <?php echo $products[$i]['model']; ?></li>
          </ul>
      <?php

      if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], $products[$i]['quantity']);
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          echo $stock_check;
        }
      }

      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo '<br /><small><i> - ' . $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'] . '</i></small>';
        }
      }
      ?>
      </div>
      
      <div class="col-md-3 product-details">
      <div class="input-group">
        <?php echo tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="4" class="form-control quantity"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']);?>
        <span class="input-group-btn">
            <?php echo tep_draw_button('<span class="glyphicon glyphicon-refresh"></span>', 'refresh',  null,'primary', null, 'btn btn-default btn-lg');?>
        </span>
      </div><!-- /input-group -->
      <a href="<?php echo tep_href_link(FILENAME_SHOPPING_CART, 'products_id=' . $products[$i]['id'] . '&action=remove_product');?>"><?php echo TEXT_REMOVE;?> </a>
      </div>

      <div class="col-md-2 product-details">
        <h4><?php echo $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);?></h4>
      </div>
    </div>
<?php
    }
?>
</form>
    <div class="row">
      <div class="col-lg-3"> 
        <?php echo tep_draw_form('checkout_shipping', tep_href_link(FILENAME_CHECKOUT_SHIPPING)); ?>
            <?php echo tep_draw_button('<span class="glyphicon glyphicon-ok"></span> '.IMAGE_BUTTON_CHECKOUT, '', null,'primary',null, 'btn btn-default btn-lg');?>
        </form>
      </div>
      <div class="col-lg-5">
      </div>
      <div class="col-lg-4"> 
        <p align="right"><strong><?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $currencies->format($cart->show_total()); ?> (excl GST)</strong></p>
      </div>
    </div>
      

<?php
    if ($any_out_of_stock == 1) {
      if (STOCK_ALLOW_CHECKOUT == 'true') {
?>

    <p class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></p>

<?php
      } else {
?>

    <p class="stockWarning" align="center"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></p>

<?php
      }
    }
?>

<?php
    $initialize_checkout_methods = $payment_modules->checkout_initialization_method();

    if (!empty($initialize_checkout_methods)) {
?>

  <p align="right" style="clear: both; padding: 15px 50px 0 0;"><?php echo TEXT_ALTERNATIVE_CHECKOUT_METHODS; ?></p>

<?php
      reset($initialize_checkout_methods);
      while (list(, $value) = each($initialize_checkout_methods)) {
?>

  <p align="right"><?php echo $value; ?></p>

<?php
      }
    }
?>





<?php
  } else {
?>


    <?php echo TEXT_CART_EMPTY; ?>

    <p align="right"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></p>

<?php
  }
?>
      </div>
<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
