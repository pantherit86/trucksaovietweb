<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package motohero
 */

$inwave_post_option = Inwave_Helper::getConfig();
$inwave_theme_option = Inwave_Helper::getConfig('smof');

include(get_template_directory() . '/framework/inc/initvars.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php esc_attr(bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php wp_head(); ?>
</head>
<body id="page-top" <?php body_class(); ?>>
<?php
get_template_part( 'blocks/canvas-menu');
?>

<div class="wrapper st-body <?php if($inwave_post_option['slide-id']) echo 'has-slider';?>" <?php if($inwave_post_option['inwave_background_color_page'])  echo 'style="background: '.$inwave_post_option['inwave_background_color_page'].';"';?>>
    <?php
        get_template_part( 'headers/header-' . $inwave_post_option['header-option']);
    ?>
    <?php if ($inwave_post_option['slide-id']) { ?>
        <div class="slide-container <?php echo esc_attr($inwave_post_option['slide-id'])?>">
            <?php putRevSlider($inwave_post_option['slide-id']); ?>
        </div>
    <?php } ?>
    <?php
        get_template_part( 'blocks/page-heading');
    ?>

