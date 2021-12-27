<?php
/**
 * Template Name: Homepage
**/

remove_action( 'entry', 'do_entry_header', 1);


add_action('entry', 'home_page_slider', 2);
function home_page_slider(){
    if(have_rows('hp_slider')){ ?>
        <section class="module-home-page-slider" aria-label="Image Slider">
            <div class="home-slider">

            <?php global $post;
            $slides = get_field('hp_slider');
            if( $slides ){ ?>
                <?php foreach( $slides as $post ){
                    // variable must be named $post
                    setup_postdata($post);
                    $image = get_field('image');
                    $content_group = get_field('slider_content');
                    $content = $content_group['content'];
                    $link = $content_group['call_to_action'];
                    ?>
                    <div>
                        <?php if( !empty( $image['url'] ) ){ ?>
                            <img data-lazy="<?php echo $image['sizes']['page-banner']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['sizes']['page-banner-width']; ?>" height="<?php echo $image['sizes']['page-banner-height']; ?>" />
                        <?php } else { ?>
                            <img data-lazy="https://dummyimage.com/1900x600/adadad.jpg&text=+" alt="" width="1900" height="600" crossorigin="anonymous" />
                        <?php } ?>
                        <div class="wrapper">
                            <div class="slide-content">
                                <?php echo $content; ?>
        
                                <?php if($link){ ?>
                                    <a href="<?php echo $link['url']; ?>"
                                    class="cta-button -white"
                                    target="<?php echo $link['target']; ?>"
                                    <?php if( $link['target'] == "_blank" ){ echo 'rel="noopener"'; } ?>
                                    >
                                        <?php echo $link['title']; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php // Reset the global post object
                wp_reset_postdata(); ?>
            <?php } ?>
            
            </div>
        </section>
    <?php }
}


shenk_init();
