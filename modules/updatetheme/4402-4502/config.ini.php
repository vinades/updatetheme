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
 * Cập nhật config.ini
 */

// Xóa config pixel_per_point nếu có, nếu không thì thôi
if (preg_match("/[\r\n\s\t]*\<config\>[^\<]+pixel_per_point[^\<]+outer_frame[^\<]+\<\/config\>/is", $output_data, $m)) {
    nv_get_update_result('base');
    nvUpdateContructItem('base', 'xml');

    $find = $m[0];
    $replace = '';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
}
