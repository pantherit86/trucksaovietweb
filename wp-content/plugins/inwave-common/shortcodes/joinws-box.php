<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_JWU_Box')) {

    class Inwave_JWU_Box extends Inwave_Shortcode{

        protected $name = 'inwave_jwu_box';

        function init_params() {
            return array(
                'name' => __('Join With Us Box', 'inwavethemes'),
                'description' => __('Join With Us Box', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "attach_image",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "image",
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => __("Content", "inwavethemes"),
                        "param_name" => "content",
                        "holder" => "div",
                        "value"=> ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value"=> "Join with us"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "holder" => "div",
                        "value"=> "#"
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

        function init_shortcode($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            $output = '';
            extract(shortcode_atts(array(
                'image' => '',
                'button_text' => '',
                'button_link' => '',
                'class' => '',
            ), $atts));

            $output .= '<div class="iw-jwu-box">';
                if($image){
                    $img = wp_get_attachment_image_src($image, 'large');
                    $image_url = count($img) ? $img[0] : '';
                    $output .= '<img src="'.esc_url($image_url).'" alt="">';
                }
                $output .= apply_filters('the_content',$content);
            $output .=  '<div class="join-button"><a class="theme-bg" href="'.$button_link.'"><span>'.$button_text.'</span><i class="fa fa-arrow-right"></i></a></div>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_JWU_Box;
