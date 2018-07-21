<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Mailchimp')) {

    class Inwave_Mailchimp extends Inwave_Shortcode{

		protected $name = 'inwave_mailchimp';

		function register_scripts()
		{
			wp_enqueue_script('mailchimp');
		}

		function init_params() {
            return array(
                'name' => __('Mailchimp subscribe', 'inwavethemes'),
                'description' => __('Simple form for mailchimp', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
					array(
						"type" => "dropdown",
						"heading" => __("Style", 'inwavethemes'),
						"param_name" => "style",
						"value" => array(
							"Style 1" => "style1",
							"Style 2" => "style2",
						)
					),
					array(
						"type" => "iwevent_preview_image",
						"heading" => __("Preview Style", "inwavethemes"),
						"param_name" => "preview_style1",
						"value" => get_template_directory_uri() . '/assets/images/shortcodes/mailchimp-style1.jpg',
						"dependency" => array('element' => 'style', 'value' => 'style1')
					),
					array(
						"type" => "iwevent_preview_image",
						"heading" => __("Preview Style", "inwavethemes"),
						"param_name" => "preview_style2",
						"value" => get_template_directory_uri() . '/assets/images/shortcodes/mailchimp-style2.jpg',
						"dependency" => array('element' => 'style', 'value' => 'style2')
					),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title",
						"description" => __("To show video button You can add {video_btn} to title", "inwavethemes"),
                    ),
					array(
                        'type' => 'textfield',
                        "heading" => __("Description", "inwavethemes"),
                        "value" => "",
                        "param_name" => "desc",
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Action URL", "inwavethemes"),
                        "value" => "",
                        "description"=> "How to get it? Just go to your <a href='https://us11.admin.mailchimp.com/lists/' target='_blank'>Mailchimp list</a> -> \"Signup forms\" -> \"Embedded forms\" and then take form action url in <a href='http://prntscr.com/7lieht' target='_blank'>the embed code</a>",
                        "param_name" => "action"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Video Background URL", "inwavethemes"),
                        "param_name" => "video_url",
                        "value" => '',
                        "dependency" => array('element' => 'style', 'value' => 'style1')
                    ),
					array(
						'type' => 'colorpicker',
						"heading" => __("Overlay Color", "inwavethemes"),
						"description" => __("Enter value: 'transparent' if you want to disable overlay", "inwavethemes"),
						"param_name" => "overlay",
						"dependency" => array('element' => 'style', 'value' => 'style1')
					),
					array(
						'type' => 'textfield',
						"heading" => __("Overlay opacity", "inwavethemes"),
						"description" => __("Enter value 0 -> 1, example '0.9'", "inwavethemes"),
						"value"=>'0.9',
						"param_name" => "opacity"
					),
					array(
						'type' => 'attach_image',
						"heading" => __("Poster image", "inwavethemes"),
						"param_name" => "poster",
						"dependency" => array('element' => 'style', 'value' => 'style1')
					),
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

			$output = $action = $desc = '';
            extract(shortcode_atts(array(
                'title' => '',
				'desc' => '',
                'action' => '',
                'style' => 'style1',
                'video_url' => '',
                'overlay' => '',
                'opacity' => '',
                'poster' => '',
			), $atts));

			$response['submit'] = __('Submitting...','inwavethemes');
            $response[0] = __('We have sent you a confirmation email','inwavethemes');
            $response[1] = __('Please enter a value','inwavethemes');
            $response[2] = __('An email address must contain a single @','inwavethemes');
            $response[3] = __('The domain portion of the email address is invalid (the portion after the @: )','inwavethemes');
            $response[4] = __('The username portion of the email address is invalid (the portion before the @: )','inwavethemes');
            $response[5] = __('This email address looks fake or invalid. Please enter a real email address','inwavethemes');

            $response = json_encode($response);
            $class .= ' ' . $style;
			
			
			$title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);

            $output .= '<div class="iw-mailchimp-form '.$class.'"><form class="iw-email-notifications" action="' . $action . '" data-response="' . htmlentities($response) . '">';
			switch($style) {
				case 'style1':
					$output .= '<div class="iw-video">';
						$output .= '<div class="iw-video-player">';
							$video_btn = '<span class="play-button"><i class="fa fa-play"></i></span>';
							$output .= '<video src="'.esc_url($video_url).'"></video>';
							if($poster){
								$poster = wp_get_attachment_image_src($poster, 'large');
								$poster = $poster[0];
								$output .= '<div class="iw-video-poster"><img class="" src="'.$poster.'" alt="" /></div>';
							}
							if($overlay && $overlay!='transparent') {
								$output .= '<div class="iw-video-overlay" style="background-color:' . $overlay . '; opacity:' . $opacity . '"></div>';
							}
							$output .= '<div class="iw-video-content">';
								$output .= '<div class="ajax-overlay"><span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span></div>';
								if($title){
									$output .= '<h3>'.str_replace('{video_btn}', $video_btn, $title).'</h3>';
								}
								if($desc){
									$output .= '<p>'.str_replace('{video_btn}', $video_btn, $desc).'</p>';
								}
								$output .= '<input class="mc-email" type="email" placeholder="' . esc_attr(__('Your email address', 'inwavethemes')) . '">';
								$output .= '<button class="theme-bg" type="submit">' . esc_attr(__('Subscribe', 'inwavethemes')) . '</button>';
								$output .= '<div class="response"><label></label></div>';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				break;
				case 'style2':
					$output .= '<div class="ajax-overlay"><span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span></div>';
					if($desc){
						$output .= '<div class="malchimp-desc">'.$desc.'</div>';
					}
					$output .= '<input class="mc-email" type="email"  placeholder="' .esc_attr(__('Email address', 'inwavethemes')) .'">';
					$output .= '<button type="submit">' .esc_attr(__('DONE', 'inwavethemes')) .'</button>';
					$output .= '<p class= "privacy">' .esc_attr(__('We Respect Your Privacy', 'inwavethemes')) .'</p>';
					$output .= '<span class="response"><label></label></span>';
					break;
			}
            
            $output .= '</form></div>';

            return $output;
        }
    }
}

new Inwave_Mailchimp;
