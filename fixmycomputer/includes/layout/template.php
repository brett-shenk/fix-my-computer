<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Site Header
 * @property hook before_site_header
 * @property hook site_header
 * @property hook after_site_header
 * 
 * Main Container
 * @property hook before_main_content
 * @property hook main_content
 * @property hook after_main_content
 * 
 * Page Content
 * @property hook before_entry
 * @property hook entry
 * @property hook entry, the_content, 10					Page Content
 * @property hook entry, shenk_flexible_layout 11			ACF Flexible Content
 * @property hook after_entry
 * 
 * ACF Flexible Content Additions
 * @property hook before_flexible_content
 * @property hook before_layout_[layout]
 * @property include includes/modules/[layout].php
 * @property hook after_layout_[layout]
 * @property hook after_flexible_content
 * 
 * Page Header
 * @property hook before_entry_header
 * @property hook entry_header
 * @property hook entry_header, do_entry_title, 10			Page Title
 * @property hook entry_header, site_breadcrumbs, 15		Breadcrumbs
 * @property hook after_entry_header
 * 
 * Site Footer
 * @property hook before_site_footer
 * @property hook site_footer
 * @property hook after_site_footer
 * 
 * Extra Functions
 * @property hook wrapper_open			Page Wrapper
 * @property hook wrapper_close			Page Wrapper
**/


/**
 * The main function to generate the templates
**/
function shenk_init() { ?>

	<?php get_header(); ?>

	<?php do_action( 'before_main_site' ); ?>

	<?php do_action( 'main_site' ); ?>

	<?php do_action( 'after_main_site' ); ?>

	<?php get_footer(); ?>
<?php }

function do_site_header() { ?>
	<?php do_action('before_site_header'); ?>
	<header id="masthead" class="site-header">
		<?php do_action('site_header'); ?>
	</header>
	<?php do_action('after_site_header'); ?>
<?php }

function do_site_main() { ?>
	<?php do_action( 'before_main_content' ); ?>
	<!-- .site__main -->
	<main id="main" class="site-main">
		<?php do_action( 'main_content' ); ?>
	</main>
	<!-- / .site__main -->
	<?php do_action( 'after_main_content' ); ?>
<?php }

function do_entry() { ?>
	<?php do_action('before_entry'); ?>
	<article class="entry">
		<?php do_action('entry'); ?>
	</article>
	<?php do_action('after_entry'); ?>
<?php }


function do_entry_header() { ?>
	<?php do_action('before_entry_header'); ?>
	<header class="entry-header" role="region" aria-label="Page Banner">
		<?php do_action('entry_header'); ?>
	</header>
	<?php do_action('after_entry_header'); ?>
<?php }

function do_entry_title() {
	$title = get_the_title();
	?>
	<h1 class="entry-title">
		<?php do_action('before_entry_title'); ?>
		<span>
			<?php echo $title ?>
		</span>
		<?php do_action('after_entry_title'); ?>
	</h1>
<?php }

function do_site_footer() { ?>
	<?php do_action( 'before_site_footer' ); ?>
	<footer id="footer" class="site-footer" aria-label="Site Footer">
		<?php do_action( 'site_footer' ); ?>
	</footer>
	<?php do_action( 'after_site_footer' ); ?>
<?php }

function wrapper_open() { ?>
	<div class="wrapper">
<?php }

function wrapper_close() { ?>
	</div>
<?php }

add_action( 'main_site', 'do_site_header', 10 );
add_action( 'main_site', 'do_site_main', 10 );
add_action( 'main_site', 'do_site_footer', 10 );
add_action( 'main_content', 'do_entry', 10);
add_action( 'entry', 'do_entry_header', 1);
add_action( 'entry_header', 'do_entry_title', 10);
add_action( 'entry', 'the_content', 10);


/**
 * Display ACF Flexible content field
 * 
 * Any module inside of the folder:
 * includes/modules/
**/
function display_flexible_layout($flexible_content){
    do_action( 'before_flexible_content' );

    while ( have_rows( $flexible_content ) ) {
        the_row();

        $layout = get_row_layout();
        $module_path = 'includes/modules/';

        do_action( 'before_layout_' . $layout );
        get_template_part($module_path . $layout);
        do_action( 'after_layout_' . $layout );
    }

    do_action( 'after_flexible_content' );
}
function shenk_flexible_layout(){
    if ( class_exists('ACF') ) {
        $flexContent = '';

        if ( have_rows('main_modules') ) {
            $flexContent = 'main_modules';
        }

        if ( !empty($flexContent) ) {
            display_flexible_layout( $flexContent );
        }
    }
}
add_action( 'entry', 'shenk_flexible_layout', 11 );
