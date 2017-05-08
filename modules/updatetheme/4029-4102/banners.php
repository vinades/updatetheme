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

if (preg_match('/banners\/global\.banners\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');
    
    if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*type\_image[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    <!-- BEGIN: bannerhtml -->
    <div class="clearfix text-left">
        {DATA.bannerhtml}
    </div>
    <!-- END: bannerhtml -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => '    <!-- END: type_image -->',
            'addafter' => '    <!-- BEGIN: bannerhtml -->
    <div class="clearfix text-left">
        {DATA.bannerhtml}
    </div>
    <!-- END: bannerhtml -->'
        ));
    }
} elseif (preg_match('/banners\/logininfo\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');
    
    if (preg_match("/\<\!\-\-[\s]*END\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        <!-- BEGIN: recaptcha -->
        <div class="form-group">
            <label class="col-sm-6 control-label">{N_CAPTCHA}:</label>
            <div class="col-xs-24">
                <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    btn: $(\'[type="button"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent().parent())
                })
                </script>
            </div>
        </div>
        <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => '		<!-- END: captcha -->',
            'addafter' => '        <!-- BEGIN: recaptcha -->
        <div class="form-group">
            <label class="col-sm-6 control-label">{N_CAPTCHA}:</label>
            <div class="col-xs-24">
                <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    btn: $(\'[type="button"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent().parent())
                })
                </script>
            </div>
        </div>
        <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/banners\.js$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'js');
    
    if (preg_match("/function[\s]*nv\_login\_info[\s]*\([\s]*containerid[\s]*\)[\s]*\{[\s\n\t\r]*\\$\([\s]*(\"|')\#(\"|')[\s]*\+[\s]*containerid[\s]*\)\.load([^\n]+)[\s\n\t\r]*return([^\n]+)[\s\n\t\r]*\}/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function nv_login_info(containerid, ccap) {
    $(\'#\' + containerid).load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&\' + nv_fc_variable + \'=logininfo&nocache=\' + new Date().getTime(), function() {
        if (ccap === true) {
            change_captcha();
        }
    });
    return false;
}';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => 'function nv_login_info(containerid) {
    $(\'#\' + containerid).load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&\' + nv_fc_variable + \'=logininfo&nocache=\' + new Date().getTime());
    return false;
}',
            'replace' => 'function nv_login_info(containerid, ccap) {
    $(\'#\' + containerid).load(nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&\' + nv_fc_variable + \'=logininfo&nocache=\' + new Date().getTime(), function() {
        if (ccap === true) {
            change_captcha();
        }
    });
    return false;
}'
        ));
    }
    
    nvUpdateContructItem('banners', 'js');
    
    if (preg_match("/pass\.value\.length[\s]*\>[\s]*pass\_max[\s]*\|\|[\s]*pass\.value\.length[\s]*\<[\s]*pass\_min[\s]*\|\|[\s]*\![\s]*nv\_namecheck\.test[\s]*\([\s]*pass\.value[\s]*\)/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'pass.value.length > pass_max || pass.value.length < pass_min';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => 'if (pass.value.length > pass_max || pass.value.length < pass_min || ! nv_namecheck.test(pass.value)) {',
            'replace' => 'if (pass.value.length > pass_max || pass.value.length < pass_min) {'
        ));
    }
    
    nvUpdateContructItem('banners', 'js');
    
    if (preg_match("/if[\s]*\([\s]*gfx\_chk[\s]*\)[\s]*\{[\s\n\t\r]*(.*)\}[\s\n\t\r]*var[\s]*nv\_timer[\s]*\=/s", $output_data, $m)) {
        $find = $m[0];
        $replace = 'if (gfx_chk) {
        if (gfx_count > 0) {
            var sec = document.getElementById(sec_id);
            if (sec.value.length != gfx_count) {
                error = nv_error_seccode.replace(/\[num\]/g, gfx_count);
                alert(error);
                sec.focus();
                return false;
            }
            request_query += \'&seccode=\' + sec.value;
        } else {
            request_query += \'&seccode=\' + $(\'[name="g-recaptcha-response"]\', $(\'#client_login\')).val();
        }
    }
    var nv_timer =';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => '    if (gfx_chk) {
        var sec = document.getElementById(sec_id);
        if (sec.value.length != gfx_count) {
            error = nv_error_seccode.replace(/\[num\]/g, gfx_count);
            alert(error);
            sec.focus();
            return false;
        }

        request_query += \'&seccode=\' + sec.value;
    }',
            'replace' => '    if (gfx_chk) {
        if (gfx_count > 0) {
            var sec = document.getElementById(sec_id);
            if (sec.value.length != gfx_count) {
                error = nv_error_seccode.replace(/\[num\]/g, gfx_count);
                alert(error);
                sec.focus();
                return false;
            }
            request_query += \'&seccode=\' + sec.value;
        } else {
            request_query += \'&seccode=\' + $(\'[name="g-recaptcha-response"]\', $(\'#client_login\')).val();
        }
    }'
        ));
    }
    
    nvUpdateContructItem('banners', 'js');
    
    if (preg_match("/nv\_login\_info[\s]*\([\s]*res[\s]*\)[\s]*\;/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'nv_login_info(res, true);';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => 'nv_login_info(res);',
            'replace' => 'nv_login_info(res, true);'
        ));
    }
}
