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

// Bổ sung docviewer
if (!preg_match('/\.nv\-docviewer[\s]*\{/is', $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    if (preg_match('/figure\.avatar[\s]*figcaption[\s]*\{([^\}]+)\}[\r\n\s\t]*/is', $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . '.nv-docviewer {
    margin-bottom: 8px;
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
            'find' => 'figure.avatar figcaption {
    position: absolute;
    bottom: 12px;
    left: 3px;
    width: calc(100% - 6px);
    background-color: #357ebd;
    color: #fff;
    font-size: 11px
}

',
            'addafter' => '.nv-docviewer {
    margin-bottom: 8px;
}

'
        ]);
    }
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Thêm :root cho ckeditor
if (preg_match("/[\r\n\s\t]*(\/\* NUKEVIET ICONS \*\/)*[\r\n\s\t]*\@font\-face[\s]*\{[\r\n\s\t]*font\-family[\s]*\:[\s]*(\'|\")NukeVietIcons(\'|\")[\s]*\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = "\n\n" . ':root {
    --nv-border-color: #dddddd;
    --nv-image-style-spacing: 20px;
    --nv-inline-image-style-spacing: calc(var(--nv-image-style-spacing) / 2);
    --nv-highlight-marker-blue: hsl(201, 97%, 72%);
    --nv-highlight-marker-green: hsl(120, 93%, 68%);
    --nv-highlight-marker-pink: hsl(345, 96%, 73%);
    --nv-highlight-marker-yellow: hsl(60, 97%, 73%);
    --nv-highlight-pen-green: hsl(112, 100%, 27%);
    --nv-highlight-pen-red: hsl(0, 85%, 49%);
    --nv-font-size-xs: 10px;
    --nv-font-size-sm: 12px;
    --nv-font-size-md: 14px;
    --nv-font-size-lg: 16px;
    --nv-font-size-xxl: 22px;
}

' . ltrim($m[0]);
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('base', [
        'find' => '@font-face {
    font-family: \'NukeVietIcons\';
    src: url(\'../fonts/NukeVietIcons.woff2\') format(\'woff2\'),
        url(\'../fonts/NukeVietIcons.woff\') format(\'woff\'),
        url(\'../fonts/NukeVietIcons.ttf\') format(\'truetype\'),
        url(\'../fonts/NukeVietIcons.svg\') format(\'svg\');
    font-weight: normal;
    font-style: normal;
    font-display: swap;
}',
        'addbefore' => ':root {
    --nv-border-color: #dddddd;
    --nv-image-style-spacing: 20px;
    --nv-inline-image-style-spacing: calc(var(--nv-image-style-spacing) / 2);
    --nv-highlight-marker-blue: hsl(201, 97%, 72%);
    --nv-highlight-marker-green: hsl(120, 93%, 68%);
    --nv-highlight-marker-pink: hsl(345, 96%, 73%);
    --nv-highlight-marker-yellow: hsl(60, 97%, 73%);
    --nv-highlight-pen-green: hsl(112, 100%, 27%);
    --nv-highlight-pen-red: hsl(0, 85%, 49%);
    --nv-font-size-xs: 10px;
    --nv-font-size-sm: 12px;
    --nv-font-size-md: 14px;
    --nv-font-size-lg: 16px;
    --nv-font-size-xxl: 22px;
}

'
    ]);
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'css');

// Thêm CKEditor 5 content css
if (preg_match('/\.nv\-docviewer[\s]*\{([^\}]+)\}[\r\n\s\t]*/is', $output_data, $m)) {
    $find = $m[0];
    $replace = $m[0] . '/* CKEditor 5 supported */
/* Table */
figure.table .ck-table-resized {
    table-layout: fixed;
}

figure.table table {
    overflow: hidden;
}

figure.table td,
figure.table th {
    overflow-wrap: break-word;
    position: relative;
}

figure.table {
    margin: 5px auto 10px auto;
    display: table;
}

figure.table table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    height: 100%;
    border: 1px double var(--nv-border-color);
}

figure.table table td,
figure.table table th {
    min-width: 5px;
    padding: 7px;
    border: 1px solid var(--nv-border-color);
}

figure.table table th {
    font-weight: bold;
    border-bottom-width: 2px;
}

figure.table > figcaption {
    display: table-caption;
    caption-side: top;
    word-break: break-word;
    text-align: center;
    outline-offset: -1px;
    margin-top: 0;
}

/* Media */
figure.media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

/* NV-Media */
figure.nv-media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

figure.nv-media video,
figure.nv-media audio {
    max-width: 100%;
    margin: 0 auto;
    display: block;
}

/* Image */
img.image_resized {
    height: auto;
}

figure.image.image_resized {
    max-width: 100%;
    display: block;
    box-sizing: border-box;
}

figure.image.image_resized img {
    width: 100%;
}

figure.image.image_resized > figcaption {
    display: block;
}

figure.image {
    display: table!important; /* Fix conflicts with Google Docs */
    clear: both;
    text-align: center;
    margin: 5px auto 10px auto;
    min-width: 10px;
}

figure.image img {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    min-width: 100%;
    height: auto;
}

figure.image-inline {
    display: inline-flex;
    max-width: 100%;
    align-items: flex-start;
}

figure.image-inline picture {
    display: flex;
}

figure.image-inline picture,
figure.image-inline img {
    flex-grow: 1;
    flex-shrink: 1;
    max-width: 100%;
}

figure.image > figcaption {
    display: table-caption;
    caption-side: bottom;
    word-break: break-word;
    padding: 7px 7px 0 7px;
    font-size: 13px;
    outline-offset: -1px;
    margin-top: 0;
}

/* Image Style */
.image-style-block-align-left,
.image-style-block-align-right {
    max-width: calc(100% - var(--nv-image-style-spacing));
}

.image-style-align-left,
.image-style-align-right {
    clear: none;
}

.image-style-side {
    float: right;
    margin-left: var(--nv-image-style-spacing);
    max-width: 50%;
}

.image-style-align-left {
    float: left;
    margin-right: var(--nv-image-style-spacing);
}

.image-style-align-center {
    margin-left: auto;
    margin-right: auto;
}

.image-style-align-right {
    float: right;
    margin-left: var(--nv-image-style-spacing);
}

.image-style-block-align-right {
    margin-right: 0;
    margin-left: auto;
}

.image-style-block-align-left {
    margin-left: 0;
    margin-right: auto;
}

p + .image-style-align-left,
p + .image-style-align-right,
p + .image-style-side {
    margin-top: 0;
}

.image-inline.image-style-align-left,
.image-inline.image-style-align-right {
    margin-top: var(--nv-inline-image-style-spacing);
    margin-bottom: var(--nv-inline-image-style-spacing);
}

.image-inline.image-style-align-left {
    margin-right: var(--nv-inline-image-style-spacing);
}

.image-inline.image-style-align-right {
    margin-left: var(--nv-inline-image-style-spacing);
}

/* Highlight */
.marker-yellow {
    background-color: var(--nv-highlight-marker-yellow);
}

.marker-green {
    background-color: var(--nv-highlight-marker-green);
}

.marker-pink {
    background-color: var(--nv-highlight-marker-pink);
}

.marker-blue {
    background-color: var(--nv-highlight-marker-blue);
}

.pen-red {
    color: var(--nv-highlight-pen-red);
    background-color: transparent;
}

.pen-green {
    color: var(--nv-highlight-pen-green);
    background-color: transparent;
}

/* Font size */
.text-tiny {
    font-size: var(--nv-font-size-xs);
}

.text-small {
    font-size: var(--nv-font-size-sm);
}

.text-big {
    font-size: var(--nv-font-size-lg);
}

.text-huge {
    font-size: var(--nv-font-size-xxl);
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
        'find' => '.nv-docviewer {
    margin-bottom: 8px;
}',
        'addafter' => ':root {
    --nv-border-color: #dddddd;
    --nv-image-style-spacing: 20px;
    --nv-inline-image-style-spacing: calc(var(--nv-image-style-spacing) / 2);
    --nv-highlight-marker-blue: hsl(201, 97%, 72%);
    --nv-highlight-marker-green: hsl(120, 93%, 68%);
    --nv-highlight-marker-pink: hsl(345, 96%, 73%);
    --nv-highlight-marker-yellow: hsl(60, 97%, 73%);
    --nv-highlight-pen-green: hsl(112, 100%, 27%);
    --nv-highlight-pen-red: hsl(0, 85%, 49%);
    --nv-font-size-xs: 10px;
    --nv-font-size-sm: 12px;
    --nv-font-size-md: 14px;
    --nv-font-size-lg: 16px;
    --nv-font-size-xxl: 22px;
}

/* Table */
figure.table .ck-table-resized {
    table-layout: fixed;
}

figure.table table {
    overflow: hidden;
}

figure.table td,
figure.table th {
    overflow-wrap: break-word;
    position: relative;
}

figure.table {
    margin: 5px auto 10px auto;
    display: table;
}

figure.table table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    height: 100%;
    border: 1px double var(--nv-border-color);
}

