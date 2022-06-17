<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 09 Jan 2014 10:18:48 GMT
 */

if (!defined('NV_IS_MOD_UPDATETHEME')) {
    die('Stop!!!');
}

/**
 * replaceModuleFileInTheme()
 *
 * @param mixed $output_data
 * @param mixed $mod
 * @return
 */
function replaceModuleFileInTheme($output_data, $mod)
{
    preg_match_all("/\\\$module\_info[\s]*\[[\s]*(\"|')template(\"|')[\s]*\][\s]*\.[\s]*(\"|')\/(modules|images)\/(\"|')[\s]*\.[\s]*\\\$module\_file/", $output_data, $m);

    if (!empty($m[1])) {
        foreach ($m[1] as $k => $v) {
            nv_get_update_result($mod);
            nvUpdateContructItem($mod, 'php');

            $find = $m[0][$k];
            $replace = '$module_info[' . $m[1][$k] . 'template' . $m[2][$k] . '] . ' . $m[3][$k] . '/' . $m[4][$k] . '/' . $m[5][$k] . ' . $module_info[\'module_theme\']';
            $output_data = str_replace($find, $replace, $output_data);
            nvUpdateSetItemData($mod, array(
                'status' => 1,
                'find' => $find,
                'replace' => $replace
            ));
        }
    }

    return $output_data;
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$theme_update = '';
$list_theme = nv_scandir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update', $global_config['check_theme']);
if (!empty($list_theme)) {
    $theme_update = $list_theme[0];
}
if (empty($theme_update)) {
    $list_theme = nv_scandir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update', $global_config['check_theme_mobile']);
    if (!empty($list_theme)) {
        $theme_update = $list_theme[0];
    }
}

if (empty($theme_update)) {
    $contents = nv_theme_alert('Không có giao diện để cập nhật', 'Bạn chưa copy giao diện cần cập nhật vào đúng thư mục đã quy định, vui lòng thực hiện thao tác đó trước.', 'danger');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$my_head .= '<link href="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/styles/github.css" rel="stylesheet">';
$my_head .= '<script src="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>';
$my_head .= '<script>hljs.initHighlightingOnLoad();</script>';

$xtpl = new XTemplate('update.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('THEMEUPDATE', $theme_update);
$xtpl->assign('NV_TEMP_DIR', NV_TEMP_DIR);

$global_autokey = -1;
$file_key = '';
$file = '';
$array_update_result = [];

$num_section_auto = 0;
$num_section_manual = 0;

if ($nv_Request->isset_request('save', 'post')) {
    // Xác định danh sách các file
    $files = list_all_file(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update, NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update);

    $array_update_result = array(
        /*
        title => Tên
        note
        files => array(
            'filekey' => array(
                'name' => Tên file
                'data' => array(
                    'find'
                    'replace'
                    'status'
                    'guide' array(
                        'find'
                        'replace'
                    )
                    'type' html js php
                )
            )
        )
        */
    );
    $array_update_result['base'] = array(
        'title' => 'Cập nhật giao diện chính',
        'note' => '',
        'files' => array()
    );
    $array_update_result['banners'] = array(
        'title' => 'Cập nhật giao diện module banners',
        'note' => '',
        'files' => array()
    );
    $array_update_result['comment'] = array(
        'title' => 'Cập nhật giao diện module comment',
        'note' => '',
        'files' => array()
    );
    $array_update_result['contact'] = array(
        'title' => 'Cập nhật giao diện module contact',
        'note' => '',
        'files' => array()
    );
    $array_update_result['news'] = array(
        'title' => 'Cập nhật giao diện module news',
        'note' => '',
        'files' => array()
    );
    $array_update_result['seek'] = array(
        'title' => 'Cập nhật giao diện module seek',
        'note' => '',
        'files' => array()
    );
    $array_update_result['users'] = array(
        'title' => 'Cập nhật giao diện module users',
        'note' => '',
        'files' => array()
    );
    $array_update_result['voting'] = array(
        'title' => 'Cập nhật giao diện module voting',
        'note' => '',
        'files' => array()
    );

    foreach ($files as $file) {
        $contents_file = file_get_contents($file);
        $output_data = $contents_file;
        $file_key = md5(strtolower($file));

        // Cập nhật giao diện module banners
        if (preg_match('/\/modules\/banners\//', $file) or preg_match('/\/banners\.js$/', $file)) {
            //require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/banners.php');
        } elseif (preg_match('/\/modules\/comment\//', $file) or preg_match('/\/comment\.js$/', $file)) {
        } elseif (preg_match('/\/modules\/contact\//', $file) or preg_match('/\/contact\.js$/', $file)) {
        } elseif (preg_match('/\/modules\/news\//', $file) or preg_match('/\/news\.js$/', $file)) {
        } elseif (preg_match('/\/modules\/seek\//', $file) or preg_match('/\/seek\.js$/', $file)) {
        } elseif (preg_match('/\/modules\/users\//', $file) or preg_match('/\/users\.js$/', $file)) {
        } elseif (preg_match('/\/modules\/voting\//', $file) or preg_match('/\/voting\.js$/', $file)) {
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/theme\.php$/', $file)) {
            //
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/css\/style\.css$/', $file)) {
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/js\/main\.js$/', $file)) {
            require NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/main.js.php';
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/blocks\/([a-zA-Z0-9\.\-\_]+)\.php$/', $file)) {
            // Nâng cấp các block banners của theme
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/system\/info\_die\.tpl$/', $file)) {
        }

        if ($contents_file != $output_data) {
            file_put_contents($file, $output_data, LOCK_EX);
        }
    }

    $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/js/main.js';
    $file_key = md5(strtolower($file));
    if (!is_file($file)) {
        nv_get_update_result('base');
        nvUpdateContructItem('base', 'js');
        nvUpdateSetItemGuide('base', array(
            'find' => 'Tìm file js chính của giao diện',
            'replace' => 'Cập nhật theo hướng dẫn ở https://github.com/nukeviet/update#js-của-giao-diện-chính'
        ));
    }

    // Xóa các file thừa
    @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/banners/cledit.tpl');
    @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/banners/clientinfo.tpl');
    @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/banners/clinfo.tpl');
    @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/banners/logininfo.tpl');

    $storage_file = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $op . '.htm';

    $xtpl->assign('NUM_SECTION_AUTO', number_format($num_section_auto, 0, ',', '.'));
    $xtpl->assign('NUM_SECTION_MANUAL', number_format($num_section_manual, 0, ',', '.'));
    $xtpl->assign('FILE_STORAGE', NV_BASE_SITEURL . $storage_file);

    foreach ($array_update_result as $result) {
        $xtpl->assign('PARA_NAME', $result['title']);

        // Ghi chú cập nhật cho đoạn
        if (!empty($result['note'])) {
            $xtpl->assign('PARA_NOTE', $result['note']);
            $xtpl->parse('main.result.loop.note');
        }

        if (empty($result['files'])) {
            $xtpl->parse('main.result.loop.empty');
        } else {
            foreach ($result['files'] as $fileData) {
                $xtpl->assign('FILE_NAME', $fileData['name']);

                foreach ($fileData['data'] as $section) {
                    $section['find'] = nv_htmlspecialchars(str_replace(array("\t"), array("    "), $section['find']));
                    $section['replace'] = nv_htmlspecialchars(str_replace(array("\t"), array("    "), $section['replace']));

                    $xtpl->assign('SECTION', $section);

                    if (!empty($section['status'])) {
                        $xtpl->parse('main.result.loop.data.loop.section.is_auto');
                    } else {
                        $guide = $section['guide'];
                        $guide['find'] = !empty($guide['find']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['find']))) : '';
                        $guide['replace'] = !empty($guide['replace']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['replace']))) : '';
                        $guide['addbefore'] = !empty($guide['addbefore']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['addbefore']))) : '';
                        $guide['addafter'] = !empty($guide['addafter']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['addafter']))) : '';
                        $guide['delinline'] = !empty($guide['delinline']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['delinline']))) : '';
                        $guide['findMessage'] = !empty($guide['findMessage']) ? $guide['findMessage'] : 'Tìm';
                        $guide['replaceMessage'] = !empty($guide['replaceMessage']) ? $guide['replaceMessage'] : 'Thay bằng';
                        $guide['addbeforeMessage'] = !empty($guide['addbeforeMessage']) ? $guide['addbeforeMessage'] : 'Thêm lên trên';
                        $guide['addafterMessage'] = !empty($guide['addafterMessage']) ? $guide['addafterMessage'] : 'Thêm xuống dưới';
                        $guide['delinlineMessage'] = !empty($guide['delinlineMessage']) ? $guide['delinlineMessage'] : 'Trong đoạn đó xóa';

                        $xtpl->assign('GUIDE', $guide);

                        if (!empty($guide['find'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.find');
                        }
                        if (!empty($guide['replace'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.replace');
                        }
                        if (!empty($guide['addbefore'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.addbefore');
                        }
                        if (!empty($guide['delinline'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.delinline');
                        }
                        if (!empty($guide['addafter'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.addafter');
                        }

                        $xtpl->parse('main.result.loop.data.loop.section.no_auto');
                    }

                    $xtpl->parse('main.result.loop.data.loop.section');
                }

                $xtpl->parse('main.result.loop.data.loop');
            }

            $xtpl->parse('main.result.loop.data');
        }

        $xtpl->parse('main.result.loop');
    }

    $xtpl->parse('main.result');

    if (file_exists(NV_ROOTDIR . '/' . $storage_file)) {
        nv_deletefile(NV_ROOTDIR . '/' . $storage_file);
    }

    $xtpl1 = new XTemplate('save.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl1->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl1->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
    $xtpl1->assign('CONTENTS', $xtpl->text('main.result'));

    $xtpl1->parse('main');
    $file_text = $xtpl1->text('main');

    file_put_contents(NV_ROOTDIR . '/' . $storage_file, $file_text, LOCK_EX);
} else {
    $xtpl->parse('main.form');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
