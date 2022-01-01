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
	#preload-container {position: fixed;left: 0;right: 0;top: 0;bottom: 0;z-index: 5000;background-color: #2f2f2f;}
	#preload-container .preload-wrap {position: absolute;top: 48.5%;width: 100%;text-align: center;}
	#preload-container .loader {font-size: 48px;display: inline-block;font-family: Arial, Helvetica, sans-serif;font-weight: bold;color: #fff;letter-spacing: 2px;position: relative;box-sizing: border-box;}
	#preload-container .loader::after {content: "Loading";position: absolute;left: 0;top: 0;color: #263238;text-shadow: 0 0 2px #fff, 0 0 1px #fff, 0 0 1px #fff;width: 100%;height: 100%;overflow: hidden;box-sizing: border-box;animation: animloader 6s linear infinite;}
	@keyframes animloader {0% {height: 100%;}100% {height: 0%;}}
	</style>
	
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>
