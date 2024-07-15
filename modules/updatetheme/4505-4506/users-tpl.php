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
if (preg_match('/\/info\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/[\r\n\s\t]*\<\!\-\-[\s]*BEGIN\:[\s]*ckeditor[\s]*\-\-\>(.*?)\<\!\-\-[\s]*END\:[\s]*ckeditor[\s]*\-\-\>/is", $output_data, $m)) {
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
            'find' => '            <!-- BEGIN: ckeditor --><script>for(var i in CKEDITOR.instances){CKEDITOR.instances[i].on(\'change\',function(){CKEDITOR.instances[i].updateElement()})}</script><!-- END: ckeditor -->'
        ]);
    }
}
