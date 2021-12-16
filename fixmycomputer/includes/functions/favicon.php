<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Favicon
 * @link        http://realfavicongenerator.net/
 * 
 * Progressive Web App Support
 * 
 * @todo        Download and Install the plugin  Progressive WordPress (PWA)
 * @link        https://wordpress.org/plugins/progressive-wp/
 * 
 * @internal    After configuring the plugin and adding the site's favicon through the customizer... Unfortunately,
 *              this is how it adds icons so no maskable icon can be added unless the default one is that you upload.
 *              It wants a 512 image uploaded. To prevent duplicate data being loaded delete the following files:
 * 
 * @todo        site.webmanifest
 *              msapplication-*
 *              apple-touch-icon
 *              theme-color
**/

function favicon_filter(){ ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo STYLE_DIR; ?>/assets/dist/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo STYLE_DIR; ?>/assets/dist/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo STYLE_DIR; ?>/assets/dist/images/favicon/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo STYLE_DIR; ?>/assets/dist/images/favicon/favicon.ico">
<?php }
add_filter( 'wp_head', 'favicon_filter' );      // Front end of the site
add_action( 'admin_head', 'favicon_filter' );   // WordPress Admin
add_action( 'login_head', 'favicon_filter' );   // Wordpress Login
