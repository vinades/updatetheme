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

if (preg_match('/contact\/form\.tpl$/', $file)) {
    nv_get_update_result('contact');
    nvUpdateContructItem('contact', 'html');

    if (preg_match("/\<input([^\>]+)value[\s]*\=[\s]*(\"|')\{CONTENT\.fphone\}([^\n]+)[\s\n\t\r]*\<\/div\>[\s\n\t\r]*\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<em class="fa fa-home fa-lg fa-horizon"></em>
				</span>
                <input type="text" maxlength="60" value="{CONTENT.faddress}" name="faddress" class="form-control" placeholder="{LANG.address}" />
            </div>
        </div>';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('contact', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('contact', array(
            'find' => '                <input type="text" maxlength="60" value="{CONTENT.fphone}" name="fphone" class="form-control" placeholder="{LANG.phone}" />
            </div>
        </div>',
            'addafter' => '        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">
					<em class="fa fa-home fa-lg fa-horizon"></em>
				</span>
                <input type="text" maxlength="60" value="{CONTENT.faddress}" name="faddress" class="form-control" placeholder="{LANG.address}" />
            </div>
        </div>'
        ));
    }

    nvUpdateContructItem('contact', 'html');

    if (preg_match("/\<input([^\>]+)name[\s]*\=(\"|')sendcopy(\"|')([^\n]+)[\s\n\t\r]*\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        <!-- BEGIN: captcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('contact', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('contact', array(
            'find' => '            <label><input type="checkbox" name="sendcopy" value="1" checked="checked" /><span>{LANG.sendcopy}</span></label>
        </div>',
            'addafter' => '        <!-- BEGIN: captcha -->'
        ));
    }

    nvUpdateContructItem('contact', 'html');

    if (preg_match("/\<input([^\>]+)name[\s]*\=(\"|')fcode(\"|')([^\n]+)[\s\n\t\r]*\<\/div\>[\s\n\t\r]*\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        <!-- END: captcha -->
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
        nvUpdateSetItemData('contact', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('contact', array(
            'find' => '                <input type="text" placeholder="{LANG.captcha}" maxlength="{NV_GFX_NUM}" value="" name="fcode" class="fcode required form-control display-inline-block" style="width:100px;" data-pattern="/^(.){{NV_GFX_NUM},{NV_GFX_NUM}}$/" onkeypress="nv_validErrorHidden(this);" data-mess="{LANG.error_captcha}"/>
            </div>
		</div>',
            'addafter' => '        <!-- END: captcha -->
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
} elseif (preg_match('/\/contact\.js$/', $file)) {
    nv_get_update_result('contact');
    nvUpdateContructItem('contact', 'js');

    if (preg_match("/\}[\s]*\,[\s]*1E3[\s]*\)[\s]*\)[\s]*\:[\s]*\([\s]*\\$\([\s]*(\"|')input[\s]*\,[\s]*select[\s]*\,[\s]*button[\s]*\,[\s]*textarea[\s]*(\"|')[\s]*\,[\s]*a[\s]*\)\.prop/", $output_data, $m)) {
        $find = $m[0];
        $replace = '}, 1E3), (nv_is_recaptcha && change_captcha())) : ($("input,select,button,textarea", a).prop';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('contact', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('contact', array(
            'find' => '            }, 1E3)) : ($("input,select,button,textarea", a).prop("disabled", !0), "error" == b.status ? $(a).next().html(b.mess).removeClass("alert-info").addClass("alert-danger").show() : $(a).next().html(b.mess).removeClass("alert-danger").addClass("alert-info").show(), $("[data-mess]").tooltip("destroy"), setTimeout(function() {',
            'replace' => '            }, 1E3), (nv_is_recaptcha && change_captcha())) : ($("input,select,button,textarea", a).prop("disabled", !0), "error" == b.status ? $(a).next().html(b.mess).removeClass("alert-info").addClass("alert-danger").show() : $(a).next().html(b.mess).removeClass("alert-danger").addClass("alert-info").show(), $("[data-mess]").tooltip("destroy"), setTimeout(function() {'
        ));
    }

    nvUpdateContructItem('contact', 'js');
    
    if (preg_match("/nv\_validReset[\s]*\([\s]*([a-z0-9A-Z\_]+)[\s]*\)[\s\n\t\r]*\}[\s]*\,[\s]*5E3[\s]*\)[\s]*\)/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'nv_validReset(a);
                (nv_is_recaptcha && change_captcha());
            }, 5E3))';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('contact', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('contact', array(
            'find' => '                $("input,select,button,textarea", a).not(".disabled").prop("disabled", !1);
                nv_validReset(a)
            }, 5E3))',
            'replace' => '                $("input,select,button,textarea", a).not(".disabled").prop("disabled", !1);
                nv_validReset(a);
                (nv_is_recaptcha && change_captcha());
            }, 5E3))'
        ));
    }
}
