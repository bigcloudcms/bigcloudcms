<?php
// Custom post types
function bigcloudcms_portfolio_post_init() {
  $portfoliolabels = array(
    'name' =>  __('Portfolio', 'bigcloudcms'),
    'singular_name' => __('Portfolio Item', 'bigcloudcms'),
    'add_new' => __('Add New', 'bigcloudcms'),
    'add_new_item' => __('Add New Portfolio Item', 'bigcloudcms'),
    'edit_item' => __('Edit Portfolio Item', 'bigcloudcms'),
    'new_item' => __('New Portfolio Item', 'bigcloudcms'),
    'all_items' => __('All Portfolio', 'bigcloudcms'),
    'view_item' => __('View Portfolio Item', 'bigcloudcms'),
    'search_items' => __('Search Portfolio', 'bigcloudcms'),
    'not_found' =>  __('No Portfolio Item found', 'bigcloudcms'),
    'not_found_in_trash' => __('No Portfolio Items found in Trash', 'bigcloudcms'),
    'parent_item_colon' => '',
    'menu_name' => __('Portfolio', 'bigcloudcms')
  );

  $portargs = array(
    'labels' => $portfoliolabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite'  => false,
    //'rewrite'  => array( 'slug' => 'portfolio' ), /* you can specify its url slug */
    'has_archive' => false, 
    'capability_type' => 'post', 
    'hierarchical' => false,
    'menu_position' => 8,
    'menu_icon' => 'dashicons-format-gallery',
    'supports' => array( 'title', 'excerpt', 'editor', 'author', 'page-attributes', 'thumbnail', 'comments' )
  ); 
  // Initialize Taxonomy Labels
    $typelabels = array(
        'name' => __( 'Portfolio Type', 'bigcloudcms' ),
        'singular_name' => __( 'Type', 'bigcloudcms' ),
        'search_items' =>  __( 'Search Type', 'bigcloudcms' ),
        'all_items' => __( 'All Type', 'bigcloudcms' ),
        'parent_item' => __( 'Parent Type', 'bigcloudcms' ),
        'parent_item_colon' => __( 'Parent Type:', 'bigcloudcms' ),
        'edit_item' => __( 'Edit Type', 'bigcloudcms' ),
        'update_item' => __( 'Update Type', 'bigcloudcms' ),
        'add_new_item' => __( 'Add New Type', 'bigcloudcms' ),
        'new_item_name' => __( 'New Type Name', 'bigcloudcms' ),
    );
    $portfolio_type_slug = apply_filters('bigcloudcms_portfolio_type_slug', 'portfolio-type');
    // Register Custom Taxonomy
    register_taxonomy('portfolio-type',array('portfolio'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $typelabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $portfolio_type_slug )
    ));
    $taglabels = array(
        'name' => __( 'Portfolio Tags', 'bigcloudcms' ),
        'singular_name' => __( 'Tags', 'bigcloudcms' ),
        'search_items' =>  __( 'Search Tags', 'bigcloudcms' ),
        'all_items' => __( 'All Tag', 'bigcloudcms' ),
        'parent_item' => __( 'Parent Tag', 'bigcloudcms' ),
        'parent_item_colon' => __( 'Parent Tag:', 'bigcloudcms' ),
        'edit_item' => __( 'Edit Tag', 'bigcloudcms' ),
        'update_item' => __( 'Update Tag', 'bigcloudcms' ),
        'add_new_item' => __( 'Add New Tag', 'bigcloudcms' ),
        'new_item_name' => __( 'New Tag Name', 'bigcloudcms' ),
    );
    $portfolio_tag_slug = apply_filters('bigcloudcms_portfolio_tag_slug', 'portfolio-tag');
    // Register Custom Taxonomy
    register_taxonomy('portfolio-tag',array('portfolio'), array(
        'hierarchical' => false,
        'labels' => $taglabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $portfolio_tag_slug )
    ));

  register_post_type( 'portfolio', $portargs );
}
add_action( 'init', 'bigcloudcms_portfolio_post_init', 1 );
    
