<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * TinyMCE
**/

// Add custom editor stylesheet
add_action( 'admin_init', 'shenk_editor_style' );
function shenk_editor_style() {
	add_editor_style( STYLE_DIR . '/assets/dist/css/custom-editor.min.css' );
}

// Add Formats Dropdown to WYSIWYG Editor
add_filter( 'mce_buttons_2', 'shenk_mce_editor_buttons' );
function shenk_mce_editor_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

// Add custom styles in Formats Dropdown
add_filter( 'tiny_mce_before_init', 'shenk_mce_before_init' );
function shenk_mce_before_init( $settings ) {
	$style_formats = array(
		array(
			'title' => 'No Break',
			'inline' => 'span',
			'classes' => array(
				'no-br'
			)
		),
		array(
			'title' => 'Small',
			'inline' => 'small'
		)
	);
	$settings['style_formats'] = json_encode( $style_formats );
	$settings[ 'wordpress_adv_hidden' ] 		= FALSE;
	return $settings;
}

// Customize color options in WYSIWYG Editor
add_filter('tiny_mce_before_init', 'shenk_mce4_options');
function shenk_mce4_options( $init ) {
	$init['textcolor_map'] = '[
		"000000", "Black",
		"292929", "Dark Gray",
		"737373", "Mid Gray", 
		"D7D7D7", "Light Gray",
		"FFFFFF", "White",
		"3E267B", "Purple",
		"291B4B", "Dark Purple",
		"e31c79", "Pink",
	]';
	$init['textcolor_rows'] = 1;
	$init['block_formats'] = 'Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Paragraph=p';

	return $init;
}

// Customize Top Row of WYSIWYG
add_filter( 'mce_buttons', 'shenk_tinymce_button' );
function shenk_tinymce_button( $buttons ){
	$remove = array(
		'blockquote',
		'wp_more',
		'wp_adv'
	);

	return array_diff( $buttons, $remove );
}

// Customize Bottom Row of WYSIWYG
add_filter( 'mce_buttons_2','shenk_tinymce2_buttons' );
function shenk_tinymce2_buttons( $buttons ){
	$remove = array(
		'charmap',
		'wp_help'
	);

	return array_diff( $buttons, $remove );
}

// Customize the Buttons On the Text View
add_filter( 'quicktags_settings', 'default_text_view', 10, 2 );
function default_text_view( $qtInit, $editor_id = 'content' ) {
	$qtInit['buttons'] = 'strong,em,link,block,img,ul,ol,li,code';
	return $qtInit;
}
