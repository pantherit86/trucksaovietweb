<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Button')) {

    class Inwave_Button extends Inwave_Shortcode{

        protected $name = 'inwave_button';

        function init_params() {
            return array(
                'name' => __("Button", 'inwavethemes'),
                'description' => __('Insert a button with some styles', 'inwavethemes'),
                'base' => 'inwave_button',
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Button style",
                        "param_name" => "style",
                        "value" => array(
                            "Button - Outline" => "button1",
                            "Button - Border none" => "button2",
                            "Button - Background Beveled" => "button3",
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value"=>"Click here"
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
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "value"=>"#"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Button size",
                        "param_name" => "button_size",
                        "value" => array(
                            "Normal" => "button-normal",
                            "Small" => "button-small",
                            "Large" => "button-large",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Background Color",
                        "param_name" => "background_color",
                        "description" => "Select background color for the button.",
                        "value" => array(
                            "Theme Color" => "theme-bg",
                            "White" => "bg-white",
                            "Grey" => "bg-grey",
                            "None" => "bg-none",
                            "Custom" => "custom",
                        )
                    ),
                    array(
                        "type" => "colorpicker",
                        "heading" => "Background Color Custom",
                        "param_name" => "background_color_custom",
                        "description" => "Select background color for the button. Example '#db084d'",
                        "dependency" => array(
                            "element" => "background_color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Text Color",
                        "param_name" => "text_color",
                        "description" => "Select text color for the button.",
                        "value" => array(
                            "White" => "color-white",
                            "Theme Color" => "theme-color",
                            "Grey" => "color-grey",
                            "Custom" => "custom",
                        )
                    ),
                    array(
                        "type" => "colorpicker",
                        "heading" => "Text Color Custom",
                        "param_name" => "text_color_custom",
                        "description" => "Select text color for the button. Example '#db084d'",
                        "dependency" => array(
                            "element" => "text_color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Border Color",
                        "param_name" => "border_color",
                        "description" => "Select border color for the button.",
                        "value" => array(
                            "Grey" => "border-grey",
                            "White" => "border-white",
                            "Theme Color" => "theme-color-border",
                            "Custom" => "custom",
                        ),
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("button1")
                        )
                    ),
                    array(
                        "type" => "colorpicker",
                        "heading" => "Border Color Custom",
                        "param_name" => "border_color_custom",
                        "description" => "Select border text color for the button. Example '#db084d'",
                        "dependency" => array(
                            "element" => "border_color",
                            "value" => array("custom")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style Hover",
                        "heading" => "Background Color Hover",
                        "param_name" => "background_color_hover",
                        "description" => "Select background color hover for the button.",
                        "value" => array(
                            "Normal" => "",
                            "Theme Color" => "theme-bg_hover",
                            "White" => "bg-white-hover",
                            "Grey" => "bg-grey-hover",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style Hover",
                        "heading" => "Text Color Hover",
                        "param_name" => "text_color_hover",
                        "description" => "Select text color for the button.",
                        "value" => array(
                            "Normal" => "",
                            "Theme Color" => "theme-color-hover",
                            "White" => "color-white-hover",
                            "Grey" => "color-grey-hover",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style Hover",
                        "heading" => "Border Color Hover",
                        "param_name" => "border_color_hover",
                        "description" => "Select border color for the button.",
                        "value" => array(
                            "Normal" => "",
                            "Theme Color" => "theme-color-border-hover",
                            "Grey" => "border-grey-hover",
                            "White" => "border-white-hover",
                        ),
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("button1")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style Hover",
                        "heading" => __("Button Effect", "inwavethemes"),
                        "param_name" => "button_effect",
                        "value" => array(
                            "None" => "",
                            "Effect Style1" => "button-effect1",
                            "Effect Style2" => "button-effect2"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Shape",
                        "param_name" => "shape",
                        "value" => array(
                            "Square" => "square",
                            "Rounded" => "rounded",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Button Width",
                        "param_name" => "button_width",
                        "value" => array(
                            "Width Auto" => "width-auto",
                            "Full Width" => "full-width",
                        )
                    ),
                    array(
                        "type" => "iw_icon",
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
                        "description" => __("Example: 40", "inwavethemes"),
                        "value" => "36"
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

            $output = $class = $button_link = $button_text = $font_weight = $align = $css = $background_color = $background_color_custom = $text_color = $text_color_custom = $border_color = $border_color_custom = $button_size = $shape = $button_width = $icon = $icon_size =
            $style = $background_color_hover = $text_color_hover = $border_color_hover = $button_effect = '';
            extract(shortcode_atts(array(
                'class' => '',
                'button_link' => '',
                'button_text' => '',
                'font_weight' => '',
                'background_color' => '',
                'text_color' => '',
                'border_color' => '',
                'background_color_custom' => '',
                'text_color_custom' => '',
                'border_color_custom' => '',
                'background_color_hover' => 'Normal',
                'text_color_hover' => 'Normal',
                'border_color_hover' => 'Normal',
                'button_effect' => 'None',
                'align' => '',
                'css' => '',
                'button_size' => '',
                'style' => 'button1',
                'shape' => 'square',
                'button_width' => 'width-auto',
                'icon' => '',
                'icon_size' => '36',
            ), $atts));

            return self::inwave_button_shortcode_html($button_link,$button_text,$font_weight,$align,$css,$background_color,$background_color_custom,$text_color,$text_color_custom,$border_color,$border_color_custom,$button_size,$style,$shape,$button_width,$icon,$icon_size,$background_color_hover,$text_color_hover,$border_color_hover,$button_effect,$class);
        }

        public static function inwave_button_shortcode_html($button_link,$button_text,$font_weight,$align,$css,$background_color,$background_color_custom,$text_color,$text_color_custom,$border_color,$border_color_custom,$button_size,$style ='',$shape,$button_width,$icon,$icon_size,$background_color_hover,$text_color_hover,$border_color_hover,$button_effect,$class =''){
            $output='';
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);
            if($button_size !='button-normal'){
                $class .= ' i' . $button_size;
            }
            if($align){
                $class.= ' '.$align.'-text';
            }
            if($icon){
                $class.= ' button-icon';
            }
            if($button_effect){
                $class.= ' '.$button_effect;
            }
            $classcss_button = '';
            if($background_color){
                $classcss_button.= ' '.$background_color;
            }
            if($text_color){
                $classcss_button.= ' '.$text_color;
            }
            if($border_color){
                $classcss_button.= ' '.$border_color;
            }
            if($shape){
                $classcss_button.= ' '.$shape;
            }
            if($button_width){
                $classcss_button.= ' '.$button_width;
            }
            $class_hover = '';
            if($background_color_hover){
                $class_hover.= ' '.$background_color_hover;
            }
            if($text_color_hover){
                $class_hover.= ' '.$text_color_hover;
            }
            if($border_color_hover){
                $class_hover.= ' '.$border_color_hover;
            }
            $extracss = '';
            $extracss .= 'style="';
            if($background_color_custom){
                $extracss .= 'background: '.$background_color_custom.';';
            }
            if($text_color_custom){
                $extracss .= 'color: '.$text_color_custom.';';
            }
            if($border_color_custom){
                $extracss .= 'border-color: '.$border_color_custom.';';
            }
            if($font_weight){
                $extracss .= 'font-weight: '.$font_weight.';';
            }
            $extracss .= '"';
            $bg_button3 = '';
            $bg_button3 .= 'style="';
            if($background_color_custom){
                $bg_button3 .= 'background: '.$background_color_custom.';';
            }
            $bg_button3 .= '"';
            $icon_html = '';
            if($icon) {
                $icon_html = '<i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i>';
            }
            switch($style){
                case 'button1':
                    $output .=  '<div class="iw-button '.$class.'">';
                    $output .=  '<div class="iw-button-text' .$class_hover. '">';
                    $output .= '<a '.$extracss.' class="button-text '.$classcss_button.'" href="'.$button_link.'">'.$icon_html.''.$button_text.'</a>';
                    $output .= '</div>';
                    $output .=  '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
                case 'button2':
                    $output .=  '<div class="iw-button '.$class.'">';
                    $output .=  '<div class="iw-button-text' .$class_hover. '">';
                    $output .= '<a '.$extracss.' class="button-text '.$classcss_button.'" href="'.$button_link.'">'.$icon_html.'<span>'.$button_text.'</span></a>';
                    $output .= '</div>';
                    $output .=  '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
               case 'button3':
                    $output .=  '<div class="iw-button '.$class.'">';
                    $output .=  '<div class="iw-button-text' .$class_hover. ' bg-bevelled">';
                    $output .= '<a '.$extracss.' class="button-text '.$classcss_button.'" href="'.$button_link.'"><span class="border-inline">'.$icon_html.''.$button_text.'</span><span ' .$bg_button3. ' class="' .$background_color. ' iw-av-overlay"></span></a>';
                    $output .= '</div>';
                    $output .=  '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Button;
