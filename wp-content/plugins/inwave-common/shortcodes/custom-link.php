<?php

/*
 * Inwave_Video for Visual Composer
 */
if (!class_exists('Inwave_Custom_Link')) {

    class Inwave_Custom_Link extends Inwave_Shortcode{

        protected $name = 'inwave_custom_link';

        function init_params() {
            return array(
                'name' => __("Custom Link", 'inwavethemes'),
                'description' => __('Add a Custom link with icon', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "param_name" => "title",
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "param_name" => "sub_title",
                        "value" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Alignment", "inwavethemes"),
                        "param_name" => "align",
                        "description" => __('Alignment for this text block', "inwavethemes"),
                        "value" => array(
                            __('Default', "inwavethemes") => '',
                            __('Left', "inwavethemes") => 'left',
                            __('Right', "inwavethemes") => 'right',
                            __('Center', "inwavethemes") => 'center',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link",
                        "value" => "#",
                    ),
                    array(
                        "type" => "iw_icon",
                        "heading" => __("Icon", "inwavethemes"),
                        "param_name" => "icon",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $title = $sub_title = $link = $icon = $align = $class = '';
            extract(shortcode_atts(array(
                'align' => '',
                'title' => '',
                'sub_title' => '',
                'link' => '#',
                'icon' => '',
                'class' => '',
            ), $atts));

            $output .= '<div class="inwave-custom-link '.esc_attr($align).'-text '.esc_attr($class).'">';
            $output .= '<a href="'.esc_url($link).'">';
                    if ($icon) {
                        $output .= '<div class="icon">';
                        $output .= '<i class="'.esc_attr($icon).'"></i>';
                        $output .= '</div>';
                    }
                    $output .= '<div class="text">';
                        if ($title) {
                            $output .= '<div class="title">' .$title. '</div>';
                        }
                        if ($sub_title) {
                            $output .= '<div class="sub-title">' .$sub_title. '</div>';
                        }
                    $output .= '</div>';
                    $output .= '<div style="clear: both"></div>';
                $output .= '</a>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Custom_Link;
