<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	global $bigcloudcms_premium;

?>
<div class="sliderclass clearfix ktslider_home_hidetop">
<?php echo do_shortcode( '[bigcloudcms_slider id="'.$bigcloudcms_premium['kt_slider'].'"]' ); ?>
</div><!--sliderclass-->