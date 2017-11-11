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

if (preg_match('/css\/news\.css$/', $file)) {
    nv_get_update_result('news');

    if (!preg_match("/\.news\-download\-file[\s]*\{/i", $output_data)) {
        nvUpdateContructItem('news', 'css');
        $replace = '.news-download-file {
    margin-top: -6px;
}

.news-download-file .list-group-item:first-child {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.news-download-file .list-group-item .badge {
    float: right;
    display: inline-block;
    width: 22px;
    height: 22px;
    font-size: 12px;
    font-weight: 700;
    line-height: 22px;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: #5cb85c;
    border-radius: 15px;
}

.news-download-file .list-group-item .badge a {
    color: #fff;
}

h3.newh3 {
    border-bottom-style: solid;
    border-bottom-width: 1px;
    border-bottom-color: #CCCCCC;
    font-size: 20px;
    line-height: 25px;
    padding-bottom: 10px;
    margin-bottom: 5px;
    padding-top: 10px;
    margin-top: 0px;
    color: #02659d;
}

';
        $output_data = trim($output_data) . "\n\n" . $replace;
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => 'Vị trí kết thúc của file',
            'replace' => $replace
        ));
    }
} elseif (preg_match('/js\/news\.js$/', $file)) {
    nv_get_update_result('news');

    if (!preg_match("/\\$\([\s]*('|\")\[data\-toggle\=('|\")newsattachimage('|\")\]('|\")[\s]*\)/i", $output_data)) {
        nvUpdateContructItem('news', 'js');
        $replace = '$(function() {
    $(\'[data-toggle="collapsepdf"]\').each(function() {
        $(\'#\' + $(this).attr(\'id\')).on(\'shown.bs.collapse\', function() {
            $(this).find(\'iframe\').attr(\'src\', $(this).data(\'src\'));
        });
    });
    $(\'[data-toggle="newsattachimage"]\').click(function(e) {
        e.preventDefault();
        modalShow(\'\', \'<div class="text-center"><img src="\' + $(this).data(\'src\') + \'" style="max-width:auto;"/></div>\');
    });
});

