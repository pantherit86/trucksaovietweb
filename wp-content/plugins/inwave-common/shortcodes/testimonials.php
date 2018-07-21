<?php

/*
 * @package Inwave Inhost
 * @version 1.0.0
 * @created May 5, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of testimonials
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Testimonials')) {

    class Inwave_Testimonials extends Inwave_Shortcode2{

        protected $name = 'inwave_testimonials';
        protected $name2 = 'inwave_testimonial_item';
        protected $testimonials;
        protected $testimonial_item;
        protected $style;


        function register_scripts()
        {
            wp_register_style('pwsignaturetwo', plugins_url('inwave-common/assets/fonts/pwsignaturetwo/stylesheet.css'), array(), INWAVE_COMMON_VERSION);
            wp_enqueue_script('iw-testimonials', plugins_url('inwave-common/assets/js/iw-testimonials.js'), array('jquery'), INWAVE_COMMON_VERSION,true);
            wp_enqueue_style('iw-testimonials', plugins_url('inwave-common/assets/css/iw-testimonials.css'), array(), INWAVE_COMMON_VERSION);
        }

        function init_params()
        {
            return array(
                "name" => __("Testimonial Group", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of testimonial and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => $this->name2),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "iw-testimonials-style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Position next to avatar clickable" => "style1",
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
                "name" => __("Testimonial Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_testimonial_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a list of testimonials with some content and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                            "Style 3" => "style3",
                            "Style 4" => "style4"
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "",
                        "param_name" => "name"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position",
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Client Image", "inwavethemes"),
                        "param_name" => "image",
                        "value" => "",
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Link", "inwavethemes"),
                        "value" => "",
                        "param_name" => "link",
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "iw-testimonials-rate",
                        "heading" => "Rate",
                        "param_name" => "rate",
                        "value" => array(
                            "Select rate" => "0",
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4",
                            "5" => "5"
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

            $output = $class = $style = '';
            //$id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1",
            ), $atts));

            $this->style = $style;

            $matches = array();
            $count = preg_match_all( '/inwave_testimonial_item([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
            if ($count) {
                switch ($style){
                    case 'style1':
                        $output .= '<div class="iw-testimonals style1 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $output .= do_shortcode($content);
                        $items = array();
                        foreach ($matches[1] as $value) {
                            $items[] = shortcode_parse_atts( $value[0] );
                        }
                        $output.= '</div>';
                        $output.= '<div class="testi-owl-clientinfo">';
                        foreach ($items as $key => $item) {
                            $image = $item['image'];
                            if ($image) {
                                $img = wp_get_attachment_image_src($image);
                                $image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
                            }
                            $output.= '<div data-item-active="' . $key . '" class="iw-testimonial-client-item ' . ($key == 0 ? 'active' : '') . '">';
                            $output.= '<div class="testi-image">' . $image . '</div>';
                            $output.= '</div>';
                        }
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                    case 'style2':
                        $output .= '<div class="iw-testimonals style2 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $items = array();

                        foreach ($matches[1] as $value) {
                            $items[] = shortcode_parse_atts( $value[0] );
                        }
                        foreach ($items as $key => $item) {
                            $text = html_entity_decode($item['testimonial_text']);
                            $name = html_entity_decode($item['name']);
                            $position = html_entity_decode($item['position']);
                            $image = $item['image'];
                            if ($image) {
                                $img = wp_get_attachment_image_src($image);
                                $image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
                            }
                            $output.= '<div class="iw-testimonial-item ' . ($key == 0 ? 'active' : '') . '">';
                            $output.= '<div class="testi-content">' . $text . '</div>';
                            $output.= '<div class="testi-client-name">' . $name . '</div>';
                            $output.= '<div class="testi-client-position">' . $position . '</div>';
                            if ($image) {
                                $output.= '<div class="testi-image">' . $image . '</div>';
                            }
                            $output.= '</div>';
                        }
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                    case 'style3':
                        $output .= '<div class="iw-testimonals style3 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $output .= do_shortcode($content);
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                }
            }

            $output .= '<div style="clear:both;"></div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function ($) {';
            $output .= '$(document).ready(function () {';
            $output .= '$(".iw-testimonals").iwCarousel();';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';

            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $name = $position = $title = $image =  $link = $rate = $style = $class = '';
            extract(shortcode_atts(array(
                'name' => '',
                'position' => '',
                'title' => '',
                'image' => '',
                'link' => '',
                'rate' => '',
                'style' => '',
                'class' => ''
            ), $atts));
            $ht_rate = '';
            if ($rate) {
                for ($i = 0; $i < 5; $i++) {
                    $ht_rate.='<span' . ($i < $rate ? ' class="active theme-color"' : '') . '><i class="fa fa-star"></i></span>';
                }
            }
            $img_tag = '';
            if ($image) {
                $image = wp_get_attachment_image_src($image, 'large');
                $image = $image[0];
                $size = '';
                $img_tag .= '<img ' . $size . ' src="' . $image . '" alt="' . $name . '">';
            }
            if($link){
                $title='<a href="'.$link.'">'.$title.'</a>';
            }

            $output .= '<div class="iw-testimonial-item ' . $class . ' ' . $style . '">';
            switch ($style) {
                case 'style1':
                case 'style2':
                    $output .= '<div class="content">';
                        $output .= '<div class="testi-title theme-color">' .$title . '</div>';
                        $output .= '<div class="testi-text">' .$content . '</div>';
                        $output .= '<div class="testi-rate">' . $ht_rate . '</div>';
                    $output .= '</div>';
                    $output .= '<div class="testi-author">';
                        $output .= '<div class="testi-image">' . $img_tag . '</div>';
                        $output .= '<div class="name-position">';
                            $output .= '<div class="testi-name theme-color">' .$name . '</div>';
                            $output .= '<div class="testi-position">' .$position . '</div>';
                        $output .= '</div>';
                        $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
                case 'style3':
                    $output .= '<div class="testi-author">';
                    $output .= '<div class="testi-image">' . $img_tag . '</div>';
                    $output .= '<div class="name-position">';
                    $output .= '<div class="testi-name theme-color">' .$name . '</div>';
                    $output .= '<div class="testi-position">' .$position . '</div>';
                    $output .= '</div>';
                    $output .= '<div class="content">';
                    $output .= '<div class="testi-title theme-color">' .$title . '</div>';
                    $output .= '<div class="testi-text">' .$content . '</div>';
                    $output .= '<div class="testi-rate">' . $ht_rate . '</div>';
                    $output .= '</div>';
                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
                case 'style4':

                    wp_enqueue_style('pwsignaturetwo');
                    
                    $output .= '<div class="testi-image">' . $img_tag . '</div>';
                    $output .= '<div class="content">';
                    $output .= '<div class="testi-title">' .$title . '</div>';
                    $output .= '<div class="testi-text">' .$content . '</div>';
                    $output .= '<div class="testi-rate">' . $ht_rate . '</div>';
                    $output .= '<div class="testi-author">';
                    $output .= '<div class="name-position">';
                    $output .= '<div class="testi-name">' .$name . '</div>';
                    $output .= '<div class="testi-position">' .$position . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';


                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
            }
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Testimonials;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Testimonials extends WPBakeryShortCodesContainer {}
}
