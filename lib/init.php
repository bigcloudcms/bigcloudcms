<?php
/**
 * bigcloudcms initial setup and constants
 */
function bigcloudcms_setup() {

  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'bigcloudcms'),
    'secondary_navigation' => __('Secondary Navigation', 'bigcloudcms'),
    'mobile_navigation' => __('Mobile Navigation', 'bigcloudcms'),
    'topbar_navigation' => __('Topbar Navigation', 'bigcloudcms'),
    'footer_navigation' => __('Footer Navigation', 'bigcloudcms'),
  ));
  add_theme_support( 'title-tag' );
  add_theme_support('post-thumbnails');
  add_image_size( 'widget-thumb', 80, 50, true );
  add_post_type_support( 'attachment', 'page-attributes' );
  add_theme_support( 'automatic-feed-links' );
  add_editor_style('/assets/css/editor-style-bigcloudcms.css');
}
add_action('after_setup_theme', 'bigcloudcms_setup');

if ( ! function_exists( '_wp_render_title_tag' ) ) :
  function bigcloudcms_render_title() {
    ?>
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
  }
  add_action( 'wp_head', 'bigcloudcms_render_title' );
endif;


/**
 *BigCloudCMS SEO
 */
function bigcloudcms_wp_title( $title) {
  if(bigcloudcms_seo_switch()) {
    global $bigcloudcms_premium, $post;
    if ( get_post_meta( get_the_ID(), '_kad_seo_title', true )) { 
        $new_title = get_post_meta( get_the_ID(), '_kad_seo_title', true );
    }
    if(!empty($new_title)) { 
       $title = $new_title;
    } else if(!empty($bigcloudcms_premium['seo_sitetitle'])) {
        $title = $bigcloudcms_premium['seo_sitetitle'];
    }
  }

  return $title;
}
add_filter( 'pre_get_document_title', 'bigcloudcms_wp_title', 10);

function kt_fav_output_seo(){
  // Keep for fallback
  global $bigcloudcms_premium, $post;
  if(bigcloudcms_seo_switch()) {
      if ( get_post_meta( get_the_ID(), '_kad_seo_description', true )) { 
        echo '<meta name="description" content="'.get_post_meta( get_the_ID(), '_kad_seo_description', true ).'">';
      } else if (!empty($bigcloudcms_premium['seo_sitedescription'])) {
        echo '<meta name="description" content="'.$bigcloudcms_premium['seo_sitedescription'].'">';
      }
    }
  if(isset($bigcloudcms_premium['bigcloudcms_custom_favicon']['url']) && !empty($bigcloudcms_premium['bigcloudcms_custom_favicon']['url']) ) {
    echo '<link rel="shortcut icon" type="image/x-icon" href="'. esc_url($bigcloudcms_premium['bigcloudcms_custom_favicon']['url']).'" />';
  }
}
add_action('wp_head', 'kt_fav_output_seo', 5);

// Backwards compatibility for older than PHP 5.3.0
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

/**
 * Define helper constants
 */
$get_theme_name = explode('/themes/', get_template_directory());

define('RELATIVE_PLUGIN_PATH',  str_replace(home_url() . '/', '', plugins_url()));
define('RELATIVE_CONTENT_PATH', str_replace(home_url() . '/', '', content_url()));
define('THEME_NAME',            next($get_theme_name));
define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);
