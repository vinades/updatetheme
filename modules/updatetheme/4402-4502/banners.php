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

if (preg_match('/banners\/global\.banners\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');

    if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*type\_image[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    <!-- BEGIN: bannerhtml -->
    <div class="clearfix text-left">
        {DATA.bannerhtml}
    </div>
    <!-- END: bannerhtml -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('banners', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('banners', array(
            'find' => '    <!-- END: type_image -->',
            'addafter' => '    <!-- BEGIN: bannerhtml -->
    <div class="clearfix text-left">
        {DATA.bannerhtml}
    </div>
    <!-- END: bannerhtml -->'
        ));
    }
} elseif (preg_match('/banners\.js$/', $file)) {
    // Xóa luôn file banners.js nếu có
    @nv_deletefile(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/js/banners.js');
} elseif (preg_match('/banners\/addads\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');

    // Copy file này từ giao diện mặc định sang và thông báo tự sửa bằng tay
    $default_contents = file_get_contents(NV_ROOTDIR . '/themes/default/modules/banners/addads.tpl');
    nvUpdateSetItemGuide('banners', array(
        'findMessage' => 'Chú ý:',
        'find' => 'Hệ thống tự thay toàn bộ file này bằng file từ giao diện mặc định do phần này ít tùy biến và có rất nhiều thay đổi, bạn cần kiểm tra lại. Có thể so sánh code để cập nhật thủ công nếu bạn đã sửa đổi ở file này'
    ));
    $output_data = $default_contents;
} elseif (preg_match('/banners\/home\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');

    // Copy file này từ giao diện mặc định sang và thông báo tự sửa bằng tay
    $default_contents = file_get_contents(NV_ROOTDIR . '/themes/default/modules/banners/home.tpl');
    nvUpdateSetItemGuide('banners', array(
        'findMessage' => 'Chú ý:',
        'find' => 'Hệ thống tự thay toàn bộ file này bằng file từ giao diện mặc định do phần này ít tùy biến và có rất nhiều thay đổi, bạn cần kiểm tra lại. Có thể so sánh code để cập nhật thủ công nếu bạn đã sửa đổi ở file này'
    ));
    $output_data = $default_contents;
} elseif (preg_match('/banners\/stats\.tpl$/', $file)) {
    nv_get_update_result('banners');
    nvUpdateContructItem('banners', 'html');

    // Copy file này từ giao diện mặc định sang và thông báo tự sửa bằng tay
    $default_contents = file_get_contents(NV_ROOTDIR . '/themes/default/modules/banners/stats.tpl');
    nvUpdateSetItemGuide('banners', array(
        'findMessage' => 'Chú ý:',
        'find' => 'Hệ thống tự thay toàn bộ file này bằng file từ giao diện mặc định do phần này ít tùy biến và có rất nhiều thay đổi, bạn cần kiểm tra lại. Có thể so sánh code để cập nhật thủ công nếu bạn đã sửa đổi ở file này'
    ));
    $output_data = $default_contents;
}
