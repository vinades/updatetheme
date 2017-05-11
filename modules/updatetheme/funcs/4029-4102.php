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
    $array_update_result['voting'] = array('title' => 'Cập nhật giao diện module voting', 'note' => '', 'files' => array());
    
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
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/js\/main\.js$/', $file)) {
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'js');
            
            if (preg_match("/brcb[\s]*\=[\s]*\\$\((\"|')\.breadcrumbs\-wrap(\"|')[\s]*\)[\s]*\;/", $output_data, $m)) {
                $find = $m[0];
                $replace = 'brcb = $(\'.breadcrumbs-wrap\'),
    reCapIDs = [];';
                $output_data = str_replace($find, $replace, $output_data);
                
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => 'brcb = $(\'.breadcrumbs-wrap\');',
                    'replace' => 'brcb = $(\'.breadcrumbs-wrap\'),
    reCapIDs = [];'
                ));
            }
            
            // Thay thế hàm tipShow nếu có
            if (preg_match("/function[\s]+tipShow[\s]*\(/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/function[\s]+tipShow[\s]*\([\s]*([a-z0-9]+)[\s]*\,[\s]*([a-z0-9]+)[\s]*\)[\s]*\{/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'function tipShow(a, b, callback) {';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => 'function tipShow(a, b) {',
                        'replace' => 'function tipShow(a, b, callback) {'
                    ));
                }
                
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/\\$\([\s]*(\"|')#tip(\"|')[\s]*\)\.attr[\s]*\([\s]*(\"|')data\-content(\"|')[\s]*\,[\s]+b[\s]*\)\.show[\s]*\([\s]*(\"|')fast(\"|')[\s]*\)[\s]*\;[\s\n\t\r]+tip\_active[\s]+\=[\s]+\![\s]*0/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'if (typeof callback != "undefined") {
        $("#tip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            }
        });
    } else {
        $("#tip").attr("data-content", b).show("fast");
    }
    tip_active = 1;';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => '// Hàm tipShow',
                        'replaceMessage' => 'Trong hàm đó tìm',
                        'replace' => '    $("#tip").attr("data-content", b).show("fast");
    tip_active = !0',
                        'addafterMessage' => 'Thay lại thành',
                        'addafter' => '    if (typeof callback != "undefined") {
        $("#tip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            }
        });
    } else {
        $("#tip").attr("data-content", b).show("fast");
    }
    tip_active = 1;'
                    ));
                }
            }
            
            // Thay thế hàm ftipShow nếu có
            if (preg_match("/function[\s]+ftipShow[\s]*\(/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/function[\s]+ftipShow[\s]*\([\s]*([a-z0-9]+)[\s]*\,[\s]*([a-z0-9]+)[\s]*\)[\s]*\{/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'function ftipShow(a, b, callback) {';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => 'function ftipShow(a, b) {',
                        'replace' => 'function ftipShow(a, b, callback) {'
                    ));
                }
                
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/\\$\([\s]*(\"|')#ftip(\"|')[\s]*\)\.attr[\s]*\([\s]*(\"|')data\-content(\"|')[\s]*\,[\s]+b[\s]*\)\.show[\s]*\([\s]*(\"|')fast(\"|')[\s]*\)[\s]*\;[\s\n\t\r]+ftip\_active[\s]+\=[\s]+\![\s]*0/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'if (typeof callback != "undefined") {
        $("#ftip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            }
        });
    } else {
        $("#ftip").attr("data-content", b).show("fast");
    }
    ftip_active = 1;';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => '// Hàm ftipShow',
                        'replaceMessage' => 'Trong hàm đó tìm',
                        'replace' => '    $("#ftip").attr("data-content", b).show("fast");
    ftip_active = !0',
                        'addafterMessage' => 'Thay lại thành',
                        'addafter' => '    if (typeof callback != "undefined") {
        $("#ftip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            }
        });
    } else {
        $("#ftip").attr("data-content", b).show("fast");
    }
    ftip_active = 1;'
                    ));
                }
            }
            
            nvUpdateContructItem('base', 'js');
            
            // change_captcha là hàm bắt buộc phải có trong giao diện
            if (preg_match("/function[\s]+change\_captcha[\s]*\([\s]*a[\s]*\)[\s]+\{(.*)\\$\(a\)\.val\(\"\"\)\;[\s\n\t\r]+return[\s]*\![\s]*1[\s\n\t\r]+\}/s", $output_data, $m)) {
                $find = $m[0];
                $replace = 'function change_captcha(a) {
    if (typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
        for (i = 0, j = reCapIDs.length; i < j; i++) {
            var ele = reCapIDs[i];
            var btn = nv_recaptcha_elements[ele[0]];
            if ($(\'#\' + btn.id).length) {
                if (typeof btn.btn != "undefined" && btn.btn != "") {
                    btn.btn.prop(\'disabled\', true);
                }
                grecaptcha.reset(ele[1]);
            }
        }
        reCaptchaLoadCallback();
    } else {
        $("img.captchaImg").attr("src", nv_base_siteurl + "index.php?scaptcha=captcha&nocache=" + nv_randomPassword(10));
        "undefined" != typeof a && "" != a && $(a).val("");
    }
    return !1
}';
                $output_data = str_replace($find, $replace, $output_data);
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => 'function change_captcha(a) {
    $("img.captchaImg").attr("src", nv_base_siteurl + "index.php?scaptcha=captcha&nocache=" + nv_randomPassword(10));
    "undefined" != typeof a && "" != a && $(a).val("");
    return !1
}',
                    'replace' => 'function change_captcha(a) {
    if (typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
        for (i = 0, j = reCapIDs.length; i < j; i++) {
            var ele = reCapIDs[i];
            var btn = nv_recaptcha_elements[ele[0]];
            if ($(\'#\' + btn.id).length) {
                if (typeof btn.btn != "undefined" && btn.btn != "") {
                    btn.btn.prop(\'disabled\', true);
                }
                grecaptcha.reset(ele[1]);
            }
        }
        reCaptchaLoadCallback();
    } else {
        $("img.captchaImg").attr("src", nv_base_siteurl + "index.php?scaptcha=captcha&nocache=" + nv_randomPassword(10));
        "undefined" != typeof a && "" != a && $(a).val("");
    }
    return !1
}'
                ));
            }
            
            // Thay thế hàm modalShow nếu có
            if (preg_match("/function[\s]+modalShow[\s]*\(/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/function[\s]+modalShow[\s]*\([\s]*([a-z0-9]+)[\s]*\,[\s]*([a-z0-9]+)[\s]*\)[\s]*\{/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'function modalShow(a, b, callback) {';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => 'function modalShow(a, b) {',
                        'replace' => 'function modalShow(a, b, callback) {'
                    ));
                }
                
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/\\$\([\s]*(\"|')\#sitemodal(\"|')[\s]*\)\.on[\s]*\([\s]*(\"|')hidden\.bs\.modal(.*)\.modal[\s]*\([\s]*\{backdrop[\s]*\:[\s]*(\"|')static(\"|')[\s]*\}[\s]*\)\;*/s", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'var scrollTop = false;
    if (typeof callback != "undefined") {
        if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
            scrollTop = $(window).scrollTop();
            $(\'#sitemodal\').on(\'show.bs.modal\', function() {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            });
        }
    }
    if (scrollTop) {
        $("html,body").animate({scrollTop: 0}, 200, function() {
            $("#sitemodal").modal({
                backdrop: "static"
            });
        });
        $(\'#sitemodal\').on(\'hide.bs.modal\', function() {
            $("html,body").animate({scrollTop: scrollTop}, 200);
        });
    } else {
        $("#sitemodal").modal({
            backdrop: "static"
        });
    }
    $(\'#sitemodal\').on(\'hidden.bs.modal\', function() {
        $("#sitemodal .modal-content").find(".modal-header").remove();
    });';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => '// Hàm modalShow',
                        'replaceMessage' => 'Trong hàm đó tìm',
                        'replace' => '    $(\'#sitemodal\').on(\'hidden.bs.modal\', function () {
            $("#sitemodal .modal-content").find(".modal-header").remove()
        });
    $("#sitemodal").modal({backdrop: "static"})',
                        'addafterMessage' => 'Thay lại thành',
                        'addafter' => '    var scrollTop = false;
    if (typeof callback != "undefined") {
        if (callback == "recaptchareset" && typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha) {
            scrollTop = $(window).scrollTop();
            $(\'#sitemodal\').on(\'show.bs.modal\', function() {
                $(\'[data-toggle="recaptcha"]\', $(this)).each(function() {
                    var parent = $(this).parent();
                    var oldID = $(this).attr(\'id\');
                    var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
                    var ele;
                    var btn = false, pnum = 0, btnselector = \'\';
                    
                    $(this).remove();
                    parent.append(\'<div id="\' + id + \'" data-toggle="recaptcha"></div>\');
                    
                    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
                        ele = nv_recaptcha_elements[i];
                        if (typeof ele.pnum != "undefined" && typeof ele.btnselector != "undefined" && ele.pnum && ele.btnselector != "" && ele.id == oldID) {
                            pnum = ele.pnum;
                            btnselector = ele.btnselector;
                            btn = $(\'#\' + id);
                            for (k = 1; k <= ele.pnum; k ++) {
                                btn = btn.parent();
                            }
                            btn = $(ele.btnselector, btn);
                            break;
                        }
                    }
                    var newEle = {};
                    newEle.id = id;
                    if (btn != false) {
                        newEle.btn = btn;
                        newEle.pnum = pnum;
                        newEle.btnselector = btnselector;
                    }
                    nv_recaptcha_elements.push(newEle);
                });
                reCaptchaLoadCallback();
            });
        }
    }
    if (scrollTop) {
        $("html,body").animate({scrollTop: 0}, 200, function() {
            $("#sitemodal").modal({
                backdrop: "static"
            });
        });
        $(\'#sitemodal\').on(\'hide.bs.modal\', function() {
            $("html,body").animate({scrollTop: scrollTop}, 200);
        });
    } else {
        $("#sitemodal").modal({
            backdrop: "static"
        });
    }
    $(\'#sitemodal\').on(\'hidden.bs.modal\', function() {
        $("#sitemodal .modal-content").find(".modal-header").remove();
    });'
                    ));
                }
            }
            
            // Thay thế hàm modalShowByObj nếu có
            if (preg_match("/function[\s]+modalShowByObj[\s]*\(/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/function[\s]+modalShowByObj[\s]*\([\s]*a[\s]*\)[\s]*\{/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'function modalShowByObj(a, callback) {';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => 'function modalShowByObj(a) {',
                        'replace' => 'function modalShowByObj(a, callback) {'
                    ));
                }
                
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/modalShow[\s]*\([\s]*b[\s]*\,[\s]*c[\s]*\)\;*[\s\n\t\r]+\}/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'modalShow(b, c, callback)
}';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => '    modalShow(b, c)
}',
                        'replace' => '    modalShow(b, c, callback)
}'
                    ));
                }
            }
            
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'js');
            
            $replace = 'var reCaptchaLoadCallback = function() {
    for (i = 0, j = nv_recaptcha_elements.length; i < j; i++) {
        var ele = nv_recaptcha_elements[i];
        if ($(\'#\' + ele.id).length && typeof reCapIDs[i] == "undefined") {
            var size = \'\';
            if (typeof ele.btn != "undefined" && ele.btn != "") {
                ele.btn.prop(\'disabled\', true);
            }
            if (typeof ele.size != "undefined" && ele.size == "compact") {
                size = \'compact\';
            }
            reCapIDs.push([
                i, grecaptcha.render(ele.id, {
                    \'sitekey\': nv_recaptcha_sitekey,
                    \'type\': nv_recaptcha_type,
                    \'size\': size,
                    \'callback\': reCaptchaResCallback
                })
            ]);
        }
    }
}

var reCaptchaResCallback = function() {
    for (i = 0, j = reCapIDs.length; i < j; i++) {
        var ele = reCapIDs[i];
        var btn = nv_recaptcha_elements[ele[0]];
        if ($(\'#\' + btn.id).length) {
            var res = grecaptcha.getResponse(ele[1]);
            if (res != "") {
                if (typeof btn.btn != "undefined" && btn.btn != "") {
                    btn.btn.prop(\'disabled\', false);
                }
            }
        }
    }
}

// Run Captcha
$(window).on(\'load\', function() {
    if (typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha && nv_recaptcha_elements.length > 0) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.async = !0;
        a.src = "https://www.google.com/recaptcha/api.js?hl=" + nv_lang_interface + "&onload=reCaptchaLoadCallback&render=explicit";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }
});
';
            
            nvUpdateSetItemData('base', array(
                'status' => 1,
                'find' => '/* Dòng cuối của file */',
                'replace' => $replace
            ));
            
            $output_data .= "\n\n\n" . $replace;
            
            // Thành phần nếu tồn tại thì phải làm thủ công
            if (preg_match("/\\$\([\s]*(\"|')\[data\-toggle\=tip\][\s]*\,[\s]*\[data\-toggle\=ftip\](\"|')[\s]*\)\.click/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                if (preg_match("/a[\s]*\!\=[\s]*c[\s]*\?[\s]*\([\s]*\"\"[\s]*\!\=[\s]*c[\s]*\&\&[\s]*\\$\([\s]*\'\[data\-target(.*)ftipShow[\s]*\([\s]*this[\s]*\,[\s]*a[\s]*\)[\s]*\;/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = 'var callback = $(this).data("callback");
        a != c ? ("" != c && $(\'[data-target="\' + c + \'"]\').attr("data-click", "y"), "tip" == b ? ($("#tip .bg").html(d), tipShow(this, a, callback)) : ($("#ftip .bg").html(d), ftipShow(this, a, callback))) : "n" == $(this).attr("data-click") ? "tip" == b ? tipHide() : ftipHide() : "tip" == b ? tipShow(this, a, callback) : ftipShow(this, a, callback);';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('base', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('base', array(
                        'find' => '    $("[data-toggle=tip], [data-toggle=ftip]").click(function() {
        var a = $(this).attr("data-target"),
            d = $(a).html(),
            b = $(this).attr("data-toggle"),
            c = "tip" == b ? $("#tip").attr("data-content") : $("#ftip").attr("data-content");
        a != c ? ("" != c && $(\'[data-target="\' + c + \'"]\').attr("data-click", "y"), "tip" == b ? ($("#tip .bg").html(d), tipShow(this, a)) : ($("#ftip .bg").html(d), ftipShow(this, a))) : "n" == $(this).attr("data-click") ? "tip" == b ? tipHide() : ftipHide() : "tip" == b ? tipShow(this, a) : ftipShow(this, a);
        return !1
    });',
                        'addbeforeMessage' => 'Trong đó xác định',
                        'addbefore' => '        a != c ? ("" != c && $(\'[data-target="\' + c + \'"]\').attr("data-click", "y"), "tip" == b ? ($("#tip .bg").html(d), tipShow(this, a)) : ($("#ftip .bg").html(d), ftipShow(this, a))) : "n" == $(this).attr("data-click") ? "tip" == b ? tipHide() : ftipHide() : "tip" == b ? tipShow(this, a) : ftipShow(this, a);',
                        'addafterMessage' => 'Thay bằng',
                        'addafter' => '        var callback = $(this).data("callback");
        a != c ? ("" != c && $(\'[data-target="\' + c + \'"]\').attr("data-click", "y"), "tip" == b ? ($("#tip .bg").html(d), tipShow(this, a, callback)) : ($("#ftip .bg").html(d), ftipShow(this, a, callback))) : "n" == $(this).attr("data-click") ? "tip" == b ? tipHide() : ftipHide() : "tip" == b ? tipShow(this, a, callback) : ftipShow(this, a, callback);'
                    ));
                }
            }
            
            // Các thành phần dưới đây không bắt buộc
            if (preg_match("/script\.src[\s]*\=[\s]*(\"|')https\:\/\/maps\.googleapis\.com([^\n]+)initializeMap(\"|')[\s]*\;/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                $find = $m[0];
                $replace = 'script.src = \'https://maps.googleapis.com/maps/api/js?\' + ($(this).data(\'apikey\') != \'\' ? \'key=\' + $(this).data(\'apikey\') + \'&\' : \'\') + \'callback=initializeMap\';';
                $output_data = str_replace($find, $replace, $output_data);
                
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            }

            if (preg_match("/https\:\/\/apis\.google\.com\/js\/plusone\.js/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                $find = $m[0];
                $replace = '//apis.google.com/js/plusone.js';
                $output_data = str_replace($find, $replace, $output_data);
                
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            }
            
            if (preg_match("/http\:\/\/platform\.twitter\.com\/widgets\.js/", $output_data, $m)) {
                nv_get_update_result('base');
                nvUpdateContructItem('base', 'js');
                
                $find = $m[0];
                $replace = '//platform.twitter.com/widgets.js';
                $output_data = str_replace($find, $replace, $output_data);
                
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            }
        }
        
        if ($contents_file != $output_data) {
            //file_put_contents($file, $output_data, LOCK_EX);
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
