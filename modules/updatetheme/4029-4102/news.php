<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 09 Jan 2014 10:18:48 GMT
 */

if (!defined('NV_IS_MOD_UPDATETHEME'))
    die('Stop!!!');

if (preg_match('/news\/block\_groups\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{ROW.hometext}', '{ROW.hometext_clean}', $output_data);
    $output_data = str_replace('>{ROW.title}<', '>{ROW.title_clean}<', $output_data);
    $output_data = str_replace('> {ROW.title} <', '> {ROW.title_clean} <', $output_data);

    $find = '<a {TITLE} class="show" href="{ROW.link}" data-content="{ROW.hometext}" data-img="{ROW.thumb}" data-rel="block_tooltip">{ROW.title}</a>';
    $replace = '<a {TITLE} class="show" href="{ROW.link}" data-content="{ROW.hometext_clean}" data-img="{ROW.thumb}" data-rel="block_tooltip">{ROW.title_clean}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/block\_headline\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{LASTEST.hometext}', '{LASTEST.hometext_clean}', $output_data);

    $find = '<a {TITLE} class="show" href="{LASTEST.link}" data-content="{LASTEST.hometext}" data-img="{LASTEST.homeimgfile}" data-rel="block_headline_tooltip">{LASTEST.title}</a>';
    $replace = '<a {TITLE} class="show" href="{LASTEST.link}" data-content="{LASTEST.hometext_clean}" data-img="{LASTEST.homeimgfile}" data-rel="block_headline_tooltip">{LASTEST.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/block\_news\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);

    $find = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';
    $replace = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext_clean}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/block\_newscenter\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{othernews.hometext}', '{othernews.hometext_clean}', $output_data);

    $find = '<a class="show black h4" href="{othernews.link}" <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{othernews.hometext}" data-img="{othernews.imgsource}" data-rel="tooltip"<!-- END: tooltip --> title="{othernews.title}" ><img src="{othernews.imgsource}" alt="{othernews.title}" class="img-thumbnail pull-right margin-left-sm" style="width:65px;"/>{othernews.titleclean60}</a>';
    $replace = '<a class="show black h4" href="{othernews.link}" <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{othernews.hometext_clean}" data-img="{othernews.imgsource}" data-rel="tooltip"<!-- END: tooltip --> title="{othernews.title}" ><img src="{othernews.imgsource}" alt="{othernews.title}" class="img-thumbnail pull-right margin-left-sm" style="width:65px;"/>{othernews.titleclean60}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/block\_tophits\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);

    $find = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';
    $replace = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext_clean}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{TOPIC.hometext}"', 'data-content="{TOPIC.hometext_clean}"', $output_data);

    $find = 'data-content="{TOPIC.hometext}"';
    $replace = 'data-content="{TOPIC.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{RELATED_NEW.hometext}"', 'data-content="{RELATED_NEW.hometext_clean}"', $output_data);

    $find = 'data-content="{RELATED_NEW.hometext}"';
    $replace = 'data-content="{RELATED_NEW.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{RELATED.hometext}"', 'data-content="{RELATED.hometext_clean}"', $output_data);

    $find = 'data-content="{RELATED.hometext}"';
    $replace = 'data-content="{RELATED.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/viewcat\_list\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);

    $find = 'data-content="{CONTENT.hometext}"';
    $replace = 'data-content="{CONTENT.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/viewcat\_main\_bottom\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/viewcat\_main\_left\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/viewcat\_main\_right\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/viewcat\_two\_column\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);

    $find = 'data-content="{CONTENT.hometext}"';
    $replace = 'data-content="{CONTENT.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
}
