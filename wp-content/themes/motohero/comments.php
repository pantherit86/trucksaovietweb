<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package motohero
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
$totalComment = get_comment_count(get_the_ID())['total_comments'];
?>
<div id="comments" class="comments">

    <div class="comments-content">
        <h3 class="comment-title beveled-background"><?php echo esc_html__( 'Comments','motohero') ?></h3>
        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'motohero'); ?></p>
        <?php endif; ?>
        <?php if (have_comments()) : ?>
            <div class="commentList">
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                    <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                        <div
                            class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'motohero')); ?></div>
                        <div
                            class="nav-next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'motohero')); ?></div>
                    </nav><!-- #comment-nav-above -->
                <?php endif; // check for comment navigation ?>
                <ul class="comment_list">
                    <?php
                    wp_list_comments(array(
                        'callback' => 'inwave_comment',
                        'short_ping' => true,
                    ));
                    ?>
                </ul>
                <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                    <nav id="comment-nav-bellow" class="comment-navigation" role="navigation">
                        <div
                            class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'motohero')); ?></div>
                        <div
                            class="nav-next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'motohero')); ?></div>
                    </nav><!-- #comment-nav-below -->
                <?php endif; // check for comment navigation ?>

            </div>
        <?php endif; // have_comments() ?>

        <div class="form-comment">
            <?php
            $req      = get_option( 'require_name_email' );
            $aria_req = ( $req ? " aria-required='true'" : '' );
            $html_req = ( $req ? " required='required'" : '' );

            $required_text = sprintf( ' ' . esc_html__('Required fields are marked %s','motohero'), '<span class="required">*</span>' );
            comment_form(array(

                $fields = array(
                    'author' => '<div class="col-md-4 col-sm-12 col-xs-12"><div class="commentFormField"><input id="author" class="input-text" name="author" placeholder="' . esc_html__('Name*', 'motohero') . '" type="text" value="" size="30" /></div></div>',
                    'email' => '<div class="col-md-4 col-sm-12 col-xs-12"><div class="commentFormField"><input id="email" class="input-text" name="email" placeholder="' . esc_html__('Email*', 'motohero') . '" type="email" value="" size="30" /></div></div>',
                    'url' => '<div class="col-md-4 col-sm-12 col-xs-12"><div class="commentFormField"><input id="url" class="input-text" name="url" placeholder="' . esc_html__('Website', 'motohero') . '" type="url" value="" size="30" /></div></div>',
                ),
                'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
                'fields' => apply_filters('comment_form_default_fields', $fields),
                'comment_field' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12 commentFormField"><textarea id="comment" class="control" placeholder="' . _x('Comment*', 'noun','motohero') . '" name="comment" cols="45" rows="3" aria-required="true"></textarea></div>',
                'class_submit' => 'btn-submit button',
                'submit_field'         => '<div class="clear"></div><div class="col-md-4 col-sm-12 col-xs-12 form-submit">%1$s %2$s</div></div>',
                'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.','motohero' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>',
                'comment_notes_after' => '',
            )); ?>
        </div>
    </div>
    <!-- #comments -->
</div><!-- #comments -->
