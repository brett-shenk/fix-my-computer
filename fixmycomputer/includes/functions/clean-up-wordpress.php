<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Cleaning up Wordpress Junk
**/

# List all style and js resources. Spits out the handle + src
// add_action( 'wp_print_scripts', 'shenk_list_scripts', 999 );
// add_action( 'wp_print_styles', 'shenk_list_styles', 999 );
// add_action( 'wp_head', 'sh_enqueued_resources');

// This cleans up  wp_head()  function
add_action( 'wp_enqueue_scripts', function(){

	# Remove resources from WooCommerce
	if(class_exists('woocommerce')){
        wp_dequeue_style( 'wc-blocks-vendors-style' );      # Block styles
		wp_dequeue_style( 'wc-blocks-style' );              # Block styles

        wp_dequeue_style('photoswipe');  					# Photoswipe
        wp_dequeue_script('photoswipe'); 					# Photoswipe
        wp_dequeue_style('photoswipe-default-skin');		# Photoswipe Skin
        wp_dequeue_script('photoswipe-ui-default');			# Photoswipe Skin
        wp_dequeue_script('flexslider');					# Photo Slider

		# Make sure the required woocommerce scripts only load on the required pages
		if ( !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) {
			wp_dequeue_script('wc-single-product');
			wp_dequeue_script('wc-add-to-cart-variation');
			wp_dequeue_script('wc-add-to-cart');
			wp_dequeue_script('jquery-blockui');
			wp_dequeue_script('woocommerce');					# Dependencies: jquery, jquery-blockui, js-cookie
			wp_dequeue_script('js-cookie');						# Cookies
			wp_dequeue_script('select2');						# Form Drop Down
			wp_dequeue_script('selectWoo');						# Form Drop Down
			wp_dequeue_style('select2');						# Form Drop Down
		 	wp_dequeue_script('zoom');  						# Product Zoom
		}
		if ( !is_cart() && !is_checkout() && !is_account_page() ) {
			wp_dequeue_script('wc-cart-fragments');           	# Dynamic Ajax for the mini cart
		}
	}

	# Removes Gutenberg Block CSS Library
	wp_dequeue_style( 'wp-block-library' ); 				# WordPress core
	wp_dequeue_style( 'wp-block-library-theme' );			# WordPress core

	if (!is_user_logged_in()) {
        wp_dequeue_style( 'dashicons' );
    }
	
	# Remove EditURI
	remove_action ('wp_head', 'rsd_link');

	# Remove Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link');

	# Remove the general feeds
	remove_action( 'wp_head', 'feed_links', 2 );

	# Remove the extra feeds, such as category feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	# Remove the displayed XHTML generator
	remove_action( 'wp_head', 'wp_generator' );

	# Remove rel next/prev links
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	
	# Remove shortlink
	remove_action( 'wp_head', 'wp_shortlink_wp_head');

	# Removes WordPress DNS Prefetch
	add_filter( 'emoji_svg_url', '__return_false' );

	# Remove dns-prefetch
    // remove_action( 'wp_head', 'wp_resource_hints', 2 );
}, 100 );

# Remove JQuery migrate
add_action('wp_default_scripts', 'shenk_jquery_migrate');
function shenk_jquery_migrate($scripts){
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
		// Check whether the script has any dependencies
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}

// Site Health API
add_filter( 'site_status_tests', 'prefix_remove_php_test' );
function prefix_remove_php_test( $tests ) {
	unset( $tests['direct']['theme_version'] );
	return $tests;
}


/**
 * Clean Up The Menus
**/

# Outputs all menu items to help organize the admin
// add_action( 'admin_menu', 'all_admin_links', 999 );
function all_admin_links(){
	global $submenu;
	echo "<pre>";
	var_dump( $submenu );
	echo "</pre>";
	echo "<style>#wpwrap { display: none!important; }</style>";
}


add_action( 'admin_menu', function(){
	/*****************************************************
	 * 					How To Reorganize
	add_menu_page(
		'page-title',					Required, the text to be displayed in the title tags of the page
		'Pages',						Menu title text
		'manage_options',				Capability
		'edit.php?post_type=page',		Menu slug
		null,							Callback function
		'dashicons-admin-page',			The icon
		4.1								Position
	);
	*****************************************************/

	# Pages
	remove_menu_page( 'edit.php?post_type=page' );
	add_menu_page('page-title', 'Pages', 'manage_options', 'edit.php?post_type=page', null, 'dashicons-admin-page', 4);

	# Appearance
	remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode( $_SERVER['REQUEST_URI'] ) );	// Fallback method only
	remove_submenu_page( 'themes.php', 'theme-editor.php' );												// Theme Editor
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );												// Plugin editor


	# Tools
	remove_submenu_page( 'tools.php', 'tools.php' );
	if( current_user_can('administrator') ){
		add_submenu_page('index.php', 'About WordPress', 'About WordPress', 'manage_options', 'about.php', null, 5);
	}

	# Settings
	remove_submenu_page( 'options-general.php', 'options-writing.php' );		// Writing
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );		// Discussion
	remove_submenu_page( 'options-general.php', 'options-media.php' );			// Media

	# Meta box Removals
	remove_meta_box( 'authordiv', 'page', 'normal' );			// author
}, 999 );


