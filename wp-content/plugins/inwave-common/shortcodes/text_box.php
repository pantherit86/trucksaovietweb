<?php
/*
 * @package Inwave Percentage
 * @version 1.0.0
 * @created October 8, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of athlete_map
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Text_Box')) {

    class Inwave_Text_Box extends Inwave_Shortcode{

        protected $name = 'inwave_text_box';

        function init_params() {
            return array(
                'name' => __("Text_box", 'inwavethemes'),
                'description' => __('Inwave Text Box', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "iw_icon",
                        "class" => "",
                        "heading" => __("Select Icon", "inwavethemes"),
                        "param_name" => "icon",
                        "value" => "",
                        "admin_label" => true,
                        "description" => __("Click and select icon of your choice. You can get complete list of available icons here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/icons/'>Font-Awesome</a>", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Icon Size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "description" => __("Example: 70", "inwavethemes"),
                        "value" => "70"
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }

        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $title = $icon = $icon_size = $class = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'title' => '',
                'icon' => '',
                'icon_size' => '70',
                'class' => ''
            ), $atts));
            if ($icon_size) {
                $size = 'style="width:' . $icon_size . 'px!important;"';
            }
            $extracss = '';
            $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
            $title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$title);
            $output .= '<div class="iw-text-box ' . $class . '">';
            if ($title) {
                $output .= '<div class="iw-text-box-title">' . $title . '</div>';
            }
            if ($icon) {
                $output .= '<div class="icon"><i style="font-size:'.$icon_size.'px" class="' . $icon . '"></i></div>';
            }
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Text_Box;
