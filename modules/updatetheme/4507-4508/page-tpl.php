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
 * Cập nhật tpl module page
 */
if (preg_match('/\/main\.tpl$/', $file)) {
    // Cập nhật khối chia sẻ mạng xã hội
    if (!preg_match('/social\-share\-container/i', $output_data)) {
        nv_get_update_result('page');
        nvUpdateContructItem('page', 'html');

        $new_share_block = '        <div class="margin-bottom-lg">
            <div class="social-share-container">
                <div class="social-share-label"><i class="fa fa-share-alt" aria-hidden="true"></i> {GLANG.share}:</div>
                <div class="social-share-buttons">
                    <!-- BEGIN: facebook --><button type="button" class="social-share-facebook" data-toggle="nv-social-share" data-platform="facebook" data-url="{CONTENT.link}" data-title="{CONTENT.title}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg> Facebook</button><!-- END: facebook -->
                    <!-- BEGIN: twitter --><button type="button" class="social-share-twitter" data-toggle="nv-social-share" data-platform="twitter" data-url="{CONTENT.link}" data-title="{CONTENT.title}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg> Tweet</button><!-- END: twitter -->
                </div>
            </div>
        </div>';

        if (preg_match('/<!--\s*BEGIN:\s*socialbutton\s*-->[\s\S]*?<!--\s*END:\s*socialbutton\s*-->/i', $output_data, $m)) {
            $find = $m[0];
            $replace = '<!-- BEGIN: socialbutton -->' . "\n" . $new_share_block . "\n" . '        <!-- END: socialbutton -->';
            $output_data = str_replace($find, $replace, $output_data);

            nvUpdateSetItemData('page', [
                'status' => 1,
                'find' => $find,
                'replace' => $replace
            ]);
        } else {
            nvUpdateSetItemGuide('page', [
                'findMessage' => 'Tìm khối chia sẻ mạng xã hội',
                'find' => '        <div class="margin-bottom">
            <div style="display:flex;align-items:flex-start;">
                <!-- BEGIN: facebook --><div class="margin-right"><div class="fb-like" style="float:left!important;margin-right:0!important" data-href="{CONTENT.link}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div><!-- END: facebook -->
                <!-- BEGIN: twitter --><div class="margin-right"><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></div><!-- END: twitter -->
                <!-- BEGIN: zalo --><div><div class="zalo-share-button" data-href="" data-oaid="{ZALO_OAID}" data-layout="1" data-color="blue" data-customize=false></div></div><!-- END: zalo -->
            </div>
        </div>',
                'replace' => $new_share_block
            ]);
        }
    }
}
