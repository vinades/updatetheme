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
$array_files_update=array();
/*
Chuyển breadcrumb từ vocabulary sang schema.org

Mở file themes/theme-cua-ban/layout/header_extended.tpl tìm:

<ul class="temp-breadcrumbs hidden">
Thay thành:

<ul class="temp-breadcrumbs hidden" itemscope itemtype="https://schema.org/BreadcrumbList">
Trong thẻ ul đó tìm các thẻ li (có khoảng 2 thẻ), thay thế các thành phần sau: Thay:

itemscope itemtype="http://data-vocabulary.org/Breadcrumb"
Thành

itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
Thay itemprop="url" thành itemprop="item". Thay itemprop="title" thành itemprop="name".

Trước khi đóng thẻ li thứ nhất thêm:

<i class="hidden" itemprop="position" content="1"></i>
Trước khi đóng thẻ li thứ hai thêm:

<i class="hidden" itemprop="position" content="{BREADCRUMBS.position}"></i>
Sau khi hoàn chỉnh kết quả sẽ như sau:
<ul class="temp-breadcrumbs hidden" itemscope itemtype="https://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="{THEME_SITE_HREF}" itemprop="item" title="{LANG.Home}">
            <span itemprop="name">{LANG.Home}</span>
        </a>
        <i class="hidden" itemprop="position" content="1"></i>
    </li>
    <!-- BEGIN: loop -->
    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="{BREADCRUMBS.link}" itemprop="item" title="{BREADCRUMBS.title}">
            <span class="txt" itemprop="name">{BREADCRUMBS.title}</span>
        </a>
        <i class="hidden" itemprop="position" content="{BREADCRUMBS.position}"></i>
    </li>
    <!-- END: loop -->
</ul>
Note: Làm có hơi phức tạp một chút để đề phòng trường hợp tag ul và li ngoài các class có sẳn
lập trình viên có thể thêm các class khác thì khi cập nhật vẫn bảo tồn những class đó.
*/
function updateFileBreadcrumb($contents_file)
{
    $pattern = '/<ul\s+class\s*=\s*"((.*\s+)?temp-breadcrumbs\s+(.*\s+)?hidden([^"]*\s*)?)"\s*>[\s\S]*?<\/ul>/';
    preg_match_all($pattern, $contents_file,$match);
    foreach ($match[0] as $k=>$tag) {
        $rs="<ul class=\"".$match[1][$k]."\" itemscope itemtype=\"https://schema.org/BreadcrumbList\">";
        $tag=preg_replace('/itemtype\s*=\s*"\s*http:\/\/data-vocabulary.org\/Breadcrumb\s*"/','itemtype="https://schema.org/ListItem"',$tag);
        $tag=preg_replace('/itemprop\s*=\s*"\s*url\s*"/','itemprop="item"',$tag);
        $tag=preg_replace('/itemprop\s*=\s*"\s*title\s*"/','itemprop="name"',$tag);
        preg_match_all('/<li\s+([^>]*)>([\s\S]*?)<\/li>/', $tag,$match1);
        foreach ($match1[0] as $k1=>$tag1){
            $rs.="\n<li itemprop=\"itemListElement\" ".$match1[1][$k1].">";
            $rs.=$match1[2][$k1];
            if ($k1==0) {
                $rs.='<i class="hidden" itemprop="position" content="1"></i>';
            } elseif ($k1==count($match1[0])-1){
                $rs.='<i class="hidden" itemprop="position" content="{BREADCRUMBS.position}"></i>';
            }
            $rs.="</li>";
        }
        $rs.="</ul>";
        $contents_file=str_replace($match[0][$k],$rs,$contents_file);
    }
    return $contents_file;
}
/*
Mở file themes/default/theme.php tìm

foreach ($array_mod_title_copy as $arr_cat_title_i) {
Thêm lên bên trên:

$border = 2;
Thêm xuống dưới:

$arr_cat_title_i['position'] = $border++;
*/
function updateFileTheme($contents_file)
{
    $pattern = '/\s*[^\w\d]\$border = 2;\s*\n*[^\w\d]foreach\s+\(\s*\$array_mod_title_copy\s+as\s+\$arr_cat_title_i\s*\)\s+\{\s*\n*\s*\$arr_cat_title_i\[\'position\'\]\s*=\s*\$border\+\+;\s*\n*/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $pattern = '/\s*[^\w\d]foreach\s+\(\s*\$array_mod_title_copy\s+as\s+\$arr_cat_title_i\s*\)\s+\{\s*/';
        $replace="\n\$border = 2;\nforeach (\$array_mod_title_copy as \$arr_cat_title_i) {\n\$arr_cat_title_i['position'] = \$border++;\n";
        $contents_file=preg_replace($pattern,$replace,$contents_file);
    }   
    return $contents_file;
}
/*
Nếu giao diện của bạn tồn tại file themes/theme-cua-ban/modules/news/detail.tpl 
tìm đoạn code từ thẻ <!-- BEGIN: data_rating --> đến thẻ <!-- END: data_rating --> thay bằng đoạn code sau
<span itemscope itemtype="https://schema.org/AggregateRating">
    <span class="hidden d-none hide" itemprop="itemReviewed" itemscope itemtype="https://schema.org/CreativeWorkSeries">
        <span class="hidden d-none hide" itemprop="name">{DETAIL.title}</span>
    </span>
    {LANG.rating_average}:
    <span id="numberrating" itemprop="ratingValue">{DETAIL.numberrating}</span> -
    <span id="click_rating" itemprop="ratingCount">{DETAIL.click_rating}</span> {LANG.rating_count}
    <span class="hidden d-none hide" itemprop="bestRating">5</span>
</span>
Ví dụ thay:
<!-- BEGIN: data_rating -->
<span itemscope itemtype="http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
    <span itemprop="rating" id="numberrating">{DETAIL.numberrating}</span> -
    <span itemprop="votes" id="click_rating">{DETAIL.click_rating}</span> {LANG.rating_count}
</span>
<!-- END: data_rating -->
Thành:
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
*/
function updateFileNewsDetail($contents_file)
{
    $pattern = '/<!--\s+BEGIN:\s+data_rating\s+-->[\s\S]*?<!--\s+END:\s+data_rating\s+-->/';
    $replace="<!-- BEGIN: data_rating -->\n<span itemscope itemtype=\"https://schema.org/AggregateRating\">
    <span class=\"hidden d-none hide\" itemprop=\"itemReviewed\" itemscope itemtype=\"https://schema.org/CreativeWorkSeries\">
        <span class=\"hidden d-none hide\" itemprop=\"name\">{DETAIL.title}</span>
    </span>
    {LANG.rating_average}:
    <span id=\"numberrating\" itemprop=\"ratingValue\">{DETAIL.numberrating}</span> -
    <span id=\"click_rating\" itemprop=\"ratingCount\">{DETAIL.click_rating}</span> {LANG.rating_count}
    <span class=\"hidden d-none hide\" itemprop=\"bestRating\">5</span>
    </span>\n<!-- END: data_rating -->";
    $contents_file=preg_replace($pattern,$replace,$contents_file);
    return $contents_file;
}
/*
Module page: Thêm cấu hình số ký tự tiêu đề, giới thiệu, hiển thị ảnh cho global.page.php
Việc sửa này không bắt buộc, nếu không sửa thì các cấu hình của block chỉ không hiển thị hình ảnh minh họa:

Sửa file (nếu có): themes/my_theme/modules/page/block.about.tpl tìm đến đoạn:

<h3 class="margin-bottom"><a title="{TITLE}" href="{LINK}">{TITLE}</a></h3>
Sửa lại thành:

<!-- BEGIN: image -->
<div class="image pull-left">
    <a href="{LINK}" title="{TITLE}"> <img src="{IMAGE}" alt="{TITLE}" class="img-responsive" /></a>
</div>
<!-- END: image -->
<h3 class="margin-bottom">
    <a title="{TITLE}" href="{LINK}">{TITLE}</a>
</h3>
*/
function updateFilePageBlockAbout($contents_file)
{
    $pattern = '/<!-- BEGIN: image -->/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $pattern = '/<h3\s+class\s*=\s*"((.*\s+)?margin-bottom([^"]*\s*)?)"\s*>[\s\S]*?<\/h3>/';
        preg_match_all($pattern, $contents_file,$match);
        if ($h3=$match[0][0]) {
            $replace="<!-- BEGIN: image -->\n<div class=\"image pull-left\">\n<a href=\"{LINK}\" title=\"{TITLE}\"> <img src=\"{IMAGE}\" alt=\"{TITLE}\" class=\"img-responsive\" /></a>\n</div>\n<!-- END: image -->\n".$h3;
            $contents_file=preg_replace($pattern,$replace,$contents_file);
        }
    }   
    return $contents_file;
}
/*
Sửa lỗi giao diện block global.login.php và global.user_button.php
Mở themes/ten-theme/modules/users/block.login.tpl (nếu có) và 
themes/ten-theme/modules/users/block.user_button.tpl (nếu có) tìm những đoạn

{NV_BASE_SITEURL}themes/{BLOCK_THEME}/js/users.js
Hoặc

{NV_BASE_SITEURL}themes/default/js/users.js
Thay lại thành

{NV_BASE_SITEURL}themes/{BLOCK_JS}/js/users.js
*/
function updateFileUserBlockLogin($contents_file)
{
    $replace="{NV_BASE_SITEURL}themes/{BLOCK_JS}/js/users.js";
    $pattern1 = '/\{\s*NV_BASE_SITEURL\s*\}\s*themes\s*\/\{\s*BLOCK_THEME\s*\}\/\s*js\s*\/\s*users.js\s*/';
    $pattern2 = '/\{\s*NV_BASE_SITEURL\\s*}\s*themes\s*\/default\s*\/\s*js\s*\/\s*users.js\s*/';
    $contents_file=preg_replace($pattern1,$replace,$contents_file); 
    $contents_file=preg_replace($pattern2,$replace,$contents_file);
    return $contents_file;
}
/*
Xóa google fonts khi thay đổi thiết lập giao diện
Mở themes/ten-themes/config.php tìm

    $nv_Cache->delMod('settings');
Thêm xuống dưới

    $gfonts = new NukeViet\Client\Gfonts();
    $gfonts->destroyAll();
*/
function updateFileConfig($contents_file)
{
    $pattern = '/\$gfonts\s*=\s*new\s+NukeViet\\\Client\\\Gfonts\(\);/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $pattern = '/\s*[^\w\d]\$nv_Cache->delMod\(\s*\'settings\s*\'\)\s*;\s*/';
        $replace="\n\$nv_Cache->delMod('settings');\n\$gfonts = new NukeViet\\Client\\Gfonts();\n\$gfonts->destroyAll();\n";
        $contents_file=preg_replace($pattern,$replace,$contents_file);
    }   
    return $contents_file;
}
/*
Xóa bỏ tích hợp web Google+ (Việc này cần làm do Google đã gỡ bỏ nền tảng Google Plus):
Tìm và xóa các đoạn tương tự như sau trong các file tpl của giao diện

<div class="g-plusone" data-size="medium"></div>
Đối với giao diện mặc định chúng tôi kiểm tra nó có ở những file sau:

themes/my_theme/modules/news/detail.tpl
themes/my_theme/modules/page/main.tpl
themes/mobile_my_theme/modules/news/detail.tpl
*/
function updateFileGooglePlus($contents_file)
{
    $pattern = '/<div\s+class\s*=\s*"g-plusone"\s+data-size\s*=\s*"medium"\s*>\s*<\/div>\n*/';
    $contents_file=preg_replace($pattern,'',$contents_file);
    return $contents_file;
}
/*
Tìm và xóa các đoạn tương tự như sau trong js của giao diện

0 < $(".g-plusone").length && (window.___gcfg = {
        lang: nv_lang_data
    }, function() {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.async = !0;
        a.src = "//apis.google.com/js/plusone.js";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }());
Đối với giao diện mặc định chúng tôi kiểm tra nó có ở những file sau:

themes/my_theme/js/main.js
themes/mobile_my_theme/js/main.js để xóa bỏ đoạn:
Note: Nếu chẳng may lập trình viên có thay đổi một chút đoạn này thì sẽ không thể xóa được
*/
function updateFileJsGooglePlus($contents_file)
{
    $pattern = '0 < $(".g-plusone").length && (window.___gcfg = {
        lang: nv_lang_data
    }, function() {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.async = !0;
        a.src = "//apis.google.com/js/plusone.js";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }());';
    $contents_file=str_replace($pattern,'',$contents_file);
    return $contents_file;
}
/*
Nếu website của bạn có tùy biến dữ liệu user với kiểu dữ liệu trình soạn thảo và đang bị lỗi không hiển thị trình soạn thảo, tồn tại file themes/ten_theme/js/users.js thì mở lên tìm
function reg_validForm(a) {
Thêm xuống dưới

    // Xử lý các trình soạn thảo
    if (typeof CKEDITOR != "undefined") {
        for (var instanceName in CKEDITOR.instances) {
            $('#' + instanceName).val(CKEDITOR.instances[instanceName].getData());
        }
    }
*/
function updateFileUsersJs($contents_file)
{
    $pattern = '/function\s+reg_validForm\(a\)\s*\n*\s*[\s\S]*?CKEDITOR/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $pattern = '/(\s+|\n+)function\s+reg_validForm\s*\(\s*a\s*\)\s*\{/';
        $replace="\nfunction reg_validForm(a) {\nif (typeof CKEDITOR != \"undefined\") {
            for (var instanceName in CKEDITOR.instances) {
                $('#' + instanceName).val(CKEDITOR.instances[instanceName].getData());
            }
        }\n";
        $contents_file=preg_replace($pattern,$replace,$contents_file);
    }   
    return $contents_file;
}
/*
Nếu site của bạn hiện ở phiên bản nhỏ hơn 4.3.02 và sử dụng giao diện không phải mặc định thì thực hiện cập nhật theo hướng dẫn sau

Tìm trong file: themes/my_theme/js/main.js:
window.location.href = location.reload()
Nếu có thay bằng

location.reload()
*/
function updateFileJsReload($contents_file)
{
    $pattern = '/(\s+|\n+)window.location.href\s*=\s*location.reload\(\s*\)/';
    $replace="\nlocation.reload()\n";
    $contents_file=preg_replace($pattern,$replace,$contents_file);
    return $contents_file;
}
/*
Nếu giao diện của bạn tồn tại themes/my_theme/modules/contact/form.tpl
Mở form.tpl tìm
<div class="form-group">
    <label><input type="checkbox" name="sendcopy" value="1" checked="checked" /><span>{LANG.sendcopy}</span></label>
</div>
Thêm lên trên

        <!-- BEGIN: sendcopy -->
Thêm xuống dưới

        <!-- END: sendcopy -->
*/
function updateFileContactForm($contents_file)
{
    $pattern = '/<!--\s+BEGIN:\s+sendcopy\s+-->/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $pattern = '/<div\s+class\s*=\s*"\s*form-group\s*">\n*\s*<label>\n*\s*<input\s+type\s*=\s*"checkbox"\s+name\s*=\s*"sendcopy"\s+value\s*=\s*"1"\s+checked\s*=\s*"\s*checked\s*"\s*\/>\n*\s*<span>\n*\s*\{LANG.sendcopy\}\n*\s*<\/span>\n*\s*<\/label>\n*\s*<\/div>/';
        $replace="<!-- BEGIN: sendcopy -->\n<div class=\"form-group\">
        <label><input type=\"checkbox\" name=\"sendcopy\" value=\"1\" checked=\"checked\" /><span>{LANG.sendcopy}</span></label>
    </div>\n<!-- END: sendcopy -->";
        $contents_file=preg_replace($pattern,$replace,$contents_file);
    }   
    return $contents_file;
}
function updateResult($file,$funcs)
{
    global $array_files_update;
    $key=str_replace(NV_ROOTDIR,"",$file);
    if (empty($array_files_update[$key])) {
        $array_files_update[$key]=array(
            'funcs'=>array()
        );
    }
    $array_files_update[$key]['funcs'][]=$funcs;
}
$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$theme_update = '';
$list_theme = nv_scandir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update', $global_config['check_theme']);
if (!empty($list_theme)) {
    $theme_update = $list_theme[0];
}
if (empty($theme_update)) {
    $list_theme = nv_scandir(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update', $global_config['check_theme_mobile']);
    if (!empty($list_theme)) {
        $theme_update = $list_theme[0];
    }
}
if (empty($theme_update)) {
    $contents = nv_theme_alert('Không có giao diện để cập nhật', 'Bạn chưa copy giao diện cần cập nhật vào đúng thư mục đã quy định, vui lòng thực hiện thao tác đó trước.', 'danger');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$my_head .= '<link href="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/styles/github.css" rel="stylesheet">';
$my_head .= '<script src="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>';
$my_head .= '<script>hljs.initHighlightingOnLoad();</script>';

$xtpl = new XTemplate('update.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('THEMEUPDATE', $theme_update);
$xtpl->assign('NV_TEMP_DIR', NV_TEMP_DIR);

$global_autokey = -1;
$file_key = '';
$file = '';
$array_update_result = array();

$num_section_auto = 0;
$num_section_manual = 0;
if ($nv_Request->isset_request('submit', 'post')) {
    // Xác định danh sách các file
    $files = list_all_file(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update, NV_ROOTDIR . '/' . NV_TEMP_DIR . '/theme-update/' . $theme_update);
    foreach ($files as $file) {
        if (preg_match('/\/'.$theme_update.'\/layout\/header_extended.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileBreadcrumb($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileBreadcrumb');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/theme.php$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileTheme($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileTheme');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/modules\/news\/detail.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileNewsDetail($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileNewsDetail');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/modules\/page\/block.about.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFilePageBlockAbout($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFilePageBlockAbout');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/modules\/users\/block.login.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileUserBlockLogin($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileUserBlockLogin');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/modules\/users\/block.user_button.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileUserBlockLogin($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileUserBlockLogin');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/modules\/contact\/form.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileContactForm($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileContactForm');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/config.php$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileConfig($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileConfig');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        else if (preg_match('/\/'.$theme_update.'\/js\/users.js$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileUsersJs($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileUsersJs');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        if (preg_match('/\.tpl$/',$file,$m)) {
            $contents_file = file_get_contents($file);
            $output_data = updateFileGooglePlus($contents_file);
            if ($contents_file != $output_data) {
                updateResult($file,'updateFileGooglePlus');
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
        if (preg_match('/\.js$/',$file,$m)) {
            $put_file=false;
            $contents_file = file_get_contents($file);
            $output_data = updateFileJsGooglePlus($contents_file);
            if ($contents_file != $output_data) {
                $put_file=true;
                updateResult($file,'updateFileJsGooglePlus');
            }
            $contents_file=$output_data;
            $output_data = updateFileJsReload($output_data);
            if ($contents_file != $output_data) {
                $put_file=true;
                updateResult($file,'updateFileJsReload');
            }
            if ($put_file) {
                file_put_contents($file, $output_data, LOCK_EX);
            }
        }
    }
    $xtpl->assign('NUM_SECTION_AUTO', count($array_files_update));
    foreach ($array_files_update as $k=>$value) {
        $xtpl->assign('FILE_NAME', $k);
        foreach ($value['funcs'] as $v) {
            $xtpl->assign('FUNC', $v);
            $xtpl->parse('main.thongke.file.func');
        }
        $xtpl->parse('main.thongke.file');
    }
    $xtpl->parse('main.thongke');
} else {
    $xtpl->parse('main.form');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
