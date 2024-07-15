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

/**
 * nv_get_update_result()
 *
 * @param mixed $key
 * @return void
 */
function nv_get_update_result($key)
{
    global $array_update_result, $theme_update, $file_key, $file;

    if (!isset($array_update_result[$key])) {
        $array_update_result[$key] = array();
    }
    if (!isset($array_update_result[$key]['files'])) {
        $array_update_result[$key]['files'] = array();
    }
    if (!isset($array_update_result[$key]['files'][$file_key])) {
        $array_update_result[$key]['files'][$file_key] = array(
            'name' => str_replace(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update . '/', '', $file),
            'data' => array()
        );
    }
}

/**
 * nvUpdateContructItem()
 *
 * @param mixed $item_key
 * @param string $item_type
 * @return void
 */
function nvUpdateContructItem($item_key, $item_type = 'php')
{
    global $array_update_result, $file_key, $global_autokey;
    $global_autokey++;
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey] = array(
        'find' => '',
        'replace' => '',
        'status' => 0,
        'guide' => array(),
        'type' => $item_type
    );
}

/**
 * nvUpdateSetItemData()
 *
 * @param mixed $item_key
 * @param mixed $array
 * @return void
 */
function nvUpdateSetItemData($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey, $num_section_auto;
    $num_section_auto++;
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey] = array_merge($array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey], $array);
}

/**
 * nvUpdateSetItemGuide()
 *
 * @param mixed $item_key
 * @param mixed $array
 * @return void
 */
function nvUpdateSetItemGuide($item_key, $array)
{
    global $array_update_result, $file_key, $global_autokey, $num_section_manual;
    $num_section_manual++;
    $array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey]['guide'] = array_merge($array_update_result[$item_key]['files'][$file_key]['data'][$global_autokey]['guide'], $array);
}
