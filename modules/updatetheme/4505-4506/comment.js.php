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

if (preg_match("/CKEDITOR\.instances\[(\'|\")commentcontent(\'|\")\]\.setData\(([^\{]+)\{(.*?)\}[\s]*\)/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'window.nveditor[\'commentcontent\'].setData(\'\');
        $(\'#commentcontent\').val(\'\');';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('comment', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('comment', [
        'find' => '        CKEDITOR.instances[\'commentcontent\'].setData(\'\', function() {
            this.updateElement()
        })',
        'replace' => '        window.nveditor[\'commentcontent\'].setData(\'\');
        $(\'#commentcontent\').val(\'\');'
    ]);
}

nv_get_update_result('comment');
nvUpdateContructItem('comment', 'js');

if (preg_match("/CKEDITOR\.instances\[(\'|\")commentcontent(\'|\")\]\.insertText([^\)]+)\)[ \t]*\;*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'window.nveditor[\'commentcontent\'].model.change(() => {
                window.nveditor[\'commentcontent\'].model.insertContent(window.nveditor[\'commentcontent\'].data.toModel(window.nveditor[\'commentcontent\'].data.processor.toView("@" + post_name + "&nbsp;")), window.nveditor[\'commentcontent\'].model.document.selection);
            });
            window.nveditor[\'commentcontent\'].editing.view.focus();';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('comment', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('comment', [
        'find' => '            CKEDITOR.instances[\'commentcontent\'].insertText("@" + post_name + " ");',
        'replace' => '            window.nveditor[\'commentcontent\'].model.change(() => {
                window.nveditor[\'commentcontent\'].model.insertContent(window.nveditor[\'commentcontent\'].data.toModel(window.nveditor[\'commentcontent\'].data.processor.toView("@" + post_name + "&nbsp;")), window.nveditor[\'commentcontent\'].model.document.selection);
            });
            window.nveditor[\'commentcontent\'].editing.view.focus();'
    ]);
}

nv_get_update_result('comment');
nvUpdateContructItem('comment', 'js');

if (preg_match("/CKEDITOR\.instances\[(\'|\")commentcontent(\'|\")\]\.updateElement\([\s]*\)[ \t]*\;*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '$(\'#commentcontent\').val(window.nveditor[\'commentcontent\'].getData());';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('comment', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('comment', [
        'find' => 'CKEDITOR.instances[\'commentcontent\'].updateElement()',
        'replace' => '$(\'#commentcontent\').val(window.nveditor[\'commentcontent\'].getData());'
    ]);
}

nv_get_update_result('comment');
nvUpdateContructItem('comment', 'js');

if (preg_match("/CKEDITOR\.instances\[(\'|\")commentcontent(\'|\")\]\.on\([\s]*(\'|\")key(\'|\")(.*?)\}[\s]*\)[ \t]*\;*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'window.nveditor["commentcontent"].editing.view.document.on(\'keydown\', (event, data) => {
                if (data.ctrlKey && data.keyCode == 13) {
                    commentform.submit();
                }
            });';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('comment', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('comment', [
        'find' => '            CKEDITOR.instances[\'commentcontent\'].on(\'key\', function(event) {
                if (event.data.keyCode === 1114125) {
                    commentform.submit()
                }
            });',
        'replace' => '            window.nveditor["commentcontent"].editing.view.document.on(\'keydown\', (event, data) => {
                if (data.ctrlKey && data.keyCode == 13) {
                    commentform.submit();
                }
            });'
    ]);
}
