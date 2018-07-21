<?php

/*
 * Inwave_Layers_Effect for Visual Composer
 */
if (!class_exists('Inwave_Layers_Effect')) {

    class Inwave_Layers_Effect extends Inwave_Shortcode2{

        protected $name = 'inwave_layers_effect';
        protected $name2 = 'inwave_layer';

        function register_scripts()
        {
            wp_enqueue_script('scroll-parallax');
        }

        function init_params() {
            return array(
                "name" => __("Layers Effect", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of layers and give a scene parallax effect.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_layer'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => __("Position", "inwavethemes"),
                        "param_name" => "position",
                        "description" => __("Choose position fix or absolute", 'inwavethemes'),
                        "value" => array(
                            'Fixed' => 'fixed',
                            'Absolute' => 'absolute'
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Z-Index", "inwavethemes"),
                        "param_name" => "zindex",
                        "value" => "-1",
                        "description" => __("Enter integer number number. (-1) value means that the Layers Effect is behind other objects", 'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Height", "inwavethemes"),
                        "param_name" => "height",
                        "value" => "100%",
                        "description" => __("Height in pixel. Example:500px. Default value is 100%", 'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
        }

        function init_params2(){

            return array(
                "name" => __("Layer", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_layer",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a list of layers_effect with some content and give some custom style.", "inwavethemes"),
                "as_child" => array('only' => 'inwave_layers_effect'),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Layer Background", "inwavethemes"),
                        "holder" => "div",
                        "param_name" => "img"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Data Depth", "inwavethemes"),
                        "param_name" => "data_depth",
                        "value" => "",
                        "description" => __("Depth of the layer. A depth of 0 will cause the layer to remain stationary, and a depth of 1 will cause the layer to move by the total effect of the calculated motion. Values inbetween 0 and 1 will cause the layer to move by an amount relative to the supplied ratio.", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Opacity", "inwavethemes"),
                        "param_name" => "opacity",
                        "value" => "",
                        "description" => __("Opacity of the layer", "inwavethemes"),
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Text",
                        "param_name" => "content"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $height = $zindex = $position = $class = '';
            extract(shortcode_atts(array(
                "class" => "",
                "height" => "100%",
                "zindex" => "-1",
                "position" => "fixed"
                            ), $atts));

            $style = '';

            if ($position) {
                $style .= 'position:' . $position . ';';
            }
            $style .= 'z-index:' . $zindex . ';';
            if ($height) {
                $style .= 'height:' . $height . ';';
            }

            if ($zindex) {
                $style .= 'z-index:' . $zindex . ';';
            }
            $output .= '<ul id="scene" class="layers-effect ' . $class . '" style="' . $style . '">';
            $output .= do_shortcode($content);
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $img = $data_depth = $class = $opacity = '';
            extract(shortcode_atts(array(
                'img' => '',
                'class' => '',
                'opacity' => '',
                'data_depth' => '0'
                            ), $atts));

            $output .= '<li class="layer" data-depth="' . $data_depth . '">';

            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $img = 'background-image:url(' . $img . ');';
            }
            if ($opacity) {
                $opacity = 'opacity:' . $opacity . ';"';
            }
            $output .= '<div class="layer-img ' . $class . '" style="' . $img . $opacity . '">';
            $output .= $content;
            $output .= '</div>';
            $output .= '</li>';

            return $output;
        }
    }
}

new Inwave_Layers_Effect;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Layers_Effect extends WPBakeryShortCodesContainer {
    }
}
