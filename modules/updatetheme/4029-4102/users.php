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

            if (preg_match('/users\/confirm\.tpl$/', $file)) {
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
                    'replaceMessage' => 'Bên trong hàm ðó, trong ph?n th?c thi sau khi login thành công success: function(d) { thay toàn b? giá tr? thành'
                ));
                
                nvUpdateContructItem('users', 'js');
                
                nvUpdateSetItemGuide('users', array(
                    'findMessage' => 'M? sung thêm hàm',
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
                    'findMessage' => 'B? sung thêm l?nh x? l? cho admin',
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
                    'replaceMessage' => 'Bên dý?i xác ð?nh và xóa',
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
                    'findMessage' => 'Trong hàm openid_account_confirm t?m',
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
                    'findMessage' => 'T?m hàm nv_memberslist_detail_theme, xác ð?nh trong hàm d?ng',
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

