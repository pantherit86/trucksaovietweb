<?php
/** Widget contact in footer  */

class Inwave_Widget_Subscribe extends WP_Widget {

    /**
     * Construct
     */
    function __construct() {
        parent::__construct(
            'inwave-subscribe',
            esc_html__('Inwave Subscribe', 'inwavethemes'),
            array( 'description'  =>  esc_html__('Widget display subscribe.', 'inwavethemes') )
        );
    }

    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {
        $default = array(
            'title'         => 'Title',
            'description'   => '',
            'action'       => ''
        );

        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $description = esc_attr($instance['description']);
        $action = esc_attr($instance['action']);

        echo '<p>Title<input type="text" class="widefat" id="'. $this->get_field_id('title') . '" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Description:  <textarea class="widefat" rows="5" cols="10" class="widefat" id="'. $this->get_field_id('description') . '" name="'.$this->get_field_name('description').'">' . $description .'</textarea></p>';
        echo '<p>Action Url<input type="text" class="widefat" name="'.$this->get_field_name('action').'" value="'.$action.'"/></p>';
    }
    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['action'] = strip_tags($new_instance['action']);

        return $instance;
    }

    /**
     * Show widget
     */
    function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $description = empty( $instance['description'] ) ? '' : $instance['description'];
        $action = empty( $instance['action'] ) ? '' : $instance['action'];

        echo $before_widget;

        echo wp_kses_post($before_title. $title .$after_title);
        echo do_shortcode('[inwave_mailchimp style="style2" desc="'.esc_attr($description).'" action="'.esc_url($action).'"]');

        // End show widget
        echo $after_widget;
    }
}
register_widget('Inwave_Widget_Subscribe');