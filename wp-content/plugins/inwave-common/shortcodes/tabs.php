<?php

/*
 * Inwave_Tabs for Visual Composer
 */
if (!class_exists('Inwave_Tabs')) {

    class Inwave_Tabs extends Inwave_Shortcode2
    {

        protected $name = 'inwave_tabs';
        protected $name2 = 'inwave_tab_item';
        protected $layout;
        protected $item_count = 0;
        protected $first_item = 0;
        protected $item_row = 0;

        function init_params()
        {
            return array(
                "name" => __("Tabs", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_tab_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "iw-tabs-style",
                        "heading" => "Style",
                        "param_name" => "layout",
                        "value" => array(
                            __("Slider 1", "inwavethemes") => "layout1",
                            __("Slider 2", "inwavethemes") => "layout2",
                            __("Accordion 1", "inwavethemes") => "accordion",
                            __("Accordion 2", "inwavethemes") => "accordion accordion-style2",
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Items", "inwavethemes"),
                        "param_name" => "row",
                        "value" => "",
                        "description" => __('The number of items you want to see on the screen(Slider style only).', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Effect",
                        "param_name" => "effect",
                        "value" => array(
                            "Fade Slide" => "fade-slide",
                            "Horizontal Slide" => "horizontal-slide",
                            "Vertical Slide" => "vertical-slide"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }

        function init_params2()
        {
            return array(
                "name" => __("Tab Item", 'inwavethemes'),
                "base" => $this->name2,
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "as_child" => array('only' => 'inwave_tabs'),
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Style",
                        "heading" => __("Font Size Title", "inwavethemes"),
                        "value" => "",
                        "description" => __('Custom font-size for heading title. Example 14', "inwavethemes"),
                        "param_name" => "font_size_title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
                    array(
                        'type' => 'iw_icon',
                        "heading" => __("Tab Icon", "inwavethemes"),
                        "param_name" => "icon",
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Tab Image", "inwavethemes"),
                        "param_name" => "icon_img",
                        "description" => __("Select image instead of font icon above", "inwavethemes"),
                    ),
                    array(
                        'type' => 'textarea_html',
                        "holder" => "div",
                        "heading" => __("Content", "inwavethemes"),
                        "value" => '',
                        "param_name" => "content"
                    ),

                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }


        // Shortcode handler function for list
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes($this->name, $atts) : $atts;

            $output = $layout = $class = $effect = $row ='';
            $id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                "effect" => "fade-slide",
                "row" => '',
                'layout' => ''
            ), $atts));

            $this->first_item = true;
            $this->layout = $layout;
            $this->item_count = 0;
            $this->item_row = $row;
            $class .= ' ' . $effect;
            $output .= '<div class="iw-shortcode-tabs">';
            $output .= '<div id="' . $id . '" class="iw-tabs ' . $class . ' ' . $layout . '">';
            switch ($layout) {
                case 'layout1':
                    $output .= '<div class="iw-tab-items owl-carousel" data-plugin-options=\'{"autoHeight":false,"singleItem":true,"navigation":false,"pagination": true}\'>';
                    $output .= do_shortcode($content);

                    //fix closed slide div
                    if ($this->item_count > 0 && $this->item_count % $this->item_row != 0) {
                        $output .= '</div>';
                    }

                    $output .= '</div>';
                    break;
                case 'layout2':
                    $output .= '<div class="row">';
                    $output .= '<div class="iw-tab-items owl-carousel" data-plugin-options=\'{"autoHeight":false,"navigation":true,"pagination": false,"items":'.$row.',"itemsDesktop": [1199,' . ($row - 1) . '],"itemsDesktopSmall": [979,' . ($row - 1) . ']}\' >';
                    $output .= do_shortcode($content);
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                default:
                    $output .= do_shortcode($content);
                    $output .= '<script type="text/javascript">';
                    $output .= '(function($){';
                    $output .= '$(document).ready(function(){';
                    $output .= '$("#' . $id . '").iwTabs("accordion");';
                    $output .= '});';
                    $output .= '})(jQuery);';
                    $output .= '</script>';
                    break;
            }
            $output .= '<div style="clear:both;"></div>';
            $output .= '</div>';
            $output .= '</div>';


            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null)
        {
            $output = $title = $font_size_title = $sub_title = $icon = $icon_img = $description = $class = '';
            $content = do_shortcode($content);
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi', '$1', $content);
            $this->item_count++;

            extract(shortcode_atts(array(
                'title' => 'This is title',
                'font_size_title' => '14',
                'icon' => '',
                'icon_img' => '',
                'sub_title' => '',
                'class' => ''
            ), $atts));

            switch ($this->layout) {
                case 'layout1':
                    if ($this->item_count % $this->item_row == 1) {
                        $output .= '<div class="slide">';
                    }
                    $output .= '<div class="iw-tab-item">';
                    $output .= '<div class="iw-tab-item-inner">';

                    // get icon to show
                    if ($icon) {
                        $output .= '<span class="iw-tab-icon"><i class="' . $icon . '"></i></span>';
                    } else {
                        if ($icon_img) {
                            $icon_img = wp_get_attachment_image_src($icon_img,'full');
                            $icon_img = $icon_img[0];
                            $icon_img = '<img src="' . $icon_img . '" alt="">';
                            $output .= '<span class="iw-tab-icon">' . $icon_img . '</span>';
                        }
                    }

                    if ($title) {
                        $output .= '<div class="iw-tab-title"><span>' . $title . '</span></div>';
                    }

                    if ($sub_title) {
                        $output .= '<div class="iw-tab-subtitle">' . $sub_title . '</div>';
                    }
                    if ($content) {
                        $output .= '<div class="iw-tab-desc">' . $content . '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    if ($this->item_count % $this->item_row == 0) {
                        $output .= '</div>';
                    }
                    break;
                case 'layout2':
                    $output .= '<div class="iw-tab-item">';
                    $output .= '<div class="iw-tab-item-inner">';

                    // get icon to show
                    if ($icon) {
                        $output .= '<span class="iw-tab-icon"><i class="' . $icon . '"></i></span>';
                    } else {
                        if ($icon_img) {
                            $icon_img = wp_get_attachment_image_src($icon_img,'full');
                            $icon_img = $icon_img[0];
                            $icon_img = '<img src="' . $icon_img . '" alt="">';
                            $output .= '<span class="iw-tab-icon">' . $icon_img . '</span>';
                        }
                    }

                    if ($title) {
                        $output .= '<div class="iw-tab-title"><span>' . $title . '</span></div>';
                    }

                    if ($sub_title) {
                        $output .= '<div class="iw-tab-subtitle">' . $sub_title . '</div>';
                    }
                    if ($content) {
                        $output .= '<div class="iw-tab-desc">' . $content . '</div>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
                default:
                    $output .= '<div class="iw-accordion-item ' . $class . '">';
                    $output .= '<div class="iw-accordion-header ' . ($this->first_item ? 'active' : '') . '">';
                    $output .= '<div class="iw-accordion-title"><span style="font-size:' . $font_size_title . 'px;">' . $title . '<span class="theme-bg iw-av-overlay"></span></span></div>';
                    $output .= '</div>';
                    $output .= '<div class="iw-accordion-content" ' . ($this->first_item ? '' : 'style="display: none;"') . '>';
                    $output .= $content;
                    $output .= '</div>';
                    $output .= '</div>';
                    if ($this->first_item) {
                        $this->first_item = false;
                    }
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Tabs;

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Tabs extends WPBakeryShortCodesContainer
    {
    }
}
