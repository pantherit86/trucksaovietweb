<?php
/** Widget contact in footer  */

class Inwave_Widget_Contact extends WP_Widget {

    /**
     * Construct
     */
    function __construct() {
        parent::__construct(
            'inwave-contact',
            esc_html__('Inwave Contact', 'inwavethemes'),
            array( 'description'  =>  esc_html__('Widget display contact information.', 'inwavethemes') )
        );
    }

    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {

        $default = array(
            'title'         => 'Title',
            'description'   => '',
            'email'         => '',
            'phone'         => '',
            'fax'           => '',
            'address'       => ''
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $description = esc_attr($instance['description']);
        $email = esc_attr($instance['email']);
        $phone = esc_attr($instance['phone']);
        $fax = esc_attr($instance['fax']);
        $address = esc_attr($instance['address']);

        echo '<p>'.__('Input Title','inwavethemes').'<input type="text" class="widefat" id="'. $this->get_field_id('title') . '" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>'.__('Description','inwavethemes').':  <textarea class="widefat" rows="5" cols="10" class="widefat" id="'. $this->get_field_id('description') . '" name="'.$this->get_field_name('description').'">' . $description .'</textarea></p>';
        echo '<p>'.__('Email','inwavethemes').' <input type="text" class="widefat" name="'.$this->get_field_name('email').'" value="'.$email.'"/></p>';
        echo '<p>'.__('Phone','inwavethemes').':  <input type="text" class="widefat" name="'.$this->get_field_name('phone').'" value="'.$phone.'"/></p>';
        echo '<p>'.__('Fax','inwavethemes').'<input type="text" class="widefat" name="'.$this->get_field_name('fax').'" value="'.$fax.'"/></p>';
        echo '<p>'.__('Address','inwavethemes').':  <input type="text" class="widefat" name="'.$this->get_field_name('address').'" value="'.$address.'"/></p>';

    }
    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags($new_instance['description']);
        $instance['email'] = strip_tags($new_instance['email']);
        $instance['phone'] = strip_tags($new_instance['phone']);
        $instance['fax'] = strip_tags($new_instance['fax']);
        $instance['address'] = strip_tags($new_instance['address']);
        return $instance;

    }

    /**
     * Show widget
     */

    function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $description = empty( $instance['description'] ) ? '' : $instance['description'];
        $email = empty( $instance['email'] ) ? '' : $instance['email'];
        $phone = empty( $instance['phone'] ) ? '' : $instance['phone'];
        $fax = empty( $instance['fax'] ) ? '' : $instance['fax'];
        $address = empty( $instance['address'] ) ? '' : $instance['address'];

        echo $before_widget;

        echo wp_kses_post($before_title. $title .$after_title);
        echo '<div class="footer-widget-contact">';
        echo '<p>' . $description .'</p>';
        echo '<ul class="information">';
        echo $email?'<li><i class="fa fa-envelope"></i>' . $email .'</li>':'';
        echo $phone?'<li class="phone"><i class="fa fa-phone"></i>'. $phone . '</li>':'';
		echo $fax?'<li class="fax"><i class="fa fa-fax"></i>' . $fax .'</li>':'';
        echo $address?'<li><i class="fa fa-map-marker"></i>' . $address .'</li>':'';
        echo '</ul>';
        echo '</div>';

        // End show widget

        echo $after_widget;
    }
}
register_widget('Inwave_Widget_Contact');