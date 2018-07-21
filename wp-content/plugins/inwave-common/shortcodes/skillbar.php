<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Skillbar')) {

    class Inwave_Skillbar extends Inwave_Shortcode
    {
        protected $name = 'inwave_skillbar';

        function init_params()
        {
            return array(
                "name" => __("Skillbar", 'inwavethemes'),
                "base" => $this->name,
                'category' => 'Custom',
                "description" => __("Display your skills with style.", "inwavethemes"),
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "exploded_textarea",
                        "admin_label" => true,
                        "heading" => __("Graphic values", 'inwavethemes'),
                        "param_name" => "values",
                        "value" => "90|Development",
                        "description" => __("Input graph values here. Divide values with linebreaks (Enter). Example: 90|Development.", 'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Units", 'inwavethemes'),
                        "param_name" => "units",
                        "value" => "%",
                        "description" => __("Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.", 'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Speed",'inwavethemes'),
                        "param_name" => "speed",
                        "value" => '1000',
                        "description" => __("Set speed funfact for element",'inwavethemes')
                    ),
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $el_class = '';

            extract( shortcode_atts( array(
                'el_class' => '',
                'values' => '',
                'units' => '%',
                'speed' => '1000'
            ), $atts ) );

            $array_values = explode(",", $values);

            $output .= '<div class="skillbar-wrap">';
            foreach($array_values as $skill_value) {
                $data = explode("|", $skill_value);
                $output .= '<div class="skillbar " data-percent="'.$data['0'] . $units.'" data-speed="'.$speed.'">
                                <div class="skillbar-title"><span>'.$data['1'].'</span></div>
                                <div class="skill-bar-bg">
                                    <div class="skillbar_level"></div>
                                    <span class="skillbar_callout">'.$data['0'].$units .'</span>
                                </div>
                            </div>';
            }
            $output .='</div>';
            return $output;
        }
    }
}

new Inwave_Skillbar();