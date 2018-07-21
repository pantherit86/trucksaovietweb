<?php
/**
 * The template for displaying Category pages
 * @package motohero
 */
$inwave_post_option = Inwave_Helper::getConfig();
get_header();
?>
<div class="page-content">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container',$inwave_post_option['sidebar-position']))?> product-content">
                    <?php
                    if ( is_singular( 'product' ) ) {
                        while ( have_posts() ) : the_post();
                            wc_get_template_part( 'content', 'single-product' );
                        endwhile;
                    } else {
                        wc_get_template_part( 'category', 'product' );
                    }
                    ?>
                </div>
                <?php if ($inwave_post_option['sidebar-position']) { ?>
                    <div class="<?php echo esc_attr(inwave_get_classes('sidebar',$inwave_post_option['sidebar-position']))?> product-sidebar">
                        <?php get_sidebar('woocommerce'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
