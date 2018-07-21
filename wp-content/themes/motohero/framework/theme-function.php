<?php
/**
 * Theme function file.
 */

/**
 * Add class to nav menu
 */

if (!is_admin()) {
    function inwave_nav_class($classes, $item)
    {
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'selected active ';
        }
        return $classes;
    }

    add_filter('nav_menu_css_class', 'inwave_nav_class', 10, 2);
}

/* add body class: support white color and boxed layout */
if(!function_exists('inwave_add_body_class')){
    function inwave_add_body_class($classes){
        global $inwave_post_option,$inwave_theme_option;

        if($inwave_post_option['page-classes']){
            $classes[] = $inwave_post_option['page-classes'];
        }
        if($inwave_post_option['panel-settings']->layout=='boxed'){
            $classes[] = 'body-boxed';
        }
        if($inwave_post_option['theme_style'] == 'light'){
            $classes[] = 'index-light';
        }

        $classes[] = 'st-effect-3';

        return $classes;
    }
    add_filter( 'body_class', 'inwave_add_body_class');
}

/* override menu walk*/
function inwave_widget_nav_menu_walker( $nav_menu_args, $nav_menu, $args) {
    $nav_menu_args["walker"] = new Inwave_Nav_Walker();
    return $nav_menu_args;
}
add_filter( 'widget_nav_menu_args', 'inwave_widget_nav_menu_walker', 10, 3 );


if (!function_exists('inwave_comment')) {
    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own inwave_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.

     */
    function inwave_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments.
                ?>
                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <p><?php esc_html_e('Pingback:', 'motohero'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('(Edit)', 'motohero'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
            default :
                // Proceed with normal comments.
                global $post;
                ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment answer">
                    <div class="commentAvt commentLeft">
                        <?php echo get_avatar(get_comment_author_email() ? get_comment_author_email() : $comment, 91); ?>
                    </div>
                    <!-- .comment-meta -->

                    

                    <div class="commentRight">
                        <div class="content-cmt">


                            <div class="commentRight-info">
                                <span class="name-cmt"><?php echo get_comment_author_link() ?></span>
							<span
                                class="date-cmt"> <?php printf(esc_html__('%s - %s', 'motohero'),get_comment_time(), get_comment_date()) ?>. </span>
                            <span
                                class="comment_reply"><?php comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'motohero'), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
                            </div>
                            <div class="content-reply">
                                <?php comment_text(); ?>
								<?php if ('0' == $comment->comment_approved) : ?>
									<p class="comment-awaiting-moderation theme-color"><?php esc_html_e('Your comment is awaiting moderation.', 'motohero'); ?></p>
								<?php endif; ?>
                            </div>
                        </div>

                        <?php edit_comment_link(esc_html__('Edit', 'motohero'), '<p class="edit-link">', '</p>'); ?>
                    </div>
					
                    <!-- .comment-content -->
                    <div class="clear"></div>
                </div>
                <!-- #comment-## -->
                <?php
                break;
        endswitch; // end comment_type check
    }

}

if (!function_exists('inwave_getElementsByTag')) {

    /**
     * Function to get element by tag
     * @param string $tag tag name. Eg: embed, iframe...
     * @param string $content content to find
     * @param int $type type of tag. <br/> 1. [tag_name settings]content[/tag_name]. <br/>2. [tag_name settings]. <br/>3. HTML tags.
     * @return type
     */
    function inwave_getElementsByTag($tag, $content, $type = 1)
    {
        if ($type == 1) {
            $pattern = "/\[$tag(.*)\](.*)\[\/$tag\]/Uis";
        } elseif ($type == 2) {
            $pattern = "/\[$tag(.*)\]/Uis";
        } elseif ($type == 3) {
            $pattern = "/\<$tag(.*)\>(.*)\<\/$tag\>/Uis";
        } else {
            $pattern = null;
        }
        $find = null;
        if ($pattern) {
            preg_match($pattern, $content, $matches);
            if ($matches) {
                $find = $matches;
            }
        }
        return $find;
    }
}


if (!function_exists('inwave_social_sharing')) {
    /**
     *
     * @global type $inwave_theme_option
     * @param String $link Link to share
     * @param String $text the text content to share
     * @param String $title the title to share
     * @param String $tag the wrap html tag
     */
    function inwave_social_sharing($link, $text, $title, $tag = '', $return = false)
    {
        global $inwave_theme_option;
        $newWindow = 'onclick="return iwOpenWindow(this.href);"';
        $title = urlencode($title);
        $text = urlencode($text);
        $link = urlencode($link);
        $html = '';
        if ($inwave_theme_option['sharing_facebook']) {
            $shareLink = 'https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link . '&amp;p[summary]=' . $text .'&amp;u='. $link;;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-fb" target="_blank" href="#" title="' . esc_attr_x('Share on Facebook','title','motohero') . '" onclick="return iwOpenWindow(\'' . esc_js($shareLink) . '\')"><i class="fa fa-facebook"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_twitter']) {
            $shareLink = 'https://twitter.com/share?url=' . $link . '&amp;text=' . $text;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-tt" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Twitter','title','motohero') . '" ' . $newWindow . '><i class="fa fa-twitter"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_linkedin']) {
            $shareLink = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . $link . '&amp;title=' . $title . '&amp;summary=' . $text;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-linkedin" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Linkedin','title','motohero') . '" ' . $newWindow . '><i class="fa fa-linkedin"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_google']) {
            $shareLink = 'https://plus.google.com/share?url=' . $link . '&amp;title=' . $title;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-gg" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Google Plus','title','motohero') . '" ' . $newWindow . '><i class="fa fa-google-plus"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_tumblr']) {
            $shareLink = 'http://www.tumblr.com/share/link?url=' . $link . '&amp;description=' . $text . '&amp;name=' . $title;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-tumblr" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Share on Tumblr','title','motohero') . '" ' . $newWindow . '><i class="fa fa-tumblr-square"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_pinterest']) {
            $shareLink = 'http://pinterest.com/pin/create/button/?url=' . $link . '&amp;description=' . $text . '&amp;media=' . $link;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-pinterest" target="_blank" href="' . esc_url($shareLink) . '" title="' . esc_attr_x('Pinterest','title', 'motohero') . '" ' . $newWindow . '><i class="fa fa-pinterest"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }
        if ($inwave_theme_option['sharing_email']) {
            $shareLink = 'mailto:?subject=' . esc_attr_x('I wanted you to see this site','title', 'motohero') . '&amp;body=' . $link . '&amp;title=' . $title;
            $html .= ($tag ? '<' . $tag . '>' : '') . '<a class="share-buttons-email" href="' . urlencode(esc_attr($shareLink)) . '" title="' . esc_attr_x('Email','title', 'motohero') . '"><i class="fa fa-envelope"></i></a>' . ($tag ? '</' . $tag . '>' : '');
        }

        if($return){
            return $html;
        }
        else
        {
            echo wp_kses_post($html);
        }
    }
}

if (!function_exists('inwave_get_class')) {
    function inwave_get_classes($type,$sidebar)
    {
        $classes = '';
        switch ($type) {
            case 'container':
                $classes = 'col-sm-12 col-xs-12';
                if ($sidebar == 'left' || $sidebar == 'right') {
                    $classes .= ' col-lg-9 col-md-8';
                    if ($sidebar == 'left') {
                        $classes .= ' pull-right';
                    }
                }
                break;
            case 'sidebar':
                $classes = 'col-sm-12 col-xs-12';
                if ($sidebar == 'left' || $sidebar == 'right') {
                    $classes .= ' col-lg-3 col-md-4';
                }
                if ($sidebar == 'bottom') {
                    $classes .= ' pull-' . $sidebar;
                }
                break;
        }
        return $classes;
    }
}

