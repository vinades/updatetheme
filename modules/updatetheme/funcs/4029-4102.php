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
    
    $array_update_result['js'] = array('title' => 'Cập nhật tương thích Jquery 3', 'note' => 'Nếu giao diện sử dụng Bootstrap riêng cần cập nhật tối thiểu lên bản 3.3.6 để tương thích với Jquery 3.', 'files' => array());
    $array_update_result['base'] = array('title' => 'Cập nhật giao diện chính', 'note' => '', 'files' => array());
    $array_update_result['banners'] = array('title' => 'Cập nhật giao diện module banners', 'note' => '', 'files' => array());
    $array_update_result['comment'] = array('title' => 'Cập nhật giao diện module comment', 'note' => '', 'files' => array());
    $array_update_result['contact'] = array('title' => 'Cập nhật giao diện module contact', 'note' => '', 'files' => array());
    $array_update_result['news'] = array('title' => 'Cập nhật giao diện module news', 'note' => '', 'files' => array());
    $array_update_result['seek'] = array('title' => 'Cập nhật giao diện module seek', 'note' => '', 'files' => array());
    $array_update_result['users'] = array('title' => 'Cập nhật giao diện module users', 'note' => '', 'files' => array());
    $array_update_result['voting'] = array('title' => 'Cập nhật giao diện module voting', 'note' => 'Nếu giao diện của bạn tồn tại themes/ten-theme/js/voting.js cần đối chiếu với themes/default/js/voting.js để chỉnh sửa phù hợp với chức năng mới (thêm captcha)', 'files' => array());
    
    foreach ($files as $file) {
        $contents_file = file_get_contents($file);
        $output_data = $contents_file;
        $file_key = md5(strtolower($file));
        
        // Thay thế js, tpl tương thích jquery 3
        if (preg_match('/([a-zA-Z0-9\-\_\/\.]+)\.(js|tpl)$/', $file)) {
            // Chỉnh sửa tương thích Jquery 3
            $output_data = preg_replace("/\\$\(\s*window\s*\)\.load\s*\(/i", "\$(window).on('load', ", $contents_file);
            
            if ($output_data != $contents_file) {
                nv_get_update_result('js');
                nvUpdateContructItem('js', 'js');
                nvUpdateSetItemData('js', array(
                    'find' => '$(window).load(function () {',
                    'replace' => '$(window).on(\'load\', function() {',
                    'status' => 1
                ));
            }
        }
        
        // Cập nhật giao diện module banners
        if (preg_match('/\/modules\/banners\//', $file) or preg_match('/\/banners\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/banners.php');
        } elseif (preg_match('/\/modules\/comment\//', $file) or preg_match('/\/comment\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/comment.php');
        } elseif (preg_match('/\/modules\/contact\//', $file) or preg_match('/\/contact\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/contact.php');
        } elseif (preg_match('/\/modules\/news\//', $file) or preg_match('/\/news\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/news.php');
        } elseif (preg_match('/\/modules\/seek\//', $file) or preg_match('/\/seek\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/seek.php');
        } elseif (preg_match('/\/modules\/users\//', $file) or preg_match('/\/users\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/users.php');
        } elseif (preg_match('/\/modules\/voting\//', $file) or preg_match('/\/voting\.js$/', $file)) {
            require (NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/voting.php');
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/theme\.php$/', $file)) {
            // Sửa luật rewrite theme.php
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'php');

            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'THEME_SEARCH_URL\'\,(.*?)\)\;/i", $output_data, $m)) {
                $replace = '
        if (!$global_config[\'rewrite_enable\']) {
            $xtpl->assign(\'THEME_SEARCH_URL\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek&amp;q=\');
        } else {
            $xtpl->assign(\'THEME_SEARCH_URL\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek\', true) . \'?q=\');
        }';
                $output_data = str_replace($m[0], $replace, $output_data);
                $rewrite_theme = true;
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $m[0],
                    'replace' => $replace,
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => '        $xtpl->assign(\'THEME_SEARCH_URL\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek&q=\');',
                    'replace' => '
        if (!$global_config[\'rewrite_enable\']) {
            $xtpl->assign(\'THEME_SEARCH_URL\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek&amp;q=\');
        } else {
            $xtpl->assign(\'THEME_SEARCH_URL\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek\', true) . \'?q=\');
        }'
                ));
            }
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/css\/style\.css$/', $file)) {
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'css');
            
            $replace = '.nv-recaptcha-default {
    margin: 0 auto;
    width: 304px;
    height: 78px;
}

.nv-recaptcha-compact {
    margin: 0 auto;
    width: 164px;
    height: 144px;
}';
            
            nvUpdateSetItemData('base', array(
                'status' => 1,
                'find' => '/* Dòng cuối của file */',
                'replace' => $replace
            ));
            
            $output_data .= "\n\n" . $replace;
        }
        
        if ($contents_file != $output_data) {
            //file_put_contents($file, $output_data, LOCK_EX);
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
