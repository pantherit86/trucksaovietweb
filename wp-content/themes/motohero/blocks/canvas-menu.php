<?php
$inwave_post_option = Inwave_Helper::getConfig();
$menu_title = '';
if($inwave_post_option['canvas-menu']) {
    $nav_menu = wp_get_nav_menu_object($inwave_post_option['canvas-menu']);
    $menu_title= $nav_menu->name;
}else{
    $menu_title = esc_html__('Main menu','motohero');
}
?>
<nav class="off-canvas-menu st-menu">
    <h2 class="canvas-menu-title"><?php echo esc_html( $menu_title ); ?> <span class="text-right"><a href="#" id="off-canvas-close"><i class="fa fa-times"></i></a></span></h2>
    <?php
    wp_nav_menu(array(
        "container"             => "",
        'menu'                  => $inwave_post_option['canvas-menu'],
        'theme_location'        => 'primary',
        "menu_class"            => "canvas-menu",
        "walker"                => new Inwave_Nav_Walker_Mobile(),
    ));
    ?>
</nav>

