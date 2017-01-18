<?php
namespace Library\Helpers;

function safeText($text)
{
    return addslashes(htmlspecialchars(chop($text)));
}

function checkEmailFormat($e)
{
    return (bool) preg_match("`^[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$`i", trim($e));
}

function slugify($text)
{
    // replace special letters by normal
    $text = str_replace(
        array('ě', 'é', 'Ě', 'É', 'č', 'Č', 'í', 'Í', 'š', 'Š', 'ž', 'Ž', 'ř', 'Ř', 'á', 'Á'),
        array('e', 'e', 'E', 'E', 'c', 'C', 'i', 'I', 's', 'S', 'z', 'Z', 'r', 'R', 'a', 'A'),
        $text
    );
    
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return '';
    }

    return $text;
}

function getGPSFromString($string)
{
    $return['N'] = '';
    $return['E'] = '';
    
    if (strlen($string) < 3) {
        return false;
    }
    $string = str_replace(' ', '', $string);
    $dimensions = explode(',', $string);
    
    if (count($dimensions) == 2) {
        $i = 0;
        foreach ($dimensions as $dimension) {
            if (substr($dimension, -1) == 'N') {
                $return['N'] = substr($dimension, 0, -1);
            } else if (substr($dimension, -1) == 'E') {
                $return['E'] = substr($dimension, 0, -1);
            } else if ($dimension[0] == 'N') {
                $return['N'] = substr($dimension, 1);
            } else if ($dimension[0] == 'E') {
                $return['E'] = substr($dimension, 1);
            } else {
                if ($i == 0) {
                    $return['N'] = $dimension;
                } else if ($i == 1) {
                    $return['E'] = $dimension;
                }
            }
            $i++;
        }
    }
    if ($return['N'] == '' || $return['E'] == '') {
        return false;
    }
    
    print_r($return);
    return $return;
}