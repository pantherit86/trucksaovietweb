<?php

/*
 * Inwave_Video for Visual Composer
 */
if (!class_exists('Inwave_Text_Block')) {

    class Inwave_Text_Block extends Inwave_Shortcode{

        protected $name = 'inwave_text_block';

        function init_params() {
            return array(
                'name' => __("Text Block", 'inwavethemes'),
                'description' => __('Add a text block', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textarea_html",
                        "holder" => "div",
                        "heading" => __("Text", "inwavethemes"),
                        "param_name" => "content",
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
                        "type" => "colorpicker",
                        "heading" => __("Color", "inwavethemes"),
                        "param_name" => "color",
                        "description" => __('Color for this text block. Default body color', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Font Size", "inwavethemes"),
                        "param_name" => "size",
                        "description" => __('Font size of this text block. Default body font size', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Line Height", "inwavethemes"),
                        "param_name" => "line_height",
                        "description" => __('Line height of this text block. Default body line height', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Maximum Width", "inwavethemes"),
                        "param_name" => "max_width",
                        "description" => __('Maximum width of this text block. Default 100%', "inwavethemes"),
                        "value" => "",
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

            $output = $class = '';
            extract(shortcode_atts(array(
                'align' => '',
                'color' => '',
                'size' => '',
                'line_height' => '',
                'max_width' => '',
                'class' => '',
            ), $atts));

            $style = array();
            if($color){
                $style[] = 'color: '.esc_attr($color);
            }
            if($size){
                $style[] = 'font-size: '.esc_attr($size);
            }
            if($line_height){
                $style[] = 'line-height: '.esc_attr($line_height);
            }
            if($max_width){
                $style[] = 'max-width: '.esc_attr($max_width);
            }

            $style = $style ? 'style="'.implode("; ", $style).'"' : '';

            $output .= '<div class="inwave-text-block text-'.esc_attr($align).' '.esc_attr($class).'">';
                $output .= '<div '.$style.'>'.$content.'</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Text_Block;
