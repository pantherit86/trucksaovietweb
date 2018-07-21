<?php
$post = get_post();
$tags = wp_get_post_tags($post->ID);
if ($tags) {
    $tag_ids = array();
    foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args = array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page' => 3, // Number of related posts to display.
        'ignore_sticky_posts' => 1
    );

    $my_query = new wp_query($args);
    if ($my_query->post_count) {

        ?>
        <div class="related-post">
            <h3 class="related-post-title beveled-background"><?php echo esc_html__('Related Post', 'motohero'); ?></h3>
            <div class="related-post-list">
                <div class="row">
                    <?php

                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        ?>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="related-post-item">
                                <div class="related-post-thumb">
                                    <?php echo the_post_thumbnail(); ?>
                                </div>
                                <div class="related-post-title">
                                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                </div>
                                <div class="related-post-info">
                                    <?php printf(esc_html__('Posted %s in %s by %s', 'motohero'), get_the_date(), get_the_time(), '<a class="theme-color theme-color-hover" href="' . esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)) . '">' . get_the_author() . '</a>') ?>
                                </div>
                                <div class="related-post-content">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="related-post-read-more">
                                    <?php echo '<a class="more-link theme-color" href="' . get_the_permalink() . '#more-' . get_the_ID() . '">' . esc_html__('Read more', 'motohero') . '</a>'; ?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    wp_reset_postdata();


                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>