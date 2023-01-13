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
 * Cập nhật theme.php module news
 */

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/if[\s]*\([\s]*\\\$news\_contents[\s]*\[[\s]*\'allowed\_send\'[\s]*\][\s]*\=\=[\s]*1[\s]*\)[\r\n\t\s]*\{/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Xuất giọng đọc
    if (!empty($news_contents[\'current_voice\'])) {
        foreach ($news_contents[\'voicedata\'] as $voice) {
            $xtpl->assign(\'VOICE\', $voice);
            $xtpl->parse(\'main.show_player.loop\');
        }

        $xtpl->parse(\'main.show_player\');
    }

    ' . $find;
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData(
        'news',
        array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        )
    );
} else {
    nvUpdateSetItemGuide(
        'news',
        array(
            'find' => '    if ($news_contents[\'allowed_send\'] == 1) {',
            'affbefore' => '    // Xuất giọng đọc
            if (!empty($news_contents[\'current_voice\'])) {
                foreach ($news_contents[\'voicedata\'] as $voice) {
                    $xtpl->assign(\'VOICE\', $voice);
                    $xtpl->parse(\'main.show_player.loop\');
                }

                $xtpl->parse(\'main.show_player\');
            }'
        )
    );
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/\\\$news_contents[\s]*\[[\s]*\'addtime\'[\s]*\][\s]*\=[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = $find . "\n" . '    $news_contents[\'css_autoplay\'] = $news_contents[\'autoplay\'] ? \' checked\' : \'\';';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData(
        'news',
        array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        )
    );
} else {
    nvUpdateSetItemGuide(
        'news',
        array(
            'find' => '    $news_contents[\'addtime\'] = nv_date(\'d/m/Y h:i:s\', $news_contents[\'addtime\']);',
            'addafter' => '    $news_contents[\'css_autoplay\'] = $news_contents[\'autoplay\'] ? \' checked\' : \'\';',
        )
    );
}
