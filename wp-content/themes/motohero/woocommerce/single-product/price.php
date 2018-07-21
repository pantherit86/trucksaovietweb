<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.2
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;


$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>


<div class="price-and-rating">

	<div class="price-box">
		<div class="price-box-inner">
			<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<?php echo wp_kses_post($product->get_price_html()); ?>
				<meta itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>" />
				<meta itemprop="priceCurrency" content="<?php echo esc_attr(get_woocommerce_currency()); ?>" />
				<link itemprop="availability" href="http://schema.org/<?php if($product->is_in_stock()){ echo 'InStock';} else{echo 'OutOfStock';}; ?>" />
			</div>
		</div>
	</div>

	<?php if ( $rating_count > 0 && get_option( 'woocommerce_enable_review_rating' ) !== 'no' ) : ?>
		<div class="rating-box">
			<div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<div class="star-rating" title="<?php printf( esc_html__( 'Rated %s out of 5', 'motohero' ), $average ); ?>">
				<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
					<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( esc_html__( 'out of %s5%s', 'motohero' ), '<span itemprop="bestRating">', '</span>' ); ?>
					<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'motohero' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
				</span>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="clear"></div>
</div>