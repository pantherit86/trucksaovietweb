<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Faq')) {

    class Inwave_Faq extends Inwave_Shortcode{

        protected $name = 'inwave_faq';

        function init_params() {
            return array(
                'name' => __("FAQ", 'inwavethemes'),
                'description' => __('Frequently asked question', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Question", "inwavethemes"),
                        "value" => "This is question",
                        "param_name" => "question"
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Answer", "inwavethemes"),
                        "value" => "This is Answer",
                        "param_name" => "answer"
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
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal heading" => "style1",
                            "Style 2 - Our pricing" => "style2",
                            "Style 3 - Pricing plan" => "style3"
                        )
                    ),
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $answer = $question = $class = '';
            extract(shortcode_atts(array(
                'answer' => '',
                'question' => '',
                'class' => ''
                            ), $atts));

            $output .= '<div class="ask-question-content ' . $class . '">';
            $output .= '<div class="question"><div class="question-content">';
            $output .= '<p>' . $question . '</p>';
            $output .= '</div></div>';
            $output .= '<div class="answer"><div class="answer-content">';
            $output .= '<p>' . $answer . '</p>';
            $output .= '</div></div>';
            $output .= '</div>';
            return $output;
        }
    }
}

new Inwave_Faq;
