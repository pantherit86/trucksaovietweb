<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Profile_Info')) {

    class Inwave_Profile_Info extends Inwave_Shortcode2{

		protected $name = 'inwave_profile_info';
		protected $name2 = 'inwave_profile_info_item';

        function init_params()
		{
			return array(
				"name" => __("Show users profile with tab", 'inwavethemes'),
				"base" => $this->name,
				"content_element" => true,
				'category' => 'Custom',
				"description" => __("Add a set of tabs and give some custom style.", "inwavethemes"),
				"as_parent" => array('only' => 'inwave_profile_info_item'),
				"show_settings_on_create" => true,
				"js_view" => 'VcColumnView',
				'icon' => 'iw-default',
				"params" => array()
			);
		}

		function init_params2() {
            return array(
                'name' => 'Profile info item',
                'description' => __('Show user profile with skills', 'inwavethemes'),
                'base' => $this->name2,
				"as_child" => array('only' => 'inwave_profile_info'),
				"as_parent" => array('except' => 'inwave_profile_info,inwave_profile_info_item'),
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("User name", "inwavethemes"),
                        "value" => "",
                        "param_name" => "user_name"
                    ),
					array(
                        "type" => "textfield",
						"holder" => "div",
                        "heading" => __("User position", "inwavethemes"),
						"value" => "",
                        "param_name" => "user_position"
                    ),
					array(
                        "type" => "textarea_html",
                        "heading" => __("User Description", "inwavethemes"),
                        "param_name" => "user_desc",
                        "value" => ""
                    ),
					array(
                        "type" => "textarea",
                        "heading" => __("Social links", "inwavethemes"),
                        "description" => __("Separated by newline", "inwavethemes"),
                        "param_name" => "social_links",
                        "value" => ""
                    ),
					array(
                        'type' => 'attach_image',
                        "heading" => __("Profile Image", "inwavethemes"),
                        "param_name" => "user_img"
                    ),
                    array(
                        "type" => "iw_profile_info",
                        "heading" => __("User skills", "inwavethemes"),
						"value" => "",
                        "param_name" => "user_skills"
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
                        )
                    ),
                )
            );
        }

		function init_shortcode($atts, $content = null) {
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            extract(shortcode_atts(array(
            
            ), $atts));
		ob_start();
		?>
		
		<?php 
		$matches = array();
        $count = preg_match_all('/\[inwave_profile_info_item\s+user_name="([^\"]+)"(.*)\]/Usi', $content, $matches, PREG_OFFSET_CAPTURE);
		//$count = preg_match_all( '/inwave_profile_info_item([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
		?>
		
		<div class="profile_tabs">
			<div class="profile_tabs_buttons">
				<?php 
					$items = array();
					var_dump($matches[0][0][0]);die;
					foreach ($matches[0] as $value) {
						$items[] = shortcode_parse_atts( $value[0] );
					}
					var_dump($items[0][1]);die;
					foreach ($items as $key => $item) {
						$image = $item['user_img'];
						var_dump($image);echo '<br/>';
						if ($image) {
							$img = wp_get_attachment_image_src($image);
							$image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
						}
						echo $image;
					}
				?>
			</div>
			<div class="profile_tabs_contents">
				<?php echo do_shortcode($content);	?>
			</div>
			
        </div>   

        <?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
		}

        // Shortcode handler function for list Icon
        function init_shortcode2($atts, $content = null) {
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

			$user_name = $user_position = $user_desc = $social_links = $user_img = $user_skills = $class = $style = '';

            extract(shortcode_atts(array(
                'user_name' => '',
				'user_position' => '',
				'user_desc' => '',
				'user_skills' => '',
				'social_links' => '',
				'user_img' => '',
				'class' => '',
				'style' => '',
            ), $atts));
			
			
			$img_tag = '';
            if ($user_img) {
                $user_img = wp_get_attachment_image_src($user_img, 'large');
                $user_img = $user_img[0];
                $size = '';
                $img_tag .= '<img ' . $size . ' src="' . $user_img . '" alt="' . $user_name . '">';
            }
			$social_links = str_replace('<br />', "\n", $social_links);
            $social_links = explode("\n", $social_links);
			
			ob_start();
			switch ($style) {
				case 'style1':
				?>
				
				<?php
					break;
					default:
				?>
					<div class="profile_tabs_contents_item">
					<div class=""><?php echo $user_name; ?></div>
					<div class=""><?php echo $user_position; ?></div>
					<div class=""><?php echo $user_desc; ?></div>
					<div class="">
						<?php 
							 foreach ($social_links as $link) {
								$domain = explode(".com", $link);
								if ($link && isset($domain[0])) {
									$domain = str_replace(array('https://', 'http://'), '', $domain[0]);
									if ($domain == 'plus.google') {
										$domain = 'google-plus';
									}
									echo '<a href="' . $link . '"><i class="fa fa-' . $domain . '"></i></a>';
								}
							}
							
						?>
					</div>
					<div class=""><?php echo $img_tag; ?></div>
						
						<?php 
					//	var_dump($user_skills);
						if($user_skills){
							$arr = explode('||', $user_skills);
							foreach($arr as $k=>$v){
								$profile_info = explode(',',$v);
								?>
								<div class="profile_list_item">
									<label>Skill title: <?php echo $profile_info[0];?></label>
									<label>Skill value: <?php echo $profile_info[1];?></label>
									<br />
								</div>
								<?php
							}
						}
						?>
						
					
					</div>
			
				<?php 
					break;
				}
			
			$html2 = ob_get_contents();
            ob_end_clean();

            return $html2;
        }
    }
}

new Inwave_Profile_Info;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Profile_Info extends WPBakeryShortCodesContainer {
    }
}