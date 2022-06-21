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
 * Cập nhật block global.QR_code.tpl
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'html');

// Xóa hàm nv_block_qr_code_config
if (preg_match("/[\s]*data\-level[\s]*\=(.*?)QRCODE\.outer_frame[\s]*\}(\"|')/is", $output_data, $m)) {
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
        'find' => ' data-level="{QRCODE.level}" data-ppp="{QRCODE.pixel_per_point}" data-of="{QRCODE.outer_frame}"',
    ));
}
