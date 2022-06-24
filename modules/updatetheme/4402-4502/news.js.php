<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_UPDATETHEME')) {
    die('Stop!!!');
}

/**
 * Cập nhật news.js
 */

nv_get_update_result('news');
nvUpdateContructItem('news', 'js');

if (preg_match("/\\\$[\s]*\([\s]*(\"|')\[data\-toggle\=(\"|')collapsepdf(\"|')\](\"|')[\s]*\)(.*?)\)[\s]*\)[\s]*\;*[\r\n\s\t]*\}[\s]*\)[\s]*\;*[\r\n\s\t]*\}[\s]*\)[\s]*\;*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Xem file đính kèm
    $(\'[data-toggle="collapsefile"]\').each(function() {
        $(\'#\' + $(this).attr(\'id\')).on(\'show.bs.collapse\', function() {
            if (\'false\' == $(this).attr(\'data-loaded\')) {
                $(this).attr(\'data-loaded\', \'true\')
                $(this).find(\'iframe\').attr(\'src\', $(this).data(\'src\'))
            }
        })
    })';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '    $(\'[data-toggle="collapsepdf"]\').each(function() {
        $(\'#\' + $(this).attr(\'id\')).on(\'shown.bs.collapse\', function() {
            $(this).find(\'iframe\').attr(\'src\', $(this).data(\'src\'));
        });
    });',
        'replace' => '    // Xem file đính kèm
    $(\'[data-toggle="collapsefile"]\').each(function() {
        $(\'#\' + $(this).attr(\'id\')).on(\'show.bs.collapse\', function() {
            if (\'false\' == $(this).attr(\'data-loaded\')) {
                $(this).attr(\'data-loaded\', \'true\')
                $(this).find(\'iframe\').attr(\'src\', $(this).data(\'src\'))
            }
        })
    })'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'js');

if (preg_match("/\\\$[\s]*\([\s]*(\"|')\[data\-toggle\=(\"|')newsattachimage(\"|')\](\"|')[\s]*\)(.*?)\<\/div\>(\"|')[\s]*\)\;*[\r\n\s\t]*\}[\s]*\)\;*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Xem ảnh đính kèm
    $(\'[data-toggle="newsattachimage"]\').click(function(e) {
        e.preventDefault();
        modalShow(\'\', \'<div class="text-center"><img src="\' + $(this).data(\'src\') + \'" style="max-width: 100%; height: auto;"/></div>\');
    });';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '    $(\'[data-toggle="newsattachimage"]\').click(function(e) {
        e.preventDefault();
        modalShow(\'\', \'<div class="text-center"><img src="\' + $(this).data(\'src\') + \'" style="max-width: 100%;"/></div>\');
    });',
        'replace' => '    // Xem ảnh đính kèm
    $(\'[data-toggle="newsattachimage"]\').click(function(e) {
        e.preventDefault();
        modalShow(\'\', \'<div class="text-center"><img src="\' + $(this).data(\'src\') + \'" style="max-width: 100%; height: auto;"/></div>\');
    });'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'js');

if (preg_match("/\\\$[\s]*\([\s]*window[\s]*\)[\s]*\.[\s]*on[\s]*\([\s]*(\"|')load(\"|')[\s]*\,[\s]*function[\s]*\([\s]*\)[\s]*\{/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function newsSendMailModal(fm, url, sess) {
    var loaded = $(fm).attr(\'data-loaded\');
    if (\'false\' == loaded) {
        $.ajax({
            type: \'POST\',
            cache: !1,
            url: url,
            data: \'checkss=\' + sess,
            success: function(e) {
                $(\'.modal-body\', $(fm)).html(e);
                if ($(\'[data-toggle=recaptcha]\', $(fm)).length) {
                    reCaptcha2Recreate($(fm));
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", $(fm)).length && "undefined" === typeof grecaptcha) {
                    reCaptcha3ApiLoad()
                }
                $(fm).attr(\'data-loaded\', \'true\');
                $(fm).modal(\'show\')
            }
        })
    } else {
        $(fm).modal(\'show\')
    }
}

function newsSendMail(event, form) {
    event.preventDefault();
    var a = $("[name=friend_email]", form).val();
    a = trim(strip_tags(a));
    $("[name=friend_email]", form).val(a);
    if (!nv_mailfilter.test(a)) return alert($("[name=friend_email]", form).data("error")), $("[name=friend_email]", form).focus(), !1;
    a = $("[name=your_name]", form).val();
    a = trim(strip_tags(a));
    $("[name=your_name]", form).val(a);
    if ("" == a || !nv_uname_filter.test(a)) return alert($("[name=your_name]", form).data("error")), $("[name=your_name]", form).focus(), !1;
    if ($("[name=nv_seccode]", form).length && (a = $("[name=nv_seccode]", form).val(), a.length != parseInt($("[name=nv_seccode]", form).attr("maxlength")) || !/^[a-z0-9]+$/i.test(a))) return alert($("[name=nv_seccode]", form).data("error")), $("[name=nv_seccode]", form).focus(), !1;
    $("[name=your_message]", form).length && $("[name=your_message]", form).val(trim(strip_tags($("[name=your_message]", form).val())));
    a = $(form).serialize();
    $("input,button,textarea", form).prop("disabled", !0);
    $.ajax({
        type: $(form).prop("method"),
        cache: !1,
        url: $(form).prop("action"),
        data: a,
        dataType: "json",
        success: function(b) {
            $("input,button,textarea", form).prop("disabled", !1);
            var c = $("[onclick*=\'change_captcha\']", form);
            c && c.click();
            ($("[data-toggle=recaptcha]", form).length || $("[data-recaptcha3]", $(form).parent()).length) && change_captcha();
            "error" == b.status ? (alert(b.mess), b.input && $("[name=" + b.input + "]", form).focus()) : (alert(b.mess), $("[name=friend_email]", form).val(\'\'), $("[name=your_message]", form).length && $("[name=your_message]", form).val(\'\'), $("[data-dismiss=modal]", form).click())
        }
    })
}

$(window).on(\'load\', function() {';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '$(window).on(\'load\', function() {',
        'addbefore' => 'function newsSendMailModal(fm, url, sess) {
    var loaded = $(fm).attr(\'data-loaded\');
    if (\'false\' == loaded) {
        $.ajax({
            type: \'POST\',
            cache: !1,
            url: url,
            data: \'checkss=\' + sess,
            success: function(e) {
                $(\'.modal-body\', $(fm)).html(e);
                if ($(\'[data-toggle=recaptcha]\', $(fm)).length) {
                    reCaptcha2Recreate($(fm));
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", $(fm)).length && "undefined" === typeof grecaptcha) {
                    reCaptcha3ApiLoad()
                }
                $(fm).attr(\'data-loaded\', \'true\');
                $(fm).modal(\'show\')
            }
        })
    } else {
        $(fm).modal(\'show\')
    }
}

function newsSendMail(event, form) {
    event.preventDefault();
    var a = $("[name=friend_email]", form).val();
    a = trim(strip_tags(a));
    $("[name=friend_email]", form).val(a);
    if (!nv_mailfilter.test(a)) return alert($("[name=friend_email]", form).data("error")), $("[name=friend_email]", form).focus(), !1;
    a = $("[name=your_name]", form).val();
    a = trim(strip_tags(a));
    $("[name=your_name]", form).val(a);
    if ("" == a || !nv_uname_filter.test(a)) return alert($("[name=your_name]", form).data("error")), $("[name=your_name]", form).focus(), !1;
    if ($("[name=nv_seccode]", form).length && (a = $("[name=nv_seccode]", form).val(), a.length != parseInt($("[name=nv_seccode]", form).attr("maxlength")) || !/^[a-z0-9]+$/i.test(a))) return alert($("[name=nv_seccode]", form).data("error")), $("[name=nv_seccode]", form).focus(), !1;
    $("[name=your_message]", form).length && $("[name=your_message]", form).val(trim(strip_tags($("[name=your_message]", form).val())));
    a = $(form).serialize();
    $("input,button,textarea", form).prop("disabled", !0);
    $.ajax({
        type: $(form).prop("method"),
        cache: !1,
        url: $(form).prop("action"),
        data: a,
        dataType: "json",
        success: function(b) {
            $("input,button,textarea", form).prop("disabled", !1);
            var c = $("[onclick*=\'change_captcha\']", form);
            c && c.click();
            ($("[data-toggle=recaptcha]", form).length || $("[data-recaptcha3]", $(form).parent()).length) && change_captcha();
            "error" == b.status ? (alert(b.mess), b.input && $("[name=" + b.input + "]", form).focus()) : (alert(b.mess), $("[name=friend_email]", form).val(\'\'), $("[name=your_message]", form).length && $("[name=your_message]", form).val(\'\'), $("[data-dismiss=modal]", form).click())
        }
    })
}'
    ));
}
