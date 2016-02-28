<?php global $bigcloudcms_premium; if(!empty($bigcloudcms_premium['search_placeholder_text'])) {$searchtext = $bigcloudcms_premium['search_placeholder_text'];} else {$searchtext = __('Search', 'bigcloudcms');} ?>
<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>">
  <label class="hide" for="s"><?php _e('Search for:', 'bigcloudcms'); ?></label>
  <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="search-query" placeholder="<?php echo $searchtext; ?>">
  <button type="submit" id="searchsubmit" class="search-icon"><i class="icon-search"></i></button>
</form>