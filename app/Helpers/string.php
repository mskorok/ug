<?php

function get_max_upload_file_size()
{
    return min(convert_size(ini_get('post_max_size')), convert_size(ini_get('upload_max_filesize')));
}

function format_bytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = ['', 'kb', 'MB', 'GB', 'TB'];

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

function convert_size($sSize)
{
    if ( is_numeric( $sSize) ) {
        return $sSize;
    }
    $sSuffix = substr($sSize, -1);
    $iValue = substr($sSize, 0, -1);
    switch(strtoupper($sSuffix)){
        case 'P':
            $iValue *= 1024;
        case 'T':
            $iValue *= 1024;
        case 'G':
            $iValue *= 1024;
        case 'M':
            $iValue *= 1024;
        case 'K':
            $iValue *= 1024;
            break;
    }
    return $iValue;
}


/**
 * @param $string
 * @return string
 */
function br2p($string)
{
    $string = nl2br(stripTags($string));
    $string = str_replace('<br>\n', '</p><p>', $string);
    $string = str_replace('<br />\n', '</p><p>', $string);
    $string = str_replace('<br>', '</p><p>', $string);
    $string = str_replace('<br />', '</p><p>', $string);
    $html = '<p>'.$string.'</p>';
    return $html;
}

/**
 * @param $string
 * @return string
 */
function stripTags($string)
{
    $tags = '<br><br /><p></p><i></i><b></b><u></u><ul></ul><li></li><img><img /><a></a><strong></strong>';
    return strip_tags($string, $tags);
}
