<?php
/*
 * Inwave_Product_List for Visual Composer
 */
if (!class_exists('Inwave_Product')) {

    class Inwave_Product extends Inwave_Shortcode
    {

        protected $name = 'inwave_product';

        function __construct()
        {
            //Filters For autocomplete param:
            //For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
            add_action('vc_after_mapping', array(
                &$this,
                'mapShortcodes',
            ));
            parent::__construct();
        }

        public function mapShortcodes()
        {
            add_filter('vc_autocomplete_inwave_product_id_callback', array(
                &$this,
                'productIdAutocompleteSuggester',
            ), 10, 1); // Get suggestion(find). Must return an array

            add_filter('vc_autocomplete_inwave_product_id_render', array(
                &$this,
                'productIdAutocompleteRender',
            ), 10, 1); // Render exact product. Must return an array (label,value)
            //For param: ID default value filter
        }

        public function productIdAutocompleteSuggester($query)
        {
            global $wpdb;
            $product_id = (int)$query;
            $post_meta_infos = $wpdb->get_results($wpdb->prepare("SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : -1, stripslashes($query), stripslashes($query)), ARRAY_A);

            $results = array();
            if (is_array($post_meta_infos) && !empty($post_meta_infos)) {
                foreach ($post_meta_infos as $value) {
                    $data = array();
                    $data['value'] = $value['id'];
                    $data['label'] = __('Id', 'js_composer') . ': ' . $value['id'] . ((strlen($value['title']) > 0) ? ' - ' . __('Title', 'js_composer') . ': ' . $value['title'] : '') . ((strlen($value['sku']) > 0) ? ' - ' . __('Sku', 'js_composer') . ': ' . $value['sku'] : '');
                    $results[] = $data;
                }
            }

            return $results;
        }

        public function productIdAutocompleteRender($query)
        {
            $query = trim($query['value']); // get value from requested
            if (!empty($query)) {
                // get product
                $product_object = wc_get_product((int)$query);
                if (is_object($product_object)) {
                    $product_sku = $product_object->get_sku();
                    $product_title = $product_object->get_title();
                    $product_id = $product_object->id;

                    $product_sku_display = '';
                    if (!empty($product_sku)) {
                        $product_sku_display = ' - ' . __('Sku', 'js_composer') . ': ' . $product_sku;
                    }

                    $product_title_display = '';
                    if (!empty($product_title)) {
                        $product_title_display = ' - ' . __('Title', 'js_composer') . ': ' . $product_title;
                    }

                    $product_id_display = __('Id', 'js_composer') . ': ' . $product_id;

                    $data = array();
                    $data['value'] = $product_id;
                    $data['label'] = $product_id_display . $product_title_display . $product_sku_display;

                    return !empty($data) ? $data : false;
                }

                return false;
            }

            return false;
        }

        function init_params()
        {
            return array(
                'name' => __('WC Product', 'inwavethemes'),
                'description' => __('Show a single product', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'autocomplete',
                        'heading' => __('Select identificator', 'js_composer'),
                        'param_name' => 'id',
                        'description' => __('Input product ID or product SKU or product title to see suggestions', 'js_composer'),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ))
            );
        }

        // Shortcode handler function for list products woocommerce
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes($this->name, $atts) : $atts;

            if (!class_exists('Woocommerce')) {
                return;
            }
            $output = $id = $class = '';
            extract(shortcode_atts(array(
                'id' => '',
                'class' => ''
            ), $atts));
            ob_start();
            if (!$id) {
                return;
            }
            global $product, $post;
            $product = wc_get_product((int)$id);
            $parent_post = $post;
            $post = $product->post;
            if (is_object($product)) {

                ?>
                <div class="inwave-product woocommerce">
                    <?php
                    wc_get_template_part('content', 'product');
                    ?>
                </div>
                <?php
            }
            $output .= ob_get_contents();
            ob_end_clean();
            $post = $parent_post;
            return $output;
        }
    }
}

new Inwave_Product;
