<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Body Classes
**/
add_filter('body_class', function( $classes ){

	# Add preview class
	if ( is_preview() )  {
		$classes[] = 'preview-mode';
		return $classes;
	}

	if ( is_singular() ){
		# Remove classes that are added for page templates
		if ( is_page_template() ) {
			global $wp_query;
			$post_id        = $wp_query->get_queried_object_id();
			$template_slug  = get_page_template_slug( $post_id );
			$template_parts = explode( '/', $template_slug );

			$remove_classes = [
				'page-template-'.$template_parts[0].str_replace( '.', '-', $template_parts[1] ),
				'page-template-page-templates',
			];
			$classes = array_diff($classes, $remove_classes);
		}

		# Remove useless class added for pages
		if( is_page() ){
			$remove_classes = [ 'page' ];
			$classes = array_diff($classes, $remove_classes);
		}
	}

	return $classes;
});


/**
 * Helper Function that lists all style and js resources. Spits out the handle + src
**/
global $enqueued_scripts;
global $enqueued_styles;

function shenk_list_scripts(){
    global $wp_scripts;
    global $enqueued_scripts;
    $enqueued_scripts = array();
    foreach ( $wp_scripts->queue as $handle ) {
        $enqueued_scripts[$handle] = $wp_scripts->registered[$handle]->src;
    }
}
function shenk_list_styles(){
    global $wp_styles;
    global $enqueued_styles;
    $enqueued_styles = array();
    foreach ( $wp_styles->queue as $handle ) {
        $enqueued_styles[$handle] = $wp_styles->registered[$handle]->src;
    }
}
function sh_enqueued_resources(){
    global $enqueued_scripts;
    v_dump( $enqueued_scripts );
    global $enqueued_styles;
    v_dump( $enqueued_styles );
}
// add_action( 'wp_print_scripts', 'shenk_list_scripts', 999 );
// add_action( 'wp_print_styles', 'shenk_list_styles', 999 );
// add_action( 'wp_head', 'sh_enqueued_resources');


/**
 * Nav menu walker
**/
class NAV_Walker extends Walker_Nav_Menu {
	/**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
    **/
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$block = isset( $args->block ) ? $args->block : explode(' ', $args->menu_class);
		$block = is_array( $block ) ? $block[0] : $block;
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"${block}__sub-menu\">\n";
	}

	/**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
    **/
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	**/
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $args = (object) $args;
        
		$block = isset( $args->block ) ? $args->block : explode(' ', $args->menu_class);
		$block = is_array( $block ) ? $block[0] : $block;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$this->prepare_el_classes( $item, $args, $depth );
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		**/
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= $indent . '<li' . $class_names .'>';
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title )	? $item->attr_title	: '';
		$atts['target'] = ! empty( $item->target )    	? $item->target		: '';
		$atts['rel']    = ! empty( $item->xfn )       	? $item->xfn   		: '';
		$atts['rel'] 	= ! empty( $item->target )	  	? 'noopener'		: '';
		$atts['href']   = ! empty( $item->url )       	? $item->url   		: '';
		$atts['class']  = $item->url === '#' 			? $block.'__span'	: $block.'__link';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		**/

	    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		if ($atts['href'] === '#' || $atts['href'] === '') {
			$atts = array_diff($atts, array("#"));
			$tag = 'span';
		} else {
			$tag = 'a';
		}

	    $attributes = '';
	    foreach ( $atts as $attr => $value ) {
	        if ( ! empty( $value ) ) {
	            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
	            $attributes .= ' ' . $attr . '="' . $value . '"';
	        }
	    }
	    $item_output = $args->before;
	    $item_output .= '<'. $tag . $attributes .'>';
	    /** This filter is documented in wp-includes/post-template.php */
	    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	    $item_output .= '</'. $tag .'>';
	    $item_output .= $args->after;
	    /**
	     * Filter a menu item's starting output.
	     *
	     * The menu item's starting output only includes `$args->before`, the opening `<a>`,
	     * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
	     * no filter for modifying the opening and closing `<li>` for a menu item.
	     *
	     * @since 3.0.0
	     *
	     * @param string $item_output The menu item's starting HTML output.
	     * @param object $item        Menu item data object.
	     * @param int    $depth       Depth of menu item. Used for padding.
	     * @param array  $args        An array of {@see wp_nav_menu()} arguments.
	    **/
	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	**/
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}

	public function prepare_el_classes( &$item, $args = array(), $depth = 0 ) {
		$block = isset( $args->block ) ? $args->block : explode(' ', $args->menu_class);
		$block = is_array( $block ) ? $block[0] : $block;
		$classes = array( $block . '__item' );

		if ( $item->classes ) {
            foreach( $item->classes as $class) {
                if($class == 'menu-item') {
                    break;
                }
                $classes[] = $class;
            }
        }
		
		if ( $item->current )
			$classes[] = $block . '__item--current';

		if ( $item->current_item_ancestor )
			$classes[] = $block . '__item--ancestor';

		if ( $item->current_item_parent )
			$classes[] = $block . '__item--parent';

		if ( in_array( 'menu-item-has-children', (array) $item->classes ) )
			$classes[] = $block . '__item--has-children';

		if ( $depth )
			$classes[] = $block . '__item--child';

     	$item->classes = $classes;
	}
}
