<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Event_Fact')) {

	class Inwave_Event_Fact extends Inwave_Shortcode2
	{

		protected $name = 'inwave_event_fact';
		protected $name2 = 'inwave_event_fact_item';
		protected $count;

		function init_params()
		{
			return array(
				'name' => __("Event Fact", 'inwavethemes'),
				'base' => $this->name,
				'content_element' => true,
				'description' => __('Show Event Fact', 'inwavethemes'),
				'as_parent' => array('only' => 'inwave_event_fact_item'),
				'category' => 'Custom',
				'show_settings_on_create' => true,
				'js_view' => 'VcColumnView',
				'icon' => 'iw-default',
				'params' => array(
					array(
						"type" => "textfield",
						"heading" => __("Extra Class", "inwavethemes"),
						"value" => "",
						"param_name" => "extra_class"
					),
					array(
						'type' => 'textfield',
						"heading" => __("Height", "inwavethemes"),
						"value" => "",
						"description" => __('Example 16px', "inwavethemes"),
						"param_name" => "height"
					),
					array(
						'type' => 'textfield',
						"heading" => __("Text intro", "inwavethemes"),
						"value" => "",
						"param_name" => "text_intro"
					),
					array(
						'type' => 'textfield',
						"heading" => __("Source Video", "inwavethemes"),
						"value" => "",
						"param_name" => "source_video"
					),
					array(
						"type" => "dropdown",
						"group" => "Style",
						"class" => "",
						"heading" => "Style",
						"param_name" => "style",
						"value" => array(
							"Style 1 - video" => "style1",
							"Style 2 - normal" => "style2",
						)
					),
				)
			);
		}

		function init_params2()
		{
			return array(
				"name" => __("Event Fact Item", 'inwavethemes'),
				"base" => $this->name2,
				"class" => "inwave_event_fact_item",
				'icon' => 'iw-default',
				'category' => 'Custom',
				"as_child" => array('only' => 'inwave_event_fact'),
				"description" => __("Add a event fact item", "inwavethemes"),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"type" => "textfield",
						"holder" => "div",
						"heading" => __("Event fact item title", "inwavethemes"),
						"param_name" => "event_fact_title",
						"value" => "",
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"heading" => __("Event fact item description", "inwavethemes"),
						"param_name" => "event_fact_desc",
						"value" => "",
					),
					array(
						'type' => 'textfield',
						"heading" => __("Bottom", "inwavethemes"),
						"value" => "",
						"description" => __('Example 16', "inwavethemes"),
						"param_name" => "bottom_value"
					),
					array(
						"type" => "iw_icon",
						"class" => "",
						"heading" => __("Select Icon", "inwavethemes"),
						"param_name" => "icon",
						"value" => "",
						"admin_label" => true,
						"description" => __("Click and select icon of your choice. You can get complete list of available icons here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/icons/'>Font-Awesome</a>", "inwavethemes"),
					),
					array(
						"type" => "textfield",
						"heading" => __("Icon Size", "inwavethemes"),
						"param_name" => "icon_size",
						"description" => __("Example: 70", "inwavethemes"),
						"value" => "70"
					),
				)
			);
		}

		// Shortcode handler function for facts
		function init_shortcode($atts, $content = null)
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

			$output = $style = $text_intro = $extra_class = $height = $source_video = '';
			extract(shortcode_atts(array(
				'extra_class' => '',
				'height' => '',
				'style' => 'style1',
				'text_intro' => '',
				'source_video' => '',
			), $atts));
			$matches = array();
			$this->count = preg_match_all('/\[inwave_event_fact_item\s+event_fact_title="([^\"]+)"(.*)\]/Usi', $content, $matches);
			ob_start();

			switch ($style) {
				case 'style1':
					?>

					<div class="iw-event-facts theme-bg<?php if ($extra_class) {
						echo ' ' . $extra_class;
					} ?>" <?php if ($height) {
						echo 'style="height:' . $height . 'px"';
					} ?>>
						<div class="iw-video">
							<div class="iw-video-facts">
								<div class="play-button">
									<i class="fa fa-play-circle animate zoomIn animated" style="font-size:50px"></i>
								</div>
								<div class="iw-video-player">
									<video src="<?php echo $source_video ?>"></video>
									<div class="iw-video-overlay" style="background-color:#000000;opacity:0.5"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="container">
								<div class="event-facts-inner">
									<?php echo do_shortcode($content); ?>
									<div style="clear:both;"></div>
								</div>
							</div>
						</div>

						<div class="bg-svg">
							<svg preserveAspectRatio="none" viewBox="0 0 900 140">
								<path class="fill-color fill-color1"
									  d="M40,90 Q 190,10 340,90 t300,0 t300,0 t300,0 l0,90 l-1200,0" stroke-width="0"/>
								<path class="fill-color fill-color2"
									  d="M-230,80 Q -80,0 70,80 t300,0 t300,0 t300,0 t300,0 l0,80 l-1500,0"
									  stroke-width="0"/>
							</svg>
						</div>
					</div>

					<?php
					break;
				case 'style2':
					?>
					<div class="iw-event-facts2">
						<div class="container">
							<?php if ($text_intro) { ?>
								<div class="text_intro"><?php echo $text_intro; ?></div>
							<?php } ?>
							<div class="event-facts-inner">
								<?php echo do_shortcode($content); ?>
								<div style="clear:both;"></div>
							</div>
						</div>
					</div>


					<?php
					break;
			}
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}

		// Shortcode handler function for fact item
		function init_shortcode2($atts, $content = null)
		{
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

			$output = $event_fact_title = $event_fact_desc = $bottom_value = $icon = $icon_size = '';
			extract(shortcode_atts(array(
				'event_fact_title' => '',
				'event_fact_desc' => '',
				'bottom_value' => '',
				'icon' => '',
				'icon_size' => '',
			), $atts));


			ob_start();
			?>

			<div class="iw-event-fact-item item-<?php echo $this->count; ?>  col-md-3 col-sm-3 col-xs-12">
				<div class="event-fact-inner" <?php if ($bottom_value) {
					echo 'style="bottom:' . intval($bottom_value) . 'px"';
				} ?>>
					<div class="event-fact-info">
						<div class="event-fact-title"><?php echo $event_fact_title ?></div>
						<div class="event-fact-desc"><?php echo $event_fact_desc ?></div>
					</div>
					<?php if ($icon) : ?>
						<div class="dotted-line"></div>
						<div class="icon-facts">
							<div class="icon theme-color"><i style="font-size:<?php echo $icon_size ?>px"
															 class="<?php echo $icon ?>"></i></div>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php
			$html2 = ob_get_contents();
			ob_end_clean();
			return $html2;
		}
	}
}
new Inwave_Event_Fact;

?>