function testimonial_post_init() {
  $testlabels = array(
    'name' =>  __('Testimonials', 'bigcloudcms'),
    'singular_name' => __('Testimonial', 'bigcloudcms'),
    'add_new' => __('Add New', 'bigcloudcms'),
    'add_new_item' => __('Add New Testimonial', 'bigcloudcms'),
    'edit_item' => __('Edit Testimonial', 'bigcloudcms'),
    'new_item' => __('New Testimonial', 'bigcloudcms'),
    'all_items' => __('All Testimonials', 'bigcloudcms'),
    'view_item' => __('View Testimonial', 'bigcloudcms'),
    'search_items' => __('Search Testimonials', 'bigcloudcms'),
    'not_found' =>  __('No Testimonials found', 'bigcloudcms'),
    'not_found_in_trash' => __('No Testimonials found in Trash', 'bigcloudcms'),
    'parent_item_colon' => '',
    'menu_name' => __('Testimonials', 'bigcloudcms')
  );
  $testimonial_post_slug = apply_filters('bigcloudcms_testimonial_post_slug', 'testimonial');
  $testargs = array(
    'labels' => $testlabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => $testimonial_post_slug ),
    'capability_type' => 'post',
    'has_archive' => false,  
    'hierarchical' => false,
    'menu_position' => 22,
    'menu_icon' => 'dashicons-id',
    'supports' => array( 'title', 'excerpt', 'editor', 'page-attributes', 'thumbnail' )
  ); 
  // Initialize Taxonomy Labels
    $taxlabels = array(
        'name' => __( 'Testimonial Group', 'bigcloudcms' ),
        'singular_name' => __( 'Testimonials', 'bigcloudcms' ),
        'search_items' =>  __( 'Search Groups', 'bigcloudcms' ),
        'all_items' => __( 'All Groups', 'bigcloudcms' ),
        'parent_item' => __( 'Parent Groups', 'bigcloudcms' ),
        'parent_item_colon' => __( 'Parent Groups:', 'bigcloudcms' ),
        'edit_item' => __( 'Edit Group', 'bigcloudcms' ),
        'update_item' => __( 'Update Group', 'bigcloudcms' ),
        'add_new_item' => __( 'Add New Group', 'bigcloudcms' ),
        'new_item_name' => __( 'New Group Name', 'bigcloudcms' ),
    );
    $testimonial_group_slug = apply_filters('bigcloudcms_testimonial_group_slug', 'testimonial-group');
    // Register Custom Taxonomy
    register_taxonomy('testimonial-group',array('testimonial'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $taxlabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $testimonial_group_slug )
    ));

  register_post_type( 'testimonial', $testargs );
}
add_action( 'init', 'testimonial_post_init' );

function staff_post_init() {
  $stafflabels = array(
    'name' =>  __('Staff', 'bigcloudcms'),
    'singular_name' => __('Staff', 'bigcloudcms'),
    'add_new' => __('Add New', 'bigcloudcms'),
    'add_new_item' => __('Add New Staff', 'bigcloudcms'),
    'edit_item' => __('Edit Staff', 'bigcloudcms'),
    'new_item' => __('New Staff', 'bigcloudcms'),
    'all_items' => __('All Staff', 'bigcloudcms'),
    'view_item' => __('View Staff', 'bigcloudcms'),
    'search_items' => __('Search Staff', 'bigcloudcms'),
    'not_found' =>  __('No Staff found', 'bigcloudcms'),
    'not_found_in_trash' => __('No Staff found in Trash', 'bigcloudcms'),
    'parent_item_colon' => '',
    'menu_name' => __('Staff', 'bigcloudcms')
  );
  $staff_post_slug = apply_filters('bigcloudcms_staff_post_slug', 'staff');
  $staffargs = array(
    'labels' => $stafflabels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => $staff_post_slug ),
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false,
    'menu_position' => 23,
    'menu_icon' => 'dashicons-businessman',
    'supports' => array( 'title', 'excerpt', 'editor', 'page-attributes', 'thumbnail' )
  ); 
  // Initialize Taxonomy Labels
    $grouplabels = array(
        'name' => __( 'Staff Group', 'bigcloudcms' ),
        'singular_name' => __( 'Staff', 'bigcloudcms' ),
        'search_items' =>  __( 'Search Groups', 'bigcloudcms' ),
        'all_items' => __( 'All Groups', 'bigcloudcms' ),
        'parent_item' => __( 'Parent Groups', 'bigcloudcms' ),
        'parent_item_colon' => __( 'Parent Groups:', 'bigcloudcms' ),
        'edit_item' => __( 'Edit Group', 'bigcloudcms' ),
        'update_item' => __( 'Update Group', 'bigcloudcms' ),
        'add_new_item' => __( 'Add New Group', 'bigcloudcms' ),
        'new_item_name' => __( 'New Group Name', 'bigcloudcms' ),
    );
    $staff_group_slug = apply_filters('bigcloudcms_staff_group_slug', 'staff-group');
    // Register Custom Taxonomy
    register_taxonomy('staff-group',array('staff'), array(
        'hierarchical' => true, // define whether to use a system like tags or categories
        'labels' => $grouplabels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite'  => array( 'slug' => $staff_group_slug )
    ));

  register_post_type( 'staff', $staffargs );
}
add_action( 'init', 'staff_post_init' );

