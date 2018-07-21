<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
global $product,$inwave_theme_option;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

// Ensure visibility
if (!$product || !$product->is_visible()) {
    return;
}


// Extra post classes
$classes = array('product-image-wrapper','woo-list-product-grid');

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>
<div <?php post_class($classes);?>>
    <?php //do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="iw-product-content">
        <div class="product-image">
            <a href="<?php the_permalink(); ?>">
				<?php echo wp_kses_post($product->get_image()); ?>
			</a>
            <div class="product-status">
                <?php do_action('woocommerce_showproduct_newlabel'); ?>
                <?php if ($product->is_on_sale()): ?>
                    <?php echo apply_filters('woocommerce_sale_flash', '<div class="iw-onsale-label"><span class="onsale-label">' . esc_html__('Sale', 'motohero') . '</span></div>', $post, $product); ?>
                <?php endif; ?>
            </div>
            <div class="actions">
                <?php if($inwave_theme_option['woocommerce_quickview']):?>
                    <a href="#<?php the_ID(); ?>" class="arrows quickview theme-bg">
                        <i class="fa fa-arrows-alt"></i>
                        <input type="hidden" value="<?php echo esc_attr($inwave_theme_option['woocommerce_quickview_effect']);?>" />
                    </a>
                <?php endif; ?>

                <?php if(class_exists('YITH_WCWL')): ?>
                    <a href="<?php echo esc_url(YITH_WCWL()->get_addtowishlist_url()); ?>" rel="nofollow"
                       data-product-id="<?php echo esc_attr($product->get_id()) ?>"
                       data-product-type="<?php echo esc_attr($product->get_type()); ?>" class="link-wishlist add_to_wishlist theme-bg">
                        <i class="fa fa-heart"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="info-products">
            <div class="product-name">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
			<div class="price-box">
				<div class="price-box-inner">
					<?php echo wp_kses_post($product->get_price_html()); ?>
				</div>
            </div>
            <div class="cart-rating theme-bg">
                <?php if ( $rating_count > 0 ) : ?>
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
                <div class="add-cart">
                    <a class="add_to_cart_button product_type_simple" data-product_id="<?php echo esc_attr($product->get_id()) ?>" data-product_sku="<?php echo esc_attr($product->get_sku()) ?>" href="<?php echo esc_url($product->add_to_cart_url())?>" data-quantity="1"><span><?php echo esc_html__( 'Add to cart', 'motohero' ) ?></span>
                    </a>
                </div>
                <div style="clear: both"></div>
            </div>

        </div>
    </div>

</div>