figure.table table td,
figure.table table th {
    min-width: 5px;
    padding: 7px;
    border: 1px solid var(--nv-border-color);
}

figure.table table th {
    font-weight: bold;
    border-bottom-width: 2px;
}

figure.table > figcaption {
    display: table-caption;
    caption-side: top;
    word-break: break-word;
    text-align: center;
    outline-offset: -1px;
    margin-top: 0;
}

/* Media */
figure.media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

/* NV-Media */
figure.nv-media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

figure.nv-media video,
figure.nv-media audio {
    max-width: 100%;
    margin: 0 auto;
    display: block;
}

/* Image */
img.image_resized {
    height: auto;
}

figure.image.image_resized {
    max-width: 100%;
    display: block;
    box-sizing: border-box;
}

figure.image.image_resized img {
    width: 100%;
}

figure.image.image_resized > figcaption {
    display: block;
}

figure.image {
    display: table!important; /* Important để không xung đột khi copy từ Google Docs */
    clear: both;
    text-align: center;
    margin: 5px auto 10px auto;
    min-width: 10px;
}

figure.image img {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    min-width: 100%;
    height: auto;
}

figure.image-inline {
    display: inline-flex;
    max-width: 100%;
    align-items: flex-start;
}

figure.image-inline picture {
    display: flex;
}

