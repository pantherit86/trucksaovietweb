<?php
/**
 * Created by PhpStorm.
 * User: TruongDX
 * Date: 11/10/2015
 * Time: 11:44 AM
 */
$inwave_post_option = Inwave_Helper::getConfig();
$inwave_theme_option = Inwave_Helper::getConfig('smof');
?>
<footer class="iw-footer-default">
    <div class="container">
        <div class="row">
        <div class="col-md-3 col-sm-3 footer-left">
                <div class="iw-footer-logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img alt="" src="<?php echo esc_url($inwave_theme_option['footer-logo']); ?>"/>
                    </a>
                </div>
                <div class="footer-text">
                <p>
                    <?php echo do_shortcode($inwave_theme_option['footer-text']); ?></p>
                </div>
                <?php if ($inwave_theme_option['footer_social_links']): ?>
                    <?php get_template_part('blocks/social-links'); ?>
                <?php endif; ?>
                <!-- <div class="clear"></div>
                <div class="footer_extra_links">
                    <?php echo do_shortcode($inwave_theme_option['footer_extra_links']) ?>
                </div> -->
            </div>
            <div class="col-md-9 col-sm-9 footer-right">
                <div class="iw-footer-widget">
                    <?php
                    switch ($inwave_theme_option['footer_number_widget']) {
                        case '1':
                            if (is_active_sidebar('footer-widget-1')) {
                                dynamic_sidebar('footer-widget-1');
                            }
                            break;
                        case '2':
                            if (is_active_sidebar('footer-widget-1')) {
                                echo '<div class="col-lg-6 col-md-6 col-sm-6">';
                                dynamic_sidebar('footer-widget-1');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-2')) {
                                echo '<div class="col-lg-6 col-md-6 col-sm-6 last">';
                                dynamic_sidebar('footer-widget-2');
                                echo '</div>';
                            }
                            break;
                        case '3':
                            if (is_active_sidebar('footer-widget-1')) {
                                echo '<div class="col-lg-4 col-md-4 col-sm-12">';
                                dynamic_sidebar('footer-widget-1');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-2')) {
                                echo '<div class="col-lg-4 col-md-4 col-sm-12">';
                                dynamic_sidebar('footer-widget-2');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-3')) {
                                echo '<div class="col-lg-4 col-md-4 col-sm-12 last">';
                                dynamic_sidebar('footer-widget-3');
                                echo '</div>';
                                break;
                            }
                        case '4':
                            if (is_active_sidebar('footer-widget-1')) {
                                echo '<div class="col-lg-3 col-md-3 col-sm-6">';
                                dynamic_sidebar('footer-widget-1');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-2')) {
                                echo '<div class="col-lg-3 col-md-3 col-sm-6">';
                                dynamic_sidebar('footer-widget-2');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-3')) {
                                echo '<div class="col-lg-3 col-md-3 col-sm-6">';
                                dynamic_sidebar('footer-widget-3');
                                echo '</div>';
                            }
                            if (is_active_sidebar('footer-widget-4')) {
                                echo '<div class="col-lg-3 col-md-3 col-sm-6 last">';
                                dynamic_sidebar('footer-widget-4');
                                echo '</div>';
                            }
                            break;
                    }
                    ?>
                </div>
            </div>
         
        </div>
    </div>
</footer>
<div class="copy-right">
    <div class="container">
        <div class="row">
        <div class="col-md-6">
        <?php get_template_part('blocks/menu-footer'); ?>

            </div>
            <div class="col-md-6">
                <?php if ($inwave_theme_option['backtotop-button']): ?>
                    <div class="back-to-top"><a href="#page-top" title="Back to top" class="button-effect3"><i
                                class="fa fa-angle-double-up"></i></a></div>
                <?php endif; ?>
                <p><?php echo wp_kses_post($inwave_theme_option['footer-copyright']) ?></p>
            </div>
        </div>
    </div>
</div>