<?php
    // Spacing
    $spaceSettings = get_sub_field('space_settings');
    $style = 'style="';
    $style .= SpacingFunction($spaceSettings);
    $style .= '"';
?>
<section class="module-service-text" <?php echo $style; ?> aria-label="Service Block">
    <div class="wrapper">
        <div class="column-container">
            <?php
            if( have_rows('service_text') ){
                while( have_rows('service_text') ){
                    the_row();

                    $header = get_sub_field('header');
                    $cta = get_sub_field('cta');
                    $content = get_sub_field('content');
                    ?>
                    <div class="column">
                        <?php if( $header ){ ?>
                            <h2>
                                <?php if( $cta['url'] ){ ?>
                                    <a href="<?php echo $cta['url']; ?>" 
                                    target="<?php echo $cta['target']; ?>" 
                                    <?php if( $cta['target'] == "_blank" ){ echo 'rel="noopener"'; } ?> 
                                    >
                                <?php }

                                echo $header;

                                if( $cta['url'] ){ ?>
                                    </a>
                                <?php } ?>
                            </h2>
                        <?php } ?>

                        <p><?php echo $content; ?></p>

                        <?php if( $cta['url'] ){ ?>
                            <a href="<?php echo $cta['url']; ?>"
                                target="<?php echo $cta['target']; ?>" 
                                class="cta-button" 
                                <?php if( $cta['target'] == "_blank" ){ echo 'rel="noopener"'; } ?> 
                                >
                                <?php echo $cta['title']; ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>
