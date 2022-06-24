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

if (preg_match('/\/content\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    // Thay toàn bộ content.tpl
    $output_data = file_get_contents(NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/content.tpl');

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => 'Toàn bộ nội dung file content.tpl',
        'replace' => 'Nội dung file tương ứng ở phiên bản mới'
    ));
} elseif (preg_match('/\/detail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<a[^\>]+\{URL_SENDMAIL\}[^\>]+\>(.*?)\<\/a\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = $find;
        $replace = preg_replace("/onclick[\s]*\=[\s]*(\"|')(.*)(\"|')/is", 'onclick="newsSendMailModal(\'#newsSendMailModal\', \'{URL_SENDMAIL}\', \'{CHECKSESSION}\');"', $replace);
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '<li><a class="dimgray" rel="nofollow" title="{LANG.sendmail}" href="javascript:void(0);" onclick="nv_open_browse(\'{URL_SENDMAIL}\',\'{TITLE}\',650,500,\'resizable=no,scrollbars=yes,toolbar=no,location=no,status=no\');return false"><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>',
            'replace' => '<li><a class="dimgray" title="{LANG.sendmail}" href="javascript:void(0);" onclick="newsSendMailModal(\'#newsSendMailModal\', \'{URL_SENDMAIL}\', \'{CHECKSESSION}\');"><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>'
        ));
    }

    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<\!\-\-[\s]*END[\s]*\:[\s]*allowed_send[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- START FORFOOTER -->
<div class="modal fade" id="newsSendMailModal" tabindex="-1" role="dialog" data-loaded="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{LANG.sendmail}</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
                    <!-- END FORFOOTER -->
                    <!-- END: allowed_send -->';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => '<li><a class="dimgray" rel="nofollow" title="{LANG.sendmail}" href="javascript:void(0);" onclick="nv_open_browse(\'{URL_SENDMAIL}\',\'{TITLE}\',650,500,\'resizable=no,scrollbars=yes,toolbar=no,location=no,status=no\');return false"><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>',
            'replace' => '<li><a class="dimgray" title="{LANG.sendmail}" href="javascript:void(0);" onclick="newsSendMailModal(\'#newsSendMailModal\', \'{URL_SENDMAIL}\', \'{CHECKSESSION}\');"><em class="fa fa-envelope fa-lg">&nbsp;</em></a></li>'
        ));
    }

    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*files[\s]*\-\-\>(.*?)\<\!\-\-[\s]*END[\s]*\:[\s]*files[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: files -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-download"></i> <strong>{LANG.files}</strong>
            </div>
            <div class="list-group news-download-file">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <!-- BEGIN: show_quick_viewfile -->
                    <span class="badge">
                        <a role="button" data-toggle="collapse" href="#file-{FILE.key}" aria-expanded="false" aria-controls="file-{FILE.key}">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewfile -->
                    <!-- BEGIN: show_quick_viewimg -->
                    <span class="badge">
                        <a href="javascript:void(0)" data-src="{FILE.src}" data-toggle="newsattachimage">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewimg -->
                    <a href="{FILE.url}" title="{FILE.titledown} {FILE.title}" download>{FILE.titledown}: <strong>{FILE.title}</strong></a>
                    <!-- BEGIN: content_quick_viewfile -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="file-{FILE.key}" data-src="{FILE.urlfile}" data-toggle="collapsefile" data-loaded="false">
                        <div class="well margin-top">
                            <iframe height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewfile -->
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
            'find' => 'Toàn bộ nội dung trong cặp <!-- BEGIN: files --> và <!-- END: files -->',
            'replace' => '        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-download"></i> <strong>{LANG.files}</strong>
            </div>
            <div class="list-group news-download-file">
                <!-- BEGIN: loop -->
                <div class="list-group-item">
                    <!-- BEGIN: show_quick_viewfile -->
                    <span class="badge">
                        <a role="button" data-toggle="collapse" href="#file-{FILE.key}" aria-expanded="false" aria-controls="file-{FILE.key}">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewfile -->
                    <!-- BEGIN: show_quick_viewimg -->
                    <span class="badge">
                        <a href="javascript:void(0)" data-src="{FILE.src}" data-toggle="newsattachimage">
                            <i class="fa fa-eye" data-rel="tooltip" data-content="{LANG.preview}"></i>
                        </a>
                    </span>
                    <!-- END: show_quick_viewimg -->
                    <a href="{FILE.url}" title="{FILE.titledown} {FILE.title}" download>{FILE.titledown}: <strong>{FILE.title}</strong></a>
                    <!-- BEGIN: content_quick_viewfile -->
                    <div class="clearfix"></div>
                    <div class="collapse" id="file-{FILE.key}" data-src="{FILE.urlfile}" data-toggle="collapsefile" data-loaded="false">
                        <div class="well margin-top">
                            <iframe height="600" scrolling="yes" src="" width="100%"></iframe>
                        </div>
                    </div>
                    <!-- END: content_quick_viewfile -->
                </div>
                <!-- END: loop -->
            </div>
        </div>'
        ));
    }

    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*allowed_rating[\s]*\-\-\>(.*?)\<\!\-\-[\s]*END[\s]*\:[\s]*allowed_rating[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: allowed_rating -->
<div class="news_column panel panel-default">
    <div class="panel-body">
        <form id="form3B" action="">
            <div class="h5 clearfix">
                <p id="stringrating">{STRINGRATING}</p>
                <!-- BEGIN: data_rating -->
                <span itemscope itemtype="https://schema.org/AggregateRating">
                    <span class="hidden d-none hide" itemprop="itemReviewed" itemscope itemtype="https://schema.org/CreativeWorkSeries">
                        <span class="hidden d-none hide" itemprop="name">{DETAIL.title}</span>
                    </span>
                    {LANG.rating_average}:
                    <span id="numberrating" itemprop="ratingValue">{DETAIL.numberrating}</span> -
                    <span id="click_rating" itemprop="ratingCount">{DETAIL.click_rating}</span> {LANG.rating_count}
                    <span class="hidden d-none hide" itemprop="bestRating">5</span>
                </span>
                <!-- END: data_rating -->
                <div style="padding: 5px;">
                    <!-- BEGIN: star --><input class="hover-star required" type="radio" value="{STAR.val}" title="{STAR.title}"{STAR.checked}/><!-- END: star -->
                    <span id="hover-test" style="margin: 0 0 0 20px;">{LANG.star_note}</span>
                </div>
            </div>
        </form>
        <script type="text/javascript">
        $(function() {
            var isDisable = false;
            $(\'.hover-star\').rating({
                focus : function(value, link) {
                    var tip = $(\'#hover-test\');
                    if (!isDisable) {
                        tip[0].data = tip[0].data || tip.html();
                        tip.html(link.title || \'value: \' + value)
                    }
                },
                blur : function(value, link) {
                    var tip = $(\'#hover-test\');
                    if (!isDisable) {
                        $(\'#hover-test\').html(tip[0].data || \'\')
                    }
                },
                callback : function(value, link) {
                    if (!isDisable) {
                        isDisable = true;
                        $(\'.hover-star\').rating(\'disable\');
                        sendrating(\'{NEWSID}\', value, \'{NEWSCHECKSS}\');
                    }
                }
            });
            <!-- BEGIN: disablerating -->
            $(".hover-star").rating(\'disable\');
            isDisable = true;
            <!-- END: disablerating -->
        })
        </script>
    </div>
</div>
<!-- END: allowed_rating -->';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => 'Toàn bộ nội dung trong cặp thẻ <!-- BEGIN: allowed_rating --> và <!-- END: allowed_rating -->',
            'replace' => '<div class="news_column panel panel-default">
    <div class="panel-body">
        <form id="form3B" action="">
            <div class="h5 clearfix">
                <p id="stringrating">{STRINGRATING}</p>
                <!-- BEGIN: data_rating -->
                <span itemscope itemtype="https://schema.org/AggregateRating">
                    <span class="hidden d-none hide" itemprop="itemReviewed" itemscope itemtype="https://schema.org/CreativeWorkSeries">
                        <span class="hidden d-none hide" itemprop="name">{DETAIL.title}</span>
                    </span>
                    {LANG.rating_average}:
                    <span id="numberrating" itemprop="ratingValue">{DETAIL.numberrating}</span> -
                    <span id="click_rating" itemprop="ratingCount">{DETAIL.click_rating}</span> {LANG.rating_count}
                    <span class="hidden d-none hide" itemprop="bestRating">5</span>
                </span>
                <!-- END: data_rating -->
                <div style="padding: 5px;">
                    <!-- BEGIN: star --><input class="hover-star required" type="radio" value="{STAR.val}" title="{STAR.title}"{STAR.checked}/><!-- END: star -->
                    <span id="hover-test" style="margin: 0 0 0 20px;">{LANG.star_note}</span>
                </div>
            </div>
        </form>
        <script type="text/javascript">
        $(function() {
            var isDisable = false;
            $(\'.hover-star\').rating({
                focus : function(value, link) {
                    var tip = $(\'#hover-test\');
                    if (!isDisable) {
                        tip[0].data = tip[0].data || tip.html();
                        tip.html(link.title || \'value: \' + value)
                    }
                },
                blur : function(value, link) {
                    var tip = $(\'#hover-test\');
                    if (!isDisable) {
                        $(\'#hover-test\').html(tip[0].data || \'\')
                    }
                },
                callback : function(value, link) {
                    if (!isDisable) {
                        isDisable = true;
                        $(\'.hover-star\').rating(\'disable\');
                        sendrating(\'{NEWSID}\', value, \'{NEWSCHECKSS}\');
                    }
                }
            });
            <!-- BEGIN: disablerating -->
            $(".hover-star").rating(\'disable\');
            isDisable = true;
            <!-- END: disablerating -->
        })
        </script>
    </div>
</div>'
        ));
    }

    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    if (preg_match("/\<\!\-\-[\s]*BEGIN[\s]*\:[\s]*socialbutton[\s]*\-\-\>(.*?)\<\!\-\-[\s]*END[\s]*\:[\s]*socialbutton[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: socialbutton -->
<div class="news_column panel panel-default">
    <div class="panel-body" style="margin-bottom:0">
        <div style="display:flex;align-items:flex-start;">
            <!-- BEGIN: facebook --><div class="margin-right"><div class="fb-like" style="float:left!important;margin-right:0!important" data-href="{DETAIL.link}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div><!-- END: facebook -->
            <!-- BEGIN: twitter --><div class="margin-right"><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></div><!-- END: twitter -->
            <!-- BEGIN: zalo --><div><div class="zalo-share-button" data-href="" data-oaid="{ZALO_OAID}" data-layout="1" data-color="blue" data-customize=false></div></div><!-- END: zalo -->
        </div>
     </div>
</div>
<!-- END: socialbutton -->';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('news', array(
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ));
    } else {
        nvUpdateSetItemGuide('news', array(
            'find' => 'Toàn bộ nội dung trong cặp thẻ <!-- BEGIN: socialbutton --> và <!-- END: socialbutton -->',
            'replace' => '<div class="news_column panel panel-default">
    <div class="panel-body" style="margin-bottom:0">
        <div style="display:flex;align-items:flex-start;">
            <!-- BEGIN: facebook --><div class="margin-right"><div class="fb-like" style="float:left!important;margin-right:0!important" data-href="{DETAIL.link}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div></div><!-- END: facebook -->
            <!-- BEGIN: twitter --><div class="margin-right"><a href="http://twitter.com/share" class="twitter-share-button">Tweet</a></div><!-- END: twitter -->
            <!-- BEGIN: zalo --><div><div class="zalo-share-button" data-href="" data-oaid="{ZALO_OAID}" data-layout="1" data-color="blue" data-customize=false></div></div><!-- END: zalo -->
        </div>
     </div>
</div>'
        ));
    }
} elseif (preg_match('/\/sendmail\.tpl$/', $file)) {
    nv_get_update_result('news');
    nvUpdateContructItem('news', 'html');

    // Thay toàn bộ content.tpl
    $output_data = file_get_contents(NV_ROOTDIR . '/modules/' . $module_file . '/' . $op . '/sendmail.tpl');

    nvUpdateSetItemData('news', array(
        'status' => 1,
        'find' => 'Toàn bộ nội dung file sendmail.tpl',
        'replace' => 'Nội dung file tương ứng ở phiên bản mới'
    ));
}
