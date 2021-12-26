<?php
/**
 * Custom 404 Page
**/


remove_action( 'entry_header', 'default_page_header_open', 2);
add_action( 'entry_header', 'page_404_header_open', 3);
function page_404_header_open(){
	$layout_style = 'text';
    ?>
	<div class="banner-container" data-layout-type="<?php echo $layout_style; ?>">
    <?php
    // the div is closed else where, ignore it
}


remove_action( 'entry_header', 'do_entry_title', 10);
add_action( 'entry_header', 'do_entry_title_404', 11);
function do_entry_title_404(){ ?>
    <h1 class="entry-title" data-text="Oops..">
		Oops..
	</h1>
<?php }


remove_action( 'entry_header', 'site_breadcrumbs', 15);


add_action( 'entry_header', 'page_content_404_error', 20 );
function page_content_404_error(){
    ?>
    <div class="error-404-container wrapper">
        <p>
            Someone's gone and done it now... Looks like you need some help.
        </p>
        <br><br>
        <div class="column-container">
            <div class="column">
                <a href="/" class="cta-button">
                    Go Home
                </a>
            </div>
            <div class="column">
                <a href="/sitemap/" class="cta-button">
                    Check out the Sitemap
                </a>
            </div>
        </div>
    </div>
    <?php
}


add_action( 'entry', 'page_content_404_error_image' );
function page_content_404_error_image(){
    ?>
    <img class="error-background" 
        src="<?php echo STYLE_DIR; ?>/assets/dist/images/ripped-code.png" 
        width="830" 
        height="902" 
        alt="transparent hole through the site looking at some code" 
        lazy="loading">
    <?php
}


shenk_init();
