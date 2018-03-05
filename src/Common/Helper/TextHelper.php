<?php

namespace App\Common\Helper;

setlocale(LC_ALL, 'en_US.UTF-8');

/**
 * Created by PhpStorm.
 * User: stephanesok
 * Date: 05/03/2018
 * Time: 10:47
 */
class TextHelper
{
    /**
     * @param $text
     * @return null|string
     */
    public static function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return null;
        }

        return $text;
    }
}