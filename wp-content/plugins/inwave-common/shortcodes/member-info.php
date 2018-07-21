<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Skillbar')) {

    class Inwave_Member_Info extends Inwave_Shortcode
    {
        protected $name = 'inwave_member_info';

        function init_params()
        {
            return array(
                "name" => __("Member Info", 'inwavethemes'),
                "base" => $this->name,
                'category' => 'Custom',
                "description" => __("Display member info.", "inwavethemes"),
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Name", 'inwavethemes'),
                        "param_name" => "name",
                        "value" => __("Daniel Trinh", 'inwavethemes'),
                        "description" => __("Enter member name.", 'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Position", 'inwavethemes'),
                        "param_name" => "position",
                        "value" => __("CO-Founder of Inwavethemes", 'inwavethemes'),
                        "description" => __("Enter member position.", 'inwavethemes')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => __("Introduction",'inwavethemes'),
                        "param_name" => "content",
                        "value" => 'Vestibulum varius fermentum risus vitae lacinia neque auctor nec. Nunc ac rutrum nulla. Nulla maximus dolor in quam euismod ac viverra libero aliquet',
                        "description" => __("Enter member introduction",'inwavethemes')
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
                        "type" => "iwevent_schedule",
                        "admin_label" => true,
                        "heading" => __("custom", 'inwavethemes'),
                        "param_name" => "custom_name",
                        "value" => "",
                        "description" => __("A custom name field.", 'inwavethemes')
                    )
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $el_class = '';
            extract( shortcode_atts( array(
                'name' => '',
                'position' => '',
                'socials' => ''
            ), $atts ) );

            $output .= '<div class="member-info">';
            $output .= '<div class="member-name">'.esc_attr($name).'</div>';
            $output .= '<div class="member-position">'.esc_attr($position).'</div>';
            $output .= '<div class="member-desription">'.apply_filters('the_content', $content).'</div>';
            if($socials){
                $socials = explode(",", $socials);
                $output .= '<div class="member-socials">';
                foreach($socials as $social) {
                    $data = explode("|", $social);
                    $output .= '<a href="'.esc_url($social[1]).'"><i class="fa '.esc_attr($data[0]).'"></i></a>';
                }
                $output .= '</div>';
            }
            $output .='</div>';
            return $output;
        }
    }
}

new Inwave_Member_Info();