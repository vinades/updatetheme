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
 * Cập nhật theme.php module news
 */

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match('/\$\_block\_topcat\_by\_id[\s]*\=(.+?)if[\s]*\([\s]*in\_array[\s]*\([\s]*(\'|\")1(\'|\")(.+?)nv\_remove\_block\_botcat\_news([^\}]+)[\r\n\s\t]*\}[\r\n\s\t]*\}/is', $output_data, $m)) {
    $find = $m[0];
    $replace = 'if (in_array(\'1\', $array_row_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_TOPCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_row_i[\'catid\'], 1)));
                $xtpl->parse(\'main.listcat.block_topcat\');
            }
            if (in_array(\'2\', $array_row_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_BOTTOMCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_row_i[\'catid\'], 2)));
                $xtpl->parse(\'main.listcat.block_bottomcat\');
            }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('news', [
        'findMessage' => 'Tìm hàm viewsubcat_main, bên trong nó xác định đoạn code tương tự',
        'find' => '            $_block_topcat_by_id = \'[\' . strtoupper($module_name) . \'_TOPCAT_\' . $array_row_i[\'catid\'] . \']\';
            if (in_array(\'1\', $array_row_i[\'ad_block_cat\'], true)) {
                if (!nv_check_block_topcat_news($array_row_i[\'catid\'])) {
                    nv_add_block_topcat_news($array_row_i[\'catid\']);
                }
                $xtpl->assign(\'BLOCK_TOPCAT\', $_block_topcat_by_id);
                $xtpl->parse(\'main.listcat.block_topcat\');
            } else {
                if (nv_check_block_topcat_news($array_row_i[\'catid\'])) {
                    nv_remove_block_topcat_news($array_row_i[\'catid\']);
                }
            }

            $_block_bottomcat_by_id = \'[\' . strtoupper($module_name) . \'_BOTTOMCAT_\' . $array_row_i[\'catid\'] . \']\';
            if (in_array(\'2\', $array_row_i[\'ad_block_cat\'], true)) {
                if (!nv_check_block_block_botcat_news($array_row_i[\'catid\'])) {
                    nv_add_block_botcat_news($array_row_i[\'catid\']);
                }
                $xtpl->assign(\'BLOCK_BOTTOMCAT\', $_block_bottomcat_by_id);
                $xtpl->parse(\'main.listcat.block_bottomcat\');
            } else {
                if (nv_check_block_block_botcat_news($array_row_i[\'catid\'])) {
                    nv_remove_block_botcat_news($array_row_i[\'catid\']);
                }
            }',
        'replace' => '            if (in_array(\'1\', $array_row_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_TOPCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_row_i[\'catid\'], 1)));
                $xtpl->parse(\'main.listcat.block_topcat\');
            }
            if (in_array(\'2\', $array_row_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_BOTTOMCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_row_i[\'catid\'], 2)));
                $xtpl->parse(\'main.listcat.block_bottomcat\');
            }',
    ]);
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match('/\/\/[\s]*Block[\s]*Top[\r\n\s\t]*\$array\_catpage\_i(.*?)if[\s]*\([\s]*\([\s]*\$a[\s]*\+[\s]*1(.*?)nv\_remove\_block\_botcat\_news([^\}]+)[\r\n\s\t]*\}[\r\n\s\t]*\}[\r\n\s\t]*\}/is', $output_data, $m)) {
    $find = $m[0];
    $replace = '// Block Top
            $array_catpage_i[\'ad_block_cat\'] = isset($array_catpage_i[\'ad_block_cat\']) ? explode(\',\', $array_catpage_i[\'ad_block_cat\']) : [];
            if (($a + 1) % 2 and in_array(\'1\', $array_catpage_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_TOPCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_catpage_i[\'catid\'], 1)));
                $xtpl->parse(\'main.loopcat.block_topcat\');
            }

            // Block Bottom
            if ($a % 2 and in_array(\'2\', $array_catpage_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_BOTTOMCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_catpage_i[\'catid\'], 2)));
                $xtpl->parse(\'main.loopcat.block_bottomcat\');
            }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', [
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ]);
} else {
    nvUpdateSetItemGuide('news', [
        'findMessage' => 'Tìm hàm viewcat_two_column, bên trong nó xác định đoạn code tương tự',
        'find' => '            // Block Top
            $array_catpage_i[\'ad_block_cat\'] = isset($array_catpage_i[\'ad_block_cat\']) ? explode(\',\', $array_catpage_i[\'ad_block_cat\']) : [];
            if (($a + 1) % 2) {
                $_block_topcat_by_id = \'[\' . strtoupper($module_name) . \'_TOPCAT_\' . $array_catpage_i[\'catid\'] . \']\';
                if (in_array(\'1\', $array_catpage_i[\'ad_block_cat\'], true)) {
                    if (!nv_check_block_topcat_news($array_catpage_i[\'catid\'])) {
                        nv_add_block_topcat_news($array_catpage_i[\'catid\']);
                    }
                    $xtpl->assign(\'BLOCK_TOPCAT\', $_block_topcat_by_id);
                    $xtpl->parse(\'main.loopcat.block_topcat\');
                } else {
                    if (nv_check_block_topcat_news($array_catpage_i[\'catid\'])) {
                        nv_remove_block_topcat_news($array_catpage_i[\'catid\']);
                    }
                }
            }

            // Block Bottom
            if ($a % 2) {
                $_block_bottomcat_by_id = \'[\' . strtoupper($module_name) . \'_BOTTOMCAT_\' . $array_catpage_i[\'catid\'] . \']\';
                if (in_array(\'2\', $array_catpage_i[\'ad_block_cat\'], true)) {
                    if (!nv_check_block_block_botcat_news($array_catpage_i[\'catid\'])) {
                        nv_add_block_botcat_news($array_catpage_i[\'catid\']);
                    }
                    $xtpl->assign(\'BLOCK_BOTTOMCAT\', $_block_bottomcat_by_id);
                    $xtpl->parse(\'main.loopcat.block_bottomcat\');
                } else {
                    if (nv_check_block_block_botcat_news($array_catpage_i[\'catid\'])) {
                        nv_remove_block_botcat_news($array_catpage_i[\'catid\']);
                    }
                }
            }',
        'replace' => '            // Block Top
            $array_catpage_i[\'ad_block_cat\'] = isset($array_catpage_i[\'ad_block_cat\']) ? explode(\',\', $array_catpage_i[\'ad_block_cat\']) : [];
            if (($a + 1) % 2 and in_array(\'1\', $array_catpage_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_TOPCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_catpage_i[\'catid\'], 1)));
                $xtpl->parse(\'main.loopcat.block_topcat\');
            }

            // Block Bottom
            if ($a % 2 and in_array(\'2\', $array_catpage_i[\'ad_block_cat\'], true)) {
                $xtpl->assign(\'BLOCK_BOTTOMCAT\', nv_tag2pos_block(nv_get_blcat_tag($array_catpage_i[\'catid\'], 2)));
                $xtpl->parse(\'main.loopcat.block_bottomcat\');
            }',
    ]);
}
