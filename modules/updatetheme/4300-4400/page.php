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

if (preg_match('/js\/users\.js$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'js');

    if (preg_match("/\\$[\s]*\([\s]*a[\s]*\)\.css[\s]*\(('|\")z\-index('|\")[\s]*\,[\s]*('|\")1000('|\")[\s]*\)\.datepicker[\s]*\(('|\")show('|\")[\s]*\)[\s]*\;/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '$(a).css("z-index", "9998").datepicker(\'show\');';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '$(a).css("z-index", "1000").datepicker(\'show\');',
            'replace' => '$(a).css("z-index", "9998").datepicker(\'show\');'
        ));
    }
} elseif (preg_match('/css\/users\.css$/', $file)) {
    nv_get_update_result('users');

    if (!preg_match("/\.openid\-btns[\s]*\{/i", $output_data)) {
        nvUpdateContructItem('users', 'css');
        $replace = '.openid-btns {
    border-top: 1px #fff solid;
    padding-top: 15px;
}

.openid-btns .btn-group {
    display: flex;
    width: 100%;
}

.openid-btns .btn-group button.btn {
    width: 40px;
    text-align: center;
}

.openid-btns .btn-group a.btn {
    flex-grow: 1;
    text-align: left;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.openid-google {
    color: #ffffff !important;
    background-color: #d9534f;
    border-color: #d43f3a;
}

.openid-google:focus {
    color: #ffffff;
    background-color: #c9302c;
    border-color: #761c19;
}

.openid-google:hover {
    color: #ffffff;
    background-color: #c9302c;
    border-color: #ac2925;
}

.openid-google:active {
    color: #ffffff;
    background-color: #c9302c;
    border-color: #ac2925;
}

.openid-google:active:hover,
.openid-google:active:focus {
    color: #ffffff;
    background-color: #ac2925;
    border-color: #761c19;
}

.openid-google:active {
    background-image: none;
}

.openid-google.disabled:hover,
.openid-google[disabled]:hover,
fieldset[disabled] .openid-google:hover,
.openid-google.disabled:focus,
.openid-google[disabled]:focus,
fieldset[disabled] .openid-google:focus {
    background-color: #d9534f;
    border-color: #d43f3a;
    cursor: inherit;
}

.openid-facebook {
    color: #ffffff !important;
    background-color: #428bca;
    border-color: #357ebd;
}

.openid-facebook:focus {
    color: #ffffff;
    background-color: #3071a9;
    border-color: #193c5a;
}

.openid-facebook:hover {
    color: #ffffff;
    background-color: #3071a9;
    border-color: #285e8e;
}

.openid-facebook:active {
    color: #ffffff;
    background-color: #3071a9;
    border-color: #285e8e;
}

.openid-facebook:active:hover,
.openid-facebook:active:focus {
    color: #ffffff;
    background-color: #285e8e;
    border-color: #193c5a;
}

.openid-facebook:active {
    background-image: none;
}

.openid-facebook.disabled:hover,
.openid-facebook[disabled]:hover,
.openid-facebook.disabled:focus,
.openid-facebook[disabled]:focus,
fieldset[disabled] .openid-facebook:focus {
    background-color: #428bca;
    border-color: #357ebd;
    cursor: inherit;
}

.openid-single-sign-on {
    color: #ffffff !important;
    background-color: #5cb85c;
    border-color: #4cae4c;
}

.openid-single-sign-on:focus {
    color: #ffffff;
    background-color: #449d44;
    border-color: #255625;
}

.openid-single-sign-on:hover {
    color: #ffffff;
    background-color: #449d44;
    border-color: #398439;
}

.openid-single-sign-on:active {
    color: #ffffff;
    background-color: #449d44;
    border-color: #398439;
}

.openid-single-sign-on:active:hover,
.openid-single-sign-on:active:focus {
    color: #ffffff;
    background-color: #398439;
    border-color: #255625;
}

.openid-single-sign-on:active {
    background-image: none;
}

.openid-single-sign-on.disabled:hover,
.openid-single-sign-on[disabled]:hover,
.openid-single-sign-on.disabled:focus,
.openid-single-sign-on[disabled]:focus,
fieldset[disabled] .openid-single-sign-on:focus {
    background-color: #5cb85c;
    border-color: #4cae4c;
    cursor: inherit;
}

';
        $output_data = trim($output_data) . "\n\n" . $replace;
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => 'Vị trí kết thúc của file',
            'replace' => $replace
        ));
    }
} elseif (preg_match('/users\/theme\.php$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'php');

    if (preg_match("/\/\/[\s]*C([^\n]+)[\s\n\t\r]*if[\s]*\([\s]*\![\s]*empty[\s]*\(([^\)]+)\)[\s]*\)[\s\n\t\r]*\{[\s\n\t\r]*if[\s]*\(([^\)]+)[\s]*\)[\s\n\t\r]*\{[\s\n\t\r]*\\\$row\[[\s]*('|\")value('|\")[\s]*\][\s]*\=[\s]*\([\s]*empty[\s]*\(([^\)]+)\)[\s]*\)([^\n]+)/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '                    $datepicker = true;';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '            // Các trường hệ thống xuất độc lập
            if (!empty($row[\'system\'])) {
                if ($row[\'field\'] == \'birthday\') {
                    $row[\'value\'] = (empty($row[\'value\'])) ? \'\' : date(\'d/m/Y\', $row[\'value\']);',
            'addafter' => '                    $datepicker = true;'
        ));
    }

    nvUpdateContructItem('users', 'php');

    if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*('|\")USER\_LOSTPASS('|\")[\s]*\,[\s]*NV\_BASE\_SI([^\n]+)lostpass('|\")[\s]*\)[\s]*\;[\s\n\t\r]*\\\$xtpl\-\>assign[\s]*\([\s]*('|\")LANG('|\")[\s]*\,[\s]*\\\$lang\_module[\s]*\)[\s]*\;[\s\n\t\r]*\\\$xtpl\-\>assign[\s]*\([\s]*('|\")GLANG('|\")[\s]*\,[\s]*\\\$lang\_global[\s]*\)[\s]*\;/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    $xtpl->assign(\'TEMPLATE\', $module_info[\'template\']);';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '    $xtpl->assign(\'USER_LOSTPASS\', NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=\' . $module_name . \'&amp;\' . NV_OP_VARIABLE . \'=lostpass\');
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'GLANG\', $lang_global);',
            'addafter' => '    $xtpl->assign(\'TEMPLATE\', $module_info[\'template\']);'
        ));
    }

    nvUpdateContructItem('users', 'php');

    if (preg_match("/if[\s]*\([\s]*defined[\s]*\([\s]*('|\")NV_OPENID_ALLOWED('|\")[\s]*\)[\s]*\)[\s\n\t\r]*\{[\s\n\t\r]*\\\$assigns[\s]*\=[\s]*array[\s]*\([\s]*\)[\s]*\;/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        $icons = array(
            \'single-sign-on\' => \'lock\',
            \'google\' => \'google-plus\',
            \'facebook\' => \'facebook\'
        );';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '    if (defined(\'NV_OPENID_ALLOWED\')) {
        $assigns = array();',
            'addafter' => '        $icons = array(
            \'single-sign-on\' => \'lock\',
            \'google\' => \'google-plus\',
            \'facebook\' => \'facebook\'
        );'
        ));
    }

    nvUpdateContructItem('users', 'php');

    if (preg_match("/\\\$assigns[\s]*\[[\s]*('|\")server('|\")[\s]*\][\s]*\=[\s]*\\\$server[\s]*\;[\s\n\t\r]*\\\$assigns[\s]*\[[\s]*('|\")title('|\")[\s]*\][\s]*\=[\s]*ucfirst[\s]*\([\s]*\\\$server[\s]*\)[\s]*\;[\s\n\t\r]*\\\$assigns[\s]*\[[\s]*('|\")img\_src('|\")[\s]*\][\s]*\=([^\n]+)[\s\n\t\r]*\\\$assigns[\s]*\[[\s]*('|\")img\_width('|\")[\s]*\]([^\n]+)\=[\s]*([0-9]+)[\s]*\;/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '$assigns[\'server\'] = $server;
            $assigns[\'title\'] = ucfirst($server);
            $assigns[\'icon\'] = $icons[$server];';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '            $assigns[\'server\'] = $server;
            $assigns[\'title\'] = ucfirst($server);
            $assigns[\'img_src\'] = NV_BASE_SITEURL . \'themes/\' . $module_info[\'template\'] . \'/images/\' . $module_info[\'module_theme\'] . \'/\' . $server . \'.png\';
            $assigns[\'img_width\'] = $assigns[\'img_height\'] = 24;',
            'replace' => '            $assigns[\'server\'] = $server;
            $assigns[\'title\'] = ucfirst($server);
            $assigns[\'icon\'] = $icons[$server];'
        ));
    }
} elseif (preg_match('/users\/ajax\_login\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    $output_data_check = str_replace('/default/', '/{TEMPLATE}/', $output_data);
    if ($output_data_check != $output_data) {
        $output_data = $output_data_check;
        $find = '/default/';
        $replace = '/{TEMPLATE}/';
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '<link type="text/css" href="{NV_BASE_SITEURL}themes/default/css/users.css" rel="stylesheet" />
<script src="{NV_BASE_SITEURL}themes/default/js/users.js"></script>',
            'replace' => '<link type="text/css" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/users.css" rel="stylesheet" />
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/users.js"></script>'
        ));
    }
} elseif (preg_match('/users\/block\.login\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    $output_data_check = str_replace('/default/', '/{BLOCK_THEME}/', $output_data);
    if ($output_data_check != $output_data) {
        $output_data = $output_data_check;
        $find = '/default/';
        $replace = '/{BLOCK_THEME}/';
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '<script src="{NV_BASE_SITEURL}themes/default/js/users.js"></script> (có 2 đoạn)',
            'replace' => '<script src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/js/users.js"></script>'
        ));
    }
} elseif (preg_match('/users\/block\.user\_button\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    $output_data_check = str_replace('/default/', '/{BLOCK_THEME}/', $output_data);
    if ($output_data_check != $output_data) {
        $output_data = $output_data_check;
        $find = '/default/';
        $replace = '/{BLOCK_THEME}/';
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '<script src="{NV_BASE_SITEURL}themes/default/js/users.js"></script>',
            'replace' => '<script src="{NV_BASE_SITEURL}themes/{BLOCK_THEME}/js/users.js"></script>'
        ));
    }
} elseif (preg_match('/users\/login\_form\.tpl$/', $file)) {
    nv_get_update_result('users');
    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<a([^\>]+)onclick[\s]*\=[\s]*\"[\s]*modalShowByObj[\s]*\([\s]*\'\#guestReg\_\{BLOCKID\}\'[\s]*\)[\s]*\"[\s]*\>[\s]*\{GLANG\.register\}[\s]*\<\/a\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '<a href="#" onclick="modalShowByObj(\'#guestReg_{BLOCKID}\', \'recaptchareset\')">{GLANG.register}</a>';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '<a href="#" onclick="modalShowByObj(\'#guestReg_{BLOCKID}\')">{GLANG.register}</a>',
            'replace' => '<a href="#" onclick="modalShowByObj(\'#guestReg_{BLOCKID}\', \'recaptchareset\')">{GLANG.register}</a>'
        ));
    }

    nvUpdateContructItem('users', 'html');

    if (preg_match("/\<hr([^\>]+)\>[\s\n\t\r]*\<div([^\>]+)\>[\s\n\t\r]*\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*server[\s]*\-\-\>(.*?)\<\!\-\- END\:[\s]*server[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<div class="text-center openid-btns">
            <!-- BEGIN: server -->
            <div class="btn-group m-bottom btn-group-justified">
                <button class="btn openid-{OPENID.server} disabled" type="button" tabindex="-1"><i class="fa fa-fw fa-{OPENID.icon}"></i></button>
                <a class="btn openid-{OPENID.server}" href="{OPENID.href}" onclick="return openID_load(this);">{LANG.login_with} {OPENID.title}</a>
            </div>
            <!-- END: server -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('users', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('users', array(
            'find' => '       	<hr />
       	<div class="text-center">
      		<!-- BEGIN: server -->
      		<a title="{LANG.login_with} {OPENID.title}" href="{OPENID.href}" class="openid margin-right" onclick="return openID_load(this);"><img alt="{OPENID.title}" title="{OPENID.title}" src="{OPENID.img_src}" width="{OPENID.img_width}" height="{OPENID.img_height}" /></a>
      		<!-- END: server -->',
            'replace' => '        <div class="text-center openid-btns">
            <!-- BEGIN: server -->
            <div class="btn-group m-bottom btn-group-justified">
                <button class="btn openid-{OPENID.server} disabled" type="button" tabindex="-1"><i class="fa fa-fw fa-{OPENID.icon}"></i></button>
                <a class="btn openid-{OPENID.server}" href="{OPENID.href}" onclick="return openID_load(this);">{LANG.login_with} {OPENID.title}</a>
            </div>
            <!-- END: server -->'
        ));
    }
}
