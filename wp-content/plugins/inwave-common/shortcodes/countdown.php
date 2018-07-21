<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Countdown')) {

    class Inwave_Countdown extends Inwave_Shortcode{

        protected $name = 'inwave_countdown';

        function init_params() {
            return array(
                'name' => __("Countdown timer", 'inwavethemes'),
                'description' => __('Schedule a countdown until a time in the future', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Datetime",'inwave'),
                        "param_name" => "date_countdown",
                        "value" => "2016/01/01|00/00/00",
                        "description" => __("Add date for element.Eg:YYYY/MM/DD|h/i/s",'inwave')
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

            $output = $end_date = $class = '';
            extract(shortcode_atts(array(
                'date_countdown' => '',
                'class' => ''
                            ), $atts));

            wp_enqueue_script('jquery-countdown');

            $countdown_ts = stripcslashes( $date_countdown);
            $items   = preg_split( '/\t\r\n|\r|\n/', $countdown_ts );
            $extracts = explode("|", $items[0]);
            $extract_date = explode("/", $extracts[0]);
            $extract_time = explode("/", $extracts[1]);

            $output .= '<div class="inwave-countdown '.$class.'" data-countdown="'.esc_attr($extract_date[0].'/'.$extract_date[1].'/'.$extract_date[2].' '.$extract_time[0].':'.$extract_time[1].':'.$extract_time[2]).'">
                <div class="date-countdown day-count">
                    <span class="day date"></span>
                    <span class="day-label date-label">DAY</span>
                </div>
                <div class="date-countdown hour-count">
                    <span class="hour date"></span>
                    <span class="hour-label date-label">HOURS</span>
                </div>
                <div class="date-countdown minute-count">
                    <span class="minute date"></span>
                    <span class="minute-label date-label">MINUTE</span>
                </div>
                <div class="date-countdown second-count">
                    <span class="second date"></span>
                    <span class="second-label date-label">SECONDS</span>
                </div>
             </div>';

            return $output;
        }
    }
}

new Inwave_Countdown;
