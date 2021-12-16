<?php
/************************************************************************************************************************
	File Include for all php files in the directory:   /includes/functions/

		File					- Description
		acf						- ACF related functions
		activation				- First time theme activation / Generate Theme Image
		browser-upgrade			- IE browser warning
		clean-up-wordpress		- SlimFast for WordPress. Also helps customize the admin bars for the client
		comments				- Disables comments
		core-functions			- Nav walker class + body classes
		cpts					- All custom post types + taxonomies
		custom-functions		- Random theme functions
		enqueue-scripts			- All css and js resources are loaded here
		favicon					- The favicon
		image-size				- All image sizes
		setup					- General WordPress setup settings
		shortcodes				- Shortcode related functions
		tinymce					- Customizes the tinymce editor in WordPress
************************************************************************************************************************/

# Site URL
define( 'STYLE_DIR',  get_theme_file_uri() );

# Setup Site HTML and Hooks
require_once get_template_directory() . '/includes/layout/template.php';

# Include Function Files
foreach ( glob( dirname( __FILE__ ) . '/includes/functions/*.php' ) as $file ) { include $file; }

?>
