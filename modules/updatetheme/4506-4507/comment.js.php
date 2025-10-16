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
 * Cập nhật comment.js
 */

nv_get_update_result('comment');
nvUpdateContructItem('comment', 'js');

if (preg_match("/if[\s]*\([\s]*data\.editor[\s]*\)[\s]*\{[^\}]+window[^\}]+\}[\r\n\s\t]*\}[\s]*\)[\s]*\;[\r\n\s\t]*\}[\s]*else[\s]*\{/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'if (!data.editor) {';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('comment', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('comment', [
        'find' => '        if (data.editor) {
            window.nveditor["commentcontent"].editing.view.document.on(\'keydown\', (event, data) => {
                if (data.ctrlKey && data.keyCode == 13) {
                    commentform.submit();
                }
            });
        } else {',
        'replace' => '        if (!data.editor) {'
    ]);
}
