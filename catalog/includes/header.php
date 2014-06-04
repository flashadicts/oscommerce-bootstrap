<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size('header') > 0) {
    echo '<div class="grid_24">' . $messageStack->output('header') . '</div>';
  }
?>

<!-- Navbar
	================================================== -->
	  <nav id="top-nav">
		<div class="row">
		  <div class="col-lg-12">
			<div class="bs-example">
			  <nav class="navbar navbar-top" role="navigation">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle navbar-toggle-inverse" data-toggle="collapse" data-target=".top-nav">
					<span class="icon-bar icon-bar-inverse"></span>
					<span class="icon-bar icon-bar-inverse"></span>
					<span class="icon-bar icon-bar-inverse"></span>
				  </button>
				</div>
				<div class="navbar-collapse collapse navbar-responsive-collapse top-nav">
				  <ul class="nav navbar-nav nav-top">
					<li><?php echo '<a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . HEADER_TITLE_SPECIALS . '</a>'; ?></li>
					<li><?php echo '<a href=" '. tep_href_link(FILENAME_INFORMATION, 'info_id=7') . '">Payment Methods</a>'; ?></li>
					<li><?php echo '<a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING) . '">'.HEADER_TITLE_CHECKOUT.'</a>'; ?></li>
					<li><?php echo '<a href="' . tep_href_link(FILENAME_INFORMATION, 'info_id=8') . '">Contact Us</a>'; ?></li>
				  </ul>
				  <ul class="nav navbar-nav nav-top navbar-right">
                    <?php
                    if (!tep_session_is_registered('customer_id')) {
                    ?>
					<li><a href="<?php echo tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>"><span class="glyphicon glyphicon-plus"></span> Create Account</a></li>
                    <?php } ?>
                    <li>
                    <?php
                    if (tep_session_is_registered('customer_id')) {
                        echo '<a href="'. tep_href_link(FILENAME_LOGOFF, '', 'SSL').'"><span class="glyphicon glyphicon-hand-left"></span> Log Off</a>';
                    }else{
                        echo '<a href="'. tep_href_link(FILENAME_LOGIN, '', 'SSL').'"><span class="glyphicon glyphicon-hand-right"></span> Log In</a>';
                    }   
                    ?>
                    </li>
					<li><a href="<?php echo tep_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
				  </ul>
				</div><!-- /.nav-collapse -->
			  </nav><!-- /.navbar -->
			</div><!-- /example -->
		  </div>
		</div>
	  </nav>
	  
	  <section id="top-banner">
        <div class="page-header" id="banner">
          <div class="row">
			<div class="col-lg-8 col-md-12 col-sm-12">
              <div class="logo">
              <?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_NAME, 'img-responsive') . '</a>'; ?>
			  </div>
            </div>
			<div class="col-lg-4 col-md-12 col-sm-12 hidden-xs">
			  <h4 class="pull-right"><span class="glyphicon glyphicon-earphone"></span> CALL US (06) 358 8999 </h4>
			  <div class="clearfix"></div>
			  <h5 class="pull-right"><?php echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '">SHOPPING CART</a>'; ?> <span><?php echo $cart->count_contents() > 0 ? $cart->count_contents() : '0';?> ITEM(S)</span> - <?php echo $currencies->format($cart->show_total());?> <a id="show-cart" class="glyphicon glyphicon-shopping-cart icon-cart"></a></h5>
			  <div id="shopping-cart-mini" style="display: none;">
				<ul id="submenu" class="submenu " style="display: block;">
                  <?php
                  $products = $cart->get_products();
                  for ($i=0, $n=sizeof($products); $i<$n; $i++) {
                    if($i == 2){
                        continue;
                    }else{
                  ?>
				  <li class="items first">
					<?php echo tep_image(DIR_WS_IMAGES. $products[$i]['image'], '', '80', '80', '');?>
					<div class="item">
					  <h5 class="item1">
						<a href="<?php tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']);?>">
						  <span class="newItemInCart"><?php echo $products[$i]['name']; ?></span>
						</a>
					  </h5>
					  <span class="item2">
						<span class="newItemInCart"><?php echo $products[$i]['quantity'] . '&nbsp;x&nbsp;'.$currencies->format($products[$i]['price']).' = '.$currencies->format(($products[$i]['quantity'] * $products[$i]['price']));?></span>
					  </span>
					</div>
				  </li>
                  <?php
                  }}
                  ?>
                  <?php
                  if (sizeof($products) > 2){
                  ?>
                  <li class="items">
					<span>Click shopping cart for all items.</span>
				  </li>
                  <?php
                  }
                  ?>
				  <li class="total">
					<span class="cart-total"><?php echo $currencies->format($cart->show_total());?></span>
				  </li>
				  <li class="last form-group">
					<strong class="button_content button_content2">
					  <strong class="button bg_button">
						<a href="<?php echo tep_href_link(FILENAME_SHOPPING_CART); ?>">
						  <span class="btn btn-primary">Shopping cart</span>
						</a>
					  </strong>
					</strong>
					<strong class="button_content button_content1">
					  <strong class="button bg_button">
						<a href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING); ?>">
						  <span class="btn btn-primary">Checkout</span>
						</a>
					  </strong>
					</strong>
				  </li>
				</ul>
              </div>
		    </div>
          </div>
        </div>
	  </section>

      <!-- Navbar
      ================================================== -->

	  <?php include(DIR_WS_MODULES . 'category_menu.php');
        if ( (strpos($_SERVER['PHP_SELF'], 'index.php')) && (!isset($_GET['manufacturers_id']) && (!$current_category_id)) ) {
        //we just dont display anything	

        } else { ?>

        <section id="breadcrumbs">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <?php echo $breadcrumb->trail(); ?>
                    </ol>
                </div>
            </div>
        </section>
        <?php } ?>
        <?php
          if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
        ?>
        <div class="alert alert-danger fade in">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4>Oh snap! You got an error!</h4>
          <p><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message']))); ?></p>
        </div>
        <?php
          }

          if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
        ?>
        <div class="alert alert-warning fade in">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4>Oh snap! You got an error!</h4>
          <p><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['info_message']))); ?></p>
        </div>
        <?php
          }
        ?>
