<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_UPDATETHEME')) {
    die('Stop!!!');
}

/**
 * Cập nhật tpl module news
 */
if (preg_match('/\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<link[^\>]+\{NV\_EDITORSDIR[^\>]+\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<link href="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/highlight/github.min.css" rel="stylesheet">';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        nvUpdateSetItemGuide('news', [
            'find' => '<link href="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor/plugins/codesnippet/lib/highlight/styles/github.css" rel="stylesheet">',
            'replace' => '<link href="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/highlight/github.min.css" rel="stylesheet">'
        ]);
    }

    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<script[^\>]+\{NV\_EDITORSDIR[^\>]+\>[\r\n\s\t]*\<\/script\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/highlight/highlight.min.js"></script>';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        nvUpdateSetItemGuide('news', [
            'find' => '<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_EDITORSDIR}/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>',
            'replace' => '<script type="text/javascript" src="{NV_STATIC_URL}{NV_ASSETS_DIR}/js/highlight/highlight.min.js"></script>'
        ]);
    }
}
