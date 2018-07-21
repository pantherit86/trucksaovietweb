<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="quantity add-to-cart">
    <input type="text" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'motohero' ) ?>" class="input-text qty text" size="4" />
    <span onclick="increaseQty(this,<?php echo esc_attr( $step ); ?>)" class="increase-qty"><i class="fa fa-sort-up"></i></span>
    <span onclick="decreaseQty(this,<?php echo esc_attr( $step ); ?>)" class="decrease-qty"><i class="fa fa-sort-down"></i></span>
</div>
