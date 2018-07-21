<?php

/*
 * @package Inwave Charity
 * @version 1.0.0
 * @created Dec 1, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://www.inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

/**
 * Description of taxonomy-infunding_category
 *
 * @developer duongca
 */
if (iwEventGetTemplatePath('taxonomy')) {
    include iwEventGetTemplatePath('taxonomy');
} else {
    echo esc_html__('No file exists', 'motohero');
}
