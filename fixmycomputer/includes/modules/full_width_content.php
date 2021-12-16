<?php
    // Main Content
    $content = get_sub_field('full_width_content');

    // CTA
    $cta_group = get_sub_field('cta_group');
    $cta = $cta_group['full_width_cta'];
    $cta_align = $cta_group['cta_alignment'];

    // Spacing
    $spaceSettings = get_sub_field('space_settings');
    $style = 'style="';
    $style .= SpacingFunction($spaceSettings);
    $style .= '"';
?>

<section class="module-full-width-content" <?php echo $style; ?>>
    <div class="wrapper">
        <?php echo $content ?>
        <?php if (!empty($cta['url']) ) { ?>
            <a href="<?php echo $cta['url']; ?>" 
                target="<?php echo $cta['target']; ?>" 
                class="cta-button <?php echo $cta_align; ?>" 
                <?php if( $cta['target'] == "_blank" ){ echo 'rel="noopener"'; } ?>
                >
                <?php echo $cta['title']; ?>
            </a>
        <?php } ?>
    </div>
</section>
