<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
?>
<?php if ( $product->is_on_sale() ) : ?>
    <div class="iw-onsale-label">
	    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale-label">' . esc_html__( 'Sale!', 'motohero' ) . '</span>', $post, $product ); ?>
    </div>
<?php endif; ?>
