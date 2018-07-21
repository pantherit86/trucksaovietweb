<?php
/**
 * This file is used to load javascript and stylesheet function
 */

/**
 * Enqueue scripts and styles.
 */
if( !function_exists( 'inwave_load_js' ) ) {
    function inwave_load_js()
    {
        global $inwave_theme_option, $inwave_post_option;

        $theme_info = wp_get_theme();
        if ($inwave_theme_option['fix_woo_jquerycookie']) {
            wp_register_script('jquery-cookie', get_template_directory_uri() . '/assets/js/jquery-cookie-min.js', array('jquery'), $theme_info->get('Version'), true);
        }

        /* Load jquery lib*/
        wp_enqueue_script('jquery');
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('easing', get_template_directory_uri() . '/assets/js/jquery.easing.1.3.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('custombox', get_template_directory_uri() . '/assets/js/custombox.min.js', array(), $theme_info->get('Version'), true);
        wp_register_script('scroll-parallax', get_template_directory_uri() . '/assets/js/scroll.parallax.js', array(), $theme_info->get('Version'), true);
        wp_register_script('mailchimp', get_template_directory_uri() . '/assets/js/mailchimp.js', array('jquery'), $theme_info->get('Version'), true);
        wp_register_script('markerclusterer', get_template_directory_uri() . '/assets/js/markerclusterer.js', array('jquery'), $theme_info->get('Version'), true);
        wp_register_script('jquery-countTo', get_template_directory_uri() . '/assets/js/jquery.countTo.js', array('jquery'), $theme_info->get('Version'), true);
        wp_register_script('jquery-countdown', get_template_directory_uri() . '/assets/js/jquery.countdown.js', array('jquery'), $theme_info->get('Version'), true);
        wp_register_script('twentytwenty', get_template_directory_uri() . '/assets/js/jquery.twentytwenty.js', array(), $theme_info->get('Version'), true);
        wp_register_script('event-move', get_template_directory_uri() . '/assets/js/jquery.event.move.js', array(), $theme_info->get('Version'), true);
        wp_register_script('arctext', get_template_directory_uri() . '/assets/js/jquery.arctext.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('select2', get_template_directory_uri() . '/assets/js/select2.full.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('icheck', get_template_directory_uri() . '/assets/js/icheck.js', array(), $theme_info->get('Version'), true);


        /* Load only page request*/
        wp_enqueue_script('waypoints', get_template_directory_uri() . '/assets/js/waypoints.js', array(), $theme_info->get('Version'), true);

        if ($inwave_theme_option['retina_support']) {
            wp_enqueue_script('retina_js', get_template_directory_uri() . '/assets/js/retina.min.js', array(), $theme_info->get('Version'), true);
        }

        wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), $theme_info->get('Version'), true);

        wp_register_script('jquery-parallax', get_template_directory_uri() . '/assets/js/jquery.parallax-1.1.3.js', array(), $theme_info->get('Version'), true);

        wp_enqueue_script('jquery-gallery', get_template_directory_uri() . '/assets/js/jquery.gallery.js', array(), $theme_info->get('Version'), true);

        wp_enqueue_script('motohero-template', get_template_directory_uri() . '/assets/js/template.js', array(), $theme_info->get('Version'), true);
        wp_localize_script('motohero-template', 'inwaveCfg', array('siteUrl' => admin_url(), 'themeUrl' => get_template_directory_uri(), 'baseUrl' => site_url(), 'ajaxUrl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('motohero-template');

        wp_enqueue_script('navgoco', get_template_directory_uri() . '/assets/js/jquery.navgoco.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('off-canvas', get_template_directory_uri() . '/assets/js/off-canvas.js', array(), $theme_info->get('Version'), true);

        /** load panel */
        if ($inwave_theme_option['show_setting_panel']) {
            wp_enqueue_script('panel-settings', get_template_directory_uri() . '/assets/js/panel-settings.js', array(), $theme_info->get('Version'), true);
        }


        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

    }

    add_action('wp_enqueue_scripts', 'inwave_load_js', 9);
}

/**
 * Admin Enqueue scripts and styles.
 */
if( !function_exists( 'admin_inwave_load_js' ) ) {
    function admin_inwave_load_js()
    {
        global $inwave_theme_option, $inwave_post_option;

        $theme_info = wp_get_theme();
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js'.(isset($inwave_theme_option['google_api']) ? '?key=' . $inwave_theme_option['google_api'] : ''), array(), true);
        //wp_enqueue_script('select2', get_template_directory_uri() . '/assets/js/select2.full.js', array(), $theme_info->get('Version'), true);
        wp_enqueue_script('custombox', get_template_directory_uri() . '/assets/js/custombox.min.js', array(), $theme_info->get('Version'), true);
    }

    add_action('admin_enqueue_scripts', 'admin_inwave_load_js', 9);
}



/**
 * Load stylesheet
 */
if( !function_exists( 'inwave_load_css' ) ) {

    /*
     * Load css
    */
    function inwave_load_css()
    {
        global $inwave_theme_option, $inwave_post_option;

        $theme_info = wp_get_theme();
		$template = get_template();
		

		
		if ($inwave_theme_option['f_body']){
			$gfont[urlencode($inwave_theme_option['f_body'])] = urlencode($inwave_theme_option['f_body']).':'.$inwave_theme_option['f_body_settings'];
		}
		if ($inwave_theme_option['f_nav'] && $inwave_theme_option['f_nav'] != '' && $inwave_theme_option['f_nav'] != $inwave_theme_option['f_body']){
			if(!$inwave_theme_option['f_nav_settings']){
				$inwave_theme_option['f_nav_settings'] = $inwave_theme_option['f_body_settings'];
			}
			$gfont[urlencode($inwave_theme_option['f_nav'])] = urlencode($inwave_theme_option['f_nav']).':'.$inwave_theme_option['f_nav_settings'];
		}
		if ($inwave_theme_option['f_headings'] && $inwave_theme_option['f_headings'] != '' && $inwave_theme_option['f_headings'] != $inwave_theme_option['f_body'] && $inwave_theme_option['f_headings'] != $inwave_theme_option['f_nav']){
			if(!$inwave_theme_option['f_headings_settings']){
				$inwave_theme_option['f_headings_settings'] = $inwave_theme_option['f_body_settings'];
				
			}
			$gfont[urlencode($inwave_theme_option['f_headings'])] = urlencode($inwave_theme_option['f_headings']).':'.$inwave_theme_option['f_headings_settings'];
		}
		if (isset($gfont) && $gfont) {
			foreach ($gfont as $key => $g_font) {
				wp_enqueue_style('google-font-'.sanitize_title($key),"//fonts.googleapis.com/css?family={$g_font}", array(), $theme_info->get('Version'));
			}
		}

		
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), $theme_info->get('Version'));

        wp_enqueue_style('select2', get_template_directory_uri() . '/assets/css/select2.css', array(), $theme_info->get('Version'));

        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.css', array(), $theme_info->get('Version'));
        
        wp_register_style('custombox', get_template_directory_uri() . '/assets/css/custombox.min.css', array(), $theme_info->get('Version'));

        /** Theme style */
    if(is_child_theme()){
        wp_enqueue_style( $template.'-parent-style', get_template_directory_uri(). '/style.css' );
        if(is_rtl()){
            wp_enqueue_style( $template.'-parent-rtl-style', get_template_directory_uri(). '/rtl.css' );
        }
    }
    wp_enqueue_style($template.'-style', get_stylesheet_uri());
        wp_enqueue_style('motohero-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('owl-transitions', get_template_directory_uri() . '/assets/css/owl.transitions.css', array(), $theme_info->get('Version'));

        if ($inwave_post_option['theme_style'] == 'light') {
            wp_enqueue_style('motohero-light', get_template_directory_uri() . '/assets/css/light.css', array(), $theme_info->get('Version'));
        }
        /** Dynamic css color */
        if (!$inwave_theme_option['show_setting_panel']) {
            wp_enqueue_style('inwave-color', Inwave_Customizer::getCustomCssUrl() . 'custom.css', array(), $theme_info->get('Version'));
        }else{
            wp_add_inline_style('motohero-style',Inwave_Customizer::color(true));
        }


    }

    add_action("wp_enqueue_scripts",'inwave_load_css', 9);
}

/**
 * Admin Load stylesheet
 */
if( !function_exists( 'admin_inwave_load_css' ) ) {

    /*
     * Load css
    */
    function admin_inwave_load_css()
    {
        global $inwave_theme_option, $inwave_post_option;

        $theme_info = wp_get_theme();
        //wp_enqueue_style('select2', get_template_directory_uri() . '/assets/css/select2.css', array(), $theme_info->get('Version'));
        wp_enqueue_style('custombox', get_template_directory_uri() . '/assets/css/custombox.min.css', array(), $theme_info->get('Version'));
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css', array(), $theme_info->get('Version'));
    }

    add_action("admin_enqueue_scripts",'admin_inwave_load_css', 9);
}


/**
 * Load theme custom css
 */
if(!function_exists('inwave_get_custom_css')){

    /*
     * get css custom
    */
    function inwave_get_custom_css()
    {
        global $inwave_theme_option, $inwave_post_option;
        $css = array();

        if($inwave_theme_option['f_body']){
           $css[] = 'html body{font-family:'.$inwave_theme_option['f_body'].'}';
        }

        if($inwave_theme_option['f_nav']){
           $css[] = '.nav-menu{font-family:'.$inwave_theme_option['f_nav'].'}';
        }
        if($inwave_theme_option['f_headings']){
           $css[] = 'h1,h2,h3,h4,h5,h6{font-family:'.$inwave_theme_option['f_headings'].'}';
        }
        if($inwave_theme_option['f_size']){
           $css[] = 'html body{font-size:'.$inwave_theme_option['f_size'].'px}';
        }
        if($inwave_theme_option['f_lineheight']){
           $css[] = 'html body{line-height:'.$inwave_theme_option['f_lineheight'].'px}';
        }

        //body background
        if($inwave_theme_option['body_layout']) {
            if ($inwave_theme_option['bg_color']) {
                if ($inwave_theme_option['bg_image']) {
                   $css[] = 'body.page{background-color:' . $inwave_theme_option['bg_color'] . '}';
                } else {
                   $css[] = 'body.page{background:' . $inwave_theme_option['bg_color'] . '}';
                }
            }

            if ($inwave_theme_option['bg_image']) {
               $css[] = 'body.page{background-image:url(' . $inwave_theme_option['bg_image'] . ')';
                if ($inwave_theme_option['bg_full']) {
                   $css[] = 'background-size:100%';
                }
                if ($inwave_theme_option['bg_repeat']) {
                   $css[] = 'background-repeat:' . $inwave_theme_option['bg_repeat'] . ';';
                }
               $css[] = '}';
            }
        }
        //header bg
        if($inwave_theme_option['header_bg_color']){
           $css[] = '.header{background-color:'.$inwave_theme_option['header_bg_color'].'!important}';
        }
        if($inwave_theme_option['header_top_bg_color']){
           $css[] = '.header-top{background-color:'.$inwave_theme_option['header_top_bg_color'].'!important}';
        }
        if($inwave_theme_option['header_bd_color']){
           $css[] = '.header,.header-top{border-color:'.$inwave_theme_option['header_bd_color'].'!important}';
        }
        //content bg
        if($inwave_theme_option['content_bg_color']){
           $css[] = '.contents-main{background-color:'.$inwave_theme_option['content_bg_color'].'!important}';
        }
        //footer bg
        if($inwave_theme_option['footer_bg_color']){
           $css[] = '.page-footer,.footer-right, .page-footer .container{background:'.$inwave_theme_option['footer_bg_color'].'!important}';
        }
        if($inwave_theme_option['footer_border_color']){
           $css[] = '.page-footer{border-color:'.$inwave_theme_option['footer_border_color'].'!important}';
        }
        if($inwave_theme_option['footer_bg_btt']){
           $css[] = '.copyright{background-color:'.$inwave_theme_option['footer_bg_btt'].'!important}';
        }

        //body color
        if($inwave_theme_option['body_text_color']){
           $css[] = 'html body{color:'.$inwave_theme_option['body_text_color'].'}';
        }
        if($inwave_theme_option['link_color']){
           $css[] = 'a{color:'.$inwave_theme_option['link_color'].'}';
        }
        //header color
        if($inwave_theme_option['header_text_color']){
           $css[] = '.header{color:'.$inwave_theme_option['header_text_color'].'}';
        }
        if($inwave_theme_option['header_link_color']){
           $css[] = '.header a{color:'.$inwave_theme_option['header_link_color'].'}';
        }

        if($inwave_theme_option['button_text_color']){
           $css[] = '#page-top .button,#page-top .btn-submit{color:'.$inwave_theme_option['button_text_color'].'}';
        }
        if($inwave_theme_option['page_title_color']){
           $css[] = '.page-title h1{color:'.$inwave_theme_option['page_title_color'].'}';
        }
        //if($inwave_theme_option['breadcrumbs_text_color']){
        //   $css[] = '.breadcrumbs,.breadcrumbs .category-2{color:'.$inwave_theme_option['breadcrumbs_text_color'].'}';
        //}
        //if($inwave_theme_option['breadcrumbs_link_color']){
        //   $css[] = '.breadcrumbs ul li a {color:'.$inwave_theme_option['breadcrumbs_link_color'].'}';
        //}
        if($inwave_theme_option['blockquote_color']){
           $css[] = '.contents-main blockquote{color:'.$inwave_theme_option['blockquote_color'].'}';
        }
        if($inwave_theme_option['footer_headings_color']){
           $css[] = '.page-footer h3,.page-footer h4{color:'.$inwave_theme_option['footer_headings_color'].'}';
        }
        if($inwave_theme_option['footer_text_color']){
           $css[] = '.page-footer{color:'.$inwave_theme_option['footer_text_color'].'}';
        }
        if($inwave_theme_option['footer_link_color']){
           $css[] = '.page-footer a{color:'.$inwave_theme_option['footer_link_color'].'}';
        }

        // header bg image
        if($inwave_theme_option['header_bg_image']){
           $css[] = '.page-heading{background-image:url('.$inwave_theme_option['header_bg_image'].')!important;';
            if($inwave_theme_option['header_bg_full']){
                $css[] = 'background-size:100%;';
            }
            if($inwave_theme_option['header_bg_repeat']){
                $css[] = 'background-repeat:'.$inwave_theme_option['header_bg_repeat'].';';
            }
           $css[] = '}';
        }

        if($inwave_theme_option['page_title_height']){
            $paddingTop = floor(intval($inwave_theme_option['page_title_height'])/2);
            if(intval($inwave_theme_option['page_title_height']) < 250){
                $css[] ='.wrapper .page-heading{height:'.$inwave_theme_option['page_title_height'].'!important;}.page-heading .iw-heading-title{padding-top:'.$paddingTop.'px;!important}';
            }else{
                $css[] = '.page-heading{height:'.$inwave_theme_option['page_title_height'].';}.page-heading .iw-heading-title{padding-top:'.$paddingTop.'px;}';
            }

        }
        if($inwave_theme_option['page_title_bg']){
           $css[] = '.page-heading{background-image:url('.$inwave_theme_option['page_title_bg'].')!important;';
            if($inwave_theme_option['page_title_bg_full']){
                $css[] = 'background-size:100%;';
            }
            if($inwave_theme_option['page_title_bg_repeat']){
                $css[] = 'background-repeat:'.$inwave_theme_option['page_title_bg_repeat'].';';
            }
           $css[] = '}';
        }

        //footer widget
        if($inwave_theme_option['footer_bg_image']){
           $css[] = '.page-footer{background-image:url('.$inwave_theme_option['footer_bg_image'].')!important;';
            if($inwave_theme_option['footer_bg_full']){
                $css[] = 'background-size:100%';
            }
            if($inwave_theme_option['footer_bg_repeat']){
                $css[] = 'background-repeat:'.$inwave_theme_option['page_title_bg_repeat'].';';
            }
           $css[] = '}';

           $css[] = '.footer-right, .page-footer .container{background:none!important;}';
        }

        if (isset($inwave_post_option['pageheading_bg']) && $inwave_post_option['pageheading_bg']) {
           $css[] = 'body .page-heading{background-image:url(\'' . esc_url($inwave_post_option['pageheading_bg']) . '\')!important;}';
        }

        $css = implode("\n", $css);
        //wp_add_inline_style( 'motohero-style', $css);
        return $css;
    }
    //add_action("wp_enqueue_scripts",'inwave_get_custom_css', 9);

}