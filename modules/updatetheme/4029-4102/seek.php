<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 09 Jan 2014 10:18:48 GMT
 */

if (!defined('NV_IS_MOD_UPDATETHEME'))
    die('Stop!!!');

if (preg_match('/seek\/form\.tpl$/', $file)) {
    nv_get_update_result('seek');
    nvUpdateContructItem('seek', 'html');
    
    if (preg_match("/http\:\/\/www\.google\.com\/jsapi/", $output_data, $m)) {
        $find = $m[0];
        $replace = '//www.google.com/jsapi';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('seek', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('seek', array(
            'find' => '        	<script src="http://www.google.com/jsapi" type="text/javascript"></script>',
            'replace' => '        	<script src="//www.google.com/jsapi" type="text/javascript"></script>'
        ));
    }
    
    nvUpdateContructItem('seek', 'html');
    
    if (preg_match("/http\:\/\/www\.google\.com\/cse\/style\/look\/default\.css/", $output_data, $m)) {
        $find = $m[0];
        $replace = '//www.google.com/cse/style/look/default.css';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('seek', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('seek', array(
            'find' => '        	<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />',
            'replace' => '        	<link rel="stylesheet" href="//www.google.com/cse/style/look/default.css" type="text/css" />'
        ));
    }
} elseif (preg_match('/seek\/theme\.php$/', $file)) {
    nv_get_update_result('seek');
    $output_data = replaceModuleFileInTheme($output_data, 'seek');
}
