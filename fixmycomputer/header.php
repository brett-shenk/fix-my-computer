<?php
/**
 * The template for displaying the header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php /*  Efficiently Load google fonts */ ?>
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin /> 
	<link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin /> 
	<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" />
	<?php /*  Supports older browsers because rel=preload isn't backwards compatible */ ?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" media="print" onload="this.media='all'" />

	<?php /*  The Preloader can also can be found in:   global/_preloader.scss */ ?>
	<style type="text/css">
	#preload-container{position:fixed;left:0;right:0;top:0;bottom:0;z-index:5000;background-color:#2f2f2f}
	#preload-container .loader-wrap{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)}
	#preload-container .loader{width:48px;height:48px;display:inline-block;position:relative;background:#e31c79;box-sizing:border-box;animation:flipX 1s linear infinite}
	@keyframes flipX{0%{transform:perspective(200px) rotateX(0) rotateY(0)}50%{transform:perspective(200px) rotateX(-180deg) rotateY(0)}100%{transform:perspective(200px) rotateX(-180deg) rotateY(-180deg)}}
	</style>
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
