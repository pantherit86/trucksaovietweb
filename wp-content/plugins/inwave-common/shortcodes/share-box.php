<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Share_Box')) {

    class Inwave_Share_Box extends Inwave_Shortcode{

        protected $name = 'inwave_share_box';

        function init_params() {
            return array(
                'name' => __("Share Box", 'inwavethemes'),
                'description' => __('Share Box', 'inwavethemes'),
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
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, <br />{TEXT_EXAMPLE} to specify colorful words, <br />'///' to insert line break tag (br)", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => __("Content", "inwavethemes"),
                        "param_name" => "content",
                        "holder" => "div",
                        "value"=> ""
                    ),
                    array(
                        "type" => "exploded_textarea",
                        "admin_label" => true,
                        "heading" => __("Social icons", 'inwavethemes'),
                        "param_name" => "socials",
                        "value" => "",
                        "description" => __("Enter socials here. Divide values with linebreaks (Enter). Example: fa-facebook|http://facebook.com.", 'inwavethemes')
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
                'title' => '',
                'socials' => '',
                'class' => '',
            ), $atts));

            $output .= '<div class="iw-share-box '.esc_attr($class).'">';
                if($image){
                    $img = wp_get_attachment_image_src($image, 'large');
                    $image_url = count($img) ? $img[0] : '';
                    $output .= '<img src="'.esc_url($image_url).'" alt="">';
                }
                if($title){
                    $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
                    $title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$title);
                    $title= preg_replace('/\/\/\//i', '<br />', $title);
                    $output .= '<div class="share-title">'.$title.'</div>';
                }
                $output .= '<div class="share-desc">'.apply_filters('the_content',$content).'</div>';
                if($socials){
                    $socials = explode(",", $socials);
                    $output .= '<div class="share-icons">';
                    foreach($socials as $social) {
                        $data = explode("|", $social);
                        $output .= '<a href="'.esc_url($data[1]).'"><i class="fa '.esc_attr($data[0]).'"></i></a>';
                    }
                    $output .= '</div>';
                }
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Share_Box;
