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
 * Cập nhật main.js của giao diện
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Bổ sung biến
if (preg_match("/NVIsMobileMenu[\s]+\=[\s]+false/", $output_data, $m)) {
    $find = $m[0];
    $replace = 'NVIsMobileMenu = false,
    gEInterval,
    siteMenu = $("#menu-site-default")';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => 'NVIsMobileMenu = false,',
        'addafter' => 'gEInterval,
    siteMenu = $("#menu-site-default"),'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm checkAll
if (preg_match("/function[\s]+checkAll(.*?)return[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function checkAll(a) {
    $(".checkAll", a).is(":checked") ? $(".checkSingle", a).not(":disabled").each(function() {
        $(this).prop("checked", !0)
    }) : $(".checkSingle", a).not(":disabled").each(function() {
        $(this).prop("checked", !1)
    });
    return !1
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm checkAll',
        'replace' => 'function checkAll(a) {
    $(".checkAll", a).is(":checked") ? $(".checkSingle", a).not(":disabled").each(function() {
        $(this).prop("checked", !0)
    }) : $(".checkSingle", a).not(":disabled").each(function() {
        $(this).prop("checked", !1)
    });
    return !1
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm checkWidthMenu
if (preg_match("/function[\s]+checkWidthMenu(.*?)\}[\r\n\s\t]+function/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function checkWidthMenu() {
    NVIsMobileMenu = (theme_responsive && "absolute" == $("#menusite").css("position"));
    NVIsMobileMenu ? (
        $("li.dropdown ul", siteMenu).removeClass("dropdown-menu").addClass("dropdown-submenu"),
        $("li.dropdown a", siteMenu).addClass("dropdown-mobile"),
        $("ul li a.dropdown-toggle", siteMenu).addClass("dropdown-mobile"),
        $("li.dropdown ul li a", siteMenu).removeClass("dropdown-mobile")
    ) : (
        $("li.dropdown ul", siteMenu).addClass("dropdown-menu").removeClass("dropdown-submenu"),
        $("li.dropdown a", siteMenu).removeClass("dropdown-mobile"),
        $("li.dropdown ul li a", siteMenu).removeClass("dropdown-mobile"),
        $("ul li a.dropdown-toggle", siteMenu).removeClass("dropdown-mobile")
    )
}

function';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm checkWidthMenu',
        'replace' => 'function checkWidthMenu() {
    NVIsMobileMenu = (theme_responsive && "absolute" == $("#menusite").css("position"));
    NVIsMobileMenu ? (
        $("li.dropdown ul", siteMenu).removeClass("dropdown-menu").addClass("dropdown-submenu"),
        $("li.dropdown a", siteMenu).addClass("dropdown-mobile"),
        $("ul li a.dropdown-toggle", siteMenu).addClass("dropdown-mobile"),
        $("li.dropdown ul li a", siteMenu).removeClass("dropdown-mobile")
    ) : (
        $("li.dropdown ul", siteMenu).addClass("dropdown-menu").removeClass("dropdown-submenu"),
        $("li.dropdown a", siteMenu).removeClass("dropdown-mobile"),
        $("li.dropdown ul li a", siteMenu).removeClass("dropdown-mobile"),
        $("ul li a.dropdown-toggle", siteMenu).removeClass("dropdown-mobile")
    )
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm openID_load
if (preg_match("/function[\s]+openID_load(.*?)return[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function openID_load(a) {
    tip_active && tipHide();
    ftip_active && ftipHide();
    nv_open_browse($(a).attr("href"), "NVOPID", 550, 500, "resizable=no,scrollbars=1,toolbar=no,location=no,titlebar=no,menubar=0,location=no,status=no");
    return !1
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm openID_load',
        'replace' => 'function openID_load(a) {
    tip_active && tipHide();
    ftip_active && ftipHide();
    nv_open_browse($(a).attr("href"), "NVOPID", 550, 500, "resizable=no,scrollbars=1,toolbar=no,location=no,titlebar=no,menubar=0,location=no,status=no");
    return !1
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm openID_result
if (preg_match("/function[\s]+openID_result(.*?)return[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function openID_result() {
    var resElement = $("#openidResult");
    resElement.fadeIn();
    setTimeout(function() {
        if (resElement.data(\'redirect\') != \'\') {
            window.location.href = resElement.data(\'redirect\');
        } else if (resElement.data(\'result\') == \'success\') {
            location.reload();
        } else {
            resElement.hide(0).html(\'\').data(\'result\', \'\').data(\'redirect\', \'\');
        }
    }, 5000);
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm openID_result',
        'replace' => 'function openID_result() {
    var resElement = $("#openidResult");
    resElement.fadeIn();
    setTimeout(function() {
        if (resElement.data(\'redirect\') != \'\') {
            window.location.href = resElement.data(\'redirect\');
        } else if (resElement.data(\'result\') == \'success\') {
            location.reload();
        } else {
            resElement.hide(0).html(\'\').data(\'result\', \'\').data(\'redirect\', \'\');
        }
    }, 5000);
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm tipShow
if (preg_match("/function[\s]+tipShow(.*?)tip_active[\s]+\=[\s]+1[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function tipShow(a, b, callback) {
    tip_active && tipHide();
    ftip_active && ftipHide();
    $("[data-toggle=tip]").removeClass("active");
    $(a).attr("data-click", "n").addClass("active");
    if (typeof callback != "undefined") {
        $("#tip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset") {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            } else if (typeof window[callback] === "function") {
                window[callback]()
            }
        });
    } else {
        $("#tip").attr("data-content", b).show("fast");
    }
    tip_active = 1;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm tipShow',
        'replace' => 'function tipShow(a, b, callback) {
    tip_active && tipHide();
    ftip_active && ftipHide();
    $("[data-toggle=tip]").removeClass("active");
    $(a).attr("data-click", "n").addClass("active");
    if (typeof callback != "undefined") {
        $("#tip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset") {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            } else if (typeof window[callback] === "function") {
                window[callback]()
            }
        });
    } else {
        $("#tip").attr("data-content", b).show("fast");
    }
    tip_active = 1;
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm ftipShow
if (preg_match("/function[\s]+ftipShow(.*?)ftip_active[\s]+\=[\s]+1[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function ftipShow(a, b, callback) {
    if ($(a).is(".qrcode") && "no" == $(a).attr("data-load")) {
        return qrcodeLoad(a), !1;
    }
    tip_active && tipHide();
    ftip_active && ftipHide();
    $("[data-toggle=ftip]").removeClass("active");
    $(a).attr("data-click", "n").addClass("active");
    if (typeof callback != "undefined") {
        $("#ftip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset") {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            } else if (typeof window[callback] === "function") {
                window[callback]()
            }
        });
    } else {
        $("#ftip").attr("data-content", b).show("fast");
    }
    ftip_active = 1;
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm ftipShow',
        'replace' => 'function ftipShow(a, b, callback) {
    if ($(a).is(".qrcode") && "no" == $(a).attr("data-load")) {
        return qrcodeLoad(a), !1;
    }
    tip_active && tipHide();
    ftip_active && ftipHide();
    $("[data-toggle=ftip]").removeClass("active");
    $(a).attr("data-click", "n").addClass("active");
    if (typeof callback != "undefined") {
        $("#ftip").attr("data-content", b).show("fast", function() {
            if (callback == "recaptchareset") {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            } else if (typeof window[callback] === "function") {
                window[callback]()
            }
        });
    } else {
        $("#ftip").attr("data-content", b).show("fast");
    }
    ftip_active = 1;
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm change_captcha
if (preg_match("/function[\s]+change_captcha(.*?)return[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function change_captcha(a) {
    if ($(\'[data-toggle=recaptcha]\').length) {
        "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
    } else if ($("[data-recaptcha3]").length) {
        "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
    }

    if ($("img.captchaImg").length) {
        $("img.captchaImg").attr("src", nv_base_siteurl + "index.php?scaptcha=captcha&nocache=" + nv_randomPassword(10));
        "undefined" != typeof a && "" != a && $(a).val("");
    }
    return !1
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm change_captcha',
        'replace' => 'function change_captcha(a) {
    if ($(\'[data-toggle=recaptcha]\').length) {
        "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
    } else if ($("[data-recaptcha3]").length) {
        "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
    }

    if ($("img.captchaImg").length) {
        $("img.captchaImg").attr("src", nv_base_siteurl + "index.php?scaptcha=captcha&nocache=" + nv_randomPassword(10));
        "undefined" != typeof a && "" != a && $(a).val("");
    }
    return !1
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm modalShow
if (preg_match("/function[\s]+modalShow(.*?)function[\s]+modalShowByObj/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function modalShow(a, b, callback) {
    "" != a && \'undefined\' != typeof a && $("#sitemodal .modal-content").prepend(\'<div class="modal-header"><h2 class="modal-title">\' + a + \'</h2></div>\');
    $("#sitemodal").find(".modal-title").html(a);
    $("#sitemodal").find(".modal-body").html(b);
    var scrollTop = false;
    if (typeof callback != "undefined") {
        if (callback == "recaptchareset") {
            scrollTop = $(window).scrollTop();
            $(\'#sitemodal\').on(\'show.bs.modal\', function() {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            });
        }
    }
    if (scrollTop) {
        $("html,body").animate({
            scrollTop: 0
        }, 200, function() {
            $("#sitemodal").modal({
                backdrop: "static"
            });
        });
        $(\'#sitemodal\').on(\'hide.bs.modal\', function() {
            $("html,body").animate({
                scrollTop: scrollTop
            }, 200);
        });
    } else {
        $("#sitemodal").modal({
            backdrop: "static"
        });
    }
    $(\'#sitemodal\').on(\'hidden.bs.modal\', function() {
        $("#sitemodal .modal-content").find(".modal-header").remove();
    });
}

function modalShowByObj';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm modalShow',
        'replace' => 'function modalShow(a, b, callback) {
    "" != a && \'undefined\' != typeof a && $("#sitemodal .modal-content").prepend(\'<div class="modal-header"><h2 class="modal-title">\' + a + \'</h2></div>\');
    $("#sitemodal").find(".modal-title").html(a);
    $("#sitemodal").find(".modal-body").html(b);
    var scrollTop = false;
    if (typeof callback != "undefined") {
        if (callback == "recaptchareset") {
            scrollTop = $(window).scrollTop();
            $(\'#sitemodal\').on(\'show.bs.modal\', function() {
                if ($(\'[data-toggle=recaptcha]\', this).length) {
                    reCaptcha2Recreate(this);
                    "undefined" != typeof grecaptcha ? reCaptcha2OnLoad() : reCaptcha2ApiLoad()
                } else if ($("[data-recaptcha3]", this).length) {
                    "undefined" != typeof grecaptcha ? reCaptcha3OnLoad() : reCaptcha3ApiLoad()
                }
            });
        }
    }
    if (scrollTop) {
        $("html,body").animate({
            scrollTop: 0
        }, 200, function() {
            $("#sitemodal").modal({
                backdrop: "static"
            });
        });
        $(\'#sitemodal\').on(\'hide.bs.modal\', function() {
            $("html,body").animate({
                scrollTop: scrollTop
            }, 200);
        });
    } else {
        $("#sitemodal").modal({
            backdrop: "static"
        });
    }
    $(\'#sitemodal\').on(\'hidden.bs.modal\', function() {
        $("#sitemodal .modal-content").find(".modal-header").remove();
    });
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thay hàm loginForm
if (preg_match("/function[\s]+loginForm(.*?)\)(\;)*[\r\n\s\t]+return[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'function loginForm(redirect) {
    if (nv_is_user == 1) {
        return !1;
    }
    if (redirect != \'\') {
        redirect = \'&nv_redirect=\' + redirect;
    }
    $.ajax({
        type: \'POST\',
        url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=users&\' + nv_fc_variable + \'=login\' + redirect,
        cache: !1,
        data: \'&nv_ajax=1\',
        dataType: "html"
    }).done(function(a) {
        modalShow(\'\', a, \'recaptchareset\')
    });
    return !1
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm',
        'find' => 'Hàm loginForm',
        'replace' => 'function loginForm(redirect) {
    if (nv_is_user == 1) {
        return !1;
    }
    if (redirect != \'\') {
        redirect = \'&nv_redirect=\' + redirect;
    }
    $.ajax({
        type: \'POST\',
        url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=users&\' + nv_fc_variable + \'=login\' + redirect,
        cache: !1,
        data: \'&nv_ajax=1\',
        dataType: "html"
    }).done(function(a) {
        modalShow(\'\', a, \'recaptchareset\')
    });
    return !1
}'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thêm functions: cookie_notice_hide, isRecaptchaCheck, reCaptcha2Recreate, reCaptcha2OnLoad, reCaptcha2Callback, reCaptcha2ApiLoad, reCaptcha3OnLoad, reCaptcha3ApiLoad
if (preg_match("/function[\s]+add_hint[\s]*\(/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Hide Cookie Notice Popup
function cookie_notice_hide() {
    nv_setCookie(nv_cookie_prefix + \'_cn\', \'1\', 365);
    $(".cookie-notice").hide()
}

function isRecaptchaCheck() {
    if (nv_recaptcha_sitekey == \'\') return 0;
    return (nv_recaptcha_ver == 2 || nv_recaptcha_ver == 3) ? nv_recaptcha_ver : 0
}

function reCaptcha2Recreate(obj) {
    $(\'[data-toggle=recaptcha]\', $(obj)).each(function() {
        var callFunc = $(this).data(\'callback\'),
            pnum = $(this).data(\'pnum\'),
            btnselector = $(this).data(\'btnselector\'),
            size = ($(this).data(\'size\') && $(this).data(\'size\') == \'compact\') ? \'compact\' : \'\';
        var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
        if (callFunc) {
            $(this).replaceWith(\'<div id="\' + id + \'" data-toggle="recaptcha" data-callback="\' + callFunc + \'" data-size="\' + size + \'"></div>\');
        } else {
            $(this).replaceWith(\'<div id="\' + id + \'" data-toggle="recaptcha" data-pnum="\' + pnum + \'" data-btnselector="\' + btnselector + \'" data-size="\' + size + \'"></div>\')
        }
    })
}

var reCaptcha2OnLoad = function() {
    $(\'[data-toggle=recaptcha]\').each(function() {
        var id = $(this).attr(\'id\'),
            callFunc = $(this).data(\'callback\'),
            size = ($(this).data(\'size\') && $(this).data(\'size\') == \'compact\') ? \'compact\' : \'\';

        if (typeof window[callFunc] === \'function\') {
            if (typeof reCapIDs[id] === "undefined") {
                reCapIDs[id] = grecaptcha.render(id, {
                    \'sitekey\': nv_recaptcha_sitekey,
                    \'type\': nv_recaptcha_type,
                    \'size\': size,
                    \'callback\': callFunc
                })
            } else {
                grecaptcha.reset(reCapIDs[id])
            }
        } else {
            var pnum = parseInt($(this).data(\'pnum\')),
                btnselector = $(this).data(\'btnselector\'),
                btn = $(\'#\' + id),
                k = 1;

            for (k; k <= pnum; k++) {
                btn = btn.parent();
            }
            btn = $(btnselector, btn);
            if (btn.length) {
                btn.prop(\'disabled\', true);
            }

            if (typeof reCapIDs[id] === "undefined") {
                reCapIDs[id] = grecaptcha.render(id, {
                    \'sitekey\': nv_recaptcha_sitekey,
                    \'type\': nv_recaptcha_type,
                    \'size\': size,
                    \'callback\': function() {
                        reCaptcha2Callback(id, false)
                    },
                    \'expired-callback\': function() {
                        reCaptcha2Callback(id, true)
                    },
                    \'error-callback\': function() {
                        reCaptcha2Callback(id, true)
                    }
                })
            } else {
                grecaptcha.reset(reCapIDs[id])
            }
        }
    })
}

var reCaptcha2Callback = function(id, val) {
    var btn = $(\'#\' + id),
        pnum = parseInt(btn.data(\'pnum\')),
        btnselector = btn.data(\'btnselector\'),
        k = 1;
    for (k; k <= pnum; k++) {
        btn = btn.parent();
    }
    btn = $(btnselector, btn);
    if (btn.length) {
        btn.prop(\'disabled\', val);
    }
}

// reCaptcha v2 load
var reCaptcha2ApiLoad = function() {
    if (isRecaptchaCheck() == 2) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//www.google.com/recaptcha/api.js?hl=" + nv_lang_interface + "&onload=reCaptcha2OnLoad&render=explicit";
        document.getElementsByTagName("head")[0].appendChild(a)
    }
}

// reCaptcha v3: reCaptcha3OnLoad
var reCaptcha3OnLoad = function() {
    grecaptcha.ready(function() {
        $("[data-recaptcha3]").length && (clearInterval(gEInterval), grecaptcha.execute(nv_recaptcha_sitekey, {
            action: "formSubmit"
        }).then(function(a) {
            $("[data-recaptcha3]").each(function() {
                if ($("[name=g-recaptcha-response]", this).length) $("[name=g-recaptcha-response]", this).val(a);
                else {
                    var b = $(\'<input type="hidden" name="g-recaptcha-response" value="\' + a + \'"/>\');
                    $(this).append(b)
                }
            })
        }), gEInterval = setTimeout(function() {
            reCaptcha3OnLoad()
        }, 12E4))
    })
}

// reCaptcha v3 API load
var reCaptcha3ApiLoad = function() {
    if (isRecaptchaCheck() == 3) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//www.google.com/recaptcha/api.js?render=" + nv_recaptcha_sitekey + "&onload=reCaptcha3OnLoad";
        document.getElementsByTagName("head")[0].appendChild(a)
    }
}

function add_hint(';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => 'function add_hint(type, url) {',
        'addbefore' => '// Hide Cookie Notice Popup
function cookie_notice_hide() {
    nv_setCookie(nv_cookie_prefix + \'_cn\', \'1\', 365);
    $(".cookie-notice").hide()
}

function isRecaptchaCheck() {
    if (nv_recaptcha_sitekey == \'\') return 0;
    return (nv_recaptcha_ver == 2 || nv_recaptcha_ver == 3) ? nv_recaptcha_ver : 0
}

function reCaptcha2Recreate(obj) {
    $(\'[data-toggle=recaptcha]\', $(obj)).each(function() {
        var callFunc = $(this).data(\'callback\'),
            pnum = $(this).data(\'pnum\'),
            btnselector = $(this).data(\'btnselector\'),
            size = ($(this).data(\'size\') && $(this).data(\'size\') == \'compact\') ? \'compact\' : \'\';
        var id = "recaptcha" + (new Date().getTime()) + nv_randomPassword(8);
        if (callFunc) {
            $(this).replaceWith(\'<div id="\' + id + \'" data-toggle="recaptcha" data-callback="\' + callFunc + \'" data-size="\' + size + \'"></div>\');
        } else {
            $(this).replaceWith(\'<div id="\' + id + \'" data-toggle="recaptcha" data-pnum="\' + pnum + \'" data-btnselector="\' + btnselector + \'" data-size="\' + size + \'"></div>\')
        }
    })
}

var reCaptcha2OnLoad = function() {
    $(\'[data-toggle=recaptcha]\').each(function() {
        var id = $(this).attr(\'id\'),
            callFunc = $(this).data(\'callback\'),
            size = ($(this).data(\'size\') && $(this).data(\'size\') == \'compact\') ? \'compact\' : \'\';

        if (typeof window[callFunc] === \'function\') {
            if (typeof reCapIDs[id] === "undefined") {
                reCapIDs[id] = grecaptcha.render(id, {
                    \'sitekey\': nv_recaptcha_sitekey,
                    \'type\': nv_recaptcha_type,
                    \'size\': size,
                    \'callback\': callFunc
                })
            } else {
                grecaptcha.reset(reCapIDs[id])
            }
        } else {
            var pnum = parseInt($(this).data(\'pnum\')),
                btnselector = $(this).data(\'btnselector\'),
                btn = $(\'#\' + id),
                k = 1;

            for (k; k <= pnum; k++) {
                btn = btn.parent();
            }
            btn = $(btnselector, btn);
            if (btn.length) {
                btn.prop(\'disabled\', true);
            }

            if (typeof reCapIDs[id] === "undefined") {
                reCapIDs[id] = grecaptcha.render(id, {
                    \'sitekey\': nv_recaptcha_sitekey,
                    \'type\': nv_recaptcha_type,
                    \'size\': size,
                    \'callback\': function() {
                        reCaptcha2Callback(id, false)
                    },
                    \'expired-callback\': function() {
                        reCaptcha2Callback(id, true)
                    },
                    \'error-callback\': function() {
                        reCaptcha2Callback(id, true)
                    }
                })
            } else {
                grecaptcha.reset(reCapIDs[id])
            }
        }
    })
}

var reCaptcha2Callback = function(id, val) {
    var btn = $(\'#\' + id),
        pnum = parseInt(btn.data(\'pnum\')),
        btnselector = btn.data(\'btnselector\'),
        k = 1;
    for (k; k <= pnum; k++) {
        btn = btn.parent();
    }
    btn = $(btnselector, btn);
    if (btn.length) {
        btn.prop(\'disabled\', val);
    }
}

// reCaptcha v2 load
var reCaptcha2ApiLoad = function() {
    if (isRecaptchaCheck() == 2) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//www.google.com/recaptcha/api.js?hl=" + nv_lang_interface + "&onload=reCaptcha2OnLoad&render=explicit";
        document.getElementsByTagName("head")[0].appendChild(a)
    }
}

// reCaptcha v3: reCaptcha3OnLoad
var reCaptcha3OnLoad = function() {
    grecaptcha.ready(function() {
        $("[data-recaptcha3]").length && (clearInterval(gEInterval), grecaptcha.execute(nv_recaptcha_sitekey, {
            action: "formSubmit"
        }).then(function(a) {
            $("[data-recaptcha3]").each(function() {
                if ($("[name=g-recaptcha-response]", this).length) $("[name=g-recaptcha-response]", this).val(a);
                else {
                    var b = $(\'<input type="hidden" name="g-recaptcha-response" value="\' + a + \'"/>\');
                    $(this).append(b)
                }
            })
        }), gEInterval = setTimeout(function() {
            reCaptcha3OnLoad()
        }, 12E4))
    })
}

// reCaptcha v3 API load
var reCaptcha3ApiLoad = function() {
    if (isRecaptchaCheck() == 3) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//www.google.com/recaptcha/api.js?render=" + nv_recaptcha_sitekey + "&onload=reCaptcha3OnLoad";
        document.getElementsByTagName("head")[0].appendChild(a)
    }
}

'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Xóa hàm reCaptchaLoadCallback
if (preg_match("/var[\s]+reCaptchaLoadCallback(.*?)\}[\r\n\s\t]+\}[\r\n\s\t]+\}[\r\n\s\t]+/is", $output_data, $m)) {
    $find = $m[0];
    $replace = "\n";
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm và xóa hàm',
        'find' => 'reCaptchaLoadCallback',
        'replace' => ''
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Xóa hàm reCaptchaResCallback
if (preg_match("/var[\s]+reCaptchaResCallback(.*?)\}[\r\n\s\t]+\}[\r\n\s\t]+\}[\r\n\s\t]+\}[\r\n\s\t]+\}[\r\n\s\t]+/is", $output_data, $m)) {
    $find = $m[0];
    $replace = "\n";
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm và xóa hàm',
        'find' => 'reCaptchaResCallback',
        'replace' => ''
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Xóa hàm add_hint
if (preg_match("/function[\s]+add_hint(.*?)document\.getElementsByTagName\(\"head\"\)\[0\]\.appendChild\(el\)[\n\r\s\t]*\}[\n\r\s\t]*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = "\n";
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'findMessage' => 'Tìm và xóa hàm',
        'find' => 'add_hint',
        'replace' => ''
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Thêm rel="noopener noreferrer nofollow" to all external links
if (preg_match("/\/\/[\s]+Smooth[\s]+scroll[\s]+to[\s]+top/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Add rel="noopener noreferrer nofollow" to all external links
    $(\'a[href^="http"]\').not(\'a[href*="\' + location.hostname + \'"]\').not(\'[rel*=dofollow]\').attr({
        target: "_blank",
        rel: "noopener noreferrer nofollow"
    });

    // Smooth scroll to top';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '    // Smooth scroll to top',
        'addbefore' => '    // Add rel="noopener noreferrer nofollow" to all external links
    $(\'a[href^="http"]\').not(\'a[href*="\' + location.hostname + \'"]\').not(\'[rel*=dofollow]\').attr({
        target: "_blank",
        rel: "noopener noreferrer nofollow"
    });

'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'js');

// Load Social script - lasest
if (preg_match("/if[\s]*\([\s]*typeof[\s]*nv_is_recaptcha[\s]*\!\=[\s]*\"undefined\"[\s]*\&\&[\s]*nv_is_recaptcha[\s]*\&\&[\s]*nv_recaptcha_elements\.length[\s]*\>[\s]*0[\s]*\)[\s]*\{[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '0 < $(".zalo-share-button, .zalo-follow-only-button, .zalo-follow-button, .zalo-chat-widget").length && function() {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//sp.zalo.me/plugins/sdk.js";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }();
    if ($(\'[data-toggle=recaptcha]\').length) {
        reCaptcha2ApiLoad()
    } else if ($("[data-recaptcha3]").length) {
        reCaptcha3ApiLoad()
    }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => 'if (typeof nv_is_recaptcha != "undefined" && nv_is_recaptcha && nv_recaptcha_elements.length > 0) {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.async = !0;
        a.src = "https://www.google.com/recaptcha/api.js?hl=" + nv_lang_interface + "&onload=reCaptchaLoadCallback&render=explicit";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }',
        'replace' => '0 < $(".zalo-share-button, .zalo-follow-only-button, .zalo-follow-button, .zalo-chat-widget").length && function() {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.src = "//sp.zalo.me/plugins/sdk.js";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }();
    if ($(\'[data-toggle=recaptcha]\').length) {
        reCaptcha2ApiLoad()
    } else if ($("[data-recaptcha3]").length) {
        reCaptcha3ApiLoad()
    }'
    ));
}