if (!function_exists('inwave_allow_tags')) {

    function inwave_allow_tags($tag = null)
    {
        $inwave_tag_allowed = wp_kses_allowed_html('post');

        $inwave_tag_allowed['input'] = array(
            'class' => array(),
            'id' => array(),
            'name' => array(),
            'value' => array(),
            'checked' => array(),
            'type' => array()
        );
        $inwave_tag_allowed['select'] = array(
            'class' => array(),
            'id' => array(),
            'name' => array(),
            'value' => array(),
            'multiple' => array(),
            'type' => array()
        );
        $inwave_tag_allowed['option'] = array(
            'value' => array(),
            'selected' => array()
        );

        if($tag == null){
            return $inwave_tag_allowed;
        }
        elseif(is_array($tag)){
            $new_tag_allow = array();
            foreach ($tag as $_tag){
                $new_tag_allow[$_tag] = $inwave_tag_allowed[$_tag];
            }

            return $new_tag_allow;
        }
        else{
            return isset($inwave_tag_allowed[$tag]) ? array($tag=>$inwave_tag_allowed[$tag]) : array();
        }
    }
}


if (!function_exists('inwave_get_post_views')) {

    function inwave_get_post_views($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count;
    }
}

if (!function_exists('inwave_social_sharing_fb')) {
    /**
     *
     * @global type $inwave_theme_option
     * @param String $link Link to share
     * @param String $text the text content to share
     * @param String $title the title to share
     * @param String $tag the wrap html tag
     */
    function inwave_social_sharing_fb($link, $text, $title)
    {
        $newWindow = 'onclick="return iwOpenWindow(this.href);"';
        $title = urlencode($title);
        $text = urlencode($text);
        $link = urlencode($link);
        $shareLink = 'https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . $title . '&amp;p[url]=' . $link . '&amp;p[summary]=' . $text;
        echo '<a class="share-buttons-fb" target="_blank" href="#" title="' . esc_attr_x('Share on Facebook','title', 'motohero') . '" onclick="return iwOpenWindow(\'' . esc_js($shareLink) . '\')"><i class="fa fa-share"></i><span>share</span></a>';
    }
}


/**
 * Count widgets function
 * https://gist.github.com/slobodan/6156076
 */
if(!function_exists('inwave_count_widgets')){
    function inwave_count_widgets($sidebar_id)
    {
        // If loading from front page, consult $_wp_sidebars_widgets rather than options
        // to see if wp_convert_widget_settings() has made manipulations in memory.
        global $_wp_sidebars_widgets;
        if (empty($_wp_sidebars_widgets)) :
            $_wp_sidebars_widgets = get_option('sidebars_widgets', array());
        endif;
        $sidebars_widgets_count = $_wp_sidebars_widgets;
        if (isset($sidebars_widgets_count[$sidebar_id])) :
            $widget_count = count($sidebars_widgets_count[$sidebar_id]);
            $widget_classes = 'widget-count-' . count($sidebars_widgets_count[$sidebar_id]);
            if ($widget_count >= 3) :
                // Four widgets er row if there are exactly four or more than 3
                $widget_classes .= ' col-md-4 col-sm-4';
            elseif ($widget_count == 2) :
                // Three widgets per row if there's three or more widgets
                $widget_classes .= ' col-md-6 col-sm-6';
            elseif ($widget_count == 1) :
                // Otherwise show two widgets per row
                $widget_classes .= ' col-md-12 col-sm-12';
            endif;
            $widget_classes .= ' col-xs-12';
            return $widget_classes;
        endif;
    }

    function inwave_breadcrumbs(){
        /* === OPTIONS === */
        $text['home']     = esc_html__('Home', 'motohero'); // text for the 'Home' link
        $text['category'] = esc_html__('Archive by Category "%s"', 'motohero'); // text for a category page
        $text['tax'] 	  = esc_html__('Archive for "%s"', 'motohero'); // text for a taxonomy page
        $text['search']   = esc_html__('Search Results for "%s" Query', 'motohero'); // text for a search results page
        $text['tag']      = esc_html__('Posts Tagged "%s"', 'motohero'); // text for a tag page
        $text['author']   = esc_html__('Articles Posted by %s', 'motohero'); // text for an author page
        $text['404']      = esc_html__('Error 404', 'motohero'); // text for the 404 page

        $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
        $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
        $delimiter   = ''; // delimiter between crumbs
        $before      = '<li class="current">'; // tag before the current crumb
        $after       = '</li>'; // tag after the current crumb
        /* === END OF OPTIONS === */

        global $post;
        $homeLink = esc_url(home_url('/'));
        $linkBefore = '<li>';
        $linkAfter = '</li>';
        $linkAttr = '';
        $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

        if ( is_front_page()) {

            if ($showOnHome == 1) echo '<ul><li><a href="' . $homeLink . '">' . $text['home'] . '</a></li></ul>';

        } else {

            echo '<ul><li><i class="fa fa-home"></i><a href="' . $homeLink . '">' . $text['home'] . '</a></li>' . $delimiter;

            if(is_home()){
                echo wp_kses_post($before . get_the_title( get_option('page_for_posts', true) ) . $after);
            }elseif ( is_category() ) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo wp_kses_post($cats);
                }
                echo wp_kses_post($before . sprintf($text['category'], single_cat_title('', false)) . $after);

            } elseif( is_tax() ){
                $thisCat = get_category(get_query_var('cat'), false);
                if (isset($thisCat->parent) && $thisCat->parent != 0) {
                    $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo wp_kses_post($cats);
                }
                echo wp_kses_post($before . sprintf($text['tax'], single_cat_title('', false)) . $after);

            }elseif ( is_search() ) {
                echo wp_kses_post($before . sprintf($text['search'], get_search_query()) . $after);

            } elseif ( is_day() ) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
                echo wp_kses_post($before . get_the_time('d') . $after);

            } elseif ( is_month() ) {
                echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                echo wp_kses_post($before . get_the_time('F') . $after);

            } elseif ( is_year() ) {
                echo wp_kses_post($before . get_the_time('Y') . $after);

            } elseif ( is_single() && !is_attachment() ) {
                if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                    if ($showCurrent == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);
                } else {
                    $cat = get_the_category(); $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                    $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                    $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                    echo wp_kses_post($cats);
                    if ($showCurrent == 1) echo wp_kses_post($before . get_the_title() . $after);
                }

            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object(get_post_type());
                echo wp_kses_post($before . $post_type->labels->singular_name . $after);

            } elseif ( is_attachment() ) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                echo wp_kses_post($cats);
                printf($link, get_permalink($parent), $parent->post_title);
                if ($showCurrent == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

            } elseif ( is_page() && !$post->post_parent ) {
                if ($showCurrent == 1) echo wp_kses_post($before . get_the_title() . $after);

            } elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo wp_kses_post($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs)-1) echo wp_kses_post($delimiter);
                }
                if ($showCurrent == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

            } elseif ( is_tag() ) {
                echo wp_kses_post($before . sprintf($text['tag'], single_tag_title('', false)) . $after);

            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata($author);
                echo wp_kses_post($before . sprintf($text['author'], $userdata->display_name) . $after);

            } elseif ( is_404() ) {
                echo wp_kses_post($before . $text['404'] . $after);
            }

            if ( get_query_var('paged') ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                echo esc_html(__('Page', 'motohero')) . ' ' . get_query_var('paged');
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
            }

            echo '</ul>';

        }
    }
}
function inwave_get_post_format_icon($post_format){
    $icon = '';
    switch ($post_format) {
        case 'link':
            $icon = '<i class="fa fa-link"></i>';
            break;
        case 'video':
            $icon = '<i class="fa fa-video-camera"></i>';
            break;
        case 'gallery':
            $icon = '<i class="fa fa-image"></i>';
            break;
        case 'quote':
            $icon = '<i class="fa fa-quote-left"></i>';
            break;
        default:
            $icon = '<i class="fa fa-pencil"></i>';
            break;
    }
    return $icon;
}

