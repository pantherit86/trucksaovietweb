<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Heading')) {

    class Inwave_Heading extends Inwave_Shortcode{

        protected $name = 'inwave_heading';

        function init_params() {
            return array(
                'name' => __("Heading", 'inwavethemes'),
                'description' => __('Add a heading & some information', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, <br />{TEXT_EXAMPLE} to specify colorful words, <br />'///' to insert line break tag (br)", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title",
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title",
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Content Below", "inwavethemes"),
                        "value" => "",
                        "param_name" => "content",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Heading type", "inwavethemes"),
                        "param_name" => "heading_type",
                        "value" => array(
                            "default" => "",
                            "h1" => "h1",
                            "h2" => "h2",
                            "h3" => "h3",
                            "h4" => "h4",
                            "h5" => "h5",
                            "h6" => "h6",
                        ),
                        "description" => __("Select heading type.", "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "General Style",
                        "admin_label" => true,
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal" => "style1",
                            "Style 2 - Curve" => "style2",
                            "Style 3 - Title Background Color Theme" => "style3",
                            "Style 4 - Border Before" => "style4",
                            "Style 5 - Lines in Sub Title" => "style5",
                            "Style 6 - Mixed" => "style6"
                        )
                    ),

					array(
                        'type' => 'textfield',
                        "group" => "Title Style",
                        "heading" => __("Margin Top", "inwavethemes"),
                        "description" => __('Margin Top', "inwavethemes"),
                        "param_name" => "margin_top",
						"value" => "",
                    ),
					array(
                        'type' => 'textfield',
                        "group" => "Title Style",
                        "heading" => __("Margin Bottom", "inwavethemes"),
                        "description" => __('Margin Bottom', "inwavethemes"),
                        "param_name" => "iw_margin_bottom",
                        "value" => "",
                    ),

                    array(
                        "type" => "dropdown",
                        "group" => "General Style",
                        "heading" => "Text align",
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
                        'group' => __( 'Design Options', 'js_composer' )
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $title = $sub_title = $heading_type = $align = $css = $class = $style = $margin_top = $iw_margin_bottom = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'heading_type' => 'h3',
                'style' => 'style1',
                'align' => '',
                'css' => '',
				'margin_top' => '',
				'iw_margin_bottom' => '',
                'class' => ''
            ), $atts));

            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);
			
            if($align){
                $class.= ' '.$align.'-text';
            }

            $extracss = '';
			$extracss .= 'style="';
            if($margin_top){
                $extracss .= 'margin-top:'.$margin_top.'px;';
            }
            if($iw_margin_bottom){
                $extracss .= 'margin-bottom:'.$iw_margin_bottom.'px;';
            }
			$extracss .= '"';

            			
            $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
            $title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$title);
            $title= preg_replace('/\/\/\//i', '<br />', $title);

            $sub_title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$sub_title);
            $sub_title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$sub_title);
			
			$content= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$content);
            $content= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$content);
            $content= preg_replace('/\/\/\//i', '<br />', $content);
			
            if(!$heading_type){
                $heading_type = 'h3';
            }
            switch ($style) {
                // Normal style
                case 'style1':
                    $output .= '<div class="iw-heading ' .$class. '">';
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title">' .$sub_title. '</div>';
                    }
                    if ($title) {
                        $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'>' .$title. '</' . $heading_type . '>';
                    }
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                    break;

                case 'style2':
                    wp_enqueue_script('arctext');
                    $output .= '<div class="iw-heading ' .$class. '">';
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title">' .$sub_title. '</div>';
                    }
                    if ($title) {
                        $output .= '<' . $heading_type . ' class="iwh-title theme-color" '.$extracss.'>' .$title. '</' . $heading_type . '>';
                    }
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                    break;

                case 'style3':
                    $output .= '<div class="iw-heading ' .$class. '">';
                    if ($title) {
                        $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'><span class="bg-before-theme">' .$title. '</span></' . $heading_type . '>';
                    }
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title" '.$sub_title_css. '>' .$sub_title. '</div>';
                    }
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                    break;

                case 'style4':
                    $output .= '<div class="iw-heading ' .$class. '">';
                        $output .= '<div class="iw-heading-info">';
                            if ($sub_title) {
                                $output .= '<div class="iwh-sub-title">' .$sub_title. '</div>';
                            }
                            if ($title) {
                                $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'><span class="title-text">' .$title. '</span></' . $heading_type . '>';
                            }
                            if ($content) {
                                $output .= '<p class="iwh-content">' . $content . '</p>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style5':
                    $output .= '<div class="iw-heading ' .$class. '">';
                    $output .= '<div class="iw-heading-info">';
                    if ($title) {
                        $output .= '<' . $heading_type . ' class="iwh-title" '.$extracss.'><span class="title-text">' .$title. '</span></' . $heading_type . '>';
                    }
                    if ($sub_title) {
                        $output .= '<div class="iwh-sub-title">' .$sub_title. '</div>';
                    }
                    if ($content) {
                        $output .= '<p class="iwh-content">' . $content . '</p>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Heading;
