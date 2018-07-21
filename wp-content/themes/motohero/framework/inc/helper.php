<?php

/**
 * Created by PhpStorm.
 * User: Inwavethemes
 * Date: 4/7/2015
 * Time: 8:58 AM
 */
class Inwave_Helper
{
    /**
     * CUT STRING BY CHARACTERS FUNCTION
     * @param $text
     * @param int $length
     * @param string $replacer
     * @param bool $isStrips
     * @param string $stringtags
     * @return string
     */
    public static function substring($text, $length = 100, $isStrips = false, $replacer = '...', $stringtags = '')
    {

        if ($isStrips) {
            $text = preg_replace('/\<p.*\>/Us', '', $text);
            $text = str_replace('</p>', '<br/>', $text);
            $text = strip_tags($text, $stringtags);
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen($text) < $length) return $text;
            $text = mb_substr($text, 0, $length);
        } else {
            if (strlen($text) < $length) return $text;
            $text = substr($text, 0, $length);
        }

        return $text . $replacer;
    }

    /**
     * CUT STRING BY WORDS FUNCTION
     * @param $text
     * @param int $length
     * @param string $replacer
     * @param bool $isStrips
     * @param string $stringtags
     * @return string
     */
    public static function substrword($text, $length = 100, $isStrips = false, $replacer = '...', $stringtags = '')
    {
        if ($isStrips) {
            $text = preg_replace('/\<p.*\>/Us', '', $text);
            $text = str_replace('</p>', '<br/>', $text);
            $text = strip_tags($text, $stringtags);
        }
        $tmp = explode(" ", $text);

        if (count($tmp) < $length)
            return $text;

        $text = implode(" ", array_slice($tmp, 0, $length)) . $replacer;

        return $text;
    }

    public static function getConfig($type = '')
    {
        global $inwave_post_option, $inwave_theme_option;
        if ($type == 'smof') {
            return $inwave_theme_option;
        }
        return $inwave_post_option;
    }

    public static function setConfig($config, $type = '')
    {
        global $inwave_post_option, $inwave_theme_option;
        if ($type == 'smof') {
            $inwave_theme_option = $config;
        } else {
            $inwave_post_option = $config;
        }
    }

    public static function getAuthorData()
    {
        global $authordata;
        return $authordata;
    }

    public static function getRevoSlider()
    {
        global $wpdb;
        $sliders = array(
            '' => 'No Slider'
        );
        if (class_exists('RevSlider')) {
            
            // safe query: no input data
            $rs = $wpdb->get_results(
                "
            SELECT alias, title
            FROM " . $wpdb->prefix . "revslider_sliders
            ORDER BY title ASC LIMIT 100
            "
            );

            if ($rs) {
                foreach ($rs as $slider) {
                    $sliders[$slider->alias] = $slider->title;
                }
            }

        }
        return $sliders;
    }
}