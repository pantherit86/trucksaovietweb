<?php

/*
 * Inwave_Portfolio_Listing for Visual Composer
 */
if (!class_exists('Inwave_Portfolio_Listing')) {

    class Inwave_Portfolio_Listing extends Inwave_Shortcode {

        protected $name = 'iw_portfolio_listing';

        function getIwpCategories() {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.name, a.slug FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwp_category\'');
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '0';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->slug;
            }
            return $newCategories;
        }

        function init_params() {
            return array(
                'name' => 'Portfolio Listing',
                'description' => __('Create a list of portfolios', 'inwavethemes'),
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
                        "heading" => __("Number of portfolio per page", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 12
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Number of column",
                        "param_name" => "number_column",
                        "value" => array(
							"4" => "4",
							"3" => "3",
							"2" => "2",
                            "1" => "1"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Show filter bar",
                        "param_name" => "show_filter_bar",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
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
            extract(shortcode_atts(array(
                "category" => "0",
                "order_by" => "date",
                "order_dir" => "desc",
                "limit" => 12,
                "show_filter_bar" => '1',
                "number_column" => '4',
                "class" => ""
                            ), $atts));

            ob_start();
            echo do_shortcode('[iw_portfolio_list cats="' . $category . '" show_filter_bar="' . $show_filter_bar . '" item_per_page="' . $limit . '" order_by="' . $order_by . '" order_dir="' . $order_dir . '" number_column="'.$number_column.'"]');
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }

    }

}

new Inwave_Portfolio_Listing();