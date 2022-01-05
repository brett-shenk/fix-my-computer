<section class="module-computer-list" aria-label="">
    <div class="wrapper">
        <?php if(have_rows('primary_group')){ ?>
            <?php while(have_rows('primary_group')){
                the_row();
                $icon = get_sub_field('icon');
                $type = get_sub_field('type');
                $hard_drive = get_sub_field('hard_drive');
                $ram = get_sub_field('ram');
                $cpu = get_sub_field('cpu');
                $video_card = get_sub_field('video_card');
                ?>

                <div class="single-computer-block">
                    <div class="single-computer-inner">
                        <i class="icon-<?php echo $icon; ?>"></i><br>
                        <h2><?php echo $type; ?></h2>
                        <table>
                            <tr>
                                <td>
                                    <strong>Hard Drive:</strong>
                                </td>
                                <td>
                                    <?php echo $hard_drive; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>RAM:</strong>
                                </td>
                                <td>
                                    <?php echo $ram; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>CPU:</strong>
                                </td>
                                <td>
                                    <?php echo $cpu; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Video Card:</strong>
                                </td>
                                <td>
                                    <?php echo $video_card; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</section>
