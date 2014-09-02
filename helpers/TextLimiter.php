<?php

namespace app\helpers;

class TextLimiter{
	public static function limitByChar($string, $limit){
		return str_replace("\n", ' ', substr($string, 0, $limit) . (strlen($string) > $limit ? "..." : ''));
	}

	public static function limitByWords($string, $limit){
		$overflow = true;

        $array = explode(" ", $string);

        $output = '';

        for ($i = 0; $i < $limit; $i++) {

            if (isset($array[$i])) $output .= $array[$i] . " ";
            else $overflow = false;
        }

        return str_replace("\n", ' ', trim($output) . ($overflow ? "..." : ''));
	}
}