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
}
