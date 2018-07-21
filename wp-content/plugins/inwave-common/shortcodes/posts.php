<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 27, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of wp_posts
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Posts')) {

    class Inwave_Posts extends Inwave_Shortcode
    {

        protected $name = 'inwave_posts';

        function init_params()
        {
            $_categories = get_categories();
            $cats = array(__("All", "inwavethemes") => '');
            foreach ($_categories as $cat) {
                $cats[$cat->name] = $cat->term_id;
            }

            return array(
                'name' => __('Posts', 'inwavethemes'),
                'description' => __('Display a list of posts ', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Style", "inwavethemes"),
                        "param_name" => "style",
                        "value" => array(
                            'Style 1 - Flat' => 'style1',
                            'Style 2 - Slider' => 'style2',
                            'Style 3 - Flat Slider' => 'style3'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Post Ids", "inwavethemes"),
                        "value" => "",
                        "param_name" => "post_ids",
                        "description" => __('Id of posts you want to get. Separated by commas.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Post Category", "inwavethemes"),
                        "param_name" => "category",
                        "value" => $cats,
                        "description" => __('Category to get posts.', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Post number", "inwavethemes"),
                        "param_name" => "post_number",
                        "value" => "3",
                        "description" => __('Number of posts to display.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Column", "inwavethemes"),
                        "param_name" => "column",
                        "value" => array(
                            '4' => '4',
                            '3' => '3',
                            '2' => '2',
                            '1' => '1'
                        ),
                        "description" => __('Number of Columns to display(Slider style only).', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Excerpt length", "inwavethemes"),
                        "param_name" => "excerpt_length",
                        "value" => 40
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order By", "inwavethemes"),
                        "param_name" => "order_by",
                        "value" => array(
                            'ID' => 'ID',
                            'Title' => 'title',
                            'Date' => 'date',
                            'Modified' => 'modified',
                            'Ordering' => 'menu_order',
                            'Random' => 'rand'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order Type", "inwavethemes"),
                        "param_name" => "order_type",
                        "value" => array(
                            'ASC' => 'ASC',
                            'DESC' => 'DESC'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show date", "inwavethemes"),
                        "param_name" => "show_date",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show category", "inwavethemes"),
                        "param_name" => "show_category",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show Author", "inwavethemes"),
                        "param_name" => "show_author",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show post type icon", "inwavethemes"),
                        "param_name" => "show_post_type",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show comment count", "inwavethemes"),
                        "param_name" => "show_comment_count",
                        "value" => array(
                            'No' => '0',
                            'Yes' => '1'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show tag", "inwavethemes"),
                        "param_name" => "show_tag",
                        "value" => array(
                            'No' => '0',
                            'Yes' => '1'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Include Sticky Posts", "inwavethemes"),
                        "param_name" => "include_sticky_posts",
                        "value" => array(
                            'No' => '0',
                            'Yes' => '1'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show read-more", "inwavethemes"),
                        "param_name" => "show_readmore",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Read More Text", "inwavethemes"),
                        "value" => "",
                        "param_name" => "read_more_text",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes($this->name, $atts) : $atts;
            $output = $title = $post_ids = $category = $items_desktop = $items_desktopsmall = $items_tablet = $items_mobile = $description_limit = $post_number = $order_by = $order_type = $style = $show_date = $show_category = $show_author = $show_thumbnail = $show_desc = $show_comment_count = $show_tag = $show_readmore = $show_post_type = $read_more_text = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'post_ids' => '',
                'category' => '',
                'post_number' => 3,
                'column' => 4,
                'excerpt_length' => 40,
                'include_sticky_posts' => '0',
                'order_by' => 'ID',
                'order_type' => 'DESC',
                'style' => 'style1',
                'show_date' => '1',
                'show_category' => '1',
                'show_author' => '1',
                'show_desc' => '1',
                'show_comment_count' => '1',
                'show_tag' => '1',
                'show_readmore' => '1',
                'show_post_type' => '1',
                'read_more_text' => 'more',
                'class' => ''
            ), $atts));

            $args = array();
            if ($post_ids) {
                $args['post__in'] = explode(',', $post_ids);
            } else {
                if ($category) {
                    $args['category__in'] = $category;
                }
            };
            if (!$include_sticky_posts) {
                $args['ignore_sticky_posts'] = true;
            }
            $args['posts_per_page'] = $post_number;
            $args['order'] = $order_type;
            $args['orderby'] = $order_by;
            $query = new WP_Query($args);
            $class .= ' ' . $style;
            ob_start();
            switch ($style) {
                case 'style1':
                    ?>
                    <div class="iw-posts <?php echo $class ?>">
                        <div class="iw-posts-list">
                            <?php
                            $i = 0;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $i++;
                                $post_format = get_post_format();
                                $icon_post_type = inwave_get_post_format_icon($post_format);

                                ?>
                                <div
                                    class="iw-post-item col-md-<?php echo $post_number >= 3 ? '4' : (12 / $post_number); ?>">
                                    <div class="post-item-inner">
                                        <div class="post-thumbnail featured-image">
                                            <?php if ($show_post_type): ?>
                                                <div
                                                    class="post-type theme-color"><?php echo $icon_post_type; ?></i></div>
                                            <?php endif; ?>
                                            <?php
                                            $post = get_post();
                                            $contents = $post->post_content;
                                            $description = wp_trim_words(get_the_excerpt(), $excerpt_length);
                                            switch ($post_format) {
                                                case 'video':
                                                    $video = inwave_getElementsByTag('embed', $contents);
                                                    if (count($video)) {
                                                        //$video_url = $video[2];
                                                        echo '<div class="fit-video">' . apply_filters('the_content', $video[0]) . '</div>';
                                                    } else {
                                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                                                        ?>
                                                        <img src="<?php echo $img[0]; ?>" alt="">
                                                        <?php
                                                    }
                                                    break;
                                                default :
                                                    $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                                                    ?>
                                                    <img src="<?php echo $img[0]; ?>" alt="">
                                                    <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="post-content <?php echo $post_format == 'video' ? 'video' : '' ?>">
                                            <?php if ($show_date): ?>
                                                <div class="post-date"><span
                                                        class="date"><?php printf(__('%s'), get_the_date('F j, Y')) ?></span><span
                                                        class="theme-bg iw-av-overlay"></span></div>
                                            <?php endif; ?>
                                            <?php if ($show_category || $show_author || $show_comment_count || $show_tag) { ?>
                                                <div class="post-meta">
                                                    <ul>
                                                        <?php if ($show_author): ?>
                                                            <li>
                                                                <div
                                                                    class="author"><?php echo esc_html__('Post by: ', 'motohero'); ?>
                                                                    <span
                                                                        class="theme-color"><?php echo get_the_author_link(); ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if ($show_category) { ?>
                                                            <li>
                                                                <div
                                                                    class="category"><?php echo esc_html__('Post in: ', 'motohero'); ?>
                                                                    <span><?php the_category('/ '); ?></span></div>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($show_comment_count) { ?>
                                                            <li>
                                                                <span><a
                                                                        href="<?php comments_link(); ?>"><?php comments_number(__('0 Comments', 'inwavethemes'), __('1 Comment', 'inwavethemes'), __('% Comments', 'inwavethemes')); ?></a></span>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if ($show_tag) { ?>
                                                            <li>
                                                                <span><span><?php echo esc_html__('Tags:', 'motohero'); ?></span><?php echo get_the_tag_list(); ?></span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                            <div class="post-title">
                                                <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
                                            </div>
                                            <div class="post-description">
                                                <p><?php echo $description ?></p>
                                            </div>
                                            <?php if ($show_readmore) { ?>
                                                <a class="read-more theme-color"
                                                   href="<?php echo get_permalink(); ?>"><?php echo $read_more_text ? $read_more_text : __('Read more', 'inwavethemes'); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'style2':
                    if ($column > 1) {
                        $columns = '"items": ' . $column;
                    } else {
                        $columns = '"singleItem":true';
                    }
                    ?>
                    <div class="iw-posts <?php echo $class ?>">
                        <div class="iw-posts-list owl-carousel"
                             data-plugin-options='{"autoHeight":false,<?php echo $columns ?>,"navigation":false,"pagination": true,"itemsDesktop": [1199,<?php echo $column-1 ?>],"itemsDesktopSmall": [979,<?php echo $column-1 ?>]}'>
                            <?php
                            $i = 0;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $i++;
                                $post_format = get_post_format();
                                $icon_post_type = inwave_get_post_format_icon($post_format);
                                $post = get_post();
                                $description = wp_trim_words(get_the_excerpt(), $excerpt_length);
                                ?>
                                <div
                                    class="iw-post-item">
                                    <div class="post-item-inner">
                                        <div class="post-content <?php echo $post_format == 'video' ? 'video' : '' ?>">
                                            <div class="post-content-details">
                                            <?php if ($show_date): ?>
                                                <div class="post-date beveled-background"><span
                                                        class="date"><?php printf(__('%s'), get_the_date('F j, Y')) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="post-title">
                                                <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
                                            </div>
                                            <div class="post-description">
                                                <p><?php echo $description; ?></p>
                                            </div>

                                            </div>
                                            <?php if ($show_readmore) { ?>
                                                <a class="read-more theme-bg"
                                                   href="<?php echo get_permalink(); ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                </a>
                                            <?php } ?>
                                            <div class="post-thumbnail featured-image">
                                                <?php if ($show_post_type): ?>
                                                    <div
                                                        class="post-type theme-color"><?php echo $icon_post_type; ?></i></div>
                                                <?php endif; ?>
                                                <?php

                                                switch ($post_format) {

                                                    default :
                                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');
                                                        ?>
                                                        <img src="<?php echo $img[0]; ?>" alt="">
                                                        <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php if ($show_category || $show_author || $show_comment_count || $show_tag) { ?>
                                            <div class="post-meta">
                                                <ul>
                                                    <?php if ($show_author): ?>
                                                        <li>
                                                            <div
                                                                class="author">
                                                                <?php echo get_avatar(get_the_author_meta('ID'), 36); ?>
                                                                <span
                                                                    class="theme-color"><?php echo get_the_author_link(); ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if ($show_category) { ?>
                                                        <li>
                                                            <div
                                                                class="category"><?php echo esc_html__('Post in: ', 'motohero'); ?>
                                                                <span><?php the_category('/ '); ?></span></div>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($show_comment_count) { ?>
                                                        <li>
                                                                <span><a
                                                                        href="<?php comments_link(); ?>"><?php comments_number(__('0 Comments', 'inwavethemes'), __('1 Comment', 'inwavethemes'), __('% Comments', 'inwavethemes')); ?></a></span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($show_tag) { ?>
                                                        <li>
                                                            <span><span><?php echo esc_html__('Tags:', 'motohero'); ?></span><?php echo get_the_tag_list(); ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
                    case 'style3':
                    if ($column > 1) {
                        $columns = '"items": ' . $column;
                    } else {
                        $columns = '"singleItem":true';
                    }
                    ?>
                    <div class="iw-posts <?php echo $class ?>">
                    <!-- <div class="iw-posts style2"> -->
                        <div class="iw-posts-list owl-carousel"
                             data-plugin-options='{"autoHeight":false,<?php echo $columns ?>,"navigation":false,"pagination": true,"itemsDesktop": [1199,<?php echo $column-1 ?>],"itemsDesktopSmall": [979,<?php echo $column-1 ?>]}'>
                            <?php
                            $i = 0;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $i++;
                                $post_format = get_post_format();
                                $icon_post_type = inwave_get_post_format_icon($post_format);
                                $post = get_post();
                                $description = wp_trim_words(get_the_excerpt(), $excerpt_length);
                                ?>
                                <div
                                    class="iw-post-item">
                                    <div class="post-item-inner">
                                        <div class="post-img">
                                        <a href="<?php echo get_permalink(); ?>">
                                        <?php
                                        switch ($post_format) {
                                            default :
                                                $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                                ?>
                                                <img src="<?php echo $img[0]; ?>" alt="">
                                                <?php
                                        }
                                        ?>
                                        </a>
                                        <div class="control-overlay"></div>
                                        </div>
                                       
                                        <div class="post-content <?php echo $post_format == 'video' ? 'video' : '' ?>">
                                        <div class="info-post">
                                        <div class="post-categories">
                                            <?php if ($show_category) { ?>
                                                    <div class="category">
                                                        <?php echo esc_html__('', 'motohero'); ?>
                                                            <span><?php the_category('/ '); ?></span></div>
                                                        <?php } ?>
                                            </div>
                                            <?php if ($show_date): ?>
                                                <div class="post-date"><span
                                                        class="date"><?php printf(__('%s'), get_the_date('F j, Y')) ?></span>
                                                </div>
                                            <?php endif; ?>
                                            </div>
                                            <div class="post-content-details">
                                            <div class="post-title">
                                             <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
                                            </div>
                                            <div class="post-description">
                                                <p><?php echo $description; ?></p>
                                            </div>
                                                <div class="box-read-more">
                                                <a href="<?php echo get_permalink(); ?>">Đọc Thêm >></a>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <?php if ($show_category || $show_author || $show_comment_count || $show_tag) { ?>
                                            <div class="post-meta">
                                                <ul>
                                                    <?php if ($show_author): ?>
                                                        <li>
                                                            <div
                                                                class="author">
                                                                <?php echo get_avatar(get_the_author_meta('ID'), 36); ?>
                                                                <span
                                                                    class="theme-color"><?php echo get_the_author_link(); ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>
                                                   
                                                    <?php if ($show_comment_count) { ?>
                                                        <li>
                                                                <span><a
                                                                        href="<?php comments_link(); ?>"><?php comments_number(__('0 Comments', 'inwavethemes'), __('1 Comment', 'inwavethemes'), __('% Comments', 'inwavethemes')); ?></a></span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($show_tag) { ?>
                                                        <li>
                                                            <span><span><?php echo esc_html__('Tags:', 'motohero'); ?></span><?php echo get_the_tag_list(); ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
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

new Inwave_Posts();