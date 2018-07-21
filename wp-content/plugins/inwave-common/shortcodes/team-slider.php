<?php

/*
 * Inwave_Member List for Visual Composer
 */
if (!class_exists('Inwave_Team_Slider')) {

    class Inwave_Team_Slider extends Inwave_Shortcode{

        protected $name = 'inwave_team_slider';

        function init_params() {

            return array(
                "name" => __("Team Slider", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_member'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
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

        // Shortcode handler function for member box slider
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $class='';
            extract(shortcode_atts(array(
                "class" => ""
                            ), $atts));
            $data_plugin_options = '"navigation":true, "autoHeight":true, "pagination":false, "paginationNumbers":true, "items":3, "itemsDesktop":[1199, 3], "itemsDesktopSmall":[980, 3], "itemsTablet":[768, 2], "itemsTabletSmall":false, "itemsMobile":[479, 1]';
            $output = '<div class="iw-member-slider-block iw-slider-block ' . $class . '">';
            $output .= "<div class='owl-carousel' data-plugin-options='{" .$data_plugin_options. "}'>";
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Team_Slider;

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Team_Slider extends WPBakeryShortCodesContainer {
    }
}