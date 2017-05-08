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

if (preg_match('/comment\/main\.tpl$/', $file)) {
    nv_get_update_result('comment');
    nvUpdateContructItem('comment', 'html');
    
    if (preg_match("/\<\!\-\-[\s]*END\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '            <!-- BEGIN: recaptcha -->
            <div class="form-group clearfix">
                <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    btn: $("#buttoncontent", $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent())
                })
                </script>
            </div>
            <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => '			<!-- END: captcha -->',
            'addafter' => '            <!-- BEGIN: recaptcha -->
            <div class="form-group clearfix">
                <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    btn: $("#buttoncontent", $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent())
                })
                </script>
            </div>
            <!-- END: recaptcha -->'
        ));
    }
    
    nvUpdateContructItem('comment', 'html');
    
    if (preg_match("/onclick[\s]*\=[\s]*(\"|')[\s]*sendcommment[\s]*\([\s]*(\"|')\{MODULE_COMM\}(\"|')[\s]*\,/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'onclick=' . $m[1] . 'sendcommment(this, ' . $m[2] . '{MODULE_COMM}' . $m[3] . ',';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => '				<input id="buttoncontent" type="button" value="{LANG.comment_submit}" onclick="sendcommment(\'{MODULE_COMM}\', \'{MODULE_DATA}_commentcontent\', \'{AREA_COMM}\', \'{ID_COMM}\', \'{ALLOWED_COMM}\', \'{CHECKSS_COMM}\', {GFX_NUM});" class="btn btn-primary" />',
            'replace' => '				<input id="buttoncontent" type="button" value="{LANG.comment_submit}" onclick="sendcommment(this, \'{MODULE_COMM}\', \'{MODULE_DATA}_commentcontent\', \'{AREA_COMM}\', \'{ID_COMM}\', \'{ALLOWED_COMM}\', \'{CHECKSS_COMM}\', {GFX_NUM});" class="btn btn-primary" />'
        ));
    }
} elseif (preg_match('/\/comment\.js$/', $file)) {
    nv_get_update_result('comment');
    nvUpdateContructItem('comment', 'js');
    
    if (preg_match("/function[\s]*sendcommment[\s]*\([\s]*module[\s]*\,[\s]*id\_content[\s]*\,[\s]*area/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function sendcommment(btn, module, id_content, area';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => 'function sendcommment(module, id_content, area, id, allowed, newscheckss, gfx_count) {',
            'replace' => 'function sendcommment(btn, module, id_content, area, id, allowed, newscheckss, gfx_count) {'
        ));
    }
    
    nvUpdateContructItem('comment', 'js');
    
    if (preg_match("/var[\s]*code[\s]*\=[\s]*\\$\([\s]*(\"|')\#commentseccode\_iavim(\"|')[\s]*\)\.val[\s]*\([\s]*\)[\s]*\;/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'var code = "";
    if (gfx_count > 0) {
        code = $("#commentseccode_iavim").val();
    } else if (gfx_count == -1) {
        code = $(\'[name="g-recaptcha-response"]\', $(btn.form)).val();
    }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => 'var code = $("#commentseccode_iavim").val();',
            'replace' => 'var code = "";
    if (gfx_count > 0) {
        code = $("#commentseccode_iavim").val();
    } else if (gfx_count == -1) {
        code = $(\'[name="g-recaptcha-response"]\', $(btn.form)).val();
    }'
        ));
    }
    
    nvUpdateContructItem('comment', 'js');
    
    if (preg_match("/var[\s]*code[\s]*\=[\s]*\\$\([\s]*(\"|')\#commentseccode\_iavim(\"|')[\s]*\)\.val[\s]*\([\s]*\)[\s]*\;/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'var code = "";
    if (gfx_count > 0) {
        code = $("#commentseccode_iavim").val();
    } else if (gfx_count == -1) {
        code = $(\'[name="g-recaptcha-response"]\', $(btn.form)).val();
    }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => 'var code = $("#commentseccode_iavim").val();',
            'replace' => 'var code = "";
    if (gfx_count > 0) {
        code = $("#commentseccode_iavim").val();
    } else if (gfx_count == -1) {
        code = $(\'[name="g-recaptcha-response"]\', $(btn.form)).val();
    }'
        ));
    }
    
    nvUpdateContructItem('comment', 'js');
    
    if (preg_match("/\\$\([\s]*(\"|')\#idcomment(\"|')[\s]*\)\.load[\s]*\([\s]*nv\_base\_siteurl([^\n]+)/", $output_data, $m)) {
        $find = $m[0];
        $replace = '$("#idcomment").load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=comment&module=\' + module + \'&area=\' + area + \'&id=\' + id + \'&allowed=\' + allowed + \'&status_comment=\' + rs[1] + \'&checkss=\' + newscheckss + \'&nocache=\' + new Date().getTime(), function() {
                    if (gfx_count == -1) {
                        change_captcha();
                    }
                });';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('comment', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('comment', array(
            'find' => '                $("#idcomment").load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=comment&module=\' + module + \'&area=\' + area + \'&id=\' + id + \'&allowed=\' + allowed + \'&status_comment=\' + rs[1] + \'&checkss=\' + newscheckss + \'&nocache=\' + new Date().getTime());',
            'replace' => '                $("#idcomment").load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=comment&module=\' + module + \'&area=\' + area + \'&id=\' + id + \'&allowed=\' + allowed + \'&status_comment=\' + rs[1] + \'&checkss=\' + newscheckss + \'&nocache=\' + new Date().getTime(), function() {
                    if (gfx_count == -1) {
                        change_captcha();
                    }
                });'
        ));
    }
}
