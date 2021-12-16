<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * ACF
**/

# Options Pages
if ( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	  => 'Global Settings',
		'menu_title'	  => 'Global Settings',
		'menu_slug' 	  => 'global-settings',
		'capability'	  => 'edit_posts',
		'position'		  => 59,
		'icon_url'		  => 'dashicons-admin-site',
		'redirect'		  => true,
		// 'autoload' 		  => false,
		// 'update_button'   => __('Update', 'acf'),
		// 'updated_message' => __("Options Updated", 'acf'),
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Logo',
		'menu_title'	=> 'Logo',
		'parent_slug'	=> 'global-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'global-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Alert Bar',
		'menu_title'	=> 'Alert Bar',
		'parent_slug'	=> 'global-settings',
	));
}

/**
 * Add a new toolbar called "Alert Bar"
**/
add_filter( 'acf/fields/wysiwyg/toolbars' , 'alertbar_toolbars' );
function alertbar_toolbars( $toolbars ){
	$toolbars['Alert Bar'] = array();
	$toolbars['Alert Bar'][1] = array(
		'bold',
        'italic',
		'strikethrough',
		'underline',
        // 'bullist',
        // 'numlist',
        // 'blockquote',
        // 'hr',
        'alignleft',
        'aligncenter',
        'alignright',
        'link',
        'unlink',
	);
	$toolbars['Alert Bar'][2] = array(
		'forecolor', 	// text color
		'pastetext', 	// paste as text
		'removeformat', // clear formatting
		'charmap', 		// special characters
		'outdent',
		'indent',
		'undo',
		'redo',
	);

	return $toolbars;
}

/**
 * Add class to fields without a label
**/
add_filter('acf/load_field', 'emptyLabels');
function emptyLabels($field){
    global $post;
    if ($post) {
        if (get_post_type($post->ID) == 'acf-field-group') {
            return $field;
        }
        if ( empty($field['label']) ) {
            $field['wrapper']['class'] .= ' noLabel';
        }
    }
    return $field;
}
