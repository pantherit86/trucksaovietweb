<?php

class Inwave_Shortcode_Class {

    // declare custom shortcodes
    private $shortCodes;

    function __construct() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (is_plugin_active('js_composer/js_composer.php')) {
            require_once(WP_PLUGIN_DIR . '/js_composer/include/classes/shortcodes/shortcodes.php');
        } else {
            return;
        }

        $this->shortCodes = inwave_get_shortcodes();
        add_action('init', array($this, 'add_row_params'));
        add_action('admin_init', array($this, 'generate_shortcode_params'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_admin'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        // include shortcodes
        foreach ($this->shortCodes as $shortCode) {
            include_once INWAVE_COMMON .'shortcodes/' . $shortCode . '.php';
        }

        add_action('media_buttons', array($this, 'shortcode_add_button'), 15);
        add_action('wp_ajax_nopriv_load_shortcode_settings', array($this, 'load_shortcode_settings'));
        add_action('wp_ajax_load_shortcode_settings', array($this, 'load_shortcode_settings'));
        add_action('wp_ajax_nopriv_load_shortcode_preview', array($this, 'load_shortcode_preview'));
        add_action('wp_ajax_load_shortcode_preview', array($this, 'load_shortcode_preview'));
        add_action('wp_ajax_nopriv_search_icons', array($this, 'search_icons'));
        add_action('wp_ajax_search_icons', array($this, 'search_icons'));
    }

    function load_shortcode_settings() {
        $shortcode = $_POST['shortcode'];
        if (isset(Inwave_Shortcode::$shortcodes[$shortcode])) {
            echo $this->get_field_html(Inwave_Shortcode::$shortcodes[$shortcode]);
        } else {
            echo __('Not exists', 'inwavethemes');
        }
        exit;
    }

    function search_icons() {
        $key = $_POST['key'];
        $type = $_POST['type'];
        echo $this->get_search_icons_html($type, $key);
        exit;
    }

    function generate_shortcode_params() {
        /* Generate param type "iw_icon" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_icon', array($this, 'icon_param_settings_field'));
        }
        /* Generate param type "iw_courses_categories" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_courses_categories', array($this, 'courses_categories_param_settings_field'));
        }
        /* Generate param type "iw_courses_categories" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_select', array($this, 'select_settings_field'));
        }

        /* Generate param type "iw_server_location" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_server_location', array($this, 'server_location_settings_field'));
        }

        /* Generate param type "iw_range_skillbar" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_range_skillbar', array($this, 'range_skillbar_settings_field'));
        }

        /* Generate param type "iw_map" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_map', array($this, 'map_settings_field'));
        }
		
		/* Generate param type "iw_profile_info" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iw_profile_info', array($this, 'profile_info_settings_field'));
        }

        /* Generate param type "iw_custom" */
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iwevent_event', array($this, 'iwe_event_settings_field'));
        }

        /* Generate param type iwe cateogry spearker*/
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iwevent_cateogry_spearker', array($this, 'iwe_cateogry_spearker_settings_field'));
        }

