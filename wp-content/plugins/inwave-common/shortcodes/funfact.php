<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Funfact')) {

    class Inwave_Funfact extends Inwave_Shortcode{

        protected $name = 'inwave_funfact';

        function init_params() {
            return array(
                'name' => __("Funfact", 'inwavethemes'),
                'description' => __('Insert a funfact style', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Number",'inwavethemes'),
                        "param_name" => "number",
                        "value" => __("7854",'inwavethemes'),
                        "description" => __("Add number funfact on for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("title",'inwavethemes'),
                        "param_name" => "title",
                        "value" => __("Data Transferred",'inwavethemes'),
                        "description" => __("Add title Funfacr for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Prefix",'inwavethemes'),
                        "param_name" => "prefix",
                        "value" => '',
                        "description" => __("Add prefix funfact for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Suffix",'inwavethemes'),
                        "param_name" => "suffix",
                        "value" => '',
                        "description" => __("Add suffix funfact for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Speed",'inwavethemes'),
                        "param_name" => "speed",
                        "value" => '1000',
                        "description" => __("Set speed funfact for element",'inwavethemes')
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __( 'Add comma?', 'js_composer' ),
                        'param_name' => 'add_comma',
                    ),
                )
            );
        }

        function register_scripts()
        {
            wp_enqueue_script('jquery-countTo');
        }

        function init_shortcode($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'inwave_funfact', $atts ) : $atts;
            $el_class = $html = '';
            extract( shortcode_atts(
                array(
                    // alway
                    'el_class' => '',

                    'number' => '',
                    'title' => '',
                    'prefix' => '',
                    'suffix' => '',
                    'speed' => '',
                    'add_comma' => '',
                ), $atts ));

            $funfact_settings = array();
            $funfact_settings['to'] = $number;
            $funfact_settings['speed'] = (int)$speed;
            $funfact_settings['add_comma'] = $add_comma ? true : false;
            $html .='<div class="inwave-funfact" data-settings="'.esc_attr(json_encode($funfact_settings)).'">
                        <div class="funfact-number-wrap">';
                    if($prefix != ''){
                        $html .='<span class="funfact-prefix">'.$prefix.'</span>';
                    }
                    $html .='<span data-number="'.esc_attr($number_funfact).'" class="funfact-number">'.$number_funfact.'</span>';
                    if($suffix !=''){
                        $html .='<span class="funfact-prefix">'.$suffix.'</span>';
                    }
                    $html .='</div>
						<p class="funfact-title">'.$title.'</p>
			</div>';

            return $html;
        }
    }
}

new Inwave_Funfact();
