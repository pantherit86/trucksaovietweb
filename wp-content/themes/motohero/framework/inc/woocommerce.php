<?php
/**
 * Support Woocommerce Template
 */

// do nothing if don't have woocommerce
if ( ! class_exists( 'WooCommerce' ) ){
    return;
}

class Inwave_WC_QuickView{
    function __construct(){
        add_action('wp_ajax_load_product_quick_view',array( $this, 'load_product_quick_view_ajax' ) );
        add_action( 'wp_ajax_nopriv_load_product_quick_view', array( $this, 'load_product_quick_view_ajax' ) );
    }

function load_product_quick_view_ajax() {

if ( ! isset( $_REQUEST['product_id'] ) ) {
die();
}



$product_id = intval( $_REQUEST['product_id'] );

// set the main wp query for the product
wp( 'p=' . $product_id . '&post_type=product' );


ob_start();
    global $product;
    $product = wc_get_product($product_id);

// load content template
wc_get_template( 'content-quickview-product.php');

echo ob_get_clean();

die();
}

}
new Inwave_WC_QuickView;

// New x day Class
// Init settings
class Inwave_WC_xdays
{
    function __construct(){
        $this->settings = array(
            array(
                'name' => esc_html__('Product Newness', 'motohero'),
                'desc' => esc_html__("Display the 'New' label for how many days?", 'motohero'),
                'id' => 'wc_iw_newlimitdays',
                'type' => 'number',
            )
        );

        add_option( 'wc_iw_newlimitdays', '30' );
        add_action('woocommerce_settings_image_options_after', array($this, 'admin_settings'), 20);
        add_action('woocommerce_update_options_catalog', array($this, 'save_admin_settings'));
        add_action('woocommerce_update_options_products', array($this, 'save_admin_settings'));
        add_action( 'woocommerce_showproduct_newlabel', array( $this, 'show_product_label' ), 30 );

    }
    //add setting
    function admin_settings() {
        woocommerce_admin_fields( $this->settings );
    }
    //save setting
    function save_admin_settings() {
        woocommerce_update_options( $this->settings );
    }
    //showlabel
    function show_product_label() {
        $postdate 		= get_the_time( 'Y-m-d' );
        $postdatestamp 	= strtotime( $postdate );
        $wc_iw_newlimitdays 		= get_option( 'wc_iw_newlimitdays' );
        if ( ( time() - ( 60 * 60 * 24 * $wc_iw_newlimitdays ) ) < $postdatestamp ) {
            echo '<span class="new-label">' . esc_html__( 'New', 'motohero' ) . '</span>';
        }
    }
}

// start xdays
new Inwave_WC_xdays;


add_action('init', 'inwave_start_session', 1);

/**  Init session for theme  */
function inwave_start_session()
{
    global $inwave_theme_option;
    if (!session_id()  && !headers_sent()) {
        session_start();
    }
    if (!isset($_SESSION['product-category-layout']) || !$_SESSION['product-category-layout']) {
        $_SESSION['product-category-layout'] =  $inwave_theme_option['product_listing_layout'];
        if($_SESSION['product-category-layout']==''){
            $_SESSION['product-category-layout'] == 'col';
        }
    }
    if (isset($_REQUEST['category-layout']) && $_REQUEST['category-layout']) {
        $_SESSION['product-category-layout'] = $_REQUEST['category-layout'];
    }
}
/** Destroy session */
function inwave_end_session()
{
    session_destroy();
}
