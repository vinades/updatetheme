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
 * Cập nhật style.responsive.css của giao diện
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Thêm cookie_notice
if (preg_match("/\@media[\s]*\([\s]*max\-width[\s]*\:[\s]*499(\.98)*px[\s]*\)[\s]*\{/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '@media (max-width: 499.98px) {
    .nv-infodie {
        width: 100%;
    }

';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '@media (max-width: 499.98px) {',
        'addafter' => '    .nv-infodie {
        width: 100%;
    }

'
    ));
}
