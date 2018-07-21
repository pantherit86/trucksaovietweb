<?php
/**
 * The template for displaying Category pages
 * @package motohero
 */
get_header();
?>
<div class="page-content">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_post_option['sidebar-position']))?> search-content">
                    <?php if ( have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php
                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'content', 'search' );
                            ?>
                        <?php endwhile; ?>
                        <?php get_template_part( '/blocks/paging'); ?>
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                    </div>
                    <?php if ($inwave_post_option['sidebar-position']) { ?>
                        <div class="<?php echo esc_attr(inwave_get_classes('sidebar',$inwave_post_option['sidebar-position']))?> default-sidebar">
                            <?php get_sidebar($inwave_post_option['sidebar-name']); ?>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
