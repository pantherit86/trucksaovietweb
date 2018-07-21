<?php
/**
 * Created by PhpStorm.
 * User: HUNGTX
 * Date: 4/1/2015
 * Time: 4:44 PM
 */
class Inwave_Customizer
{
    function __construct()
    {
        global $inwave_theme_option;

        /** Dynamic css color*/

		add_action('wp_ajax_inwave_color', array($this, 'color'));
        add_action('wp_ajax_nopriv_inwave_color', array($this, 'color'));
        add_action('inwave_of_save_options_after', array($this, 'color'));

        /* Load setting from cookie*/
        $this->load_panel_settings();

        if ( is_admin() ) {
            /* INCLUDE IMPORT DEMO CONTENT */
			add_action('admin_init', array($this, 'checkCreatedCustomCSS'));

        }else{
            /* Append panel setting to footer*/
            if($inwave_theme_option['show_setting_panel']) {
                add_action('wp_footer', array($this, 'append_options'));
            }
        }
    }

	function checkCreatedCustomCSS(){
		WP_Filesystem();
        global $wp_filesystem;
		if(!$wp_filesystem->exists($this->getCustomCssDir().'custom.css')){	
		
			$this->color();
		}
	}
	public static function getCustomCssDir(){
		$uploads = wp_upload_dir();
		return $uploads['basedir'] . '/motohero/';
	}
	public static function getCustomCssUrl(){
		$uploads = wp_upload_dir();
		return $uploads['baseurl'] . '/motohero/';
	}

    /* Load panel settings from cookie or default config */
    public static function load_panel_settings()
    {
        global $inwave_post_option, $inwave_theme_option;
        if(isset($inwave_theme_option['show_setting_panel'])) {
            if ($inwave_theme_option['show_setting_panel'] && isset($_COOKIE['motohero-setting']) && $_COOKIE['motohero-setting']) {
                $inwave_post_option['panel-settings'] = str_replace('\"', '"', $_COOKIE['motohero-setting']);
                $inwave_post_option['panel-settings'] = @json_decode($inwave_post_option['panel-settings']);
            } else {
                $inwave_post_option['panel-settings'] = new stdClass();
                $inwave_post_option['panel-settings']->layout = $inwave_theme_option['body_layout'];
                $inwave_post_option['panel-settings']->mainColor = $inwave_theme_option['primary_color'];
            }
            if(!isset($inwave_post_option['panel-settings']->bgColor)){
                $inwave_post_option['panel-settings']->bgColor = '';
            }
        }
    }

    /* Append panel setting to footer*/
    function append_options()
    {
        include_once(get_template_directory() . '/blocks/panel-settings.php');
    }

    /** return/echo css color and css configuration */
    public static function color($return_text = false)
    {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global $inwave_post_option,$wp_filesystem;
		
        // load settings again
		self::load_panel_settings();

        // Color & background for content
        $colorText = trim($wp_filesystem->get_contents(get_template_directory() . '/assets/css/color.css'));
        if ($inwave_post_option['panel-settings']->mainColor) {
            $colorText = str_replace('#009fd7', $inwave_post_option['panel-settings']->mainColor, $colorText);
        }

        // CSS configuration. Example: background color of header,footer
        $colorText .= "\n".'
/*-------------------------------------------------------
CUSTOM CSS
--------------------------------------------------------*/
';
        $colorText .=  "\n".inwave_get_custom_css();

        // Background for Body page
        if (isset($inwave_post_option['panel-settings']->bgColor)&& $inwave_post_option['panel-settings']->bgColor) {
            if ($inwave_post_option['panel-settings']->bgColor[0] == '#') {
                $colorText .= 'body.page{background:' . $inwave_post_option['panel-settings']->bgColor . '}';
            } else {
                $colorText .= 'body.page{background:url(' . $inwave_post_option['panel-settings']->bgColor . ')}';
            }
        }
		
        if($return_text) {
			return $colorText;
		}else{
			$iw_upload_url = self::getCustomCssDir();
			if ( ! $wp_filesystem->is_dir( $iw_upload_url ) ) {
				if ( ! $wp_filesystem->mkdir( $iw_upload_url, 0755 ) ) {
					return false;
				}
			}

			$wp_filesystem->put_contents($iw_upload_url.'custom.css',$colorText);
		}
    }
}
new Inwave_Customizer();