<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Site Header
 * @property hook before_site_header
 * @property hook site_header
 * @property hook after_site_header
 * 
 * Main Content
 * @property hook before_entry
 * @property hook entry
 * @property hook after_entry
**/

add_action( 'before_site_header', 'preloading_animation', 1 );
add_action( 'site_header', 'the_alert_bar', 1);
add_action( 'site_header', 'wrapper_open', 2 );
add_action( 'site_header', 'site_logo', 5 );
add_action( 'site_header', 'site_navigation', 6 );
add_action( 'site_header', 'wrapper_close', 20 );
add_action( 'after_site_header', 'nav_placeholder', 4 );
add_action( 'entry_header', 'default_page_header_open', 2);
add_action( 'entry_header', 'site_breadcrumbs', 15 );
add_action( 'entry_header', 'wrapper_close', 14);

function preloading_animation() { ?>
	<div id="preload-container" aria-hidden="true">
		<div class="preload-wrap">
			<div class="loader">Loading</div>
		</div>
	</div>
<?php }

function the_alert_bar(){
	$primary_group = get_field('addional_options', 'options');
	$status_overall = isset($primary_group['overall_status']) ? $primary_group['overall_status'] : '';
	$status_cta = isset($primary_group['enable_cta']) ? $primary_group['enable_cta'] : '';
	$cta = isset($primary_group['cta']) ? $primary_group['cta'] : '';

	global $cookie, $status_cookie;
	$sub_group = isset($primary_group['sub_group']) ? $primary_group['sub_group'] : '';
	$status_cookie = isset($sub_group['status_cookie']) ? $sub_group['status_cookie'] : '';
	$cookie = isset($sub_group['cookie_time']) ? $sub_group['cookie_time'] : '';
	$alert_bar_class = '';
	if( $status_cta != "enabled" ){
		$alert_bar_class = ' -no-cta';
	}
	
	$the_content = get_field('the_content', 'options');

	if($status_overall == "enabled"){ ?>
		<div class="alert-bar-container" role="alertdialog" aria-label="Alert Bar" aria-describedby="alert_bar_dialog_desc">
			<div class="wrapper">
				<div class="column-container">
					<div class="column">
						<button type="button">
							<i class="icon-close"></i>
							<span class="sr-only">Close Alert Bar</span>
						</button>
					</div>
					<div class="column<?php echo $alert_bar_class; ?>" id="alert_bar_dialog_desc">
						<?php echo $the_content; ?>
					</div>
					<?php if( $status_cta == "enabled" ){ ?>
						<div class="column">
							<a href="<?php echo $cta['url']; ?>" 
								target="<?php echo $cta['target']; ?>" 
								class="cta-button" 
								<?php if( $cta['target'] == "_blank" ){ echo 'rel="noopener"'; } ?>
								>
								<?php echo $cta['title']; ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php

		// load the resources
		wp_enqueue_script('alert-bar');
		wp_enqueue_style('alert-bar');
		add_action('wp_footer', 'the_alert_bar_script_var', 51);

		// Pass variables to JavaScript
		function the_alert_bar_script_var(){
			global $cookie, $status_cookie;
			?>
			<script type="text/javascript">
				var global_cookie_time = "<?php echo $cookie; ?>";
				var global_cookie_status = "<?php echo $status_cookie; ?>";
			</script>
			<?php
		}
	}
}



function site_logo() {
	$logo_1 = get_field('header_logo', 'options');
	$logo_2 = get_field('mobile_logo', 'options');
	?>
	<a href="<?php echo site_url(); ?>" class="logo" title="Fix My Computer">
		<img class="desktop" src="<?php echo $logo_1['url']; ?>" alt="" width="<?php echo $logo_1['width']; ?>" height="<?php echo $logo_1['height']; ?>" />
		<img class="mobile" src="<?php echo $logo_2['url']; ?>" alt="" width="<?php echo $logo_2['width']; ?>" height="<?php echo $logo_2['height']; ?>" />
	</a>
<?php }

function site_navigation() { ?>
		<?php
		wp_nav_menu(array(
			'menu'				=> 'Main Nav',
			// 'menu_class'        => "",
			'container'			=> 'nav',
			'container_class'	=> 'main-nav',
			'walker'			=> new NAV_Walker,
			// 'before'            => "", 		// Text before the link markup
			// 'after'             => "", 		// Text after the link markup
			// 'link_before'       => "", 		// Text before the link text
			// 'link_after'        => "", 		// Text after the link text
		)); ?>
		<button class="hamburger hamburger--collapse" type="button" aria-label="Mobile Menu">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>
<?php }

function nav_placeholder(){ ?>
	<div id="nav-placeholder"></div>
<?php }


function site_breadcrumbs(){
	if( function_exists('rank_math_the_breadcrumbs') ){
		rank_math_the_breadcrumbs();
	}
	if( function_exists('yoast_breadcrumb') ){
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
}

function default_page_header_open(){
	$layout_style = get_field('layout_style');
	if($layout_style == null){
		$layout_style = 'banner';
	}
	?>
	<div class="banner-container" data-layout-type="<?php echo $layout_style; ?>">
		<?php 
		if( $layout_style == "banner" ){
			$banner_image = get_field('banner_image');

			if( $banner_image ) {
				echo wp_get_attachment_image( $banner_image['id'], 'cta_boxes', false, 
				array( 'alt' => $banner_image['alt'], "class" => '' ));
			} else {
				?>
				<img src="<?php echo site_url(); ?>/wp-content/themes/fixmycomputer/assets/dist/images/cricut-board-cards.jpg" alt="" width="1920" height="400" loading="lazy" crossorigin="anonymous" />
				<?php 
			}
		}
	// the div is closed else where, ignore it
}
