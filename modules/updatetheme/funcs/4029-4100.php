<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC.
 * All rights reserved
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

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('THEMEUPDATE', $theme_update);
$xtpl->assign('NV_TEMP_DIR', NV_TEMP_DIR);

if ($nv_Request->isset_request('submit', 'post')) {
    // Xác định danh sách các file
    $files = list_all_file(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update, NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update);
    
    $jquery_compality = array();
    $rewrite_theme = false;
    $voting_main = false;
    $voting_block = false;
    
    foreach ($files as $file) {
        $file_changed = false;
        
        // Thay thế js, tpl
        if (preg_match('/([a-zA-Z0-9\-\_\/\.]+)\.(js|tpl)$/', $file)) {
            $contents_file = file_get_contents($file);
            $output_data = preg_replace("/\\$\(\s*window\s*\)\.load\s*\(/i", "\$(window).on('load', ", $contents_file);
            
            if ($output_data != $contents_file) {
                $file_changed = true;
                $jquery_compality[] = str_replace(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/', '', $file);
            }
            
            if (preg_match('/voting\/main\.tpl$/', $file)) {
                if (preg_match("/\<\!\-\-\s*END\:\s*loop\s*\-\-\>/", $output_data, $m)) {
                    $voting_main = true;
                    $replace = "<!-- BEGIN: captcha -->
<div id=\"voting-modal-{VOTING.vid}\" class=\"hidden\">
    <div class=\"m-bottom\">
        <strong>{LANG.enter_captcha}</strong>
    </div>
    <div class=\"clearfix\">
        <div class=\"margin-bottom\">
            <div class=\"row\">
                <div class=\"col-xs-12\">
                    <input type=\"text\" class=\"form-control rsec\" value=\"\" name=\"captcha\" maxlength=\"{GFX_MAXLENGTH}\"/>
                </div>
                <div class=\"col-xs-12\">
                    <img class=\"captchaImg display-inline-block\" src=\"{SRC_CAPTCHA}\" height=\"32\" alt=\"{N_CAPTCHA}\" title=\"{N_CAPTCHA}\" />
    				<em class=\"fa fa-pointer fa-refresh margin-left margin-right\" title=\"{CAPTCHA_REFRESH}\" onclick=\"change_captcha('.rsec');\"></em>
                </div>
            </div>
        </div>
        <input type=\"button\" name=\"submit\" class=\"btn btn-primary btn-block\" value=\"{VOTING.langsubmit}\" onclick=\"nv_sendvoting_captcha(this, {VOTING.vid}, '{LANG.enter_captcha_error}');\"/>
    </div>
</div>
<!-- END: captcha -->";
                    $output_data = str_replace($m[0], $replace . "\n" . $m[0], $output_data);
                    $file_changed = true;
                }
            } elseif (preg_match('/voting\/global\.voting\.tpl$/', $file)) {
                $check1 = $check2 = $check3 = false;
                $output_data1 = str_replace('nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\')', 'nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\', \'{VOTING.active_captcha}\')', $output_data);
                if ($output_data1 != $output_data) {
                    $check1 = true;
                }
                $output_data = str_replace('nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\')', 'nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\', \'{VOTING.active_captcha}\')', $output_data1);
                if ($output_data1 != $output_data) {
                    $check2 = true;
                }
                $replace = "<!-- BEGIN: captcha -->
<div id=\"voting-modal-{VOTING.vid}\" class=\"hidden\">
    <div class=\"m-bottom\">
        <strong>{LANG.enter_captcha}</strong>
    </div>
    <div class=\"clearfix\">
        <div class=\"margin-bottom\">
            <div class=\"row\">
                <div class=\"col-xs-12\">
                    <input type=\"text\" class=\"form-control rsec\" value=\"\" name=\"captcha\" maxlength=\"{GFX_MAXLENGTH}\"/>
                </div>
                <div class=\"col-xs-12\">
                    <img class=\"captchaImg display-inline-block\" src=\"{SRC_CAPTCHA}\" height=\"32\" alt=\"{N_CAPTCHA}\" title=\"{N_CAPTCHA}\" />
    				<em class=\"fa fa-pointer fa-refresh margin-left margin-right\" title=\"{CAPTCHA_REFRESH}\" onclick=\"change_captcha('.rsec');\"></em>
                </div>
            </div>
        </div>
        <input type=\"button\" name=\"submit\" class=\"btn btn-primary btn-block\" value=\"{VOTING.langsubmit}\" onclick=\"nv_sendvoting_captcha(this, {VOTING.vid}, '{LANG.enter_captcha_error}');\"/>
    </div>
</div>
<!-- END: captcha -->\n<!-- END: main -->";
                $output_data1 = str_replace('<!-- END: main -->', $replace, $output_data);
                if ($output_data1 != $output_data) {
                    $check3 = true;
                }
                $output_data = $output_data1;
                if ($check2 and $check1 and $check3) {
                    $file_changed = true;
                    $voting_block = true;
                }
            } elseif (preg_match('/news\/block\_groups\.tpl$/', $file)) {
                $output_data = str_replace('{ROW.hometext}', '{ROW.hometext_clean}', $output_data);
                $output_data = str_replace('>{ROW.title}<', '>{ROW.title_clean}<', $output_data);
                $output_data = str_replace('> {ROW.title} <', '> {ROW.title_clean} <', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/block\_headline\.tpl$/', $file)) {
                $output_data = str_replace('{LASTEST.hometext}', '{LASTEST.hometext_clean}', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/block\_news\.tpl$/', $file)) {
                $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/block\_newscenter\.tpl$/', $file)) {
                $output_data = str_replace('{othernews.hometext}', '{othernews.hometext_clean}', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/block\_tophits\.tpl$/', $file)) {
                $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/detail\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{TOPIC.hometext}"', 'data-content="{TOPIC.hometext_clean}"', $output_data);
                $output_data = str_replace('data-content="{RELATED_NEW.hometext}"', 'data-content="{RELATED_NEW.hometext_clean}"', $output_data);
                $output_data = str_replace('data-content="{RELATED.hometext}"', 'data-content="{RELATED.hometext_clean}"', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/viewcat\_list\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/viewcat\_main\_bottom\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/viewcat\_main\_left\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/viewcat\_main\_right\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);
                $file_changed = true;
            } elseif (preg_match('/news\/viewcat\_two\_column\.tpl$/', $file)) {
                $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);
                $file_changed = true;
            }
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/theme\.php$/', $file)) {
            // Sửa luật rewrite theme.php
            $contents_file = file_get_contents($file);
            $output_data = $contents_file;
            
            if (preg_match("/global \\$([a-zA-Z0-9\_\,\s\\$]+)\;/i", $contents_file, $m)) {
                $m[1] = '$' . $m[1];
                $array_variable = array_map('trim', explode(',', $m[1]));
                if (!in_array('$rewrite_keys', $array_variable)) {
                    $array_variable[] = '$rewrite_keys';
                }
                $array_variable = 'global ' . implode(', ', $array_variable) . ';';
                $output_data = str_replace($m[0], $array_variable, $output_data);
            }

            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'THEME_SEARCH_URL\'\,(.*?)\)\;/i", $output_data, $m)) {
                $replace = "\n        if (empty(\$rewrite_keys)) {\n";
                $replace .= "            \$xtpl->assign('THEME_SEARCH_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek&amp;q=');\n";
                $replace .= "        } else {\n";
                $replace .= "            \$xtpl->assign('THEME_SEARCH_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek', true) . '?q=');\n";
                $replace .= "        }\n";
                $output_data = str_replace($m[0], $replace, $output_data);
                $rewrite_theme = true;
            }

            if ($output_data != $contents_file) {
                $file_changed = true;
            }
        } elseif (preg_match('/modules\/news\/theme\.php$/', $file)) {
            $contents_file = file_get_contents($file);
        }
        
        if ($file_changed) {
            //die($output_data);
        }
    }
    
    //print_r($jquery_compality);
    //die();
    
    if (empty($jquery_compality)) {
        $xtpl->parse('main.result.empty_jquery_compality');
    } else {
        foreach ($jquery_compality as $compality) {
            $xtpl->assign('FILE', $compality);
            $xtpl->parse('main.result.jquery_compality.loop');
        }
        $xtpl->parse('main.result.jquery_compality');
    }
    
    if ($rewrite_theme) {
        $xtpl->parse('main.result.rewrite_theme_auto');
    } else {
        $xtpl->parse('main.result.rewrite_theme_manual');
    }
    
    // Chỉnh sửa giao diện Voting
    if (is_dir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/voting')) {
        if ($voting_main) {
            $xtpl->parse('main.result.voting.voting_main_auto');
        } else {
            $xtpl->parse('main.result.voting.voting_main_manual');
        }
        if ($voting_block) {
            $xtpl->parse('main.result.voting.voting_block_auto');
        } else {
            $xtpl->parse('main.result.voting.voting_block_manual');
        }
        
        if (is_file(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/js/voting.js')) {
            $xtpl->parse('main.result.voting.js');
        }
        
        $xtpl->parse('main.result.voting');
    }
    
    // Chỉnh giao diện news
    if (is_dir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/news')) {
        
        $xtpl->parse('main.result.news');
    }
    
    // Chỉnh giao diện users
    if (is_dir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/modules/users')) {
        
        $xtpl->parse('main.result.users');
    }
    
    $xtpl->parse('main.result');
} else {
    $xtpl->parse('main.form');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
