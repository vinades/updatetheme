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

// Thêm CSS cho social share buttons
if (!preg_match('/\.social\-share\-container[\s]*\{/is', $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    $social_share_css = '/* Social share */
.social-share-container {
    display: flex;
    align-items: center;
}

.social-share-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}

.social-share-buttons button {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    color: #fff;
    border: none;
    border-radius: 9999px;
    cursor: pointer;
    line-height: 1;
    font-size: 12px;
}

.social-share-buttons button.social-share-facebook {
    background-color: #1877F2;
}

.social-share-buttons button.social-share-twitter {
    background-color: #1DA1F2;
}

.social-share-label {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-right: 10px;
}';

    if (preg_match('/\.socialList[\s]+li[\s]+a[\s]+\.fa[\s]*\{[^\}]+\}[ \t]*/is', $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n\n" . $social_share_css;
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('base', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        $output_data = rtrim($output_data) . "\n\n" . $social_share_css . "\n";

        nvUpdateSetItemData('base', [
            'status' => 1,
            'find' => '',
            'replace' => $social_share_css
        ]);
    }
}

// Sửa lỗi xung đột ckeditor4: figure margin left/right thành auto
if (preg_match('/figure[\s]*:not\(\.table\):not\(\.media\):not\(\.nv-media\)[\s]*\{[^\}]*margin[\s]*:[\s]*5px[\s]+0[\s]+10px[\s]+0[\s]*;[^\}]*\}/is', $output_data, $m)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    $find = $m[0];
    $replace = preg_replace('/margin[\s]*:[\s]*5px[\s]+0[\s]+10px[\s]+0[\s]*;/i', 'margin: 5px auto 10px auto;', $find);
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} elseif (!preg_match('/figure[\s]*:not\(\.table\):not\(\.media\):not\(\.nv-media\)[\s]*\{/is', $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    nvUpdateSetItemGuide('base', [
        'find' => 'figure:not(.table):not(.media):not(.nv-media) {
    position: relative;
    margin: 5px 0 10px 0;
    text-align: center;
}',
        'replace' => 'figure:not(.table):not(.media):not(.nv-media) {
    position: relative;
    margin: 5px auto 10px auto;
    text-align: center;
}'
    ]);
}

// Sửa lỗi xung đột ckeditor4: image-style-block-align thêm !important
if (
    preg_match('/\.image\-style\-block\-align\-right[\s]*\{[^\}]+\}[\r\n\s\t]*\.image\-style\-block\-align\-left[\s]*\{[^\}]+\}/is', $output_data, $m)
    && !preg_match('/\.image\-style\-block\-align\-right[\s]*\{[^\}]+\!important/is', $output_data)
) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    $find = $m[0];
    $replace = '.image-style-block-align-right {
    margin-right: 0 !important;
    margin-left: auto !important;
}

.image-style-block-align-left {
    margin-left: 0 !important;
    margin-right: auto !important;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} elseif (!preg_match('/\.image\-style\-block\-align\-right[\s]*\{/is', $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    nvUpdateSetItemGuide('base', [
        'find' => '.image-style-block-align-right {
    margin-right: 0;
    margin-left: auto;
}

.image-style-block-align-left {
    margin-left: 0;
    margin-right: auto;
}',
        'replace' => '.image-style-block-align-right {
    margin-right: 0 !important;
    margin-left: auto !important;
}

.image-style-block-align-left {
    margin-left: 0 !important;
    margin-right: auto !important;
}'
    ]);
}
