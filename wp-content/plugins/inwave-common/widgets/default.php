<?php
/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */
class Inwave_Recent_Posts_Widget extends WP_Widget_Recent_Posts {
 
	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo wp_kses_post($cache[ $args['widget_id'] ]);
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Recent Posts', 'motohero');

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
		?>
		<?php echo wp_kses_post($args['before_widget']); ?>
		<?php if ( $title ) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		} ?>
		<ul class="recent-blog-posts">
		<?php while ( $r->have_posts() ) : $r->the_post();
            $thumb = get_the_post_thumbnail();
            ?>
			<li class="recent-blog-post <?php echo !$thumb?'no-thumbnail':''?>">
                <?php if($thumb):?>
				<a class="recent-blog-post-thumnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                <?php endif?>
				<div class="recent-blog-post-detail">
					<div class="recent-blog-post-title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></div>
					<?php if ( $show_date ) : ?>
						<div class="post-date"><?php the_date(); ?></div>
					<?php endif; ?>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo wp_kses_post($args['after_widget']); ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
}

class Inwave_Recent_Comments_Widget extends WP_Widget_Recent_Comments
{
    public function widget($args, $instance)
    {
        global $comments, $comment;

        $cache = array();
        if (!$this->is_preview()) {
            $cache = wp_cache_get('widget_recent_comments', 'widget');
        }
        if (!is_array($cache)) {
            $cache = array();
        }

        if (!isset($args['widget_id']))
            $args['widget_id'] = $this->id;

        if (isset($cache[$args['widget_id']])) {
            echo wp_kses_post($cache[$args['widget_id']]);
            return;
        }

        $output = '';

        $title = (!empty($instance['title'])) ? $instance['title'] : esc_html__('Recent Comments','motohero');

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        if (!$number)
            $number = 5;

        /**
         * Filter the arguments for the Recent Comments widget.
         *
         * @since 3.4.0
         *
         * @see WP_Comment_Query::query() for information on accepted arguments.
         *
         * @param array $comment_args An array of arguments used to retrieve the recent comments.
         */
        $comments = get_comments(apply_filters('widget_comments_args', array(
            'number' => $number,
            'status' => 'approve',
            'post_status' => 'publish'
        )));

        $output .= $args['before_widget'];
        if ($title) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $output .= '<ul id="recentcomments">';
        if ($comments) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique(wp_list_pluck($comments, 'comment_post_ID'));
            _prime_post_caches($post_ids, strpos(get_option('permalink_structure'), '%category%'), false);

            foreach ((array)$comments as $comment) {
                $output .= '<li class="recentcomments">';
                /* translators: comments widget: 1: comment author, 2: post link */
                $output .= sprintf(_x('%1$s %2$s', 'widgets','motohero'),
                    '<a class="recentcomment-title" href="' . esc_url(get_comment_link($comment->comment_ID)) . '">' . get_the_title($comment->comment_post_ID) . '</a>',
					'<div class="comment-author-link"><i class="fa fa-comments"></i>' . get_comment_author_link() . '</div>'
                );
                $output .= '</li>';
            }
        }
        $output .= '</ul>';
        $output .= $args['after_widget'];

        echo wp_kses_post($output);

        if (!$this->is_preview()) {
            $cache[$args['widget_id']] = $output;
            wp_cache_set('widget_recent_comments', $cache, 'widget');
        }
    }
}


