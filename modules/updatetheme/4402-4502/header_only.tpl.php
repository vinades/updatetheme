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
 * Cập nhật header_only.tpl của giao diện mobile
 */

nv_get_update_result('base');
nvUpdateContructItem('base', 'html');

// Thêm cookie_notice
if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*js[\s]*\-\-\>/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '<!-- END: js -->
        <!-- Use passive listeners to improve scrolling performance
        https://web.dev/uses-passive-event-listeners/?utm_source=lighthouse&utm_medium=unknown -->
        <script>jQuery.event.special.touchstart={setup:function(c,a,b){this.addEventListener("touchstart",b,{passive:!a.includes("noPreventDefault")})}};jQuery.event.special.touchmove={setup:function(c,a,b){this.addEventListener("touchmove",b,{passive:!a.includes("noPreventDefault")})}};</script>';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('base', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('base', array(
        'find' => '        <!-- END: js -->',
        'addafter' => '        <!-- Use passive listeners to improve scrolling performance, https://web.dev/uses-passive-event-listeners/?utm_source=lighthouse&utm_medium=unknown -->
        <script>jQuery.event.special.touchstart={setup:function(c,a,b){this.addEventListener("touchstart",b,{passive:!a.includes("noPreventDefault")})}};jQuery.event.special.touchmove={setup:function(c,a,b){this.addEventListener("touchmove",b,{passive:!a.includes("noPreventDefault")})}};</script>'
    ));
}
