<?php
/*
 * @package Portfolios Manager
 * @version 1.0.0
 * @created Mar 18, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of portfolio
 *
 * @developer duongca
 */
require_once (ABSPATH . 'wp-content/plugins/iw_portfolio/includes/utility.php');
get_header();
$utility = new iwcUtility();
wp_enqueue_script('iwc-js');
?>
<div class="page-content">
    <!-- Main Content -->
    <div class="main-content class-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <!-- Banner Content -->
                    <?php
                    $image_gallery_data = get_post_meta($post->ID, 'iw_portfolio_image_gallery', true);
                    $image_gallery = unserialize($image_gallery_data);
                    if (!empty($image_gallery)):
                        ?>
                        <section class="banner-details">
                                <!-- Wrapper for slides -->
                                <?php
                                if (count($image_gallery) == 2) {
                                    echo do_shortcode('[inwave_comparision_slider before="' . $image_gallery[0] . '" after="' . $image_gallery[1] . '"]');
                                } else {
                                    ?>
                            <div class="portfolio-slider">
                                <?php
                                        for ($i = 0; $i < count($image_gallery); $i++):
                                            $img = wp_get_attachment_image_src($image_gallery[$i], 'iw_portfolio-large');
                                            ?>
                                            <div class="item<?php echo $i == 0 ? ' active' : ''; ?>">
                                                <img alt="" src="<?php echo $img[0]; ?>">
                                            </div>
                                        <?php endfor; ?>
                                </div>
                            <?php } ?>

                        </section>
                    <?php endif; ?>
                    <!-- End Banner Content -->

                    <!--  Desc -->
                    <div class="content-page">
                        <section class="class-details">
                            <div class="details-desc-title">
                                <div class="port-detail-title"><span class="theme-bg"><?php _e('The Challenges', 'inwavethemes'); ?></span></div>
                                <?php if ($utility->getPortfolioOption('enable_voting', '0') == 1): ?>
                                    <div class="btp-detail-voting">
                                        <?php
                                        if ($utility->getPortfolioOption('enable_voting', '0') == 1):
                                            $results = $wpdb->get_row($wpdb->prepare('SELECT COUNT(id) as vote_count, SUM(vote) as vote_sum FROM ' . $wpdb->prefix . 'iw_portfolio_vote WHERE item_id=%d', get_the_ID()));
                                            $voteSum = $results->vote_sum;
                                            $voteCount = $results->vote_count;
                                            echo $utility->getAthleteRatingPanel(get_the_ID(), $voteSum, $voteCount);
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <div class="iw-clear-both"></div>
                            </div>
                            <?php the_content(); ?>
                        </section>
                    </div>
                    <!-- End Desc -->

                    <!--  Comments -->
                    <?php if (comments_open()) : ?>
                        <section class="comments">
                            <?php comments_template(); ?> 
                        </section>
                    <?php endif; ?>
                    <!-- End Comments -->	

                </div>		
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <section class="class-info">
                        <div class="project-information">
                            <div class="portfolio-sidebar-title">
                                <h4><?php echo __('Project Information', 'inwavethemes'); ?></h4>
                            </div>
                            <div class="iwp-ifo-item">
                                <label class="fname"><?php _e('Project name', 'inwavethemes'); ?>: </label>
                                <label class="ftext"><span class="text"><?php the_title(); ?></span><span class="line"></span></label>
                                <div style="clear: both"></div>
                            </div>
                            <div class="iwp-ifo-item">
                                <label class="fname"><?php _e('Category', 'inwavethemes'); ?>: </label>
                                <label class="ftext">
                                    <span class="text"><?php
                                        $portCategories = get_the_terms(get_the_ID(), 'iwp_category');
                                        $cats = array();
                                        $catid = array();
                                        foreach ($portCategories as $ck => $cat) {
                                            $catid[] = $cat->term_id;
                                            $cats[] = '<a href="'.  get_term_link($cat).'">' . $cat->name . '</a>';
                                            if ($ck == 1) {
                                                break;
                                            }
                                        }
                                        echo implode(', ', $cats);
                                        ?>
                                    </span>
                                    <span class="line"></span>
                                </label>
                                <div style="clear: both"></div>
                            </div>
                            <?php
                            $extrafiels_data = $wpdb->get_results($wpdb->prepare("SELECT b.name, a.value, b.type FROM " . $wpdb->prefix . "iw_portfolio_extrafields_value as a INNER JOIN " . $wpdb->prefix . "iw_portfolio_extrafields as b ON a.extrafields_id = b.id WHERE a.portfolio_id=%d", get_the_ID()));
                            if ($extrafiels_data):
                                foreach ($extrafiels_data as $field):
                                    $name = $field->name;
                                    $value = $field->value;
                                    ?>
                                    <?php
                                    switch ($field->type):
                                        case 'link':
                                            $link_data = unserialize(html_entity_decode($value));
                                            if ($link_data['link_value_link']):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <a class="text" href="<?php echo $link_data['link_value_link']; ?>"target="<?php echo $link_data['link_value_target']; ?>"><?php echo $link_data['link_value_text']; ?></a>
                                                        <span class="line"></span>
                                                    </label>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'image':
                                            if ($value):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <span class="fname"><?php echo $name; ?>: </span>
                                                    <span class="ftext">
                                                        <span class="text"><img src="<?php echo $value ?>" width="150px" /></span>
                                                        <span class="line"></span>
                                                    </span>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'measurement':
                                            $measurement_data = unserialize(html_entity_decode($value));
                                            if ($measurement_data['measurement_value']):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <span class="text"><?php echo $measurement_data['measurement_value'] . ' ' . $measurement_data['measurement_unit']; ?></span>
                                                        <span class="line"></span>
                                                    </label>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'dropdown_list':
                                            $drop_data = unserialize(html_entity_decode($value));
                                            if (!empty($drop_data)):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <span class="text"><?php echo implode(', ', $drop_data); ?></span>
                                                        <span class="line"></span>
                                                    </label>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        case 'date':
                                            if (!empty($value)):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo $name; ?>: </label>
                                                    <label class="ftext">
                                                        <span class="text"><?php echo date('F d, Y', strtotime($value)); ?></span>
                                                        <span class="line"></span>
                                                    </label>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                        default:
                                            if ($value):
                                                ?>
                                                <div class="iwp-ifo-item">
                                                    <label class="fname"><?php echo stripslashes(($name)); ?>: </label>
                                                    <label class="ftext">
                                                        <span class="text"><?php echo htmlentities($value); ?></span>
                                                        <span class="line"></span>
                                                    </label>
                                                    <div style="clear: both"></div>
                                                </div>
                                                <?php
                                            endif;
                                            break;
                                    endswitch;
                                    ?>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                            <div class="share">
                                <div class="share-title">
                                    <h5><?php echo __('Share This', 'inwavethemes'); ?></h5>										
                                </div>
                                <div class="social-icon">
                                    <?php inwave_social_sharing(get_permalink(), $utility->truncateString(get_the_excerpt(), 10), get_the_title()); ?>
                                </div>
                                <div style="clear: both"></div>
                            </div>
                        </div>
                        <div class="related-projects">
                            <div class="portfolio-sidebar-title">
                                <h4><?php echo __('related projects', 'inwavethemes'); ?></h4>
                            </div>
                            <?php echo do_shortcode('[iwp_relate col=1 category=' . implode(',', $catid) . ' number=2]'); ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="emergency-services theme-bg center-text"><?php echo __('Emergency pick-up service available 24 / 7. Please call us', 'inwavethemes'); ?><span class="phone">+84 1234 588 888</span></div>
    </div>
    <!-- Main Content -->
</div>

<?php
get_footer();