if(!function_exists('inwave_get_googlefonts')){
    function inwave_get_googlefonts($flip = true){
        $fonts = array(
            "" => "Select Font",
            "ABeeZee" => esc_html__("ABeeZee", 'motohero'),
            "Abel" => esc_html__("Abel", 'motohero'),
            "Abril Fatface" => esc_html__("Abril Fatface", 'motohero'),
            "Aclonica" => esc_html__("Aclonica", 'motohero'),
            "Acme" => esc_html__("Acme", 'motohero'),
            "Actor" => esc_html__("Actor", 'motohero'),
            "Adamina" => esc_html__("Adamina", 'motohero'),
            "Advent Pro" => esc_html__("Advent Pro", 'motohero'),
            "Aguafina Script" => esc_html__("Aguafina Script", 'motohero'),
            "Akronim" => esc_html__("Akronim", 'motohero'),
            "Aladin" => esc_html__("Aladin", 'motohero'),
            "Aldrich" => esc_html__("Aldrich", 'motohero'),
            "Alef" => esc_html__("Alef", 'motohero'),
            "Alegreya" => esc_html__("Alegreya", 'motohero'),
            "Alegreya SC" => esc_html__("Alegreya SC", 'motohero'),
            "Alegreya Sans" => esc_html__("Alegreya Sans", 'motohero'),
            "Alegreya Sans SC" => esc_html__("Alegreya Sans SC", 'motohero'),
            "Alex Brush" => esc_html__("Alex Brush", 'motohero'),
            "Alfa Slab One" => esc_html__("Alfa Slab One", 'motohero'),
            "Alice" => esc_html__("Alice", 'motohero'),
            "Alike" => esc_html__("Alike", 'motohero'),
            "Alike Angular" => esc_html__("Alike Angular", 'motohero'),
            "Allan" => esc_html__("Allan", 'motohero'),
            "Allerta" => esc_html__("Allerta", 'motohero'),
            "Allerta Stencil" => esc_html__("Allerta Stencil", 'motohero'),
            "Allura" => esc_html__("Allura", 'motohero'),
            "Almendra" => esc_html__("Almendra", 'motohero'),
            "Almendra Display" => esc_html__("Almendra Display", 'motohero'),
            "Almendra SC" => esc_html__("Almendra SC", 'motohero'),
            "Amarante" => esc_html__("Amarante", 'motohero'),
            "Amaranth" => esc_html__("Amaranth", 'motohero'),
            "Amatic SC" => esc_html__("Amatic SC", 'motohero'),
            "Amethysta" => esc_html__("Amethysta", 'motohero'),
            "Anaheim" => esc_html__("Anaheim", 'motohero'),
            "Andada" => esc_html__("Andada", 'motohero'),
            "Andika" => esc_html__("Andika", 'motohero'),
            "Angkor" => esc_html__("Angkor", 'motohero'),
            "Annie Use Your Telescope" => esc_html__("Annie Use Your Telescope", 'motohero'),
            "Anonymous Pro" => esc_html__("Anonymous Pro", 'motohero'),
            "Antic" => esc_html__("Antic", 'motohero'),
            "Antic Didone" => esc_html__("Antic Didone", 'motohero'),
            "Antic Slab" => esc_html__("Antic Slab", 'motohero'),
            "Anton" => esc_html__("Anton", 'motohero'),
            "Arapey" => esc_html__("Arapey", 'motohero'),
            "Arbutus" => esc_html__("Arbutus", 'motohero'),
            "Arbutus Slab" => esc_html__("Arbutus Slab", 'motohero'),
            "Architects Daughter" => esc_html__("Architects Daughter", 'motohero'),
            "Archivo Black" => esc_html__("Archivo Black", 'motohero'),
            "Archivo Narrow" => esc_html__("Archivo Narrow", 'motohero'),
            "Arimo" => esc_html__("Arimo", 'motohero'),
            "Arizonia" => esc_html__("Arizonia", 'motohero'),
            "Armata" => esc_html__("Armata", 'motohero'),
            "Artifika" => esc_html__("Artifika", 'motohero'),
            "Arvo" => esc_html__("Arvo", 'motohero'),
            "Asap" => esc_html__("Asap", 'motohero'),
            "Asset" => esc_html__("Asset", 'motohero'),
            "Astloch" => esc_html__("Astloch", 'motohero'),
            "Asul" => esc_html__("Asul", 'motohero'),
            "Atomic Age" => esc_html__("Atomic Age", 'motohero'),
            "Aubrey" => esc_html__("Aubrey", 'motohero'),
            "Audiowide" => esc_html__("Audiowide", 'motohero'),
            "Autour One" => esc_html__("Autour One", 'motohero'),
            "Average" => esc_html__("Average", 'motohero'),
            "Average Sans" => esc_html__("Average Sans", 'motohero'),
            "Averia Gruesa Libre" => esc_html__("Averia Gruesa Libre", 'motohero'),
            "Averia Libre" => esc_html__("Averia Libre", 'motohero'),
            "Averia Sans Libre" => esc_html__("Averia Sans Libre", 'motohero'),
            "Averia Serif Libre" => esc_html__("Averia Serif Libre", 'motohero'),
            "Bad Script" => esc_html__("Bad Script", 'motohero'),
            "Balthazar" => esc_html__("Balthazar", 'motohero'),
            "Bangers" => esc_html__("Bangers", 'motohero'),
            "Basic" => esc_html__("Basic", 'motohero'),
            "Battambang" => esc_html__("Battambang", 'motohero'),
            "Baumans" => esc_html__("Baumans", 'motohero'),
            "Bayon" => esc_html__("Bayon", 'motohero'),
            "Belgrano" => esc_html__("Belgrano", 'motohero'),
            "Belleza" => esc_html__("Belleza", 'motohero'),
            "BenchNine" => esc_html__("BenchNine", 'motohero'),
            "Bentham" => esc_html__("Bentham", 'motohero'),
            "Berkshire Swash" => esc_html__("Berkshire Swash", 'motohero'),
            "Bevan" => esc_html__("Bevan", 'motohero'),
            "Bigelow Rules" => esc_html__("Bigelow Rules", 'motohero'),
            "Bigshot One" => esc_html__("Bigshot One", 'motohero'),
            "Bilbo" => esc_html__("Bilbo", 'motohero'),
            "Bilbo Swash Caps" => esc_html__("Bilbo Swash Caps", 'motohero'),
            "Bitter" => esc_html__("Bitter", 'motohero'),
            "Black Ops One" => esc_html__("Black Ops One", 'motohero'),
            "Bokor" => esc_html__("Bokor", 'motohero'),
            "Bonbon" => esc_html__("Bonbon", 'motohero'),
            "Boogaloo" => esc_html__("Boogaloo", 'motohero'),
            "Bowlby One" => esc_html__("Bowlby One", 'motohero'),
            "Bowlby One SC" => esc_html__("Bowlby One SC", 'motohero'),
            "Brawler" => esc_html__("Brawler", 'motohero'),
            "Bree Serif" => esc_html__("Bree Serif", 'motohero'),
            "Bubblegum Sans" => esc_html__("Bubblegum Sans", 'motohero'),
            "Bubbler One" => esc_html__("Bubbler One", 'motohero'),
            "Buda" => esc_html__("Buda", 'motohero'),
            "Buenard" => esc_html__("Buenard", 'motohero'),
            "Butcherman" => esc_html__("Butcherman", 'motohero'),
            "Butterfly Kids" => esc_html__("Butterfly Kids", 'motohero'),
            "Cabin" => esc_html__("Cabin", 'motohero'),
            "Cabin Condensed" => esc_html__("Cabin Condensed", 'motohero'),
            "Cabin Sketch" => esc_html__("Cabin Sketch", 'motohero'),
            "Caesar Dressing" => esc_html__("Caesar Dressing", 'motohero'),
            "Cagliostro" => esc_html__("Cagliostro", 'motohero'),
            "Calligraffitti" => esc_html__("Calligraffitti", 'motohero'),
            "Cambo" => esc_html__("Cambo", 'motohero'),
            "Candal" => esc_html__("Candal", 'motohero'),
            "Cantarell" => esc_html__("Cantarell", 'motohero'),
            "Cantata One" => esc_html__("Cantata One", 'motohero'),
            "Cantora One" => esc_html__("Cantora One", 'motohero'),
            "Capriola" => esc_html__("Capriola", 'motohero'),
            "Cardo" => esc_html__("Cardo", 'motohero'),
            "Carme" => esc_html__("Carme", 'motohero'),
            "Carrois Gothic" => esc_html__("Carrois Gothic", 'motohero'),
            "Carrois Gothic SC" => esc_html__("Carrois Gothic SC", 'motohero'),
            "Carter One" => esc_html__("Carter One", 'motohero'),
            "Caudex" => esc_html__("Caudex", 'motohero'),
            "Cedarville Cursive" => esc_html__("Cedarville Cursive", 'motohero'),
            "Ceviche One" => esc_html__("Ceviche One", 'motohero'),
            "Changa One" => esc_html__("Changa One", 'motohero'),
            "Chango" => esc_html__("Chango", 'motohero'),
            "Chau Philomene One" => esc_html__("Chau Philomene One", 'motohero'),
            "Chela One" => esc_html__("Chela One", 'motohero'),
            "Chelsea Market" => esc_html__("Chelsea Market", 'motohero'),
            "Chenla" => esc_html__("Chenla", 'motohero'),
            "Cherry Cream Soda" => esc_html__("Black Ops One", 'motohero'),
            "Cherry Swash" => esc_html__("Cherry Swash", 'motohero'),
            "Chewy" => esc_html__("Chewy", 'motohero'),
            "Chicle" => esc_html__("Chicle", 'motohero'),
            "Chivo" => esc_html__("Chivo", 'motohero'),
            "Cinzel" => esc_html__("Cinzel", 'motohero'),
            "Cinzel Decorative" => esc_html__("Cinzel Decorative", 'motohero'),
            "Clicker Script" => esc_html__("Clicker Script", 'motohero'),
            "Coda" => esc_html__("Coda", 'motohero'),
            "Coda Caption" => esc_html__("Coda Caption", 'motohero'),
            "Codystar" => esc_html__("Codystare", 'motohero'),
            "Combo" => esc_html__("Combo", 'motohero'),
            "Comfortaa" => esc_html__("Comfortaa", 'motohero'),
            "Coming Soon" => esc_html__("Coming Soon", 'motohero'),
            "Concert One" => esc_html__("Concert One", 'motohero'),
            "Condiment" => esc_html__("Condiment", 'motohero'),
            "Content" => esc_html__("Content", 'motohero'),
            "Contrail One" => esc_html__("Contrail One", 'motohero'),
            "Convergence" => esc_html__("Convergence", 'motohero'),
            "Cookie" => esc_html__("Cookie", 'motohero'),
            "Copse" => esc_html__("Copse", 'motohero'),
            "Corben" => esc_html__("Corben", 'motohero'),
            "Courgette" => esc_html__("Courgette", 'motohero'),
            "Cousine" => esc_html__("Cousine", 'motohero'),
            "Coustard" => esc_html__("Coustard", 'motohero'),
            "Covered By Your Grace" => esc_html__("Covered By Your Grace", 'motohero'),
            "Crafty Girls" => esc_html__("Crafty Girls", 'motohero'),
            "Creepster" => esc_html__("Creepster", 'motohero'),
            "Crete Round" => esc_html__("Crete Round", 'motohero'),
            "Crimson Text" => esc_html__("Crimson Text", 'motohero'),
            "Croissant One" => esc_html__("Croissant One", 'motohero'),
            "Crushed" => esc_html__("Crushed", 'motohero'),
            "Cuprum" => esc_html__("Cuprum", 'motohero'),
            "Cutive" => esc_html__("Cutive", 'motohero'),
            "Cutive Mono" => esc_html__("Cutive Mono", 'motohero'),
            "Damion" => esc_html__("Damion", 'motohero'),
            "Dancing Script" => esc_html__("Dancing Script", 'motohero'),
            "Dangrek" => esc_html__("Dangrek", 'motohero'),
            "Dawning of a New Day" => esc_html__("Dawning of a New Day", 'motohero'),
            "Days One" => esc_html__("Days One", 'motohero'),
            "Delius" => esc_html__("Delius", 'motohero'),
            "Delius Swash Caps" => esc_html__("Delius Swash Caps", 'motohero'),
            "Delius Unicase" => esc_html__("Delius Unicase", 'motohero'),
            "Della Respira" => esc_html__("Della Respira", 'motohero'),
            "Denk One" => esc_html__("Denk One", 'motohero'),
            "Devonshire" => esc_html__("Devonshire", 'motohero'),
            "Didact Gothic" => esc_html__("Didact Gothic", 'motohero'),
            "Diplomata" => esc_html__("Diplomata", 'motohero'),
            "Diplomata SC" => esc_html__("Diplomata SC", 'motohero'),
            "Domine" => esc_html__("Domine", 'motohero'),
            "Donegal One" => esc_html__("Donegal One", 'motohero'),
            "Doppio One" => esc_html__("Doppio One", 'motohero'),
            "Dorsa" => esc_html__("Dorsa", 'motohero'),
            "Dosis" => esc_html__("Dosis", 'motohero'),
            "Dr Sugiyama" => esc_html__("Dr Sugiyama", 'motohero'),
            "Droid Sans" => esc_html__("Droid Sans", 'motohero'),
            "Droid Sans Mono" => esc_html__("Droid Sans Mono", 'motohero'),
            "Droid Serif" => esc_html__("Droid Serif", 'motohero'),
            "Duru Sans" => esc_html__("Duru Sans", 'motohero'),
            "Dynalight" => esc_html__("Dynalight", 'motohero'),
            "EB Garamond" => esc_html__("EB Garamond", 'motohero'),
            "Eagle Lake" => esc_html__("Eagle Lake", 'motohero'),
            "Eater" => esc_html__("Eater", 'motohero'),
            "Economica" => esc_html__("Economica", 'motohero'),
            "Electrolize" => esc_html__("Electrolize", 'motohero'),
            "Elsie" => esc_html__("Elsie", 'motohero'),
            "Elsie Swash Caps" => esc_html__("Elsie Swash Caps", 'motohero'),
            "Emblema One" => esc_html__("Emblema One", 'motohero'),
            "Emilys Candy" => esc_html__("Emilys Candy", 'motohero'),
            "Engagement" => esc_html__("Engagement", 'motohero'),
            "Englebert" => esc_html__("Englebert", 'motohero'),
            "Enriqueta" => esc_html__("Enriqueta", 'motohero'),
            "Erica One" => esc_html__("Erica One", 'motohero'),
            "Esteban" => esc_html__("Esteban", 'motohero'),
            "Euphoria Script" => esc_html__("Euphoria Script", 'motohero'),
            "Ewert" => esc_html__("Ewert", 'motohero'),
            "Exo" => esc_html__("Cutive", 'motohero'),"Exo",
            "Exo 2" => esc_html__("Exo 2", 'motohero'),
            "Expletus Sans" => esc_html__("Expletus Sans", 'motohero'),
            "Fanwood Text" => esc_html__("Fanwood Text", 'motohero'),
            "Fascinate" => esc_html__("Fascinate", 'motohero'),
            "Fascinate Inline" => esc_html__("Fascinate Inline", 'motohero'),
            "Faster One" => esc_html__("Faster One", 'motohero'),
            "Fasthand" => esc_html__("Fasthand", 'motohero'),
            "Fauna One" => esc_html__("Fauna One", 'motohero'),
            "Federant" => esc_html__("Federant", 'motohero'),
            "Federo" => esc_html__("Federo", 'motohero'),
            "Felipa" => esc_html__("Felipa", 'motohero'),
            "Fenix" => esc_html__("Fenix", 'motohero'),
            "Finger Paint" => esc_html__("Finger Paint", 'motohero'),
            "Fjalla One" => esc_html__("Fjalla One", 'motohero'),
            "Fjord One" => esc_html__("Fjord One", 'motohero'),
            "Flamenco" => esc_html__("Flamenco", 'motohero'),
            "Flavors" => esc_html__("Flavors", 'motohero'),
            "Fondamento" => esc_html__("Fondamento", 'motohero'),
            "Fontdiner Swanky" => esc_html__("Fontdiner Swanky", 'motohero'),
            "Forum" => esc_html__("Forum", 'motohero'),
            "Francois One" => esc_html__("Francois One", 'motohero'),
            "Freckle Face" => esc_html__("Freckle Face", 'motohero'),
            "Fredericka the Great" => esc_html__("Fredericka the Great", 'motohero'),
            "Fredoka One" => esc_html__("Fredoka One", 'motohero'),
            "Freehand" => esc_html__("Freehand", 'motohero'),
            "Fresca" => esc_html__("Fresca", 'motohero'),
            "Frijole" => esc_html__("Frijole", 'motohero'),
            "Fruktur" => esc_html__("Fruktur", 'motohero'),
            "Fugaz One" => esc_html__("Fugaz One", 'motohero'),
            "GFS Didot" => esc_html__("GFS Didot", 'motohero'),
            "GFS Neohellenic" => esc_html__("GFS Neohellenic", 'motohero'),
            "Gabriela" => esc_html__("Gabriela", 'motohero'),
            "Gafata" => esc_html__("Gafata", 'motohero'),
            "Galdeano" => esc_html__("Galdeano", 'motohero'),
            "Galindo" => esc_html__("Galindo", 'motohero'),
            "Gentium Basic" => esc_html__("Gentium Basic", 'motohero'),
            "Gentium Book Basic" => esc_html__("Gentium Book Basic", 'motohero'),
            "Geo" => esc_html__("Geo", 'motohero'),
            "Geostar" => esc_html__("Geostar", 'motohero'),
            "Geostar Fill" => esc_html__("Geostar Fill", 'motohero'),
            "Germania One" => esc_html__("Germania One", 'motohero'),
            "Gilda Display" => esc_html__("Gilda Display", 'motohero'),
            "Give You Glory" => esc_html__("Give You Glory", 'motohero'),
            "Glass Antiqua" => esc_html__("Glass Antiqua", 'motohero'),
            "Glegoo" => esc_html__("Glegoo", 'motohero'),
            "Gloria Hallelujah" => esc_html__("Gloria Hallelujah", 'motohero'),
            "Goblin One" => esc_html__("Goblin One", 'motohero'),
            "Gochi Hand" => esc_html__("Gochi Hand", 'motohero'),
            "Gorditas" => esc_html__("Gorditas", 'motohero'),
            "Goudy Bookletter 1911" => esc_html__("Goudy Bookletter 1911", 'motohero'),
            "Graduate" => esc_html__("Graduate", 'motohero'),
            "Grand Hotel" => esc_html__("Grand Hotel", 'motohero'),
            "Gravitas One" => esc_html__("Gravitas One", 'motohero'),
            "Great Vibes" => esc_html__("Great Vibes", 'motohero'),
            "Griffy" => esc_html__("Griffy", 'motohero'),
            "Gruppo" => esc_html__("Gruppo", 'motohero'),
            "Gudea" => esc_html__("Gudea", 'motohero'),
            "Habibi" => esc_html__("Habibi", 'motohero'),
            "Hammersmith One" => esc_html__("Hammersmith One", 'motohero'),
            "Hanalei" => esc_html__("Hanalei", 'motohero'),
            "Hanalei Fill" => esc_html__("Hanalei Fill", 'motohero'),
            "Handlee" => esc_html__("Handlee", 'motohero'),
            "Hanuman" => esc_html__("Hanuman", 'motohero'),
            "Happy Monkey" => esc_html__("Happy Monkey", 'motohero'),
            "Headland One" => esc_html__("Headland One", 'motohero'),
            "Henny Penny" => esc_html__("Henny Penny", 'motohero'),
            "Herr Von Muellerhoff" => esc_html__("Herr Von Muellerhoff", 'motohero'),
            "Holtwood One SC" => esc_html__("Holtwood One SC", 'motohero'),
            "Homemade Apple" => esc_html__("Homemade Apple", 'motohero'),
            "Homenaje" => esc_html__("Homenaje", 'motohero'),
            "IM Fell DW Pica" => esc_html__("IM Fell DW Pica", 'motohero'),
            "IM Fell DW Pica SC" => esc_html__("IM Fell DW Pica SC", 'motohero'),
            "IM Fell Double Pica" => esc_html__("IM Fell Double Pica", 'motohero'),
            "IM Fell Double Pica SC" => esc_html__("IM Fell Double Pica SC", 'motohero'),
            "IM Fell English" => esc_html__("IM Fell English", 'motohero'),
            "IM Fell English SC" => esc_html__("IM Fell English SC", 'motohero'),
            "IM Fell French Canon" => esc_html__("IM Fell French Canon", 'motohero'),
            "IM Fell French Canon SC" => esc_html__("IM Fell French Canon SC", 'motohero'),
            "IM Fell Great Primer" => esc_html__("IM Fell Great Primer", 'motohero'),
            "IM Fell Great Primer SC" => esc_html__("IM Fell Great Primer SC", 'motohero'),
            "Iceberg" => esc_html__("Iceberg", 'motohero'),
            "Iceland" => esc_html__("Iceland", 'motohero'),
            "Imprima" => esc_html__("Imprima", 'motohero'),
            "Inconsolata" => esc_html__("Inconsolata", 'motohero'),
            "Inder" => esc_html__("Inder", 'motohero'),
            "Indie Flower" => esc_html__("Indie Flower", 'motohero'),
            "Inika" => esc_html__("Inika", 'motohero'),
            "Irish Grover" => esc_html__("Irish Grover", 'motohero'),
            "Istok Web" => esc_html__("Istok Web", 'motohero'),
            "Italiana" => esc_html__("Italiana", 'motohero'),
            "Italianno" => esc_html__("Italianno", 'motohero'),
            "Jacques Francois" => esc_html__("Jacques Francois", 'motohero'),
            "Jacques Francois Shadow" => esc_html__("Jacques Francois Shadow", 'motohero'),
            "Jim Nightshade" => esc_html__("Jim Nightshade", 'motohero'),
            "Jockey One" => esc_html__("Jockey One", 'motohero'),
            "Jolly Lodger" => esc_html__("Jolly Lodger", 'motohero'),
            "Josefin Sans" => esc_html__("Josefin Sans", 'motohero'),
            "Josefin Slab" => esc_html__("Josefin Slab", 'motohero'),
            "Joti One" => esc_html__("Joti One", 'motohero'),
            "Judson" => esc_html__("Judson", 'motohero'),
            "Julee" => esc_html__("Julee", 'motohero'),
            "Julius Sans One" => esc_html__("Julius Sans One", 'motohero'),
            "Junge" => esc_html__("Junge", 'motohero'),
            "Jura" => esc_html__("Jura", 'motohero'),
            "Just Another Hand" => esc_html__("Just Another Hand", 'motohero'),
            "Just Me Again Down Here" => esc_html__("Just Me Again Down Here", 'motohero'),
            "Kameron" => esc_html__("Kameron", 'motohero'),
            "Kantumruy" => esc_html__("Kantumruy", 'motohero'),
            "Karla" => esc_html__("Karla", 'motohero'),
            "Kaushan Script" => esc_html__("Kaushan Script", 'motohero'),
            "Kavoon" => esc_html__("Kavoon", 'motohero'),
            "Kdam Thmor" => esc_html__("Kdam Thmor", 'motohero'),
            "Keania One" => esc_html__("Keania One", 'motohero'),
            "Kelly Slab" => esc_html__("Kelly Slab", 'motohero'),
            "Kenia" => esc_html__("Kenia", 'motohero'),
            "Khmer" => esc_html__("Khmer", 'motohero'),
            "Kite One" => esc_html__("Kite One", 'motohero'),
            "Knewave" => esc_html__("Knewave", 'motohero'),
            "Kotta One" => esc_html__("Kotta One", 'motohero'),
            "Koulen" => esc_html__("Koulen", 'motohero'),
            "Kranky" => esc_html__("Kranky", 'motohero'),
            "Kreon" => esc_html__("Kreon", 'motohero'),
            "Kristi" => esc_html__("Kristi", 'motohero'),
            "Krona One" => esc_html__("Krona One", 'motohero'),
            "La Belle Aurore" => esc_html__("La Belle Aurore", 'motohero'),
            "Lancelot" => esc_html__("Lancelot", 'motohero'),
            "Lato" => esc_html__("Lato", 'motohero'),
            "League Script" => esc_html__("League Script", 'motohero'),
            "Leckerli One" => esc_html__("Leckerli One", 'motohero'),
            "Ledger" => esc_html__("Ledger", 'motohero'),
            "Lekton" => esc_html__("Lekton", 'motohero'),
            "Lemon" => esc_html__("Lemon", 'motohero'),
            "Libre Baskerville" => esc_html__("Libre Baskerville", 'motohero'),
            "Life Savers" => esc_html__("Life Savers", 'motohero'),
            "Lilita One" => esc_html__("Lilita One", 'motohero'),
            "Lily Script One" => esc_html__("Lily Script One", 'motohero'),
            "Limelight" => esc_html__("Limelight", 'motohero'),
            "Linden Hill" => esc_html__("Linden Hill", 'motohero'),
            "Lobster" => esc_html__("Lobster", 'motohero'),
            "Lobster Two" => esc_html__("Lobster Two", 'motohero'),
            "Londrina Outline" => esc_html__("Londrina Outline", 'motohero'),
            "Londrina Shadow" => esc_html__("Londrina Shadow", 'motohero'),
            "Londrina Sketch" => esc_html__("Londrina Sketch", 'motohero'),
            "Londrina Solid" => esc_html__("Londrina Solid", 'motohero'),
            "Lora" => esc_html__("Lora", 'motohero'),
            "Love Ya Like A Sister" => esc_html__("Love Ya Like A Sister", 'motohero'),
            "Loved by the King" => esc_html__("Loved by the King", 'motohero'),
            "Lovers Quarrel" => esc_html__("Lovers Quarrel", 'motohero'),
            "Luckiest Guy" => esc_html__("Luckiest Guy", 'motohero'),
            "Lusitana" => esc_html__("Lusitana", 'motohero'),
            "Lustria" => esc_html__("Lustria", 'motohero'),
            "Macondo" => esc_html__("Macondo", 'motohero'),
            "Macondo Swash Caps" => esc_html__("Macondo Swash Caps", 'motohero'),
            "Magra" => esc_html__("Magra", 'motohero'),
            "Maiden Orange" => esc_html__("Maiden Orange", 'motohero'),
            "Mako" => esc_html__("Mako", 'motohero'),
            "Marcellus" => esc_html__("Marcellus", 'motohero'),
            "Marcellus SC" => esc_html__("Marcellus SC", 'motohero'),
            "Marck Script" => esc_html__("Marck Script", 'motohero'),
            "Margarine" => esc_html__("Margarine", 'motohero'),
            "Marko One" => esc_html__("Marko One", 'motohero'),
            "Marmelad" => esc_html__("Marmelad", 'motohero'),
            "Marvel" => esc_html__("Marvel", 'motohero'),
            "Mate" => esc_html__("Mate", 'motohero'),
            "Mate SC" => esc_html__("Mate SC", 'motohero'),
            "Maven Pro" => esc_html__("Maven Pro", 'motohero'),
            "McLaren" => esc_html__("McLaren", 'motohero'),
            "Meddon" => esc_html__("Meddon", 'motohero'),
            "MedievalSharp" => esc_html__("MedievalSharp", 'motohero'),
            "Medula One" => esc_html__("Medula One", 'motohero'),
            "Megrim" => esc_html__("Megrim", 'motohero'),
            "Meie Script" => esc_html__("Meie Script", 'motohero'),
            "Merienda" => esc_html__("Merienda", 'motohero'),
            "Merienda One" => esc_html__("Merienda One", 'motohero'),
            "Merriweather" => esc_html__("Merriweather", 'motohero'),
            "Merriweather Sans" => esc_html__("Merriweather Sans", 'motohero'),
            "Metal" => esc_html__("Metal", 'motohero'),
            "Metal Mania" => esc_html__("Metal Mania", 'motohero'),
            "Metamorphous" => esc_html__("Metamorphous", 'motohero'),
            "Metrophobic" => esc_html__("Metrophobic", 'motohero'),
            "Michroma" => esc_html__("Michroma", 'motohero'),
            "Milonga" => esc_html__("Milonga", 'motohero'),
            "Miltonian" => esc_html__("Miltonian", 'motohero'),
            "Miltonian Tattoo" => esc_html__("Miltonian Tattoo", 'motohero'),
            "Miniver" => esc_html__("Miniver", 'motohero'),
            "Miss Fajardose" => esc_html__("Miss Fajardose", 'motohero'),
            "Modern Antiqua" => esc_html__("Modern Antiqua", 'motohero'),
            "Molengo" => esc_html__("Molengo", 'motohero'),
            "Molle" => esc_html__("Molle", 'motohero'),
            "Monda" => esc_html__("Monda", 'motohero'),
            "Monofett" => esc_html__("Monofett", 'motohero'),
            "Monoton" => esc_html__("Monoton", 'motohero'),
            "Monsieur La Doulaise" => esc_html__("Monsieur La Doulaise", 'motohero'),
            "Montaga" => esc_html__("Montaga", 'motohero'),
            "Montez" => esc_html__("Montez", 'motohero'),
            "Montserrat" => esc_html__("Montserrat", 'motohero'),
            "Montserrat Alternates" => esc_html__("Montserrat Alternates", 'motohero'),
            "Montserrat Subrayada" => esc_html__("Montserrat Subrayada", 'motohero'),
            "Moul" => esc_html__("Moul", 'motohero'),
            "Moulpali" => esc_html__("Moulpali", 'motohero'),
            "Mountains of Christmas" => esc_html__("Mountains of Christmas", 'motohero'),
            "Mouse Memoirs" => esc_html__("Mouse Memoirs", 'motohero'),
            "Mr Bedfort" => esc_html__("Mr Bedfort", 'motohero'),
            "Mr Dafoe" => esc_html__("Mr Dafoe", 'motohero'),
            "Mr De Haviland" => esc_html__("Mr De Haviland", 'motohero'),
            "Mrs Saint Delafield" => esc_html__("Mrs Saint Delafield", 'motohero'),
            "Mrs Sheppards" => esc_html__("Mrs Sheppards", 'motohero'),
            "Muli" => esc_html__("Muli", 'motohero'),
            "Mystery Quest" => esc_html__("Mystery Quest", 'motohero'),
            "Neucha" => esc_html__("Neucha", 'motohero'),
            "Neuton" => esc_html__("Neuton", 'motohero'),
            "New Rocker" => esc_html__("New Rocker", 'motohero'),
            "News Cycle" => esc_html__("News Cycle", 'motohero'),
            "Niconne" => esc_html__("Niconne", 'motohero'),
            "Nixie One" => esc_html__("Nixie One", 'motohero'),
            "Nobile" => esc_html__("Nobile", 'motohero'),
            "Nokora" => esc_html__("Nokora", 'motohero'),
            "Norican" => esc_html__("Norican", 'motohero'),
            "Nosifer" => esc_html__("Nosifer", 'motohero'),
            "Nothing You Could Do" => esc_html__("Nothing You Could Do", 'motohero'),
            "Noticia Text" => esc_html__("Noticia Text", 'motohero'),
            "Noto Sans" => esc_html__("Noto Sans", 'motohero'),
            "Noto Serif" => esc_html__("Noto Serif", 'motohero'),
            "Nova Cut" => esc_html__("Nova Cut", 'motohero'),
            "Nova Flat" => esc_html__("Nova Flat", 'motohero'),
            "Nova Mono" => esc_html__("Nova Mono", 'motohero'),
            "Nova Oval" => esc_html__("Nova Oval", 'motohero'),
            "Nova Round" => esc_html__("Nova Round", 'motohero'),
            "Nova Script" => esc_html__("Nova Script", 'motohero'),
            "Nova Slim" => esc_html__("Nova Slim", 'motohero'),
            "Nova Square" => esc_html__("Nova Square", 'motohero'),
            "Numans" => esc_html__("Numans", 'motohero'),
            "Nunito" => esc_html__("Nunito", 'motohero'),
            "Odor Mean Chey" => esc_html__("Odor Mean Chey", 'motohero'),
            "Offside" => esc_html__("Offside", 'motohero'),
            "Old Standard TT" => esc_html__("Old Standard TT", 'motohero'),
            "Oldenburg" => esc_html__("Oldenburg", 'motohero'),
            "Oleo Script" => esc_html__("Oleo Script", 'motohero'),
            "Oleo Script Swash Caps" => esc_html__("Oleo Script Swash Caps", 'motohero'),
            "Open Sans" => esc_html__("Open Sans", 'motohero'),
            "Open Sans Condensed" => esc_html__("Open Sans Condensed", 'motohero'),
            "Oranienbaum" => esc_html__("Oranienbaum", 'motohero'),
            "Orbitron" => esc_html__("Orbitron", 'motohero'),
            "Oregano" => esc_html__("Oregano", 'motohero'),
            "Orienta" => esc_html__("Orienta", 'motohero'),
            "Original Surfer" => esc_html__("Original Surfer", 'motohero'),
            "Oswald" => esc_html__("Oswald", 'motohero'),
            "Over the Rainbow" => esc_html__("Over the Rainbow", 'motohero'),
            "Overlock" => esc_html__("Overlock", 'motohero'),
            "Overlock SC" => esc_html__("Overlock SC", 'motohero'),
            "Ovo" => esc_html__("Nova Cut", 'motohero'),"Ovo",
            "Oxygen" => esc_html__("Oxygen", 'motohero'),
            "Oxygen Mono" => esc_html__("Oxygen Mono", 'motohero'),
            "PT Mono" => esc_html__("PT Mono", 'motohero'),
            "PT Sans" => esc_html__("PT Sans", 'motohero'),
            "PT Sans Caption" => esc_html__("PT Sans Caption", 'motohero'),
            "PT Sans Narrow" => esc_html__("PT Sans Narrow", 'motohero'),
            "PT Serif" => esc_html__("PT Serif", 'motohero'),
            "PT Serif Caption" => esc_html__("PT Serif Caption", 'motohero'),
            "Pacifico" => esc_html__("Pacifico", 'motohero'),
            "Paprika" => esc_html__("Paprika", 'motohero'),
            "Parisienne" => esc_html__("Parisienne", 'motohero'),
            "Passero One" => esc_html__("Passero One", 'motohero'),
            "Passion One" => esc_html__("Passion One", 'motohero'),
            "Pathway Gothic One" => esc_html__("Pathway Gothic One", 'motohero'),
            "Patrick Hand" => esc_html__("Patrick Hand", 'motohero'),
            "Patrick Hand SC" => esc_html__("Patrick Hand SC", 'motohero'),
            "Patua One" => esc_html__("Patua One", 'motohero'),
            "Paytone One" => esc_html__("Paytone One", 'motohero'),
            "Peralta" => esc_html__("Peralta", 'motohero'),
            "Permanent Marker" => esc_html__("Permanent Marker", 'motohero'),
            "Petit Formal Script" => esc_html__("Petit Formal Script", 'motohero'),
            "Petrona" => esc_html__("Petrona", 'motohero'),
            "Philosopher" => esc_html__("Philosopher", 'motohero'),
            "Piedra" => esc_html__("Piedra", 'motohero'),
            "Pinyon Script" => esc_html__("Pinyon Script", 'motohero'),
            "Pirata One" => esc_html__("Pirata One", 'motohero'),
            "Plaster" => esc_html__("Plaster", 'motohero'),
            "Play" => esc_html__("Play", 'motohero'),
            "Playball" => esc_html__("Playball", 'motohero'),
            "Playfair Display" => esc_html__("Playfair Display", 'motohero'),
            "Playfair Display SC" => esc_html__("Playfair Display SC", 'motohero'),
            "Podkova" => esc_html__("Podkova", 'motohero'),
            "Poiret One" => esc_html__("Poiret One", 'motohero'),
            "Poller One" => esc_html__("Poller One", 'motohero'),
            "Poly" => esc_html__("Poly", 'motohero'),
            "Pompiere" => esc_html__("Pompiere", 'motohero'),
            "Pontano Sans" => esc_html__("Pontano Sans", 'motohero'),
            "Port Lligat Sans" => esc_html__("Port Lligat Sans", 'motohero'),
            "Port Lligat Slab" => esc_html__("Port Lligat Slab", 'motohero'),
            "Poppins" => esc_html__("Poppins", 'motohero'),
            "Prata" => esc_html__("Prata", 'motohero'),
            "Preahvihear" => esc_html__("Preahvihear", 'motohero'),
            "Press Start 2P" => esc_html__("Press Start 2P", 'motohero'),
            "Princess Sofia" => esc_html__("Princess Sofia", 'motohero'),
            "Prociono" => esc_html__("Prociono", 'motohero'),
            "Prosto One" => esc_html__("Prosto One", 'motohero'),
            "Puritan" => esc_html__("Puritan", 'motohero'),
            "Purple Purse" => esc_html__("Purple Purse", 'motohero'),
            "Quando" => esc_html__("Quando", 'motohero'),
            "Quantico" => esc_html__("Quantico", 'motohero'),
            "Quattrocento" => esc_html__("Quattrocento", 'motohero'),
            "Quattrocento Sans" => esc_html__("Quattrocento Sans", 'motohero'),
            "Questrial" => esc_html__("Questrial", 'motohero'),
            "Quicksand" => esc_html__("Quicksand", 'motohero'),
            "Quintessential" => esc_html__("Quintessential", 'motohero'),
            "Qwigley" => esc_html__("Qwigley", 'motohero'),
            "Racing Sans One" => esc_html__("Racing Sans One", 'motohero'),
            "Radley" => esc_html__("Radley", 'motohero'),
            "Raleway" => esc_html__("Raleway", 'motohero'),
            "Raleway Dots" => esc_html__("Raleway Dots", 'motohero'),
            "Rambla" => esc_html__("Rambla", 'motohero'),
            "Rammetto One" => esc_html__("Rammetto One", 'motohero'),
            "Ranchers" => esc_html__("Ranchers", 'motohero'),
            "Rancho" => esc_html__("Rancho", 'motohero'),
            "Rationale" => esc_html__("Rationale", 'motohero'),
            "Redressed" => esc_html__("Redressed", 'motohero'),
            "Reenie Beanie" => esc_html__("Reenie Beanie", 'motohero'),
            "Revalia" => esc_html__("Revalia", 'motohero'),
            "Ribeye" => esc_html__("Ribeye", 'motohero'),
            "Ribeye Marrow" => esc_html__("Ribeye Marrow", 'motohero'),
            "Righteous" => esc_html__("Righteous", 'motohero'),
            "Risque" => esc_html__("Risque", 'motohero'),
            "Roboto" => esc_html__("Roboto", 'motohero'),
            "Roboto Condensed" => esc_html__("Roboto Condensed", 'motohero'),
            "Roboto Slab" => esc_html__("Roboto Slab", 'motohero'),
            "Rochester" => esc_html__("Rochester", 'motohero'),
            "Rock Salt" => esc_html__("Rock Salt", 'motohero'),
            "Rokkitt" => esc_html__("Rokkitt", 'motohero'),
            "Romanesco" => esc_html__("Romanesco", 'motohero'),
            "Ropa Sans" => esc_html__("Ropa Sans", 'motohero'),
            "Rosario" => esc_html__("Rosario", 'motohero'),
            "Rosarivo" => esc_html__("Rosarivo", 'motohero'),
            "Rouge Script" => esc_html__("Rouge Script", 'motohero'),
            "Rubik Mono One" => esc_html__("Rubik Mono One", 'motohero'),
            "Rubik One" => esc_html__("Rubik One", 'motohero'),
            "Ruda" => esc_html__("Ruda", 'motohero'),
            "Rufina" => esc_html__("Rufina", 'motohero'),
            "Ruge Boogie" => esc_html__("Ruge Boogie", 'motohero'),
            "Ruluko" => esc_html__("Ruluko", 'motohero'),
            "Rum Raisin" => esc_html__("Rum Raisin", 'motohero'),
            "Ruslan Display" => esc_html__("Ruslan Display", 'motohero'),
            "Russo One" => esc_html__("Russo One", 'motohero'),
            "Ruthie" => esc_html__("Ruthie", 'motohero'),
            "Rye" => esc_html__("Rye", 'motohero'),
            "Sacramento" => esc_html__("Sacramento", 'motohero'),
            "Sail" => esc_html__("Sail", 'motohero'),
            "Salsa" => esc_html__("Salsa", 'motohero'),
            "Sanchez" => esc_html__("Sanchez", 'motohero'),
            "Sancreek" => esc_html__("Sancreek", 'motohero'),
            "Sansita One" => esc_html__("Sansita One", 'motohero'),
            "Sarina" => esc_html__("Sarina", 'motohero'),
            "Satisfy" => esc_html__("Satisfy", 'motohero'),
            "Scada" => esc_html__("Scada", 'motohero'),
            "Schoolbell" => esc_html__("Schoolbell", 'motohero'),
            "Seaweed Script" => esc_html__("Seaweed Script", 'motohero'),
            "Sevillana" => esc_html__("Sevillana", 'motohero'),
            "Seymour One" => esc_html__("Seymour One", 'motohero'),
            "Shadows Into Light" => esc_html__("Shadows Into Light", 'motohero'),
            "Shadows Into Light Two" => esc_html__("Shadows Into Light Two", 'motohero'),
            "Shanti" => esc_html__("Shanti", 'motohero'),
            "Share" => esc_html__("Share", 'motohero'),
            "Share Tech" => esc_html__("Share Tech", 'motohero'),
            "Share Tech Mono" => esc_html__("Share Tech Mono", 'motohero'),
            "Shojumaru" => esc_html__("Shojumaru", 'motohero'),
            "Short Stack" => esc_html__("Short Stack", 'motohero'),
            "Siemreap" => esc_html__("Siemreap", 'motohero'),
            "Sigmar One" => esc_html__("Sigmar One", 'motohero'),
            "Signika" => esc_html__("Signika", 'motohero'),
            "Signika Negative" => esc_html__("Signika Negative", 'motohero'),
            "Simonetta" => esc_html__("Simonetta", 'motohero'),
            "Sintony" => esc_html__("Sintony", 'motohero'),
            "Sirin Stencil" => esc_html__("Sirin Stencil", 'motohero'),
            "Six Caps" => esc_html__("Six Caps", 'motohero'),
            "Skranji" => esc_html__("Skranji", 'motohero'),
            "Slackey" => esc_html__("Slackey", 'motohero'),
            "Smokum" => esc_html__("Smokum", 'motohero'),
            "Smythe" => esc_html__("Smythe", 'motohero'),
            "Sniglet" => esc_html__("Sniglet", 'motohero'),
            "Snippet" => esc_html__("Snippet", 'motohero'),
            "Snowburst One" => esc_html__("Snowburst One", 'motohero'),
            "Sofadi One" => esc_html__("Sofadi One", 'motohero'),
            "Sofia" => esc_html__("Sofia", 'motohero'),
            "Sonsie One" => esc_html__("Sonsie One", 'motohero'),
            "Sorts Mill Goudy" => esc_html__("Sorts Mill Goudy", 'motohero'),
            "Source Code Pro" => esc_html__("Source Code Pro", 'motohero'),
            "Source Sans Pro" => esc_html__("Source Sans Pro", 'motohero'),
            "Special Elite" => esc_html__("Special Elite", 'motohero'),
            "Spicy Rice" => esc_html__("Spicy Rice", 'motohero'),
            "Spinnaker" => esc_html__("Spinnaker", 'motohero'),
            "Spirax" => esc_html__("Spirax", 'motohero'),
            "Squada One" => esc_html__("Squada One", 'motohero'),
            "Stalemate" => esc_html__("Stalemate", 'motohero'),
            "Stalinist One" => esc_html__("Stalinist One", 'motohero'),
            "Stardos Stencil" => esc_html__("Stardos Stencil", 'motohero'),
            "Stint Ultra Condensed" => esc_html__("Stint Ultra Condensed", 'motohero'),
            "Stint Ultra Expanded" => esc_html__("Stint Ultra Expanded", 'motohero'),
            "Stoke" => esc_html__("Stoke", 'motohero'),
            "Strait" => esc_html__("Strait", 'motohero'),
            "Sue Ellen Francisco" => esc_html__("Share", 'motohero'),
            "Sunshiney" => esc_html__("Sunshiney", 'motohero'),
            "Supermercado One" => esc_html__("Supermercado One", 'motohero'),
            "Suwannaphum" => esc_html__("Suwannaphum", 'motohero'),
            "Swanky and Moo Moo" => esc_html__("Swanky and Moo Moo", 'motohero'),
            "Syncopate" => esc_html__("Syncopate", 'motohero'),
            "Tangerine" => esc_html__("Tangerine", 'motohero'),
            "Taprom" => esc_html__("Taprom", 'motohero'),
            "Tauri" => esc_html__("Tauri", 'motohero'),
            "Telex" => esc_html__("Telex", 'motohero'),
            "Tenor Sans" => esc_html__("Tenor Sans", 'motohero'),
            "Text Me One" => esc_html__("Text Me One", 'motohero'),
            "The Girl Next Door" => esc_html__("The Girl Next Door", 'motohero'),
            "Tienne" => esc_html__("Tienne", 'motohero'),
            "Tinos" => esc_html__("Tinos", 'motohero'),
            "Titan One" => esc_html__("Titan One", 'motohero'),
            "Titillium Web" => esc_html__("Titillium Web", 'motohero'),
            "Trade Winds" => esc_html__("Trade Winds", 'motohero'),
            "Trocchi" => esc_html__("Trocchi", 'motohero'),
            "Trochut" => esc_html__("Trochut", 'motohero'),
            "Trykker" => esc_html__("Trykker", 'motohero'),
            "Tulpen One" => esc_html__("Tulpen One", 'motohero'),
            "Ubuntu" => esc_html__("Ubuntu", 'motohero'),
            "Ubuntu Condensed" => esc_html__("Ubuntu Condensed", 'motohero'),
            "Ubuntu Mono" => esc_html__("Ubuntu Mono", 'motohero'),
            "Ultra" => esc_html__("Ultra", 'motohero'),
            "Uncial Antiqua" => esc_html__("Uncial Antiqua", 'motohero'),
            "Underdog" => esc_html__("Underdog", 'motohero'),
            "Unica One" => esc_html__("Unica One", 'motohero'),
            "UnifrakturCook" => esc_html__("UnifrakturCook", 'motohero'),
            "UnifrakturMaguntia" => esc_html__("UnifrakturMaguntia", 'motohero'),
            "Unkempt" => esc_html__("Unkempt", 'motohero'),
            "Unlock" => esc_html__("Unlock", 'motohero'),
            "Unna" => esc_html__("Unna", 'motohero'),
            "VT323" => esc_html__("VT323", 'motohero'),
            "Vampiro One" => esc_html__("Vampiro One", 'motohero'),
            "Varela" => esc_html__("Varela", 'motohero'),
            "Varela Round" => esc_html__("Varela Round", 'motohero'),
            "Vast Shadow" => esc_html__("Shadow", 'motohero'),
            "Vibur" => esc_html__("Vibur", 'motohero'),
            "Vidaloka" => esc_html__("Vidaloka", 'motohero'),
            "Viga" => esc_html__("Viga", 'motohero'),
            "Voces" => esc_html__("Voces", 'motohero'),
            "Volkhov" => esc_html__("Volkhov", 'motohero'),
            "Vollkorn" => esc_html__("Vollkorn", 'motohero'),
            "Voltaire" => esc_html__("Voltaire", 'motohero'),
            "Waiting for the Sunrise" => esc_html__("Waiting for the Sunrise", 'motohero'),
            "Wallpoet" => esc_html__("Wallpoet", 'motohero'),
            "Walter Turncoat" => esc_html__("Walter Turncoat", 'motohero'),
            "Warnes" => esc_html__("Warnes", 'motohero'),
            "Wellfleet" => esc_html__("Wellfleet", 'motohero'),
            "Wendy One" => esc_html__("Wendy One", 'motohero'),
            "Wire One" => esc_html__("Wire One", 'motohero'),
            "Yanone Kaffeesatz" => esc_html__("Yanone Kaffeesatz", 'motohero'),
            "Yellowtail" => esc_html__("Yellowtail", 'motohero'),
            "Yeseva One" => esc_html__("Yeseva One", 'motohero'),
            "Yesteryear" => esc_html__("Yesteryear", 'motohero'),
            "Zeyada" => esc_html__("Zeyada", 'motohero'),
        );

        if($flip){
            return array_flip($fonts);
        }
        else{
            return $fonts;
        }
    }
}

function inwave_add_editor_styles() {
    add_editor_style();
}
add_action( 'admin_init', 'inwave_add_editor_styles' );

if (function_exists('inwave_load_widgets')) {
    add_action('widgets_init', 'inwave_load_widgets');
}