<?php
/*
 * @package Inwave Event
 * @version 1.0.0
 * @created Jun 8, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */


/**
 * Description of server_locations
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Server_Locations')) {

    class Inwave_Server_Locations extends Inwave_Shortcode{

		protected $name = 'server_locations';

		function init_params() {

            return array(
                'name' => 'Inwave Server Locations',
                'description' => __('Add a server locations block', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
					array(
                        'type' => 'textfield',
                        "heading" => __("Description", "inwavethemes"),
                        "value" => "",
                        "param_name" => "desc"
                    ),
                    array(
                        'type' => 'iw_server_location',
                        "heading" => __("Location info", "inwavethemes"),
                        "value" => "",
                        "param_name" => "server_locations"
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
                        "heading" => __("Style", "inwavethemes"),
                        "param_name" => "style",
                        "value" => array(
                            'Style 1' => 'style1',
                            'Style 2' => 'style2',
                        )
                    ),
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
			$atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

			$title = $style = $desc = "";
            extract(shortcode_atts(array(
                "title" => "",
                "server_locations" => "",
                "class" => "",
				"desc" =>"",
				"style" => "style1",
                            ), $atts));
            ob_start();
            $utility = new inFundingUtility();
            
            if ($server_locations):
                $server_location_info = json_decode(base64_decode($server_locations));
			
			switch ($style) {
			case 'style1':
                ?>
				<div class="server-location-block <?php echo $class ?>">
				<div class="block-title"><?php echo $title; ?></div>
					<div class="iw-server-location-wrap site-view">
						<?php
						if ($server_location_info[0]) {
							$mapimg = wp_get_attachment_image_src($server_location_info[0], 'large');
							$map_img_src = $mapimg[0];
						} else {
							$map_img_src = plugins_url('inwave-common/assets/images/map.png');
						}
						?>
						<div class="image-map-preview col-sm-6">
							<div class="image">
								<img src="<?php echo $map_img_src; ?>" alt="map" />
							</div>
							<div class="iw-map-pickers">
								<?php
								$marker_infos = array();
								if (!empty($server_location_info[1]) && $server_location_info[1]) {
									$i = 1;
									foreach ($server_location_info[1] as $marker) {

										if($marker[0]){
											$post = get_post($marker[0]);
										}else{
											$post = new stdClass();
											$post->ID = 0;
											$post->post_title = '';
											$post->post_content = '';
										}
										$marker_info = array();
										$marker_info['id'] = $post->ID;
										$marker_info['title'] = $post->post_title;
										$marker_info['cat'] = '';
										if (!empty($post->post_category)) {
											$marker_info['cat'] = get_cat_name($post->post_category[0]);
										}
										$marker_info['content'] = $post->post_content;
										$marker_info['active'] = 1;
	//                                    if ($marker[2]) {
	//                                        $marker_info['active'] = 1;
	//                                    }
										$marker_infos[] = $marker_info;

										$style = '';
										$pos = explode('x', $marker[1]);
										$style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
										$flag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
										if($flag){
											$flag = '<img alt="flag" src="'.$flag[0].'" width="30"/>';
										}
										echo '<div data-post="' . $marker[0] . '" data-position="' . $marker[1] . '" class="map-picker theme-bg" style="' . $style . '"><span class="numerical-order">0' .$i. '</span></div>';
										$i ++;
									}
								}
								?>
							</div>
						</div>
						<div class="marker-info col-sm-6">

							<?php
							if (!empty($marker_infos)):
								$j = 1;
								foreach ($marker_infos as $marker_info):
									?>
									<div class="marker-info-<?php echo $marker_info['id']; ?>">
										<span class="numerical-order theme-bg"><?php echo '0'.$j ?></span>
										<div class="marker-info-right">
											<div class="title iw-capital"><?php echo $marker_info['title']; ?></div>
											<div class="description"><?php echo do_shortcode($marker_info['content']); ?></div>
										</div>
									</div>
									<?php $j ++; ?>
									<?php
								endforeach;
							endif;
							?>
						</div>
					</div>
				</div>
                <?php
			break;
			case 'style2':
			?>
				<div class="server-location-block <?php echo $class ?>">
				
					<div class="container">
						<?php if ($title || $desc){ ?>
							<div class="block-titles">
								<?php if ($title){ ?>
									<div class="block-title"><?php echo $title; ?></div>
								<?php } ?>	
								<?php if ($desc){ ?>
									<div class="block-desc"><?php echo $desc; ?></div>
								<?php } ?>	
							</div>
						<?php } ?>	
						
						<div class="iw-server-location-2 site-view style2 theme-bg">
							<?php
							if ($server_location_info[0]) {
								$mapimg = wp_get_attachment_image_src($server_location_info[0], 'large');
								$map_img_src = $mapimg[0];
							} else {
								$map_img_src = plugins_url('inwave-common/assets/images/map.png');
							}
							?>
							<div class="image-map-preview">
								<div class="image">
									<img src="<?php echo $map_img_src; ?>" alt="map" />
								</div>
								<div class="iw-map-pickers">
									<?php
									$marker_infos = array();
									if (!empty($server_location_info[1]) && $server_location_info[1]) {
										$i = 1;
										foreach ($server_location_info[1] as $marker) {

											if($marker[0]){
												$post = get_post($marker[0]);
											}else{
												$post = new stdClass();
												$post->ID = 0;
												$post->post_title = '';
												$post->post_content = '';
											}
											$marker_info = array();
											$marker_info['id'] = $post->ID;
											$marker_info['title'] = $post->post_title;
											if (!empty($post->post_category)) {
												$marker_info['cat'] = get_cat_name($post->post_category[0]);
											}
											$marker_info['content'] = $post->post_content;
											$marker_info['active'] = 1;
		//                                    if ($marker[2]) {
		//                                        $marker_info['active'] = 1;
		//                                    }
											$marker_infos[] = $marker_info;

											$style = '';
											$pos = explode('x', $marker[1]);
											//$style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
											//$style2 = 'left: calc('.$pos[0] * 100 .'% - 300px)'; 'bottom: 0';
											$style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
											$style2 = 'left: '.$pos[0] * 100 .'%; bottom: 0';
											$flag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
											if($flag){
												$flag = '<img alt="" src="'.$flag[0].'" />';
											} ?>
											
											<div data-post="<?php echo $marker[0] ?>" data-position="<?php echo $marker[1] ?>" class="map-picker">
												<div class="picker-icon" style="<?php echo $style ?>"><i class="fa fa-plus"></i></div>
												<div class="marker-info-item marker-info-<?php echo $marker_info['id']; ?>" style="<?php echo $style; ?>">
													<div class="row">
														<?php if ($flag){ ?>
															<div class="col-md-6 col-sm-12 col-xs-12">
																<div class="marker-image"><?php echo $flag; ?></div>
															</div>
														<?php } ?>
														<div class="col-md-6 col-sm-12 col-xs-12">
															<div class="marker-info-right">
																<div class="title theme-color"><?php echo $marker_info['title']; ?></div>
																<div class="description"><?php echo do_shortcode($marker_info['content']); ?></div>
															</div>
														</div>
													</div>
												</div>
											
											</div>
											
										<?php $i ++;
										}
									}
									?>
								</div>
							</div>
					
						</div>
					</div>
				</div>
			
			<?php 
			break;
			}
            endif;
            $html = ob_get_contents();
            ob_end_clean();

            return $html;
        }
    }
}

new Inwave_Server_Locations();
