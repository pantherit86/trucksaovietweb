<?php
/** Widget Event list **/
class Inwave_Event_List extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'shortcode_widget', 'description' => esc_html__('Show Event list', 'motohero'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('event-list', esc_html__('Inwave Events', 'motohero'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $category = strip_tags($instance['category']);
        $order_by = strip_tags($instance['order_by']);
        $order_dir = strip_tags($instance['order_dir']);
        $limit = strip_tags($instance['limit']);
        echo wp_kses_post($before_widget);
        if ( !empty( $title ) ) { echo wp_kses_post($before_title . $title . $after_title); }
        if(class_exists('iwEventUtility')){
            $utility = new iwEventUtility();
            $query = $utility->getEventList($category, array(), $order_by, $order_dir, $limit);
            if ($query->have_posts()) {
                ?>
                <ul class="widget-event-list">
                    <?php
                    while ($query->have_posts()) : $query->the_post();
                        $event = $utility->getEventInfo(get_the_ID());
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                        ?>
                        <li>
                            <img src="<?php echo $image[0]; ?>" alt="">
                            <div class="event-info">
                                <h3 class="event-title"><a class="theme-color" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="event-time"><i class="fa fa-clock-o"></i><?php echo $event->day['times'][0]['time']; ?></div>
                                <?php if($event->location){ ?>
                                    <div class="event-location"><i class="fa fa-map-marker"></i><?php echo $event->location->name; ?></div>
                                <?php } ?>
                            </div>
                        </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
                <?php
            }
        }
        echo wp_kses_post($after_widget);
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['order_by'] = strip_tags($new_instance['order_by']);
        $instance['order_dir'] = strip_tags($new_instance['order_dir']);
        $instance['limit'] = strip_tags($new_instance['limit']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $title = strip_tags($instance['title']);
        $category_id = esc_attr($instance['category']);
        $order_by = esc_attr($instance['order_by']);
        $order_dir = esc_attr($instance['order_dir']);
        $limit = esc_attr($instance['limit']);

        global $wpdb;
        $categories = $wpdb->get_results('SELECT a.name, a.term_id FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwevent_category\'');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'motohero'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category:', 'motohero'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <option value="0" <?php echo $category_id == '0' ? 'selected' : ''?>><?php echo __('All', 'motohero'); ?></option>
                <?php
                foreach($categories as $category){
                    echo '<option value="'.$category->term_id.'" '.($category->term_id == $category_id ? 'selected' : '').'>'.$category->name.'</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('order_by')); ?>"><?php esc_html_e('Order by:', 'motohero'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_by')); ?>" name="<?php echo esc_attr($this->get_field_name('order_by')); ?>">
                <option value="date" <?php echo $order_by == 'date' ? 'selected' : ''?>><?php echo __('Date', 'motohero'); ?></option>
                <option value="title" <?php echo $order_by == 'title' ? 'selected' : ''?>><?php echo __('Title', 'motohero'); ?></option>
                <option value="ID" <?php echo $order_by == 'ID' ? 'selected' : ''?>><?php echo __('Event ID', 'motohero'); ?></option>
                <option value="menu_order" <?php echo $order_by == 'menu_order' ? 'selected' : ''?>><?php echo __('Name', 'motohero'); ?></option>
                <option value="rand" <?php echo $order_by == 'rand' ? 'selected' : ''?>><?php echo __('Random', 'motohero'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('order_dir')); ?>"><?php esc_html_e('Order Direction:', 'motohero'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('order_dir')); ?>" name="<?php echo esc_attr($this->get_field_name('order_dir')); ?>">
                <option value="desc" <?php echo $order_dir == 'desc' ? 'selected' : ''?> ><?php echo __('Descending', 'motohero'); ?></option>
                <option value="asc" <?php echo $order_dir == 'asc' ? 'selected' : ''?>><?php echo __('Ascending', 'motohero'); ?></option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php esc_html_e('Limit:', 'motohero'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
        </p>
        <?php
    }
}
register_widget('Inwave_Event_List');