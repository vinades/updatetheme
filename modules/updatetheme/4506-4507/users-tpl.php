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
 * Cập nhật tpl module users
 */
if (preg_match('/\/lostpass_form\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/[\r\n\s\t]*\<input[^\>]+name[\s]*\=[\s]*(\'|\")[\s]*gcaptcha\_session[\s]*(\'|\")[^\>]+\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = "";
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('users', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        nvUpdateSetItemGuide('users', [
            'findMessage' => 'Tìm và xóa dòng',
            'find' => '                        <input type="hidden" value="" name="gcaptcha_session"/>',
        ]);
    }

    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<input[^\>]+name[\s]*\=[\s]*(\'|\")[\s]*checkss[\s]*(\'|\")[^\>]+\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '            <input type="hidden" value="" name="gcaptcha_session"/>';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('users', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        nvUpdateSetItemGuide('users', [
            'find' => '             <input type="hidden" name="checkss" value="{DATA.checkss}" />',
            'addafter' => '            <input type="hidden" value="" name="gcaptcha_session"/>',
        ]);
    }
}
