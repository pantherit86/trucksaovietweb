<?php
/*
 * @package Inwave Event
 * @version 1.0.0
 * @created Jun 8, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */


/**
 * Description of iw_slider
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Slider')) {

    class Inwave_Slider extends Inwave_Shortcode2{

        protected $name = 'inwave_slider';
        protected $name2 = 'inwave_slider_item';
        protected $count;

        function init_params() {
            return array(
                "name" => __("Slider", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_slider_item'),
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
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style Slider",
                        "param_name" => "style_slider",
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
                "name" => __("Inwave Slider Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_slider_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "as_child" => array('only' => 'inwave_slider'),
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Description", "inwavethemes"),
                        "value" => "",
                        "param_name" => "description"
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Profile Image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text Left", "inwavethemes"),
                        "param_name" => "button_text_left",
                        "holder" => "div",
                        "value"=>""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text Right", "inwavethemes"),
                        "param_name" => "button_text_right",
                        "holder" => "div",
                        "value"=>""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
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
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Text align", "inwavethemes"),
                        "param_name" => "align",
                        "value" => array(
                            "Default" => "",
                            "Left" => "left",
                            "Right" => "right",
                            "Center" => "center"
                        )
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __( 'CSS box', 'js_composer' ),
                        'param_name' => 'css',
                        // 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                        'group' => __( 'Design Options', 'js_composer' )
                    )
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            extract(shortcode_atts(array(
                "class" => "",
                "style_slider" => "style1"
                            ), $atts));
            $output = '<div class="iw-slider-shortcode iw-slider-block ' .$style_slider. ' ' . $class . '">';
            $output .= '<div id="iw-item-slider" class="dg-container fit-video">';
            $output .= '<div class="dg-wrapper">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="item-info-view"></div>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">';
            $output .= 'jQuery(document).ready(function () {';
            $output .= 'jQuery("#iw-item-slider").gallery();';
            $output .= '});';
            $output .= '</script>';
            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $img = $title = $description = $button_text_left = $button_text_right = $class = $align = $css = $style = '';
            extract(shortcode_atts(array(
                'img' => '',
                'title' => '',
                'description' => '',
                'button_text_left' => '',
                'button_text_right' => '',
                'class' => '',
                'align' => '',
                'css' => '',
                'style' => 'style1'
            ), $atts));
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($align){
                $class.= ' '.$align.'-text';
            }
            $img_tag = '';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }
            switch ($style) {
            case 'style1':
            case 'style3':
                $output .= '<div class="slider-box item item' . $this->count++ . ' ' . $class . '">';
                $output .= '<div class="slider-top">';
                if ($img_tag){
                    $output .= '<div class="item-image">' . $img_tag . '</div>';
                }
                if ($title){
                    $output .= '<div class="item-title">' . $title . '</div>';
                }
                $output .= '</div>';
                $output .= '<div class="item-info-wrap">';
                if ($description){
                    $output .= '<div class="item-info"><div class="item-description">' . $description . '</div></div>';
                }
                $output .= '<div class="iw-slider-action-button">';
                if ($button_text_left){
                    $output .= '<div class="donate-us-button iw-button-effect"><a class="ibutton-effect1 theme-bg" href="#"><span class="effect" data-hover="' .$button_text_left. '">' .$button_text_left. '</span></a></div>';
                }
                if ($button_text_right){
                    $output .= '<div class="iw-register-button iw-button-effect"><a href="#">' .$button_text_right. '</a></div>';
                }
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
            break;

            case 'style2':
                $output .= '<div class="slider-box item item' . $this->count++ . ' ' . $class . '">';
                $output .= '<div class="slider-top">';
                if ($img_tag){
                    $output .= '<div class="item-image">' . $img_tag . '</div>';
                }
                if ($title){
                    $output .= '<div class="item-title">' . $title . '</div>';
                }
                $output .= '</div>';
                $output .= '<div class="item-info-wrap">';
                if ($description){
                    $output .= '<div class="item-info ' .$style. '"><div class="item-description">' . $description . '</div></div>';
                }
                $output .= '<div class="iw-slider-action-button ' .$style. '">';
                if ($button_text_left){
                    $output .= '<div class="donate-us-button iw-button-effect"><a class="ibutton-effect1 theme-color" href="#"><span class="effect" data-hover="' .$button_text_left. '">' .$button_text_left. '</span></a></div>';
                }
                if ($button_text_right){
                    $output .= '<div class="iw-register-button iw-button-effect"><a class="theme-bg theme-color-hover" href="#">' .$button_text_right. '</a></div>';
                }
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                break;

            default:
            break;
            }
            return $output;
        }

    }

}

new Inwave_Slider();
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Slider extends WPBakeryShortCodesContainer {
    }
}