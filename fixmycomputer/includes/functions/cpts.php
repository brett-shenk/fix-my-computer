<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * CPTs
**/

add_action( 'init', 'shenk_register_cpts_taxes' );
function shenk_register_cpts_taxes() {
	$prefix = "sh_";

	// Start Post Type
	$singular = 'Slide';
	$plural = 'Slides';

	$args = array(
		'label'					=> $plural,
		'labels'				=> 	array(
			'name'					=> $plural,
			'singular_name'			=> $singular,
			'menu_name'				=> $plural,
			'name_admin_bar'		=> $singular,
			'all_items'				=> 'All '.$plural,
			'add_new'				=> 'Add New',
			'add_new_item'			=> 'Add New '.$singular,
			'edit_item'				=> 'Edit '.$singular,
			'new_item'				=> 'New '.$singular,
			'view_item'				=> 'View '.$singular,
			'search_items'			=> 'Search '.$plural,
			'not_found'				=> 'No '.$plural.' found',
			'not_found_in_trash'	=> 'No '.$plural.' found in Trash',
			'parent_item_colon'		=> 'Parent '.$singular.':',
			'update_item'			=> 'Update '.$singular,
			'items_list'			=> $plural.' list',
			'items_list_navigation'	=> $plural.' list navigation',
			'filter_items_list'		=> 'Filter '.$plural.' list',
			'parent' 				=> 'Parent '.$singular,
		),
		'description'			=> '',
		'public'				=> false,		// false disables yoast + slug
		'exclude_from_search'	=> true,
		'publicly_queryable'    => false,
		'show_ui'				=> true,
		'show_in_nav_menus'     => false,		// Appearance > Menus (Adds a select list of all pages)
		'show_in_menu'			=> true,		// Left admin bar menu
		'show_in_admin_bar'     => true,		// Horizontal admin bar > New
		'menu_position'         => 4,
		'menu_icon'				=> 'dashicons-format-gallery',
		'hierarchical'			=> true,		// True allows parent and child pages (page-attributes must be enabled)
		'supports'				=> array(
			'title',
			'editor',					// (content)
			// 'author',
			// 'thumbnail',				// (featured image, current theme must also support post-thumbnails)
			// 'excerpt',
			// 'trackbacks',
			// 'custom-fields',
			// 'comments',				// (also will see comment count balloon on edit screen)
			// 'revisions',				// (will store revisions)
			// 'page-attributes',		// (menu order, hierarchical must be true to show Parent option)
			// 'post-formats'			// add post formats, see Post Formats
		),
		'taxonomies'			=> array(),
		'has_archive'			=> false,
		'rewrite'				=> array(
			'slug'			=> sanitize_title($singular),
			'with_front'	=> true,
			'pages'         => true
		),
		'query_var'				=> true,
		'can_export'            => true,
		// 'capability_type'		=> array(
		// 	str_replace('-', '_', sanitize_title($singular)),
		// 	str_replace('-', '_', sanitize_title($plural))
		// ),
	);
	register_post_type( $prefix.sanitize_title($singular), $args );
	// End Post Type



	// Start Taxonomy
	$singular = 'Type';
	$plural = 'Types';
	$cpt_to_apply = $prefix.'case-study';

	$args = array(
		'label'					=> $plural,
		'labels'				=> array(
			'name'							=> $plural,
			'singular_name'					=> $singular,
			'menu_name'						=> $plural,
			'all_items'						=> 'All '.$plural,
			'edit_item'						=> 'Edit '.$singular,
			'view_item'						=> 'View '.$singular,
			'update_item'					=> 'Update '.$singular.' Name',
			'add_new_item'					=> 'Add New '.$singular,
			'new_item_name'					=> 'New '.$singular.' Name',
			'parent_item'					=> 'Parent '.$singular,
			'parent_item_colon'				=> 'Parent '.$singular.':',
			'search_items'					=> 'Search '.$plural,
			'popular_items'					=> 'Popular '.$plural,
			'separate_items_with_commas'	=> 'Separate '.$plural.' with commas',
			'add_or_remove_items'			=> 'Add or remove '.$plural,
			'choose_from_most_used'			=> 'Choose from the most used '.$plural,
			'not_found'						=> 'No '.$plural.' found',
		),
		'public'				=> true,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'show_in_nav_menus'		=> true,
		'show_admin_column'		=> true,
		'description'			=> '',
		'hierarchical'			=> true,
		'query_var'				=> true,
		'rewrite'				=> array(
			'slug'			=> sanitize_title($singular),
			'with_front'	=> true
		),
	);
	// register_taxonomy( $prefix.sanitize_title($singular), array($cpt_to_apply), $args );
	// End Taxonomy
}


// Disable Fullscreen Editor by default
add_filter('wp_editor_expand', 'deregister_editor_expand', 10, 2);
function deregister_editor_expand($val, $post_type) {
	$disabled_post_types = array('page', 'post', 'sh_slide');
	return !in_array($post_type, $disabled_post_types);
}