figure.image-inline picture,
figure.image-inline img {
    flex-grow: 1;
    flex-shrink: 1;
    max-width: 100%;
}

figure.image > figcaption {
    display: table-caption;
    caption-side: bottom;
    word-break: break-word;
    padding: 7px 7px 0 7px;
    font-size: 13px;
    outline-offset: -1px;
    margin-top: 0;
}

/* Image Style */
.image-style-block-align-left,
.image-style-block-align-right {
    max-width: calc(100% - var(--nv-image-style-spacing));
}

.image-style-align-left,
.image-style-align-right {
    clear: none;
}

.image-style-side {
    float: right;
    margin-left: var(--nv-image-style-spacing);
    max-width: 50%;
}

.image-style-align-left {
    float: left;
    margin-right: var(--nv-image-style-spacing);
}

.image-style-align-center {
    margin-left: auto;
    margin-right: auto;
}

.image-style-align-right {
    float: right;
    margin-left: var(--nv-image-style-spacing);
}

.image-style-block-align-right {
    margin-right: 0;
    margin-left: auto;
}

.image-style-block-align-left {
    margin-left: 0;
    margin-right: auto;
}

p + .image-style-align-left,
p + .image-style-align-right,
p + .image-style-side {
    margin-top: 0;
}

.image-inline.image-style-align-left,
.image-inline.image-style-align-right {
    margin-top: var(--nv-inline-image-style-spacing);
    margin-bottom: var(--nv-inline-image-style-spacing);
}

.image-inline.image-style-align-left {
    margin-right: var(--nv-inline-image-style-spacing);
}

.image-inline.image-style-align-right {
    margin-left: var(--nv-inline-image-style-spacing);
}

/* Highlight */
.marker-yellow {
    background-color: var(--nv-highlight-marker-yellow);
}

.marker-green {
    background-color: var(--nv-highlight-marker-green);
}

.marker-pink {
    background-color: var(--nv-highlight-marker-pink);
}

.marker-blue {
    background-color: var(--nv-highlight-marker-blue);
}

.pen-red {
    color: var(--nv-highlight-pen-red);
    background-color: transparent;
}

.pen-green {
    color: var(--nv-highlight-pen-green);
    background-color: transparent;
}

/* Font size */
.text-tiny {
    font-size: var(--nv-font-size-xs);
}

.text-small {
    font-size: var(--nv-font-size-sm);
}

.text-big {
    font-size: var(--nv-font-size-lg);
}

.text-huge {
    font-size: var(--nv-font-size-xxl);
}'
    ]);
}

// Thêm NV-Media nếu nó chưa có
if (!preg_match("/figure\.nv\-media/is", $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'css');

    if (preg_match("/figure\.media[\s]*\{([^\}]+)\}[\r\n\s\t]*/is", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . '/* NV-Media */
figure.nv-media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

figure.nv-media video,
figure.nv-media audio {
    max-width: 100%;
    margin: 0 auto;
    display: block;
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
            'find' => '/* Media */
figure.media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}
',
            'addafter' => '
/* NV-Media */
figure.nv-media {
    clear: both;
    margin: 5px 0 10px 0;
    display: block;
    min-width: 10px;
}

figure.nv-media video,
figure.nv-media audio {
    max-width: 100%;
    margin: 0 auto;
    display: block;
}
'
        ]);
    }
}
