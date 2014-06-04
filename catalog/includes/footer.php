<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require(DIR_WS_INCLUDES . 'counter.php');
?>

      <section class="links">
        <div class="row" style="width: 100%;">
          <div class="col-md-3 links-col">
            <h3>Information</h3>
            <ul class="footer_information">
              <li><a href="#">Our Store</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_CONTACT_US, '', 'SSL');?>">Contact Us</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=7', 'SSL');?>">Payment Methods</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=6', 'SSL');?>">Returns Policy</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=10', 'SSL');?>">Online Store Usage Policy</a></li>
              <li><a href="#">Services</a></li>
            </ul>
          </div>
          <div class="col-md-3 links-col">
            <h3>Our Offers</h3>
            <ul class="footer_offers">
              <li><a href="#">Featured</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_SPECIALS); ?>">Specials</a></li>
              <li><a href="#">New Products</a></li>
              <li><a href="#">Top Sellers</a></li>
            </ul>
          </div>
          <div class="col-md-3 links-col">
            <h3>Your Account</h3>
            <ul class="footer_offers">
              <?php
              if (tep_session_is_registered('customer_id')) {
                  echo '<li><a href="'. tep_href_link(FILENAME_LOGOFF, '', 'SSL').'">Log Off</a></li>';
              }else{
                  echo '<li><a href="'. tep_href_link(FILENAME_LOGIN, '', 'SSL').'">Log In</a></li>';
              }   
              ?>
              <li><a href="<?php echo tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'); ?>">Create Account</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_INFORMATION, 'info_id=9', 'SSL');?>">Shipping</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'); ?>">Order History</a></li>
              <li><a href="<?php echo tep_href_link(FILENAME_ADVANCED_SEARCH, '', 'SSL'); ?>">Advanced Search</a></li>
            </ul>
          </div>
          <div class="col-md-3 links-col">
            <h3>Our Details</h3>
            <ul class="footer_details">
              <li>Store Name</li>
              <li>123 Example Street</li>
              <li>England 4410</li>
              <li><span class="glyphicon glyphicon-earphone"></span> +61 123 465789</li>
              <li><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:sales@mystore.com">sales@mystore.com</a></li>
            </ul>
          </div>
        </div>
	  </section>
		
      <footer>
		<div class="row">
          <div class="col-md-12">
			<div class="row">
              <div class="col-md-6">
				<strong>All rights reserved © 2013</strong> <a href="http://www.mystore.com">mystore.com</a>
              </div>
			  <div class="col-md-6">
                <p class="social">
				  <a class="social-bg"><img src="images/visamc.jpg" title="We accept payment via credit card with extra cost." alt="Accepted credit cards"></a>
                  <a href="/" class="social-bg"><span class="el-icon-facebook el-colour"></span></a>
                  <a href="/" class="social-bg"><span class="el-icon-twitter el-colour"></span></a>
                  <a href="/" class="social-bg"><span class="el-icon-youtube el-colour"></span></a>
                  <a href="/" class="social-bg"><span class="el-icon-linkedin el-colour"></span></a>
                  <a href="/" class="social-bg"><span class="el-icon-pinterest el-colour"></span></a>
				</p>
              </div>
			</div>
          </div>
		</div>
	  </footer>

<script type="text/javascript">
$('.productListTable tr:nth-child(even)').addClass('alt');
</script>
