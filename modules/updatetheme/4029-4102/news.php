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

if (!function_exists('addLinkTargetForNewFeature')) {
    /**
     * addLinkTargetForNewFeature()
     * 
     * @param mixed $output_data
     * @param mixed $mod
     * @return
     */
    function addLinkTargetForNewFeature($output_data, $mod)
    {
        preg_match_all("/<a([^\>]+)href[\s]*\=[\s]*\"[\s]*\{([^\.]+)\.([^\}]+)\}\"([^\>]*)\>/i", $output_data, $m);
        
        if (!empty($m[1])) {
            foreach ($m[1] as $k => $v) {
                nv_get_update_result($mod);
                nvUpdateContructItem('news', 'html');
                
                $find = $m[0][$k];
                $replace = '<a' . $m[1][$k] . 'href="{' . $m[2][$k] . '.' . $m[3][$k] . '}" {' . $m[2][$k] . '.target_blank}' . $m[4][$k] . '>';
                $output_data = str_replace($find, $replace, $output_data);
                nvUpdateSetItemData($mod, array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
            }
        }
        
        return $output_data;
    }
}

if (preg_match('/news\/block\_groups\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<a([^\>]*)title\=(\"|')\{ROW\.title\}(\"|')([^\>]*)\>\<img/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '<a href="{ROW.link}" title="{ROW.title}" {ROW.target_blank} ><img';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '		<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.thumb}" alt="{ROW.title}" width="{ROW.blockwidth}" class="img-thumbnail pull-left"/></a>',
            'replace' => '		<a href="{ROW.link}" title="{ROW.title}" {ROW.target_blank} ><img src="{ROW.thumb}" alt="{ROW.title}" width="{ROW.blockwidth}" class="img-thumbnail pull-left"/></a>'
        ));
    }
    
    nvUpdateContructItem('news', 'html');
    
    if (preg_match("/\<a([^\>]+)data\-content[\s]*\=[\s]*(\"|')\{ROW\.hometext\}(\"|')([^\>]+)\>(\{ROW\.title\})\<\/a\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = '<a' . $m[1] . '{ROW.target_blank} data-content=' . $m[2] . '{ROW.hometext_clean}' . $m[3] . $m[4] . '>{ROW.title_clean}</a>';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '		<a {TITLE} class="show" href="{ROW.link}" data-content="{ROW.hometext}" data-img="{ROW.thumb}" data-rel="block_tooltip">{ROW.title}</a>',
            'replace' => '		<a {TITLE} class="show" href="{ROW.link}" {ROW.target_blank} data-content="{ROW.hometext_clean}" data-img="{ROW.thumb}" data-rel="block_tooltip">{ROW.title_clean}</a>'
        ));
    }
} elseif (preg_match('/news\/block\_headline\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('href="{HOTSNEWS.link}"', 'href="{HOTSNEWS.link}" {HOTSNEWS.target_blank}', $output_data);
    
    $find = '<a title="{HOTSNEWS.title}" href="{HOTSNEWS.link}"><img class="img-responsive" id="slImg{HOTSNEWS.imgID}" src="{PIX_IMG}" alt="{HOTSNEWS.image_alt}" /></a><h3><a title="{HOTSNEWS.title}" href="{HOTSNEWS.link}">{HOTSNEWS.title}</a></h3>';
    $replace = '<a title="{HOTSNEWS.title}" href="{HOTSNEWS.link}" {HOTSNEWS.target_blank}><img class="img-responsive" id="slImg{HOTSNEWS.imgID}" src="{PIX_IMG}" alt="{HOTSNEWS.image_alt}" /></a><h3><a title="{HOTSNEWS.title}" href="{HOTSNEWS.link}" {HOTSNEWS.target_blank}>{HOTSNEWS.title}</a></h3>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('href="{LASTEST.link}"', 'href="{LASTEST.link}" {LASTEST.target_blank}', $output_data);
    
    $find = '<a {TITLE} class="show" href="{LASTEST.link}" data-content="{LASTEST.hometext}" data-img="{LASTEST.homeimgfile}" data-rel="block_headline_tooltip">{LASTEST.title}</a>';
    $replace = '<a {TITLE} class="show" href="{LASTEST.link}" {LASTEST.target_blank} data-content="{LASTEST.hometext_clean}" data-img="{LASTEST.homeimgfile}" data-rel="block_headline_tooltip">{LASTEST.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/block\_news\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);

    $find = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';
    $replace = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext_clean}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/block\_newscenter\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{othernews.hometext}', '{othernews.hometext_clean}', $output_data);

    $find = '<a class="show black h4" href="{othernews.link}" <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{othernews.hometext}" data-img="{othernews.imgsource}" data-rel="tooltip"<!-- END: tooltip --> title="{othernews.title}" ><img src="{othernews.imgsource}" alt="{othernews.title}" class="img-thumbnail pull-right margin-left-sm" style="width:65px;"/>{othernews.titleclean60}</a>';
    $replace = '<a class="show black h4" href="{othernews.link}" <!-- BEGIN: tooltip -->data-placement="{TOOLTIP_POSITION}" data-content="{othernews.hometext_clean}" data-img="{othernews.imgsource}" data-rel="tooltip"<!-- END: tooltip --> title="{othernews.title}" ><img src="{othernews.imgsource}" alt="{othernews.title}" class="img-thumbnail pull-right margin-left-sm" style="width:65px;"/>{othernews.titleclean60}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/block\_tophits\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('{blocknews.hometext}', '{blocknews.hometext_clean}', $output_data);

    $find = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';
    $replace = '<a {TITLE} class="show" href="{blocknews.link}" data-content="{blocknews.hometext_clean}" data-img="{blocknews.imgurl}" data-rel="block_news_tooltip">{blocknews.title}</a>';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/content\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');
    
    if (preg_match("/\<input([^\>]+)name[\s]*\=[\s]*(\"|')keywords(\"|')([^\n]+)[\s\n\t\r]*\<\/div\>[\s\n\t\r]*\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n\n" . '    <!-- BEGIN: captcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '<input maxlength="255" value="{DATA.keywords}" name="keywords" type="text" class="form-control" />
		</div>
	</div>
',
            'addafter' => '<input maxlength="255" value="{DATA.keywords}" name="keywords" type="text" class="form-control" />
		</div>
	</div>

    <!-- BEGIN: captcha -->'
        ));
    }
    
    nvUpdateContructItem('news', 'html');
    
    if (preg_match("/\<img([^\>]+)onclick[\s]*\=[\s]*(\"|')change_captcha([^\n]+)[\s\n\t\r]*\<\/div\>[\s\n\t\r]*\<\/div\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    <!-- END: captcha -->
    
    <!-- BEGIN: recaptcha -->
    <div class="form-group">
        <label class="col-sm-4 control-label">{N_CAPTCHA} <span class="txtrequired">(*)</span></label>
        <div class="col-sm-20">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
            })
            </script>
        </div>
    </div>
    <!-- END: recaptcha -->
    ';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '<img alt="{CAPTCHA_REFRESH}" src="{CAPTCHA_REFR_SRC}" width="16" height="16" class="refresh" onclick="change_captcha(\'#fcode_iavim\');" />
		</div>
	</div>',
            'addafter' => '    <!-- END: captcha -->
    
    <!-- BEGIN: recaptcha -->
    <div class="form-group">
        <label class="col-sm-4 control-label">{N_CAPTCHA} <span class="txtrequired">(*)</span></label>
        <div class="col-sm-20">
            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
            <script type="text/javascript">
            nv_recaptcha_elements.push({
                id: "{RECAPTCHA_ELEMENT}",
                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
            })
            </script>
        </div>
    </div>
    <!-- END: recaptcha -->
    '
        ));
    }
} elseif (preg_match('/news\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{TOPIC.hometext}"', 'data-content="{TOPIC.hometext_clean}"', $output_data);

    $find = 'data-content="{TOPIC.hometext}"';
    $replace = 'data-content="{TOPIC.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{RELATED_NEW.hometext}"', 'data-content="{RELATED_NEW.hometext_clean}"', $output_data);

    $find = 'data-content="{RELATED_NEW.hometext}"';
    $replace = 'data-content="{RELATED_NEW.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{RELATED.hometext}"', 'data-content="{RELATED.hometext_clean}"', $output_data);

    $find = 'data-content="{RELATED.hometext}"';
    $replace = 'data-content="{RELATED.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/search\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');
    
    if (preg_match("/href[\s]*\=[\s]*(\"|')\{LINK\}(\"|')/", $output_data, $m)) {
        $find = $m[0];
        $replace = 'href="{LINK}" title="{TITLEROW}" {TARGET_BLANK}';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '<h3><a href="{LINK}">{TITLEROW}</a></h3>',
            'replace' => '<h3><a href="{LINK}" title="{TITLEROW}" {TARGET_BLANK}>{TITLEROW}</a></h3>'
        ));
    }
} elseif (preg_match('/news\/sendmail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');
    
    if (preg_match("/\<\!\-\-[\s]*END\:[\s]*captcha[\s]*\-\-\>/", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '                    
                    <!-- BEGIN: recaptcha -->
                    <div class="form-group">
                        <label for="semail" class="col-sm-4 control-label">{N_CAPTCHA}<em>*</em></label>
                        <div class="col-sm-20">
                            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                            <script type="text/javascript">
                            nv_recaptcha_elements.push({
                                id: "{RECAPTCHA_ELEMENT}",
                                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                            })
                            </script>
                        </div>
                    </div>
                    <!-- END: recaptcha -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'find' => $find,
            'replace' => $replace,
            'status' => 1
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '					<!-- END: captcha -->',
            'addafter' => '                    
                    <!-- BEGIN: recaptcha -->
                    <div class="form-group">
                        <label for="semail" class="col-sm-4 control-label">{N_CAPTCHA}<em>*</em></label>
                        <div class="col-sm-20">
                            <div class="nv-recaptcha-default"><div id="{RECAPTCHA_ELEMENT}"></div></div>
                            <script type="text/javascript">
                            nv_recaptcha_elements.push({
                                id: "{RECAPTCHA_ELEMENT}",
                                btn: $(\'[type="submit"]\', $(\'#{RECAPTCHA_ELEMENT}\').parent().parent().parent().parent())
                            })
                            </script>
                        </div>
                    </div>
                    <!-- END: recaptcha -->'
        ));
    }
} elseif (preg_match('/news\/topic\.tpl$/', $file)) {
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_grid\.tpl$/', $file)) {
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_list\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);

    $find = 'data-content="{CONTENT.hometext}"';
    $replace = 'data-content="{CONTENT.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_main\_bottom\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_main\_left\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_main\_right\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{OTHER.hometext}"', 'data-content="{OTHER.hometext_clean}"', $output_data);

    $find = 'data-content="{OTHER.hometext}"';
    $replace = 'data-content="{OTHER.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/news\/viewcat\_two\_column\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    $output_data_compare = $output_data;
    $output_data = str_replace('data-content="{CONTENT.hometext}"', 'data-content="{CONTENT.hometext_clean}"', $output_data);

    $find = 'data-content="{CONTENT.hometext}"';
    $replace = 'data-content="{CONTENT.hometext_clean}"';

    if ($output_data != $output_data_compare) {
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => $find,
            'replace' => $replace
        ));
    }
    
    $output_data = addLinkTargetForNewFeature($output_data, 'news');
} elseif (preg_match('/modules\/news\/theme\.php$/', $file)) {
            nv_get_update_result('news');
            
            if (preg_match_all("/\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\\s*]\s*\=\s*nv\_clean60\(\s*\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\s*\]/", $output_data, $m)) {
                foreach ($m[1] as $k => $v) {
                    $find = $m[0][$k];
                    $replace = '$' . $m[1][$k] . '[\'hometext_clean\'] = nv_clean60(strip_tags($' . $m[2][$k] . '[\'hometext\'])';
                    $output_data = str_replace($find, $replace, $output_data);
                    nvUpdateContructItem('news', 'php');
                    nvUpdateSetItemData('news', array(
                        'status' => 1,
                        'find' => $find,
                        'replace' => $replace
                    ));
                }
            } else {
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'findMessage' => 'T?m các đo?n có d?ng (kho?ng 2)',
                    'find' => '$array_row_i[\'hometext\'] = nv_clean60($array_row_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$array_row_i[\'hometext_clean\'] = nv_clean60(strip_tags($array_row_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$array_content_i[\'hometext\'] = nv_clean60($array_content_i[\'hometext\'], 200);',
                    'replace' => '$array_content_i[\'hometext\'] = nv_clean60(strip_tags($array_content_i[\'hometext\']), 200);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$related_new_array_i[\'hometext\'] = nv_clean60($related_new_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$related_new_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($related_new_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$related_array_i[\'hometext\'] = nv_clean60($related_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$related_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($related_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
                nvUpdateContructItem('news', 'php');
                nvUpdateSetItemGuide('news', array(
                    'find' => '$topic_array_i[\'hometext\'] = nv_clean60($topic_array_i[\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'replace' => '$topic_array_i[\'hometext_clean\'] = nv_clean60(strip_tags($topic_array_i[\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);'
                ));
            }
            
            nvUpdateContructItem('news', 'php');
            
            if (preg_match("/if\s*\(\\\$module\_config\s*\[\s*\\\$module\_name\s*\]\s*\[\s*\'showtooltip'\s*\]\s*\)\s*\{[\s\n\t\r]*\\\$xtpl\-\>assign\s*\(\s*\'TOOLTIP\_POSIT([^\}]+)main\.loopcat\.other\.tooltip\'\s*\)\s*\;[\s\n\t\r]*\}/isU", $output_data, $m)) {
                $find = $m[0];
                $replace = '

                    $array_catpage_i[\'content\'][$index][\'hometext_clean\'] = nv_clean60(strip_tags($array_catpage_i[\'content\'][$index][\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);
                    $xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);
                    
                    if ($module_config[$module_name][\'showtooltip\']) {
                        $xtpl->assign(\'TOOLTIP_POSITION\', $module_config[$module_name][\'tooltip_position\']);
                        $xtpl->parse(\'main.loopcat.other.tooltip\');
                    }                
                ';
                nvUpdateSetItemData('news', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('news', array(
                    'find' => '
if ($module_config[$module_name][\'showtooltip\']) {
    $xtpl->assign(\'TOOLTIP_POSITION\', $module_config[$module_name][\'tooltip_position\']);
    $array_catpage_i[\'content\'][$index][\'hometext\'] = nv_clean60($array_catpage_i[\'content\'][$index][\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);
    $xtpl->parse(\'main.loopcat.other.tooltip\');
}
                    ',
                    'delinline' => '$array_catpage_i[\'content\'][$index][\'hometext\'] = nv_clean60($array_catpage_i[\'content\'][$index][\'hometext\'], $module_config[$module_name][\'tooltip_length\'], true);',
                    'addafter' => '$xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);',
                    'addbefore' => '
$array_catpage_i[\'content\'][$index][\'hometext_clean\'] = nv_clean60(strip_tags($array_catpage_i[\'content\'][$index][\'hometext\']), $module_config[$module_name][\'tooltip_length\'], true);
$xtpl->assign(\'CONTENT\', $array_catpage_i[\'content\'][$index]);
                    '
                ));
            }
            
            nvUpdateContructItem('news', 'php');
            
            if (preg_match("/BoldKeywordInStr\s*\(\s*\\$([a-zA-Z0-9\_]+)\s*\[\s*\'hometext\'\s*\]\s*\,\s*\\$([a-zA-Z0-9\_]+)\s*\)/", $output_data, $m)) {
                $find = $m[0];
                $replace = 'BoldKeywordInStr(strip_tags($' . $m[1] . '[\'hometext\']), $' . $m[2] . ')';
                nvUpdateSetItemData('news', array(
                    'status' => 1,
                    'find' => $find,
                    'replace' => $replace
                ));
                $output_data = str_replace($find, $replace, $output_data);
            } else {
                nvUpdateSetItemGuide('news', array(
                    'find' => '$xtpl->assign(\'CONTENT\', BoldKeywordInStr($value[\'hometext\'], $key) . "...");',
                    'replace' => '$xtpl->assign(\'CONTENT\', BoldKeywordInStr(strip_tags($value[\'hometext\']), $key) . "...");'
                ));
            }
        }
