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
 * Cập nhật tpl module news
 */
if (preg_match('/\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*no\_public[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = $find . "\n" . '        <!-- BEGIN: show_player -->
        <link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/plyr/plyr.css" />
        <script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/plyr/plyr.polyfilled.js"></script>
        <div class="news-detail-player">
            <div class="player">
                <audio id="newsVoicePlayer" data-voice-id="{DETAIL.current_voice.id}" data-voice-path="{DETAIL.current_voice.path}" data-voice-title="{DETAIL.current_voice.title}" data-autoplay="{DETAIL.autoplay}"></audio>
            </div>
            <div class="source">
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-microphone" aria-hidden="true"></i> <span data-news="voiceval" class="val">{DETAIL.current_voice.title}</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <!-- BEGIN: loop -->
                        <li><a href="#" data-news="voicesel" data-id="{VOICE.id}" data-path="{VOICE.path}" data-tokend="{NV_CHECK_SESSION}">{VOICE.title}</a></li>
                        <!-- END: loop -->
                    </ul>
                </div>
            </div>
            <div class="tools">
                <div class="news-switch">
                    <div class="news-switch-label">
                        {LANG.autoplay}:
                    </div>
                    <div data-news="switchapl" class="news-switch-btn{DETAIL.css_autoplay}" role="button" data-busy="false" data-tokend="{NV_CHECK_SESSION}">
                        <span class="news-switch-slider"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: show_player -->';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData(
            'news',
            [
                'status' => 1,
                'find' => $find,
                'replace' => $replace
            ]
        );
    } else {
        nvUpdateSetItemGuide(
            'news',
            array(
                'find' => '        <!-- END: no_public -->',
                'addafter' => '        <!-- BEGIN: show_player -->
                <link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/plyr/plyr.css" />
                <script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/plyr/plyr.polyfilled.js"></script>
                <div class="news-detail-player">
                    <div class="player">
                        <audio id="newsVoicePlayer" data-voice-id="{DETAIL.current_voice.id}" data-voice-path="{DETAIL.current_voice.path}" data-voice-title="{DETAIL.current_voice.title}" data-autoplay="{DETAIL.autoplay}"></audio>
                    </div>
                    <div class="source">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-microphone" aria-hidden="true"></i> <span data-news="voiceval" class="val">{DETAIL.current_voice.title}</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <!-- BEGIN: loop -->
                                <li><a href="#" data-news="voicesel" data-id="{VOICE.id}" data-path="{VOICE.path}" data-tokend="{NV_CHECK_SESSION}">{VOICE.title}</a></li>
                                <!-- END: loop -->
                            </ul>
                        </div>
                    </div>
                    <div class="tools">
                        <div class="news-switch">
                            <div class="news-switch-label">
                                {LANG.autoplay}:
                            </div>
                            <div data-news="switchapl" class="news-switch-btn{DETAIL.css_autoplay}" role="button" data-busy="false" data-tokend="{NV_CHECK_SESSION}">
                                <span class="news-switch-slider"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: show_player -->'
            )
        );
    }
}
