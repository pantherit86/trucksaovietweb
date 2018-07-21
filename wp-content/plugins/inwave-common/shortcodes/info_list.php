<?php

/*
 * Inwave_Info_List for Visual Composer
 */
if (!class_exists('Inwave_Info_List')) {

    class Inwave_Info_List extends Inwave_Shortcode2
    {

        protected $name = 'inwave_info_list';
        protected $name2 = 'inwave_info_item';
        protected $style;

        function init_params()
        {
            return array(
                "name" => __("Info List", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of list info and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_info_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Circle (You need to add 6 info items)" => "style1",
                        )
                    )
                )
            );
        }

        function init_params2()
        {
            return array(
                "name" => __("Info Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_info_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Read More" => "style1",
                            "Style 2 - Icon Rounded " => "style2",
                            "Style 3 - Border Left " => "style3",
                            "Style 4 - Image icons " => "style4",
                            "Style 5 - Pricing" => "style5",
                            "Style 6 - Centered" => "style6"
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "This is sub title",
                        "param_name" => "sub_title",
                        "dependency" => array('element' => 'style', 'value' => array('style5','style6'))
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Pricing", "inwavethemes"),
                        "param_name" => "pricing",
                        "value" => "",
                        "dependency" => array('element' => 'style', 'value' => 'style5')
                    ),
                    array(
                        "type" => "iw_icon",
                        "heading" => __("Select Icon", "inwavethemes"),
                        "param_name" => "icon",
                        "value" => "",
                        "description" => __("Click and select icon of your choice. You can get complete list of available icons here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/icons/'>Font-Awesome</a>", "inwavethemes"),
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Icon Image", "inwavethemes"),
                        "param_name" => "icon_img",
                        "description" => __("Select icon image instead of font icon above", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Icon Size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "description" => __("Example: 40", "inwavethemes"),
                        "value" => "40"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Read More Text", "inwavethemes"),
                        "value" => "",
                        "param_name" => "read_more_text",
                        "dependency" => array('element' => 'style', 'value' => array('style1','style6'))
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Link Read More", "inwavethemes"),
                        "param_name" => "link",
                        "value" => "#",
                        "dependency" => array('element' => 'style', 'value' => array('style1','style6'))
                    ),

                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "extra_class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
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
                        'heading' => __('CSS box', 'js_composer'),
                        'param_name' => 'css',
                        'group' => __('Design Options', 'js_composer')
                    )
                )
            );
        }


        // Shortcode handler function for list
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes($this->name, $atts) : $atts;

            $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"
            ), $atts));
            $this->style = $style;

            $class .= ' ' . $style;

            $output = '<div class="info-list ' . $class . '">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes($this->name2, $atts) : $atts;

            $output = $style = $icon = $icon_size = $title = $sub_title = $pricing = $read_more_text = $link = $align = $css = $extra_class = '';
            $description = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);
            extract(shortcode_atts(array(
                'icon' => '',
                'icon_img' => '',
                'icon_size' => '40',
                'title' => '',
                'sub_title' => '',
                'pricing' => '',
                'style' => '',
                'read_more_text' => '',
                'link' => '#',
                'align' => '',
                'css' => '',
                'extra_class' => ''
            ), $atts));
            $class = '';
            $class .= ' ' . $style . ' ' . vc_shortcode_custom_css_class($css);

            if ($align) {
                $class .= ' ' . $align . '-text';
            }
            if ($icon_img) {
                $icon_img = wp_get_attachment_image_src($icon_img, 'large');
                $icon_img = $icon_img[0];
                $icon_img = '<img src="' . $icon_img . '" alt="' . $title . '">';
            }

            if ($extra_class) {
                $class .= ' ' . $extra_class;
            }
            switch ($style) {
                case 'style1':
                case 'style4':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon_img) {
                        $output .= '<div class="icon" style="width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . $icon_size . 'px;">' . $icon_img . '</div>';
                    } else if ($icon) {
                        $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></div>';
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                    }
                    if ($description) {
                        $output .= '<div class="info-item-desc">' . $description . '</div>';
                    }
                    if ($read_more_text) {
                        $output .= '<div class="info-read-more"><a href="' . $link . '" class="theme-color">' . $read_more_text . '</a></div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style2':
                    $output .= '<div class="info-item style1 ' . $class . '">';
                    if ($icon_img) {
                        $output .= '<div class="icon" style="width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . $icon_size . 'px;">' . $icon_img . '</div>';
                    } else if ($icon) {
                        $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></div>';
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                    }
                    if ($description) {
                        $output .= '<div class="info-item-desc">' . $description . '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style3':
                    $output .= '<div class="info-item ' . $class . '">';
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-title-icon">';
                    if ($icon_img) {
                        $output .= '<div class="icon" style="width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . $icon_size . 'px;">' . $icon_img . '</div>';
                    } else if ($icon) {
                        $output .= '<div class="icon theme-bg"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></div>';
                    }
                    if ($title) {
                        $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                    }
                    $output .= '</div>';
                    if ($description) {
                        $output .= '<div class="info-item-desc">' . $description . '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style5':
                    $output .= '<div class="info-item ' . $class . ' style1 theme-bg">';
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-title-icon">';
                    if ($icon_img) {
                        $output .= '<div class="icon" style="width:' . $icon_size . 'px;height:' . $icon_size . 'px;line-height:' . $icon_size . 'px;">' . $icon_img . '</div>';
                    } else if ($icon) {
                        $output .= '<div class="icon theme-bg"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></div>';
                    }
                    if ($sub_title) {
                        $output .= '<div class="info-item-sub-title">' . $sub_title . '</div>';
                    }
                    if ($title) {
                        $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                    }
                    $output .= '</div>';
                    if ($description) {
                        $output .= '<div class="info-item-desc">' . $description . '</div>';
                    }
                    if ($pricing) {
                        $output .= '<div class="info-item-pricing">' . $pricing . '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                case 'style6':
                    $output .= '<div class="info-item ' . $class . '">';
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-title-icon">';
                    if ($icon_img) {
                        $output .= '<div class="icon">' . $icon_img . '</div>';
                    } else if ($icon) {
                        $output .= '<div class="icon theme-bg"><i style="font-size:' . $icon_size . 'px" class="' . $icon . '"></i></div>';
                    }
                    if ($title) {
                        $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                    }
                    if ($sub_title) {
                        $output .= '<div class="info-item-sub-title">' . $sub_title . '</div>';
                    }

                    $output .= '</div>';
                    if ($description) {
                        $output .= '<div class="info-item-desc">' . $description . '</div>';
                    }
                    if ($read_more_text) {
                        $output .= '<div class="info-read-more"><a href="' . $link . '">' . $read_more_text . '</a></div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}


new Inwave_Info_List;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Info_List extends WPBakeryShortCodesContainer
    {
    }
}
