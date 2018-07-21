<?php
/**
 * The template part for displaying social links
 * @package inhost
 */
$inwave_theme_option = Inwave_Helper::getConfig('smof');

?>
<ul class="iw-social-all">
    <?php if ($inwave_theme_option['facebook_link']): ?>
        <li><a class="iw-social-fb" target="_blank" href="<?php echo esc_url($inwave_theme_option['facebook_link']); ?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['twitter_link']): ?>
        <li><a class="iw-social-twitter" target="_blank"  href="<?php echo esc_url($inwave_theme_option['twitter_link']); ?>" title="Twitter"><i class="fa fa-twitter"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['linkedin_link']): ?>
        <li><a class="iw-social-linkedin" target="_blank"  href="<?php echo esc_url($inwave_theme_option['linkedin_link']); ?>" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['rss_link']): ?>
        <li><a class="iw-social-rss" target="_blank"  href="<?php echo esc_url($inwave_theme_option['rss_link']); ?>" title="RSS"><i class="fa fa-rss"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['dribbble_link']): ?>
        <li><a class="iw-social-dribbble" target="_blank"  href="<?php echo esc_url($inwave_theme_option['dribbble_link']); ?>" title="Dribbble"><i class="fa fa-dribbble"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['youtube_link']): ?>
        <li><a class="iw-social-youtube" target="_blank"  href="<?php echo esc_url($inwave_theme_option['youtube_link']); ?>" title="Youtube"><i class="fa fa-youtube"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['pinterest_link']): ?>
        <li><a class="iw-social-pinterest" target="_blank"  href="<?php echo esc_url($inwave_theme_option['pinterest_link']); ?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['flickr_link']): ?>
        <li><a class="iw-social-flickr" target="_blank"  href="<?php echo esc_url($inwave_theme_option['flickr_link']); ?>" title="Flickr"><i class="fa fa-flickr"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['vimeo_link']): ?>
        <li><a class="iw-social-vimeo" target="_blank"  href="<?php echo esc_url($inwave_theme_option['vimeo_link']); ?>" title="Vimeo"><i class="fa fa-vimeo-square"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['tumblr_link']): ?>
        <li><a class="iw-social-tumblr" target="_blank"  href="<?php echo esc_url($inwave_theme_option['tumblr_link']); ?>" title="Tumblr"><i class="fa fa-tumblr"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['google_link']): ?>
        <li><a class="iw-social-google" target="_blank"  href="<?php echo esc_url($inwave_theme_option['google_link']); ?>" title="Google+"><i class="fa fa-google-plus"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['weibo_link']): ?>
        <li><a class="iw-social-weibo" target="_blank"  href="<?php echo esc_url($inwave_theme_option['weibo_link']); ?>" title="Weibo"><i class="fa fa-weibo"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['dropbox_link']): ?>
        <li><a class="iw-social-dropbox" target="_blank"  href="<?php echo esc_url($inwave_theme_option['dropbox_link']); ?>" title="Dropbox"><i class="fa fa-dropbox"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['skype_link']): ?>
        <li><a class="iw-social-skype" target="_blank"  href="<?php echo esc_attr($inwave_theme_option['skype_link']); ?>" title="Skype"><i class="fa fa-skype"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['instagram_link']): ?>
        <li><a class="iw-social-instagram" target="_blank"  href="<?php echo esc_url($inwave_theme_option['instagram_link']); ?>" title="Instagram"><i class="fa fa-instagram"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['email_link']): ?>
        <li><a class="iw-social-email" target="_blank"  href="mailto:<?php echo esc_attr($inwave_theme_option['email_link']); ?>" title="Email"><i class="fa fa-envelope"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['github_link']): ?>
        <li><a class="iw-social-github" target="_blank"  href="<?php echo esc_url($inwave_theme_option['github_link']); ?>" title="Github"><i class="fa fa-github"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['appstore_link']): ?>
        <li><a class="iw-social-appstore" target="_blank"  href="<?php echo esc_url($inwave_theme_option['appstore_link']); ?>" title="Appstore"><i class="fa fa-apple"></i></a></li>
    <?php endif; ?>
    <?php if ($inwave_theme_option['android_link']): ?>
        <li><a class="iw-social-android" target="_blank"  href="<?php echo esc_url($inwave_theme_option['android_link']); ?>" title="Playstore"><i class="fa fa-android"></i></a></li>
    <?php endif; ?>
</ul>

