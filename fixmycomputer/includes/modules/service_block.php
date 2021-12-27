<section class="module-service-block" aria-label="Service Block">
    <div class="wrapper">
        <?php if(have_rows('service_block')){ ?>
            <?php while(have_rows('service_block')){
                the_row();
                $image = get_sub_field('image');
                $content_group = get_sub_field('content_group');
                $header = $content_group['header'];
                $cta = $content_group['call_to_action'];
                $content = $content_group['content'];
                ?>

                <div class="the-service-block">
                    <div class="first-part">
                        <?php if( !empty( $image['url'] ) ){
                            echo wp_get_attachment_image( $image['id'], 'service-block', false, 
                            array( 'alt' => $image['alt'], "class" => '' ));
                        } else { ?>
                            <img src="https://dummyimage.com/450x450/adadad.jpg&text=+" alt="" width="450" height="450" loading="lazy" crossorigin="anonymous" />
                        <?php } ?>

                        <?php if( $header ){ ?>
                            <h3><?php echo $header; ?></h3>
                        <?php } ?>
                    </div>
                    <div class="second-part">
                        <div>
                            <?php echo $content; ?>
                        </div>
                        <?php if( $cta['url'] ){ ?>
                            <a href="<?php echo $cta['url']; ?>"
                            target="<?php echo $cta['target']; ?>" 
                            class="cta-button -white" 
                            <?php if( $cta['target'] == "_blank" ){ echo 'rel="noopener"'; } ?> 
                            >
                                <?php echo $cta['title']; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</section>
