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

if (preg_match('/statistics\/main\.tpl$/', $file)) {
    nv_get_update_result('statistics');
    nvUpdateContructItem('statistics', 'html');

    nvUpdateSetItemGuide('statistics', array(
        'find' => 'Cần đối chiếu với giao diện mặc định để sửa. Module này không phổ biến việc thay đổi giao diện do đó chúng tôi không cung cấp công cụ tự động cập nhật',
        'addafter' => ''
    ));
}
