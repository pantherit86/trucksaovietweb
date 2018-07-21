<?php

add_action('init', 'inwave_of_options');

if (!function_exists('inwave_of_options')) {
    function inwave_of_options()
    {
        global $wp_registered_sidebars;
        $sidebar_options[] = 'None';
        $sidebars = $wp_registered_sidebars;

        if (is_array($sidebars) && !empty($sidebars)) {
            foreach ($sidebars as $sidebar) {
                $sidebar_options[] = $sidebar['name'];
            }
        }

        //get slug menu in admin
        $menuArr = array();
        $menus = get_terms('nav_menu');
        foreach ( $menus as $menu ) {
            $menuArr[$menu->slug] = $menu->name;
        }




         //Background Images Reader
        $bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
        $bg_images = array();

        if (is_dir($bg_images_path)) {
            if ($bg_images_dir = opendir($bg_images_path)) {
                while (($bg_images_file = readdir($bg_images_dir)) !== false) {
                    if (stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        natsort($bg_images); //Sorts the array into a natural order
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }
            }
        }


        /*-----------------------------------------------------------------------------------*/
        /* TO DO: Add options/functions that use these */
        /*-----------------------------------------------------------------------------------*/


        $font_sizes = array(
            '' => 'Select size',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
            '31' => '31',
            '32' => '32',
            '33' => '33',
            '34' => '34',
            '35' => '35',
            '36' => '36',
            '37' => '37',
            '38' => '38',
            '39' => '39',
            '40' => '40',
            '41' => '41',
            '42' => '42',
            '43' => '43',
            '44' => '44',
            '45' => '45',
            '46' => '46',
            '47' => '47',
            '48' => '48',
            '49' => '49',
            '50' => '50',
        );

        $google_fonts = inwave_get_googlefonts(false);
        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

// Set the Options Array
        global $inwave_of_options;
        $inwave_of_options = array();

// GENERAL SETTING
        $inwave_of_options[] = array("name" => esc_html__("General setting",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Show demo setting panel",'motohero'),
            "desc" => esc_html__("Check this box to active the setting panel. This panel should be shown only in demo mode",'motohero'),
            "id" => "show_setting_panel",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show page heading",'motohero'),
            "desc" => esc_html__("Check this box to show or hide page heading",'motohero'),
            "id" => "show_page_heading",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show breadcrumbs",'motohero'),
            "desc" => esc_html__("Check to display the breadcrumbs in general. Uncheck to hide them.",'motohero'),
            "id" => "breadcrumbs",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Retina support:",'motohero'),
            "desc" => esc_html__("Each time an image is uploaded, a higher quality version is created and stored with @2x added to the filename in the media upload folder. These @2x images will be loaded with high-resolution screens.",'motohero'),
            "id" => "retina_support",
            "std" => 0,
            "type" => "checkbox");
			
		$inwave_of_options[] = array("name" => esc_html__("Google API",'motohero'),
            "desc" => esc_html__('Use for process data from google service. Eg: map, photo, video... To get Google api, you can access via <a href="https://console.developers.google.com/" target="_blank">here</a>.','motohero'),
            "id" => "google_api",
            "std" => '',
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Typography",'motohero'),
            "desc" => "",
            "id" => "typography",
            "std" => "<h3>Typography</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array( "name" => esc_html__("Select Body Font Family", 'motohero'),
            "desc" => esc_html__("Select a font family for body text", 'motohero'),
            "id" => "f_body",
            "std" => "Poppins",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Body Font Settings", 'motohero'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'motohero'),
            "id" => "f_body_settings",
            "std" => "100,300,400,700",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Select Menu Font", 'motohero'),
            "desc" => esc_html__("Select a font family for navigation", 'motohero'),
            "id" => "f_nav",
            "std" => "",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Menu Font Settings", 'motohero'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'motohero'),
            "id" => "f_nav_settings",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Select Headings Font", 'motohero'),
            "desc" => esc_html__("Select a font family for headings", 'motohero'),
            "id" => "f_headings",
            "std" => "",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Headings Font Settings", 'motohero'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'motohero'),
            "id" => "f_headings_settings",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Default Font Size", 'motohero'),
            "desc" => esc_html__("In pixels, default is 13", 'motohero'),
            "id" => "f_size",
            "std" => "13",
            "type" => "select",
            "options" => $font_sizes);
        $inwave_of_options[] = array( "name" => esc_html__("Default Font Line Height", 'motohero'),
            "desc" => esc_html__("In pixels, default is 28", 'motohero'),
            "id" => "f_lineheight",
            "std" => "28",
            "type" => "select",
            "options" => $font_sizes);
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Layout",'motohero'),
            "type" => "heading"
        );

        $inwave_of_options[] = array("name" => esc_html__("Sidebar Position",'motohero'),
            "desc" => esc_html__("Select slide bar position",'motohero'),
            "id" => "sidebar_position",
            "std" => "right",
            "type" => "select",
            "options" => array(
                'none' => 'Without Sidebar',
                'right' => 'Right',
                'left' => 'Left',
                'bottom' => 'Bottom'
            ));

        $inwave_of_options[] = array("name" => esc_html__("Layout",'motohero'),
            "desc" => esc_html__("Select boxed or wide layout.",'motohero'),
            "id" => "body_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                'boxed' => 'Boxed',
                'wide' => 'Wide',
            ));

        $inwave_of_options[] = array("name" => esc_html__("Boxed Mode Only",'motohero'),
            "desc" => "",
            "id" => "boxed_mode_only",
            "std" => "<h3>Page Background options (Only work in boxed mode)</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Background Image For Outer Areas In Boxed Mode",'motohero'),
            "desc" => esc_html__("Please choose an image or insert an image url to use for the background.",'motohero'),
            "id" => "bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array("name" => esc_html__("Full Background Image",'motohero'),
            "desc" => esc_html__("Check this box to have the background image display at 100% in width and height and scale according to the browser size.",'motohero'),
            "id" => "bg_full",
            "std" => 0,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Background Repeat",'motohero'),
            "desc" => esc_html__("Choose how the background image repeats.",'motohero'),
            "id" => "bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $inwave_of_options[] = array("name" => esc_html__("Background Color",'motohero'),
            "desc" => esc_html__("Select a background color.",'motohero'),
            "id" => "bg_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        // COLOR PRESETS
        $inwave_of_options[] = array("name" => esc_html__("Color presets",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Theme style",'motohero'),
            "id" => "theme_style",
            "std" => "dark",
            "type" => "select",
            "options" => array(
                'dark' => 'Dark',
                'light' => 'Light'
            ));
        $inwave_of_options[] = array("name" => esc_html__("Primary Color",'motohero'),
            "desc" => esc_html__("Controls several items, ex: link hovers, highlights, and more.",'motohero'),
            "id" => "primary_color",
            "std" => "#009fd7",
            "type" => "color");
        $inwave_of_options[] = array("name" => "Color Scheme",
            "desc" => "",
            "id" => "color_scheme_bg",
            "std" => "<h3>Background Colors</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Header Background Color",'motohero'),
            "desc" => esc_html__("Select a color for the header background.",'motohero'),
            "id" => "header_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Header Top Background Color",'motohero'),
            "desc" => esc_html__("Controls the background color of the top header section used in Header style 2.",'motohero'),
            "id" => "header_top_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Header Border Color",'motohero'),
            "desc" => esc_html__("Select a color for the header border.",'motohero'),
            "id" => "header_bd_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Content Background Color",'motohero'),
            "desc" => esc_html__("Controls the background color of the main content area.",'motohero'),
            "id" => "content_bg_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Background Color",'motohero'),
            "desc" => esc_html__("Select a color for the footer background.",'motohero'),
            "id" => "footer_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Footer Border Color",'motohero'),
            "desc" => esc_html__("Select a color for the footer border.",'motohero'),
            "id" => "footer_border_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Footer Back-to-top Background",'motohero'),
            "desc" => esc_html__("Select a color for the Back-to-top Background.",'motohero'),
            "id" => "footer_bg_btt",
            "std" => "",
            "type" => "color");


        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Color Scheme",'motohero'),
            "desc" => "",
            "id" => "color_scheme_font",
            "std" => "<h3>Font Colors</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Body Text Color",'motohero'),
            "desc" => esc_html__("Controls the text color of body font.",'motohero'),
            "id" => "body_text_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Link Color",'motohero'),
            "desc" => esc_html__("Controls the color of all text links as well as the '>' in certain areas.",'motohero'),
            "id" => "link_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Header Font Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the header font.",'motohero'),
            "id" => "header_text_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Header Link Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the header link font.",'motohero'),
            "id" => "header_link_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Page Title Font Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the page title font.",'motohero'),
            "id" => "page_title_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Blockquote Color",'motohero'),
            "desc" => esc_html__("Controls the color of blockquote.",'motohero'),
            "id" => "blockquote_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Headings Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the footer heading font.",'motohero'),
            "id" => "footer_headings_color",
            "std" => "#dcdcdc",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Font Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the footer font.",'motohero'),
            "id" => "footer_text_color",
            "std" => "#989898",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Link Color",'motohero'),
            "desc" => esc_html__("Controls the text color of the footer link font.",'motohero'),
            "id" => "footer_link_color",
            "std" => "#989898",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Button Text Color",'motohero'),
            "desc" => esc_html__("Controls the text color of buttons.",'motohero'),
            "id" => "button_text_color",
            "std" => "#ffffff",
            "type" => "color");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        //HEADER OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Header Options",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Header Info",'motohero'),
            "desc" => "",
            "id" => "header_info_content_options",
            "std" => "<h3>Header Content Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Select a Header Layout",'motohero'),
            "desc" => "",
            "id" => "header_layout",
            "std" => "",
            "type" => "images",
            "options" => array(
                "" => get_template_directory_uri() . "/assets/images/header/default.jpg",
                "v2" => get_template_directory_uri() . "/assets/images/header/v2.jpg",
                "v3" => get_template_directory_uri() . "/assets/images/header/v3.jpg",
                "v4" => get_template_directory_uri() . "/assets/images/header/v4.jpg",
                "v5" => get_template_directory_uri() . "/assets/images/header/v5.jpg"
            ));
        $inwave_of_options[] = array("name" => esc_html__("Sticky Header",'motohero'),
            "desc" => esc_html__("Check to enable a fixed header when scrolling, uncheck to disable.",'motohero'),
            "id" => "header_sticky",
            "std" => '0',
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Logo Sticky",'motohero'),
            "desc" => esc_html__("You can change logo header sticky when scroll mouse.",'motohero'),
            "id" => "logo_sticky",
            "std" => "",
            "type" => "upload");

        $inwave_of_options[] = array( "name" => esc_html__("Select Canvas Menu", 'motohero'),
            "desc" => esc_html__("Select a canvas menu", 'motohero'),
            "id" => "canvas_menu",
            "type" => "select",
            "options" => $menuArr);
        $inwave_of_options[] = array("name" => esc_html__("Show form search",'motohero'),
            "desc" => esc_html__("Check to show form search",'motohero'),
            "id" => "show_search_form",
            "std" => '1',
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Background Image For Header Area",'motohero'),
            "desc" => esc_html__("Please choose an image or insert an image url to use for the header background.",'motohero'),
            "id" => "header_bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array("name" => esc_html__("100% Background Image",'motohero'),
            "desc" => esc_html__("Check this box to have the header background image display at 100% in width and height and scale according to the browser size.",'motohero'),
            "id" => "header_bg_full",
            "std" => '',
            "type" => "checkbox");


        $inwave_of_options[] = array("name" => esc_html__("Background Repeat",'motohero'),
            "desc" => esc_html__("Choose how the background image repeats.",'motohero'),
            "id" => "header_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));
        $inwave_of_options[] = array("name" => esc_html__("Show social links",'motohero'),
            "desc" => esc_html__("Show social share links in header one-page version 3 (header v4 styles)",'motohero'),
            "id" => "header_social_links",
            "std" => '1',
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Top content",'motohero'),
            "id" => "header_top_content",
            "std" => "<i class=\"fa fa-map-marker\"></i> 302 Rainbow, Van Quan, Ha Dong, Ha Noi",
            "type" => "textarea");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Header Info",'motohero'),
            "desc" => "",
            "id" => "header_info_logo_options",
            "std" => "<h3>Logo Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Logo",'motohero'),
            "desc" => esc_html__("Please choose an image file for your logo.",'motohero'),
            "id" => "logo",
            "std" => get_template_directory_uri() . "/assets/images/logo.png",
            "mod" => "",
            "type" => "media");


        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Header Info",'motohero'),
            "desc" => "",
            "id" => "header_info_page_title_options",
            "std" => "<h3>Page Title Bar Options</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Page Title Bar Height",'motohero'),
            "desc" => esc_html__("In pixels, ex: 10px",'motohero'),
            "id" => "page_title_height",
            "std" => "280px",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Page Title Bar Background",'motohero'),
            "desc" => esc_html__("Please choose an image or insert an image url to use for the page title bar background.",'motohero'),
            "id" => "page_title_bg",
            "std" => '',
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array("name" => esc_html__("Full Background Image",'motohero'),
            "desc" => esc_html__("Check this box to have the page title bar background image display at 100% in width and height and scale according to the browser size.",'motohero'),
            "id" => "page_title_bg_full",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Background Repeat",'motohero'),
            "desc" => esc_html__("Choose how the background image repeats.",'motohero'),
            "id" => "page_title_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        // FOOTER OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Footer options",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Footer style",'motohero'),
            "desc" => "",
            "id" => "footer_option",
            "std" => "",
            "type" => "images",
            "options" => array(
            "" => get_template_directory_uri() . "/assets/images/footer/default.jpg"
            ));
        $inwave_of_options[] = array("name" => esc_html__("Footer columns",'motohero'),
            "id" => "footer_number_widget",
            "std" => "4",
            "type" => "select",
            "options" => array(
                '4' => '4',
                '3' => '3',
                '2' => '2',
                '1' => '1',
            ));
        $inwave_of_options[] = array("name" => esc_html__("Footer Logo",'motohero'),
            "desc" => esc_html__("Please choose an image file for your footer logo.",'motohero'),
            "id" => "footer-logo",
            "mod" => "",
            "type" => "media");
        $inwave_of_options[] = array("name" => esc_html__("Footer description",'motohero'),
            "desc" => esc_html__("Please enter text description for footer.",'motohero'),
            "id" => "footer-text",
            "std" => "<h3>About us</h3>
<div class=\"clear\"></div>
MotoHero a powerful corporate Wordpress theme provides you with immense application to any website you are going to create. The MotoHere is a theme build for Motorcycles, Car repair services, shop",
            "mod" => "",
            "type" => "textarea");
        $inwave_of_options[] = array("name" => esc_html__("Footer buttons",'motohero'),
            "desc" => "",
            "id" => "footer_extra_links",
            "std" => "",
            "mod" => "",
            "type" => "textarea");

        $inwave_of_options[] = array("name" => esc_html__("Footer copyright",'motohero'),
            "desc" => esc_html__("Please enter text copyright for footer.",'motohero'),
            "id" => "footer-copyright",
            "std" => "Copyright 2016 &copy; <a href='#' class='theme-color'>MotoHero</a>.  Theme with<i class='fa fa-heart'></i> by <a href='#' class='theme-color'>Inwavethemes</a>",
            "mod" => "",
            "type" => "textarea");
        $inwave_of_options[] = array("name" => esc_html__("Show social links",'motohero'),
            "desc" => esc_html__("Show social links in footer",'motohero'),
            "id" => "footer_social_links",
            "std" => '1',
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Footer Widgets",'motohero'),
            "desc" => esc_html__("Check the box to display footer widgets.",'motohero'),
            "id" => "footer_widgets",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Background Image For Footer Area",'motohero'),
            "desc" => esc_html__("Please choose an image or insert an image url to use for the footer widget area background.",'motohero'),
            "id" => "footer_bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array("name" => esc_html__("Full Background Image",'motohero'),
            "desc" => esc_html__("Check this box to have the footer background image display at 100% in width and height and scale according to the browser size.",'motohero'),
            "id" => "footer_bg_full",
            "std" => 0,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Background Repeat",'motohero'),
            "desc" => esc_html__("Choose how the background image repeats.",'motohero'),
            "id" => "footer_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

        $inwave_of_options[] = array("name" => esc_html__("Back to top button",'motohero'),
            "desc" => esc_html__("Select the checkbox to display Back to top button",'motohero'),
            "id" => "backtotop-button",
            "std" => 1,
            "type" => "checkbox");

// SHOP OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Shop options",'motohero'),
            "type" => "heading");

        $inwave_of_options[] = array("name" => esc_html__("Show Woocommerce Cart Icon in Top Navigation",'motohero'),
            "desc" => esc_html__("Check the box to show the Cart icon & Cart widget, uncheck to disable.",'motohero'),
            "id" => "woocommerce_cart_top_nav",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show Quick View Button",'motohero'),
            "desc" => esc_html__("Check the box to show the quick view button on product image.",'motohero'),
            "id" => "woocommerce_quickview",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Quick View Effect",'motohero'),
            "desc" => esc_html__("Select effect of the quick view box.",'motohero'),
            "id" => "woocommerce_quickview_effect",
            "std" => 'fadein',
            "type" => "select",
            "options" => array(
                'fadein' => 'Fadein',
                'slide' => 'Slide',
                'newspaper' => 'Newspaper',
                'fall' => 'Fall',
                'sidefall' => 'Side Fall',
                'blur' => 'Blur',
                'flip' => 'Flip',
                'sign' => 'Sign',
                'superscaled' => 'Super Scaled',
                'slit' => 'Slit',
                'rotate' => 'Rotate',
                'letmein' => 'Letmein',
                'makeway' => 'Makeway',
                'slip' => 'Slip'
            ));
        $inwave_of_options[] = array("name" => esc_html__("Product Listing Layout",'motohero'),
            "desc" => esc_html__("Select the layout for product listing page. Please logout to clean the old session",'motohero'),
            "id" => "product_listing_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                'grid' => 'Grid',
                'row' => 'Row'
            ));
        $inwave_of_options[] = array("name" => esc_html__("Troubleshooting",'motohero'),
            "desc" => esc_html__("Woocommerce jquery cookie fix<br> Read more: <a href='http://docs.woothemes.com/document/jquery-cookie-fails-to-load/'>jquery-cookie-fails-to-load</a>",'motohero'),
            "id" => "fix_woo_jquerycookie",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Blog",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Blog Listing",'motohero'),
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>Blog Listing</h3>",
            "icon" => true,
            "type" => "info");
        $inwave_of_options[] = array("name" => esc_html__("Post Category Title",'motohero'),
            "desc" => esc_html__("Check the box to display the post category title in each post.",'motohero'),
            "id" => "blog_category_title_listing",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Entry footer",'motohero'),
            "desc" => esc_html__("Check the box to display the tags and edit link (admin only).",'motohero'),
            "id" => "entry_footer_category",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Social Sharing Box",'motohero'),
            "desc" => esc_html__("Check the box to display the social sharing box in blog listing",'motohero'),
            "id" => "social_sharing_box_category",
            "std" => 0,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Blog Single Post",'motohero'),
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>Blog Single Post</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Featured Image on Single Post Page",'motohero'),
            "desc" => esc_html__("Check the box to display featured images on single post pages.",'motohero'),
            "id" => "featured_images_single",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Post Title",'motohero'),
            "desc" => esc_html__("Check the box to display the post title that goes below the featured images.",'motohero'),
            "id" => "blog_post_title",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Post Category Title",'motohero'),
            "desc" => esc_html__("Check the box to display the post category title that goes below the featured images.",'motohero'),
            "id" => "blog_category_title",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Show Author Info",'motohero'),
            "desc" => esc_html__("Check the box to display the author info in the post.",'motohero'),
            "id" => "author_info",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Related Posts",'motohero'),
            "desc" => esc_html__("Check the box to display related posts.",'motohero'),
            "id" => "related_posts",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Social Sharing Box",'motohero'),
            "desc" => esc_html__("Check the box to display the social sharing box.",'motohero'),
            "id" => "social_sharing_box",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Entry footer",'motohero'),
            "desc" => esc_html__("Check the box to display the tags and edit link (admin only).",'motohero'),
            "id" => "entry_footer",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Social Media",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Social Sharing",'motohero'),
            "desc" => "",
            "id" => "social_sharing",
            "std" => "<h3>Social Sharing</h3>",
            "icon" => false,
            "type" => "accordion",
            "position"=> 'start');
        $inwave_of_options[] = array("name" => esc_html__("Facebook",'motohero'),
            "desc" => esc_html__("Check the box to show the facebook sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_facebook",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Twitter",'motohero'),
            "desc" => esc_html__("Check the box to show the twitter sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_twitter",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("LinkedIn",'motohero'),
            "desc" => esc_html__("Check the box to show the linkedin sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_linkedin",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Google Plus",'motohero'),
            "desc" => esc_html__("Check the box to show the g+ sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_google",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Tumblr",'motohero'),
            "desc" => esc_html__("Check the box to show the tumblr sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_tumblr",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Pinterest",'motohero'),
            "desc" => esc_html__("Check the box to show the pinterest sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_pinterest",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Email",'motohero'),
            "desc" => esc_html__("Check the box to show the email sharing icon in blog, woocommerce and portfolio detail page.",'motohero'),
            "id" => "sharing_email",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Social Link",'motohero'),
            "desc" => "",
            "id" => "social_link",
            "std" => "<h3>Social Link</h3>",
            "icon" => false,
            "type" => "accordion",
            "position"=> 'start');

        $inwave_of_options[] = array("name" => esc_html__("Facebook",'motohero'),
            "desc" => esc_html__("Enter your Facebook link.",'motohero'),
            "id" => "facebook_link",
            "std" => "#",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Twitter",'motohero'),
            "desc" => esc_html__("Enter your Twitter link.",'motohero'),
            "id" => "twitter_link",
            "std" => "#",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Youtube",'motohero'),
            "desc" => esc_html__("Enter your Youtube channel link.",'motohero'),
            "id" => "youtube_link",
            "std" => "#",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Flickr",'motohero'),
            "desc" => esc_html__("Enter your Flickr link.",'motohero'),
            "id" => "flickr_link",
            "std" => "#",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Google+",'motohero'),
            "desc" => esc_html__("Enter your Google+ link.",'motohero'),
            "id" => "google_link",
            "std" => "#",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("LinkedIn",'motohero'),
            "desc" => esc_html__("Enter your LinkedIn link.",'motohero'),
            "id" => "linkedin_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("RSS",'motohero'),
            "desc" => esc_html__("Enter your RSS link.",'motohero'),
            "id" => "rss_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Instagram",'motohero'),
            "desc" => esc_html__("Enter your instagram link.",'motohero'),
            "id" => "instagram_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Vimeo",'motohero'),
            "desc" => esc_html__("Enter your Vimeo link.",'motohero'),
            "id" => "vimeo_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Pinterest",'motohero'),
            "desc" => esc_html__("Enter your Pinterest link.",'motohero'),
            "id" => "pinterest_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Tumblr",'motohero'),
            "desc" => esc_html__("Enter your Tumblr link.",'motohero'),
            "id" => "tumblr_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Dribbble",'motohero'),
            "desc" => esc_html__("Enter your Dribbble link.",'motohero'),
            "id" => "dribbble_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Weibo",'motohero'),
            "desc" => esc_html__("Enter your Weibo link.",'motohero'),
            "id" => "weibo_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Dropbox",'motohero'),
            "desc" => esc_html__("Enter your Dropbox link.",'motohero'),
            "id" => "dropbox_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Skype",'motohero'),
            "desc" => esc_html__("Enter your Skype account.",'motohero'),
            "id" => "skype_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Playstore",'motohero'),
            "desc" => esc_html__("Enter your Playstore link.",'motohero'),
            "id" => "android_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Appstore",'motohero'),
            "desc" => esc_html__("Enter your Appstore link.",'motohero'),
            "id" => "appstore_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Email",'motohero'),
            "desc" => esc_html__("Enter your Email address.",'motohero'),
            "id" => "email_link",
            "std" => "",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Github",'motohero'),
            "desc" => esc_html__("Enter your Github link.",'motohero'),
            "id" => "github_link",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");


// IMPORT EXPORT
        $inwave_of_options[] = array("name" => esc_html__("Import Demo",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Import Demo Content",'motohero'),
            "desc" => "We recommend you to <a href='https://wordpress.org/plugins/wordpress-reset/' target='_blank'>reset data</a>  & clean wp-content/uploads before import to prevent duplicate content!",
            "id" => "demo_data",
            "std" => admin_url('themes.php?page=optionsframework') . "&import_data_content=true",
            "btntext" => 'Import Demo Content',
            "type" => "import_button");
// BACKUP OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Backup Options",'motohero'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Backup and Restore Options",'motohero'),
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => esc_html__('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.','motohero'),
        );

        $inwave_of_options[] = array("name" => esc_html__("Transfer Theme Options Data",'motohero'),
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => esc_html__('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".','motohero'),
        );

    }//End function: inwave_of_options()
}//End chack if function exists: inwave_of_options()
?>
