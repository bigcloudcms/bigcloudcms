<?php
/**
 * @category BigCloudCMS Theme
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'bigcloudcms_metaboxes' );



/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
//add_filter('cmb_icomoon', 'cmb_icomoon');
add_filter( 'cmb_render_imag_select_taxonomy', 'imag_render_imag_select_taxonomy', 10, 2 );
function imag_render_imag_select_taxonomy( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All", 'bigcloudcms' ),
            'hierarchical' => 1,
            'taxonomy' => $field['taxonomy'],
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';
}
add_filter( 'cmb_render_imag_select_category', 'imag_render_imag_select_category', 10, 2 );
function imag_render_imag_select_category( $field, $meta ) {

    wp_dropdown_categories(array(
            'show_option_none' => __( "All Blog Posts", 'bigcloudcms' ),
            'hierarchical' => 1,
            'taxonomy' => 'category',
            'orderby' => 'name', 
            'hide_empty' => 0, 
            'name' => $field['id'],
            'selected' => $meta  

        ));
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
add_filter( 'cmb_render_select_pages', 'imag_render_select_pages', 10, 2 );
function imag_render_select_pages( $field, $meta ) {	
	$pages = get_pages(); 
    if (!empty($pages)) {
			 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
			  echo '<option value="default"', $meta == 'default' ? ' selected="selected"' : '', '>Theme Options Default</option>';
		  foreach ($pages as $page) {
		    echo '<option value="', $page->ID, '"', $meta == $page->ID ? ' selected="selected"' : '', '>', $page->post_title, '</option>';
		  }
		  echo '</select>'; 
		}
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
add_filter( 'cmb_render_imag_select_sidebars', 'imag_render_imag_select_sidebars', 10, 2 );
function imag_render_imag_select_sidebars( $field, $meta ) {
	global $vir_sidebars;	
	
	 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
  foreach ($vir_sidebars as $side) {
    echo '<option value="', $side['id'], '"', $meta == $side['id'] ? ' selected="selected"' : '', '>', $side['name'], '</option>';
  }
  echo '</select>';
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
add_filter( 'cmb_render_imag_select_sidebars_product', 'imag_render_imag_select_sidebars_product', 10, 2 );
function imag_render_imag_select_sidebars_product( $field, $meta ) {
	global $vir_sidebars;	
	
	 echo '<select name="', $field['id'], '" id="', $field['id'], '">';
	 echo '<option value="default" selected="selected">Theme Options Default</option>';
  foreach ($vir_sidebars as $side) {
    echo '<option value="', $side['id'], '"', $meta == $side['id'] ? ' selected="selected"' : '', '>', $side['name'], '</option>';
  }
  echo '</select>';
	
    if ( !empty( $field['desc'] ) ) echo '<p class="cmb_metabox_description">' . $field['desc'] . '</p>';

}
function kad_metabox_post_format( $display, $meta_box ) {
    if ( 'format' !== $meta_box['show_on']['key'] )
        return $display;

    // If we're showing it based on ID, get the current ID                  
    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
    elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
    if( !isset( $post_id ) )
        return $display;

    $format = get_post_format( $post_id );
    if ( false === $format ) {$format = 'standard';}
    if ($format == $meta_box['show_on']['value']) 
    	return true;
    	 else 
        return false;
}
//add_filter( 'cmb_show_on', 'kad_metabox_post_format', 10, 2 );

function bigcloudcms_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_kad_';

	$meta_boxes[] = array(
				'id'         => 'subtitle_metabox',
				'title'      => __( "Page Title and Subtitle", 'bigcloudcms' ),
				'pages'      => array( 'page', ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
					array(
						'name' => __( "Subtitle", 'bigcloudcms' ),
						'desc' => __( "Subtitle will go below page title", 'bigcloudcms' ),
						'id'   => $prefix . 'subtitle',
						'type' => 'textarea_code',
					),
				)
			);
$meta_boxes[] = array(
				'id'         => 'standard_post_metabox',
				'title'      => __("Standard Post Options", 'bigcloudcms'),
				'pages'      => array( 'post',), // Post type
				//'show_on' => array( 'key' => 'format', 'value' => 'standard'),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __("Head Content", 'bigcloudcms' ),
				'desc'    => '',
				'id'      => $prefix . 'blog_head',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Site Default', 'bigcloudcms' ), 'value' => 'default', ),
					array( 'name' => __("None", 'bigcloudcms' ), 'value' => 'none', ),
					array( 'name' => __("Image Slider (Flex Slider)", 'bigcloudcms' ), 'value' => 'flex', ),
					array( 'name' => __("Carousel Slider - (Caroufedsel Slider)", 'bigcloudcms' ), 'value' => 'carouselslider', ),
					array( 'name' => __("Image Carousel", 'bigcloudcms' ), 'value' => 'carousel', ),
					array( 'name' => __("Video", 'bigcloudcms' ), 'value' => 'video', ),
					array( 'name' => __("Image", 'bigcloudcms' ), 'value' => 'image', ),
					array( 'name' => __("Shortcode", 'bigcloudcms' ), 'value' => 'shortcode', ),
				),
			),
			array(
				'name' => __("Max Image/Slider Height", 'bigcloudcms' ),
				'desc' => __("Default is: 400 (Note: just input number, example: 350)", 'bigcloudcms' ),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'bigcloudcms' ),
				'desc' => __("Default is: 770 or 1140 on fullwidth posts (Note: just input number, example: 650, does not apply to carousel slider)", 'bigcloudcms' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name'    => __("Post Summary", 'bigcloudcms' ),
				'desc'    => '',
				'id'      => $prefix . 'post_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Site Default', 'bigcloudcms' ), 'value' => 'default', ),
					array( 'name' => __('Text', 'bigcloudcms' ), 'value' => 'text', ),
					array( 'name' => __('Portrait Image', 'bigcloudcms'), 'value' => 'img_portrait', ),
					array( 'name' => __('Landscape Image', 'bigcloudcms'), 'value' => 'img_landscape', ),
					array( 'name' => __('Portrait Image Slider', 'bigcloudcms'), 'value' => 'slider_portrait', ),
					array( 'name' => __('Landscape Image Slider', 'bigcloudcms'), 'value' => 'slider_landscape', ),
					array( 'name' => __('Video', 'bigcloudcms'), 'value' => 'video', ),
				),
			),
			array(
						'name' => __('If Video Post', 'bigcloudcms'),
						'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'bigcloudcms'),
						'id'   => $prefix . 'post_video',
						'type' => 'textarea_code',
			),
			array(
						'name' => __('If Shortcode Head Content', 'bigcloudcms'),
						'desc' => __('Place Shortcode Here', 'bigcloudcms'),
						'id'   => $prefix . 'post_shortcode',
						'type' => 'textarea_code',
			),
		),
	);

	$meta_boxes[] = array(
				'id'         => 'post_metabox',
				'title'      => __("Post Options", 'bigcloudcms'),
				'pages'      => array( 'post',), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Display Sidebar?', 'bigcloudcms'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'bigcloudcms'),
				'id'   => $prefix . 'post_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'bigcloudcms'), 'value' => 'default', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
			),
			array(
				'name' => __('Author Info', 'bigcloudcms'),
				'desc' => __('Display an author info box?', 'bigcloudcms'),
				'id'   => $prefix . 'blog_author',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'bigcloudcms'), 'value' => 'default', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),	
			array(
				'name' => __('Posts Carousel', 'bigcloudcms'),
				'desc' => __('Display a carousel with similar or recent posts?', 'bigcloudcms'),
				'id'   => $prefix . 'blog_carousel_similar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'bigcloudcms'), 'value' => 'default', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes - Display Recent Posts', 'bigcloudcms'), 'value' => 'recent', ),
					array( 'name' => __('Yes - Display Similar Posts', 'bigcloudcms'), 'value' => 'similar', )
				),
				
			),
			array(
				'name' => __('Carousel Title', 'bigcloudcms'),
				'desc' => __('ex. Similar Posts', 'bigcloudcms'),
				'id'   => $prefix . 'blog_carousel_title',
				'type' => 'text_medium',
			),
		),
	);

	$meta_boxes[] = array(
				'id'         => 'portfolio_post_metabox',
				'title'      => __('Portfolio Post Options', 'bigcloudcms'),
				'pages'      => array( 'portfolio' ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Project Layout', 'bigcloudcms'),
				'desc'    => '<a href="http://docs.bigcloudcms.com/bigcloudcms/#portfolio_posts" target="_blank">'.__('Whats the difference?', 'bigcloudcms').'</a>',
				'id'      => $prefix . 'ppost_layout',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => __('Beside', 'bigcloudcms'), 'value' => 'beside', ),
					array( 'name' => __('Above', 'bigcloudcms'), 'value' => 'above', ),
					array( 'name' => __('Three Rows', 'bigcloudcms'), 'value' => 'three', ), 
				),
			),
			array(
				'name'    => __('Project Options', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'ppost_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Image', 'bigcloudcms'), 'value' => 'image', ),
					array( 'name' => __('Image Slider (Flex Slider)', 'bigcloudcms'), 'value' => 'flex', ),
					array( 'name' => __('Carousel Slider', 'bigcloudcms'), 'value' => 'carousel', ),
					array( 'name' => __('Image Carousel', 'bigcloudcms'), 'value' => 'imgcarousel', ),
					array( 'name' => __('Rev Slider', 'bigcloudcms'), 'value' => 'rev', ),
					array( 'name' => __('BigCloudCMS Slider', 'bigcloudcms'), 'value' => 'ktslider', ),
					array( 'name' => __('Cyclone Slider', 'bigcloudcms'), 'value' => 'cyclone', ),
					array( 'name' => __('Image Grid', 'bigcloudcms'), 'value' => 'imagegrid', ),
					array( 'name' => __('Image List', 'bigcloudcms'), 'value' => 'imagelist', ),
					array( 'name' => __('Image List Style 2', 'bigcloudcms'), 'value' => 'imagelist2', ),
					array( 'name' => __('Video', 'bigcloudcms'), 'value' => 'video', ),
					array( 'name' => __('None', 'bigcloudcms'), 'value' => 'none', ),
				),
			),
			array(
				'name'    => __('Columns (Only for Image Grid option)', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_img_grid_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => '2', ),
					array( 'name' => __('Five Column', 'bigcloudcms'), 'value' => '5', ),
					array( 'name' => __('Six Column', 'bigcloudcms'), 'value' => '6', ),
				),
			),
			array(
				'name' => __("If Revolution, Cyclone or BigCloudCMS Slider", 'bigcloudcms' ),
				'desc' => __("Paste Slider Shortcode here", 'bigcloudcms' ),
				'id'   => $prefix . 'shortcode_slider',
				'type' => 'textarea_code',
			),
			array(
				'name' => __("Max Image/Slider Height", 'bigcloudcms' ),
				'desc' => __("Default is: 450 (Note: just input number, example: 350)", 'bigcloudcms' ),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'bigcloudcms' ),
				'desc' => __("Default is: 670 or 1140 on above or three row layouts (Note: just input number, example: 650)", 'bigcloudcms' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name' => __('Auto Play Slider?', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_autoplay',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'Yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Project Summary', 'bigcloudcms'),
				'desc'    => __('This determines how its displayed in the <b>portfolio grid page</b>', 'bigcloudcms'),
				'id'      => $prefix . 'post_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Image', 'bigcloudcms'), 'value' => 'image', ),
					array( 'name' => __('Image Slider', 'bigcloudcms'), 'value' => 'slider', ),
					array( 'name' => __('Image with video lightbox (must be url)', 'bigcloudcms'), 'value' => 'videolight', ),
				),
			),
			array(
				'name' => __('Value 01 Title', 'bigcloudcms'),
				'desc' => __('ex. Project Type:', 'bigcloudcms'),
				'id'   => $prefix . 'project_val01_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 01 Description', 'bigcloudcms'),
				'desc' => __('ex. Character Illustration', 'bigcloudcms'),
				'id'   => $prefix . 'project_val01_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 02 Title', 'bigcloudcms'),
				'desc' => __('ex. Skills Needed:', 'bigcloudcms'),
				'id'   => $prefix . 'project_val02_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 02 Description', 'bigcloudcms'),
				'desc' => __('ex. Photoshop, Illustrator', 'bigcloudcms'),
				'id'   => $prefix . 'project_val02_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 03 Title', 'bigcloudcms'),
				'desc' => __('ex. Customer:', 'bigcloudcms'),
				'id'   => $prefix . 'project_val03_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 03 Description', 'bigcloudcms'),
				'desc' => __('ex. Example Inc', 'bigcloudcms'),
				'id'   => $prefix . 'project_val03_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 04 Title', 'bigcloudcms'),
				'desc' => __('ex. Project Year:', 'bigcloudcms'),
				'id'   => $prefix . 'project_val04_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Value 04 Description', 'bigcloudcms'),
				'desc' => __('ex. 2013', 'bigcloudcms'),
				'id'   => $prefix . 'project_val04_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('External Website', 'bigcloudcms'),
				'desc' => __('ex. Website:', 'bigcloudcms'),
				'id'   => $prefix . 'project_val05_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Website Address', 'bigcloudcms'),
				'desc' => __('ex. http://www.example.com', 'bigcloudcms'),
				'id'   => $prefix . 'project_val05_description',
				'type' => 'text_medium',
			),
			array(
				'name' => __('If Video Project - Video URL (recomended)', 'bigcloudcms'),
				'desc' => __('Place youtube, vimeo url', 'bigcloudcms'),
				'id'   => $prefix . 'post_video_url',
				'type' => 'textarea_code',
			),
			array(
						'name' => __('If Video Project', 'bigcloudcms'),
						'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'bigcloudcms'),
						'id'   => $prefix . 'post_video',
						'type' => 'textarea_code',
					),
			array(
				'name'    => __('Choose Portfolio Parent Page', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_parent',
				'type'    => 'select_pages',
			),
				
		),
	);
	$meta_boxes[] = array(
				'id'         => 'portfolio_post_carousel_metabox',
				'title'      => __('Bottom Carousel Options', 'bigcloudcms'),
				'pages'      => array( 'portfolio' ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Carousel Title', 'bigcloudcms'),
				'desc' => __('ex. Similar Projects', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_carousel_title',
				'type' => 'text_medium',
			),
			array(
				'name' => __('Bottom Portfolio Carousel', 'bigcloudcms'),
				'desc' => __('Display a carousel with portfolio items below project?', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_carousel_recent',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
			array(
				'name' => __('Carousel Items', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_carousel_group',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All Portfolio Posts', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => __('Only of same Portfolio Type', 'bigcloudcms'), 'value' => 'cat', ),
				),
			),
			array(
				'name' => __('Carousel Order', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_carousel_order',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Menu Order', 'bigcloudcms'), 'value' => 'menu_order', ),
					array( 'name' => __('Title', 'bigcloudcms'), 'value' => 'title', ),
					array( 'name' => __('Date', 'bigcloudcms'), 'value' => 'date', ),
					array( 'name' => __('Random', 'bigcloudcms'), 'value' => 'rand', ),
				),
			),
				
		),
	);

	$meta_boxes[] = array(
				'id'         => 'testimonial_post_metabox',
				'title'      => __('Testimonial Options', 'bigcloudcms'),
				'pages'      => array( 'testimonial' ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Location', 'bigcloudcms'),
				'desc' => __('ex: New York, NY', 'bigcloudcms'),
				'id'   => $prefix . 'testimonial_location',
				'type' => 'text',
			),
			array(
				'name'    => __('Client Title', 'bigcloudcms'),
				'desc'    => __('ex: CEO of Example Inc', 'bigcloudcms'),
				'id'      => $prefix . 'testimonial_occupation',
				'type' => 'text',
			),
			array(
				'name'    => __('Link', 'bigcloudcms'),
				'desc'    => __('ex: http://www.example.com', 'bigcloudcms'),
				'id'      => $prefix . 'testimonial_link',
				'type' => 'text',
			),
		),
	);
	$meta_boxes[] = array(
				'id'         => 'product_post_side_metabox',
				'title'      => __('Product Sidebar Options', 'bigcloudcms'),
				'pages'      => array( 'product' ), // Post type
				'context'    => 'normal',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Display Sidebar?', 'bigcloudcms'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'bigcloudcms'),
				'id'   => $prefix . 'post_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Default', 'bigcloudcms'), 'value' => 'default', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars_product',
				),
		),
	);
	$meta_boxes[] = array(
				'id'         => 'product_post_metabox',
				'title'      => __('Product Video Tab', 'bigcloudcms'),
				'pages'      => array( 'product' ), // Post type
				'context'    => 'normal',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
						'name' => __('Product Video', 'bigcloudcms'),
						'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'bigcloudcms'),
						'id'   => $prefix . 'product_video',
						'type' => 'textarea_code',
					),
		),
	);


			$meta_boxes[] = array(
				'id'         => 'portfolio_metabox',
				'title'      => __('Portfolio Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-portfolio.php' )),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Columns', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => '2', ),
					array( 'name' => __('Five Column', 'bigcloudcms'), 'value' => '5', ),
					array( 'name' => __('Six Column', 'bigcloudcms'), 'value' => '6', ),
				),
			),
			array(
				'name'    => __('Filter?', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_filter',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
                'name' => __('Portfolio Work Types', 'bigcloudcms'),
                'desc' => __('You can have filterable portfolios with one work type if has children', 'bigcloudcms'),
                'id' => $prefix .'portfolio_type',
                'type' => 'imag_select_taxonomy',
                'taxonomy' => 'portfolio-type',
            ),
            array(
				'name'    => __('Order Items By', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_order',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Menu Order', 'bigcloudcms'), 'value' => 'menu_order', ),
					array( 'name' => __('Title', 'bigcloudcms'), 'value' => 'title', ),
					array( 'name' => __('Date', 'bigcloudcms'), 'value' => 'date', ),
					array( 'name' => __('Random', 'bigcloudcms'), 'value' => 'rand', ),
				),
			),
			array(
				'name'    => __('Items per Page', 'bigcloudcms'),
				'desc'    => __('How many portfolio items per page', 'bigcloudcms'),
				'id'      => $prefix . 'portfolio_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name' => __('Crop images to equal height', 'bigcloudcms'),
				'desc' => __('If cropped rows will be equal', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_crop',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					),
			),
			array(
				'name' => __('Set image height if cropping', 'bigcloudcms'),
				'desc' => __('Default is 1:1 ratio (Note: just input number, example: 350)', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_img_crop',
				'type' => 'text_small',
			),
			array(
				'name' => __('Display Item Work Types', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_item_types',
				'type' => 'checkbox',
			),
			array(
				'name' => __('Display Item Excerpt', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_item_excerpt',
				'type' => 'checkbox',
			),
			array(
				'name'    => __('Add Lightbox link in the top right of each item', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_lightbox',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
				
			));
$meta_boxes[] = array(
				'id'         => 'portfolio_metabox',
				'title'      => __('Portfolio Category Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-portfolio-category.php' )),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Columns', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'portfolio_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => '2', ),
					array( 'name' => __('Five Column', 'bigcloudcms'), 'value' => '5', ),
					array( 'name' => __('Six Column', 'bigcloudcms'), 'value' => '6', ),
				),
			),
			array(
				'name'    => __('Items per Page', 'bigcloudcms'),
				'desc'    => __('How many portfolio items per page', 'bigcloudcms'),
				'id'      => $prefix . 'portfolio_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name' => __('Crop images to equal height', 'bigcloudcms'),
				'desc' => __('If cropped rows will be equal', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_crop',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					),
			),
			array(
				'name' => __('Set image height if cropping', 'bigcloudcms'),
				'desc' => __('Default is 1:1 ratio (Note: just input number, example: 350)', 'bigcloudcms'),
				'id'   => $prefix . 'portfolio_img_crop',
				'type' => 'text_small',
			),
			array(
				'name' => __('Display Item Excerpt', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'portfolio_item_excerpt',
				'type' => 'checkbox',
			),
				
	));
	$meta_boxes[] = array(
				'id'         => 'staff_page_metabox',
				'title'      => __('Staff Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-staff-grid.php' )),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name'    => __('Columns', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'staff_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => '2', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => '3', ),
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => '4', ),
				),
			),
			array(
                'name' => __('Limit to Group', 'bigcloudcms'),
                'desc' => '',
                'id' => $prefix .'staff_type',
                'type' => 'imag_select_taxonomy',
                'taxonomy' => 'staff-group',
            ),
            array(
				'name'    => __('Filter?', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'staff_filter',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
			array(
				'name'    => __('Items per Page', 'bigcloudcms'),
				'desc'    => __('How many portfolio items per page', 'bigcloudcms'),
				'id'      => $prefix . 'staff_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name' => __('Crop images to equal height', 'bigcloudcms'),
				'desc' => __('If cropped rows will be equal', 'bigcloudcms'),
				'id'   => $prefix . 'staff_crop',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					),
			),
			array(
				'name' => __('Set image height if cropping', 'bigcloudcms'),
				'desc' => __('Default is 16:9 ratio (Note: just input number, example: 350)', 'bigcloudcms'),
				'id'   => $prefix . 'staff_img_crop',
				'type' => 'text_small',
			),
			array(
				'name' => __('Use Staff Excerpt or Content?', 'bigcloudcms'),
				'id'   => $prefix . 'staff_wordlimit',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Content', 'bigcloudcms'), 'value' => 'false', ),
					array( 'name' => __('Excerpt', 'bigcloudcms'), 'value' => 'true', ),
					),
			),
			array(
				'name' => __('Images and title link?', 'bigcloudcms'),
				'id'   => $prefix . 'staff_single_link',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No, no link', 'bigcloudcms'), 'value' => 'false', ),
					array( 'name' => __('Yes, link to single post', 'bigcloudcms'), 'value' => 'true', ),
					array( 'name' => __('Image link to Lightbox', 'bigcloudcms'), 'value' => 'lightbox', ),
					),
			),
				
			));
			$meta_boxes[] = array(
				'id'         => 'testimonial_page_metabox',
				'title'      => __('Testimonial Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-testimonial-grid.php' )),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name'    => __('Columns', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'testimonial_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => '4', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => '3', ),
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => '2', ),
					array( 'name' => __('One Column', 'bigcloudcms'), 'value' => '1', ),
				),
			),
			array(
				'name'    => __('Orderby', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'testimonial_orderby',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Menu Order', 'bigcloudcms'), 'value' => 'menu_order', ),
					array( 'name' => __('Title', 'bigcloudcms'), 'value' => 'title', ),
					array( 'name' => __('Date', 'bigcloudcms'), 'value' => 'date', ),
					array( 'name' => __('Random', 'bigcloudcms'), 'value' => 'rand', ),
				),
			),
			array(
                'name' => __('Testimonial Group', 'bigcloudcms'),
                'desc' => '',
                'id' => $prefix .'testimonial_type',
                'type' => 'imag_select_taxonomy',
                'taxonomy' => 'testimonial-group',
            ),
			array(
				'name'    => __('Items per Page', 'bigcloudcms'),
				'desc'    => __('How many testimonial items per page', 'bigcloudcms'),
				'id'      => $prefix . 'testimonial_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name' => __('Limit Testimonial Text', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'limit_testimonial',
				'type' => 'checkbox',
				'std'  => '0'
			),
			array(
				'name' => __('Word Count Text', 'bigcloudcms'),
				'desc' => __('eg: 25', 'bigcloudcms'),
				'id'   => $prefix . 'testimonial_word_count',
				'type' => 'text_small',
			),
			array(
				'name' => __('Add link to single post', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'single_testimonial_link',
				'type' => 'checkbox',
				'std'  => '0'
			),
			array(
				'name' => __('Link Text', 'bigcloudcms'),
				'desc' => __('eg: Read More', 'bigcloudcms'),
				'id'   => $prefix . 'testimonial_link_text',
				'type' => 'text_small',
			),				
		));

			
			$meta_boxes[] = array(
				'id'         => 'pagefeature_metabox',
				'title'      => __('Feature Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-feature.php', 'page-feature-sidebar.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Feature Options', 'bigcloudcms'),
				'desc'    => __('If image slider make sure images uploaded are at-least 1170px wide.', 'bigcloudcms'),
				'id'      => $prefix . 'page_head',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Flex Slider', 'bigcloudcms'), 'value' => 'flex', ),
					array( 'name' => __('Carousel Slider', 'bigcloudcms'), 'value' => 'carouselslider', ),
					array( 'name' => __('Image Carousel Slider', 'bigcloudcms'), 'value' => 'carousel', ),
					array( 'name' => __('Revolution Slider', 'bigcloudcms'), 'value' => 'rev', ),
					array( 'name' => __('BigCloudCMS Slider', 'bigcloudcms'), 'value' => 'ktslider', ),
					array( 'name' => __('Cyclone Slider', 'bigcloudcms'), 'value' => 'cyclone', ),
					array( 'name' => __('Video', 'bigcloudcms'), 'value' => 'video', ),
					array( 'name' => __('Image', 'bigcloudcms'), 'value' => 'image', ),
				),
			),
			array(
				'name' => __('If Revolution Slider', 'bigcloudcms'),
				'desc' => __('Paste Revolution slider alias here (example: slider1)', 'bigcloudcms'),
				'id'   => $prefix . 'post_rev',
				'type' => 'text_small',
			),
			array(
				'name' => __('If Cyclone or BigCloudCMS Slider', 'bigcloudcms'),
				'desc' => __('Paste the slider shortcode here (example: [cycloneslider id="slider1"])', 'bigcloudcms'),
				'id'   => $prefix . 'post_cyclone',
				'type' => 'textarea_code',
			),
			array(
				'name' => __('Display Shortcode Slider above Header', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'shortcode_above_header',
				'type' => 'checkbox',
				'std'  => '0'
			),
			array(
				'name' => __('If above Header use arrow', 'bigcloudcms'),
				'desc' => '',
				'id'   => $prefix . 'shortcode_above_header_arrow',
				'type' => 'checkbox',
				'std'  => '0'
			),
			array(
				'name' => __('Max Image/Slider Height', 'bigcloudcms'),
				'desc' => __('Default is: 400 (Note: just input number, example: 350)', 'bigcloudcms'),
				'id'   => $prefix . 'posthead_height',
				'type' => 'text_small',
			),
			array(
				'name' => __("Max Image/Slider Width", 'bigcloudcms' ),
				'desc' => __("Default is: 1140 on fullwidth posts (Note: just input number, example: 650, does not apply to Carousel slider)", 'bigcloudcms' ),
				'id'   => $prefix . 'posthead_width',
				'type' => 'text_small',
			),
			array(
				'name'    => __('Use Lightbox for Feature Image', 'bigcloudcms'),
				'desc'    => __("If feature option is set to image, choose to use lightbox link with image.", 'bigcloudcms' ),
				'id'      => $prefix . 'feature_img_lightbox',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name' => __('If Video Post', 'bigcloudcms'),
				'desc' => __('Place Embed Code Here, works with youtube, vimeo...', 'bigcloudcms'),
				'id'   => $prefix . 'post_video',
				'type' => 'textarea_code',
			),
				
			));
	$meta_boxes[] = array(
				'id'         => 'bloglist_metabox',
				'title'      => __('Blog List Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-blog.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Blog Category', 'bigcloudcms'),
                'desc' => __('Select all blog posts or a specific category to show', 'bigcloudcms'),
                'id' => $prefix .'blog_cat',
                'type' => 'imag_select_category',
                'taxonomy' => 'category',
            ),
			array(
				'name'    => __('How Many Posts Per Page', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'blog_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name'    => __('Display Post Content as:', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'blog_summery',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Summary', 'bigcloudcms'), 'value' => 'summery', ),
					array( 'name' => __('Full', 'bigcloudcms'), 'value' => 'full', ),
				),
			),
			array(
				'name' => __('Display Sidebar?', 'bigcloudcms'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'bigcloudcms'),
				'id'   => $prefix . 'page_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));
			$meta_boxes[] = array(
				'id'         => 'bloggrid_metabox',
				'title'      => __('Blog Grid Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-blog-grid.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Blog Category', 'bigcloudcms'),
                'desc' => __('Select all blog posts or a specific category to show', 'bigcloudcms'),
                'id' => $prefix .'blog_cat',
                'type' => 'imag_select_category',
                'taxonomy' => 'category',
            ),
			array(
				'name'    => __('How Many Posts Per Page', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'blog_items',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('All', 'bigcloudcms'), 'value' => 'all', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
				),
			),
			array(
				'name'    => __('Choose Column Layout:', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'blog_columns',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Four Column', 'bigcloudcms'), 'value' => 'fourcolumn', ),
					array( 'name' => __('Three Column', 'bigcloudcms'), 'value' => 'threecolumn', ),
					array( 'name' => __('Two Column', 'bigcloudcms'), 'value' => 'twocolumn', ),
				),
			),
			array(
				'name' => __('Display Sidebar?', 'bigcloudcms'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'bigcloudcms'),
				'id'   => $prefix . 'page_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),			
			));
			$meta_boxes[] = array(
				'id'         => 'contact_metabox',
				'title'      => __('Contact Page Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array('key' => 'page-template', 'value' => array( 'page-contact.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
                'name' => __('Use Contact Form', 'bigcloudcms'),
                'desc' => '',
                'id' => $prefix .'contact_form',
                'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name' => __('Contact Form Title', 'bigcloudcms'),
				'desc' => __('ex. Send us an Email', 'bigcloudcms'),
				'id'   => $prefix . 'contact_form_title',
				'type' => 'text',
			),
			array(
                'name' => __('Use Simple Math Question', 'bigcloudcms'),
                'desc' => 'Adds a simple math question to form.',
                'id' => $prefix .'contact_form_math',
                'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
                'name' => __('Use Map', 'bigcloudcms'),
                'desc' => '',
                'id' => $prefix .'contact_map',
                'type'    => 'select',
				'options' => array(
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
				),
			),
			array(
				'name' => __('Address', 'bigcloudcms'),
				'desc' => __('Enter your Location', 'bigcloudcms'),
				'id'   => $prefix . 'contact_address',
				'type' => 'text',
			),
			array(
				'name'    => __('Map Type', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'contact_maptype',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('ROADMAP', 'bigcloudcms'), 'value' => 'ROADMAP', ),
					array( 'name' => __('HYBRID', 'bigcloudcms'), 'value' => 'HYBRID', ),
					array( 'name' => __('TERRAIN', 'bigcloudcms'), 'value' => 'TERRAIN', ),
					array( 'name' => __('SATELLITE', 'bigcloudcms'), 'value' => 'SATELLITE', ),
				),
			),
			array(
				'name' => __('Map Zoom Level', 'bigcloudcms'),
				'desc' => __('A good place to start is 15', 'bigcloudcms'),
				'id'   => $prefix . 'contact_zoom',
				'std'  => '15',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('1 (World View)', 'bigcloudcms'), 'value' => '1', ),
					array( 'name' => '2', 'value' => '2', ),
					array( 'name' => '3', 'value' => '3', ),
					array( 'name' => '4', 'value' => '4', ),
					array( 'name' => '5', 'value' => '5', ),
					array( 'name' => '6', 'value' => '6', ),
					array( 'name' => '7', 'value' => '7', ),
					array( 'name' => '8', 'value' => '8', ),
					array( 'name' => '9', 'value' => '9', ),
					array( 'name' => '10', 'value' => '10', ),
					array( 'name' => '11', 'value' => '11', ),
					array( 'name' => '12', 'value' => '12', ),
					array( 'name' => '13', 'value' => '13', ),
					array( 'name' => '14', 'value' => '14', ),
					array( 'name' => '15', 'value' => '15', ),
					array( 'name' => '16', 'value' => '16', ),
					array( 'name' => '17', 'value' => '17', ),
					array( 'name' => '18', 'value' => '18', ),
					array( 'name' => '19', 'value' => '19', ),
					array( 'name' => '20', 'value' => '20', ),
					array( 'name' => __('21 (Street View)', 'bigcloudcms'), 'value' => '21', ),
					),
			),
			array(
				'name' => __('Map Height', 'bigcloudcms'),
				'desc' => __('Default is 300', 'bigcloudcms'),
				'id'   => $prefix . 'contact_mapheight',
				'type' => 'text_small',
			),
			array(
				'name' => __('Address Two', 'bigcloudcms'),
				'desc' => __('Enter your Location', 'bigcloudcms'),
				'id'   => $prefix . 'contact_address2',
				'type' => 'text',
			),
			array(
				'name' => __('Address Three', 'bigcloudcms'),
				'desc' => __('Enter a Location', 'bigcloudcms'),
				'id'   => $prefix . 'contact_address3',
				'type' => 'text',
			),
			array(
				'name' => __('Address Four', 'bigcloudcms'),
				'desc' => __('Enter a Location', 'bigcloudcms'),
				'id'   => $prefix . 'contact_address4',
				'type' => 'text',
			),
			array(
				'name' => __('Map Center', 'bigcloudcms'),
				'desc' => __('Enter a Location', 'bigcloudcms'),
				'id'   => $prefix . 'contact_map_center',
				'type' => 'text',
			),
				
			));
			$meta_boxes[] = array(
				'id'         => 'staff_sidebar',
				'title'      => __('Sidebar Options', 'bigcloudcms'),
				'pages'      => array( 'staff' ), // Post type
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			array(
				'name' => __('Display Sidebar?', 'bigcloudcms'),
				'desc' => __('Choose if layout is fullwidth or sidebar', 'bigcloudcms'),
				'id'   => $prefix . 'post_sidebar',
				'type'    => 'select',
				'options' => array(
					array( 'name' => __('Yes', 'bigcloudcms'), 'value' => 'yes', ),
					array( 'name' => __('No', 'bigcloudcms'), 'value' => 'no', ),
				),
			),
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));
			$meta_boxes[] = array(
				'id'         => 'page_sidebar',
				'title'      => __('Sidebar Options', 'bigcloudcms'),
				'pages'      => array( 'page' ), // Post type
				'show_on' => array( 'key' => 'page-template', 'value' => array('page-sidebar.php','page-feature-sidebar.php')),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => true, // Show field names on the left
				'fields' => array(
			
			array(
				'name'    => __('Choose Sidebar', 'bigcloudcms'),
				'desc'    => '',
				'id'      => $prefix . 'sidebar_choice',
				'type'    => 'imag_select_sidebars',
				),
				
			));
	global $bigcloudcms_premium;		
	if(isset($bigcloudcms_premium['seo_switch']) && $bigcloudcms_premium['seo_switch'] == '1') {
	$meta_boxes[] = array(
				'id'         => 'seo_metabox',
				'title'      => __('SEO Options', 'bigcloudcms'),
				'pages'      => array( 'page', 'post' ), // Post type
				'context'    => 'normal',
				'priority'   => 'core',
				'show_names' => true, // Show field names on the left
				'fields' => array(
				array(
						'name' => __('Page Title', 'bigcloudcms'),
						'desc' => __('Optimal Format: Brand Name | Primary Keyword and Secondary Keyword', 'bigcloudcms'),
						'id'   => $prefix . 'seo_title',
						'type' => 'text',
					),
					array(
						'name' => __('Page Description', 'bigcloudcms'),
						'desc' => __('Optimal Length: Roughly 155 Characters', 'bigcloudcms'),
						'id'   => $prefix . 'seo_description',
						'type' => 'textarea_small',
					),
				)
			);
		}
	if(isset($bigcloudcms_premium['custom_tab_01']) && $bigcloudcms_premium['custom_tab_01'] == '1') {
	$meta_boxes[] = array(
				'id'         => 'kad_custom_tab_01',
				'title'      => __( "BigCloudCMS Custom Tab 01", 'bigcloudcms' ),
				'pages'      => array( 'product', ), // Post type
				'context'    => 'normal',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields' => array(
					array(
						'name' => __( "Tab Title", 'bigcloudcms' ),
						'desc' => __( "This will show on the tab", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_title_01',
						'type' => 'text',
					),
					array(
						'name'    => __( 'Tab Content', 'bigcloudcms' ),
						'desc'    => __( 'Add Tab Content', 'bigcloudcms' ),
						'id'      => $prefix . 'tab_content_01',
						'type'    => 'wysiwyg',
						'options' => array( 'textarea_rows' => 5,),
					),
					array(
						'name' => __( "Tab priority", 'bigcloudcms' ),
						'desc' => __( "This will determine where the tab is shown (e.g. 20)", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_priority_01',
						'type' => 'text_small',
					),
				)

			);
	}
	if(isset($bigcloudcms_premium['custom_tab_02']) && $bigcloudcms_premium['custom_tab_02'] == '1') {
	$meta_boxes[] = array(
				'id'         => 'kad_custom_tab_02',
				'title'      => __( "BigCloudCMS Custom Tab 02", 'bigcloudcms' ),
				'pages'      => array( 'product', ), // Post type
				'context'    => 'normal',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields' => array(
					array(
						'name' => __( "Tab Title", 'bigcloudcms' ),
						'desc' => __( "This will show on the tab", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_title_02',
						'type' => 'text',
					),
					array(
						'name'    => __( 'Tab Content', 'bigcloudcms' ),
						'desc'    => __( 'Add Tab Content', 'bigcloudcms' ),
						'id'      => $prefix . 'tab_content_02',
						'type'    => 'wysiwyg',
						'options' => array( 'textarea_rows' => 5, ),
					),
					array(
						'name' => __( "Tab priority", 'bigcloudcms' ),
						'desc' => __( "This will determine where the tab is shown (e.g. 20)", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_priority_02',
						'type' => 'text_small',
					),
				)

			);
	}
	if(isset($bigcloudcms_premium['custom_tab_03']) && $bigcloudcms_premium['custom_tab_03'] == '1') {
	$meta_boxes[] = array(
				'id'         => 'kad_custom_tab_03',
				'title'      => __( "BigCloudCMS Custom Tab 03", 'bigcloudcms' ),
				'pages'      => array( 'product', ), // Post type
				'context'    => 'normal',
				'priority'   => 'default',
				'show_names' => true, // Show field names on the left
				'fields' => array(
					array(
						'name' => __( "Tab Title", 'bigcloudcms' ),
						'desc' => __( "This will show on the tab", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_title_03',
						'type' => 'text',
					),
					array(
						'name'    => __( 'Tab Content', 'bigcloudcms' ),
						'desc'    => __( 'Add Tab Content', 'bigcloudcms' ),
						'id'      => $prefix . 'tab_content_03',
						'type'    => 'wysiwyg',
						'options' => array( 'textarea_rows' => 5, ),
					),
					array(
						'name' => __( "Tab priority", 'bigcloudcms' ),
						'desc' => __( "This will determine where the tab is shown (e.g. 20)", 'bigcloudcms' ),
						'id'   => $prefix . 'tab_priority_03',
						'type' => 'text_small',
					),
				)

			);
	}

	return $meta_boxes;
}

add_action( 'init', 'initialize_showcase_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function initialize_showcase_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'cmb/init.php';

}