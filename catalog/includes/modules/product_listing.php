<?php
    /*
    $Id: product_listing.php 187 2010-12-01 11:12:10Z Rob $

    osCommerce, Open Source E-Commerce Solutions
    http://www.oscommerce.com

    Copyright (c) 2010 osCommerce

    Released under the GNU General Public License
    */

$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');

if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
              
            <div class="row">
                <div class="col-md-6">
                    <h4 class="num-products"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></h4>
                </div>
                <div class="col-md-6">
                    <?php echo $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
                </div>
            </div>
            <div class="tab-content product-tab">
<?php
} 

if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
?>

    <div class="tab-pane" id="list">
<?php             



    while ($listing = tep_db_fetch_array($listing_query)) {
        $rows++;
        if ($new_price = tep_get_products_special_price($listing['products_id'])) {
				$persent = ($currencies->display_sale_percent($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']), $new_price) * -1);
				$sale_percent = '<div class="sale_percent"><strong>'.$persent.'%</strong></div>';
            } else {
                $sale_percent = '';
            }
?>
        <div class="row product-block">

            <div class="col-md-2 product-image">
                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>"><?php echo tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], 'img-responsive');?></a>
            </div>
            <?php echo $sale_percent; ?>
            <div class="col-md-8 product-details">
                <h5><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>"><?php echo $listing['products_name'];?></a></h5>

                <div class="row product-details-list">
                    <div class="col-md-3"><strong>Advantage Id:</strong></div>
                    <div class="col-md-9"><?php echo $listing['products_id'];?></div>
                </div>

                <div class="row product-details-list">
                    <div class="col-md-3"><strong>Brand:</strong></div>
                    <div class="col-md-9"><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']); ?>"><?php echo $listing['manufacturers_name'];?></a></div>
                </div>

                <div class="row product-details-list">
                    <div class="col-md-3"><strong>Model:</strong></div>
                    <div class="col-md-9"><?php echo $listing['products_model'];?></div>
                </div>

                <div class="row product-details-list">
                        <div class="col-md-3"><strong>Quantity:</strong></div>
                        <div class="col-md-9"><?php echo $listing['products_quantity'];?></div>
                </div>
            </div>
            <div class="col-md-2 pricing">
                <div class="pricing-info">
                <?php
                if (tep_not_null($listing['specials_new_products_price'])) {
                    echo '<span class="price">'. $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</span>';
                    echo '<h5 class="special-price">'.$currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</h5>';
                }else{
                    echo '<h4>'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</h4>';
                }
                ?>
                </div>
                <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'action=buy_now&products_id=' . $listing['products_id']);?>" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                </a>
                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>" class="btn btn-default btn-sm">
                    <span class="new-button-details">Details</span>
                </a>
            </div>
        </div>
        <?php
        }
        ?>
    </div> <!-- eof list tab -->
<?php
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
?>
    <div class="tab-pane" id="grid">
        <div class="row">

        <?php    
        while ($listing = tep_db_fetch_array($listing_query)) {
            $rows++;
            //echo '<pre>';
            //print_r($listing);
            //echo '</pre>';
            
            if ($new_price = tep_get_products_special_price($listing['products_id'])) {
				$persent = ($currencies->display_sale_percent($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']), $new_price) * -1);
				$sale_percent = '<div class="sale_percent"><strong>'.$persent.'%</strong></div>';
            } else {

                $sale_percent = '';
            }
        ?>
            <div class="col-md-4 col-sm-6">

                <div class="panel panel-default categories">
                    <div class="panel-body">
                        <div class="product_block equal-height_new_products_block">
                            <div style="">
                                <div class="product_pic_wrapper" >
                                    <a class="product_img">
                                        <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>"><?php echo tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], 'img-responsive');?></a>
                                    </a>
                                </div>
                                <?php echo $sale_percent ; ?>
                                <div class="product_info_wrapper">
                                    <div class="row_01">
                                        <h4>
                                            <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>"><?php echo $listing['products_name'];?></a>
                                        </h4>
                                    </div>
                                    <div class="row product-details-list">
                                        <div class="col-md-6 text-right"><strong>Advantage Id:</strong></div>
                                        <div class="col-md-6 text-left"><?php echo $listing['products_id'];?></div>
                                    </div>

                                    <div class="row product-details-list">
                                        <div class="col-md-6 text-right"><strong>Brand:</strong></div>
                                        <div class="col-md-6 text-left"><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $listing['manufacturers_id']); ?>"><?php echo $listing['manufacturers_name'];?></a></div>
                                    </div>

                                    <div class="row product-details-list">
                                        <div class="col-md-6 text-right"><strong>Model:</strong></div>
                                        <div class="col-md-6 text-left"><?php echo $listing['products_model'];?></div>
                                    </div>

                                    <div class="row product-details-list">
                                        <div class="col-md-6 text-right"><strong>Quantity:</strong></div>
                                        <div class="col-md-6 text-left"><?php echo $listing['products_quantity'];?></div>
                                    </div>
                                    <div class="row_02">
                                        <div class="cl_both block">
                                            <div class="product_price_wrapper price ">
                                                <b>Price:&nbsp;&nbsp;</b>
                                                <?php
                                                if (tep_not_null($listing['specials_new_products_price'])) {
                                                    echo '<del>'. $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</del>';
                                                    echo '<span class="productSpecialPrice">'.$currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</span>';
                                                }else{
                                                    echo '<del></del><span class="productPrice">'.$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])).'</span>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="product_button_wrapper">
                                            <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'action=buy_now&products_id=' . $listing['products_id']);?>"  class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                            </a>
                                            <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $listing['products_id']);?>" class="btn btn-default btn-sm">
                                                <span class="new-button-details">Details</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ((($rows / 3) == floor($rows / 3))) {
              ?>
            </div>
            <div class="row">
            <?php
            }
            ?>
        <?php
        }
        ?>
        </div>
    </div>
</div>
<?php
}else{
?>
    <p><?php echo TEXT_NO_PRODUCTS; ?></p>
    </div>
    </div>
<?php
}


if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

<div class="row">
    <div class="col-md-6">
        <h4 class="num-products"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></h4>
    </div>
    <div class="col-md-6">
        <?php echo $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
    </div>
</div>

<?php
}
?>