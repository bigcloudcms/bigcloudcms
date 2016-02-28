<?php
/**
 * Enqueue scripts and stylesheets
 */

function bigcloudcms_scripts() {
  wp_enqueue_style('bigcloudcms_app', get_template_directory_uri() . '/assets/css/bigcloudcms.css', false, '350');
  global $bigcloudcms_premium; if(isset($bigcloudcms_premium['skin_stylesheet']) && !empty($bigcloudcms_premium['skin_stylesheet'])) {$skin = $bigcloudcms_premium['skin_stylesheet'];} else { $skin = 'default.css';} 
 wp_enqueue_style('bigcloudcms_skin', get_template_directory_uri() . '/assets/css/skins/'.$skin.'', false, null);

if (is_child_theme()) {
   wp_enqueue_style('bigcloudcms_child', get_stylesheet_uri(), false, null);
  } 
  
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', false, null, false);
  wp_register_script('bigcloudcms_plugins', get_template_directory_uri() . '/assets/js/plugins.js', false, 350, true);
  wp_register_script('bigcloudcms_main', get_template_directory_uri() . '/assets/js/main.js', false, 350, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('modernizr');
  wp_enqueue_script('bigcloudcms_plugins');
  if(isset($bigcloudcms_premium["smooth_scrolling"]) && $bigcloudcms_premium["smooth_scrolling"] == '1') { 
     wp_register_script('bigcloudcms_smoothscroll', get_template_directory_uri() . '/assets/js/min/nicescroll-min.js', false, null, false);
     wp_enqueue_script('bigcloudcms_smoothscroll');
  } else if(isset($bigcloudcms_premium["smooth_scrolling"]) && $bigcloudcms_premium["smooth_scrolling"] == '2') { 
    wp_register_script('bigcloudcms_smoothscroll', get_template_directory_uri() . '/assets/js/min/smoothscroll-min.js', false, null, true);
    wp_enqueue_script('bigcloudcms_smoothscroll');
  }
  wp_enqueue_script('bigcloudcms_main');

  if((isset($bigcloudcms_premium['infinitescroll']) && $bigcloudcms_premium['infinitescroll'] == 1) || (isset($bigcloudcms_premium['blog_infinitescroll']) && $bigcloudcms_premium['blog_infinitescroll'] == 1)) {
    wp_register_script('infinite_scroll', get_template_directory_uri() . '/assets/js/jquery.infinitescroll.js', false, null, true);
    wp_enqueue_script('infinite_scroll');
  }

  if(class_exists('woocommerce')) {
    if(isset($bigcloudcms_premium['product_radio']) && $bigcloudcms_premium['product_radio'] == 1) {
      wp_deregister_script('wc-add-to-cart-variation');
      wp_register_script( 'wc-add-to-cart-variation', get_template_directory_uri() . '/assets/js/min/add-to-cart-variation-radio-min.js' , array( 'jquery' ), false, '330', true );
          wp_localize_script( 'wc-add-to-cart-variation', 'wc_add_to_cart_variation_params', apply_filters( 'wc_add_to_cart_variation_params', array(
        'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'bigcloudcms' ),
        'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'bigcloudcms' ),
      ) ) );
          wp_enqueue_script( 'wc-add-to-cart-variation');
    } else {
     wp_register_script( 'kt-wc-add-to-cart-variation', get_template_directory_uri() . '/assets/js/min/kt-add-to-cart-variation-min.js' , array( 'jquery' ), false, '328', true );
     wp_enqueue_script( 'kt-wc-add-to-cart-variation');
    }
    if(isset($bigcloudcms_premium['product_quantity_input']) && $bigcloudcms_premium['product_quantity_input'] == 1) {
      function kt_get_wc_version() {return defined( 'WC_VERSION' ) && WC_VERSION ? WC_VERSION : null;}
      function kt_is_wc_version_gte_2_3() {return kt_get_wc_version() && version_compare(kt_get_wc_version(), '2.3', '>=' );}
      if (kt_is_wc_version_gte_2_3() ) {
        wp_register_script( 'wcqi-js', get_template_directory_uri() . '/assets/js/min/wc-quantity-increment.min.js' , array( 'jquery' ), false, '295', true );
        wp_enqueue_script( 'wcqi-js' );
      }
    }
  }

}
add_action('wp_enqueue_scripts', 'bigcloudcms_scripts', 100);

/**
 * Add Respond.js for IE8 support of media queries
 */
function bigcloudcms_ie_support_header() {
    echo '<!--[if lt IE 9]>'. "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/assets/js/vendor/respond.min.js' ) . '"></script>'. "\n";
    echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'bigcloudcms_ie_support_header', 15 );

function bigcloudcms_google_analytics() { 
  global $bigcloudcms_premium; 
  if(isset($bigcloudcms_premium['google_analytics']) && !empty($bigcloudcms_premium['google_analytics'])) { ?>
  <!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $bigcloudcms_premium['google_analytics']; ?>', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
  <?php
  }
}
add_action('wp_head', 'bigcloudcms_google_analytics', 20);
