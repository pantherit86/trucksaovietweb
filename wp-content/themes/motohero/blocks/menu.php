<!--Menu desktop-->
<?php
$inwave_post_option = Inwave_Helper::getConfig();
wp_nav_menu(array(
	"container_class"       => "iw-main-menu",
	'menu'                  => $inwave_post_option['theme-menu-id'],
	'theme_location'        => $inwave_post_option['theme-menu'],
	"menu_class"            => "iw-nav-menu",
	"walker"                => new Inwave_Nav_Walker(),
));
