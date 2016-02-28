<?php 
  do_action('get_header');
  get_template_part('templates/head');

  global $bigcloudcms_premium; 
  if(isset($bigcloudcms_premium["smooth_scrolling"]) && $bigcloudcms_premium["smooth_scrolling"] == '1') {$scrolling = '1';}  else if(isset($pinnacle["smooth_scrolling"]) && $pinnacle["smooth_scrolling"] == '2') { $scrolling = '2';} else {$scrolling = '0';}
  if(isset($bigcloudcms_premium["smooth_scrolling_hide"]) && $bigcloudcms_premium["smooth_scrolling_hide"] == '1') {$scrolling_hide = '1';} else {$scrolling_hide = '0';} 
  if(isset($bigcloudcms_premium['bigcloudcms_animate_in']) && $bigcloudcms_premium['bigcloudcms_animate_in'] == '1') {$animate = '1';} else {$animate = '0';}
  if(isset($bigcloudcms_premium['sticky_header']) && $bigcloudcms_premium['sticky_header'] == '1') {$sticky = '1';} else {$sticky = '0';}
  if(isset($bigcloudcms_premium['product_tabs_scroll']) && $bigcloudcms_premium['product_tabs_scroll'] == '1') {$pscroll = '1';} else {$pscroll = '0';}
  if(isset($bigcloudcms_premium['header_style'])) {$header_style = $bigcloudcms_premium['header_style'];} else {$header_style = 'standard';}
  if(isset($bigcloudcms_premium['select2_select'])) {$select2_select = $bigcloudcms_premium['select2_select'];} else {$select2_select = '1';}
  ?>
<body <?php body_class(); ?> data-smooth-scrolling="<?php echo esc_attr($scrolling);?>" data-smooth-scrolling-hide="<?php echo esc_attr($scrolling_hide);?>" data-jsselect="<?php echo esc_attr($select2_select);?>" data-product-tab-scroll="<?php echo esc_attr($pscroll); ?>" data-animate="<?php echo esc_attr($animate);?>" data-sticky="<?php echo esc_attr($sticky);?>">
<div id="wrapper" class="container">
  <!--[if lt IE 8]><div class="alert"> <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'bigcloudcms'); ?></div><![endif]-->
  <?php
   do_action('kt_beforeheader');
    if($header_style == 'center') {
          if(isset($bigcloudcms_premium['shrink_center_header']) && $bigcloudcms_premium['shrink_center_header'] == "1") {
           get_template_part('templates/header-style-two-shrink');
          } else {
            get_template_part('templates/header-style-two');
          } 
    } else if ($header_style == 'shrink') {
      get_template_part('templates/header-style-three');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <div class="wrap clearfix contentclass hfeed" role="document">

        <?php do_action('kt_afterheader');
        include bigcloudcms_template_path(); ?>
        
      <?php if (bigcloudcms_display_sidebar()) : ?>
      <aside id="ktsidebar" class="<?php echo esc_attr(bigcloudcms_sidebar_class()); ?> kad-sidebar" role="complementary">
        <div class="sidebar">
          <?php include bigcloudcms_sidebar_path(); ?>
        </div><!-- /.sidebar -->
      </aside><!-- /aside -->
      <?php endif; ?>
      </div><!-- /.row-->
    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php do_action('get_footer');
  get_template_part('templates/footer'); ?>
</div><!--Wrapper-->
</body>
</html>
