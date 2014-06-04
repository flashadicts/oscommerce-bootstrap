<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

?>
<!-- Responsive slider - START -->
<section id="main-slider" class="hidden-xs hidden-sm">
    <div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
      <div class="slides" data-group="slides">
        <ul>
        <?php
        $slides_query = tep_db_query("select slideshow_name, slideshow_url, slideshow_addtocart, slideshow_description, slideshow_image FROM " . TABLE_SLIDESHOW . " order by slideshow_id");
 
        $slides_array = array();
            
        while ($slide_values = tep_db_fetch_array($slides_query)) {
         // print_r($slides_values);
            $slides_array[] = array('slide_name' => $slide_values['slideshow_name'],
                                   'slide_url' => $slide_values['slideshow_url'],
                                   'slide_addtocart' => $slide_values['slideshow_addtocart'],
                                   'slide_description' => $slide_values['slideshow_description'],
                                   'slide_image' => $slide_values['slideshow_image']);
        }

        foreach ($slides_array as $k){
        ?>
          <li>
            <div class="slide-body" data-group="slide">
              <img src="images/slider/bg.gif" alt="slider-bg">
              <div class="caption header" data-animate="slideAppearRightToLeft" data-delay="500" data-length="300">
                <h2><?php echo $k['slide_description']; ?></h2>
                <div class="caption sub" data-animate="slideAppearLeftToRight" data-delay="800" data-length="300"><?php echo $k['slide_name']; ?></div>
              </div>
              <div class="caption img-product" data-animate="slideAppearDownToUp" data-delay="200">
                <img src="<?php echo  DIR_WS_IMAGES . $k['slide_image']; ?>" alt="<?php echo $k['slide_name'];?>" title="<?php echo $k['slide_name'];?>">
              </div>
              <div class="caption img-buttons" data-animate="slideAppearLeftToRight" style="opacity: 1; margin-left: 0px; margin-right: 0px;">
                <div class="form-group">
                <?php
                if($k['slide_url'] == '' && $k['slide_addtocart'] != ''){
                    echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'));
                    echo tep_draw_hidden_field('products_id', $k['slide_addtocart']);
                    echo '<a href="' . FILENAME_PRODUCT_INFO . '?products_id=' . $k['slide_addtocart']. '"><span class="btn btn-primary">Details</span></a>';
                    echo '<button class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>';
                    echo '</form>';
                }elseif($k['slide_url'] != '' && $k['slide_addtocart'] != ''){
                    echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product'));
                    echo tep_draw_hidden_field('products_id', $k['slide_addtocart']);
                    echo '<a href="' . $k['slideshow_url']. '"><span class="btn btn-primary">Details</span></a>';
                    echo '<button class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>';
                    echo '</form>';
                }elseif($k['slide_url'] != '' && $k['slide_addtocart'] == ''){
                    echo '<a href="' . $k['slideshow_url']. '"><span class="btn btn-primary">Details</span></a>';
                }else{
                
                }
                ?>
                </div>
              </div>
            </div>
          </li>
          <?php
          }
          ?>
        </ul>
      </div>
      <a class="slider-control left" href="#" data-jump="prev">&lt;</a>
      <a class="slider-control right" href="#" data-jump="next">&gt;</a>
      <div class="pages">
        <?php
        for($i=0; $i<count($slides_array); $i++){
            echo '<a class="page" href="#" data-jump-to="'.$i.'"></a>';
        }
        ?>
      </div>
    </div>
</section>