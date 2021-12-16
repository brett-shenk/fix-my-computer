<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Shortcodes
**/

// Remove Empty p tags for Shortcodes
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}

// Allow Shortcodes in Text Widgets
add_filter('widget_text', 'do_shortcode');


# CF7
if ( defined( 'WPCF7_VERSION' ) ) {

	# Removes  <p>  tags from being output
	add_filter('wpcf7_autop_or_not', '__return_false');

	# The form class
	add_filter('wpcf7_form_class_attr', function($html_class) {
		return $html_class;
	});
}
