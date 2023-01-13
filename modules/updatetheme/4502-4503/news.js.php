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
 * Cập nhật news.js
 */

nv_get_update_result('news');
nvUpdateContructItem('news', 'js');

if (preg_match("/\\\$(\([\s]*document[\s]*\)[\s]*\.[\s]*ready)*[\s]*\([\s]*function[\s]*\([\s]*\)[\s]*\{/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'window.newsPls = {};
window.newsSeek = 0;

// Trình điều khiển báo nói
function newsPlayVoice(voiceid, voicepath, voicetitle, autoplay) {
    // Destroy các player đang phát
    $.each(window.newsPls, function(k, v) {
        v.destroy();
    });
    window.newsPls = {};
    window.newsPls[voiceid] = new Plyr(\'#newsVoicePlayer\', {
        controls: [\'play-large\', \'play\', \'progress\', \'current-time\', \'mute\', \'volume\', \'airplay\']
    });
    window.newsPls[voiceid].source = {
        type: \'audio\',
        title: voicetitle,
        sources: [{
            src: voicepath
        }],
    };
    window.newsPls[voiceid].isFirstPlay = true;
    window.newsPls[voiceid].isPlaying = false;
    window.newsPls[voiceid].on(\'playing\', function() {
        window.newsPls[voiceid].isPlaying = true;
        if (window.newsPls[voiceid].isFirstPlay) {
            window.newsPls[voiceid].isFirstPlay = false;
            window.newsPls[voiceid].forward(window.newsSeek);
        }
    });
    window.newsPls[voiceid].on(\'pause\', function() {
        window.newsPls[voiceid].isPlaying = false;
    });
    window.newsPls[voiceid].on(\'ended\', function() {
        window.newsPls[voiceid].isPlaying = false;
    });
    window.newsPls[voiceid].on(\'ready\', function() {
        if (autoplay) {
            window.newsPls[voiceid].play();
        }
        window.newsPls[voiceid].on(\'timeupdate\', function() {
            if (window.newsPls[voiceid].isPlaying) {
                window.newsSeek = window.newsPls[voiceid].currentTime;
            }
        });
    });
}

$(document).ready(function() {';
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
            'find' => '$(document).ready(function() {',
            'addbefore' => 'window.newsPls = {};
window.newsSeek = 0;

// Trình điều khiển báo nói
function newsPlayVoice(voiceid, voicepath, voicetitle, autoplay) {
    // Destroy các player đang phát
    $.each(window.newsPls, function(k, v) {
        v.destroy();
    });
    window.newsPls = {};
    window.newsPls[voiceid] = new Plyr(\'#newsVoicePlayer\', {
        controls: [\'play-large\', \'play\', \'progress\', \'current-time\', \'mute\', \'volume\', \'airplay\']
    });
    window.newsPls[voiceid].source = {
        type: \'audio\',
        title: voicetitle,
        sources: [{
            src: voicepath
        }],
    };
    window.newsPls[voiceid].isFirstPlay = true;
    window.newsPls[voiceid].isPlaying = false;
    window.newsPls[voiceid].on(\'playing\', function() {
        window.newsPls[voiceid].isPlaying = true;
        if (window.newsPls[voiceid].isFirstPlay) {
            window.newsPls[voiceid].isFirstPlay = false;
            window.newsPls[voiceid].forward(window.newsSeek);
        }
    });
    window.newsPls[voiceid].on(\'pause\', function() {
        window.newsPls[voiceid].isPlaying = false;
    });
    window.newsPls[voiceid].on(\'ended\', function() {
        window.newsPls[voiceid].isPlaying = false;
    });
    window.newsPls[voiceid].on(\'ready\', function() {
        if (autoplay) {
            window.newsPls[voiceid].play();
        }
        window.newsPls[voiceid].on(\'timeupdate\', function() {
            if (window.newsPls[voiceid].isPlaying) {
                window.newsSeek = window.newsPls[voiceid].currentTime;
            }
        });
    });
}'
        )
    );
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'js');

if (preg_match("/\\\$\([\s]*document[\s]*\)[\s]*\.[\s]*ready[\s]*\([\s]*function[\s]*\([\s]*\)[\s]*\{(.*?)\}[\s]*\)[\s]*\;*[\r\n\s\t]+\}[\s]*\)[\s]*\;*[\r\n\s\t]+$/is", $output_data, $m)) {
    // Trường hợp ở cuối file
    $find = $m[0];
    $replace = '$(document).ready(function() {' . $m[1] . "});\n" . '// Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });    // Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });' . "\n});\n";
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData(
        'news',
        array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        )
    );
} elseif (preg_match("/\\\$\([\s]*document[\s]*\)[\s]*\.[\s]*ready[\s]*\([\s]*function[\s]*\([\s]*\)[\s]*\{(.*?)\}[\s]*\)[\s]*\;*[\r\n\s\t]+\}[\s]*\)[\s]*\;*[\r\n\s\t]+function/is", $output_data, $m)) {
    // Trường hợp sau đó là function
    $find = $m[0];
    $replace = '$(document).ready(function() {' . $m[1] . "});\n\n" . '    // Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });    // Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });' . "\n});\n\nfunction";
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
            'find' => '$(document).ready(function() {',
            'replace' => '    // Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });    // Xử lý player
    var playerCtn = $(\'#newsVoicePlayer\');
    if (playerCtn.length) {
        newsPlayVoice(playerCtn.data(\'voice-id\'), playerCtn.data(\'voice-path\'), playerCtn.data(\'voice-title\'), playerCtn.data(\'autoplay\'));
    }

    // Chọn giọng đọc: Thiết lập làm giọng đọc mặc định lần sau
    $(\'[data-news="voicesel"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                setDefaultVoice: $this.data(\'tokend\'),
                id: $this.data(\'id\')
            }
        }).done(function() {
            $this.data(\'busy\', false);
            $(\'[data-news="voiceval"]\').html($this.text());
            newsPlayVoice($this.data(\'id\'), $this.data(\'path\'), $this.text(), true);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });

    // Bật/Tắt tự phát giọng đọc
    $(\'[data-news="switchapl"]\').on(\'click\', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.data(\'busy\')) {
            return;
        }
        $(this).data(\'busy\', true);
        $.ajax({
            type: \'POST\',
            url: nv_base_siteurl + \'index.php?\' + nv_lang_variable + \'=\' + nv_lang_data + \'&\' + nv_name_variable + \'=\' + nv_module_name + \'&nocache=\' + new Date().getTime(),
            dataType: \'json\',
            data: {
                \'setAutoPlayVoice\': $this.data(\'tokend\')
            }
        }).done(function(res) {
            $this.data(\'busy\', false);
            if (res.value == 1) {
                $this.addClass(\'checked\');
            } else {
                $this.removeClass(\'checked\');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            $this.data(\'busy\', false);
            console.error(jqXHR, textStatus, errorThrown);
        });
    });',
            'replaceMessage' => 'Trong đoạn đó thêm',
        )
    );
}
