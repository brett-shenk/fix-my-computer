<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Images
**/

// Default sizes
update_option( 'thumbnail_size_w', 150 );
update_option( 'thumbnail_size_h', 150 );

update_option( 'medium_size_w', 300 );
update_option( 'medium_size_h', 300 );

update_option( 'medium_large_size_w', 768 );
update_option( 'medium_large_size_h', 9999 );

update_option( 'large_size_w', 1024 );
update_option( 'large_size_h', 1024 );

// Remove some sizes
add_action('init', 'remove_image_sizes');
function remove_image_sizes() {
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
}

# Disable scaled image size 2560px
add_filter('big_image_size_threshold', '__return_false');


/**
 * Custom image sizes
 * 
 * Ex: Hard Crop            add_image_size( 'page_banner', 1920, 600, true );
 * Ex: Soft Crop            add_image_size( 'page_banner', 1920, 600 );
 * Ex: Unlimited Height     add_image_size( 'page_banner', 1920, 9999 );
**/
add_image_size( 'page-banner', 1900, 600, true );
add_image_size( 'service-block', 450, 450, true );


// Register image sizes proper names
add_filter( 'image_size_names_choose', 'shenk_custom_sizes' );
function shenk_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'page-banner'       => __( 'Page Banner' ),
        'service-block'     => __( 'Service Block' ),
    ) );
}
