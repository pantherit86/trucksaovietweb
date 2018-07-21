<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 23/02/2016
 * Time: 5:02 CH
 */

$inwave_post_option = Inwave_Helper::getConfig();
$inwave_theme_option = Inwave_Helper::getConfig('smof');

register_sidebar(array(
    'name' => esc_html__('Sidebar Default', 'motohero'),
    'id' => 'sidebar-default',
    'description' => '',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title"><span>',
    'after_title' => '</span></h3>',
));

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar Product Page', 'motohero'),
            'id' => 'sidebar-woocommerce',
            'description' => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
}

register_sidebar(
    array(
        'name' => esc_html__('Sidebar Service', 'motohero'),
        'id' => 'sidebar-service',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));

//var_dump($inwave_theme_option["footer_number_widget"]);exit;
if(isset($inwave_theme_option["footer_number_widget"])){
    $footer_number_widget = $inwave_theme_option["footer_number_widget"];
    $register_sidebar_arr = array();
    switch($footer_number_widget)
    {
        case '4':
            $register_sidebar_arr[] = array(
                'name' => esc_html__( 'Footer widget 4', 'motohero' ),
                'id'            => 'footer-widget-4',
                'description' => esc_html__( 'This is footer widget location','motohero' ),
                'before_title' =>'<h3 class="widget-title">',
                'after_title' =>'</h3><div class="subtitle">
							<div class="line1"></div>
							<div class="line2"></div>
							<div class="clearfix"></div>
						</div>',
                'before_widget' => '<div class="%1$s widget %2$s">',
                'after_widget' => '</div>',
            );
        case '3':
            $register_sidebar_arr[] = array(
                'name' => esc_html__( 'Footer widget 3', 'motohero' ),
                'id'            => 'footer-widget-3',
                'description' => esc_html__( 'This is footer widget location','motohero' ),
                'before_title' =>'<h3 class="widget-title">',
                'after_title' =>'</h3><div class="subtitle">
							<div class="line1"></div>
							<div class="line2"></div>
							<div class="clearfix"></div>
						</div>',
                'before_widget' => '<div class="%1$s widget %2$s">',
                'after_widget' => '</div>',
            );
        case '2':
            $register_sidebar_arr[] = array(
                'name' => esc_html__( 'Footer widget 2', 'motohero' ),
                'id'            => 'footer-widget-2',
                'description' => esc_html__( 'This is footer widget location','motohero' ),
                'before_title' =>'<h3 class="widget-title">',
                'after_title' =>'</h3><div class="subtitle">
							<div class="line1"></div>
							<div class="line2"></div>
							<div class="clearfix"></div>
						</div>',
                'before_widget' => '<div class="%1$s widget %2$s">',
                'after_widget' => '</div>',
            );
        case '1':
            $register_sidebar_arr[] = array(
                'name' => esc_html__( 'Footer widget 1', 'motohero' ),
                'id'            => 'footer-widget-1',
                'description' => esc_html__( 'This is footer widget location','motohero' ),
                'before_title' =>'<h3 class="widget-title">',
                'after_title' =>'</h3><div class="subtitle">
							<div class="line1"></div>
							<div class="line2"></div>
							<div class="clearfix"></div>
						</div>',
                'before_widget' => '<div class="%1$s widget %2$s">',
                'after_widget' => '</div>',
            );
    }

    $register_sidebar_arr = array_reverse($register_sidebar_arr);
    foreach($register_sidebar_arr as $register_sidebar){
        register_sidebar($register_sidebar);
    }
}

register_nav_menus(array(
    'primary'           => esc_html__('Primary Menu', 'motohero'),
    'footer-menu'       => esc_html__('Footer Menu','motohero'),
));
