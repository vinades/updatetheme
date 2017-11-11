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

if (preg_match('/page\/theme\.php$/', $file)) {
    nv_get_update_result('page');
    nvUpdateContructItem('page', 'php');

    if (preg_match("/global \\$([^\;]+)\;[\s\n\t\r]*\\\$xtpl[\s]*\=[\s]*new[\s]+XTemplate[\s]*\([\s]*('|\")main\.tpl('|\")([^\;]+)\;/i", $output_data, $m)) {
        $find = $m[0];
        $replace = 'global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config;

    $xtpl = new XTemplate(\'main.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'LANG\', $lang_module);';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('page', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('page', array(
            'find' => '    global $module_name, $lang_global, $module_info, $meta_property, $client_info, $page_config;

    $xtpl = new XTemplate(\'main.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);',
            'replace' => '    global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config;

    $xtpl = new XTemplate(\'main.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'LANG\', $lang_module);'
        ));
    }

    nvUpdateContructItem('page', 'php');

    if (preg_match("/\\\$xtpl\-\>parse[\s]*\([\s]*('|\")main\.adminlink('|\")[\s]*\)[\s]*\;[\s\n\t\r]*\}/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '$xtpl->parse(\'main.adminlink\');

        // Hiển thị cảnh báo cho người quản trị nếu bài ngưng hoạt động
        if (!$row[\'status\']) {
            $xtpl->parse(\'main.warning\');
        }
    } elseif (!$row[\'status\']) {
        nv_redirect_location(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&\' . NV_NAME_VARIABLE . \'=\' . $module_name);
    }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('page', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('page', array(
            'find' => '        $xtpl->parse(\'main.adminlink\');
    }',
            'replace' => '        $xtpl->parse(\'main.adminlink\');

        // Hiển thị cảnh báo cho người quản trị nếu bài ngưng hoạt động
        if (!$row[\'status\']) {
            $xtpl->parse(\'main.warning\');
        }
    } elseif (!$row[\'status\']) {
        nv_redirect_location(NV_BASE_SITEURL . \'index.php?\' . NV_LANG_VARIABLE . \'=\' . NV_LANG_DATA . \'&\' . NV_NAME_VARIABLE . \'=\' . $module_name);
    }'
        ));
    }
} elseif (preg_match('/page\/main\.tpl$/', $file)) {
    nv_get_update_result('page');
    nvUpdateContructItem('page', 'html');

    if (preg_match("/\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*main[\s]*\-\-\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '<!-- BEGIN: warning -->
<div class="alert alert-danger">{LANG.warning}</div>
<!-- END: warning -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('page', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('page', array(
            'find' => '<!-- BEGIN: main -->',
            'addafter' => '<!-- BEGIN: warning -->
<div class="alert alert-danger">{LANG.warning}</div>
<!-- END: warning -->'
        ));
    }
}