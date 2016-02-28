<?php 
global $bigcloudcms_premium;

if(isset($bigcloudcms_premium['postlinks_in_cat']) && $bigcloudcms_premium['postlinks_in_cat'] == "cat"){
	$cat_setting = true;
} else {
	$cat_setting = false;
}
?>
<div class="kad-post-navigation clearfix">
        <div class="alignleft kad-previous-link">
        <?php previous_post_link('%link', __('Previous Post', 'bigcloudcms'), $in_same_term = $cat_setting); ?> 
        </div>
        <div class="alignright kad-next-link">
        <?php next_post_link('%link', __('Next Post', 'bigcloudcms'), $in_same_term = $cat_setting); ?> 
        </div>
 </div> <!-- end navigation -->