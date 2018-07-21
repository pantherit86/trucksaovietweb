<?php

/*
 * Inwave_Table for Visual Composer
 */
if (!class_exists('Inwave_Table')) {

    class Inwave_Table extends Inwave_Shortcode{

        protected $name = 'inwave_table';

        function init_params() {
            return array(
                'name' => __("Table", 'inwavethemes'),
                'description' => __('Add a items list with some table style', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textarea_html',
                        "holder" => "div",
                        "heading" => __("Content", "inwavethemes"),
                        "value" => '
                            <ul>
                                <li class="table-title"><div><span class="name">name of service</span><span class="delivery-time">Delivery time</span><span class="pricing">Pricing</span><span class="warranty-time">Warranty time</span></div></li>
                                <li class="table-info"><div><span class="name">Classic Motorcycle Tire Changing</span><span class="delivery-time">01 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">03 months</span></div></li>
                                <li class="table-info"><div><span class="name">Oil and filter changes</span><span class="delivery-time">02 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">01 months</span></div></li>
                                <li class="table-info"><div><span class="name">Spark plug replacement</span><span class="delivery-time">02 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">06 months</span></div></li>
                                <li class="table-info"><div><span class="name">Air filter cleaning or replacing</span><span class="delivery-time">05 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">12 months</span></div></li>
                                <li class="table-info"><div><span class="name">Drive chain tension setting</span><span class="delivery-time">06 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">03 months</span></div></li>
                                <li class="table-info"><div><span class="name">Valve clearance (as applicable)</span><span class="delivery-time">05 working day</span><span class="pricing">Starting in $60</span><span class="warranty-time">01 months</span></div></li>
                            </ul>',
                        "description" => "",
                        "param_name" => "content"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "extra_class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
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


        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $extra_class = $align = $css = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'extra_class' => '',
                'align' => '',
                'css' => ''
                            ), $atts));
            $class = '';
            if($align){
                $class.= ' '.$align.'-text';
            }
            if($extra_class){
                $class.= ' '.$extra_class;
            }

            $output .= '<div class="iw-table ' . $class . '">';
            $output .= $content;
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Table;
