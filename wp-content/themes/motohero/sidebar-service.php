<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package motohero
 */

if (is_active_sidebar('sidebar-service')) {
    ?>
    <div id="secondary" class="widget-area sidebar-service" role="complementary">
        <?php dynamic_sidebar('sidebar-service'); ?>
    </div><!-- #secondary -->
<?php } ?>