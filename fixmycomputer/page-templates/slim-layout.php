<?php
/**
 * Template Name: Slim Layout Default
**/

add_action( 'wp_footer', function(){ ?>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>
<?php }, 10 );


shenk_init();
