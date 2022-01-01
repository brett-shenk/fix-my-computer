<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Theme Styles & Scripts
 * 
 * WordPress Built-in Scripts + Handles
 * https://developer.wordpress.org/reference/functions/wp_enqueue_script/#default-scripts-and-js-libraries-included-and-registered-by-wordpress
**/

add_action( 'wp_enqueue_scripts', 'shenk_styles', 99);
function shenk_styles(){
    # Google Fonts          - Loads in header.php
    # Slick Slider          - Loads in theme.scss

    # Register styles for later use
    wp_register_style('alert-bar', STYLE_DIR . '/assets/dist/css/alert-bar.min.css', false, 1, false);
    wp_register_style('theme', STYLE_DIR . '/assets/dist/css/theme.min.css', false, 1, false);

    # Enqueue styles
    wp_enqueue_style('theme');

	wp_dequeue_style('contact-form-7');
}

add_action( 'wp_enqueue_scripts', 'shenk_register_scripts', 99);
function shenk_register_scripts(){
    # Slick Slider          - loads from vendor.min.js
    # jquery-maskedinput    - loads from vendor.min.js
    
    # Register scripts for later use
    wp_register_script('alert-bar', STYLE_DIR . '/assets/dist/js/alert-bar.min.js', array('jquery'), 1, true);
    wp_register_script('global', STYLE_DIR . '/assets/dist/js/global.min.js', array('jquery'), 1, false );
    wp_register_script('vendor', STYLE_DIR . '/assets/dist/js/vendor.min.js', array('jquery'), 1, true);
    wp_register_script('main', STYLE_DIR . '/assets/dist/js/theme.min.js', array('jquery', 'vendor'), 1, true );

    # Enqueue scripts
    wp_enqueue_script('vendor');
    wp_enqueue_script('main');
    wp_enqueue_script('global');
}


/**
 * Admin Resources Including the Login
**/
add_action( 'admin_enqueue_scripts', 'shenk_enqueue_admin_scripts' );
function shenk_enqueue_admin_scripts( $hook_suffix ){
    wp_enqueue_style('admin', STYLE_DIR . '/assets/dist/css/admin.min.css', false, 1, 'all');
}

add_action( 'login_enqueue_scripts', 'shenk_enqueue_login_scripts' );
function shenk_enqueue_login_scripts(){
    wp_enqueue_style('login-styles', STYLE_DIR . '/assets/dist/css/login-styles.min.css');
}

add_action( 'login_enqueue_scripts', function(){
	if ( function_exists( 'get_field' ) ) {
		$logo = get_field('mobile_logo', 'options');
	}
	if ( $logo != '' ){ ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo $logo['url']; ?>);
                height: <?php echo $logo['height']; ?>px;
			}
		</style>
	<?php }
});

# Login Logo URL
add_filter( 'login_headerurl', 'shenk_custom_login_url', 10, 1 );
function shenk_custom_login_url( $url ){
    return esc_url( home_url( '/' ) );
}

# Login Site Name
add_filter( 'login_headertitle', 'shenk_login_logo_title' );
function shenk_login_logo_title(){
    return get_bloginfo( 'name' );
}

# Add HTML to the bottom of WP login 
// add_action( 'login_footer', function(){
// }, 10 );


# style.css
add_filter('stylesheet_uri', 'shenk_stylesheet_uri');
function shenk_stylesheet_uri($stylesheet_uri){
    return $stylesheet_uri;
}

# List all style and js resources. Spits out the handle + src
// add_action( 'wp_print_scripts', 'shenk_list_scripts', 999 );
// add_action( 'wp_print_styles', 'shenk_list_styles', 999 );
// add_action( 'wp_head', 'sh_enqueued_resources');