# Completely remove Editor and customize
add_action( 'admin_menu', function () {
	global $submenu;
	if ( isset( $submenu[ 'themes.php' ] ) ) {
		foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
			foreach ($menu_item as $value) {
				if (strpos($value,'customize') !== false) {
					unset( $submenu[ 'themes.php' ][ $index ] );
				}
			}
		}
	}
});
add_action( 'wp_before_admin_bar_render', function() {
	/*******************************************
	 * 	                How To Use
	 * Inspect the horizontal admin bar and find the LI
	 * item. The ID is what your looking for, just drop
	 * this part of the ID to remove that menu item.
	 * 		wp-admin-bar-
	*******************************************/
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('themes');				// Themes
	$wp_admin_bar->remove_menu('customize');			// Customize
	$wp_admin_bar->remove_menu('wp-logo');				// WP Logo
	// $wp_admin_bar->remove_menu('widgets');			// Widgets
	$wp_admin_bar->remove_menu('new-post');				// New Post
	$wp_admin_bar->remove_menu( 'new-user' );         	// New User
	$wp_admin_bar->remove_menu( 'new-media' );         	// New Media
});


/**
 * Other Clean Up
**/

# Disables Gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);

# Disables Gutenberg for widgets
add_filter( 'use_widgets_block_editor', '__return_false', 11 );


# Remove theme features
add_action('after_setup_theme',	function () {
	remove_theme_support( 'custom-background' );
	remove_theme_support( 'custom-header' );
}, 11 );

# Remove dashboard widgets
add_action( 'admin_init', function() {
    remove_action( 'welcome_panel', 'wp_welcome_panel' );					// Welcome panel
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );			// WordPress News
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );		// Quick Draft
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');			// Activity
});


/**
 * Media Library
**/

// Remove actions from Media Upload. Does not disable it completely
add_filter( 'media_view_strings', function ($strings){
	$strings['createGalleryTitle']       = null; 		    // Remove "Create gallery" button
	$strings['createPlaylistTitle']      = null; 		    // Remove "Create Audio Playlist" button
	$strings['createVideoPlaylistTitle'] = null; 		    // Remove "Create Video Playlist" button
	// $strings['insertFromUrlTitle']       = null; 		// Remove "Insert from URL" button

	return $strings;
});

// Hide input fields when uploading or editing media
add_action('admin_print_scripts', function(){ ?>
    <style>
	/* .attachment-details .setting[data-setting="caption"],       	<?php // Media caption ?> */
	.attachment-details .setting[data-setting="description"],		<?php // Media description ?>
	.attachment-details .setting[data-setting="artist"],    		<?php // Audio artist ?>
	.attachment-details .setting[data-setting="album"],         	<?php // Audio album ?>
    .media-types-required-info
	{
		display: none;
	}
	.attachments-browser .compat-field-enable-media-replace .help	<?php // Media Replacer ?>
	{
		visibility: hidden;
    	margin: 0;
	}
	.attachments-browser .compat-attachment-fields tr td:not([class]):first-of-type 	<?php // Rank Math  ?>
	{
		min-width: 30%;
		margin-right: 4%;
		float: left;
		text-align: right;
		padding: 1.3em 0;
	}
	</style>
<?php 
});


/**
 * User Profile Page
**/

# Remove social contact methods
add_filter('user_contactmethods', function( $contact_methods ){
	unset( $contact_methods['facebook'] );
	unset( $contact_methods['pinterest'] );
	unset( $contact_methods['wikipedia'] );
	unset( $contact_methods['instagram'] );
	unset( $contact_methods['soundcloud'] );
	unset( $contact_methods['tumblr'] );
	unset( $contact_methods['twitter'] );
	unset( $contact_methods['linkedin'] );
	unset( $contact_methods['youtube'] );
	unset( $contact_methods['myspace'] );

	return $contact_methods;
});

/**
 * @link https://developer.wordpress.org/reference/hooks/admin_print_scripts-hook_suffix/
 *
 * Syntax Highlighting 	- .user-syntax-highlighting-wrap
 * Keyboard Short 		- .user-comment-shortcuts-wrap
 * Website 				- .user-url-wrap
 * Biographical Info 	- .user-description-wrap
*/
if( !function_exists( 'syn_hide_profile_fields' )){
	function syn_hide_profile_fields() { ?>
		<style>
		.user-url-wrap,
		.user-syntax-highlighting-wrap,
		.user-comment-shortcuts-wrap,
		.user-description-wrap {
			display: none;
		}
		</style>
		<?php
	}
	add_action('admin_init', function() {
			add_action( 'admin_print_scripts-profile.php', 'syn_hide_profile_fields' );
			add_action( 'admin_print_scripts-user-edit.php', 'syn_hide_profile_fields' );
		}
	);
}


/**
 * Remove All WP Emojicons
**/
function stupid_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}
function stupid_emojis() {
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	add_filter( 'tiny_mce_plugins', 'stupid_emojis_tinymce' );
}
add_action( 'init', 'stupid_emojis' );
