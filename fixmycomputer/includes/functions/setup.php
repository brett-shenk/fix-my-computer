<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

// Includes
include_once get_template_directory() . '/includes/layout/header.php';
include_once get_template_directory() . '/includes/layout/footer.php';


/**
 * Theme Setup
**/

# Remove Edit Link
add_filter( 'edit_post_link', '__return_false' );

# HTML5
add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
));

# Menu Support
add_theme_support('menus');

# Title Tags
add_theme_support('title-tag');

# Set width of iframes
if(!isset($content_width)){ $content_width = 600; }

# Disable Editor on...
add_action('init', 'my_rem_editor_from_post_type');
function my_rem_editor_from_post_type(){
	remove_post_type_support('page', 'editor');         // Page
    remove_post_type_support('sh_slide', 'editor');     // Home Slider
}


/**
 * Default Post Setup
**/

# The excerpt
add_post_type_support('page', 'excerpt');
add_filter('get_the_excerpt', function($post_excerpt, $post){
    return wp_trim_words( $post_excerpt, 40 );
}, 10, 2);

# Post Thumbnail
// add_theme_support('post-thumbnails');
// set_post_thumbnail_size(1200, 9999);

# Remove post thumbnail from...
// add_action('init','remove_thumbnail_support');
// function remove_thumbnail_support(){
//     remove_post_type_support('page','thumbnail');
// }

add_action( 'admin_menu', function(){
    
    # Clean up the admin left sidebar
	remove_menu_page( 'edit.php' );                                             // default post
    // remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');      // category post
    // remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');      // taxonomy post

    # Default post type
    register_post_type('post', [
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);

    # The category taxonomy from post
    register_taxonomy('category', 'post', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);

    # The tag taxonomy from post
    register_taxonomy('post_tag', 'post', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);
}, 998 );
