<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package motohero
 */
$inwave_post_option = Inwave_Helper::getConfig();
get_template_part('footer/footer-' . $inwave_post_option['footer-option']);

?>
</div> <!--end .content-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
