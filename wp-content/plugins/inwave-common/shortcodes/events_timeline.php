<?php

/*
 * Inwave_Profile List for Visual Composer
 */
if (!class_exists('Inwave_Events_Timeline')) {

    class Inwave_Events_Timeline extends Inwave_Shortcode2{

        protected $name = 'inwave_events_timeline';
        protected $name2 = 'inwave_events';
        protected $count;

        function init_params() {
            return array(
                "name" => __("Inwave Events Timeline", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_events'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title Timeline", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title_timeline"
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
        }

        function init_params2(){
            return array(
                'name' => 'Event Item',
                'description' => __('Show a Event', 'inwavethemes'),
                'base' => $this->name2,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_events_timeline'),
                "as_parent" => array('except' => 'inwave_events_timeline_item,inwave_events'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Title Link", "inwavethemes"),
                        "param_name" => "title_link",
                        "value"=>"#"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Location", "inwavethemes"),
                        "value" => "",
                        "param_name" => "location"
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => __("Description", "inwavethemes"),
                        "param_name" => "description",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Date", "inwavethemes"),
                        "param_name" => "date",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Speakers", "inwavethemes"),
                        "param_name" => "speakers",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Tickets", "inwavethemes"),
                        "param_name" => "tickets",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Yeah", "inwavethemes"),
                        "param_name" => "yeah",
                        "value" => ""
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "img"
                    ),array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Video URL", "inwavethemes"),
                        "value" => "",
                        "param_name" => "url"
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
                            "Style 1" => "style1",
                            "Style 2" => "style2"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
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

        // Shortcode handler function for profile box slider
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $title_timeline = $class = '';
            extract(shortcode_atts(array(
                'title_timeline' => 'history',
                'class' => '',
            ), $atts));

            $output .= '<div class="iw-events-timeline ' . $class . '">';
            $output .= '<div class="title_timeline"><span class="theme-bg">' .$title_timeline. '</span></div>';
            $output .= do_shortcode($content);
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function for profile box
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $title = $title_link = $location = $description = $date = $description = $speakers = $tickets = $yeah = $img = $url = $class = $align = $css = $style = '';
            extract(shortcode_atts(array(
                'title' => '',
                'title_link' => '#',
                'location' => '',
                'description' => '',
                'date' => '',
                'speakers' => '',
                'tickets' => '',
                'yeah' => '2016',
                'img' => '',
                'url' => '',
                'class' => '',
                'align' => '',
                'css' => '',
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
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }
            switch ($style) {
                case 'style1':
                    $output .= '<div class="events-timeline ' .$class. '">';
                        $output .= '<div class="row">';
                            $output .= '<div class="bg-line col-md-6 col-sm-6 col-xs-12">';
                                $output .= '<div class="iw-event-info">';
                                    $output .= '<div class="yeah theme-bg">' . $yeah . '</div>';
                                    if ($location){
                                        $output .= '<div class="location">' . $location . '</div>';
                                    }
                                    if ($title){
                                        $output .= '<a class="title theme-color" href="' .$title_link. '">' . $title . '</a>';
                                    }
                                    if ($description){
                                        $output .= '<div class="description">' . $description . '</div>';
                                    }
                                    if ($date){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<div class="iwe-date theme-color">' . $date . '</div><span class="icon theme-bg"><i class="fa fa-calendar"></i></span>';
                                        $output .= '</div>';
                                    }
                                    if ($speakers){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<div class="iwe-speakers theme-color">' . $speakers . '</div><span class="icon theme-bg"><i class="fa fa-microphone"></i></span>';
                                        $output .= '</div>';
                                    }
                                    if ($tickets){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<div class="iwe-tickets theme-color">' . $tickets . '</div><span class="icon theme-bg"><i class="fa fa-ticket"></i></span>';
                                        $output .= '</div>';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';
                            $output .= '<div class="col-md-6 col-sm-6 col-xs-12">';
                                $output .= '<div class="video-image">';
                                    if ($location){
                                        $output .= '<div class="iw-shortcode-video iw-video">';
                                            $output .= '<div class="iw-video-player">';
                                                $output .= '<div class="play-button"><i class="fa fa-play"></i></div>';
                                                $output .= '<video src="'.$url.'"></video>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    }
                                    else{
                                        $output .= '' . $img_tag . '';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    break;

                case 'style2':
                    $output .= '<div class="events-timeline ' .$class. '">';
                        $output .= '<div class="row">';
                            $output .= '<div class="bg-line col-md-6 col-sm-6 col-xs-12">';
                                $output .= '<div class="iw-event-info">';
                                    $output .= '<div class="yeah theme-bg">' . $yeah . '</div>';
                                    if ($location){
                                        $output .= '<div class="location">' . $location . '</div>';
                                    }
                                    if ($title){
                                        $output .= '<a class="title theme-color" href="' .$title_link. '">' . $title . '</a>';
                                    }
                                    if ($description){
                                        $output .= '<div class="description">' . $description . '</div>';
                                    }
                                    if ($date){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<span class="icon theme-bg"><i class="fa fa-calendar"></i></span><div class="iwe-date theme-color">' . $date . '</div>';
                                        $output .= '</div>';
                                    }
                                    if ($speakers){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<span class="icon theme-bg"><i class="fa fa-microphone"></i></span><div class="iwe-speakers theme-color">' . $speakers . '</div>';
                                        $output .= '</div>';
                                    }
                                    if ($tickets){
                                        $output .= '<div class="info-detail">';
                                        $output .= '<span class="icon theme-bg"><i class="fa fa-ticket"></i></span><div class="iwe-tickets theme-color">' . $tickets . '</div>';
                                        $output .= '</div>';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';

                            $output .= '<div class="col-md-6 col-sm-6 col-xs-12">';
                                $output .= '<div class="video-image">';
                                    if ($location){
                                        $output .= '<div class="iw-shortcode-video iw-video">';
                                            $output .= '<div class="iw-video-player">';
                                                $output .= '<div class="play-button"><i class="fa fa-play"></i></div>';
                                                $output .= '<video src="'.$url.'"></video>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    }
                                    else{
                                        $output .= '' . $img_tag . '';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    break;
            }

            return $output;
        }
    }
}

new Inwave_Events_Timeline;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Events_Timeline extends WPBakeryShortCodesContainer {
    }
}