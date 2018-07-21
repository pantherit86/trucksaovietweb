<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
    <div class="more-views">
    <div class="owl-carousel owl-theme" id="owl-demo">
	<?php

	foreach ( $attachment_ids as $attachment_id ) {

		$classes = array( 'zoom' );

		if ( $loop === 0 || $loop % $columns === 0 ) {
			$classes[] = 'first';
		}

		if ( ( $loop + 1 ) % $columns === 0 ) {
			$classes[] = 'last';
		}

		$image_class = implode( ' ', $classes );
		$props       = wc_get_product_attachment_props( $attachment_id, $post );

		if ( ! $props['url'] ) {
			continue;
		}
		echo '<div class="item">';
		echo apply_filters(
			'woocommerce_single_product_image_thumbnail_html',
			sprintf(
				'<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>',
				esc_url( $props['url'] ),
				esc_attr( $image_class ),
				esc_attr( $props['caption'] ),
				wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
			),
			$attachment_id,
			$post->ID,
			esc_attr( $image_class )
		);
		echo '</div>';
		$loop++;
	}

	?>
    </div>
    </div>
	<?php
}
