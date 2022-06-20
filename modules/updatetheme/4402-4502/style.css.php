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

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Thêm cookie_notice
if (preg_match("/\@font\-face[\s]*\{[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '@font-face {
    font-family: \'NukeVietIcons\';
    src: url(\'../fonts/NukeVietIcons.woff2\') format(\'woff2\'),
        url(\'../fonts/NukeVietIcons.woff\') format(\'woff\'),
        url(\'../fonts/NukeVietIcons.ttf\') format(\'truetype\'),
        url(\'../fonts/NukeVietIcons.svg\') format(\'svg\');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '@font-face {
    font-family:\'NukeVietIcons\';
    src:url(\'../../default/fonts/NukeVietIcons.eot?avyewf\');
    src:url(\'../../default/fonts/NukeVietIcons.eot?#iefixavyewf\') format(\'embedded-opentype\'),url(\'../../default/fonts/NukeVietIcons.ttf?avyewf\') format(\'truetype\'),url(\'../../default/fonts/NukeVietIcons.woff?avyewf\') format(\'woff\'),url(\'../../default/fonts/NukeVietIcons.svg?avyewf#NukeVietIcons\') format(\'svg\');
    font-weight:normal;
    font-style:normal;
}',
        'replace' => '@font-face {
    font-family: \'NukeVietIcons\';
    src: url(\'../fonts/NukeVietIcons.woff2\') format(\'woff2\'),
        url(\'../fonts/NukeVietIcons.woff\') format(\'woff\'),
        url(\'../fonts/NukeVietIcons.ttf\') format(\'truetype\'),
        url(\'../fonts/NukeVietIcons.svg\') format(\'svg\');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Đổi centered
if (preg_match("/\.centered[\s]*\{[^\}]+\}[\r\n\s\t]*\.centered[\s]*\>[\s]*div[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '.centered {
    display: flex;
    justify-content: center;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '.centered {
   text-align: center;
   font-size: 0
}
.centered > div {
   float: none;
   display: inline-block;
   text-align: left;
   font-size: 14px;
}',
        'replace' => '.centered {
    display: flex;
    justify-content: center;
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Xóa guestBlock
if (preg_match("/\/\*[\s]*guestBlock[\s]*\*\/(.*?)\.guestBlock[\s]*\>[\s]*h3[\s]*\>[\s]*a\.current[^\}]+\}[\r\n\s\t]*/is", $output_data, $m)) {
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
        'find' => '/* guestBlock */

.guestBlock {
    width:350px;
}

.guestBlock > h3 {
    border-bottom-width :1px;
    border-bottom-style: solid;
    border-bottom-color: #cccccc;
}

.guestBlock > h3 > a {
    display:inline-block;
    line-height:34px;
    padding:0 17px;
    background-color:#e5e5e5;
    border-top-right-radius:5px;
    border-top-left-radius:5px;
}

.guestBlock > h3 > a:hover,
.guestBlock > h3 > a.current {
    background-color:#cccccc;
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Thêm grecaptcha-badge
if (preg_match("/\.nv\-recaptcha\-compact[\s]*\{[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '.nv-recaptcha-compact {
    margin: 0 auto;
    width: 164px;
    height: 144px;
}

.grecaptcha-badge {
    visibility: hidden;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '.nv-recaptcha-compact {
    margin: 0 auto;
    width: 164px;
    height: 144px;
}',
        'addafter' => '
.grecaptcha-badge {
    visibility: hidden;
}'
    ));
}

$output_data = rtrim($output_data);

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

$output_data .= '

/*cookie-notice popup*/
.cookie-notice {
    position:fixed;
    bottom: 20px;
    left: 20px;
    width: 350px;
    z-index:99999999999999;
    background-color: #eee;
    border: solid 1px #dedede;
    border-radius: 4px;
    box-shadow:0 0 4px rgba(0,0,0,0.15);
}

.cookie-notice a {
    color: #1a3f5e;
    text-decoration: underline;
}

.cookie-notice div {
    position: relative;
    width: 100%;
    padding: 20px;
    color: #333;
}

.cookie-notice button {
    float: right;
    margin-top: -20px;
    margin-right: -20px;
    margin-left: 10px;
    margin-bottom: 10px;
    width: 40px;
    height: 40px;
    border: 0;
    font-size: 24px;
}
';

nvUpdateSetItemData('base', array(
    'status' => 1,
    'find' => 'Dòng cuối cùng trống của file',
    'replace' => '/*cookie-notice popup*/
.cookie-notice {
    position:fixed;
    bottom: 20px;
    left: 20px;
    width: 350px;
    z-index:99999999999999;
    background-color: #eee;
    border: solid 1px #dedede;
    border-radius: 4px;
    box-shadow:0 0 4px rgba(0,0,0,0.15);
}

.cookie-notice a {
    color: #1a3f5e;
    text-decoration: underline;
}

.cookie-notice div {
    position: relative;
    width: 100%;
    padding: 20px;
    color: #333;
}

.cookie-notice button {
    float: right;
    margin-top: -20px;
    margin-right: -20px;
    margin-left: 10px;
    margin-bottom: 10px;
    width: 40px;
    height: 40px;
    border: 0;
    font-size: 24px;
}'
));
