<?php
/**
 * @package motohero
 */
$inwave_theme_option = Inwave_Helper::getConfig('smof');
$authordata = Inwave_Helper::getAuthorData();

$post_format = get_post_format();
$contents = get_the_content();
$str_regux = '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-item post-<?php echo esc_attr($post_format) ?> fit-video">
        <div class="featured-image">
            <?php
            switch ($post_format) {
                case 'video':
                    $video = inwave_getElementsByTag('embed', $contents);
                    $str_regux = $video[0];
                    if ($video) {
                        echo apply_filters('the_content', $video[0]);
                    }
                    break;
                case 'gallery':
                    $gallery = inwave_getElementsByTag('gallery', $contents, 2);
                    $str_regux = $gallery[0];
                    if ($gallery) {
                        echo apply_filters('the_content', $gallery[0]);
                        break;
                    }
                default:
                    if ($inwave_theme_option['featured_images_single']) {
                        the_post_thumbnail();
                    }
                    break;
            }
            ?>
        </div>
        <div class="post-content <?php if (is_sticky()) echo 'sticky' ?>">
            <div class="post-icon theme-bg">
                <?php echo inwave_get_post_format_icon($post_format); ?>
                <?php if (is_sticky()) {
                    echo '<span class="feature-post">' . esc_html__('Sticky', 'motohero') . '</span>';
                } ?>
            </div>
            <div class="post-info-date theme-bg">
                <span><?php echo get_the_date('d'); ?></span><br/><?php echo get_the_date('M'); ?></div>
            <div class="post-content-detail">
                <div class="post-content-head">
                    <div class="post-head-detail">
                        <?php if ($inwave_theme_option['blog_post_title']): ?>
                            <h3 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title('', ''); ?></a>
                            </h3>
                        <?php endif; ?>
                        <div class="post-info">
                            <?php if ($inwave_theme_option['author_info']): ?>
                                <div class="post-info-category">
                                    <span><?php echo esc_html__('By', 'motohero') ?></span>
                                    <a href="<?php echo esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)); ?>">
                                        <?php echo esc_html($authordata->display_name); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($inwave_theme_option['blog_category_title_listing']): ?>
                                <div
                                    class="post-info-category theme-color"><?php echo '<span>' . esc_html__('On', 'motohero') . '</span> '; ?><?php the_category(', ') ?></div>
                            <?php endif; ?>
                            <?php
                            if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                                echo '<div class="post-info-comment">';
                                comments_popup_link(esc_html__('0 comment', 'motohero'), esc_html__('1 Comment', 'motohero'), esc_html__('% Comments', 'motohero'));
                                echo '</span></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="post-content-desc">
                    <div class="post-text">
                        <?php echo apply_filters('the_content', str_replace($str_regux, '', get_the_content())); ?>
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'motohero'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>
                </div>
                <div class="clear"></div>
                <?php if ($inwave_theme_option['entry_footer']): ?>
                    <div class="entry-footer">
                        <?php inwave_entry_footer(); ?>
                    </div>
                <?php endif ?>
                <div class="clear"></div>
                <?php if ($inwave_theme_option['social_sharing_box']): ?>
                    <div class="share single-post-share">
                        <span class="share-title"><?php echo esc_html__('Share This Post', 'motohero'); ?></span>
                        <div class="social-icon">
                            <?php
                            inwave_social_sharing(get_permalink(), Inwave_Helper::substrword(get_the_excerpt(), 10), get_the_title());
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- .entry-footer -->
        <?php if ($inwave_theme_option['author_info']): ?>
            <div class="blog-author">
                <div class="authorAvt">
                    <div class="authorAvt-inner">
                        <?php echo get_avatar(get_the_author_meta('email'), 213) ?>
                    </div>
                </div>
                <div class="authorDetails">
                    <div class="author-title">
                        <a class="beveled-background"
                           href="<?php echo esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)); ?>"><?php echo esc_html($authordata->user_nicename); ?></a>
                    </div>
                    <?php if (get_the_author_meta('description')) { ?>
                        <div class="caption-desc">
                            <?php echo get_the_author_meta('description'); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </div>
        <?php endif ?>

        <?php if ($inwave_theme_option['related_posts']): ?>
            <?php get_template_part('blocks/related-posts'); ?>
        <?php endif ?>
    </div>
</article><!-- #post-## -->