/** Base on https://wordpress.org/plugins/shortcode-widget/ */
class Inwave_Widget_Shortcodes extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'shortcode_widget', 'description' => esc_html__('Shortcode or Arbitrary Text', 'motohero'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('shortcode-widget', esc_html__('Shortcode Widget', 'motohero'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $text = do_shortcode(apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance ));
        echo wp_kses_post($before_widget);
        if ( !empty( $title ) ) { echo wp_kses_post($before_title . $title . $after_title); } ?>
        <div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
        <?php
        echo wp_kses_post($after_widget);
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
        $instance['filter'] = isset($new_instance['filter']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $title = strip_tags($instance['title']);
        $text = esc_textarea($instance['text']);
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'motohero'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo wp_kses_post($text); ?></textarea>

        <p><input id="<?php echo esc_attr($this->get_field_id('filter')); ?>" name="<?php echo esc_attr($this->get_field_name('filter')); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo esc_attr($this->get_field_id('filter')); ?>"><?php esc_html_e('Automatically add paragraphs', 'motohero'); ?></label></p>
    <?php
    }
}

/** Widget latest post type campaign  */

class Inwave_Post_Latest_Campaign extends WP_Widget {

    function __construct() {
        parent::__construct(
            'latest_post_campaign',
            'Latest Post Campaign',
            array( 'description'  =>  'Widget display latest post campaign.' )
        );
    }

    function form( $instance ) {

        $default = array(
            'title' => 'Title',
            'post_number' => 5,
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);

        echo '<p>Input Title<input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Number display latest post campaign:  <input type="text" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';

    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        return $instance;
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        $post_number = $instance['post_number'];

        echo wp_kses_post($before_widget);
        echo '<div class="footer-post-campaign">';
        echo wp_kses_post($before_title. $title .$after_title);

        $args = array(
            'posts_per_page'	=> $post_number,
            'post_type'		=> 'infunding'
        );


        $the_query = new WP_Query( $args );
        if ($the_query->have_posts() ):
            echo "<ol>";
             while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span>-<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></span>
                </li>
            <?php endwhile;
            echo "</ol>";
        endif;
        wp_reset_postdata();
        echo wp_kses_post($after_widget);
        echo "</div>";
    }
}

/** Widget contact in footer  */

class Inwave_Widget_Contact extends WP_Widget {
    /**
     * Construct
     */
    function __construct() {
        parent::__construct(
            'event_footer_contact',
            'Widget Contact in Footer',
            array( 'description'  =>  'Widget display contact information in footer.' )
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

        echo '<p>Input Title<input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Description:  <textarea class="widefat" rows="5" cols="10" class="widefat" id="'. $this->get_field_id('description') . '" name="'.$this->get_field_name('description').'">' . $description .'</textarea></p>';
        echo '<p>Email <input type="text" class="widefat" name="'.$this->get_field_name('email').'" value="'.$email.'"/></p>';
        echo '<p>Phone:  <input type="text" class="widefat" name="'.$this->get_field_name('phone').'" value="'.$phone.'"/></p>';
        echo '<p>Fax<input type="text" class="widefat" name="'.$this->get_field_name('fax').'" value="'.$fax.'"/></p>';
        echo '<p>Address:  <input type="text" class="widefat" name="'.$this->get_field_name('address').'" value="'.$address.'"/></p>';

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
        echo '<li><i class="fa fa-envelope"></i>' . $email .'</li>';
        echo '<li class="phone"><i class="fa fa-phone"></i><ul><li>'. $phone . '</li><li>' . $fax .'</li></ul></li>';
        echo '<li><i class="fa fa-map-marker"></i>' . $address .'</li>';
        echo '</ul>';
        echo '</div>';

        // End show widget

        echo $after_widget;
    }
}


/** Base on https://wordpress.org/plugins/shortcode-widget/ */
class Inwave_Event_List extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'shortcode_widget', 'description' => esc_html__('Show Event list', 'motohero'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('event-list', esc_html__('Event List', 'motohero'), $widget_ops, $control_ops);
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
                            <h3 class="event-title"><a class="" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
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

unregister_widget('Inwave_Widget_Recent_Posts');
register_widget('Inwave_Recent_Posts_Widget');

unregister_widget('Inwave_Widget_Recent_Posts');
register_widget('Inwave_Recent_Posts_Widget');

register_widget('Inwave_Post_Latest_Campaign');

register_widget('Inwave_Widget_Shortcodes');

register_widget('Inwave_Widget_Contact');

register_widget('Inwave_Event_List');