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

if (preg_match('/users\/avatar\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('jquery/jquery.Jcrop.min', 'cropper/cropper.min', $output_data);

    if ($output_data_compare != $output_data) {
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => 'jquery/jquery.Jcrop.min',
            'replace' => 'cropper/cropper.min'
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.Jcrop.min.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />',
            'replace' => '<link  type="text/css"href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/cropper/cropper.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/cropper/cropper.min.js"></script>'
        ));
    }

    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<input[\s]+type[\s]*\=[\s]*(\"|')hidden(\"|')[\s]+id[\s]*\=[\s]*(\"|')x1(\"|')(.*)id[\s]*\=[\s]*(\"|')h(\"|')[\s]+name[\s]*\=[\s]*(\"|')h(\"|')[\s]*\/[\s]*\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<input type="hidden" id="crop_x" name="crop_x"/>
        <input type="hidden" id="crop_y" name="crop_y"/>
        <input type="hidden" id="crop_width" name="crop_width"/>
        <input type="hidden" id="crop_height" name="crop_height"/>';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '        <input type="hidden" id="x1" name="x1"/>
        <input type="hidden" id="y1" name="y1"/>
        <input type="hidden" id="x2" name="x2"/>
        <input type="hidden" id="y2" name="y2"/>
        <input type="hidden" id="w" name="w"/>
        <input type="hidden" id="h" name="h"/>',
            'replace' => '        <input type="hidden" id="crop_x" name="crop_x"/>
        <input type="hidden" id="crop_y" name="crop_y"/>
        <input type="hidden" id="crop_width" name="crop_width"/>
        <input type="hidden" id="crop_height" name="crop_height"/>'
        ));
    }
} elseif (preg_match('/users\/block\.login\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/onclick[\s]*\=[\s]*\"modalShowByObj[\s]*\([\s]*\'\#guestLogin\_\{BLOCKID\}\'[\s]*\)[\s]*\"/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'onclick="modalShowByObj(\'#guestLogin_{BLOCKID}\', \'recaptchareset\')"';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'onclick="modalShowByObj(\'#guestLogin_{BLOCKID}\')"',
            'replace' => 'onclick="modalShowByObj(\'#guestLogin_{BLOCKID}\', \'recaptchareset\')"'
        ));
    }

    nvUpdateContructItem('users', 'html');

    if (preg_match("/onclick[\s]*\=[\s]*\"modalShowByObj[\s]*\([\s]*\'\#guestReg\_\{BLOCKID\}\'[\s]*\)[\s]*\"/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'onclick="modalShowByObj(\'#guestReg_{BLOCKID}\', \'recaptchareset\')"';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'onclick="modalShowByObj(\'#guestReg_{BLOCKID}\')"',
            'replace' => 'onclick="modalShowByObj(\'#guestReg_{BLOCKID}\', \'recaptchareset\')"'
        ));
    }
} elseif (preg_match('/users\/block\.user\_button\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/data\-click[\s]*\=[\s]*\"y\"[\s]*\>\<em/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'data-click="y" data-callback="recaptchareset"><em';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'data-click="y"><em',
            'replace' => 'data-click="y" data-callback="recaptchareset"><em'
        ));
    }
} elseif (preg_match('/users\/confirm\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<\!\-\-[\s]*END\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . '
                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '				<!-- END: captcha -->',
            'addafter' => '                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->'
        ));
    }

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

    // Copy file này từ giao diện mặc định sang và thông báo tự sửa bằng tay
    $default_contents = file_get_contents(NV_ROOTDIR . '/themes/default/modules/users/info.tpl');
    nvUpdateSetItemGuide('users', array(
        'findMessage' => 'Chú ý:',
        'find' => 'Hệ thống tự thay toàn bộ file này bằng file từ giao diện mặc định do phần này ít tùy biến và có rất nhiều thay đổi, bạn cần kiểm tra lại. Có thể so sánh code để cập nhật thủ công nếu bạn đã sửa đổi ở file này'
    ));
    $output_data = $default_contents;
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

    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<\!\-\-[\s]*END\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . '

        <!-- BEGIN: recaptcha -->
        <div class="form-group loginCaptcha">
            <div class="middle text-center clearfix">
                <!-- BEGIN: default --><div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div><!-- END: default -->
                <!-- BEGIN: compact --><div class="nv-recaptcha-compact"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div><!-- END: compact -->
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    <!-- BEGIN: smallbtn -->size: "compact",<!-- END: smallbtn -->
                    btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent()),
                    pnum: 4,
                    btnselector: \'[type="submit"]\'
                })
                </script>
            </div>
        </div>
        <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '        <!-- END: captcha -->',
            'addafter' => '
        <!-- BEGIN: recaptcha -->
        <div class="form-group loginCaptcha">
            <div class="middle text-center clearfix">
                <!-- BEGIN: default --><div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div><!-- END: default -->
                <!-- BEGIN: compact --><div class="nv-recaptcha-compact"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div><!-- END: compact -->
                <script type="text/javascript">
                nv_recaptcha_elements.push({
                    id: "{RECAPTCHA_ELEMENT}",
                    <!-- BEGIN: smallbtn -->size: "compact",<!-- END: smallbtn -->
                    btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent()),
                    pnum: 4,
                    btnselector: \'[type="submit"]\'
                })
                </script>
            </div>
        </div>
        <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/users\/lostactivelink\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<div([^\>]+)\>[\s\n\t\r]+\<div([^\>]+)\>[\s\n\t\r]+\<img([^\>]+)captchaImg([^\n]+)[\s\n\t\r]+\<\/div\>[\s\n\t\r]+\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: captcha -->
                <div class="form-group">
                    <div class="middle text-right clearfix">
                        <img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" /><em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha(\'.bsec\');"></em><input type="text" style="width:100px;" class="bsec required form-control display-inline-block" name="nv_seccode" value="" maxlength="{GFX_MAXLENGTH}" placeholder="{GLANG.securitycode}" data-pattern="/^(.){{GFX_MAXLENGTH},{GFX_MAXLENGTH}}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.securitycodeincorrect}" />
                    </div>
                </div>
                <!-- END: captcha -->

                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '                <div class="form-group">
                    <div class="middle text-right clearfix">
                        <img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" /><em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha(\'.bsec\');"></em><input type="text" style="width:100px;" class="bsec required form-control display-inline-block" name="nv_seccode" value="" maxlength="{GFX_MAXLENGTH}" placeholder="{GLANG.securitycode}" data-pattern="/^(.){{GFX_MAXLENGTH},{GFX_MAXLENGTH}}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.securitycodeincorrect}" />
                    </div>
                </div>',
            'addbefore' => '                <!-- BEGIN: captcha -->',
            'addafter' => '                <!-- END: captcha -->

                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/users\/lostpass\_form\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<div([^\>]+)\>[\s\n\t\r]+\<div([^\>]+)\>[\s\n\t\r]+\<img([^\>]+)captchaImg([^\n]+)[\s\n\t\r]+\<\/div\>[\s\n\t\r]+\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: captcha -->
            <div class="form-group">
                <div class="middle text-right clearfix">
                    <img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" /><em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha(\'.bsec\');"></em><input type="text" style="width:100px;" class="bsec required form-control display-inline-block" name="nv_seccode" value="" maxlength="{GFX_MAXLENGTH}" placeholder="{GLANG.securitycode}" data-pattern="/^(.){{GFX_MAXLENGTH},{GFX_MAXLENGTH}}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.securitycodeincorrect}" />
                </div>
            </div>
            <!-- END: captcha -->

            <!-- BEGIN: recaptcha -->
            <div class="form-group">
                <div class="middle text-right clearfix">
                    <div class="nv-recaptcha-default">
                        <div id="{RECAPTCHA_ELEMENT}"></div>
                        <input type="hidden" value="" name="gcaptcha_session"/>
                    </div>
                    <script type="text/javascript">
                    nv_recaptcha_elements.push({
                        id: "{RECAPTCHA_ELEMENT}",
                        btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent().parent())
                    })
                    </script>
                </div>
            </div>
            <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '            <div class="form-group">
                <div class="middle text-right clearfix">
                    <img class="captchaImg display-inline-block" src="{SRC_CAPTCHA}" width="{GFX_WIDTH}" height="{GFX_HEIGHT}" alt="{N_CAPTCHA}" title="{N_CAPTCHA}" /><em class="fa fa-pointer fa-refresh margin-left margin-right" title="{CAPTCHA_REFRESH}" onclick="change_captcha(\'.bsec\');"></em><input type="text" style="width:100px;" class="bsec required form-control display-inline-block" name="nv_seccode" value="" maxlength="{GFX_MAXLENGTH}" placeholder="{GLANG.securitycode}" data-pattern="/^(.){{GFX_MAXLENGTH},{GFX_MAXLENGTH}}$/" onkeypress="validErrorHidden(this);" data-mess="{GLANG.securitycodeincorrect}" />
                </div>
            </div>',
            'addbefore' => '            <!-- BEGIN: captcha -->',
            'addafter' => '            <!-- END: captcha -->

            <!-- BEGIN: recaptcha -->
            <div class="form-group">
                <div class="middle text-right clearfix">
                    <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                    <script type="text/javascript">
                    nv_recaptcha_elements.push({
                        id: "{RECAPTCHA_ELEMENT}",
                        btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent().parent())
                    })
                    </script>
                </div>
            </div>
            <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/users\/openid\_login\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- END: captcha -->
                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '				<!-- END: captcha -->',
            'addafter' => '                <!-- BEGIN: recaptcha -->
                <div class="form-group">
                    <div class="middle text-center clearfix">
                        <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                        <script type="text/javascript">
                        nv_recaptcha_elements.push({
                            id: "{RECAPTCHA_ELEMENT}",
                            btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                        })
                        </script>
                    </div>
                </div>
                <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/users\/register\_form\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    // Copy file này từ giao diện mặc định sang và thông báo tự sửa bằng tay
    $default_contents = file_get_contents(NV_ROOTDIR . '/themes/default/modules/users/register_form.tpl');
    nvUpdateSetItemGuide('users', array(
        'findMessage' => 'Chú ý:',
        'find' => 'Hệ thống tự thay toàn bộ file này bằng file từ giao diện mặc định do phần này ít tùy biến và có rất nhiều thay đổi, bạn cần kiểm tra lại. Có thể so sánh code để cập nhật thủ công nếu bạn đã sửa đổi ở file này'
    ));
    $output_data = $default_contents;
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

    if (preg_match("/\\$\([\s]*(\"|')\[name\=your\_question\](\"|')([^\n]+)/", $output_data, $m)) {
        $find = $m[0];
        $replace = "$(\"[name=question]\", b).val($(a).text());\n";
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '$("[name=your_question]", b).val($(a).text());',
            'replace' => '$("[name=question]", b).val($(a).text());'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/function[\s]*lostpass\_validForm[\s]*\([\s]*a[\s]*\)[\s]*\{(.*?)function[\s]*changemail\_validForm/isU", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function lostpass_validForm(a) {
    $(".has-error", a).removeClass("has-error");
    var d = 0,
        c = [];
    $(a).find("input.required,textarea.required,select.required,div.required").each(function() {
        var b = $(this).prop("tagName");
        "INPUT" != b && "TEXTAREA" != b || "password" == $(a).prop("type") || "radio" == $(a).prop("type") || "checkbox" == $(a).prop("type") || $(this).val(trim(strip_tags($(this).val())));
        if (!validCheck(this)) return d++, $(".tooltip-current", a).removeClass("tooltip-current"), $(this).addClass("tooltip-current").attr("data-current-mess", $(this).attr("data-mess")), validErrorShow(this), !1
    });
    if (!d) {
        if (nv_is_recaptcha && $("[name=step]",a).val() == \'step1\') {
            $("[name=gcaptcha_session]",a).val($("[name=g-recaptcha-response]",a).val());
        }
        c.type = $(a).prop("method"), c.url = $(a).prop("action"), c.data = $(a).serialize(), formErrorHidden(a), $(a).find("input,button,select,textarea").prop("disabled", !0);
        $.ajax({
            type: c.type,
            cache: !1,
            url: c.url,
            data: c.data,
            dataType: "json",
            success: function(b) {
                if (b.status == "error") {
                    $("[name=step]",a).val(b.step);
                    if("undefined" != typeof b.info && "" != b.info) $(".nv-info",a).removeClass(\'error success\').text(b.info);
                    $("input,button", a).prop("disabled", !1);
                    $(".required",a).removeClass("required");
                    $(".tooltip-current", a).removeClass("tooltip-current");
                    $("[class*=step]", a).hide();
                    $("." + b.step + " input", a).addClass("required");
                    $("." + b.step, a).show();
                    if (b.input == \'\') {
                        $(".nv-info", a).html(b.mess).addClass("error").show();
                    } else {
                        $(a).find("[name=\"" + b.input + "\"]").each(function() {
                            $(this).addClass("tooltip-current").attr("data-current-mess", b.mess);
                            validErrorShow(this);
                        });
                    }
                    if(b.step == \'step1\') {
                        $("[onclick*=\'change_captcha\']", a).click();
                        if (nv_is_recaptcha) {
                            change_captcha();
                            $("[name=gcaptcha_session]",a).val(\'\');
                        }
                    }
                } else {
                    $(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show();
                    setTimeout(function() {
                        window.location.href = b.input;
                    }, 6E3);
                }
            }
        });
    }
    return !1;
}

function changemail_validForm';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'Hàm lostpass_validForm',
            'replace' => 'function lostpass_validForm(a) {
    $(".has-error", a).removeClass("has-error");
    var d = 0,
        c = [];
    $(a).find("input.required,textarea.required,select.required,div.required").each(function() {
        var b = $(this).prop("tagName");
        "INPUT" != b && "TEXTAREA" != b || "password" == $(a).prop("type") || "radio" == $(a).prop("type") || "checkbox" == $(a).prop("type") || $(this).val(trim(strip_tags($(this).val())));
        if (!validCheck(this)) return d++, $(".tooltip-current", a).removeClass("tooltip-current"), $(this).addClass("tooltip-current").attr("data-current-mess", $(this).attr("data-mess")), validErrorShow(this), !1
    });
    if (!d) {
        if (nv_is_recaptcha && $("[name=step]",a).val() == \'step1\') {
            $("[name=gcaptcha_session]",a).val($("[name=g-recaptcha-response]",a).val());
        }
        c.type = $(a).prop("method"), c.url = $(a).prop("action"), c.data = $(a).serialize(), formErrorHidden(a), $(a).find("input,button,select,textarea").prop("disabled", !0);
        $.ajax({
            type: c.type,
            cache: !1,
            url: c.url,
            data: c.data,
            dataType: "json",
            success: function(b) {
                if (b.status == "error") {
                    $("[name=step]",a).val(b.step);
                    if("undefined" != typeof b.info && "" != b.info) $(".nv-info",a).removeClass(\'error success\').text(b.info);
                    $("input,button", a).prop("disabled", !1);
                    $(".required",a).removeClass("required");
                    $(".tooltip-current", a).removeClass("tooltip-current");
                    $("[class*=step]", a).hide();
                    $("." + b.step + " input", a).addClass("required");
                    $("." + b.step, a).show();
                    if (b.input == \'\') {
                        $(".nv-info", a).html(b.mess).addClass("error").show();
                    } else {
                        $(a).find("[name=\"" + b.input + "\"]").each(function() {
                            $(this).addClass("tooltip-current").attr("data-current-mess", b.mess);
                            validErrorShow(this);
                        });
                    }
                    if(b.step == \'step1\') {
                        $("[onclick*=\'change_captcha\']", a).click();
                        if (nv_is_recaptcha) {
                            change_captcha();
                            $("[name=gcaptcha_session]",a).val(\'\');
                        }
                    }
                } else {
                    $(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show();
                    setTimeout(function() {
                        window.location.href = b.input;
                    }, 6E3);
                }
            }
        });
    }
    return !1;
}'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/function[\s]*validCheck[\s]*\((.*)return[\s]*\![\s]*0\;*[\s\n\t\r]+\}[\s\n\t\r]+function[\s]*validErrorHidden[\s]*\(/s", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function validCheck(a) {
    if ($(a).is(\':visible\')) {
        var c = $(a).attr("data-pattern"),
            d = $(a).val(),
            b = $(a).prop("tagName"),
            e = $(a).prop("type");
        if ("INPUT" == b && "email" == e) {
            if (!nv_mailfilter.test(d)) return !1
        } else if ("SELECT" == b) {
            if (!$("option:selected", a).length) return !1
        } else if ("DIV" == b && $(a).is(".radio-box")) {
            if (!$("[type=radio]:checked", a).length) return !1
        } else if ("DIV" == b && $(a).is(".check-box")) {
            if (!$("[type=checkbox]:checked", a).length) return !1
        } else if ("INPUT" == b || "TEXTAREA" == b) if ("undefined" == typeof c || "" == c) {
            if ("" == d) return !1
        } else if (a = c.match(/^\/(.*?)\/([gim]*)$/), !(a ? new RegExp(a[1], a[2]) : new RegExp(c)).test(d)) return !1;
    }
    return !0
}

function validErrorHidden(';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'function validCheck(a) {
    var c = $(a).attr("data-pattern"),
        d = $(a).val(),
        b = $(a).prop("tagName"),
        e = $(a).prop("type");
    if ("INPUT" == b && "email" == e) {
        if (!nv_mailfilter.test(d)) return !1
    } else if ("SELECT" == b) {
        if (!$("option:selected", a).length) return !1
    } else if ("DIV" == b && $(a).is(".radio-box")) {
        if (!$("[type=radio]:checked", a).length) return !1
    } else if ("DIV" == b && $(a).is(".check-box")) {
        if (!$("[type=checkbox]:checked", a).length) return !1
    } else if ("INPUT" == b || "TEXTAREA" == b) if ("undefined" == typeof c || "" == c) {
        if ("" == d) return !1
    } else if (a = c.match(/^\/(.*?)\/([gim]*)$/), !(a ? new RegExp(a[1], a[2]) : new RegExp(c)).test(d)) return !1;
    return !0
}',
            'replace' => 'function validCheck(a) {
    if ($(a).is(\':visible\')) {
        var c = $(a).attr("data-pattern"),
            d = $(a).val(),
            b = $(a).prop("tagName"),
            e = $(a).prop("type");
        if ("INPUT" == b && "email" == e) {
            if (!nv_mailfilter.test(d)) return !1
        } else if ("SELECT" == b) {
            if (!$("option:selected", a).length) return !1
        } else if ("DIV" == b && $(a).is(".radio-box")) {
            if (!$("[type=radio]:checked", a).length) return !1
        } else if ("DIV" == b && $(a).is(".check-box")) {
            if (!$("[type=checkbox]:checked", a).length) return !1
        } else if ("INPUT" == b || "TEXTAREA" == b) if ("undefined" == typeof c || "" == c) {
            if ("" == d) return !1
        } else if (a = c.match(/^\/(.*?)\/([gim]*)$/), !(a ? new RegExp(a[1], a[2]) : new RegExp(c)).test(d)) return !1;
    }
    return !0
}'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/success[\s]*:[\s]*function[\s]*\([\s]*d[\s]*\)[\s]*\{[\s\n\t\r]+(.*?)\}[\s]*\,[\s]*3E3[\s]*\)[\s]*\)[\s\n\t\r]+\}/s", $output_data, $m)) {
        $find = $m[0];
        $replace = 'success: function(d) {
            var b = $("[onclick*=\'change_captcha\']", a);
            b && b.click();
            if (d.status == "error") {
                $("input,button", a).not("[type=submit]").prop("disabled", !1),
                $(".tooltip-current", a).removeClass("tooltip-current"),
                "" != d.input ? $(a).find("[name=\"" + d.input + "\"]").each(function() {
                    $(this).addClass("tooltip-current").attr("data-current-mess", d.mess);
                    validErrorShow(this)
                }) : $(".nv-info", a).html(d.mess).addClass("error").show(), setTimeout(function() {
                    $("[type=submit]", a).prop("disabled", !1);
                    if (nv_is_recaptcha) {
                        change_captcha();
                    }
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
        }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'function login_validForm(a) {',
            'replace' => 'success: function(d) {
    var b = $("[onclick*=\'change_captcha\']", a);
    b && b.click();
    if (d.status == "error") {
        $("input,button", a).not("[type=submit]").prop("disabled", !1),
        $(".tooltip-current", a).removeClass("tooltip-current"),
        "" != d.input ? $(a).find("[name=\"" + d.input + "\"]").each(function() {
            $(this).addClass("tooltip-current").attr("data-current-mess", d.mess);
            validErrorShow(this)
        }) : $(".nv-info", a).html(d.mess).addClass("error").show(), setTimeout(function() {
            $("[type=submit]", a).prop("disabled", !1);
            if (nv_is_recaptcha) {
                change_captcha();
            }
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
}',
            'replaceMessage' => 'Trong hàm đó thay toàn bộ quá trình xử lý sau Ajax success: function(d) { bằng'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/\}[\s]*\,[\s]*800[\s]*\)[\s]*\)[\s]*\)[\s]*\:[\s]*\([\s]*\\$\([\s]*(\"|')\.nv\-info(\"|')[\s]*\,[\s]*a[\s]*\)\.html[\s]*\([\s]*b\.mess[\s]*([^\n]+)/", $output_data, $m)) {
        $find = $m[0];
        $replace = '}, 800)), (nv_is_recaptcha && change_captcha())) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.input ? setTimeout(function() {';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '            }, 800))) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.input ? setTimeout(function() {',
            'replace' => '            }, 800)), (nv_is_recaptcha && change_captcha())) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.input ? setTimeout(function() {'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/if[\s]*\([\s]*b\.step[\s]*\=\=[\s]*(\"|')step1(\"|')[\s]*\)[\s]*\\$\([\s]*(\"|')\[onclick\*([^\n]+)/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'if(b.step == \'step1\') {
                    $("[onclick*=\'change_captcha\']", a).click();
                    (nv_is_recaptcha && change_captcha());
                 }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '                 if(b.step == \'step1\') $("[onclick*=\'change_captcha\']", a).click();',
            'replace' => '                 if(b.step == \'step1\') {
                    $("[onclick*=\'change_captcha\']", a).click();
                    (nv_is_recaptcha && change_captcha());
                 }'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/\}[\s]*\)[\s]*\)[\s]*\:[\s]*\([\s]*\\$\((\"|')\.nv\-info(\"|')[\s]*\,[\s]*a[\s]*\)\.html[\s]*\([\s]*b\.mess[\s]*\+[\s]*(\"|')\<span([^\n]+)/", $output_data, $m)) {
        $find = $m[0];
        $replace = '}), (nv_is_recaptcha && change_captcha())) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.status ? setTimeout(function() {';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '            })) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.status ? setTimeout(function() {',
            'replace' => '            }), (nv_is_recaptcha && change_captcha())) : ($(".nv-info", a).html(b.mess + \'<span class="load-bar"></span>\').removeClass("error").addClass("success").show(), ("ok" == b.status ? setTimeout(function() {'
        ));
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/var[\s]*UAV[\s]*\=[\s]*\{[\s]*\}[\s]*\;/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function login2step_change(ele) {
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

' . $m[0];
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => 'var UAV = {};',
            'addbefore' => 'function login2step_change(ele) {
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
    }

    nvUpdateContructItem('users', 'js');

    if (preg_match("/var[\s]*UAV[\s]*\=[\s]*\{[\s]*\}[\s]*\;(.*?)$/s", $output_data, $m)) {
        $find = $m[0];
        $replace = 'var UAV = {};
// Default config, replace it with your own
UAV.config = {
    inputFile: \'image_file\',
    uploadIcon: \'upload_icon\',
    pattern: /^(image\/jpeg|image\/png)$/i,
    maxsize: 2097152,
    avatar_width: 80,
    avatar_height: 80,
    max_width: 1500,
    max_height: 1500,
    target: \'preview\',
    uploadInfo: \'uploadInfo\',
    uploadGuide: \'guide\',
    x: \'crop_x\',
    y: \'crop_y\',
    w: \'crop_width\',
    h: \'crop_height\',
    originalDimension: \'original-dimension\',
    displayDimension: \'display-dimension\',
    imageType: \'image-type\',
    imageSize: \'image-size\',
    btnSubmit: \'btn-submit\',
    btnReset: \'btn-reset\',
    uploadForm: \'upload-form\'
};
// Default language, replace it with your own
UAV.lang = {
    bigsize: \'File too large\',
    smallsize: \'File too small\',
    filetype: \'Only accept jmage file tyle\',
    bigfile: \'File too big\',
    upload: \'Please upload and drag to crop\'
};
UAV.data = {
    error: false,
    busy: false,
    cropperApi: null
};
UAV.tool = {
    bytes2Size: function(bytes) {
        var sizes = [\'Bytes\', \'KB\', \'MB\'];
        if (bytes == 0) return \'n/a\';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return (bytes / Math.pow(1024, i)).toFixed(1) + \' \' + sizes[i];
    },
    update: function(e) {
        $(\'#\' + UAV.config.x).val(e.x);
        $(\'#\' + UAV.config.y).val(e.y);
        $(\'#\' + UAV.config.w).val(e.width);
        $(\'#\' + UAV.config.h).val(e.height);
    },
    clear: function(e) {
        $(\'#\' + UAV.config.x).val(0);
        $(\'#\' + UAV.config.y).val(0);
        $(\'#\' + UAV.config.w).val(0);
        $(\'#\' + UAV.config.h).val(0);
    }
};
// Please use this package with fengyuanchen/cropper https://fengyuanchen.github.io/cropper
UAV.common = {
    read: function(file) {
        $(\'#\' + UAV.config.uploadIcon).hide();
        var fRead = new FileReader();
        fRead.onload = function(e) {
            $(\'#\' + UAV.config.target).show();
            $(\'#\' + UAV.config.target).attr(\'src\', e.target.result);
            $(\'#\' + UAV.config.target).on(\'load\', function() {
                var img = document.getElementById(UAV.config.target);
                var boxWidth = $(\'#\' + UAV.config.target).innerWidth();
                var boxHeight = Math.round(boxWidth * img.naturalHeight / img.naturalWidth);
                var minCropBoxWidth = UAV.config.avatar_width / (img.naturalWidth / boxWidth);
                var minCropBoxHeight = UAV.config.avatar_height / (img.naturalHeight / boxHeight);
                if (img.naturalWidth > UAV.config.max_width || img.naturalHeight > UAV.config.max_height) {
                    UAV.common.error(UAV.lang.bigsize);
                    UAV.data.error = true;
                    return false;
                }
                if (img.naturalWidth < UAV.config.avatar_width || img.naturalHeight < UAV.config.avatar_height) {
                    UAV.common.error(UAV.lang.smallsize);
                    UAV.data.error = true;
                    return false;
                }
                if (!UAV.data.error) {
                    // Hide and show data
                    $(\'#\' + UAV.config.uploadGuide).hide();
                    $(\'#\' + UAV.config.uploadInfo).show();
                    $(\'#\' + UAV.config.imageType).html(file.type);
                    $(\'#\' + UAV.config.imageSize).html(UAV.tool.bytes2Size(file.size));
                    $(\'#\' + UAV.config.originalDimension).html(img.naturalWidth + \' x \' + img.naturalHeight);

                    UAV.data.cropperApi = $(\'#\' + UAV.config.target).cropper({
                        viewMode: 3,
                        dragMode: \'crop\',
                        aspectRatio: 1,
                        responsive: true,
                        modal: true,
                        guides: false,
                        highlight: true,
                        autoCrop: false,
                        autoCropArea: 0.1,
                        movable: false,
                        rotatable: false,
                        scalable: false,
                        zoomable: false,
                        zoomOnTouch: false,
                        zoomOnWheel: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        minCropBoxWidth: minCropBoxWidth,
                        minCropBoxHeight: minCropBoxHeight,
                        minContainerWidth: 10,
                        minContainerHeight: 10,
                        crop: function(e) {
                            UAV.tool.update(e);
                        },
                        built: function(e) {
                            var imageData = $(this).cropper(\'getImageData\');
                            var cropBoxScale = imageData.naturalWidth / imageData.width;
                            imageData.width = parseInt(Math.floor(imageData.width));
                            imageData.height = parseInt(Math.floor(imageData.height));
                            var cropBoxSize = {
                                width: 80 / cropBoxScale,
                                height: 80 / cropBoxScale
                            };
                            cropBoxSize.left = (imageData.width - cropBoxSize.width) / 2;
                            cropBoxSize.top = (imageData.height - cropBoxSize.height) / 2;
                            $(this).cropper(\'crop\');
                            $(this).cropper(\'setCropBoxData\', {
                                left: cropBoxSize.left,
                                top: cropBoxSize.top,
                                width: cropBoxSize.width,
                                height: cropBoxSize.height
                            });
                            $(\'#\' + UAV.config.w).val(imageData.width);
                            $(\'#\' + UAV.config.h).val(imageData.height);
                            $(\'#\' + UAV.config.displayDimension).html(imageData.width + \' x \' + imageData.height);
                        }
                    });
                } else {
                    $(\'#\' + UAV.config.uploadIcon).show();
                }
            });
        };
        fRead.readAsDataURL(file);
    },
    init: function() {
        UAV.data.error = false;
        if ($(\'#\' + UAV.config.inputFile).val() == \'\') {
            UAV.data.error = true;
        }
        var image = $(\'#\' + UAV.config.inputFile)[0].files[0];
        // Check ext
        if (!UAV.config.pattern.test(image.type)) {
            UAV.common.error(UAV.lang.filetype);
            UAV.data.error = true;
        }
        // Check size
        if (image.size > UAV.config.maxsize) {
            UAV.common.error(UAV.lang.bigfile);
            UAV.data.error = true;
        }
        if (!UAV.data.error) {
            // Read image
            UAV.common.read(image);
        }
    },
    error: function(e) {
        UAV.common.reset();
        alert(e);
    },
    reset: function() {
        if (UAV.data.cropperApi != null) {
            UAV.data.cropperApi.cropper(\'destroy\');
            UAV.data.cropperApi = null;
        }
        UAV.data.error = false;
        UAV.data.busy = false;
        UAV.tool.clear();
        $(\'#\' + UAV.config.target).removeAttr(\'src\').removeAttr(\'style\').hide();
        $(\'#\' + UAV.config.uploadIcon).show();
        $(\'#\' + UAV.config.uploadInfo).hide();
        $(\'#\' + UAV.config.uploadGuide).show();
        $(\'#\' + UAV.config.imageType).html(\'\');
        $(\'#\' + UAV.config.imageSize).html(\'\');
        $(\'#\' + UAV.config.originalDimension).html(\'\');
        $(\'#\' + UAV.config.w).val(\'\');
        $(\'#\' + UAV.config.h).val(\'\');
        $(\'#\' + UAV.config.displayDimension).html(\'\');
    },
    submit: function() {
        if (!UAV.data.busy) {
            if ($(\'#\' + UAV.config.w).val() == \'\' || $(\'#\' + UAV.config.w).val() == \'0\') {
                alert(UAV.lang.upload);
                return false;
            }
            UAV.data.busy = true;
            return true;
        }
        return false;
    }
};
UAV.init = function() {
    $(\'#\' + UAV.config.uploadIcon).click(function() {
        $(\'#\' + UAV.config.inputFile).trigger(\'click\');
    });
    $(\'#\' + UAV.config.inputFile).change(function() {
        UAV.common.init();
    });
    $(\'#\' + UAV.config.btnReset).click(function() {
        if (!UAV.data.busy) {
            UAV.common.reset();
            $(\'#\' + UAV.config.uploadIcon).trigger(\'click\');
        }
    });
    $(\'#\' + UAV.config.uploadForm).submit(function() {
        return UAV.common.submit();
    });
};

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
});';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'findMessage' => 'Tìm từ giá trị này đến hết file',
            'find' => 'var UAV = {};',
            'replace' => 'var UAV = {};
// Default config, replace it with your own
UAV.config = {
    inputFile: \'image_file\',
    uploadIcon: \'upload_icon\',
    pattern: /^(image\/jpeg|image\/png)$/i,
    maxsize: 2097152,
    avatar_width: 80,
    avatar_height: 80,
    max_width: 1500,
    max_height: 1500,
    target: \'preview\',
    uploadInfo: \'uploadInfo\',
    uploadGuide: \'guide\',
    x: \'crop_x\',
    y: \'crop_y\',
    w: \'crop_width\',
    h: \'crop_height\',
    originalDimension: \'original-dimension\',
    displayDimension: \'display-dimension\',
    imageType: \'image-type\',
    imageSize: \'image-size\',
    btnSubmit: \'btn-submit\',
    btnReset: \'btn-reset\',
    uploadForm: \'upload-form\'
};
// Default language, replace it with your own
UAV.lang = {
    bigsize: \'File too large\',
    smallsize: \'File too small\',
    filetype: \'Only accept jmage file tyle\',
    bigfile: \'File too big\',
    upload: \'Please upload and drag to crop\'
};
UAV.data = {
    error: false,
    busy: false,
    cropperApi: null
};
UAV.tool = {
    bytes2Size: function(bytes) {
        var sizes = [\'Bytes\', \'KB\', \'MB\'];
        if (bytes == 0) return \'n/a\';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return (bytes / Math.pow(1024, i)).toFixed(1) + \' \' + sizes[i];
    },
    update: function(e) {
        $(\'#\' + UAV.config.x).val(e.x);
        $(\'#\' + UAV.config.y).val(e.y);
        $(\'#\' + UAV.config.w).val(e.width);
        $(\'#\' + UAV.config.h).val(e.height);
    },
    clear: function(e) {
        $(\'#\' + UAV.config.x).val(0);
        $(\'#\' + UAV.config.y).val(0);
        $(\'#\' + UAV.config.w).val(0);
        $(\'#\' + UAV.config.h).val(0);
    }
};
// Please use this package with fengyuanchen/cropper https://fengyuanchen.github.io/cropper
UAV.common = {
    read: function(file) {
        $(\'#\' + UAV.config.uploadIcon).hide();
        var fRead = new FileReader();
        fRead.onload = function(e) {
            $(\'#\' + UAV.config.target).show();
            $(\'#\' + UAV.config.target).attr(\'src\', e.target.result);
            $(\'#\' + UAV.config.target).on(\'load\', function() {
                var img = document.getElementById(UAV.config.target);
                var boxWidth = $(\'#\' + UAV.config.target).innerWidth();
                var boxHeight = Math.round(boxWidth * img.naturalHeight / img.naturalWidth);
                var minCropBoxWidth = UAV.config.avatar_width / (img.naturalWidth / boxWidth);
                var minCropBoxHeight = UAV.config.avatar_height / (img.naturalHeight / boxHeight);
                if (img.naturalWidth > UAV.config.max_width || img.naturalHeight > UAV.config.max_height) {
                    UAV.common.error(UAV.lang.bigsize);
                    UAV.data.error = true;
                    return false;
                }
                if (img.naturalWidth < UAV.config.avatar_width || img.naturalHeight < UAV.config.avatar_height) {
                    UAV.common.error(UAV.lang.smallsize);
                    UAV.data.error = true;
                    return false;
                }
                if (!UAV.data.error) {
                    // Hide and show data
                    $(\'#\' + UAV.config.uploadGuide).hide();
                    $(\'#\' + UAV.config.uploadInfo).show();
                    $(\'#\' + UAV.config.imageType).html(file.type);
                    $(\'#\' + UAV.config.imageSize).html(UAV.tool.bytes2Size(file.size));
                    $(\'#\' + UAV.config.originalDimension).html(img.naturalWidth + \' x \' + img.naturalHeight);

                    UAV.data.cropperApi = $(\'#\' + UAV.config.target).cropper({
                        viewMode: 3,
                        dragMode: \'crop\',
                        aspectRatio: 1,
                        responsive: true,
                        modal: true,
                        guides: false,
                        highlight: true,
                        autoCrop: false,
                        autoCropArea: 0.1,
                        movable: false,
                        rotatable: false,
                        scalable: false,
                        zoomable: false,
                        zoomOnTouch: false,
                        zoomOnWheel: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        minCropBoxWidth: minCropBoxWidth,
                        minCropBoxHeight: minCropBoxHeight,
                        minContainerWidth: 10,
                        minContainerHeight: 10,
                        crop: function(e) {
                            UAV.tool.update(e);
                        },
                        built: function(e) {
                            var imageData = $(this).cropper(\'getImageData\');
                            var cropBoxScale = imageData.naturalWidth / imageData.width;
                            imageData.width = parseInt(Math.floor(imageData.width));
                            imageData.height = parseInt(Math.floor(imageData.height));
                            var cropBoxSize = {
                                width: 80 / cropBoxScale,
                                height: 80 / cropBoxScale
                            };
                            cropBoxSize.left = (imageData.width - cropBoxSize.width) / 2;
                            cropBoxSize.top = (imageData.height - cropBoxSize.height) / 2;
                            $(this).cropper(\'crop\');
                            $(this).cropper(\'setCropBoxData\', {
                                left: cropBoxSize.left,
                                top: cropBoxSize.top,
                                width: cropBoxSize.width,
                                height: cropBoxSize.height
                            });
                            $(\'#\' + UAV.config.w).val(imageData.width);
                            $(\'#\' + UAV.config.h).val(imageData.height);
                            $(\'#\' + UAV.config.displayDimension).html(imageData.width + \' x \' + imageData.height);
                        }
                    });
                } else {
                    $(\'#\' + UAV.config.uploadIcon).show();
                }
            });
        };
        fRead.readAsDataURL(file);
    },
    init: function() {
        UAV.data.error = false;
        if ($(\'#\' + UAV.config.inputFile).val() == \'\') {
            UAV.data.error = true;
        }
        var image = $(\'#\' + UAV.config.inputFile)[0].files[0];
        // Check ext
        if (!UAV.config.pattern.test(image.type)) {
            UAV.common.error(UAV.lang.filetype);
            UAV.data.error = true;
        }
        // Check size
        if (image.size > UAV.config.maxsize) {
            UAV.common.error(UAV.lang.bigfile);
            UAV.data.error = true;
        }
        if (!UAV.data.error) {
            // Read image
            UAV.common.read(image);
        }
    },
    error: function(e) {
        UAV.common.reset();
        alert(e);
    },
    reset: function() {
        if (UAV.data.cropperApi != null) {
            UAV.data.cropperApi.cropper(\'destroy\');
            UAV.data.cropperApi = null;
        }
        UAV.data.error = false;
        UAV.data.busy = false;
        UAV.tool.clear();
        $(\'#\' + UAV.config.target).removeAttr(\'src\').removeAttr(\'style\').hide();
        $(\'#\' + UAV.config.uploadIcon).show();
        $(\'#\' + UAV.config.uploadInfo).hide();
        $(\'#\' + UAV.config.uploadGuide).show();
        $(\'#\' + UAV.config.imageType).html(\'\');
        $(\'#\' + UAV.config.imageSize).html(\'\');
        $(\'#\' + UAV.config.originalDimension).html(\'\');
        $(\'#\' + UAV.config.w).val(\'\');
        $(\'#\' + UAV.config.h).val(\'\');
        $(\'#\' + UAV.config.displayDimension).html(\'\');
    },
    submit: function() {
        if (!UAV.data.busy) {
            if ($(\'#\' + UAV.config.w).val() == \'\' || $(\'#\' + UAV.config.w).val() == \'0\') {
                alert(UAV.lang.upload);
                return false;
            }
            UAV.data.busy = true;
            return true;
        }
        return false;
    }
};
UAV.init = function() {
    $(\'#\' + UAV.config.uploadIcon).click(function() {
        $(\'#\' + UAV.config.inputFile).trigger(\'click\');
    });
    $(\'#\' + UAV.config.inputFile).change(function() {
        UAV.common.init();
    });
    $(\'#\' + UAV.config.btnReset).click(function() {
        if (!UAV.data.busy) {
            UAV.common.reset();
            $(\'#\' + UAV.config.uploadIcon).trigger(\'click\');
        }
    });
    $(\'#\' + UAV.config.uploadForm).submit(function() {
        return UAV.common.submit();
    });
};

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
});'
        ));
    }
} elseif (preg_match('/modules\/users\/theme\.php$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'php');

    nvUpdateSetItemGuide('users', array(
        'findMessage' => 'Chú ý',
        'find' => 'So sánh với file theme.php ở thư mục module users để chỉnh sửa do có rất nhiều thay đổi',
    ));
}
