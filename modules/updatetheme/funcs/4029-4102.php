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

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('THEMEUPDATE', $theme_update);
$xtpl->assign('NV_TEMP_DIR', NV_TEMP_DIR);

$global_autokey = -1;
$file_key = '';
$file = '';
$array_update_result = array();

$num_section_auto = 0;
$num_section_manual = 0;

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

/**
 * nvUpdateContructItem()
 * 
 * @param mixed $item_key
 * @param string $item_type
 * @return void
 */
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

/**
 * nvUpdateSetItemData()
 * 
 * @param mixed $item_key
 * @param mixed $array
 * @return void
 */
function nvUpdateSetItemData($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey, $num_section_auto;
    $num_section_auto++;    
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey] = array_merge($array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey], $array);
}

/**
 * nvUpdateSetItemGuide()
 * 
 * @param mixed $item_key
 * @param mixed $array
 * @return void
 */
function nvUpdateSetItemGuide($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey, $num_section_manual;
    $num_section_manual++;
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
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'html'); 
                if (preg_match("/name\=\"openid\_account\_confirm\"([^\n]+)/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = $m[0] . "\n					<!-- BEGIN: redirect --><input name=\"nv_redirect\" value=\"{REDIRECT}\" type=\"hidden\" /><!-- END: redirect -->";
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '<input name="openid_account_confirm" value="1" type="hidden" />',
                        'addafter' => '<!-- BEGIN: redirect --><input name="nv_redirect" value="{REDIRECT}" type="hidden" /><!-- END: redirect -->'
                    ));
                }
            } elseif (preg_match('/users\/info\.tpl$/', $file)) {
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'html'); 
                if (preg_match("/\<\!\-\-\s*END\:\s*edit_passw([^\n]+)/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = $m[0] . "\n        <!-- BEGIN: 2step --><li><a href=\"{URL_2STEP}\">{LANG.2step_status}</a></li><!-- END: 2step -->";
                    $output_data = str_replace($m[0], $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '<!-- BEGIN: edit_password --><li class="{PASSWORD_ACTIVE}"><a data-toggle="tab" data-location="{EDITINFO_FORM}/password" href="#edit_password">{LANG.edit_password}</a></li><!-- END: edit_password -->',
                        'addafter' => '<!-- BEGIN: 2step --><li><a href="{URL_2STEP}">{LANG.2step_status}</a></li><!-- END: 2step -->'
                    ));
                }
            } elseif (preg_match('/users\/login\_form\.tpl$/', $file)) {
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'html');
                
                if (preg_match("/\<div class\=\"([^\"]+)\"\>[\s\n\t\r]*\<div class\=\"input\-group\"\>[\s\n\t\r]*\<span class\=\"input\-group\-addon\"\>\<em class\=\"([^\"]+)\"\>\<\/em\>\<\/span\>[\s\n\t\r]*\<input type\=\"text\"([^\>]+)name\=\"nv\_login\"/is", $output_data, $m)) {
                    $find = $m[0];
                    $replace = str_replace('"' . $m[1] . '"', '"' . $m[1] . ' loginstep1"', $m[0]);
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><em class="fa fa-user fa-lg"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.username_email}" value="" name="nv_login" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.username_empty}">
            </div>
        </div>
                        ',
                        'replace' => '
        <div class="form-group loginstep1">
            <div class="input-group">
                <span class="input-group-addon"><em class="fa fa-user fa-lg"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.username_email}" value="" name="nv_login" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.username_empty}">
            </div>
        </div>
                        '
                    ));
                }
                
                nvUpdateContructItem('users', 'html');
                
                if (preg_match("/\<div class\=\"([^\"]+)\"\>[\s\n\t\r]*\<div class\=\"input\-group\"\>[\s\n\t\r]*\<span class\=\"input\-group\-addon\"\>\<em class\=\"([^\"]+)\"\>\<\/em\>\<\/span\>[\s\n\t\r]*\<input type\=\"password\"([^\>]+)name\=\"nv\_password\"/is", $output_data, $m)) {
                    $find = $m[0];
                    $replace = str_replace('"' . $m[1] . '"', '"' . $m[1] . ' loginstep1"', $m[0]);
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '
        <div class="form-group loginstep1">
            <div class="input-group">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="password" class="required form-control" placeholder="{GLANG.password}" value="" name="nv_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.password_empty}">
            </div>
        </div>
                        ',
                        'replace' => '
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="password" class="required form-control" placeholder="{GLANG.password}" value="" name="nv_password" maxlength="100" data-pattern="/^(.){3,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.password_empty}">
            </div>
        </div>
                        '
                    ));
                }
                
                nvUpdateContructItem('users', 'html');
                
                if (preg_match("/\<\!\-\-\s*BEGIN\:\s*captcha\s*\-\-\>[\s\n\t\r]*\<div class\=\"form\-group\"\>/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = '
        <div class="form-group loginstep2 hidden">
            <label class="margin-bottom">{GLANG.2teplogin_totppin_label}</label>
            <div class="input-group margin-bottom">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.2teplogin_totppin_placeholder}" value="" name="nv_totppin" maxlength="6" data-pattern="/^(.){6,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.2teplogin_totppin_placeholder}">
            </div>
            <div class="text-center">
                <a href="#" onclick="login2step_change(this);">{GLANG.2teplogin_other_menthod}</a>
            </div>
        </div>
        
        <div class="form-group loginstep3 hidden">
            <label class="margin-bottom">{GLANG.2teplogin_code_label}</label>
            <div class="input-group margin-bottom">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.2teplogin_code_placeholder}" value="" name="nv_backupcodepin" maxlength="8" data-pattern="/^(.){8,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.2teplogin_code_placeholder}">
            </div>
            <div class="text-center">
                <a href="#" onclick="login2step_change(this);">{GLANG.2teplogin_other_menthod}</a>
            </div>
        </div>
        
        <!-- BEGIN: captcha -->
        <div class="form-group loginCaptcha">
                    ';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '
        <!-- BEGIN: captcha -->
        <div class="form-group">
                        ',
                        'replace' => '
        <!-- BEGIN: captcha -->
        <div class="form-group loginCaptcha">
                        ',
                        'addbefore' => '
        <div class="form-group loginstep2 hidden">
            <label class="margin-bottom">{GLANG.2teplogin_totppin_label}</label>
            <div class="input-group margin-bottom">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.2teplogin_totppin_placeholder}" value="" name="nv_totppin" maxlength="6" data-pattern="/^(.){6,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.2teplogin_totppin_placeholder}">
            </div>
            <div class="text-center">
                <a href="#" onclick="login2step_change(this);">{GLANG.2teplogin_other_menthod}</a>
            </div>
        </div>
        
        <div class="form-group loginstep3 hidden">
            <label class="margin-bottom">{GLANG.2teplogin_code_label}</label>
            <div class="input-group margin-bottom">
                <span class="input-group-addon"><em class="fa fa-key fa-lg fa-fix"></em></span>
                <input type="text" class="required form-control" placeholder="{GLANG.2teplogin_code_placeholder}" value="" name="nv_backupcodepin" maxlength="8" data-pattern="/^(.){8,}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.2teplogin_code_placeholder}">
            </div>
            <div class="text-center">
                <a href="#" onclick="login2step_change(this);">{GLANG.2teplogin_other_menthod}</a>
            </div>
        </div>
        
                        '
                    ));
                }
            } elseif (preg_match('/users\/userinfo\.tpl$/', $file)) {
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'html');
            
                if (preg_match("/\<tr\>[\s\n\t\r]*\<td\>\{LANG\.st\_login2\}\<\/td\>[\s\n\t\r]*\<td\>\{USER\.st\_login\}\<\/td\>[\s\n\t\r]*\<\/tr\>/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = $m[0] . '
            <tr>
                <td>{LANG.2step_status}</td>
                <td>{USER.active2step} (<a href="{URL_2STEP}">{LANG.2step_link}</a>)</td>
            </tr>
                    ';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '
<tr>
    <td>{LANG.st_login2}</td>
    <td>{USER.st_login}</td>
</tr>
                        ',
                        'addafter' => '
<tr>
    <td>{LANG.2step_status}</td>
    <td>{USER.active2step} (<a href="{URL_2STEP}">{LANG.2step_link}</a>)</td>
</tr>
                        '
                    ));
                }
            } elseif (preg_match('/users\/viewdetailusers\.tpl$/', $file)) {
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'html');
            
                if (preg_match("/\<div class\=\"table\-responsive\"\>[\s\n\t\r]*\<table class\=\"table table\-bordered table\-striped\"\>/", $output_data, $m)) {
                    $find = $m[0];
                    $replace = '
    <!-- BEGIN: for_admin -->
    <div class="m-bottom clearfix">
        <div class="pull-right">
            {LANG.for_admin}: 
            <!-- BEGIN: edit --><a href="{USER.link_edit}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> {GLANG.edit}</a><!-- END: edit -->
            <!-- BEGIN: delete --><a href="#" class="btn btn-danger btn-xs" data-toggle="admindeluser" data-userid="{USER.userid}" data-link="{USER.link_delete}" data-back="{USER.link_delete_callback}"><i class="fa fa-trash-o"></i> {GLANG.delete}</a><!-- END: delete -->
        </div>
    </div>
    <!-- END: for_admin -->
    ' . $m[0];
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateSetItemData('users', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                } else {
                    nvUpdateSetItemGuide('users', array(
                        'find' => '
<div class="table-responsive">
	<table class="table table-bordered table-striped">
                        ',
                        'addbefore' => '
<!-- BEGIN: for_admin -->
<div class="m-bottom clearfix">
    <div class="pull-right">
        {LANG.for_admin}: 
        <!-- BEGIN: edit --><a href="{USER.link_edit}" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> {GLANG.edit}</a><!-- END: edit -->
        <!-- BEGIN: delete --><a href="#" class="btn btn-danger btn-xs" data-toggle="admindeluser" data-userid="{USER.userid}" data-link="{USER.link_delete}" data-back="{USER.link_delete_callback}"><i class="fa fa-trash-o"></i> {GLANG.delete}</a><!-- END: delete -->
    </div>
</div>
<!-- END: for_admin -->
                        '
                    ));
                }
            } elseif (preg_match('/js\/users\.js$/', $file)) {
                nv_get_update_result('users');
                nvUpdateContructItem('users', 'js');
                
                nvUpdateSetItemGuide('users', array(
                    'find' => 'function login_validForm(a) {',
                    'replace' => '
success: function(d) {
    var b = $("[onclick*=\'change_captcha\']", a);
    b && b.click();
    if (d.status == "error") {
        $("input,button", a).not("[type=submit]").prop("disabled", !1), 
        $(".tooltip-current", a).removeClass("tooltip-current"), 
        "" != d.input ? $(a).find("[name=\"" + d.input + "\"]").each(function() {
            $(this).addClass("tooltip-current").attr("data-current-mess", d.mess);
            validErrorShow(this)
        }) : $(".nv-info", a).html(d.mess).addClass("error").show(), setTimeout(function() {
            $("[type=submit]", a).prop("disabled", !1)
        }, 1E3)
    } else if (d.status == "ok") {
        $(".nv-info", a).html(d.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), 
        $(".form-detail", a).hide(), $("#other_form").hide(), setTimeout(function() {
            if( "undefined" != typeof d.redirect && "" != d.redirect){
                 window.location.href = d.redirect;
            }else{
                 $(\'#sitemodal\').modal(\'hide\');
                 window.location.href = window.location.href;
            }
        }, 3E3)
    } else if (d.status == "2steprequire") {
        $(".form-detail", a).hide(), $("#other_form").hide();
        $(".nv-info", a).html("<a href=\"" + d.input + "\">" + d.mess + "</a>").removeClass("error").removeClass("success").addClass("info").show();
    } else {
        $("input,button", a).prop("disabled", !1);
        $(\'.loginstep1, .loginstep2, .loginCaptcha\', a).toggleClass(\'hidden\');
    }
}
                    ',
                    'replaceMessage' => 'Bên trong hàm đó, trong phần thực thi sau khi login thành công success: function(d) { thay toàn bộ giá trị thành'
                ));
                
                nvUpdateContructItem('users', 'js');
                
                nvUpdateSetItemGuide('users', array(
                    'findMessage' => 'Mổ sung thêm hàm',
                    'find' => '
function login2step_change(ele) {
    var ele = $(ele), form = ele, i = 0;
    while (!form.is(\'form\')) {
        if (i++ > 10) {
            break;
        }
        form = form.parent();
    }
    if (form.is(\'form\')) {
        $(\'.loginstep2 input,.loginstep3 input\', form).val(\'\');
        $(\'.loginstep2,.loginstep3\', form).toggleClass(\'hidden\');
    }
    return false;
}
                    '
                ));
                
                nvUpdateContructItem('users', 'js');
                nvUpdateSetItemGuide('users', array(
                    'findMessage' => 'Bổ sung thêm lệnh xử lý cho admin',
                    'find' => '
$(document).ready(function() {
    // Delete user handler
    $(\'[data-toggle="admindeluser"]\').click(function(e) {
        e.preventDefault();
        var data = $(this).data();
        if (confirm(nv_is_del_confirm[0])) {
            $.post(data.link, \'userid=\' + data.userid, function(res) {
                if (res == \'OK\') {
                    window.location.href = data.back;
                } else {
                    var r_split = res.split("_");
                    if (r_split[0] == \'ERROR\') {
                        alert(r_split[1]);
                    } else {
                        alert(nv_is_del_confirm[2]);
                    }
                }
            });
        }
    });
});
                    '
                ));
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
        } elseif (preg_match('/modules\/users\/theme\.php$/', $file)) {
            nv_get_update_result('users');
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\s*\=\s*new XTemplate\s*\(\s*\'register\.tpl\'([^\n]+)[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'USER_REGISTER\'([^\n]+)/", $output_data, $m)) {
                $find = $m[0];
                $replace = '$xtpl = new XTemplate(\'register.tpl\'' . $m[1];
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '$xtpl = new XTemplate(\'register.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_file);',
                    'replaceMessage' => 'Bên dưới xác định và xóa',
                    'replace' => '$xtpl->assign(\'USER_REGISTER\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=register\');'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/if\s*\(\s*\\\$group\_id\s*\!\=\s*0\s*\)\s*\{[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'USER\_REGISTER\'([^\n]+)[\s\n\t\r]*\}/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . ' else {
        $xtpl->assign(\'USER_REGISTER\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=register\');
        $xtpl->parse(\'main.agreecheck\');
    }';
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '
if ($group_id != 0) {
	$xtpl->assign(\'USER_REGISTER\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=register/\' . $group_id);
}
                    ',
                    'addafter' => '
 else {
    $xtpl->assign(\'USER_REGISTER\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=register\');
    $xtpl->parse(\'main.agreecheck\');
}
                    '
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\-\>parse\s*\(\s*\'main\.tab\_edit\_password\'\s*\)\s*\;[\s\n\t\r]*\}/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . '

    if (in_array(\'2step\', $types)) {
        $xtpl->assign(\'URL_2STEP\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=two-step-verification\', true));
        $xtpl->parse(\'main.2step\');
    }
                ';
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '
    $xtpl->parse(\'main.edit_password\');
    $xtpl->parse(\'main.tab_edit_password\');
}
                    ',
                    'addafter' => '

if (in_array(\'2step\', $types)) {
    $xtpl->assign(\'URL_2STEP\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=two-step-verification\', true));
    $xtpl->parse(\'main.2step\');
}
                    '
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'URL\_GROUPS\'\,\s*nv\_url\_rewrite([^\n]+)\n/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . '    $xtpl->assign(\'URL_2STEP\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=two-step-verification\', true));' . "\n";
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '$xtpl->assign(\'URL_GROUPS\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=groups\', true));',
                    'addafter' => '$xtpl->assign(\'URL_2STEP\', nv_url_rewrite(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=two-step-verification\', true));'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\$\_user\_info\s*\[\s*\'st\_login\'\s*\]\s*\=\s*\!\s*empty\s*\(([^\n]+)\n/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . '    $_user_info[\'active2step\'] = ! empty($user_info[\'active2step\']) ? $lang_global[\'on\'] : $lang_global[\'off\'];' . "\n";
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '$_user_info[\'st_login\'] = ! empty($user_info[\'st_login\']) ? $lang_module[\'yes\'] : $lang_module[\'no\'];',
                    'addafter' => '$_user_info[\'active2step\'] = ! empty($user_info[\'active2step\']) ? $lang_global[\'on\'] : $lang_global[\'off\'];'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/function openid\_account\_confirm\s*\(\s*\\\$gfx\_chk\s*\,\s*\\\$attribs\s*\)/", $output_data, $m)) {
                $find = $m[0];
                $replace = 'function openid_account_confirm($gfx_chk, $attribs, $user)';
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => 'function openid_account_confirm($gfx_chk, $attribs)',
                    'replace' => 'function openid_account_confirm($gfx_chk, $attribs, $user)'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\s*\=\s*new XTemplate\s*\(\s*\'confirm\.tpl\'([^\n]+)\n/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . '
    $lang_module[\'openid_confirm_info\'] = sprintf($lang_module[\'openid_confirm_info\'], $attribs[\'contact/email\'], $user[\'username\']);' . "\n";
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '$xtpl = new XTemplate(\'confirm.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_file);',
                    'addafter' => '$lang_module[\'openid_confirm_info\'] = sprintf($lang_module[\'openid_confirm_info\'], $attribs[\'contact/email\'], $user[\'username\']);'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'OPENID\_LOGIN\'(.*?)\\\$xtpl\-\>parse\s*\(\s*\'main\'\s*\);/s", $output_data, $m)) {
                $find = $m[0];
                $replace = '$xtpl->assign(\'OPENID_LOGIN\'' . $m[1] . 'if (!empty($nv_redirect)) {
        $xtpl->assign(\'REDIRECT\', $nv_redirect);
        $xtpl->parse(\'main.redirect\');
    }' . "\n\n    \$xtpl->parse('main');";
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'findMessage' => 'Trong hàm openid_account_confirm tìm',
                    'find' => '
$xtpl->parse(\'main\');
return $xtpl->text(\'main\');
                    ',
                    'addbefore' => '
if (!empty($nv_redirect)) {
    $xtpl->assign(\'REDIRECT\', $nv_redirect);
    $xtpl->parse(\'main.redirect\');
}
                    '
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\s*\=\s*new XTemplate\s*\(\s*\'viewdetailusers\.tpl\'([^\n]+)[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'LANG\'\s*\,\s*\\\$lang\_module\s*\)\s*\;/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . "\n    \$xtpl->assign('GLANG', \$lang_global);";
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'findMessage' => 'Tìm hàm nv_memberslist_detail_theme, xác định trong hàm dòng',
                    'find' => '$xtpl->assign(\'LANG\', $lang_module);',
                    'addafter' => '$xtpl->assign(\'GLANG\', $lang_global);'
                ));
            }
            nvUpdateContructItem('users', 'php');
            
            if (preg_match("/\\\$xtpl\-\>assign\s*\(\s*\'USER\'\s*\,\s*\\\$item\s*\)\s*\;/", $output_data, $m)) {
                $find = $m[0];
                $replace = $m[0] . "\n" . '
    if ($item[\'is_admin\']) {
        if ($item[\'allow_edit\']) {
            $xtpl->assign(\'LINK_EDIT\', $item[\'link_edit\']);
            $xtpl->parse(\'main.for_admin.edit\');
        }
        if ($item[\'allow_delete\']) {
            $xtpl->parse(\'main.for_admin.delete\');
        }
        $xtpl->parse(\'main.for_admin\');
    }';
                nvUpdateSetItemData('users', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('users', array(
                    'find' => '$xtpl->assign(\'USER\', $item);',
                    'addafter' => '

if ($item[\'is_admin\']) {
    if ($item[\'allow_edit\']) {
        $xtpl->assign(\'LINK_EDIT\', $item[\'link_edit\']);
        $xtpl->parse(\'main.for_admin.edit\');
    }
    if ($item[\'allow_delete\']) {
        $xtpl->parse(\'main.for_admin.delete\');
    }
    $xtpl->parse(\'main.for_admin\');
}
                    '
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
