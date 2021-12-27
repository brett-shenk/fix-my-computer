<?php
/**
 * Template Name: Sitemap
**/

remove_action('entry_header', 'site_breadcrumbs', 15);


add_action('after_entry', 'sitemap_main_content', 10);
function sitemap_main_content(){
    // Get pages to be excluded
    $exclude_pages = get_field('exclude_pages');
    $excluded_string = '';
    if($exclude_pages){
        $excluded_string = '"';
        foreach($exclude_pages as $a_page){
            $a_page = $a_page . ', ';
            $excluded_string = $excluded_string . $a_page;
        }
        $excluded_string = $excluded_string . '"';
    } ?>

    <section class="wrapper sitemap-module">
        <?php // Displaying all pages on the site, except those picked above  ?>
        <div class="column">
            <h3>Pages</h3>
            <ul>
                <?php
                wp_list_pages( array( 
                    'exclude'       => $excluded_string,
                    'post_status'   => 'publish',
                    'sort_column'   => 'menu_order',
                    'title_li'      => '',
                )); ?>
            </ul>
        </div>
        <div class="column">
            <h3>Services</h3>
            <?php
            $service_page = get_page_by_path( 'services' );
            $loop = new WP_Query( array(
                'post_type'      => 'page',
                'post_status'    => array('publish', 'private'),
                'orderby'        => 'menu_order',
                'posts_per_page' => '-1',
                'order'          => 'ASC',
                'post_parent'    => $service_page->ID,
            ) );

            if( $loop->have_posts() ){
                echo '<ul>';
                while( $loop->have_posts() ){
                    $loop->the_post();
                    echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                }
                echo '</ul>';
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>
<?php }


shenk_init();
