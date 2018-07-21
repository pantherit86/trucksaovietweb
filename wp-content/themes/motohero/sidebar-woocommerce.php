<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package motohero
 */

if (is_active_sidebar('sidebar-woocommerce')) {
    ?>
    <div id="secondary" class="widget-area" role="complementary">
        <?php dynamic_sidebar('sidebar-woocommerce'); ?>
    </div><!-- #secondary -->
<?php } ?>