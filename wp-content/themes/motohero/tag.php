<?php
/**
 * The template for displaying Category pages
 * @package motohero
 */

get_header();
?>
<div class="page-content iw-category iw-tag">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_post_option['sidebar-position']))?> blog-content">
                    <?php if ( have_posts() ) : ?>
                        <?php while (have_posts()) : the_post();
                            get_template_part( 'content', get_post_format() );
                        endwhile; // end of the loop. ?>
                        <?php get_template_part( '/blocks/paging'); ?>
                    <?php else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );
                    endif;?>
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
