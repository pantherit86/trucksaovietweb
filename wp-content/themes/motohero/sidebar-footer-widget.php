<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package inhost
 */
$inwave_post_option = Inwave_Helper::getConfig();

if ($inwave_post_option['footer-option'] == 'default' || $inwave_post_option['footer-option'] == 'v1') {
    ?>
    <div id="iw-sidebar-four" class="widget-area" role="complementary">
        <?php if (is_active_sidebar('sidebar-footer-email')): ?>
            <?php dynamic_sidebar('sidebar-footer-email'); ?>
        <?php endif; ?>
    </div><!-- #sidebar footer -->
    <?php
} else
    if ($inwave_post_option['footer-option'] == 'v2') {
        ?>
        <div id="iw-sidebar-four" class="widget-area" role="complementary">
            <?php if (is_active_sidebar('sidebar-footer1')): ?>
                <?php dynamic_sidebar('sidebar-footer1'); ?>
            <?php else: ?>
                <br/>
                <br/>
                <?php esc_html_e('This is the footer area. Please add more widgets in Appearance -> Widgets -> Sidebar Footer Default', 'motohero'); ?>
            <?php endif; ?>
        </div><!-- #sidebar footer -->
        <?php
    }
?>