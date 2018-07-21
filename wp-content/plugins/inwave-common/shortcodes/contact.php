<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 31, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of iw_contact
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Contact')) {

    class Inwave_Contact extends Inwave_Shortcode
    {
        protected $name = 'inwave_contact';

        function __construct()
        {
            parent::__construct();
            add_action('wp_ajax_nopriv_sendMessageContact', array($this, 'sendMessageContact'));
            add_action('wp_ajax_sendMessageContact', array($this, 'sendMessageContact'));
        }

        function init_params()
        {
            return array(
                'name' => __("Contact Form", 'inwavethemes'),
                'description' => __('Show contact form', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "heading" => __("Button text", "inwavethemes"),
                        "value" => "",
                        "param_name" => "button_text"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show name", "inwavethemes"),
                        "param_name" => "show_name",
                        "description" => __("Show name field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show email", "inwavethemes"),
                        "param_name" => "show_email",
                        "description" => __("Show email field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show title", "inwavethemes"),
                        "param_name" => "show_title",
                        "description" => __("Show title field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show message", "inwavethemes"),
                        "param_name" => "show_message",
                        "description" => __("Show message field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
					array(
                        "type" => "dropdown",
                        "heading" => __("Show captcha", "inwavethemes"),
                        "param_name" => "show_captcha",
                        "description" => __("Show captach field", 'inwavethemes'),
                        "value" => array(
                            'Yes' => 'yes',
                            'No' => 'no',
                        ),
                    ),
					array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Receiver Email", "inwavethemes"),
                        "value" => "",
                        "param_name" => "receiver_email",
                        "description" => __('If not specified, Admin E-mail Address in General setting will be used', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Default" => "style1",
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null)
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $button_text = $show_name = $show_email = $show_title = $show_message = $style = $class = '';
            extract(shortcode_atts(array(
                'button_text' => '',
                'show_name' => 'yes',
                'show_email' => 'yes',
                'show_title' => 'yes',
                'show_message' => 'yes',
				'show_captcha' => 'yes',
                'style' => 'style1',
				'receiver_email' => '',
                'class' => ''
            ), $atts));
            ob_start();
            switch ($style) {
                case 'style1':
                ?>
                    <div class="iw-contact iw-contact-us <?php echo $class; ?>">
                        <div class="ajax-overlay">
                            <span class="ajax-loading"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                        </div>
                        <div class="headding-bottom"></div>
                        <form method="post" name="contact-form">
                            <div class="row">
                                <?php if ($show_name == 'yes'): ?>
                                    <div class="form-group col-md-4 col-md-6 col-xs-12">
                                        <input type="text" placeholder="<?php echo __('Your Name', 'inwavethemes'); ?>"
                                               required="required" class="control" name="name">
                                    </div>
                                <?php
                                endif;
                                if ($show_email == 'yes'):
                                    ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <input type="email" placeholder="<?php echo __('Email Address', 'inwavethemes'); ?>"
                                               required="required" class="control" name="email">
                                    </div>
                                <?php
                                endif;
                                if ($show_title == 'yes'):
                                    ?>
                                    <div class="form-group col-md-4 col-sm-6 col-xs-12">
                                        <input type="text" placeholder="<?php echo __('Title', 'inwavethemes'); ?>"
                                               required="required" class="control" name="title">
                                    </div>
                                <?php
                                endif;
                                if ($show_message == 'yes'):
                                    ?>
                                    <div class="form-group col-xs-12">
                                        <textarea placeholder="<?php echo __('Type Message', 'inwavethemes'); ?>" rows="8"
                                                  class="control" required="required" id="message" name="message"></textarea>
                                    </div>
                                <?php endif; ?>
								<?php if ($show_captcha == 'yes'):
								$rand_captcha = $this->getCaptchaCode();
                                    ?>
                                    <div class="form-group col-xs-12 capcha-group">
                                        <input required="required" placeholder="<?php echo __('Captcha', 'inwavethemes'); ?>" name="captcha" value="" class="captcha"/> 
                                        <label data-value="<?php echo $rand_captcha; ?>" class="captcha-view"><?php echo $rand_captcha; ?></label>
                                        <span class="reload-captcha"><i class="fa fa-spin"></i></span>
                                    </div>
                                    <style>
                                        .iw-contact input.captcha{width: 200px;}
                                        .iw-contact .captcha-view{background:url("http://4.bp.blogspot.com/-EEMSa_GTgIo/UpAgBQaE6-I/AAAAAAAACUE/jdcxZVXelzA/s1600/ca.png") repeat center center scroll; color:#ff0000; font-size:18px; height:45px; line-height:43px;padding:0 30px; margin:0 15px;}
                                    </style>
                                <?php endif; ?>
                                <div class="form-group form-submit col-xs-12">
                                    <input name="action" type="hidden" value="sendMessageContact">
                                    <input name="mailto" type="hidden" value="<?php echo $receiver_email; ?>">

                                    <div class="button-submit">
                                        <button class="btn-submit theme-bg button-effect3" name="submit"
                                                type="submit"><i class="fa fa-envelope"></i><span class="button-text" data-hover="<?php echo $button_text? $button_text: __('SEND MESSAGE', 'inwavethemes'); ?>"><?php echo $button_text? $button_text: __('SEND MESSAGE', 'inwavethemes'); ?></span></button>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 form-message"></div>
                            </div>
                        </form>

                    </div>
                    <?php
                    break;
            }
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
		
		function getCaptchaCode() {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        //Ajax iwcSendMailTakeCourse
        function sendMessageContact()
        {
            $result = array();
            $result['success'] = false;
            $mailto = isset($_POST['mailto'])? $_POST['mailto'] : '';
            if(!$mailto){
                $mailto = get_option('admin_email');
            }
            $email = isset($_POST['email'])? $_POST['email'] : '';
            $name = isset($_POST['name'])? $_POST['name'] : '';
            $mobile = isset($_POST['mobile'])? $_POST['mobile'] : '';
            $website = isset($_POST['website'])? $_POST['website'] : '';
            $message = isset($_POST['message'])? $_POST['message'] : '';
            $title = __('Email from Contact Form', 'inwavethemes') . ' ['. $email.']';

            $html = '<html><head><title>' . $title . '</title>
                    </head><body><p>' . __('Hi Admin,', 'inwavethemes') . '</p><p>' . __('This email was sent from contact form', 'inwavethemes') . '</p><table>';

            if ($name) {
                $html .= '<tr><td>' . __('Name', 'inwavethemes') . '</td><td>' . $name . '</td></tr>';
            }
            if ($email) {
                $html .= '<tr><td>' . __('Email', 'inwavethemes') . '</td><td>' . $email . '</td></tr>';
            }
            if ($mobile) {
                $html .= '<tr><td>' . __('Mobile', 'inwavethemes') . '</td><td>' . $mobile . '</td></tr>';
            }
            if ($website) {
                $html .= '<tr><td>' . __('Website', 'inwavethemes') . '</td><td>' . $website . '</td></tr>';
            }
            if ($message) {
                $html .= '<tr><td>' . __('Message', 'inwavethemes') . '</td><td>' . $message . '</td></tr>';
            }
            $html .= '</tr></table></body></html>';

            // To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if (wp_mail($mailto, $title, $html, $headers)) {
                $result['success'] = true;
                $result['message'] = __('Your message was sent, we will contact you soon', 'inwavethemes');
            } else {
                $result['message'] = __('Can\'t send message, please try again', 'inwavethemes');
            }
            echo json_encode($result);
            exit();
        }
    }
}

new Inwave_Contact();

