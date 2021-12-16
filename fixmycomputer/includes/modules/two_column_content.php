<?php
    $content_left = get_sub_field('two_col_left_content');
    $content_right = get_sub_field('two_col_right_content');

    // Spacing
    $spaceSettings = get_sub_field('space_settings');
    $style = 'style="';
    $style .= SpacingFunction($spaceSettings);
    $style .= '"';
?>

<section class="module-two-column" <?php echo $style; ?>>
    <div class="wrapper">
        <div class="column-container">
            <div class="column">
                <?php echo $content_left; ?>
            </div>
            <div class="column">
                <?php echo $content_right; ?>
            </div>
        </div>
    </div>
</section>