';
        $output_data = trim($output_data) . "\n\n" . $replace;
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => 'Vị trí kết thúc của file',
            'replace' => $replace
        ));
    }
} elseif (preg_match('/news\/theme\.php$/', $file)) {
    nv_get_update_result('news');

    if (!preg_match("/nv\_theme\_viewpdf[\s]*\(/i", $output_data)) {
        nvUpdateContructItem('news', 'php');
        $replace = '
/**
 * nv_theme_viewpdf()
 *
 * @param mixed $file_url
 * @return
 */
function nv_theme_viewpdf($file_url)
{
    global $lang_module, $lang_global;
    $xtpl = new XTemplate(\'viewer.tpl\', NV_ROOTDIR . \'/\' . NV_ASSETS_DIR . \'/js/pdf.js\');
    $xtpl->assign(\'LANG\', $lang_module);
    $xtpl->assign(\'GLANG\', $lang_global);
    $xtpl->assign(\'PDF_JS_DIR\', NV_BASE_SITEURL . NV_ASSETS_DIR . \'/js/pdf.js/\');
    $xtpl->assign(\'PDF_URL\', $file_url);
    $xtpl->parse(\'main\');
    return $xtpl->text(\'main\');
}

';
        $output_data = trim($output_data) . "\n\n" . $replace;
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => 'Vị trí kết thúc của file',
            'replace' => $replace
        ));
    }

    nvUpdateContructItem('news', 'php');

    if (preg_match("/if[\s]*\([\s]*\\\$global\_array\_cat[\s]*\[[\s]*\\\$catid\_i[\s]*\][\s]*\[[\s]*'inhome'[\s]*\][\s]*\=\=[\s]*1[\s]*\)[\s\n\t\r]*\{/i", $output_data, $m)) {
        $find = $m[0];
        $replace = 'if ($global_array_cat[$catid_i][\'status\'] == 1) {';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => 'if ($global_array_cat[$catid_i][\'inhome\'] == 1) {',
            'replace' => 'if ($global_array_cat[$catid_i][\'status\'] == 1) {'
        ));
    }

    nvUpdateContructItem('news', 'php');

    if (preg_match("/if[\s]*\([\s]*\![\s]*empty[\s]*\(\\\$news\_contents[\s]*\[[\s]*('|\")post\_name('|\")[\s]*\][\s]*\)[\s]*\)[\s\n\t\r]*\{[\s\n\t\r]*\\\$xtpl\-\>parse[\s]*\([\s]*('|\")main\.post_name('|\")[\s]*\)[\s]*\;[\s\n\t\r]*\}/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    if (!empty($news_contents[\'files\'])) {
        foreach ($news_contents[\'files\'] as $file) {
            $xtpl->assign(\'FILE\', $file);

            if ($file[\'ext\'] == \'pdf\') {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewpdf\');
            } elseif (preg_match(\'/^png|jpe|jpeg|jpg|gif|bmp|ico|tiff|tif|svg|svgz$/\', $file[\'ext\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewimg\');
            } else {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewdoc\');
            }
            $xtpl->parse(\'main.files.loop\');
        }
        $xtpl->parse(\'main.files\');
    }';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '    if (! empty($news_contents[\'post_name\'])) {
        $xtpl->parse(\'main.post_name\');
    }',
            'addafter' => '    if (!empty($news_contents[\'files\'])) {
        foreach ($news_contents[\'files\'] as $file) {
            $xtpl->assign(\'FILE\', $file);

            if ($file[\'ext\'] == \'pdf\') {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewpdf\');
            } elseif (preg_match(\'/^png|jpe|jpeg|jpg|gif|bmp|ico|tiff|tif|svg|svgz$/\', $file[\'ext\'])) {
                $xtpl->parse(\'main.files.loop.show_quick_viewimg\');
            } else {
                $xtpl->parse(\'main.files.loop.show_quick_viewpdf\');
                $xtpl->parse(\'main.files.loop.content_quick_viewdoc\');
            }
            $xtpl->parse(\'main.files.loop\');
        }
        $xtpl->parse(\'main.files\');
    }'
        ));
    }
} elseif (preg_match('/news\/content\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<div[\s]*class[\s]*\=[\s]*('|\")form\-group('|\")[\s]*\>[\s\n\t\r]*\<label([^\>]+)\>[\s]*\{LANG\.alias\}[\s]*\<\/label\>[\s\n\t\r]*\<div([^\>]+)\>(.*?)\<\/div\>[\s\n\t\r]*\<\/div\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: alias -->' . "\n    " . $m[0] . "\n" . '    <!-- END: alias -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '	<div class="form-group">
		<label class="col-sm-4 control-label">{LANG.alias}</label>
		<div class="col-sm-20">
			<input type="text" class="form-control pull-left" name="alias" id="idalias" value="{DATA.alias}" maxlength="255" style="width: 94%;" />
			<em class="fa fa-refresh pull-right" style="cursor: pointer; vertical-align: middle; margin: 9px 0 0 4px" onclick="get_alias(\'{OP}\');" alt="Click">&nbsp;</em>
		</div>
	</div>',
            'addbefore' => '    <!-- BEGIN: alias -->',
            'addafter' => '    <!-- END: alias -->'
        ));
    }

    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<div[\s]*class[\s]*\=[\s]*('|\")form\-group('|\")[\s]*\>[\s\n\t\r]*\<label([^\>]+)\>[\s]*\{LANG\.content\_homeimg\}[\s]*\<\/label\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = "\n" . '    <!-- BEGIN: layout_func -->
    <div class="form-group">
        <label class="col-sm-4 control-label">{LANG.pick_layout}</label>
        <div class="col-sm-20">
            <select name="layout_func" class="form-control">
                <option value="">{LANG.default_layout}</option>
                <!-- BEGIN: loop -->
                <option value="{LAYOUT_FUNC.key}"{LAYOUT_FUNC.selected}>{LAYOUT_FUNC.key}</option>
                <!-- END: loop -->
            </select>
        </div>
    </div>
    <!-- END: layout_func -->' . "\n    " . $m[0];
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '	<div class="form-group">
		<label class="col-sm-4 control-label">{LANG.content_homeimg}</label>',
            'addbefore' => '
    <!-- BEGIN: layout_func -->
	<div class="form-group">
		<label class="col-sm-4 control-label">{LANG.pick_layout}</label>
		<div class="col-sm-20">
			<select name="layout_func" class="form-control">
				<option value="">{LANG.default_layout}</option>
				<!-- BEGIN: loop -->
				<option value="{LAYOUT_FUNC.key}"{LAYOUT_FUNC.selected}>{LAYOUT_FUNC.key}</option>
				<!-- END: loop -->
			</select>
		</div>
	</div>
    <!-- END: layout_func -->'
        ));
    }

    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<div[\s]*class[\s]*\=[\s]*('|\")form\-group('|\")[\s]*\>[\s\n\t\r]*\<label([^\>]+)\>[\s]*\{LANG\.imgposition\}[\s]*\<\/label\>[\s\n\t\r]*\<div([^\>]+)\>[\s\n\t\r]*\<select([^\>]+)name[\s]*\=[\s]*('|\")imgposition('|\")([^\>]+)\>(.*?)\<\/div\>[\s\n\t\r]*\<\/div\>[\s\n\t\r]*/is", $output_data, $m)) {
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
            'find' => '<div class="form-group">
		<label class="col-sm-4 control-label">{LANG.imgposition}</label>
		<div class="col-sm-20">
			<select name="imgposition" class="form-control">
				<!-- BEGIN: imgposition -->
				<option value="{DATAIMGOP.value}"{DATAIMGOP.selected}>{DATAIMGOP.title}</option>
				<!-- END: imgposition -->
			</select>
		</div>
	</div>',
            'findMessage' => 'Tìm và xóa đoạn'
        ));
    }

    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<input([^\>]*)value[\s]*\=[\s]*('|\")\{DATA\.author\}('|\")([^\>]*)\>[\s\n\t\r]*\<\/div\>[\s\n\t\r]*\<\/div\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '    <div class="form-group">
        <label class="col-sm-4 control-label">{LANG.content_keywords}</label>
        <div class="col-sm-20">
            <input maxlength="255" value="{DATA.keywords}" name="keywords" type="text" class="form-control" />
        </div>
    </div>';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '			<input maxlength="255" value="{DATA.author}" name="author" type="text" class="form-control" />
		</div>
	</div>',
            'addafter' => '    <div class="form-group">
		<label class="col-sm-4 control-label">{LANG.content_keywords}</label>
		<div class="col-sm-20">
			<input maxlength="255" value="{DATA.keywords}" name="keywords" type="text" class="form-control" />
		</div>
	</div>'
        ));
    }
} elseif (preg_match('/news\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\{DETAIL\.bodyhtml\}[\s\n\t\r]*\<\/div\>/i", $output_data, $m)) {
        $find = $m[0];
        $replace = $m[0] . "\n" . '        <!-- BEGIN: files -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-download fa-fw"></i><strong>{LANG.files}</strong>
            </div>
            <div class="list-group news-download-file">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <!-- BEGIN: show_quick_viewpdf -->
                    <span class="badge">
                        <a role="button" data-toggle="collapse" href="#pdf{FILE.key}" aria-expanded="false" aria-controls="pdf{FILE.key}">
                            <i class="fa fa-file-pdf-o" data-rel="tooltip" data-content="{LANG.quick_view_pdf}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewpdf -->
                    <!-- BEGIN: show_quick_viewimg -->
                    <span class="badge">
                        <a href="javascript:void(0)" data-src="{FILE.src}" data-toggle="newsattachimage">
                            <i class="fa fa-file-image-o" data-rel="tooltip" data-content="{LANG.quick_view_pdf}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewimg -->
                    <a href="{FILE.url}" title="{FILE.titledown}{FILE.title}">{FILE.titledown}: <strong>{FILE.title}</strong></a>
                    <!-- BEGIN: content_quick_viewpdf -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="pdf{FILE.key}" data-src="{FILE.urlpdf}" data-toggle="collapsepdf">
                        <div class="well margin-top">
                            <iframe frameborder="0" height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewpdf -->
                    <!-- BEGIN: content_quick_viewdoc -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="pdf{FILE.key}" data-src="{FILE.urldoc}" data-toggle="collapsepdf">
                        <div class="well margin-top">
                            <iframe frameborder="0" height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewdoc -->
                </div>
                <!-- END: loop -->
            </div>
        </div>
        <!-- END: files -->';
        $output_data = str_replace($find, $replace, $output_data);
        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '			{DETAIL.bodyhtml}
		</div>',
            'addafter' => '        <!-- BEGIN: files -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-download fa-fw"></i><strong>{LANG.files}</strong>
            </div>
            <div class="list-group news-download-file">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <!-- BEGIN: show_quick_viewpdf -->
                    <span class="badge">
                        <a role="button" data-toggle="collapse" href="#pdf{FILE.key}" aria-expanded="false" aria-controls="pdf{FILE.key}">
                            <i class="fa fa-file-pdf-o" data-rel="tooltip" data-content="{LANG.quick_view_pdf}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewpdf -->
                    <!-- BEGIN: show_quick_viewimg -->
                    <span class="badge">
                        <a href="javascript:void(0)" data-src="{FILE.src}" data-toggle="newsattachimage">
                            <i class="fa fa-file-image-o" data-rel="tooltip" data-content="{LANG.quick_view_pdf}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewimg -->
                    <a href="{FILE.url}" title="{FILE.titledown}{FILE.title}">{FILE.titledown}: <strong>{FILE.title}</strong></a>
                    <!-- BEGIN: content_quick_viewpdf -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="pdf{FILE.key}" data-src="{FILE.urlpdf}" data-toggle="collapsepdf">
                        <div class="well margin-top">
                            <iframe frameborder="0" height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewpdf -->
                    <!-- BEGIN: content_quick_viewdoc -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="pdf{FILE.key}" data-src="{FILE.urldoc}" data-toggle="collapsepdf">
                        <div class="well margin-top">
                            <iframe frameborder="0" height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewdoc -->
                </div>
                <!-- END: loop -->
            </div>
        </div>
        <!-- END: files -->'
        ));
    }
}
