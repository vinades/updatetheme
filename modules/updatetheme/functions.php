<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 09 Jan 2014 10:18:48 GMT
 */

if (!defined('NV_SYSTEM'))
    die('Stop!!!');

if ($sys_info['allowed_set_time_limit']) {
    set_time_limit(0);
}

define('NV_IS_MOD_UPDATETHEME', true);

/**
 * list_all_file()
 * 
 * @param string $dir
 * @param string $base_dir
 * @return
 */
function list_all_file($dir = '', $base_dir = '')
{
    $file_list = array();

    if (is_dir($dir)) {
        $array_filedir = scandir($dir);

        foreach ($array_filedir as $v) {
            if ($v == '.' or $v == '..')
                continue;

            if (is_dir($dir . '/' . $v)) {
                foreach (list_all_file($dir . '/' . $v, $base_dir . '/' . $v) as $file) {
                    $file_list[] = $file;
                }
            } else {
                // if( $base_dir == '' and ( $v == 'index.html' or $v == 'index.htm' ) ) continue; // Khong di chuyen index.html
                $file_list[] = preg_replace('/^\//', '', $base_dir . '/' . $v);
            }
        }
    }

    return $file_list;
}
