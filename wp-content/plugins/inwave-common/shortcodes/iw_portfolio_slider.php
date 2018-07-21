<?php

/*
 * Inwave_Portfolio_Slider for Visual Composer
 */
if (!class_exists('Inwave_Portfolio_Slider')) {

    class Inwave_Portfolio_Slider extends Inwave_Shortcode
    {

        protected $name = 'iw_portfolio_slider';

        function getIwpCategories()
        {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.name, a.slug FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwp_category\'');
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '0';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->slug;
            }
            return $newCategories;
        }

        function init_params()
        {
            return array(
                'name' => 'Portfolio Slider',
                'description' => __('Create a slider of portfolios', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Portfolio Category",
                        "param_name" => "category",
                        "value" => $this->getIwpCategories()
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "Date" => "date",
                            "Title" => "title",
                            "Portfolio ID" => "ID",
                            "Name" => "name",
                            "menu_order" => "Ordering",
                            "Random" => "rand"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Order Direction",
                        "param_name" => "order_dir",
                        "value" => array(
                            "Descending" => "desc",
                            "Ascending" => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of portfolio", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 3
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Excerpt length", "inwavethemes"),
                        "param_name" => "excerpt_length",
                        "value" => 40
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Read more text", "inwavethemes"),
                        "param_name" => "read_more_text"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Style", "inwavethemes"),
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Comparision Slider" => "style1",
                            "Style 2 - Columns Slider" => "style2",
                            "Style 3 - Grid list" => "style3"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Number of columns", "inwavethemes"),
                        "param_name" => "columns",
                        "value" => array(
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "group" => "Style",
                        "heading" => "Show categories",
                        "param_name" => "show_categories",
                        "value" => array(
                            "No" => "0",
                            "Yes" => "1"

                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "group" => "Style",
                        "heading" => "Show description",
                        "param_name" => "show_description",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "group" => "Style",
                        "heading" => "Show next-back button",
                        "param_name" => "next_back_button",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),

                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "group" => "Style",
                        "heading" => "Auto play slider",
                        "param_name" => "auto_play",
                        "value" => array(
                            "No" => "0",
                            "Yes" => "1"
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
        function init_shortcode($atts, $content = null)
        {
            $read_more_text = $category = $show_description = $show_categories = $columns = $order_by = $order_dir = $limit = $next_back_button = $excerpt_length = $auto_play = $class = $style = '';
            extract(shortcode_atts(array(
                "category" => "0",
                "order_by" => "date",
                "order_dir" => "desc",
                "limit" => 3,
                "excerpt_length" => 40,
                "read_more_text" => '',
                "next_back_button" => 1,
                "columns" => 1,
                "show_description" => 1,
                "show_categories" => 0,
                "auto_play" => 0,
                "class" => "",
                "style" => "style1"
            ), $atts));


            $query = $this->getListPortfolio($category, $order_dir, $order_by, $limit);
            if ($columns > 1) {
                $column_params = '"items": ' . $columns;
            } else {
                $column_params = '"singleItem":true';
            }

            ob_start();
            switch ($style) {
                case 'style1':
                    ?>
                    <div class="portfolio-slider-<?php echo $style ?>">
                        <div class="owl-carousel"
                             data-plugin-options='{"autoPlay":<?php if ($auto_play) echo 'true'; else echo 'false'; ?>,"autoHeight":false,<?php echo $column_params ?>,"navigation":<?php if ($next_back_button) echo 'true'; else echo 'false'; ?>,"pagination": false,"touchDrag": false,"mouseDrag":false}'>
                            <?php
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();
                                $image_gallery_data = get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true);
                                $image_gallery = unserialize($image_gallery_data);
                                $description = wp_trim_words($post->post_content, $excerpt_length);
                                $terms = wp_get_post_terms(get_the_ID(), 'iwp_category');
                                $cats = array();
                                if (!empty($terms)) {
                                    foreach ($terms as $cat):
                                        $term_link = get_term_link($cat);
                                        $cats[] = '<a href="' . esc_url($term_link) . '">' . $cat->name . '</a>';
                                    endforeach;
                                }
                                $cats = implode(' / ', $cats);
                                ?>
                                <div class="portfolio-item">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h3 class="portfolio-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
                                            </h3>
                                            <?php if ($show_description) { ?>
                                                <p>
                                                    <?php echo $description; ?>
                                                </p>
                                            <?php } ?>
                                            <?php
                                            if ($show_categories) {
                                                echo '<div class="categories">' . $cats . '</div>';
                                            }
                                            if ($read_more_text) {
                                                echo do_shortcode('[inwave_button style="button3" button_text="' . $read_more_text . '" button_link="' . get_the_permalink() . '"]');
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="portfolio-galleries">
                                                <?php
                                                if (!empty($image_gallery)):
                                                    if (count($image_gallery) == 2) {
                                                        echo do_shortcode('[inwave_comparision_slider before="' . $image_gallery[0] . '" after="' . $image_gallery[1] . '"]');
                                                    } else {
                                                        ?>
                                                        <?php
                                                        for ($i = 0; $i < count($image_gallery); $i++):
                                                            $img = wp_get_attachment_image_src($image_gallery[$i], 'iw_portfolio-large');
                                                            ?>
                                                            <img alt="" src="<?php echo $img[0]; ?>">
                                                            <?php
                                                            break;
                                                        endfor; ?>
                                                    <?php } ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endwhile; ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'style2':
                    $navigationText = '"navigationText":["' . __('Prev', 'inwavethemes') . '","' . __('Next', 'inwavethemes') . '"]';

                    ?>
                    <div class="portfolio-slider-<?php echo $style ?>">
                        <div class="owl-carousel"
                             data-plugin-options='{"autoPlay":<?php if ($auto_play) echo 'true'; else echo 'false'; ?>,"autoHeight":false,<?php echo $column_params ?>,"navigation":<?php if ($next_back_button) echo 'true'; else echo 'false'; ?>,"pagination": false,<?php echo $navigationText; ?>}'>
                            <?php
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();
                                $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_portfolio-large');
                                if (!$post_thumb) {
                                    $images = unserialize(get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true));
                                    $post_thumb = wp_get_attachment_image_src($images[0], 'iw_portfolio-thumb');
                                }
                                if (!$post_thumb) {
                                    continue;
                                }
                                $description = wp_trim_words($post->post_content, $excerpt_length);

                                $terms = wp_get_post_terms(get_the_ID(), 'iwp_category');
                                $cats = array();
                                if (!empty($terms)) {
                                    foreach ($terms as $cat):
                                        $term_link = get_term_link($cat);
                                        $cats[] = '<a href="' . esc_url($term_link) . '">' . $cat->name . '</a>';
                                    endforeach;
                                }
                                $cats = implode(' / ', $cats);
                                ?>
                                <div class="portfolio-item">
                                    <img alt="" src="<?php echo $post_thumb[0]; ?>">
                                    <div class="portfolio-content">
										<div class="portfolio-content-inner">
                                        <?php
                                        echo do_shortcode('[inwave_button style="button3" button_text="' . esc_attr(get_the_title()) . '" button_link="' . get_the_permalink() . '"]');
                                        ?>
                                        <?php if ($show_description) { ?>
                                            <p>
                                                <?php echo $description; ?>
                                            </p>
                                        <?php } ?>
                                        <?php
                                        if ($show_categories) {
                                            echo '<div class="categories">' . $cats . '</div>';
                                        }
                                        if ($read_more_text) {
                                            echo '<a class="read-more" href="' . get_the_permalink() . '">' . $read_more_text . '</a>';
                                        }
                                        ?>
										</div>
                                    </div>
                                </div>
                                <?php
                            endwhile; ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'style3':
                    ?>
                    <div class="portfolio-slider-style2 portfolio-slider-<?php echo $style ?>">
                            <?php
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();
                                $post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'iw_portfolio-large');
                                if (!$post_thumb) {
                                    $images = unserialize(get_post_meta(get_the_ID(), 'iw_portfolio_image_gallery', true));
                                    $post_thumb = wp_get_attachment_image_src($images[0], 'iw_portfolio-thumb');
                                }
                                if (!$post_thumb) {
                                    continue;
                                }
                                $description = wp_trim_words($post->post_content, $excerpt_length);

                                $terms = wp_get_post_terms(get_the_ID(), 'iwp_category');
                                $cats = array();
                                if (!empty($terms)) {
                                    foreach ($terms as $cat):
                                        $term_link = get_term_link($cat);
                                        $cats[] = '<a href="' . esc_url($term_link) . '">' . $cat->name . '</a>';
                                    endforeach;
                                }
                                $cats = implode(' / ', $cats);
                                ?>
                                <div class="portfolio-item col-md-<?php echo $columns >= 3 ? '4' : (12 / $columns); ?>">
                                    <img alt="" src="<?php echo $post_thumb[0]; ?>">
                                    <div class="portfolio-content">
                                        <div class="portfolio-content-inner">
                                        <?php
                                        echo do_shortcode('[inwave_button style="button3" button_text="' . esc_attr(get_the_title()) . '" button_link="' . get_the_permalink() . '"]');
                                        ?>
                                        <?php if ($show_description) { ?>
                                            <p>
                                                <?php echo $description; ?>
                                            </p>
                                        <?php } ?>
                                        <?php
                                        if ($show_categories) {
                                            echo '<div class="categories">' . $cats . '</div>';
                                        }
                                        if ($read_more_text) {
                                            echo '<a class="read-more" href="' . get_the_permalink() . '">' . $read_more_text . '</a>';
                                        }
                                        ?>
                                    </div>
                                    </div>
                                </div>
                                <?php
                            endwhile; ?>
                        </div>
                    <div class="clear"></div>
                    <?php
                    break;
            }
            wp_reset_postdata();
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

        function getListPortfolio($cats, $order_dir, $order_by, $limit)
        {
            $cat_array = explode(',', $cats);
            $new_cats = array();
            if (in_array('0', $cat_array)) {
                global $wpdb;
                $res = $wpdb->get_results("SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy='iwp_category'");
                foreach ($res as $value) {
                    $new_cats[] = $value->term_id;
                }
            } else {
                $new_cats = $cat_array;
            }
            $args = array(
                'post_type' => 'iw_portfolio',
                'order' => $order_dir,
                'orderby' => $order_by,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'iwp_category',
                        'terms' => $new_cats,
                        'include_children' => false
                    ),
                ),
                'posts_per_page' => $limit,
                'paged' => 1
            );
            return new WP_Query($args);
        }

    }

}

new Inwave_Portfolio_Slider();