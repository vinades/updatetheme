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
} elseif (preg_match('/\/voting\.js$/', $file)) {
    nv_get_update_result('voting');
    nvUpdateContructItem('voting', 'js');
    
    $output_data = '/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC ( contact@vinades.vn )
 * @Copyright ( C ) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3 / 25 / 2010 18 : 6
 */

var total = 0;

function nv_check_accept_number(form, num, errmsg) {
    opts = form["option[]"];
    for (var e = total = 0; e < opts.length; e++)
        if (opts[e].checked && (total += 1), total > num) return alert(errmsg), !1
}

function nv_sendvoting(form, id, num, checkss, errmsg, captcha) {
    var vals = "0";
    num = parseInt(num);
    captcha = parseInt(captcha);
    if (1 == num) {
        opts = form.option;
        for (var b = 0; b < opts.length; b++) opts[b].checked && (vals = opts[b].value)
    } else if (1 < num)
        for (opts = form["option[]"], b = 0; b < opts.length; b++) opts[b].checked && (vals = vals + "," + opts[b].value);
    
    if ("0" == vals && 0 < num) {
        alert(errmsg);
    } else if (captcha == 0 || "0" == vals) {
        nv_sendvoting_submit(id, checkss, vals);
    } else {
        $(\'#voting-modal-\' + id).data(\'id\', id).data(\'checkss\', checkss).data(\'vals\', vals);
        modalShowByObj(\'#voting-modal-\' + id, "recaptchareset");
    }
    return !1
}

function nv_sendvoting_submit(id, checkss, vals, capt) {
    $.ajax({
        type: "POST",
        cache: !1,
        url: nv_base_siteurl + "index.php?" + nv_lang_variable + "=" + nv_lang_data + "&" + nv_name_variable + "=voting&" + nv_fc_variable + "=main&vid=" + id + "&checkss=" + checkss + "&lid=" + vals + (typeof capt != \'undefined\' ? \'&captcha=\' + capt : \'\'),
        data: "nv_ajax_voting=1",
        dataType: "html",
        success: function(res) {
            if (res.match(/^ERROR\|/g)) {
                change_captcha(\'.rsec\');
                alert(res.substring(6));
            } else {
                modalShow("", res);
            }
        }
    });
}

function nv_sendvoting_captcha(btn, id, msg) {
    var ctn = $(\'#voting-modal-\' + id);
    var capt = "";
    if (nv_is_recaptcha) {
        capt = $(\'[name="g-recaptcha-response"]\', $(btn).parent()).val();
    } else {
        capt = $(\'[name="captcha"]\', $(btn).parent()).val();
    }
    if (capt == "") {
        alert(msg);
    } else {
        nv_sendvoting_submit(ctn.data(\'id\'), ctn.data(\'checkss\'), ctn.data(\'vals\'), capt);
    }
}';
    nvUpdateSetItemData('voting', array(
        'find' => '//Toàn bộ file',
        'replace' => $output_data,
        'status' => 1
    ));
} elseif (preg_match('/voting\/theme\.php$/', $file)) {
    nv_get_update_result('voting');
    $output_data = replaceModuleFileInTheme($output_data, 'voting');
}
