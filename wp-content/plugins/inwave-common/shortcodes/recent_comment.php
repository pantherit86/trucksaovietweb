<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Comment_Recent')) {

    class Inwave_Comment_Recent extends Inwave_Shortcode{

        protected $name = 'inwave_recent_comment';

        function init_params() {
            return array(
                'name' => __("Recent Comment Post", 'inwavethemes'),
                'description' => __('Show Recent Comment Post', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Number comment", "inwavethemes"),
                        "value" => "3",
                        "param_name" => "number_comment",
                        'description' =>  __( 'Enter number comment to display', 'inwavethemes' )
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {

            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $number_comment = '';

            extract(shortcode_atts(array(
                'number_comment' => '3'
            ), $atts));

            $args = array(
                'number' => $number_comment,
                'orderby' => 'post_date',
                'order' => 'DESC'
            );
            $comments = get_comments($args);
            $output .= '<div class="iw_recent_comment">';
            $output .= '<ul>';
            foreach($comments as $comment) :
                $output .= '<li><span>' . $comment->comment_author . '</span>' . '<p>' .  wp_trim_words( $comment->comment_content, 40 ) . '</p></li>';
            endforeach;
            $output .= '</ul>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Comment_Recent;
