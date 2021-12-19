<?php if( !defined( 'ABSPATH' )){
	exit; // Exit if accessed directly
}

/**
 * Main Content
 * @property hook before_entry
 * @property hook entry
 * @property hook after_entry
 * 
 * Site Footer
 * @property hook before_site_footer
 * @property hook site_footer
 * @property hook after_site_footer
**/

add_action('site_footer', 'the_site_footer');
add_action('after_site_footer', 'the_site_copyright');
add_action('wp_footer', 'mobile_menu_script', 50);


function the_site_footer(){
    $logo = get_field('footer_logo', 'options');
    $hours_header = get_field('shop_hours_header', 'options');
    
    global $email, $phone;
    $center_column = get_field('center_column_group', 'options');
    $phone = $center_column['phone_number'];
    $email = $center_column['email'];
    $address1 = $center_column['address_1'];
    $address2 = $center_column['address_2'];
    $map_link = $center_column['google_maps_link'];
    $parking = $center_column['parking_area'];

    $right_column = get_field('right_column_group', 'options');
    $social_facebook = $right_column['facebook'];
    $g_review_link = $right_column['google_reviews_link'];
    $g_review_image = $right_column['google_reviews_image'];

    function mobile_menu_script(){ 
        global $email, $phone;
        ?>
        <script type="text/javascript">
            var global_phone = "<?php echo $phone; ?>";
            var global_email = "<?php echo $email; ?>";
        </script>
    <?php
    }
    ?>
    <div class="column-container wrapper">
        <section class="column">
            <a href="<?php echo site_url(); ?>" title="<?php echo $logo['alt']; ?>" class="logo">
                <img src="<?php echo $logo['url']; ?>" alt="" width="<?php echo $logo['width']; ?>" height="<?php echo $logo['height']; ?>" loading="lazy" />
            </a>
        </section>
        <section class="column" aria-labelledby="footer_second_column">
            <?php if(have_rows('shop_hours', 'options')){ ?>
                <strong id="footer_second_column"><?php echo $hours_header; ?></strong>
                <table>
                <?php while(have_rows('shop_hours', 'options')){
                    the_row();
                    $week_start = get_sub_field('week_start', 'options');
                    $week_end = get_sub_field('week_end', 'options');
                    $time = get_sub_field('time', 'options');

                    if( $week_end != 'none' ){
                        $week = $week_start . ' - ' . $week_end;
                    } else {
                        $week = $week_start;
                    }
                    ?>
                    <tr>
                        <th><?php echo $week; ?></th>
                        <td><?php echo $time; ?></td>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>
        </section>
        <section class="column" aria-label="Reach us and Our Address">
            <strong>Reach Us</strong><br />
            <a class="footer-link-size" href="tel:+1<?php echo $phone; ?>">
                <i class="icon-phone"></i>
                <span>Give us a Call</span>
            </a>
            <br />
            <a class="footer-link-size" href="mailto:<?php echo $email; ?>">
                <i class="icon-email"></i>
                <span>Email Us</span>
            </a>
            <br /><br />
            <address>
                <strong>Our Address</strong><br />
                <?php echo $address1; ?><br />
                <?php echo $address2; ?><br />
            </address>
            <a class="footer-map" href="<?php echo $map_link; ?>" target="_blank" rel="noopener" title="Get Directions">
                <i class="icon-map"></i>
            </a>
            <span class="where-parking tooltip" data-tooltip="<?php echo $parking; ?>">P</span>
        </section>
        <section class="column">
            <?php echo do_shortcode('[contact-form-7 id="262" title="Newsletter"]'); ?>
            
            <div class="column-container">
                <div class="column">
                    <a href="<?php echo $g_review_link; ?>" target="_blank" rel="noopener">
                        <img src="<?php echo $g_review_image['url']; ?>" alt="<?php echo $g_review_image['alt']; ?>" width="<?php echo $g_review_image['width']; ?>" height="<?php echo $g_review_image['height']; ?>" loading="lazy" />
                    </a>
                </div>
                <div class="column">
                    <a class="social-link-foot" href="<?php echo $social_facebook; ?>" target="_blank" rel="noopener">
                        <i class="icon-facebook"></i>
                        <span class="sr-only">
                            Like us on Facebook
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </div>
<?php }

function the_site_copyright(){
    $text = get_field('copyright_text', 'options');
    $the_links = get_field('footer_links', 'options');
    ?>
    <section class="site-copyright" aria-label="Site Copyright">
        <div class="column-container wrapper">
            <div class="column">
                &copy; 2015-<?php echo date('Y'); ?> <?php echo $text; ?>
            </div>
            <div class="column">
                <?php if( $the_links ){
                    $count = 0; ?>
                    <?php foreach( $the_links as $link ){
                        $permalink = get_permalink( $link->ID );
                        $title = get_the_title( $link->ID );

                        if( $count != 0 ){ ?>
                        &nbsp;|&nbsp;
                        <?php } ?>
                        <a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
                        <?php $count++; ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php }
