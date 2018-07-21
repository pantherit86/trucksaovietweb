<?php
/** Widget contact in footer  */

class Inwave_Widget_Flickr extends WP_Widget
{
    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct(
            'inwave-flickr',
            esc_html__('Inwave Flickr', 'inwavethemes'),
            array('description' => esc_html__('Widget display subscribe.', 'inwavethemes'))
        );
    }

    /**
     * Tạo form option cho widget
     */
    function form($instance)
    {
        $default = array(
            'title' => 'Title',
            'items' => '',
            'flickr_id' => ''
        );
        $instance = wp_parse_args((array)$instance, $default);
        $title = esc_attr($instance['title']);
        $items = esc_attr($instance['items']);
        $flickr_id = esc_attr($instance['flickr_id']);

        echo '<p>Title<input type="text" class="widefat" id="'. $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $title . '"/></p>';
        echo '<p>Items<input type="text" class="widefat" name="' . $this->get_field_name('items') . '" value="' . $items . '"/></p>';
        echo '<p>Flickr ID<input type="text" class="widefat" name="' . $this->get_field_name('flickr_id') . '" value="' . $flickr_id . '"/></p>';
    }

    /**
     * save widget form
     */

    function update($new_instance, $old_instance)
    {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['items'] = strip_tags($new_instance['items']);
        $instance['flickr_id'] = strip_tags($new_instance['flickr_id']);

        return $instance;
    }

    /**
     * Show widget
     */
    function widget($args, $instance)
    {

        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $items = empty($instance['items']) ? '' : $instance['items'];
        $flickr_id = empty($instance['flickr_id']) ? '' : $instance['flickr_id'];

        echo $before_widget;

        echo wp_kses_post($before_title . $title . $after_title);
        if(!defined('SLICKR_FLICKR_VERSION')){
            echo __('Please install and active slickr-flickr plugin first !', 'inwavethemes');
        }
        else
        {
            echo do_shortcode('[slickr-flickr items="'.esc_attr($items).'" type="gallery" id="'.esc_attr($flickr_id).'"]');
        }
        // End show widget
        echo $after_widget;
    }
}

register_widget('Inwave_Widget_Flickr');