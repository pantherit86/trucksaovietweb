<?php 
$inwave_post_option = Inwave_Helper::getConfig();

if ($inwave_post_option['show-pageheading']) { ?>
    <div class="page-heading">
        <div class="container">
            <div class="page-title">
                <?php
                if (isset($post->ID)) {
                    $terms = get_the_terms($post->ID, 'infunding_category');
                }
                if (is_category()) {
                    // Category
                    echo '<div class="iw-heading-title"><h1>';
                    single_cat_title('');
                    echo '</h1></div>';
                } elseif (is_single()) {
                    // Single post
                    if (has_category('', $post)) {
                        echo '<div  class="iw-heading-title">';
                        $cat = get_the_category();
                        $cat = $cat[0];
                        echo '<h1>' . $cat->name . '</h1>';
                        echo '</div>';
                    } else {
                        echo '<div class="iw-heading-title"><h1>' . $post->post_title . '</h1></div>';
                    }
                } elseif (is_page()) {
                    echo '<div class="iw-heading-title"><h1>';
                    echo the_title();
                    echo '</h1></div>';
                } elseif (is_tag()) {
                    // Tag
                    echo '<div class="iw-heading-title iw-tag"><h1>';
                    single_tag_title();
                    echo '</h1></div>';
                } elseif (is_day()) {
                    // Archive
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Archive for ', 'motohero');
                    the_time('F jS, Y');
                    echo '</h1></div>';
                } elseif (is_month()) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Archive for ', 'motohero');
                    the_time('F, Y');
                    echo '</h1></div>';
                } elseif (is_year()) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Archive for ', 'motohero');
                    the_time('Y');
                    echo '</h1></div>';
                } elseif (is_author()) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Author Archive', 'motohero');
                    echo '</h1></div>';
                } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Blog Archives', 'motohero');
                    echo '</h1></div>';
                } elseif (is_search()) {
                    echo '<div class="iw-heading-title"><h1>';
                    printf(esc_html__('Search Results for: %s', 'motohero'), get_search_query());
                    echo '</h1></div>';
                } elseif (is_404()) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Oops! That page can&rsquo;t be found.', 'motohero');
                    echo '</h1></div>';
                } elseif (function_exists('is_product_category') && is_product_category()) {
                    echo '<div class="iw-heading-title"><h1>';
                    $terms = get_the_terms($post->ID, 'product_cat');
                    $term = $terms[0];
                    echo wp_kses_post($term->name);
                    echo '</h1></div>';
                } elseif (function_exists('is_product_tag') && is_product_tag()) {
                    echo '<div class="iw-heading-title iw-category-2"><h1>';
                    single_tag_title();
                    echo '</h1></div>';
                } elseif (function_exists('is_shop') && is_shop()) {
                    echo '<div class="iw-heading-title"><h1>' . esc_html__('Shop', 'motohero');
                    echo '</h1></div>';
                } elseif (is_array($terms)) {
                    echo '<div class="iw-heading-title"><h1>';
                    $term = $terms[0];
                    echo wp_kses_post($term->name);
                    echo '</h1></div>';
                } else {
                    echo '<div class="iw-heading-title iw-category-2"><h1>';
                    $title = single_post_title('', false);
                    if (!$title) $title = get_bloginfo('name');
                    echo esc_html($title);
                    echo '</h1></div>';
                }
                ?>
            </div>
        </div>
        <?php if ($inwave_post_option['show-breadcrumbs']) { ?>
            <div class="breadcrumbs">
                <div class="container">
                    <?php echo inwave_breadcrumbs(); ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>