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
} elseif (preg_match('/modules\/news\/theme\.php$/', $file)) {
            nv_get_update_result('news');
            
            if (preg_match_all("/\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\\s*]\s*\=\s*nv\_clean60\(\s*\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\s*\]/", $output_data, $m)) {
                foreach ($m[1] as $k => $v) {
                    $find = $m[0][$k];
                    $replace = '$' . $m[1][$k] . '[\'hometext_clean\'] = nv_clean60(strip_tags($' . $m[2][$k] . '[\'hometext\'])';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateContructItem('news', 'php');
                    nvUpdateSetItemData('news', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                }
            } else {
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'findMessage' => 'T?m các ðo?n có d?ng (kho?ng 2)',
                    'find' => '$array_row_i[\'hometext\'] = nv_clean60($array_row_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$array_row_i[\'hometext_clean\'] = nv_clean60(strip_tags($array_row_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$array_content_i[\'hometext\'] = nv_clean60($array_content_i[\'hometext\'], 200);',
                    'replace' => '$array_content_i[\'hometext\'] = nv_clean60(strip_tags($array_content_i[\'hometext\']), 200);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$related_new_array_i[\'hometext\'] = nv_clean60($related_new_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$related_new_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($related_new_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$related_array_i[\'hometext\'] = nv_clean60($related_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$related_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($related_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$topic_array_i[\'hometext\'] = nv_clean60($topic_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$topic_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($topic_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
            }
            
            nvUpdateContructItem('news', 'php');
            
            if (preg_match("/if\s*\(\\\$module\_config\s*\[\s*\\\$module\_name\s*\]\s*\[\s*\'showtooltip'\s*\]\s*\)\s*\{[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'TOOLTIP\_POSIT([^\}]+)main\.loopcat\.other\.tooltip\'\s*\)\s*\;[\s\n\t\r]*\}/isU", $output_data, $m)) {
                $find = $m[0];
                $replace = '

                    $array_catpage_i[\'content\'][$index][\'hometext_clean\'] = nv_clean60(strip_tags($array_catpage_i[\'content\'][$index][\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);
                    $xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);
                    
                    if ($module_config[$module_name][\'showtooltip\']) {
                        $xtpl->assign(\'TOOLTIP_POSITION\', $module_config[$module_name][\'tooltip_position\']);
                        $xtpl->parse(\'main.loopcat.other.tooltip\');
                    }                
                ';
                nvUpdateSetItemData('news', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('news', array(
                    'find' => '
if ($module_config[$module_name][\'showtooltip\']) {
    $xtpl->assign(\'TOOLTIP_POSITION\', $module_config[$module_name][\'tooltip_position\']);
    $array_catpage_i[\'content\'][$index][\'hometext\'] = nv_clean60($array_catpage_i[\'content\'][$index][\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);
    $xtpl->parse(\'main.loopcat.other.tooltip\');
}
                    ',
                    'delinline' => '$array_catpage_i[\'content\'][$index][\'hometext\'] = nv_clean60($array_catpage_i[\'content\'][$index][\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'addafter' => '$xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);',
                    'addbefore' => '
$array_catpage_i[\'content\'][$index][\'hometext_clean\'] = nv_clean60(strip_tags($array_catpage_i[\'content\'][$index][\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);
$xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);
                    '
                ));
            }
            
            nvUpdateContructItem('news', 'php');
            
            if (preg_match("/BoldKeywordInStr\s*\(\s*\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\s*\]\s*\,\s*\\$([a-zA-Z0-9\_]+)\s*\)/", $output_data, $m)) {
                $find = $m[0];
                $replace = 'BoldKeywordInStr(strip_tags($' . $m[1] . '[\'hometext\']), $' . $m[2] . ')';
                nvUpdateSetItemData('news', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('news', array(
                    'find' => '$xtpl->assign(\'CONTENT\', BoldKeywordInStr($value[\'hometext\'], $key) . "...");',
                    'replace' => '$xtpl->assign(\'CONTENT\', BoldKeywordInStr(strip_tags($value[\'hometext\']), $key) . "...");'
                ));
            }
        }
