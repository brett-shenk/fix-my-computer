<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Update the admin footer + admin greeting
**/

add_filter('admin_footer_text', 'shenk_admin_footer');
function shenk_admin_footer() {
	$output = '';
	$output .= 'Powered by: <a href="https://wordpress.org/" target="_blank">WordPress</a>. ';
	$output .= 'This site has been custom built just for you by ';
	$output .= '<a href="https://www.linkedin.com/in/brett-shenk-59480794/" target="_blank">Brett Shenk</a>. ';
	echo $output;
}

add_filter('admin_bar_menu', 'shenk_replace_wp_howdy', 25 );
function shenk_replace_wp_howdy( $wp_admin_bar ){
    $my_account = $wp_admin_bar->get_node('my-account');
    $newtext = str_replace( 'Howdy,', 'Hello,', $my_account->title );
    $wp_admin_bar->add_node(array(
        'id' => 'my-account',
        'title' => $newtext,
    ));
}


/**
 * Theme Activation
**/

// This action is only triggered when a theme is activated / switched
// add_action('after_switch_theme', 'shenk_setup_options');
// function shenk_setup_options() {
// }



/**
 * Generate Theme Image
 * 
 * @link    Only on the page: Appearance > Theme
**/
add_action( 'admin_print_scripts', 'shenk_generate_theme_image', 50, 1 );
function shenk_generate_theme_image(){
    if( $_SERVER['REQUEST_URI'] === '/wp-admin/themes.php' ){
    ?>
    <script type="text/javascript">
        if(typeof($) === 'undefined') {
        var $ = jQuery;
        }

        // URL for local environment check
        var domain = window.location.href;
        domain = String( domain );
        var domain_array = ['lndo', 'localhost'];

        // URL for screenshot replacement
        function getURL() {
            var url = "<?php echo esc_url( home_url( '/' ) ); ?>";
            var output = window.location.protocol + "//s.wordpress.com/mshots/v1/" + encodeURIComponent(url) + "?w=1200";
            return output;
        }

        // The response API is slow for new images and will return a "loading image" in the meantime... So we have to
        // get creative with how to handle this response. Starting with loading it as soon as possible. Next it
        // waits for a set amount of time to try and wait for the API to finish generating the new screenshot.
        function generate_theme_img(){
			// Used for multiple themes
            document.querySelector('.theme-browser .theme[data-slug="<?php echo get_stylesheet(); ?>"]').querySelector('.theme-screenshot img').src = getURL();
			// Used for the theme pop up + single themes
			document.querySelector('.theme-overlay .screenshot img').src = getURL();
		}

        if( !domain.includes(domain_array[0]) && !domain.includes(domain_array[1]) ){
            getURL();
        }

        // When the Window is finished loading
        window.addEventListener("load", function(){
            if( !domain.includes(domain_array[0]) && !domain.includes(domain_array[1]) ){
                setTimeout(function(){
                    generate_theme_img();
                }, 1500);

				setTimeout(function(){
                    generate_theme_img();
                }, 20000);

                setTimeout(function(){
                    generate_theme_img();
                }, 30000);

                // The Theme Details pop up
                $('.theme[data-slug="<?php echo get_stylesheet(); ?>"]').on('click', function(){
                    generate_theme_img();
                });

            }
        });
    </script>
    <?php
    }
}