        /* Generate param type preview image*/
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('iwevent_preview_image', array($this, 'preview_image_settings_field'));
        }
    }

    function load_shortcode_preview() {
        echo '<html><head>';
        wp_head();
        echo '<style>body{background:none!important}</style>';
        echo '</head><body>';
        $shortcode = stripslashes($_GET['shortcode']);
        echo do_shortcode($shortcode);
        wp_footer();
        echo '</body></html>';
        exit();
    }

    function enqueue_scripts() {
        $theme_info = wp_get_theme();
        wp_enqueue_style('iw-shortcodes', plugins_url() . '/inwave-common/assets/css/iw-shortcodes.css', array(), $theme_info->get('Version'));
        wp_enqueue_script('iw-shortcodes', plugins_url() . '/inwave-common/assets/js/iw-shortcodes.js', array(), $theme_info->get('Version'), true);
    }

    function enqueue_scripts_admin() {
        $theme_info = wp_get_theme();
        wp_enqueue_style('iwicon', plugins_url() . '/inwave-common/assets/css/iwicon.css', array(), $theme_info->get('Version'));
        wp_register_script('iw-main', plugins_url() . '/inwave-common/assets/js/iw-main.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_script('iw_map_admin', plugins_url() . '/inwave-common/assets/js/iw-map-admin.js', array('jquery'), $theme_info->get('Version'), true);
        wp_enqueue_style('iw-main', plugins_url() . '/inwave-common/assets/css/iw-main.css', array(), $theme_info->get('Version'));
        wp_localize_script('iw-main', 'iwConfig', array('ajaxUrl' => admin_url('admin-ajax.php'), 'siteUrl' => site_url(), 'homeUrl' => get_home_url(), 'whmcs_pageid' => get_option("cc_whmcs_bridge_pages")));
        wp_enqueue_script('iw-main');
        wp_enqueue_script('jquery-ui-draggable');
    }

    /* add parameter for rows */
    function add_row_params() {

        if (!defined('WPB_VC_VERSION')) {
            return;
        }

        // init new params
        $newParams = array(
            array(
                "type" => "dropdown",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Width",
                "param_name" => "iw_layout",
                "value" => array(
                    "Auto" => "",
                    "Boxed" => "boxed",
                    "Wide Background" => "wide-bg",
                    "Wide Content" => "wide-content"
                )
            ),
            array(
                "type" => "dropdown",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax background",
                "description" => 'Require background image in Design Options Tab',
                "param_name" => "iw_parallax",
                "value" => array(
                    "No" => "0",
                    "Yes" => "1"
                )
            ),
            array(
                "type" => "textfield",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax Overlay opacity",
                "param_name" => "iw_parallax_overlay",
                "value" => '0.9'
            ),
            array(
                "type" => "textfield",
                "group" => "Layout options",
                "class" => "",
                "heading" => "Parallax background speed",
                "description" => "Enter speed factor from 0 to 1",
                "param_name" => "iw_parallax_speed",
                "value" => "0.1"
            )
        );
        // add to row
        vc_add_params("vc_row", $newParams);
        vc_set_shortcodes_templates_dir(dirname(dirname(__FILE__)) . '/vc_templates');
    }

    function icon_param_settings_field($settings, $value) {
        $name = $settings['param_name'] ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        return $this->get_icon_field($name, $value, $class);
    }


    function select_settings_field($settings, $value) {
        $name = $settings['param_name'];
        $datas = $settings['data'];
        $multi = $settings['multiple'];
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = $settings['class'] ? $settings['class'] : '';
        $class .= ' wpb_vc_param_value ' . $name . " " . $type;
        return $this->get_select_field($name, $value, $datas, $multi, $class);
    }

    function courses_categories_param_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_course_categories_field($param_name, $value, $class);
    }

    function server_location_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_server_loaction_html($param_name, $value, $class);
    }

    function range_skillbar_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_range_skillbar_field($param_name, $value, $class);
    }

    function map_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_map_field($param_name, $value, $class);
    }
	
	function profile_info_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_profile_info_field($param_name, $value, $class);
    }

    function iwe_event_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_iwe_event_field($param_name, $value, $class);
    }

    function iwe_cateogry_spearker_settings_field($settings, $value) {
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_iwe_cateogry_spearker_field($param_name, $value, $class);
    }

    function preview_image_settings_field($settings, $value){
        $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
        $type = isset($settings['type']) ? $settings['type'] : '';
        $class = isset($settings['class']) ? $settings['class'] : '';
        $class = "wpb_vc_param_value " . $param_name . " " . $type . " " . $class;
        return $this->get_preview_image_settings_field($param_name, $settings['value'], $class);
    }

    //Functions
    function shortcode_add_button() {
        echo '<a href="javascript:void(0);" id="insert-iw-shortcode" class="button">' . __('Insert IW Shortcode', 'inwavethemes') . '</a>';
        ?>
        <div id='iw-list-shortcode' class="iw-shortcode list-shortcode iw-hidden">
            <div class="shortcode-contain">
                <div class="shortcode-control">
                    <div class="title"><?php _e('List Shortcode', 'inwavethemes'); ?></div>
                    <div class="close-btn"><i class="fa fa-times"></i></div>
                    <div class="filter-box"><input placeholder="<?php echo __('Shortcode filter', 'inwavethemes'); ?>" class="shortcode-filter" name="shortcode-filter"/></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="shortcode-list-content">
                    <div class="shortcode-items">
                        <?php
                        foreach (Inwave_Shortcode::$shortcodes as $shortcode) {
                            if (isset($shortcode['base'])) {
                                echo '<div class="shortcode-item" data-shortcodetag="' . $shortcode['base'] . '">';
                                echo '<div class="icon">';
                                if ($shortcode['icon']) {
                                    if ($shortcode['icon'] == 'iw-default') {
                                        echo '<span class="' . $shortcode['icon'] . '"></span>';
                                    } else {
                                        echo '<i class="fa fa-2x fa-' . $shortcode['icon'] . '"></i>';
                                    }
                                } else {
                                    echo '<i class="iw-shortcode-dficon"></i>';
                                }
                                echo '</div>';
                                echo '<div class="short-info">';
                                echo '<div class="s_name">' . $shortcode['name'] . '</div>';
                                echo '<div class="s_des">' . $shortcode['description'] . '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
        <div id="iw-shortcode" class="iw-hidden iw-shortcode shortcode-item-view">
            <div class="shortcode-contain">
                <div class="shortcode-control">
                    <div class="title"><?php _e('Shortcode settings', 'inwavethemes'); ?></div>
                    <div class="close-btn"><i class="fa fa-times"></i></div>
                    <div style="clear: both;"></div>
                </div>
                <div class="shortcode-content">
                </div>
                <div class="shortcode-preview">
                </div>
                <div class="shortcode-save-setting">
                    <div class="save-settings"><?php _e('Insert Shortcode'); ?></div>
                    <div class="cancel-settings"><?php _e('Cancel'); ?></div>
                    <div class="preview-settings"><?php _e('Preview'); ?></div>
                    <div style="clear: both; padding: 0;"></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    var $shortcodeItems = $('.shortcode-items .shortcode-item');
                    $('.shortcode-control .shortcode-filter').on('input', function () {
                        var filterVal = $(this).val();
                        $shortcodeItems.each(function () {
                            var text = $(this).text();
                            if (text.toLowerCase().indexOf(filterVal.toLowerCase()) >= 0) {
                                $(this).fadeIn();
                            } else {
                                $(this).fadeOut();
                            }
                        });
                    });
                });
            })(jQuery);
        </script>
        <?php
    }

    function get_field_html($params) {
        $shortcode = $params['base'];
        $content_e = isset($params['content_element']) ? 1 : 0;
        $fields = $params['params'];

        ob_start();
        foreach ($fields as $field):
            $value = isset($field['value']) ? $field['value'] : '';
            ?>
            <div class="field-group <?php echo isset($field['class']) ? $field['class'] : ''; ?>">
                <div class="field-label"><?php echo $field['heading']; ?></div>
                <div class="field-input">
                    <?php
                    switch ($field['type']) {
                        case 'textfield':
                            echo $this->get_text_field($field['param_name'], $value);
                            break;
                        case 'iw_select':
                            echo $this->get_select_field($field['param_name'], $value, $field['data'], $field['multiple'] ? $field['multiple'] : 0, $field['class'] ? $field['class'] : '');
                            break;
                        case 'textarea':
                            echo $this->get_textarea_field($field['param_name'], $value);
                            break;
                        case 'dropdown':
                            if (!$value)
                                $value = array();
                            echo $this->get_dropdown_field($field['param_name'], $value);
                            break;
                        case 'textarea_html':
                            echo $this->get_textareahtml_field($field['param_name'], $value);
                            break;
                        case 'attach_image':
                            echo $this->get_attach_image_field($field['param_name'], $value);
                            break;
                        case 'iconpicker':
                        case 'iw_icon':
                            echo $this->get_icon_field($field['param_name'], $value, $field['class'] ? $field['class'] : '');
                            break;
                        case 'colorpicker':
                            echo $this->get_colorpicker_field($field['param_name'], $value);
                            break;
                        case 'iw_courses_categories':
                            echo $this->get_course_categories_field($field['param_name'], $value);
                            break;
                        case 'iw_range_skillbar':
                            echo $this->get_range_skillbar_field($field['param_name'], $value, $field['class'] ? $field['class'] : '');
                            break;
                        case 'iw_map':
                            echo $this->get_map_field($field['param_name'], $field['value'], $field['class'] ? $field['class'] : '');
                            break;
						case 'iw_profile_info':
                            echo $this->get_profile_info_field($field['param_name'], $value, $field['class'] ? $field['class'] : '');
                            break;
                        default:
                            break;
                    }
                    ?>
                </div>
                <?php if (isset($field['description'])): ?>
                    <div class="field-description"><?php echo $field['description']; ?></div>
                <?php endif; ?>
            </div>
            <?php
        endforeach;
        echo '<input type="hidden" name="shortcode_tag" value="' . $shortcode . '"/>';
        echo '<input type="hidden" name="shortcode_close_tag" value="' . $content_e . '"/>';
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_attach_image_field($fname, $fvalue) {
        if (!is_numeric($fvalue)) {
            $fvalue = null;
        }
        ob_start();
        ?>
        <div class="iw-image-field">
            <div class="image-preview iw-hidden"></div>
            <div class="image-add-image"><span><i class="fa fa-plus"></i></span></div>
        </div>
        <input type="hidden" value="<?php echo $fvalue; ?>" name="<?php echo $fname; ?>" class="iw-field iw-image-field-data"/>
        <div style="clear: both;"></div>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_textareahtml_field($fname, $fvalue) {
        ob_start();
        ?>
        <div class="textarea_html">
            <textarea class="iw-field iw-textarea-html" name="<?php echo $fname; ?>" id="iw-tinymce-<?php echo $fname; ?>"><?php echo $fvalue; ?></textarea>
        </div>
        <script type="text/javascript">
            (function ($) {
                $('.shortcode-content .field-group').ready(function () {
                    var ed = new tinymce.Editor('iw-tinymce-<?php echo $fname; ?>', {
                    }, tinymce.EditorManager);

                    ed.on('change', function (e) {
                        var content = ed.getContent();
                        $('#iw-tinymce-<?php echo $fname; ?>').text(content);
                    });
                    ed.render();
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_course_categories_field($param_name, $value) {
        $product_categories = get_terms('iw_courses_class');
        $output = $selected = $ids = '';
        if ($value !== '') {
            $ids = explode(',', $value);
            $ids = array_map('trim', $ids);
        } else {
            $ids = array();
        }
        ob_start();
        ?>
        <select id="sel2_cat" multiple="multiple" style="min-width:200px;">
            <?php
            foreach ($product_categories as $cat) {
                if (in_array($cat->term_id, $ids)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                echo '<option ' . $selected . ' value="' . $cat->term_id . '">' . $cat->name . '</option>';
            }
            ?>
        </select>

        <input type='hidden' name='<?php echo $param_name; ?>' value='<?php echo $value; ?>' class='iw-field' id='sel_cat'>

        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    //Select 2
                   /* $("#sel2_cat").select2({
                        placeholder: "Select Categories",
                        allowClear: true
                    });
                    */
                    $("#sel2_cat").on("change", function () {
                        $("#sel_cat").val($(this).val());
                    });
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_server_loaction_html($param_name, $value, $class) {
        $markers = json_decode(base64_decode($value));
        $posts = get_posts(array('posts_per_page' => -1));
        ob_start();
        ?>
        <div class="iw-server-location-wrap">
            <div class="controls">
                <span class="button load-image"><?php _e('Load map image', 'inwavethemes'); ?></span>
                <span class="button add-location"><?php _e('Add location', 'inwavethemes'); ?></span>
                <span class="button remove-location disabled"><?php _e('Remove location', 'inwavethemes'); ?></span>
            </div>
            <div class="image-map-preview">
                <div class="image">
                    <?php
                    if ($markers[0]) {
                        $mapimg = wp_get_attachment_image_src($markers[0], 'large');
                        $map_img_src = $mapimg[0];
                    } else {
                        $map_img_src = plugins_url('inwave-common/assets/images/map.png');
                    }
                    ?>
                    <img src="<?php echo $map_img_src; ?>"/>
                    <input type="hidden" value="<?php echo $markers[0] ? $markers[0] : ''; ?>" name="map_image"/>
                </div>
                <div class="map-pickers">
                    <?php
                    if (!empty($markers[1]) && $markers[1]) {
                        foreach ($markers[1] as $marker) {
                            $style = '';
                            $pos = explode('x', $marker[1]);
                            $style = 'left:' . $pos[0] * 100 . '%; top:' . $pos[1] * 100 . '%;';
                            echo '<span data-post="' . $marker[0] . '" data-position="' . $marker[1] . '" class="map-picker" style="' . $style . '"></span>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="iw-tabs accordion location-list hidden">
                <div class="iw-accordion-content">
                    <div class="field-group">
                        <div class="label"><?php _e('Select marker Post', 'inwavethemes'); ?></div>
                        <div class="field">
                            <select id="sel_post" class="sel_post" style="min-width:200px;">
                                <?php
                                echo '<option value="">' . __('Select post', 'inwavethemes') . '</option>';
                                foreach ($posts as $post) {
                                    echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        //Select 2
                        $("#sel_post").select2({
                            placeholder: "Select Post",
                            allowClear: true
                        });
                    });
                })(jQuery);
            </script>
        </div>

        <input type='hidden' name='<?php echo $param_name; ?>' value='<?php echo $value; ?>' class='marker-location-data iw-field <?php echo $class; ?>'>

        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_icon_field($fname, $fvalue, $class) {
        ob_start();
        ?>
        <div class="control-icon">
            <div class="icon-preview" onclick="jQuery('.iw-list-icon-wrap').slideToggle();">
                <span><i class="<?php echo $fvalue; ?>"></i></span>
            </div>
            <div class="icon-filter">
                <input class="filter-input" style="width:49%" onclick="jQuery('.iw-list-icon-wrap').slideDown();" placeholder="<?php echo __('Click to select new or search...', 'inwavethemes'); ?>" type="text"/>
                <select class="filter-input-type" style="width:49%">
                    <option value="">All</option>
                    <option value="fa">FontAwesome</option>
                </select>
            </div>
        </div>
        <div style="clear:both;"></div>
        <div class="iw-list-icon-wrap" style="display:none;">
            <input name="<?php echo $fname; ?>" type="hidden" value="<?php echo $fvalue; ?>" class="iw-icon-input-cs iw-field iw-iw_icon-field <?php echo $class; ?>">
            <div class="list-icon-wrap">
                <ul id="iw-list-icon" class="list-icon">
                    <?php
                    echo $this->get_search_icons_html('', '', $fvalue);
                    ?>
                </ul>
                <div class="ajax-overlay">
                    <span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                </div>
            </div>

        </div>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
                    var xhr = '';
                    var timeout = '';
                    $('.icon-filter .filter-input').on('input', function () {
                        var filterVal = $(this).val();
                        var type = $(this).parent().find('.filter-input-type').val();
                        $('.list-icon-wrap .ajax-overlay').fadeIn();
                        jQuery('.iw-list-icon-wrap').slideDown();
                        if (xhr) {
                            xhr.abort();
                        }
                        clearTimeout(timeout);
                        timeout = setTimeout(function () {
                            xhr = $.ajax({
                                url: iwConfig.ajaxUrl,
                                data: {action: 'search_icons', 'key': filterVal, 'type': type},
                                type: "post",
                                success: function (data) {
                                    $('#iw-list-icon').html(data);
                                    $('.list-icon-wrap .ajax-overlay').fadeOut();
                                }
                            });
                        }, 200);

                    });
                    $('.icon-filter .filter-input-type').on('change', function () {
                        $('.icon-filter .filter-input').trigger('input');
                    })
                    $('.icon-item').live('click', function () {
                        var value = $(this).data('icon');
                        var html = '<span><i class="' + value + '"></i></span>';
                        $('.control-icon .icon-preview').html(html);
                        $('input[name="<?php echo $fname; ?>"]').val(value);
                        $('.icon-item').removeClass('selected');
                        $(this).addClass('selected');
                        $('.iw-list-icon-wrap').slideUp();
                    });
                });
                $('.iw-icon-input-cs').live('change', function () {
                    var value = jQuery(this).val();
                    var html = '<i class="' + value + '"></i>';
                    $('.control-icon .icon-preview').html(html);
                })
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_search_icons_html($type = 'fa', $key = '', $fvalue = '', $limit = 500) {
        $inwave_fonts = array();
        include_once('font-data.php');
        $result = array();
        if ($type) {
            $types = array($type);
        } else {
            $types = array('fa', 'whhg', 'glyphicons');
        }
        $i = 0;
        foreach ($types as $type) {
            foreach ($inwave_fonts[$type] as $icon) {
                if ($key == '' || strpos($icon, $key) !== false) {
                    if ($type == 'fa') {
                        $icon = 'fa fa-' . $icon;
                    } else if ($type == 'whhg') {
                        $icon = 'iwf-' . $icon;
                    } else {
                        $icon = 'glyphicon glyphicon-' . $icon;
                    }
                    $result[] = $icon;
                    $i++;
                }
                if ($i == $limit)
                    break;
            }
            if ($i == $limit)
                break;
        }

        $html = '';
        if (count($result)) {
            $html .= '<li title="No icon" class="icon-item" data-icon=""><span class="icon"><i class=""></i></span></li>';
            foreach ($result as $icon) {

                $html .= '<li class="icon-item ' . ($icon == $fvalue ? 'selected' : '') . '" data-icon="' . $icon . '"><span class="icon"><i class="' . $icon . '"></i></span></li>';
            }
        } else {
            $html .= '<li>Not found</li>';
        }
        return $html;
    }

    function get_colorpicker_field($fname, $fvalue) {
        $html = '<div class="iwcolor-picker color-group"><input type="text" value="' . htmlspecialchars($fvalue) . '" name="' . $fname . '" class="vc_color-control iw-field input-field"></div>';
        $html .= "<script>if(typeof('vc') != undefined) vc.atts.colorpicker.init('','.iwcolor-picker')</script>";

        wp_enqueue_script('wpb_js_composer_js_atts');
        return $html;
    }

    function get_text_field($fname, $fvalue) {
        return '<input type="text" value="' . htmlspecialchars($fvalue) . '" name="' . $fname . '" class="iw-field input-field"/>';
    }

    function get_textarea_field($fname, $fvalue) {
        return '<textarea name="' . $fname . '" class="iw-field textarea-field">' . $fvalue . '</textarea>';
    }

    function get_dropdown_field($fname, $fvalue) {
        $html = '';
        $html .= '<select name="' . $fname . '" class="iw-field dropdown-field">';
        foreach ($fvalue as $text => $value) {
            $html .= '<option value="' . $value . '">' . $text . '</option>';
        }
        $html.='</select>';
        return $html;
    }

    function get_range_skillbar_field($fname, $fvalue, $class) {
        $html = '<input class="skillbar_input iw-field ' . $class . '" value="' . $fvalue . '" type="range" min="0" max="100" step="1" name="' . $fname . '"/>
				<span class="value-view">' . ($fvalue ? $fvalue : 50) . '%</span>
					<script>
						jQuery("input.skillbar_input").on("input", function(){
							jQuery(this).parent().find(".value-view").text(jQuery(this).val() + "%");
						});
					</script>
				';
        return $html;
    }
	
	function get_profile_info_field($fname, $fvalue, $class) {
        ob_start();
        ?>
        <div class="profile_info">
			<div class="profile_lists">
			<?php if($fvalue){
			$arr = explode('||', $fvalue);
			foreach($arr as $k=>$v){
				$profile_info = explode(',',$v);
				?>
				<div class="profile_list_item">
					<label>User's skill name</label>
					<input type="text" class="profile_info_label" value="<?php echo $profile_info[0];?>" name="profile_info[label][]" />
					
					<label>User's skill value (from 1 to 100)</label>
					<input type="number" min="1" max="100" class="profile_info_value" value="<?php echo $profile_info[1];?>" name="profile_info[value][]" />
				</div>
				<?php
			}
			}else{?>
				<div class="profile_list_item">
					<label>User's skill name</label>
					<input type="text" class="profile_info_label" name="profile_info[label][]" />
					
					<label>User's skill value (from 1 to 100)</label>
					<input type="text" class="profile_info_value" name="profile_info[value][]" />
				</div>
				<?php }?>
			</div>
			<input type="hidden" class="profile_input iw-field <?php echo $class;?>" value="<?php echo $fvalue;?>" name = "<?php echo $fname;?>" />
			<button class="addmore"><?php _e("Add more user's skill", 'inwavethemes'); ?></button>
			
        </div>
		<script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
					$('.profile_info .addmore').click(function(){
						var html='<div class="profile_list_item">';
							html+='<label>Profile skill title</label>';
							html+='<input class="profile_info_label" type="text" name="profile_info_label" />';
							html+='<label>Profile skill value</label>';
							html+='<input type="text" class="profile_info_value" name="profile_info_value" />';
							html+='</div>';
							
							$('.profile_info .profile_lists').append(html);
				
					});
					
					$('.profile_info input[type="text"]').live('change', function(){
						var labels = $('.profile_info .profile_info_label'),
							values = $('.profile_info .profile_info_value'),
							new_arr = '';
						for(var i = 0; i < labels.length; i++){
							if(i>0){
								new_arr += '||';
							}
							new_arr += $(labels[i]).val()+','+$(values[i]).val();
						}
						$('.profile_info .profile_input').val(new_arr);
					});
                 });
            })(jQuery);
        </script>
       
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
	}

	function get_iwe_event_field($fname, $fvalue, $class) {
        ob_start();
        $args = array(
            'post_type' => 'iwevent',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );

        $iwevents = get_posts($args);
        ?>
            <select name="<?php echo $fname;?>" class="iw-field <?php echo $class;?>">
                <option><?php echo __('Select Event', 'inwavethemes');?></option>
                <?php
                    foreach($iwevents as $iwevent){
                        ?>
                        <option value="<?php echo $iwevent->ID; ?>" <?php echo $iwevent->ID == $fvalue ? 'selected' : '' ?>><?php echo $iwevent->post_title; ?></option>
                        <?php
                    }
                ?>
            </select>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
	}

    function get_iwe_cateogry_spearker_field($fname, $fvalue, $class) {
        ob_start();
        global $wpdb;
        $categories = $wpdb->get_results('SELECT id, name FROM ' . $wpdb->prefix . 'iwe_speaker_category WHERE status = 1');
        ?>
            <select name="<?php echo $fname;?>" class="iw-field <?php echo $class;?>">
                <option value=""><?php echo __('All Categories'); ?></option>
                <?php
                    foreach($categories as $category){
                        ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $fvalue ? 'selected' : '' ?>><?php echo $category->name; ?></option>
                        <?php
                    }
                ?>
            </select>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
	}

    function get_preview_image_settings_field($fname, $fvalue, $class) {
        ob_start();
        ?>
            <a name="<?php echo $fname; ?>" class="preview-image <?php echo $class;?>" href="#<?php echo $fname; ?>" style="display: inline-block"><img style="max-width: 80px; max-height: 50px" src="<?php echo $fvalue; ?>"></a>
            <img id="<?php echo $fname;?>" style="display: none" src="<?php echo $fvalue; ?>">
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
	}

    function get_map_field($fname, $fvalue, $class) {
        global $inf_settings;
        if ($fvalue) {
            $mapoptions = json_decode($fvalue);
        }
        ob_start();
        ?>
        <div class="infunding-map infuding-map-container">
            <div class="infuding-map-wrap">
                <div class="map-preview" style="height:350px;">
                </div>
            </div>
            <div class="description">
                <ul>
                    <li><?php _e('- Click on map to set map position.', 'inwavethemes'); ?></li>
                    <li><?php _e('- Drag and Drop marker to set map position.', 'inwavethemes'); ?></li>
                    <li><?php _e('- ZoomIn or ZoomOut to change and set map Zoom Level.', 'inwavethemes'); ?></li>
                </ul>
            </div>
            <input type="hidden" value="<?php echo $fvalue; ?>" class="iw-map <?php echo $class; ?>" name="<?php echo $fname; ?>"/>
        </div>
        <script type="text/javascript">
            (function () {
                var mapProperties = {
                    zoom: <?php echo isset($mapoptions->zoomlv) ? $mapoptions->zoomlv : (isset($inf_settings['general']['map_zoom_lever']) ? $inf_settings['general']['map_zoom_lever'] : '8'); ?>,
                    center: new google.maps.LatLng(<?php echo (isset($mapoptions->lat) ? $mapoptions->lat : -33.8665433) . ', ' . (isset($mapoptions->lng) ? $mapoptions->lng : 151.1956316); ?>),
                    zoomControl: true,
                    scrollwheel: true,
                    disableDoubleClickZoom: true,
                    draggable: true,
                    panControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    overviewMapControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                setTimeout(function () {
                    jQuery('.infunding-map').iwMap(mapProperties);
                }, 1000);
            })();
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    function get_select_field($fname, $fvalue, $fdata, $fmulti, $class) {
        $data_value = $fvalue ? explode(',', $fvalue) : array(0);
        ob_start();
        if ($fmulti) {
            $multiselect = 'multiple="multiple"';
            echo '<select id="iw_select" ' . $multiselect . ' style="min-width:200px;">';
        } else {
            echo '<select id="iw_select" style="min-width:200px;">';
        }

        //Duyet qua tung phan tu cua mang du lieu de tao option tuong ung
        foreach ($fdata as $option) {
            if (is_array($data_value)) {
                if (in_array($option['value'], $data_value)) {
                    echo '<option value="' . $option['value'] . '" selected="selected">' . htmlspecialchars($option['text']) . '</option>';
                } else {
                    echo '<option value="' . $option['value'] . '">' . htmlspecialchars($option['text']) . '</option>';
                }
            } else {
                echo '<option value="' . $option['value'] . '" ' . (($option['value'] == $fvalue) ? 'selected="selected"' : '') . '>' . $option['text'] . '</option>';
            }
        }
        echo '</select>';
        echo '<input type="hidden" name="' . $fname . '" id="' . $fname . '" value="' . $fvalue . '" class="iw-field ' . $class . '"/>';
        ?>
        <script type="text/javascript">
            (function ($) {
                $(document).ready(function () {
//                    $("#iw_select").select2({
//                        placeholder: "Select domain type",
//                        allowClear: true
//                    });
                    $("#iw_select").on("change", function () {
                        $("#<?php echo $fname; ?>").val($(this).val());
                    });
                });
            })(jQuery);
        </script>
        <?php
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
	
	//if(!function_exists('margeArray')){
		public function margeArray($array) {
			if (!is_array($array)) {
				return;
			}
			$key_title = $array['key_title'];
			$key_value = $array['key_value'];
			$new_array = array();
			$i = 0;
			foreach ($key_title as $value) {
				$new_array[] = array('key_title' => $value, 'key_value' => $key_value[$i]);
				$i++;
			}
			return $new_array;
		}
	//}
}

new Inwave_Shortcode_Class();
