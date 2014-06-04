<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
?>


<?php
  if ($oscTemplate->hasBlocks('boxes_column_right')) {
?>

<div class="col-md-3 right-column">
  <?php echo $oscTemplate->getBlocks('boxes_column_right'); ?>
</div>

<?php
  }
?>
</div>
<!-- EOF Row -->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

</div> <!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="ext/jquery/ui/jquery-ui-1.10.4.min.js"></script>

    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.event.move.js"></script>
	<script src="js/responsive-slider.min.js"></script>
	<script src="js/jcarousellite_1.0.1.min.js"></script>
	<script src="js/smartsuggest.js"></script>
	<script src="js/imagelightbox.min.js"></script>
	<script src="js/advantage.js"></script>
	
	<!-- brands js >
	<script type="text/javascript" src="js/jquery.carouFredSel-6.2.1-packed.js"></script>
	<script type="text/javascript" src="js/jquery.mousewheel.min.js"></script>
	<script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
	<script type="text/javascript" src="js/jquery.transit.min.js"></script>
	<script type="text/javascript" src="js/jquery.ba-throttle-debounce.min.js"></script-->
	
	<script> 
	$(function () {
        $('#main-tab a:first').tab('show')
    })
   $(function () {
        $('#display-tab a:first').tab('show')
    })
	$(function() {
	$(".specials-jcarousellite").jCarouselLite({
			vertical: true,
			visible: 2,
			auto:1000,
            pauseOnMouseOver: true, // This is the configuration parameter
			speed:1000
		});
	});
	
	$(document).ready(
    function(){
        $("#show-cart").click(function () {
            $("#shopping-cart-mini").toggle();
        });
    });
	</script>
</html>
