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
 * Cập nhật users.js
 */

nv_get_update_result('users');
nvUpdateContructItem('users', 'js');

if (preg_match("/\/\/[\s]*Xử[\s]*lý[\s]*các[\s]*trình[\s]*soạn[\s]*thảo(.*?)CKEDITOR\.instances\[c\]\.getData\(\)\)[\s]*\;*/isu", $output_data, $m)) {
    $find = $m[0];
    $replace = '';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('users', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('users', [
        'find' => '    // Xử lý các trình soạn thảo
    if ("undefined" != typeof CKEDITOR)
        for (var c in CKEDITOR.instances) $("#" + c).val(CKEDITOR.instances[c].getData());
',
        'findMessage' => 'Tìm và xóa đoạn'
    ]);
}
