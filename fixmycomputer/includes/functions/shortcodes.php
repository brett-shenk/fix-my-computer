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

	/**
	 * functions to allow the data attribute
	 * NOTE: CF7 still won't work with certain characters, such as: () 
	 * 
	 * Shortcode:	[tel phone_number data-phonemask:___-___-____ class:masked-phone]
	 * Output:		<input type="tel" name="phone_number" data-phonemask="___-___-____" value="" size="40" class="masked-phone">
	**/
	add_filter( 'wpcf7_form_tag', function ( $tag ) {
		$datas = [];
		foreach ( (array)$tag['options'] as $option ) {
			if ( strpos( $option, 'data-' ) === 0 ) {
				$option = explode( ':', $option, 2 );
				$datas[$option[0]] = apply_filters('wpcf7_option_value', $option[1], $option[0]);
			}
		}
		if ( ! empty( $datas ) ) {
			$name = $tag['name'];
			$tag['name'] = $id = uniqid('wpcf');
			add_filter( 'wpcf7_form_elements', function ($content) use ($name, $id, $datas) {
				return str_replace($id, $name, str_replace("name=\"$id\"", "name=\"$name\" ". wpcf7_format_atts($datas), $content));
			});
		}
		return $tag;
	} );
}
