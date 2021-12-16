<?php
/**
 * Template Name: Sitemap
 */

/**********************************************************
 *                      HOW TO USE
 * 1. Create ACF field with the name:  exclude_pages
 * 2. The type as relationship
 * 3. Return format:  Post ID
 **********************************************************/

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
        <div>
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

        <?php // Custom Post Type displaying all news/blog posts
        /*?>
        <div>
            <h3>News & Events</h3>
            <?php $args = array(
                'post_type'     => 'sh_news',
                'post_status'   => 'publish',
                'posts_per_page'=> -1,
                'offset'        => 0,
                'order'         => 'DESC',
                'orderby'       => 'date'
            );              
            
            $the_query = new WP_Query( $args );
            if($the_query->have_posts() ){
                echo '<ul>';
                while ( $the_query->have_posts() ){
                   $the_query->the_post(); 
                   echo '<li class="sitemap_item"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                }
                wp_reset_postdata(); 
                echo '</ul>';
            }
            */ ?>
        </div>
    </section>
<?php }
add_action('after_entry', 'sitemap_main_content', 10);


shenk_init();
