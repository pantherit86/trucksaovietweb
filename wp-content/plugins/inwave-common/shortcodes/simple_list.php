<?php

/*
 * Inwave_Simple_List for Visual Composer
 */
if (!class_exists('Inwave_Simple_List')) {

    class Inwave_Simple_List extends Inwave_Shortcode{

        protected $name = 'inwave_simple_list';

        function init_params() {
            return array(
                'name' => __("Simple List", 'inwavethemes'),
                'description' => __('Add a items list with some simple style', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal" => "style1",
                            "Style 2 - List Style None " => "style2",
                        )
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Content", "inwavethemes"),
                        "value" => '
                            <ul>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>Lorem ipsum dolor sit amet</li>
                            </ul>',
                        "description" => "Format: <br>Inactive Item: ".htmlspecialchars('<li>Lorem ipsum dolor sit amet</li>')."<br>Active Item: ".htmlspecialchars('<li class="active">Lorem ipsum dolor sit amet</li>')."",
                        "param_name" => "content"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "List Style",
                        "param_name" => "list_style",
                        "value" => array(
                            "None" => "none",
                            "Check Mark" => "check-mark",
                            "Angle Right" => "angle-right",
                            "Chevron Circle Right" => "chevron-circle-right",
                            "Stars" => "stars",
                            "circle" => "circle",
							"Check Circle" => "check-circle",
                            "Numbers" => "numbers"
                        ),
                        "dependency" => array('element' => 'style', 'value' => 'style1')
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

            $output = $class = $style = $list_style = $align = $css = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'style' => 'style1',
                'list_style' => 'none',
                'class' => '',
                'align' => '',
                'css' => ''
                            ), $atts));
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($list_style){
                $class.= ' '.$list_style;
            }
            if($align){
                $class.= ' '.$align.'-text';
            }

            $output .= '<div class="simple-list ' . $class . '">';


                $i = 0;
                do {
                    $i++;
                    if($list_style == 'none') {
                        $replacer = '<#$1><span class="list-content">';
                    }
                    else if($list_style == 'numbers') {
                        $replacer = '<#$1><span class="number"> '. ($i<10?'0':'') . $i . '</span><span class="list-content">';
                    }
                    else if($list_style == 'stars') {
                        $replacer = '<#$1><span class="icon"><i class="fa fa-star"></i></span><span class="list-content">';
                    }
					else if($list_style == 'check-circle') {
                        $replacer = '<#$1><span class="icon"><i class="fa fa-check-circle"></i></span><span class="list-content">';
                    }
					else if($list_style == 'circle') {
                        $replacer = '<#$1><span class="icon"><i class="fa fa-circle"></i></span><span class="list-content">';
                    }
                    else if($list_style == 'angle-right') {
                        $replacer = '<#$1><span class="icon"><i class="fa fa-chevron-right"></i></span><span class="list-content">';
                    }
                    else if($list_style == 'chevron-circle-right') {
                        $replacer = '<#$1><span class="icon"><i class="fa fa-chevron-circle-right"></i></span><span class="list-content">';
                    }
                    else{
                        $replacer = '<#$1><span class="icon"><i class="fa fa-check"></i></span><span class="list-content">';
                    }
                    $content = preg_replace('/\<li(.*)\>/Uis',$replacer, $content, 1, $count);
            } while ($count);
            $content = str_replace('<#','<li',$content);
            $content = str_replace('</li>','</span></li>',$content);
            $output .= $content;
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Simple_List;
