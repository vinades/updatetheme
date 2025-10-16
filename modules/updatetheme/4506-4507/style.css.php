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
 * Cập nhật style.css của giao diện
 */

// Thêm biến z-index cho ckeditor5
nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

if (preg_match('/\-\-nv\-font\-size\-xxl\:[\s]*22[\s]*px[\s]*\;/is', $output_data, $m)) {
    $find = $m[0];
    $replace = $m[0] . "\n    --ck-z-default: 100;
    --ck-z-panel: calc(var(--ck-z-default) + 999);";

    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('base', [
        'find' => '    --nv-font-size-xxl: 22px;',
        'addafter' => '    --ck-z-default: 100;
    --ck-z-panel: calc(var(--ck-z-default) + 999);'
    ]);
}

// CSS cho nội dung soạn thảo
nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

if (preg_match('/\:root[\s]*\{[^\}]+\}[\r\n\s\t]*/is', $output_data, $m)) {
    $find = $m[0];
    $replace = $m[0] . '.ck {
    --ck-content-font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    --ck-content-font-size: 13px;
    --ck-content-font-color: #333;
    --ck-content-line-height: 1.42857143;
}

';

    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('base', [
        'find' => ':root { .... }',
        'addafter' => '
.ck {
    --ck-content-font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    --ck-content-font-size: 13px;
    --ck-content-font-color: #333;
    --ck-content-line-height: 1.42857143;
}'
    ]);
}

// Chỉnh sửa thẻ figure
nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

if (preg_match('/figure[\s]*\{[^\}]+text\-align[\s]*\:[\s]*center[^\}]+\}/is', $output_data, $m)) {
    $find = $m[0];
    $replace = str_replace('figure', 'figure:not(.table):not(.media):not(.nv-media)', $find);

    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('base', [
        'find' => 'figure { .... }',
        'replaceMessage' => 'Nếu bên trong dấu ... có text-align: center; thì sửa figure { thành',
        'replace' => 'figure:not(.table):not(.media):not(.nv-media) {'
    ]);
}

// Bổ sung css cho ckeditor5
nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

if (preg_match('/\.text\-huge[\s]*\{[^\}]+\}[\r\n\s\t]*/is', $output_data, $m)) {
    $find = $m[0];
    $replace = $m[0] . '/* NV Iframe */
.nvck-iframe {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
}

.nvck-iframe>.nvck-iframe-inner>.nvck-iframe-element {
    border: none;
    margin: 0 auto;
    display: block;
}

.nvck-iframe.nvck-iframe-responsive {
    height: 0;
}

.nvck-iframe.nvck-iframe-responsive>.nvck-iframe-inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.nvck-iframe.nvck-iframe-responsive>.nvck-iframe-inner>.nvck-iframe-element {
    width: 100%;
    height: 100%;
}

/* NV Docs */
.nvck-docs {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
}

.nvck-docs>.nvck-docs-inner>.nvck-docs-element {
    border: none;
    margin: 0 auto;
    display: block;
}

.nvck-docs.nvck-docs-responsive {
    height: 0;
}

.nvck-docs.nvck-docs-responsive>.nvck-docs-inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.nvck-docs.nvck-docs-responsive>.nvck-docs-inner>.nvck-docs-element {
    width: 100%;
    height: 100%;
}

';

    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('base', [
        'find' => '.text-huge {
    font-size: var(--nv-font-size-xxl);
}

',
        'addafter' => '/* NV Iframe */
.nvck-iframe {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
}

.nvck-iframe>.nvck-iframe-inner>.nvck-iframe-element {
    border: none;
    margin: 0 auto;
    display: block;
}

.nvck-iframe.nvck-iframe-responsive {
    height: 0;
}

.nvck-iframe.nvck-iframe-responsive>.nvck-iframe-inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.nvck-iframe.nvck-iframe-responsive>.nvck-iframe-inner>.nvck-iframe-element {
    width: 100%;
    height: 100%;
}

/* NV Docs */
.nvck-docs {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
}

.nvck-docs>.nvck-docs-inner>.nvck-docs-element {
    border: none;
    margin: 0 auto;
    display: block;
}

.nvck-docs.nvck-docs-responsive {
    height: 0;
}

.nvck-docs.nvck-docs-responsive>.nvck-docs-inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.nvck-docs.nvck-docs-responsive>.nvck-docs-inner>.nvck-docs-element {
    width: 100%;
    height: 100%;
}

'
    ]);
}
