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

if (preg_match('/voting\/global\.voting\.tpl$/', $file)) {
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
    $replace = '<!-- BEGIN: has_captcha -->
<div id="voting-modal-{VOTING.vid}" class="hidden">
    <div class="clearfix">
        <!-- BEGIN: basic -->
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
        </div>
        <!-- END: basic -->
        <!-- BEGIN: recaptcha -->
        <div class="m-bottom text-center">
            <strong>{N_CAPTCHA}</strong>
        </div>
        <div class="margin-bottom clearfix">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent()),
                pnum: 3,
                btnselector: \'[name="submit"]\'
            })
            </script>
        </div>
        <!-- END: recaptcha -->
        <input type="button" name="submit" class="btn btn-primary btn-block" value="{VOTING.langsubmit}" onclick="nv_sendvoting_captcha(this, {VOTING.vid}, \'{LANG.enter_captcha_error}\');"/>
    </div>
</div>
<!-- END: has_captcha -->
<!-- END: main -->';
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
            'addbefore' => '<!-- BEGIN: has_captcha -->
<div id="voting-modal-{VOTING.vid}" class="hidden">
    <div class="clearfix">
        <!-- BEGIN: basic -->
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
        </div>
        <!-- END: basic -->
        <!-- BEGIN: recaptcha -->
        <div class="m-bottom text-center">
            <strong>{N_CAPTCHA}</strong>
        </div>
        <div class="margin-bottom clearfix">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent()),
                pnum: 3,
                btnselector: \'[name="submit"]\'
            })
            </script>
        </div>
        <!-- END: recaptcha -->
        <input type="button" name="submit" class="btn btn-primary btn-block" value="{VOTING.langsubmit}" onclick="nv_sendvoting_captcha(this, {VOTING.vid}, \'{LANG.enter_captcha_error}\');"/>
    </div>
</div>
<!-- END: has_captcha -->'
        ));
    }
    $output_data = $output_data1;
} elseif (preg_match('/voting\/main\.tpl$/', $file)) {
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
    
    $find = '<!-- END: loop -->';
    $replace = '<!-- BEGIN: has_captcha -->
<div id="voting-modal-{VOTING.vid}" class="hidden">
    <div class="clearfix">
        <!-- BEGIN: basic -->
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
        </div>
        <!-- END: basic -->
        <!-- BEGIN: recaptcha -->
        <div class="m-bottom text-center">
            <strong>{N_CAPTCHA}</strong>
        </div>
        <div class="margin-bottom clearfix">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent()),
                pnum: 3,
                btnselector: \'[name="submit"]\'
            })
            </script>
        </div>
        <!-- END: recaptcha -->
        <input type="button" name="submit" class="btn btn-primary btn-block" value="{VOTING.langsubmit}" onclick="nv_sendvoting_captcha(this, {VOTING.vid}, \'{LANG.enter_captcha_error}\');"/>
    </div>
</div>
<!-- END: has_captcha -->
<!-- END: loop -->';
    
    $output_data1 = str_replace($find, $replace, $output_data);
    if ($output_data1 != $output_data) {
        nvUpdateSetItemData('voting', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('voting', array(
            'find' => '<!-- END: loop -->',
            'addbefore' => '<!-- BEGIN: has_captcha -->
<div id="voting-modal-{VOTING.vid}" class="hidden">
    <div class="clearfix">
        <!-- BEGIN: basic -->
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
        </div>
        <!-- END: basic -->
        <!-- BEGIN: recaptcha -->
        <div class="m-bottom text-center">
            <strong>{N_CAPTCHA}</strong>
        </div>
        <div class="margin-bottom clearfix">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}" data-toggle="recaptcha"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent()),
                pnum: 3,
                btnselector: \'[name="submit"]\'
            })
            </script>
        </div>
        <!-- END: recaptcha -->
        <input type="button" name="submit" class="btn btn-primary btn-block" value="{VOTING.langsubmit}" onclick="nv_sendvoting_captcha(this, {VOTING.vid}, \'{LANG.enter_captcha_error}\');"/>
    </div>
</div>
<!-- END: has_captcha -->'
        ));
    }
    $output_data = $output_data1;
}
