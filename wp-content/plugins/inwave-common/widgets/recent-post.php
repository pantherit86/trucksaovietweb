<?php
/** Widget recent post */
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

unregister_widget('Widget_Recent_Posts');
register_widget('Inwave_Recent_Posts_Widget');