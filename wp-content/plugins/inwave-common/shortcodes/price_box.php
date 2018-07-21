<?php
/*
 * Inwave_Price_Box for Visual Composer
 */
if (!class_exists('Inwave_Price_Box')) {

    class Inwave_Price_Box extends Inwave_Shortcode{

        protected $name = 'inwave_price_box';

        function __construct() {
            parent::__construct();
            add_shortcode('inwave_rate', array($this, 'init_shortcode'));
        }

        function init_params() {
            return array(
                'name' => __("Price Box", 'inwavethemes'),
                'description' => __('Add a price box & some information', 'inwavethemes'),
                'base' => $this->name,
                'wrapper_class' => 'clearfix',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Package name/Title", "inwavethemes"),
                        "value" => "Lorem ipsum dolor sit amet",
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Price Description", "inwavethemes"),
                        "param_name" => "price_desc"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase button text", "inwavethemes"),
                        "param_name" => "purchase_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Price", "inwavethemes"),
                        "param_name" => "price",
                        "dependency" => array(
                                            'element' => 'style',
                                            'value' => 'style1'
                                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Purchase link", "inwavethemes"),
                        "param_name" => "purchase_link"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Features",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Select image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        'type' => 'iw_icon',
                        "heading" => __("Or select icon", "inwavethemes"),
                        "param_name" => "icon"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Icon size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "value" => '36px'
                    ),
                    array(
                        'type' => 'dropdown',
                        "heading" => __("Featured", "inwavethemes"),
                        "param_name" => "featured",
                        "value" => array(
                            "No" => '0',
                            "Yes" => '1'
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);
            $output = $img = $title = $sub_title = $class = $style = $icon_size = $purchase_text = $purchase_link = $price = $price_desc = $icon = $featured = '';
            extract(shortcode_atts(array(
                'img' => '',
                'icon' => '',
                'icon_size' => '36px',
                'title' => '',
                'class' => '',
                'purchase_link' => '',
                'purchase_text' => '',
                'price' => '',
                'style' => 'style1',
                'featured' => '',
                'price_desc' => '',
                            ), $atts));

            $title = preg_replace('/\|(.*)\|/isU', '<strong>$1</strong>', $title);
            $title = preg_replace('/\{(.*)\}/isU', '<span class="theme-color">$1</span>', $title);

            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $icon = '<img style="width:' . $icon_size . '"src="' . $img . '" alt="">';
            } else {
                $icon = '<i style="font-size:' . $icon_size . '" class="theme-color ' . $icon . '"></i>';
            }
            $class .= ' ' . $style;
            if ($featured) {
                $class .= ' featured featured-image';
            }
            if (!$price) {
                $class .= ' no-price';
            }
            ob_start();
            switch ($style) {
                case 'style1': ?>
                    <div class="pricebox <?php echo $class ?>">
                        <div class="pricebox-col1">
                            <h3 class="pricebox-title theme-color"><?php echo $title ?></h3>
                            <?php if ($price_desc) { ?>
                                <div class="pricebox-price-desc"><?php echo $price_desc ?></div>
                            <?php } ?>

                        </div>
                        <div class="pricebox-col2">
                            <div class="pricebox-description"><?php echo do_shortcode($content) ?></div>
                        </div>
                        <div class="pricebox-col3 theme-bg">
                            <div class="pricebox_starting"><?php echo __("Starting in", "inwavethemes"); ?></div>
                            <?php
                            if ($price) {
                            $price_arr = explode('.', $price);
                            ?>
                                <div class="pricebox-price">
                                    <?php echo $price_arr[0];?>.<sup><?php echo $price_arr[1];?></sup>
                                </div>
                            <?php } ?>
                            <?php if ($purchase_text) { ?>
                                <div class="pricebox-purchased-link button-effect2">
                                    <a href="<?php echo $purchase_link ?>" class="ibutton button-text"><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>
                                </div>
                            <?php } ?>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <?php
                    break; ?>
                <?php case 'style2': ?>
                    <div class="pricebox <?php echo $class ?>">
                        <div class="pricebox-col1">
                            <h3 class="pricebox-title theme-color"><?php echo $title ?></h3>
                            <?php if ($price_desc) { ?>
                                <div class="pricebox-price-desc"><?php echo $price_desc ?></div>
                            <?php } ?>

                        </div>
                        <div class="pricebox-col2">
                            <div class="pricebox-description"><?php echo do_shortcode($content) ?></div>
                        </div>
                        <div class="pricebox-col3 theme-bg">
                            <div class="pricebox_starting"><?php echo __("please", "inwavethemes"); ?></div>
                            <div class="pricebox_call"><?php echo __("call us", "inwavethemes"); ?></div>
                            <?php if ($purchase_text) { ?>
                                <div class="pricebox-purchased-link button-effect2">
                                    <a href="<?php echo $purchase_link ?>" class="ibutton button-text"><span class="ibutton-inner"><?php echo $purchase_text ?></span></a>
                                </div>
                            <?php } ?>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <?php
                    break;
            }
            $html = ob_get_contents();
            ob_end_clean();

            return $html;
        }

        function rate_shortcode($atts, $content = null) {
            $output = $value = '';
            extract(shortcode_atts(array(
                'value' => '5'
            ), $atts));
            $output .= '<span class="iw-rate">';
            if ($value) {
                for ($i = 0; $i < 5; $i++) {
                    $output .= '<span' . ($i < $value ? ' class="active theme-color"' : '') . '><i class="fa fa-star"></i></span>';
                }
            }
            $output .= '</span>';

            return $output;
        }
    }
}

new Inwave_Price_Box;
