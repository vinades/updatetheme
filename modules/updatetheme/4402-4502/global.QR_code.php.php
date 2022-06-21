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
 * Cập nhật block global.QR_code.php
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'php');

// Xóa hàm nv_block_qr_code_config
if (preg_match("/(?:(\/\*\*[\r\n\s\t]*\*[\s]*nv_block_qr_code_config(.*)\*\/)*)[\r\n\s\t]*function[\s]+nv_block_qr_code_config(.*?)return[\s]*\\\$html[\s]*\;[\r\n\s\t]*\}[\r\n\s\t]*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm và xóa',
        'find' => 'Hàm nv_block_qr_code_config',
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'php');

// Xóa hàm nv_block_qr_code_config_submit
if (preg_match("/(?:(\/\*\*[\r\n\s\t]*\*[\s]*nv_block_qr_code_config_submit(.*)\*\/)*)[\r\n\s\t]*function[\s]+nv_block_qr_code_config_submit(.*?)return[\s]*\\\$return[\s]*\;[\r\n\s\t]*\}[\r\n\s\t]*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm và xóa',
        'find' => 'Hàm nv_block_qr_code_config',
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'php');

if (preg_match("/\\\$block_config[\s]*\[[\s]*(\"|')selfurl(\"|')[\s]*\][\s]*\=[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'str_starts_with($current_page_url, NV_MY_DOMAIN) && $current_page_url = substr($current_page_url, strlen(NV_MY_DOMAIN));
        $block_config[\'selfurl\'] = NV_MY_DOMAIN . nv_url_rewrite($current_page_url, true);';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '$block_config[\'selfurl\'] = NV_MAIN_DOMAIN . nv_url_rewrite($current_page_url, true);',
        'replace' => 'str_starts_with($current_page_url, NV_MY_DOMAIN) && $current_page_url = substr($current_page_url, strlen(NV_MY_DOMAIN));
        $block_config[\'selfurl\'] = NV_MY_DOMAIN . nv_url_rewrite($current_page_url, true);',
    ));
}
