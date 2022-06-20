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
 * Cập nhật footer_only.tpl của giao diện
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'html');

// Thêm cookie_notice
if (preg_match("/\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*lt_ie9(.*?)\<\!\-\-[\s]*END[\s]*\:[\s]*lt_ie9[\s]*\-\-\>/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '<!-- BEGIN: lt_ie9 --><p class="chromeframe">{LANG.chromeframe}</p><!-- END: lt_ie9 -->
        <!-- BEGIN: cookie_notice --><div class="cookie-notice"><div><button onclick="cookie_notice_hide();">&times;</button>{COOKIE_NOTICE}</div></div><!-- END: cookie_notice -->';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '    	<!-- BEGIN: lt_ie9 --><p class="chromeframe">{LANG.chromeframe}</p><!-- END: lt_ie9 -->',
        'addafter' => '        <!-- BEGIN: cookie_notice --><div class="cookie-notice"><div><button onclick="cookie_notice_hide();">&times;</button>{COOKIE_NOTICE}</div></div><!-- END: cookie_notice -->'
    ));
}

nv_get_update_result('base');
nvUpdateContructItem('base', 'html');

// Thêm cookie_notice
if (preg_match("/\<script[^\>]+bootstrap\.min\.js[^\>]+\>[\r\n\s\t]*\<\/script\>/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '<!-- BEGIN: crossdomain_listener -->
        <script type="text/javascript">
        function nvgSSOReciver(event) {
            if (event.origin !== \'{SSO_REGISTER_ORIGIN}\') {
                return false;
            }
            if (
                event.data !== null && typeof event.data == \'object\' && event.data.code == \'oauthback\' &&
                typeof event.data.redirect != \'undefined\' && typeof event.data.status != \'undefined\' && typeof event.data.mess != \'undefined\'
            ) {
                $(\'#openidResult\').data(\'redirect\', event.data.redirect);
                $(\'#openidResult\').data(\'result\', event.data.status);
                $(\'#openidResult\').html(event.data.mess + (event.data.status == \'success\' ? \' <span class="load-bar"></span>\' : \'\'));
                $(\'#openidResult\').addClass(\'nv-info \' + event.data.status);
                $(\'#openidBt\').trigger(\'click\');
            }
        }
        window.addEventListener(\'message\', nvgSSOReciver, false);
        </script>
        <!-- END: crossdomain_listener -->
        <script src="{NV_STATIC_URL}themes/{TEMPLATE}/js/bootstrap.min.js"></script>';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/bootstrap.min.js"></script>',
        'addbefore' => '        <!-- BEGIN: crossdomain_listener -->
        <script type="text/javascript">
        function nvgSSOReciver(event) {
            if (event.origin !== \'{SSO_REGISTER_ORIGIN}\') {
                return false;
            }
            if (
                event.data !== null && typeof event.data == \'object\' && event.data.code == \'oauthback\' &&
                typeof event.data.redirect != \'undefined\' && typeof event.data.status != \'undefined\' && typeof event.data.mess != \'undefined\'
            ) {
                $(\'#openidResult\').data(\'redirect\', event.data.redirect);
                $(\'#openidResult\').data(\'result\', event.data.status);
                $(\'#openidResult\').html(event.data.mess + (event.data.status == \'success\' ? \' <span class="load-bar"></span>\' : \'\'));
                $(\'#openidResult\').addClass(\'nv-info \' + event.data.status);
                $(\'#openidBt\').trigger(\'click\');
            }
        }
        window.addEventListener(\'message\', nvgSSOReciver, false);
        </script>
        <!-- END: crossdomain_listener -->        <!-- BEGIN: crossdomain_listener -->
        <script type="text/javascript">
        function nvgSSOReciver(event) {
            if (event.origin !== \'{SSO_REGISTER_ORIGIN}\') {
                return false;
            }
            if (
                event.data !== null && typeof event.data == \'object\' && event.data.code == \'oauthback\' &&
                typeof event.data.redirect != \'undefined\' && typeof event.data.status != \'undefined\' && typeof event.data.mess != \'undefined\'
            ) {
                $(\'#openidResult\').data(\'redirect\', event.data.redirect);
                $(\'#openidResult\').data(\'result\', event.data.status);
                $(\'#openidResult\').html(event.data.mess + (event.data.status == \'success\' ? \' <span class="load-bar"></span>\' : \'\'));
                $(\'#openidResult\').addClass(\'nv-info \' + event.data.status);
                $(\'#openidBt\').trigger(\'click\');
            }
        }
        window.addEventListener(\'message\', nvgSSOReciver, false);
        </script>
        <!-- END: crossdomain_listener -->'
    ));
}
