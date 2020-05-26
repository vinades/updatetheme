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
$array_update_result = array();

$num_section_auto = 0;
$num_section_manual = 0;

if ($nv_Request->isset_request('submit', 'post')) {
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

    $array_update_result['base'] = array('title' => 'Cập nhật giao diện chính', 'note' => '', 'files' => array());
    $array_update_result['comment'] = array('title' => 'Cập nhật giao diện module comment', 'note' => '', 'files' => array());
    $array_update_result['news'] = array('title' => 'Cập nhật giao diện module news', 'note' => '', 'files' => array());
    $array_update_result['page'] = array('title' => 'Cập nhật giao diện module page', 'note' => '', 'files' => array());
    $array_update_result['statistics'] = array('title' => 'Cập nhật giao diện module statistics', 'note' => '', 'files' => array());
    $array_update_result['users'] = array('title' => 'Cập nhật giao diện module users', 'note' => '', 'files' => array());

    foreach ($files as $file) {
        $contents_file = file_get_contents($file);
        $output_data = $contents_file;
        $file_key = md5(strtolower($file));

        if (preg_match('/\/modules\/comment\//', $file) or preg_match('/\/comment\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/comment.php');
        } elseif (preg_match('/\/modules\/news\//', $file) or preg_match('/\/news\.js$/', $file) or preg_match('/\/news\.css$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/news.php');
        } elseif (preg_match('/\/modules\/page\//', $file) or preg_match('/\/page\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/page.php');
        } elseif (preg_match('/\/modules\/statistics\//', $file) or preg_match('/\/statistics\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/statistics.php');
        } elseif (preg_match('/\/modules\/users\//', $file) or preg_match('/\/users\.js$/', $file) or preg_match('/\/users\.css$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/users.php');
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/theme\.php$/', $file)) {
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'php');

            if (preg_match("/function[\s]*nv\_site\_theme[\s]*\([\s]*\\\$contents([^\)]+)\)[\s\n\t\r]*\{[\s\n\t\r]*global \\$([a-zA-Z0-9\_\,\s\\$]+)\;/i", $output_data, $m)) {
                $m[2] = '$' . $m[2];
                $array_variable = array_map('trim', explode(',', $m[2]));
                if (!in_array('$nv_plugin_area', $array_variable)) {
                    $array_variable[] = '$nv_plugin_area';
                }
                $array_variable = 'global ' . implode(', ', $array_variable) . ';';

                $find = $m[0];
                $replace = "function nv_site_theme(\$contents" . $m[1] . ")\n{\n    " . $array_variable;

                $output_data = str_replace($find, $replace, $output_data);
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace,
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => 'global $home, $array_mod_title, $lang_global, $language_array',
                    'replaceMessage' => 'Trong dòng đó thêm vào cuối trước dấu <code>;</code>',
                    'replace' => ', $nv_plugin_area'
                ));
            }

            nvUpdateContructItem('base', 'php');

            if (preg_match("/\\\$xtpl[\s]*\=[\s]*new[\s]*XTemplate[\s]*\([\s]*\\\$layout_file[\s]*\,[\s]*NV\_ROOTDIR([^\n]+)/i", $output_data, $m)) {
                $find = $m[0];
                $replace = 'if (isset($nv_plugin_area[4])) {
        // Kết nối với các plugin sau khi xây dựng nội dung module
        foreach ($nv_plugin_area[4] as $_fplugin) {
            include NV_ROOTDIR . \'/includes/plugin/\' . $_fplugin;
        }
    }

    ' . $m[0];
                $output_data = str_replace($find, $replace, $output_data);
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => '    $xtpl = new XTemplate($layout_file, NV_ROOTDIR . \'/themes/\' . $global_config[\'module_theme\'] . \'/layout\');',
                    'addbefore' => '    if (isset($nv_plugin_area[4])) {
        // Kết nối với các plugin sau khi xây dựng nội dung module
        foreach ($nv_plugin_area[4] as $_fplugin) {
            include NV_ROOTDIR . \'/includes/plugin/\' . $_fplugin;
        }
    }

'
                ));
            }
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/blocks\/([a-zA-Z0-9\.\-\_]+)\.php$/', $file, $parseBlock)) {
            $isContructed = false;

            // Kiểm tra xem block có cấu hình không
            if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/blocks/' . $parseBlock[1] . '.ini')) {
                $xml = simplexml_load_file(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/blocks/' . $parseBlock[1] . '.ini');
                if ($xml !== false) {
                    $submit_function = trim($xml->submitfunction);
                    if (!empty($submit_function)) {
                        // Nếu có cấu hình thì replace phần cấu hình
                        // Phần này tạm bỏ, cần làm bằng tay
                        /*
                        unset($m);
                        preg_match_all("/\\$([a-zA-Z0-9\_]+)[\s]*(\.*)\=[\s]*('|\")\<(\/*)tr\>('|\")[\s]*\;/i", $output_data, $m);
                        if (!empty($m[1])) {
                            foreach ($m[1] as $k => $v) {
                                $find = $m[0][$k];
                                $replace = '$' . $m[1][$k] . ' ' . $m[2][$k] . '= \'<' . (empty($m[4][$k]) ? 'div class="form-group"' : '/div') . '>\';';
                                $output_data = str_replace($find, $replace, $output_data);
                            }
                        }
                        */
                        $isContructed = true;
                        nv_get_update_result('base');
                        nvUpdateContructItem('base', 'html');
                        nvUpdateSetItemGuide('base', array(
                            'findMessage' => 'Lúc trước khi xuất ra HTML, phần cấu hình block thường viết dạng',
                            'find' => '<tr>
    <td>Phần tiêu đề</td>
    <td>Phần input</td>
</tr>',
                            'replaceMessage' => 'Cần sửa lại thành',
                            'replace' => '<div class="form-group">
    <label class="control-label col-sm-6">Phần tiêu đề:</label>
    <div class="col-sm-18">Phần input</div>
</div>'
                        ));
                    }
                }
            }

            // Chỉnh lại câu query của news cat
            if (preg_match("/\\\$sql[\s]*\=[\s]*('|\")SELECT[\s]*catid([^\;]+)\;/i", $output_data, $m)) {
                if (!$isContructed) {
                    nv_get_update_result('base');
                }
                nvUpdateContructItem('base', 'php');
                $find = $m[0];
                $replace = str_replace('inhome', 'status', $m[0]);
                $output_data = str_replace($find, $replace, $output_data);
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace,
                ));
            }

            // Kiểm tra tiếp còn trường inhome thì cảnh báo
            if (preg_match("/inhome/i", $output_data, $m)) {
                if (!$isContructed) {
                    nv_get_update_result('base');
                }
                nvUpdateContructItem('base', 'html');
                nvUpdateSetItemGuide('base', array(
                    'find' => 'Những chỗ sử dụng trường inhome ở bảng cat',
                    'replace' => 'Đổi thành status với:

inhome = 1 => status = 1;
inhome = 0 => status = 2;'
                ));
            }
        }

        if ($contents_file != $output_data) {
            file_put_contents($file, $output_data, LOCK_EX);
        }
    }

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
