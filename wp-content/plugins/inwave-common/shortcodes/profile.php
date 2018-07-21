<?php

/*
 * Inwave_Profile List for Visual Composer
 */
if (!class_exists('Inwave_Profile_Slider')) {

    class Inwave_Profile_Slider extends Inwave_Shortcode2{

        protected $name = 'inwave_profile_slider';
        protected $name2 = 'inwave_profile';
        protected $count;

        function init_params() {

            return array(
                "name" => __("Profile Slider", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_profile'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "class" => "",
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
                'name' => 'Profile Item',
                'description' => __('Show a personal profile', 'inwavethemes'),
                'base' => $this->name2,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_profile_slider'),
                "as_parent" => array('except' => 'inwave_profile_slider,inwave_profile'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "",
                        "param_name" => "name"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => __("Description", "inwavethemes"),
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => __("Social links", "inwavethemes"),
                        "description" => __("Separated by newline", "inwavethemes"),
                        "param_name" => "social_links",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Profile Image", "inwavethemes"),
                        "param_name" => "img"
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
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
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

        // Shortcode handler function for profile box slider
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $class='';
            extract(shortcode_atts(array(
                "class" => ""
                            ), $atts));
            $data_plugin_options = '"navigation":true, "autoHeight":true, "pagination":false, "paginationNumbers":true, "items":4, "itemsDesktop":[1199, 3], "itemsDesktopSmall":[980, 3], "itemsTablet":[768, 2], "itemsTabletSmall":false, "itemsMobile":[479, 1]';
            $output = '<div class="iw-profile-slider-block iw-slider-block ' . $class . '">';
            $output .= "<div class='owl-carousel' data-plugin-options='{" .$data_plugin_options. "}'>";
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function for profile box
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $img = $name = $position = $class = $align = $css = $description = $social_links = $style = '';
            extract(shortcode_atts(array(
                'img' => '',
                'name' => '',
                'position' => '',
                'class' => '',
                'align' => '',
                'css' => '',
                'social_links' => '',
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
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $name . '">';
            }
            $social_links = str_replace('<br />', "\n", $social_links);
            $social_links = explode("\n", $social_links);
            $description = do_shortcode($content);
            switch ($style) {
                case 'style1':
                    $output .= '<div class="profile-box ' . $class . '">';
                    $output .= '<div class="profile-image">';
                    $output .= '' . $img_tag . '';
                    $output.= '</div>';
                    $output .= '<div class="profile-info">';
                    $output .= '<div class="social-links">';
                    foreach ($social_links as $link) {
                        $domain = explode(".com", $link);

                        if ($link && isset($domain[0])) {

                            $domain = str_replace(array('https://', 'http://'), '', $domain[0]);
                            if ($domain == 'plus.google') {
                                $domain = 'google-plus';
                            }

                            $output .= '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
                        }
                    }
                    $output.= '</div>';
                    $output .= '<h3 class="name theme-color">' . $name . '</h3><div class="position">' . $position . '</div><div class="description">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;

                case 'style2':
                    $output .= '<div class="profile-box ' . $class . '">';
                    $output .= '<div class="profile-image">';
                    $output .= '' . $img_tag . '';
                    $output.= '</div>';
                    $output .= '<div class="profile-info">';
                    if ($name){
                        $output .= '<h3 class="name theme-bg">' . $name . '</h3>';
                    }
                    if ($position){
                        $output .= '<div class="position">' . $position . '</div>';
                    }
                    if ($description){
                    $output .= '<div class="description">' . $description . '</div>';
                }
                    $output .= '<div class="social-links">';
                    foreach ($social_links as $link) {
                        $domain = explode(".com", $link);

                        if ($link && isset($domain[0])) {

                            $domain = str_replace(array('https://', 'http://'), '', $domain[0]);
                            if ($domain == 'plus.google') {
                                $domain = 'google-plus';
                            }

                            $output .= '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
                        }
                    }
                    $output.= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }

            return $output;
        }
    }
}

new Inwave_Profile_Slider;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Profile_Slider extends WPBakeryShortCodesContainer {
    }
}