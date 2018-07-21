<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Team_Tab')) {

    class Inwave_Team_Tab extends Inwave_Shortcode2 {

        protected $name = 'inwave_team_tab';
        protected $name2 = 'inwave_team_item';
        protected $layout;
        protected $first_item;
        protected $full_width;

        function init_params() {
            return array(
                "name" => __("Team Tab", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a team.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_team_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Effect",
                        "param_name" => "effect",
                        "value" => array(
                            "Fade Slide" => "fade-slide",
                            "Horizontal Slide" => "horizontal-slide",
                            "Vertical Slide" => "vertical-slide"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }

        function init_params2() {
            return array(
                "name" => __("Team item", 'inwavethemes'),
                "base" => $this->name2,
                "content_element" => true,
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a team item.", "inwavethemes"),
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_team'),
                "as_parent" => array('except' => 'inwave_team,inwave_team_item'),
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Content Container",
                        "param_name" => "content_container",
                        "value" => array(
                            "Content with container" => "yes",
                            "Content without container" => "no",
                        )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => "Avatar",
                        "param_name" => "avatar",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $class = '';
            $id = 'iwteam-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                "effect" => "fade-slide",
                //'layout' => 'layout1'
            ), $atts));
            $this->first_item = true;
            $class .= ' ' . $effect;
            $output .= '<div class="iw-shortcode-tabs iw-team">';
            $output .= '<div id="' . $id . '" class="iw-tabs ' . $class . '">';
            $matches = array();
            $count = preg_match_all('/\[inwave_team_item\s+avatar="([^\"]+)"(.*)\]/Usi', $content, $matches);

            $this->full_width = false;
            $output.= '<div class="iw-tab-items">';
            if ($count) {
                if ($this->full_width) {
                    $output .='<div class="container">';
                }
                foreach ($matches[1] as $key => $value) {
                    $output.= '<div class="iw-tab-item ' . ($key == 0 ? 'active' : '') . '" style="width: ' . (100 / $count) . '%;">';
                    $output.= '<div class="iw-tab-item-inner">';
                    $output.= '<div class="iw-tab-image"><span>';
                    $img = wp_get_attachment_image_src($value);
                    $output.= '<img src="' . $img[0] . '" />';
                    $output.= '</span></div>';
                    $output.= '</div>';
                    $output.= '</div>';
                }
                if ($this->full_width) {
                    $output .='</div>';
                }
            }
            $output .= '</div>';
            $output .= '<div class="iw-tab-content">';
            $output .= '<div class="iw-tab-content-inner">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';


            $output .= '<div style="clear:both;"></div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function($){';
            $output .= '$(document).ready(function(){';
            $output .= '$("#' . $id . '").iwTabs("tab");';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';

            return $output;
        }

        // Shortcode handler function for item image
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $icon = $title = $sub_title = $description = $content_container = $class = '';
            $content = do_shortcode($content);
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);

            extract(shortcode_atts(array(
                'image' => '',
                'content_container' => 'yes',
                'class' => ''
                            ), $atts));

            $output .= '<div class="iw-tab-item-content ' . ($this->first_item ? 'active' : 'next') . ' ' . $class . '">';
            if ($this->full_width && $content_container == 'yes') {
                $output .= '<div class="container">';
            }
            $output .= $content;
            if ($this->full_width && $content_container == 'yes') {
                $output .= '</div>';
            }
            $output .= '</div>';
            if ($this->first_item) {
                $this->first_item = false;
            }

            return $output;
        }

    }

}

new Inwave_Team_Tab();

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Team_Tab extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Team_Item extends WPBakeryShortCodesContainer {
    }
}