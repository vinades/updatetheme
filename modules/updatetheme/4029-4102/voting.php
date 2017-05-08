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
            }
