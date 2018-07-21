<?php

/*
 * Inwave_Sponsors_Slider for Visual Composer
 */
if (!class_exists('Inwave_Sponsors_Slider')) {

    class Inwave_Sponsors_Slider extends Inwave_Shortcode2{

        protected $name = 'inwave_sponsors_slider';
        protected $name2 = 'inwave_sponsors';
        protected $count;

        function init_params() {
            return array(
                "name" => __("Sponsors", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of sponsors and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_sponsors'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                            "Style 3" => "style3"
                        )
                    )
                )
            );
        }

        function init_params2(){

            return array(
                "name" => __("Inwave Sponsors", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_sponsors",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_sponsors_slider'),
                "as_parent" => array('except' => 'inwave_sponsors_slider,inwave_sponsors'),
                "params" => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Icon Image", "inwavethemes"),
                        "param_name" => "img",
                        "description" => __("Use for style 4", "inwavethemes"),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1"
                        )
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

            $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"
            ), $atts));
            $this->style = $style;

            $class .= ' '. $style;

            $output = '<div class="iw-sponsors-list ' . $class . '">';
            $output .= do_shortcode($content);
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $class = $style = $img_tag = '';
            $description = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'img' => '',
                'style' => 'style1',
                'class' => ''
            ), $atts));

            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="">';
            }
            switch ($style) {
                case 'style1':
                    $output .= '<div class="iw-sponsors-item ' . $class . '">';
                    if ($img_tag) {
                        $output .= $img_tag;
                    }
                    $output .= '</div>';
                break;

                default:

                break;
            }

            return $output;
        }
    }
}

new Inwave_Sponsors_Slider;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Sponsors_Slider extends WPBakeryShortCodesContainer {
    }
}
