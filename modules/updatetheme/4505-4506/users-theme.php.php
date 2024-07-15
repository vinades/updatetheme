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
 * Cập nhật theme.php module users
 */

nv_get_update_result('users');
nvUpdateContructItem('users', 'php');

if (preg_match("/if[\s]*\([\s]*defined[\s]*\([\s]*(\"|\')CKEDITOR(\"|\')[\s]*\)[\s]*\)[\s]*\{([^\}]+)\}[\r\n\s\t]*/is", $output_data, $m)) {
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
        'findMessage' => 'Tìm và xóa',
        'find' => '        if (defined(\'CKEDITOR\')) {
            $xtpl->parse(\'main.tab_edit_others.ckeditor\');
        }
',
    ]);
}
