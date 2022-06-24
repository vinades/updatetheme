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

if (preg_match("/[\r\n\s\t]*\\\$xtpl\-\>assign[\s]*\([\s]*(\"|')LANGSTAR(\"|')[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'findMessage' => 'Tìm và xóa',
        'find' => '        $xtpl->assign(\'LANGSTAR\', $news_contents[\'langstar\']);',
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*(\"|')NUMBERRATING(\"|')[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '
        foreach ($news_contents[\'stars\'] as $star) {
            $xtpl->assign(\'STAR\', $star);
            $xtpl->parse(\'main.allowed_rating.star\');
        }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '        $xtpl->assign(\'NUMBERRATING\', $news_contents[\'numberrating\']);',
        'replace' => '
        foreach ($news_contents[\'stars\'] as $star) {
            $xtpl->assign(\'STAR\', $star);
            $xtpl->parse(\'main.allowed_rating.star\');
        }'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/if[\s]*\([\s]*\\\$file[\s]*\[[\s]*(\"|')ext(\"|')[\s]*\][\s]*\=\=[\s]*(\"|')pdf(\"|')[\s]*\)[\s]*\{(.*?)content_quick_viewdoc[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '// Hỗ trợ xem trực tuyến PDF và ảnh, các định dạng khác tải về để xem
            if (!empty($file[\'urlfile\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewfile\');
                $xtpl->parse(\'main.files.loop.content_quick_viewfile\');
            } elseif (preg_match(\'/^png|jpe|jpeg|jpg|gif|bmp|ico|tiff|tif|svg|svgz$/\', $file[\'ext\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewimg\');
            }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '            if ($file[\'ext\'] == \'pdf\') {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewpdf\');
            } elseif (preg_match(\'/^png|jpe|jpeg|jpg|gif|bmp|ico|tiff|tif|svg|svgz$/\', $file[\'ext\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewimg\');
            } else {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewdoc\');
            }',
        'replace' => '            // Hỗ trợ xem trực tuyến PDF và ảnh, các định dạng khác tải về để xem
            if (!empty($file[\'urlfile\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewfile\');
                $xtpl->parse(\'main.files.loop.content_quick_viewfile\');
            } elseif (preg_match(\'/^png|jpe|jpeg|jpg|gif|bmp|ico|tiff|tif|svg|svgz$/\', $file[\'ext\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewimg\');
            }'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/if[\s]*\([\s]*\\\$module_config[\s]*\[[\s]*\\\$module_name[\s]*\][\s]*\[[\s]*(\"|')socialbutton(\"|')[\s]*\][\s]*\)(.*?)main\.socialbutton[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = 'if (!empty($module_config[$module_name][\'socialbutton\'])) {
        global $meta_property;

        if (str_contains($module_config[$module_name][\'socialbutton\'], \'facebook\')) {
            if (!empty($module_config[$module_name][\'facebookappid\'])) {
                $meta_property[\'fb:app_id\'] = $module_config[$module_name][\'facebookappid\'];
                $meta_property[\'og:locale\'] = (NV_LANG_DATA == \'vi\') ? \'vi_VN\' : \'en_US\';
            }
            $xtpl->parse(\'main.socialbutton.facebook\');
        }
        if (str_contains($module_config[$module_name][\'socialbutton\'], \'twitter\')) {
            $xtpl->parse(\'main.socialbutton.twitter\');
        }
        if (str_contains($module_config[$module_name][\'socialbutton\'], \'zalo\') and !empty($global_config[\'zaloOfficialAccountID\'])) {
            $xtpl->assign(\'ZALO_OAID\', $global_config[\'zaloOfficialAccountID\']);
            $xtpl->parse(\'main.socialbutton.zalo\');
        }

        $xtpl->parse(\'main.socialbutton\');
    }';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '    if ($module_config[$module_name][\'socialbutton\']) {
        global $meta_property;

        if (! empty($module_config[$module_name][\'facebookappid\'])) {
            $meta_property[\'fb:app_id\'] = $module_config[$module_name][\'facebookappid\'];
            $meta_property[\'og:locale\'] = (NV_LANG_DATA == \'vi\') ? \'vi_VN\' : \'en_US\';
        }
        $xtpl->parse(\'main.socialbutton\');
    }',
        'replace' => '    if (!empty($module_config[$module_name][\'socialbutton\'])) {
        global $meta_property;

        if (str_contains($module_config[$module_name][\'socialbutton\'], \'facebook\')) {
            if (!empty($module_config[$module_name][\'facebookappid\'])) {
                $meta_property[\'fb:app_id\'] = $module_config[$module_name][\'facebookappid\'];
                $meta_property[\'og:locale\'] = (NV_LANG_DATA == \'vi\') ? \'vi_VN\' : \'en_US\';
            }
            $xtpl->parse(\'main.socialbutton.facebook\');
        }
        if (str_contains($module_config[$module_name][\'socialbutton\'], \'twitter\')) {
            $xtpl->parse(\'main.socialbutton.twitter\');
        }
        if (str_contains($module_config[$module_name][\'socialbutton\'], \'zalo\') and !empty($global_config[\'zaloOfficialAccountID\'])) {
            $xtpl->assign(\'ZALO_OAID\', $global_config[\'zaloOfficialAccountID\']);
            $xtpl->parse(\'main.socialbutton.zalo\');
        }

        $xtpl->parse(\'main.socialbutton\');
    }'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

$output_data = rtrim($output_data) . "\n\n" . '/**
 * author_theme()
 *
 * @param array  $author_info
 * @param array  $topic_array
 * @param array  $topic_other_array
 * @param string $generate_page
 * @return string
 */
function author_theme($author_info, $topic_array, $topic_other_array, $generate_page)
{
    global $lang_module, $module_info, $module_name, $module_config, $topicid;

    $xtpl = new XTemplate(\'topic.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'TOPPIC_TITLE\', $author_info[\'pseudonym\']);
    $xtpl->assign(\'IMGWIDTH1\', $module_config[$module_name][\'homewidth\']);
    if (!empty($author_info[\'description\'])) {
        $xtpl->assign(\'TOPPIC_DESCRIPTION\', $author_info[\'description\']);
        if (!empty($author_info[\'image\'])) {
            $xtpl->assign(\'HOMEIMG1\', $author_info[\'image\']);
            $xtpl->parse(\'main.topicdescription.image\');
        }
        $xtpl->parse(\'main.topicdescription\');
    }
    if (!empty($topic_array)) {
        foreach ($topic_array as $topic_array_i) {
            if (!empty($topic_array_i[\'external_link\'])) {
                $topic_array_i[\'target_blank\'] = \'target="_blank"\';
            }

            $xtpl->assign(\'TOPIC\', $topic_array_i);
            $xtpl->assign(\'TIME\', date(\'H:i\', $topic_array_i[\'publtime\']));
            $xtpl->assign(\'DATE\', date(\'d/m/Y\', $topic_array_i[\'publtime\']));

            if (!empty($topic_array_i[\'src\'])) {
                $xtpl->parse(\'main.topic.homethumb\');
            }

            if ($topicid and defined(\'NV_IS_MODADMIN\')) {
                $xtpl->assign(\'ADMINLINK\', nv_link_edit_page($topic_array_i[\'id\']) . \' \' . nv_link_delete_page($topic_array_i[\'id\']));
                $xtpl->parse(\'main.topic.adminlink\');
            }

            $xtpl->parse(\'main.topic\');
        }
    }

    if (!empty($topic_other_array)) {
        foreach ($topic_other_array as $topic_other_array_i) {
            $topic_other_array_i[\'publtime\'] = nv_date(\'H:i d/m/Y\', $topic_other_array_i[\'publtime\']);

            if ($topic_other_array_i[\'external_link\']) {
                $topic_other_array_i[\'target_blank\'] = \'target="_blank"\';
            }

            $xtpl->assign(\'TOPIC_OTHER\', $topic_other_array_i);
            $xtpl->parse(\'main.other.loop\');
        }

        $xtpl->parse(\'main.other\');
    }

    if (!empty($generate_page)) {
        $xtpl->assign(\'GENERATE_PAGE\', $generate_page);
        $xtpl->parse(\'main.generate_page\');
    }

    $xtpl->parse(\'main\');

    return $xtpl->text(\'main\');
}
';

nvUpdateSetItemData('news', array(
    'status' => 1,
    'find' => 'Dòng trống cuối cùng của file',
    'replace' => '/**
 * author_theme()
 *
 * @param array  $author_info
 * @param array  $topic_array
 * @param array  $topic_other_array
 * @param string $generate_page
 * @return string
 */
function author_theme($author_info, $topic_array, $topic_other_array, $generate_page)
{
    global $lang_module, $module_info, $module_name, $module_config, $topicid;

    $xtpl = new XTemplate(\'topic.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'TOPPIC_TITLE\', $author_info[\'pseudonym\']);
    $xtpl->assign(\'IMGWIDTH1\', $module_config[$module_name][\'homewidth\']);
    if (!empty($author_info[\'description\'])) {
        $xtpl->assign(\'TOPPIC_DESCRIPTION\', $author_info[\'description\']);
        if (!empty($author_info[\'image\'])) {
            $xtpl->assign(\'HOMEIMG1\', $author_info[\'image\']);
            $xtpl->parse(\'main.topicdescription.image\');
        }
        $xtpl->parse(\'main.topicdescription\');
    }
    if (!empty($topic_array)) {
        foreach ($topic_array as $topic_array_i) {
            if (!empty($topic_array_i[\'external_link\'])) {
                $topic_array_i[\'target_blank\'] = \'target="_blank"\';
            }

            $xtpl->assign(\'TOPIC\', $topic_array_i);
            $xtpl->assign(\'TIME\', date(\'H:i\', $topic_array_i[\'publtime\']));
            $xtpl->assign(\'DATE\', date(\'d/m/Y\', $topic_array_i[\'publtime\']));

            if (!empty($topic_array_i[\'src\'])) {
                $xtpl->parse(\'main.topic.homethumb\');
            }

            if ($topicid and defined(\'NV_IS_MODADMIN\')) {
                $xtpl->assign(\'ADMINLINK\', nv_link_edit_page($topic_array_i[\'id\']) . \' \' . nv_link_delete_page($topic_array_i[\'id\']));
                $xtpl->parse(\'main.topic.adminlink\');
            }

            $xtpl->parse(\'main.topic\');
        }
    }

    if (!empty($topic_other_array)) {
        foreach ($topic_other_array as $topic_other_array_i) {
            $topic_other_array_i[\'publtime\'] = nv_date(\'H:i d/m/Y\', $topic_other_array_i[\'publtime\']);

            if ($topic_other_array_i[\'external_link\']) {
                $topic_other_array_i[\'target_blank\'] = \'target="_blank"\';
            }

            $xtpl->assign(\'TOPIC_OTHER\', $topic_other_array_i);
            $xtpl->parse(\'main.other.loop\');
        }

        $xtpl->parse(\'main.other\');
    }

    if (!empty($generate_page)) {
        $xtpl->assign(\'GENERATE_PAGE\', $generate_page);
        $xtpl->parse(\'main.generate_page\');
    }

    $xtpl->parse(\'main\');

    return $xtpl->text(\'main\');
}
'
));

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/(?:(\/\*\*[\r\n\s\t]*\*[\s]*sendmail_themme(.*)\*\/)*)[\r\n\s\t]*function[\s]+sendmail_themme[\s]*\((.*?)return[\s]*\\\$xtpl\-\>text[\s]*\([\s]*(\"|')main(\"|')[^\}]+\}/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '/**
 * sendmail_themme()
 *
 * @param mixed $sendmail
 * @return string
 */
function sendmail_themme($sendmail)
{
    global $module_info, $global_config, $lang_module, $lang_global, $module_config, $module_name, $module_captcha;

    $xtpl = new XTemplate(\'sendmail.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'SENDMAIL\', $sendmail);
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'GLANG\', $lang_global);
    $xtpl->assign(\'NV_BASE_SITEURL\', NV_BASE_SITEURL);

    if (defined(\'NV_IS_USER\')) {
        $xtpl->parse(\'main.sender_is_user\');
    }

    // Nếu dùng reCaptcha v3
    if ($module_captcha == \'recaptcha\' and $global_config[\'recaptcha_ver\'] == 3) {
        $xtpl->parse(\'main.recaptcha3\');
    }
    // Nếu dùng reCaptcha v2
    elseif ($module_captcha == \'recaptcha\' and $global_config[\'recaptcha_ver\'] == 2) {
        $xtpl->assign(\'RECAPTCHA_ELEMENT\', \'recaptcha\' . nv_genpass(8));
        $xtpl->assign(\'N_CAPTCHA\', $lang_global[\'securitycode1\']);
        $xtpl->parse(\'main.recaptcha\');
    } elseif ($module_captcha == \'captcha\') {
        $xtpl->assign(\'GFX_NUM\', NV_GFX_NUM);
        $xtpl->assign(\'CAPTCHA_REFRESH\', $lang_global[\'captcharefresh\']);
        $xtpl->assign(\'CAPTCHA_REFR_SRC\', NV_STATIC_URL . NV_ASSETS_DIR . \'/images/refresh.png\');
        $xtpl->assign(\'N_CAPTCHA\', $lang_global[\'securitycode\']);
        $xtpl->assign(\'GFX_WIDTH\', NV_GFX_WIDTH);
        $xtpl->assign(\'GFX_HEIGHT\', NV_GFX_HEIGHT);
        $xtpl->parse(\'main.captcha\');
    }
    $xtpl->parse(\'main\');

    return $xtpl->text(\'main\');
}';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => 'Hàm sendmail_themme',
        'replace' => '/**
 * sendmail_themme()
 *
 * @param mixed $sendmail
 * @return string
 */
function sendmail_themme($sendmail)
{
    global $module_info, $global_config, $lang_module, $lang_global, $module_config, $module_name, $module_captcha;

    $xtpl = new XTemplate(\'sendmail.tpl\', NV_ROOTDIR . \'/themes/\' . $module_info[\'template\'] . \'/modules/\' . $module_info[\'module_theme\']);
    $xtpl->assign(\'SENDMAIL\', $sendmail);
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'GLANG\', $lang_global);
    $xtpl->assign(\'NV_BASE_SITEURL\', NV_BASE_SITEURL);

    if (defined(\'NV_IS_USER\')) {
        $xtpl->parse(\'main.sender_is_user\');
    }

    // Nếu dùng reCaptcha v3
    if ($module_captcha == \'recaptcha\' and $global_config[\'recaptcha_ver\'] == 3) {
        $xtpl->parse(\'main.recaptcha3\');
    }
    // Nếu dùng reCaptcha v2
    elseif ($module_captcha == \'recaptcha\' and $global_config[\'recaptcha_ver\'] == 2) {
        $xtpl->assign(\'RECAPTCHA_ELEMENT\', \'recaptcha\' . nv_genpass(8));
        $xtpl->assign(\'N_CAPTCHA\', $lang_global[\'securitycode1\']);
        $xtpl->parse(\'main.recaptcha\');
    } elseif ($module_captcha == \'captcha\') {
        $xtpl->assign(\'GFX_NUM\', NV_GFX_NUM);
        $xtpl->assign(\'CAPTCHA_REFRESH\', $lang_global[\'captcharefresh\']);
        $xtpl->assign(\'CAPTCHA_REFR_SRC\', NV_STATIC_URL . NV_ASSETS_DIR . \'/images/refresh.png\');
        $xtpl->assign(\'N_CAPTCHA\', $lang_global[\'securitycode\']);
        $xtpl->assign(\'GFX_WIDTH\', NV_GFX_WIDTH);
        $xtpl->assign(\'GFX_HEIGHT\', NV_GFX_HEIGHT);
        $xtpl->parse(\'main.captcha\');
    }
    $xtpl->parse(\'main\');

    return $xtpl->text(\'main\');
}'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*(\"|')LINK(\"|')[\s]*\,[\s]*\\\$global_array_cat[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '$authors = [];
            if (isset($internal_authors[$value[\'id\']]) and !empty($internal_authors[$value[\'id\']])) {
                foreach ($internal_authors[$value[\'id\']] as $internal_author) {
                    $authors[] = \'<a href="\' . $internal_author[\'href\'] . \'">\' . BoldKeywordInStr($internal_author[\'pseudonym\'], $key) . \'</a>\';
                }
            }
            if (!empty($value[\'author\'])) {
                $authors[] = BoldKeywordInStr($value[\'author\'], $key);
            }
            $authors = !empty($authors) ? implode(\', \', $authors) : \'\';

            $xtpl->assign(\'LINK\', $global_array_cat[$catid_i][\'link\'] . \'/\' . $value[\'alias\'] . \'-\' . $value[\'id\'] . $global_config[\'rewrite_exturl\']);';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'findMessage' => 'Bên trong hàm search_result_theme tìm đoạn dạng như',
        'find' => '$catid_i = $value[\'catid\'];',
        'addafter' => '            $authors = [];
            if (isset($internal_authors[$value[\'id\']]) and !empty($internal_authors[$value[\'id\']])) {
                foreach ($internal_authors[$value[\'id\']] as $internal_author) {
                    $authors[] = \'<a href="\' . $internal_author[\'href\'] . \'">\' . BoldKeywordInStr($internal_author[\'pseudonym\'], $key) . \'</a>\';
                }
            }
            if (!empty($value[\'author\'])) {
                $authors[] = BoldKeywordInStr($value[\'author\'], $key);
            }
            $authors = !empty($authors) ? implode(\', \', $authors) : \'\';'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*(\"|')AUTHOR[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '$xtpl->assign(\'AUTHOR\', $authors);';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '$xtpl->assign(\'AUTHOR\', BoldKeywordInStr($value[\'author\'], $key));',
        'replace' => '$xtpl->assign(\'AUTHOR\', $authors);'
    ));
}

nv_get_update_result('news');
nvUpdateContructItem('news', 'php');

if (preg_match("/\\\$xtpl\-\>assign[\s]*\([\s]*(\"|')PDF_JS_DIR[^\;]+\;/is", $output_data, $m)) {
    $find = $m[0];
    $replace = '$xtpl->assign(\'PDF_JS_DIR\', NV_STATIC_URL . NV_ASSETS_DIR . \'/js/pdf.js/\');';
    $output_data = str_replace($find, $replace, $output_data);

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => $find,
        'replace' => $replace
    ));
} else {
    nvUpdateSetItemGuide('news', array(
        'find' => '$xtpl->assign(\'PDF_JS_DIR\', NV_BASE_SITEURL . NV_ASSETS_DIR . \'/js/pdf.js/\');',
        'replace' => '$xtpl->assign(\'PDF_JS_DIR\', NV_STATIC_URL . NV_ASSETS_DIR . \'/js/pdf.js/\');'
    ));
}
