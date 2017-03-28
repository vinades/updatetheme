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

$global_autokey = -1;
$file_key = '';
$file = '';
$array_update_result = array();

/**
 * nv_get_update_result()
 * 
 * @param mixed $key
 * @return void
 */
function nv_get_update_result($key)
{
    global $array_update_result, $theme_update, $file_key, $file;
    
    if (!isset($array_update_result[$key])) {
        $array_update_result[$key] = array();
    }
    if (!isset($array_update_result[$key]['files'])) {
        $array_update_result[$key]['files'] = array();
    }
    if (!isset($array_update_result[$key]['files'][$file_key])) {
        $array_update_result[$key]['files'][$file_key] = array(
            'name' => str_replace(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/', '', $file),
            'data' => array()
        );
    }
}

function nvUpdateContructItem($item_key, $item_type = 'php')
{
    global $array_update_result, $file_key, $global_autokey;
    $global_autokey++;
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey] = array(
        'find' => '',
        'replace' => '',
        'status' => 0,
        'guide' => array(),
        'type' => $item_type
    );
}

function nvUpdateSetItemData($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey;    
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey] = array_merge($array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey], $array);
}

function nvUpdateSetItemGuide($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey;
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey]['guide'] = array_merge($array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey]['guide'], $array);
}

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
    $array_update_result['voting'] = array('title' => 'Cập nhật giao diện module voting', 'note' => 'Nếu giao diện của bạn tồn tại themes/ten-theme/js/voting.js cần đối chiếu với themes/default/js/voting.js để chỉnh sửa phù hợp với chức năng mới (thêm captcha)', 'files' => array());
    $array_update_result['news'] = array('title' => 'Cập nhật giao diện module news', 'note' => '', 'files' => array());
    $array_update_result['users'] = array('title' => 'Cập nhật giao diện module users', 'note' => '', 'files' => array());
    
    foreach ($files as $file) {
        $contents_file = file_get_contents($file);
        $output_data = $contents_file;
        $file_key = md5(strtolower($file));
        
        // Thay thế js, tpl
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
            
            if (preg_match('/voting\/main\.tpl$/', $file)) {
                nv_get_update_result('voting');
                nvUpdateContructItem('voting', 'html');
                
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
                if (preg_match("/\<\!\-\-\s*END\:\s*loop\s*\-\-\>/", $output_data, $m)) {
                    $output_data = str_replace($m[0], $replace . "\n" . $m[0], $output_data);
                    nvUpdateSetItemData('voting', array(
                        'find' => $m[0],
                        'replace' => $replace . "\n" . $m[0],
                        'status' => 1
                    ));
                } else {
                    nvUpdateSetItemGuide('voting', array(
                        'find' => '
<!-- END: loop -->
<!-- END: main -->
                        ',
                        'addbefore' => $replace
                    ));
                }
            } elseif (preg_match('/voting\/global\.voting\.tpl$/', $file)) {
                nv_get_update_result('voting');
                nvUpdateContructItem('voting', 'js');
                
                $find = 'nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\')';
                $replace = 'nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\', \'{VOTING.active_captcha}\')';
                
                $output_data1 = str_replace($find, $replace, $output_data);
                if ($output_data1 != $output_data) {
                    nvUpdateSetItemData('voting', array(
                        'find' => $find,
                        'replace' => $replace,
                        'status' => 1
                    ));
                } else {
                    nvUpdateSetItemGuide('voting', array(
                        'find' => '<input class="btn btn-success btn-sm" type="button" value="{VOTING.langsubmit}" onclick="nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\');" />',
                        'replace' => '<input class="btn btn-success btn-sm" type="button" value="{VOTING.langsubmit}" onclick="nv_sendvoting(this.form, \'{VOTING.vid}\', \'{VOTING.accept}\', \'{VOTING.checkss}\', \'{VOTING.errsm}\', \'{VOTING.active_captcha}\');" />'
                    ));
                }
                
                nvUpdateContructItem('voting', 'js');
                
                $find = 'nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\')';
                $replace = 'nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\', \'{VOTING.active_captcha}\')';
                
                $output_data = str_replace($find, $replace, $output_data1);
                if ($output_data1 != $output_data) {
                    nvUpdateSetItemData('voting', array(
                        'find' => $find,
                        'replace' => $replace,
                        'status' => 1
                    ));
                } else {
                    nvUpdateSetItemGuide('voting', array(
                        'find' => '<input class="btn btn-primary btn-sm" value="{VOTING.langresult}" type="button" onclick="nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\');" />',
                        'replace' => '<input class="btn btn-primary btn-sm" value="{VOTING.langresult}" type="button" onclick="nv_sendvoting(this.form, \'{VOTING.vid}\', 0, \'{VOTING.checkss}\', \'\', \'{VOTING.active_captcha}\');" />'
                    ));
                }
                
                nvUpdateContructItem('voting', 'html');
                
                $find = '<!-- END: main -->';
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
                $output_data1 = str_replace($find, $replace, $output_data);
                if ($output_data1 != $output_data) {
                    nvUpdateSetItemData('voting', array(
                        'find' => $find,
                        'replace' => $replace,
                        'status' => 1
                    ));
                } else {
                    nvUpdateSetItemGuide('voting', array(
                        'find' => '<!-- END: main -->',
                        'addbefore' => '
<!-- BEGIN: captcha -->
<div id="voting-modal-{VOTING.vid}" class="hidden">
    <div class="m-bottom">
        <strong>{LANG.enter_captcha}</strong>
    </div>
    <div class="clearfix">
        <div class="margin-bottom">
            <div class="row">
                <div class="col-xs-12">
                    <input type="text" class="form-control rsec" value="" name="captcha" maxlength="{GFX_MAXLENGTH}"/>
                </div>
                <div class="col-xs-12">
                    <img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" height="32" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" />
    				<em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha(\'.rsec\');"></em>
                </div>
            </div>
        </div>
        <input type="button" name="submit" class="btn btn-primary btn-block" value="{VOTING.langsubmit}" onclick="nv_sendvoting_captcha(this, {VOTING.vid}, \'{LANG.enter_captcha_error}\');"/>
    </div>
</div>
<!-- END: captcha -->
                        '
                    ));
                }
                $output_data = $output_data1;
            } elseif (preg_match('/news\/block\_groups\.tpl$/', $file)) {
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
            } elseif (preg_match('/users\/confirm\.tpl$/', $file)) {
                if (preg_match("/name\=\"openid\_account\_confirm\"([^\n]+)/", $output_data, $m)) {
                    $output_data = str_replace($m[0], $m[0] . "\n					<!-- BEGIN: redirect --><input name=\"nv_redirect\" value=\"{REDIRECT}\" type=\"hidden\" /><!-- END: redirect -->", $output_data);
                    $file_changed = true;
                }
            } elseif (preg_match('/users\/info\.tpl$/', $file)) {
                if (preg_match("/\<\!\-\-\s*END\:\s*edit_passw([^\n]+)/", $output_data, $m)) {
                    $output_data = str_replace($m[0], $m[0] . "\n        <!-- BEGIN: 2step --><li><a href=\"{URL_2STEP}\">{LANG.2step_status}</a></li><!-- END: 2step -->", $output_data);
                    $file_changed = true;
                }
            }
        } elseif (preg_match('/' . nv_preg_quote($theme_update) . '\/theme\.php$/', $file)) {
            // Sửa luật rewrite theme.php
            $contents_file = file_get_contents($file);
            $output_data = $contents_file;
            
            nv_get_update_result('base');
            nvUpdateContructItem('base', 'php');
            
            if (preg_match("/global \\$([a-zA-Z0-9\_\,\s\\$]+)\;/i", $contents_file, $m)) {
                $m[1] = '$' . $m[1];
                $array_variable = array_map('trim', explode(',', $m[1]));
                if (!in_array('$rewrite_keys', $array_variable)) {
                    $array_variable[] = '$rewrite_keys';
                }
                $array_variable = 'global ' . implode(', ', $array_variable) . ';';
                $output_data = str_replace($m[0], $array_variable, $output_data);
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $m[0],
                    'replace' => $array_variable,
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => 'global $home, $array_mod_title, $lang_global, $language_array',
                    'replaceMessage' => 'Trong dòng đó thêm vào cuối trước dấu <code>;</code>',
                    'replace' => ', $rewrite_keys'
                ));
            }

            nvUpdateContructItem('base', 'php');

            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'THEME_SEARCH_URL\'\,(.*?)\)\;/i", $output_data, $m)) {
                $replace = "\n        if (empty(\$rewrite_keys)) {\n";
                $replace .= "            \$xtpl->assign('THEME_SEARCH_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek&amp;q=');\n";
                $replace .= "        } else {\n";
                $replace .= "            \$xtpl->assign('THEME_SEARCH_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek', true) . '?q=');\n";
                $replace .= "        }\n";
                $output_data = str_replace($m[0], $replace, $output_data);
                $rewrite_theme = true;
                nvUpdateSetItemData('base', array(
                    'status' => 1,
                    'find' => $m[0],
                    'replace' => $replace,
                ));
            } else {
                nvUpdateSetItemGuide('base', array(
                    'find' => '$xtpl->assign(\'THEME_SEARCH_URL\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek&q=\');',
                    'replace' => '
if (empty($rewrite_keys)) {
    $xtpl->assign(\'THEME_SEARCH_URL\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek&amp;q=\');
} else {
    $xtpl->assign(\'THEME_SEARCH_URL\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=seek\', true) . \'?q=\');
}
                    '
                ));
            }

            if ($output_data != $contents_file) {
                $file_changed = true;
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
                    'findMessage' => 'Tìm các đoạn có dạng (khoảng 2)',
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
            
            if (preg_match("/if\s*\(\\\$module\_config\s*\[\s*\\\$module\_name\s*\]\s*\[\s*\'showtooltip'\s*\]\s*\)\s*\{[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'TOOLTIP\_POSIT([^\}]+)\.other\.tooltip\'\s*\)\s*\;[\s\n\t\r]*\}/isU", $output_data, $m)) {
                //print_r($m);
                //die();
            }
            
            
            nvUpdateSetItemGuide('news', array(
                'find' => '$topic_array_i[\'hometext\'] = nv_clean60($topic_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                'replace' => '$topic_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($topic_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
            ));
        }
        
        if ($contents_file != $output_data) {
            //die($output_data);
        }
    }
    
    //print_r($array_update_result);
    //die();
    
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
                        $guide['findMessage'] = !empty($guide['findMessage']) ? $guide['findMessage'] : 'Tìm';
                        $guide['replaceMessage'] = !empty($guide['replaceMessage']) ? $guide['replaceMessage'] : 'Thay bằng';
                        $guide['addbeforeMessage'] = !empty($guide['addbeforeMessage']) ? $guide['addbeforeMessage'] : 'Thêm lên trên';
                        
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
} else {
    $xtpl->parse('main.form');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
