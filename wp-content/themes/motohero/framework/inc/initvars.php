<?php
/***********
 * LOAD THEME CONFIGURATION FILE
 */

 // Declare variables
$postId = get_the_ID();
$css = '';
// woo commerce shop ID
if( function_exists('is_shop') ) {
	if( is_shop() ) {
		$postId = get_option('woocommerce_shop_page_id');
	}
} else
if(( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type()){
    $postId = get_option('page_for_posts');
}
// get revolution slider-id from post meta
if(function_exists('putRevSlider')){
    $inwave_post_option['slide-id'] = get_post_meta( $postId, 'inwave_slider', true );
}else{
    $inwave_post_option['slide-id'] = 0;
}

// background color
$page_bg_color = get_post_meta($postId, 'inwave_background_color_page', true);
if(isset($page_bg_color)){
    $inwave_post_option['inwave_background_color_page'] = $page_bg_color;
}
// get show or hide heading from post meta
$inwave_post_option['show-pageheading']= get_post_meta( $postId, 'inwave_show_pageheading', true );
if(!$inwave_post_option['show-pageheading']){
	$inwave_post_option['show-pageheading'] = $inwave_theme_option['show_page_heading'];
}

if($inwave_post_option['show-pageheading'] =='no' || empty($inwave_post_option['show-pageheading'])){
    $inwave_post_option['show-pageheading']= 0;
}
else{
    $inwave_post_option['show-pageheading']= 1;
}

// get show or hide breadcrumb from post meta
$inwave_post_option['show-breadcrumbs']= get_post_meta( $postId, 'inwave_breadcrumbs', true );
if(!$inwave_post_option['show-breadcrumbs']){
    $inwave_post_option['show-breadcrumbs'] = $inwave_theme_option['breadcrumbs'];
}

if($inwave_post_option['show-breadcrumbs'] =='no' || empty($inwave_post_option['show-breadcrumbs'])){
    $inwave_post_option['show-breadcrumbs']= 0;
}
else{
    $inwave_post_option['show-breadcrumbs']= 1;
}

// get menu for mobile

if(!isset($inwave_theme_option['canvas_menu'])){
    $inwave_post_option['canvas-menu'] = 'primary';
}else{
    $inwave_post_option['canvas-menu'] = $inwave_theme_option['canvas_menu'];
}


// get heading background
$inwave_post_option['pageheading_bg'] = get_post_meta( $postId, 'inwave_pageheading_bg', true );

$inwave_post_option['sidebar-position'] = $inwave_theme_option['sidebar_position'];

if(!$inwave_post_option['sidebar-position']){
    $inwave_post_option['sidebar-position'] = 'right';
}
// get sidebar position from post meta
$sliderbarPos= get_post_meta( $postId, 'inwave_sidebar_position',true);
if($sliderbarPos){
    $inwave_post_option['sidebar-position'] = $sliderbarPos;
}
if($inwave_post_option['sidebar-position']=='none'){
    $inwave_post_option['sidebar-position'] = '';
}

$inwave_post_option['sidebar-name'] = '';
if(!isset($inwave_post_option['page-classes'])){
	$inwave_post_option['page-classes'] = '';
}
if (class_exists('WooCommerce') && (is_cart() || is_checkout())) {
    $inwave_post_option['page-classes'] .= ' page-product';
    $inwave_post_option['sidebar-name'] = 'woocommerce';
}
// get sidebar name
if(get_post_meta( $postId, 'inwave_sidebar_name',true)){
    $inwave_post_option['sidebar-name'] = get_post_meta( $postId, 'inwave_sidebar_name',true);
}

// get Page Class from post meta
if(!isset($inwave_post_option['page-classes'])) {
    $inwave_post_option['page-classes'] = '';
}
$inwave_post_option['page-classes'] .= get_post_meta($postId, 'inwave_page_class', true);

// header layout
if($inwave_theme_option['header_layout']){
    $inwave_post_option['header-option'] = $inwave_theme_option['header_layout'];
}

$headerOption = get_post_meta( $postId, 'inwave_header_option',true );
if($headerOption){
    $inwave_post_option['header-option'] = $headerOption;
}

if(!isset($inwave_post_option['header-option']) || $inwave_post_option['header-option']==''){
    $inwave_post_option['header-option'] = 'default';
}

// header sticky
$inwave_post_option['header-sticky'] = $inwave_theme_option['header_sticky'];
$headerSticky = get_post_meta( $postId, 'inwave_header_sticky',true );
if($headerSticky =='no'){
	$inwave_post_option['header-sticky'] = 0;
}
if($headerSticky =='yes'){
	$inwave_post_option['header-sticky'] = 1;
}

// footer layout
if(!isset($inwave_post_option['footer-option']) || $inwave_post_option['footer-option'] == ''){
	$inwave_post_option['footer-option'] = 'default';
}
if($inwave_theme_option['footer_option']){
	$inwave_post_option['footer-option'] = $inwave_theme_option['footer_option'];
}
$footerOption = get_post_meta( $postId, 'inwave_footer_option',true );
if($footerOption){
	$inwave_post_option['footer-option'] = $footerOption;
}

/* show search form for header version 5*/
if(!isset($inwave_post_option['show_search_form'])){
    $inwave_post_option['show_search_form'] = '';
}
if($inwave_theme_option['show_search_form']){
    $inwave_post_option['show_search_form'] = $inwave_theme_option['show_search_form'];
}

/* show or hidden icon social header */
if(!isset($inwave_post_option['header_social_links'])){
    $inwave_post_option['header_social_links'] = '';
}
if($inwave_theme_option['header_social_links']){
    $inwave_post_option['header_social_links'] = $inwave_theme_option['header_social_links'];
}

/** defined primary theme menu */
$inwave_post_option['theme-menu'] = 'primary';
$inwave_post_option['theme-menu-id'] = get_post_meta( $postId, 'inwave_primary_menu',true );

/* Logo */
if(!substr_count($inwave_theme_option['logo'],'http://') && !substr_count($inwave_theme_option['logo'],'https://')){
    $inwave_theme_option['logo'] = site_url() .'/'.$inwave_theme_option['logo'];
}

if(get_post_meta( $postId, 'inwave_logo',true )){
    $inwave_theme_option['logo'] = get_post_meta( $postId, 'inwave_logo',true );
}


/* Logo sticky */
if($inwave_theme_option['logo_sticky'] && !substr_count($inwave_theme_option['logo_sticky'],'http://') && !substr_count($inwave_theme_option['logo_sticky'],'https://')){
    $inwave_theme_option['logo_sticky'] = site_url() .'/'.$inwave_theme_option['logo_sticky'];
}
if(!$inwave_theme_option['logo_sticky']){
    $inwave_theme_option['logo_sticky'] = $inwave_theme_option['logo'];
}

/* Logo footer */
if($inwave_theme_option['footer-logo'] && !substr_count($inwave_theme_option['footer-logo'],'http://') && !substr_count($inwave_theme_option['footer-logo'],'https://')){
    $inwave_theme_option['footer-logo'] = site_url() .'/'.$inwave_theme_option['footer-logo'];
}
if(!$inwave_theme_option['footer-logo']){
    $inwave_theme_option['footer-logo'] = $inwave_theme_option['logo'];
}

$inwave_post_option['theme_style'] = get_post_meta( $postId, 'inwave_theme_style',true );
if(!$inwave_post_option['theme_style']){
    $inwave_post_option['theme_style'] = $inwave_theme_option['theme_style'];
}
if(!$inwave_post_option['theme_style']){
    $inwave_post_option['theme_style'] = 'light';
}

/** update cofig */
Inwave_Helper::setConfig($inwave_post_option);
Inwave_Helper::setConfig($inwave_theme_option,'smof');
