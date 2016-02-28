<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	global $bigcloudcms_premium; 

?>
<div class="sliderclass home_sliderclass revslider_home_hidetop">
<?php  
	if( function_exists('putRevSlider') ) {
		putRevSlider( $bigcloudcms_premium['rev_slider'] );
		if(isset($bigcloudcms_premium['above_header_slider_arrow']) && $bigcloudcms_premium['above_header_slider_arrow'] == 1) {
        	echo '<div class="kad_fullslider_arrow"><a href="#home_slider_bottom"><i class="icon-arrow-down"></i></a></div>';
      	}
	} else {
		echo '<p class="error" style="text-align:center; color: red;">'.__("Please Install Revolution Slider Plugin", "bigcloudcms").'</p>';
	} ?>
</div><!--sliderclass-->
<div id="home_slider_bottom"></div>