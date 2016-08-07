<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function PHP_INIT() {
//    $matches = array();
//    // Check memory
//    $memory_limit = ini_get('memory_limit');
//    if (eregi('([0-9]+)M', $memory_limit, $matches)) {
//        // could be stored as "16M" rather than 16777216 for example
//        $memory_limit = $matches[1] * 1048576;
//    }
//    if ($memory_limit <= 0) {
//        echo 'memory limits probably disabled';
//        return false;
//    } elseif ($memory_limit <= 3145728) {
//        echo 'PHP has less than 3MB available memory and will very likely run out. Increase memory_limit in php.ini';
//        return false;
//    } elseif ($memory_limit <= 12582912) {
//        echo 'PHP has less than 12MB available memory and might run out if all modules are loaded. Increase memory_limit in php.ini';
//        return false;
//    }
//
//    // Check safe_mode off
//    if ((bool) ini_get('safe_mode')) {
//        echo 'WARNING: Safe mode is on, shorten support disabled, md5data/sha1data for ogg vorbis disabled, ogg vorbos/flac tag writing disabled.';
//        return false;
//    }
    return true;
}
