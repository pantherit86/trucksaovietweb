<?php
/*
 * Inwave_Adv_Banner for Visual Composer
 */
if (!class_exists('Inwave_Adv_Banner')) {

    class Inwave_Adv_Banner extends Inwave_Shortcode{

        protected $name = 'inwave_adv_banner';

        function init_params() {
            return array(
                'name' => __("Adv Banner", 'inwavethemes'),
                'description' => __('Add a banner & some advertising information', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Banner Image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textarea_html',
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "link"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                            "Style 3" => "style3"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $img = $title = $sub_title = $class = $link = $button_text = $style = '';
            extract(shortcode_atts(array(
                'img' => '',
                'title' => '',
                'sub_title' => '',
                'class' => '',
                'link' => '',
                'button_text' => '',
                'style' => 'style1'
                            ), $atts));
            $img_tag = '';
            $bg_tag = '';
            $img_size = '';
            $title = str_replace('//','<br />',$title);
            $sub_title = str_replace('//','<br />',$sub_title);
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                if ($img_size) {
                    $img_size = explode('x', $img_size);
                    $size = 'style="width:' . $img_size[0] . 'px!important;height:' . $img_size[1] . 'px!important"';
                }
                $img_tag .= '<img ' . $size . ' src="' . $img . '" alt="' . $title . '">';
            }
			$class .= ' ' . $style;
			ob_start();
            switch ($style) {
                case 'style1':
                case 'style2':
                    ?>
                    <div class="iw-av-banner<?php echo $class?>">
                        <?php echo $img_tag;?>
                        <div class="banner-content">
                            <?php if ($button_text) {
                                echo '<div class="iw-av-title"><span>' .$title. '</span></div>';
                            }
                            ?>
                            <?php if ($button_text) {
                                echo '<div class="iw-av-subtitle">' .$sub_title. '</div>';
                            }
                            ?>
                            <?php if ($button_text) {
                                echo '<div class="banner-button"><a href="' . $link . '">' . $button_text . '</a></div>';
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    break;
				case 'style3':
                    ?>
                    <div class="iw-av-banner<?php echo $class?>">
                        <?php echo $img_tag;?>
                        <div class="iw-overlay"></div>
                        <div class="banner-content">
                            <?php if ($button_text) {
                                echo '<div class="iw-av-title"><span>' .$title. '</span></div>';
                            }
                            ?>
                            <?php if ($button_text) {
                                echo '<div class="iw-av-subtitle">' .$sub_title. '</div>';
                            }
                            ?>
                            <?php if ($button_text) {
                                echo '<div class="banner-button"><a href="' . $link . '">' . $button_text . '</a></div>';
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    break;
			}
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
}

new Inwave_Adv_Banner;
