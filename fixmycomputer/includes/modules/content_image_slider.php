<?php
    $primary_g = get_sub_field('main_content_group');
    $content = $primary_g['the_content'];
    $layout = $primary_g['block_alignment'];

    // Spacing
    $spaceSettings = get_sub_field('space_settings');
    $style = 'style="';
    $style .= SpacingFunction($spaceSettings);
    $style .= '"';
?>

<section class="module-content-image-slider" <?php echo $style; ?>>
    <div class="wrapper">
        <div class="content-container -<?php echo $layout; ?>">
            <div class="column">
                <?php echo $content; ?>
            </div>
            <div class="column">
                <?php if(have_rows('image_gallery')){ ?>
                    <div class="content-image-slider">
                        <?php while(have_rows('image_gallery')){
                            the_row();
                            $image = get_sub_field('image');
                            
                            ?>
                            <div>
                                <?php echo wp_get_attachment_image( $image['id'], array('800', '550'), false, 
                                array( 'alt' => $image['alt'] ));
                                if($image['caption']){ ?>
                                    <div class="the-caption">
                                        <p><?php echo $image['caption']; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="content-image-slider" aria-label="Image Slider">
                        <div>
                            <img src="https://dummyimage.com/800x500/adadad.jpg" alt="" width="800" height="500" loading="lazy" crossorigin="anonymous" />
                        </div>
                        <div>
                            <img src="https://dummyimage.com/800x500/000000/ffffff.jpg" alt="" width="800" height="500" loading="lazy" crossorigin="anonymous" />
                            <div class="the-caption">
                                <p>This is just an example caption.</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
