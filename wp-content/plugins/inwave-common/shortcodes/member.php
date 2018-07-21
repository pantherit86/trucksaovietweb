<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Member')) {

    class Inwave_Member extends Inwave_Shortcode
    {
        protected $name = 'inwave_member';

        function init_params()
        {
            return array(
                'name' => 'Member Item',
                'description' => __('Show a personal member', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "show_settings_on_create" => true,
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
                        "holder" => "div",
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
                        "type" => "exploded_textarea",
                        "heading" => __("Social links", "inwavethemes"),
                        "description" => __("Separated by newline", "inwavethemes"),
                        "param_name" => "social_links",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Member Image", "inwavethemes"),
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
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
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
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

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
            $description = do_shortcode($content);
            switch ($style) {
                case 'style1':
                    $output .= '<div class="member-box ' . $class . '">';
                        $output .= '<div class="member-image">';
                        $output .= '' . $img_tag . '';
                        $output.= '</div>';
                        $output .= '<div class="member-info">';
                            $output .= '<div class="social-links">';
                            if($social_links){
                                $social_links = explode(",", $social_links);
                                $output .= '<div class="member-socials">';
                                foreach($social_links as $social_link) {
                                    $data = explode("|", $social_link);
                                    $output .= '<a class="theme-bg" href="'.esc_url($social_link[1]).'"><i class="fa '.esc_attr($data[0]).'"></i></a>';
                                }
                                $output .= '</div>';
                            }
                            $output.= '</div>';
                            $output.= '<div class="name-position">';
                                $output .= '<h3 class="name"><span>' . $name . '</span></h3><div class="position">' . $position . '</div><div style="clear: both"></div>';
                            $output .= '</div>';
                            $output .= '<div class="description">' . $description . '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    break;
            }

            return $output;
        }
    }
}

new Inwave_Member();