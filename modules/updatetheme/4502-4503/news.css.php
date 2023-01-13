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
 * Cập nhật news.css
 */

nv_get_update_result('news');
nvUpdateContructItem('news', 'css');

if (preg_match("/\/\*[\s]*Responsive[\s]*news[\s]*\*\//is", $output_data, $m)) {
    $find = $m[0];
    $replace = '/* Player */
:root {
    --plyr-color-main: #108DE5;
    --plyr-audio-controls-background: transparent;
}

.news-detail-player {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 24px;
    background-color: #f4f4f4;
}

.news-detail-player > .player {
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-negative: 1;
    flex-shrink: 1;
    padding-right: 24px;
}

.news-detail-player > .source {
    -ms-flex-positive: 0;
    flex-grow: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    padding-right: 20px;
}

.news-detail-player > .tools {
    -ms-flex-positive: 0;
    flex-grow: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    padding-right: 20px;
}

.news-switch {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
}

.news-switch .news-switch-btn {
    margin-left: 5px;
    position: relative;
    width: 44px;
    height: 22px;
}

.news-switch .news-switch-btn .news-switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    -webkit-transition: .4s;
    transition: .4s;
}

.news-switch .news-switch-btn .news-switch-slider:before {
    position: absolute;
    content: "";
    background-color: #d6dadf;
    -webkit-transition: .4s;
    transition: .4s;
    height: 14px;
    width: 36px;
    left: 4px;
    bottom: 4px;
    border-radius: 7px;
}

.news-switch .news-switch-btn .news-switch-slider:after {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 0;
    bottom: 0;
    background-color: #4a5464;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

.news-switch .news-switch-btn.checked .news-switch-slider:after {
    background-color: #108DE5;
    -webkit-transform: translateX(22px);
    -ms-transform: translateX(22px);
    transform: translateX(22px);
}' . "\n\n" . $find;
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData(
        'news',
        array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        )
    );
} else {
    nvUpdateSetItemGuide(
        'news',
        array(
            'find' => '/* Responsive news */',
            'addbefore' => '/* Player */
:root {
    --plyr-color-main: #108DE5;
    --plyr-audio-controls-background: transparent;
}

.news-detail-player {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    margin-bottom: 24px;
    background-color: #f4f4f4;
}

.news-detail-player > .player {
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-negative: 1;
    flex-shrink: 1;
    padding-right: 24px;
}

.news-detail-player > .source {
    -ms-flex-positive: 0;
    flex-grow: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    padding-right: 20px;
}

.news-detail-player > .tools {
    -ms-flex-positive: 0;
    flex-grow: 0;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    padding-right: 20px;
}

.news-switch {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
}

.news-switch .news-switch-btn {
    margin-left: 5px;
    position: relative;
    width: 44px;
    height: 22px;
}

.news-switch .news-switch-btn .news-switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    -webkit-transition: .4s;
    transition: .4s;
}

.news-switch .news-switch-btn .news-switch-slider:before {
    position: absolute;
    content: "";
    background-color: #d6dadf;
    -webkit-transition: .4s;
    transition: .4s;
    height: 14px;
    width: 36px;
    left: 4px;
    bottom: 4px;
    border-radius: 7px;
}

.news-switch .news-switch-btn .news-switch-slider:after {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 0;
    bottom: 0;
    background-color: #4a5464;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

.news-switch .news-switch-btn.checked .news-switch-slider:after {
    background-color: #108DE5;
    -webkit-transform: translateX(22px);
    -ms-transform: translateX(22px);
    transform: translateX(22px);
}'
        )
    );
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'css');

if (preg_match("/\@media[\s]*\([\s]*max\-width[\s]*\:[\s]*499(.*?)\}[\r\n\s\t]*\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '@media (max-width: 499.98' . $m[1] . "}\n\n" . '    .news-detail-player {
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .news-detail-player > .player {
        padding-right: 0;
        width: 100%;
        -ms-flex-order: 1;
        order: 2;
    }

    .news-detail-player > .source {
        padding-right: 10;
        -ms-flex-order: 0;
        order: 0;
        margin-top: 12px;
    }

    .news-detail-player > .tools {
        padding-right: 0;
        -ms-flex-order: 0;
        order: 1;
        margin-top: 12px;
    }' . "\n}";
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData(
        'news',
        array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        )
    );
} else {
    nvUpdateSetItemGuide(
        'news',
        array(
            'find' => '@media (max-width:499.98px) {',
            'addafter' => '    .news-detail-player {
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .news-detail-player > .player {
        padding-right: 0;
        width: 100%;
        -ms-flex-order: 1;
        order: 2;
    }

    .news-detail-player > .source {
        padding-right: 10;
        -ms-flex-order: 0;
        order: 0;
        margin-top: 12px;
    }

    .news-detail-player > .tools {
        padding-right: 0;
        -ms-flex-order: 0;
        order: 1;
        margin-top: 12px;
    }',
            'addafterMessage' => 'Thêm vào bên trong đoạn đó'
        )
    );
}
