<?php
/**
 * Additional Information tab
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$heading = '';// apply_filters( 'woocommerce_product_additional_information_heading', esc_html__( 'Additional Information', 'motohero' ) );

?>

<?php if ( $heading ): ?>
	<h2><?php echo esc_html($heading); ?></h2>
<?php endif; ?>

<?php $product->list_attributes(); ?>
