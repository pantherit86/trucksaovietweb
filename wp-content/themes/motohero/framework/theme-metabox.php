<?php
/**
 * Include and setup custom metaboxes and fields.
 */

add_filter( 'cmb_meta_boxes', 'inwave_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function inwave_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'inwave_';

	$sideBars = array();
	$sideBars[''] = 'Auto';
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
		$sideBars[str_replace('sidebar-','',$sidebar['id'])] = ucwords( $sidebar['name'] );
	}

	$menuArr = array();
	$menuArr[''] = 'Default';
	$menus = get_terms('nav_menu');
	foreach ( $menus as $menu ) {
		$menuArr[$menu->slug] = $menu->name;
	}

	/**
	 * Metabox to be displayed on a single page ID
	 */

	$meta_boxes['page_metas'] = array(
		'id'         => 'page_metas',
		'title'      => esc_html__( 'Page Metabox', 'motohero' ),
		'pages'      => array( 'page', 'post' ), // Post type
		'context'    => 'side',
		'priority'   => 'low',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => esc_html__('Background Color Page', 'motohero'),
				'id'      => $prefix . 'background_color_page',
				'type'    => 'select',
				'options' => array(
					''=>  esc_html__( 'Default', 'motohero'),
					'#ffffff'=>  esc_html__( 'White', 'motohero'),
					'#000000'=>  esc_html__( 'Black', 'motohero'),
					'#00c8d6'=>  esc_html__( 'Blue', 'motohero'),
					'#49a32b'=>  esc_html__( 'Green', 'motohero'),
					'#ec3642'=>  esc_html__( 'Red', 'motohero'),
					'#efc10a'=>  esc_html__( 'Yellow', 'motohero'),
					'#ed9914'=>  esc_html__( 'Orange', 'motohero'),
					'#f9f9f9'=>  esc_html__( 'Very Light Gray', 'motohero'),
				),
				'default' => '',
			),
			array(
				'name'    => esc_html__('Select Revolution  Slider', 'motohero'),
				'id'      => $prefix . 'slider',
				'type'    => 'select',
				'options' => Inwave_Helper::getRevoSlider(),
				'default' => '',
			),
			array(
				'name'    => esc_html__( 'Show page heading', 'motohero' ),
				'id'      => $prefix . 'show_pageheading',
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'motohero' ),
					'yes'   => esc_html__( 'Yes', 'motohero' ),
					'no'     => esc_html__( 'No', 'motohero' ),
				),
			),
            array(
                'name'    => esc_html__( 'Show page breadcrumb', 'motohero' ),
                'id'      => $prefix . 'breadcrumbs',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'motohero' ),
                    'yes'   => esc_html__( 'Yes', 'motohero' ),
                    'no'     => esc_html__( 'No', 'motohero' ),
                ),
            ),
			array(
				'name' => esc_html__( 'Page heading background', 'motohero' ),
				'id'   => $prefix . 'pageheading_bg',
				'type' => 'file',
			),
			array(
				'name' => esc_html__( 'Change logo', 'motohero' ),
				'id'   => $prefix . 'logo',
				'type' => 'file',
			),
			array(
				'name'    => esc_html__( 'Sidebar Position', 'motohero' ),
				'id'      => $prefix . 'sidebar_position',
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'motohero' ),
					'none'   => esc_html__( 'Without Sidebar', 'motohero' ),
					'right'     => esc_html__( 'Right', 'motohero' ),
					'left'     => esc_html__( 'Left', 'motohero' ),
					'bottom'     => esc_html__( 'Bottom', 'motohero' ),
				),
			),
			array(
				'name'    => esc_html__( 'Sidebar Name', 'motohero' ),
				'id'      => $prefix . 'sidebar_name',
				'type'    => 'select',
				'options' => $sideBars,
			),
			array(
				'name' => esc_html__( 'Extra class', 'motohero' ),
				'desc' => esc_html__( 'Add extra class for page content', 'motohero' ),
				'default' => '',
				'id' => $prefix . 'page_class',
				'type' => 'text',
			),
			array(
				'name'    => esc_html__( 'Header style', 'motohero' ),
				'id'      => $prefix . 'header_option',
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'motohero' ),
					'default'   => esc_html__( 'Header Style 1', 'motohero' ),
					'v2'     => esc_html__( 'Header Style 2', 'motohero' ),
					'v3'     => esc_html__( 'Header Style 3', 'motohero' ),
					'v4'     => esc_html__( 'Header Style 4', 'motohero' ),
					'v5'     => esc_html__( 'Header Style 5', 'motohero' )
				),
			),
			array(
				'name'    => esc_html__( 'Sticky Header', 'motohero' ),
				'id'      => $prefix . 'header_sticky',
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'motohero' ),
					'yes'   => esc_html__( 'Yes', 'motohero' ),
					'no'     => esc_html__( 'No', 'motohero' ),
				),
			),
			array(
				'name'    => esc_html__( 'Primary Menu', 'motohero' ),
				'id'      => $prefix . 'primary_menu',
				'type'    => 'select',
				'options' => $menuArr,
			),
			array(
				'name'    => esc_html__( 'Show Donate button', 'motohero' ),
				'id'      => $prefix . 'show_donate_button',
				'type'    => 'select',
				'options' => array(
					'' => esc_html__( 'Default', 'motohero' ),
					'yes'   => esc_html__( 'Yes', 'motohero' ),
					'no'     => esc_html__( 'No', 'motohero' ),
				),
			),
			array(
				'name'    => esc_html__( 'Footer style', 'motohero' ),
				'id'      => $prefix . 'footer_option',
				'type'    => 'select',
				'options' => array(
                ''        => esc_html__( 'Default', 'motohero' ),
				'default' => esc_html__( 'Footer version 1', 'motohero' )
				),
			),
			array(
				'name'    => esc_html__( 'Theme style', 'motohero' ),
				'id'      => $prefix . 'theme_style',
				'type'    => 'select',
				'options' => array(
					''        => esc_html__( 'Default', 'motohero' ),
					'dark' => esc_html__( 'Dark', 'motohero' ),
					'light' => esc_html__( 'Light', 'motohero' )
				),
			),

		)
	);


	return $meta_boxes;
}