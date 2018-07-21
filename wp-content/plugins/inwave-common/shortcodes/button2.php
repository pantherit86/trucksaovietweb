<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Button2')) {

    class Inwave_Button2 extends Inwave_Shortcode{

        protected $name = 'inwave_button2';

        function init_params() {
            return array(
                'name' => 'Button 2',
                'description' => __('Insert a button with some styles', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value"=>"Click here"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "value"=>"#"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Default" => "default",
                            "Outline" => "outline",
                            "Border Inline" => "inline",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Shape",
                        "admin_label" => true,
                        "param_name" => "shape",
                        "value" => array(
                            "Square" => "square",
                            "Rounded" => "rounded",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Color",
                        "admin_label" => true,
                        "param_name" => "color",
                        "value" => array(
                            "Theme Color" => "theme",
                            "White" => "white",
                            "Grey" => "grey",
                            "Custom" => "custom",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Button Color",
                        "param_name" => "button_color",
                        "value" => "",
                        "dependency" => array(
                            "element" => "color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Text Color",
                        "param_name" => "text_color",
                        "value" => "",
                        "dependency" => array(
                            "element" => "color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Button Hover Color",
                        "param_name" => "button_hover_color",
                        "value" => "",
                        "dependency" => array(
                            "element" => "color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Text Hover Color",
                        "param_name" => "text_hover_color",
                        "value" => "",
                        "dependency" => array(
                            "element" => "color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Button size",
                        "param_name" => "size",
                        "value" => array(
                            "Normal" => "normal",
                            "Small" => "small",
                            "Large" => "large",
                        )
                    ),
                    array(
                        "type" => "dropdown",
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
                        'type' => 'dropdown',
                        "heading" => __("Font Weight", "inwavethemes"),
                        "description" => __('Font Weight Button Text', "inwavethemes"),
                        "param_name" => "font_weight",
                        "value" => array(
                            "Default" => "",
                            "Extra Bold" => "900",
                            "Bold" => "700",
                            "Normal" => "400",
                            "Light" => "300"
                        )
                    ),
                    array(
                        "type" => "iw_icon",
                        "heading" => "Button Icon",
                        "param_name" => "button_icon"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Show Side Link",
                        "param_name" => "show_side_link",
                        "value" => array(
                            __("No", "inwavethemes") => "0",
                            __("Yes", "inwavethemes") => "1",
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Separator Text", "inwavethemes"),
                        "param_name" => "separator_text",
                        "value"=>"or",
                        "dependency" => array(
                            "element" => "show_side_link",
                            "value" => array("1")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Side Link Text", "inwavethemes"),
                        "param_name" => "side_link_text",
                        "value"=> __("Get in touch", "inwavethemes"),
                        "dependency" => array(
                            "element" => "show_side_link",
                            "value" => array("1")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Side Link", "inwavethemes"),
                        "param_name" => "side_link_link",
                        "value"=>"#",
                        "dependency" => array(
                            "element" => "show_side_link",
                            "value" => array("1")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
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

        function init_shortcode($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            extract(shortcode_atts(array(
                'class' => '',
                'button_text' => '',
                'font_weight' => '400',
                'button_link' => '',
                'style' => '',
                'shape' => '',
                'color' => '',
                'size' => '',
                'align' => '',
                'button_color' => '',
                'button_hover_color' => '',
                'text_color' => '',
                'text_hover_color' => '',
                'button_icon' => '',
                'show_side_link' => '',
                'separator_text' => '',
                'side_link_text' => '',
                'side_link_link' => '',
                'css' => '',
            ), $atts));

            $wrapper_classes = array(
                'iw-button-container',
                'text-' . $align. '',
                vc_shortcode_custom_css_class( $css)
            );

            if($class){
                $wrapper_classes[] = $class;
            }
            $extracss = '';
            $extracss .= 'style="';
            if($font_weight){
                $extracss .= 'font-weight: '.$font_weight.';';
            }
            $extracss .= '"';

            $button_classes = array(
                'iw-button',
                'iw-button-size-' . $size,
                'iw-button-shape-' . $shape,
                'iw-button-style-' . $style,
            );

            $button_html = $button_text;

            if ( '' === trim( $button_text ) ) {
                $button_classes[] = 'iw-button-o-empty';
                $button_html = '<span class="iw-button-placeholder">&nbsp;</span>';
            }
            if ( 'true' === $button_block && 'inline' !== $align ) {
                $button_classes[] = 'iw-button-block';
            }

            $side_link_html = '';
            if($show_side_link){
                $side_link_html .= '<span class="iw-button-separator">'.$separator_text.'</span>';
                    $side_link_text .= '<i class="fa fa-long-arrow-right"></i>';
                $side_link_html .= '<a class="side-link" href="'.esc_url($side_link_link).'" target="_blank">'.$side_link_text.'</a>';
            }

            $styles = $attributes = array();
            if ( 'custom' === $color ) {
                if('outline' == $style){
                    if ( $button_color ) {
                        $styles[] = vc_get_css_color( 'border-color', $button_color );
                        $styles[] = vc_get_css_color( 'color', $text_color );
                        $attributes[] = 'onmouseleave="this.style.borderColor=\'' . $button_color . '\'; this.style.backgroundColor=\'transparent\'; this.style.color=\'' . $text_color . '\'"';
                    } else {
                        $attributes[] = 'onmouseleave="this.style.borderColor=\'\'; this.style.backgroundColor=\'transparent\'; this.style.color=\'\'"';
                    }

                    $onmouseenter = array();
                    if ( $button_hover_color ) {
                        $onmouseenter[] = 'this.style.borderColor=\'' . $button_hover_color . '\';';
                        $onmouseenter[] = 'this.style.backgroundColor=\'' . $button_hover_color . '\';';
                    }
                    if ( $text_hover_color ) {
                        $onmouseenter[] = 'this.style.color=\'' . $text_hover_color . '\';';
                    }
                    if ( $onmouseenter ) {
                        $attributes[] = 'onmouseenter="' . implode( ' ', $onmouseenter ) . '"';
                    }
                }
                else
                {
                    if ( $button_color ) {
                        $styles[] = vc_get_css_color( 'background-color', $button_color );
                        $styles[] = vc_get_css_color( 'color', $text_color );
                        $attributes[] = 'onmouseleave="this.style.backgroundColor=\'' . $button_color . '\'; this.style.color=\'' . $text_color . '\'"';
                    } else {
                        $attributes[] = 'onmouseleave="this.style.borderColor=\'\'; this.style.backgroundColor=\'transparent\'; this.style.color=\'\'"';
                    }

                    $onmouseenter = array();
                    if ( $button_hover_color ) {
                        $onmouseenter[] = 'this.style.backgroundColor=\'' . $button_hover_color . '\';';
                    }
                    if ( $text_hover_color ) {
                        $onmouseenter[] = 'this.style.color=\'' . $text_hover_color . '\';';
                    }
                    if ( $onmouseenter ) {
                        $attributes[] = 'onmouseenter="' . implode( ' ', $onmouseenter ) . '"';
                    }
                }

                if ( ! $button_color && ! $button_hover_color && ! $text_hover_color ) {
                    $button_classes[] = 'iw-button-color-inverse';
                }
            } elseif($color) {
                $button_classes[] = 'iw-button-color-' . $color;
            }


            if ( $styles ) {
                $attributes[] = 'style="' . implode( ' ', $styles ) . '"';
            }
            $class = $style;

            $class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
            //$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->name, $atts );

            if ( $button_classes ) {
                $button_classes = esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $button_classes ) ), $this->name, $atts ) );
                $attributes[] = 'class="' . trim( $button_classes ) . '"';
            }

            if ( $button_link ) {
                $attributes[] = 'href="' . esc_url( trim( $button_link ) ) . '"';
                $attributes[] = 'title=""';
                $attributes[] = 'target="_blank"';
            }

            $attributes = implode( ' ', $attributes );
            $output .=  '<div ' .$extracss. ' class="' .trim( esc_attr( $css_class ) ). '">';
            $output .=  '<div class="iw-button-style ' .$class. '">';
                if ( $button_link ) {
                    $output .=   '<a ' . $attributes . '>' . $button_html . '</a>'.$side_link_html. '';
                } else {
                    $output .=   '<button ' . $attributes . '>' . $button_html . '</button>'.$side_link_html. '';
                }
            $output .=  '</div>';
            $output .=  '</div>';
            return $output;
        }
    }
}

new Inwave_Button2;
