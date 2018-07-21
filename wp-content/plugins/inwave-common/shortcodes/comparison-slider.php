<?php
/*
 * Inwave_Adv_Banner for Visual Composer
 */
if (!class_exists('Inwave_Comparision_Slider')) {

    class Inwave_Comparision_Slider extends Inwave_Shortcode{

        protected $name = 'inwave_comparision_slider';

        function init_params() {
            return array(
                'name' => __("Comparision Slider", 'inwavethemes'),
                'description' => __('A handy draggable slider to quickly compare 2 images', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Before image", "inwavethemes"),
                        "param_name" => "before"
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("After image", "inwavethemes"),
                        "param_name" => "after"
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
            wp_enqueue_script('twentytwenty');
            wp_enqueue_script('event-move');
            $output = $before = $after = $class ='';
            extract(shortcode_atts(array(
                'before' => '',
                'after' => '',
                'class' => ''
                            ), $atts));


            if ($before) {
                $before = wp_get_attachment_image_src($before, 'large');
                $before = $before[0];
            }
            if ($after) {
                $after = wp_get_attachment_image_src($after, 'large');
                $after = $after[0];
            }
			ob_start();

            ?>
            <div class="comparision-slider <?php echo $class?>">
                <img src="<?php echo $before ?>" alt="" />
                <img src="<?php echo $after ?>" alt="" />
            </div>
            <?php
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
}

new Inwave_Comparision_Slider;
