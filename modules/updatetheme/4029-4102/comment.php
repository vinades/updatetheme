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
}
