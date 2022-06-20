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
 * Cập nhật theme.php của giao diện
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'php');

// Bổ sung biến
if (preg_match("/if[\s]*\([\s]*\![\s]*defined[\s]*\([\s]*'NV_SYSTEM'[\s]*\)[^\;]+\;[\r\n\s\t]*\}*[\r\n\s\t]*/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'if (!defined(\'NV_SYSTEM\') or !defined(\'NV_MAINFILE\')) {
    die(\'Stop!!!\');
}

$theme_config = [
    \'pagination\' => [
        // Nếu dùng bootstrap 3: \'pagination\'
        // Nếu dùng bootstrap 4/5: \'pagination justify-content-center\'
        \'ul_class\' => \'pagination\',
        // Nếu dùng bootstrap 3: \'\',
        // Nếu dùng bootstrap 4/5: \'page-item\'
        \'li_class\' => \'\',
        // Nếu dùng bootstrap 3: \'\',
        // Nếu dùng bootstrap 4/5: \'page-link\'
        \'a_class\' => \'\'
    ]
];
';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => 'if (!defined(\'NV_SYSTEM\') or !defined(\'NV_MAINFILE\')) {
    die(\'Stop!!!\');
}',
        'addafter' => '
$theme_config = [
    \'pagination\' => [
        // Nếu dùng bootstrap 3: \'pagination\'
        // Nếu dùng bootstrap 4/5: \'pagination justify-content-center\'
        \'ul_class\' => \'pagination\',
        // Nếu dùng bootstrap 3: \'\',
        // Nếu dùng bootstrap 4/5: \'page-item\'
        \'li_class\' => \'\',
        // Nếu dùng bootstrap 3: \'\',
        // Nếu dùng bootstrap 4/5: \'page-link\'
        \'a_class\' => \'\'
    ]
];'
    ));
}

// Sửa hàm nv_mailHTML
if (preg_match('/function[\s]+nv_mailHTML/is', $output_data)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'php');

    if (preg_match("/function[\s]+nv_mailHTML(.*?)global[^\;]+\;/is", $output_data, $m)) {
        $find = $m[0];
        $replace = 'function nv_mailHTML($title, $content, $footer = \'\')
{
    global $global_config, $lang_global;

    $title = nv_autoLinkDisable($title);
';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('base', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('base', array(
            'find' => 'function nv_mailHTML($title, $content, $footer = \'\')
{
    global $global_config, $lang_global;',
            'addafter' => '

    $title = nv_autoLinkDisable($title);

'
        ));
    }

    nv_get_update_result('base');
    nvUpdateContructItem('base', 'php');

    if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*'MESSAGE_FOOTER'[\s]*\,[\s]*\\\$footer[\s]*\)[\s]*\;/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '$xtpl->assign(\'MESSAGE_FOOTER\', $footer);

    if (!empty($global_config[\'phonenumber\'])) {
        $xtpl->parse(\'main.phonenumber\');
    }
';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('base', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('base', array(
            'find' => '    $xtpl->assign(\'MESSAGE_FOOTER\', $footer);',
            'addafter' => '
    if (!empty($global_config[\'phonenumber\'])) {
        $xtpl->parse(\'main.phonenumber\');
    }

'
        ));
    }

    nv_get_update_result('base');
    nvUpdateContructItem('base', 'php');

    if (preg_match("/[\r\n\s\t]*\\\$xtpl\-\>parse[\s]*\([\s]*'main'[\s]*\)[\s]*\;[\r\n\s\t]*\\\$sitecontent[\s]*\=[\s]*\\\$xtpl\-\>text[\s]*\([\s]*'main'[\s]*\)[\s]*\;/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '

    if (defined(\'SSO_REGISTER_DOMAIN\')) {
        $xtpl->assign(\'SSO_REGISTER_ORIGIN\', SSO_REGISTER_DOMAIN);
        $xtpl->parse(\'main.crossdomain_listener\');
    }

    if ($global_config[\'cookie_notice_popup\'] and !isset($_COOKIE[$global_config[\'cookie_prefix\'] . \'_cn\'])) {
        $xtpl->assign(\'COOKIE_NOTICE\', sprintf($lang_global[\'cookie_notice\'], NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=siteterms&amp;\' . NV_OP_VARIABLE . \'=privacy\' . $global_config[\'rewrite_exturl\']));
        $xtpl->parse(\'main.cookie_notice\');
    }

    $xtpl->parse(\'main\');
    $sitecontent = $xtpl->text(\'main\');';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('base', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('base', array(
            'find' => '    $xtpl->parse(\'main\');
    $sitecontent = $xtpl->text(\'main\');',
            'addbefore' => '    if ($global_config[\'cookie_notice_popup\'] and !isset($_COOKIE[$global_config[\'cookie_prefix\'] . \'_cn\'])) {
        $xtpl->assign(\'COOKIE_NOTICE\', sprintf($lang_global[\'cookie_notice\'], NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&amp;\' . NV_NAME_VARIABLE . \'=siteterms&amp;\' . NV_OP_VARIABLE . \'=privacy\' . $global_config[\'rewrite_exturl\']));
        $xtpl->parse(\'main.cookie_notice\');
    }

'
        ));
    }
}
