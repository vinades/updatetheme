<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Thu, 09 Jan 2014 10:18:48 GMT
 */

if (!defined('NV_IS_MOD_UPDATETHEME')) {
    die('Stop!!!');
}
    
$array_files_update = array();
/*
Chuyển breadcrumb từ vocabulary sang schema.org

Mở file themes/theme-cua-ban/layout/header_extended.tpl tìm:

<ul class = "temp-breadcrumbs hidden">
Thay thành:

<ul class = "temp-breadcrumbs hidden" itemscope itemtype = "https://schema.org/BreadcrumbList">
Trong thẻ ul đó tìm các thẻ li (có khoảng 2 thẻ), thay thế các thành phần sau: Thay:

itemscope itemtype = "http://data-vocabulary.org/Breadcrumb"
Thành

itemprop = "itemListElement" itemscope itemtype = "https://schema.org/ListItem"
Thay itemprop = "url" thành itemprop = "item". Thay itemprop = "title" thành itemprop = "name".

Trước khi đóng thẻ li thứ nhất thêm:

<i class = "hidden" itemprop = "position" content = "1"></i>
Trước khi đóng thẻ li thứ hai thêm:

<i class = "hidden" itemprop = "position" content = "{BREADCRUMBS.position}"></i>
Sau khi hoàn chỉnh kết quả sẽ như sau:
<ul class = "temp-breadcrumbs hidden" itemscope itemtype = "https://schema.org/BreadcrumbList">
    <li itemprop = "itemListElement" itemscope itemtype = "https://schema.org/ListItem">
        <a href = "{THEME_SITE_HREF}" itemprop = "item" title = "{LANG.Home}">
            <span itemprop = "name">{LANG.Home}</span>
        </a>
        <i class = "hidden" itemprop = "position" content = "1"></i>
    </li>
    <!-- BEGIN: loop -->
    <li itemprop = "itemListElement" itemscope itemtype = "https://schema.org/ListItem">
        <a href = "{BREADCRUMBS.link}" itemprop = "item" title = "{BREADCRUMBS.title}">
            <span class = "txt" itemprop = "name">{BREADCRUMBS.title}</span>
        </a>
        <i class = "hidden" itemprop = "position" content = "{BREADCRUMBS.position}"></i>
    </li>
    <!-- END: loop -->
</ul>
Note: Làm có hơi phức tạp một chút để đề phòng trường hợp tag ul và li ngoài các class có sẳn
lập trình viên có thể thêm các class khác thì khi cập nhật vẫn bảo tồn những class đó.
*/
function updateFileBreadcrumb($contents_file)
{
    $status = false;
    $find = '<ul class = "temp-breadcrumbs hidden">
    <li itemscope itemtype = "http://data-vocabulary.org/Breadcrumb"><a href = "{THEME_SITE_HREF}" itemprop = "url" title = "{LANG.Home}"><span itemprop = "title">{LANG.Home}</span></a></li>
    <!-- BEGIN: loop --><li itemscope itemtype = "http://data-vocabulary.org/Breadcrumb"><a href = "{BREADCRUMBS.link}" itemprop = "url" title = "{BREADCRUMBS.title}"><span class = "txt" itemprop = "title">{BREADCRUMBS.title}</span></a></li><!-- END: loop -->
</ul>';
    $replace = '
    <ul class = "temp-breadcrumbs hidden" itemscope itemtype = "https://schema.org/BreadcrumbList">
        <li itemprop = "itemListElement" itemscope itemtype = "https://schema.org/ListItem">
            <a href = "{THEME_SITE_HREF}" itemprop = "item" title = "{LANG.Home}">
                <span itemprop = "name">{LANG.Home}</span>
            </a>
            <i class = "hidden" itemprop = "position" content = "1"></i>
        </li>
        <!-- BEGIN: loop -->
        <li itemprop = "itemListElement" itemscope itemtype = "https://schema.org/ListItem">
            <a href = "{BREADCRUMBS.link}" itemprop = "item" title = "{BREADCRUMBS.title}">
                <span class = "txt" itemprop = "name">{BREADCRUMBS.title}</span>
            </a>
            <i class = "hidden" itemprop = "position" content = "{BREADCRUMBS.position}"></i>
        </li>
        <!-- END: loop -->
    </ul>';
    $pattern = '/<ul\s+class\s*=\s*"((.*\s+)?temp-breadcrumbs\s+(.*\s+)?hidden([^"]*\s*)?)"\s*>[\s\S]*?<\/ul>/';
    preg_match_all($pattern, $contents_file,$match);
    if (!empty($match[0])) {
        $status = true;
        foreach ($match[0] as $k=>$tag) {
            $rs = "\n".str_repeat(" ",36)."<ul class = \"".$match[1][$k]."\" itemscope itemtype = \"https://schema.org/BreadcrumbList\">";
            $tag = preg_replace('/itemtype\s*=\s*"\s*http:\/\/data-vocabulary.org\/Breadcrumb\s*"/','itemtype = "https://schema.org/ListItem"',$tag);
            $tag = preg_replace('/itemprop\s*=\s*"\s*url\s*"/','itemprop = "item"',$tag);
            $tag = preg_replace('/itemprop\s*=\s*"\s*title\s*"/','itemprop = "name"',$tag);
            preg_match_all('/<li\s+([^>]*)>([\s\S]*?)<\/li>/', $tag,$match1);
            foreach ($match1[0] as $k1=>$tag1){
                $rs.=  "\n".str_repeat(" ",40)."<li itemprop = \"itemListElement\" ".$match1[1][$k1].">";
                $rs.= "\n".str_repeat(" ",44).$match1[2][$k1];
                if ($k1 == 0) {
                    $rs.= "\n".str_repeat(" ",48).'<i class = "hidden" itemprop = "position" content = "1"></i>';
                } elseif ($k1 == count($match1[0])-1) {
                    $rs.=  "\n".str_repeat(" ",48).'<i class = "hidden" itemprop = "position" content = "{BREADCRUMBS.position}"></i>';
                }
                $rs.=  "\n".str_repeat(" ",40)."</li>";
            }
            $rs.=  "\n".str_repeat(" ",36)."</ul>";
            $contents_file = str_replace($match[0][$k],$rs,$contents_file);
        }
    }
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
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
    $status = false;
    $find = 'foreach ($array_mod_title_copy as $arr_cat_title_i) {';
    $pattern = '/\s*[^\w\d]\$border = 2;\s*\n*[^\w\d]foreach\s+\(\s*\$array_mod_title_copy\s+as\s+\$arr_cat_title_i\s*\)\s+\{\s*\n*\s*\$arr_cat_title_i\[\'position\'\]\s*=\s*\$border\+\+;\s*\n*/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $pattern = '/\s*[^\w\d]foreach\s+\(\s*\$array_mod_title_copy\s+as\s+\$arr_cat_title_i\s*\)\s+\{\s*/';
        $replace="\n".str_repeat(" ",16)."\$border = 2;";
        $replace.="\n".str_repeat(" ",16)."foreach (\$array_mod_title_copy as \$arr_cat_title_i) {";
        $replace.="\n".str_repeat(" ",20)."\$arr_cat_title_i['position'] = \$border++;\n";
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = "\$border = 2;\n";
    $replace .="foreach (\$array_mod_title_copy as \$arr_cat_title_i) {\n";
    $replace .= "    \$arr_cat_title_i['position'] = \$border++;\n";   
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
/*
Nếu giao diện của bạn tồn tại file themes/theme-cua-ban/modules/news/detail.tpl 
tìm đoạn code từ thẻ <!-- BEGIN: data_rating --> đến thẻ <!-- END: data_rating --> thay bằng đoạn code sau
<span itemscope itemtype = "https://schema.org/AggregateRating">
    <span class = "hidden d-none hide" itemprop = "itemReviewed" itemscope itemtype = "https://schema.org/CreativeWorkSeries">
        <span class = "hidden d-none hide" itemprop = "name">{DETAIL.title}</span>
    </span>
    {LANG.rating_average}:
    <span id = "numberrating" itemprop = "ratingValue">{DETAIL.numberrating}</span> -
    <span id = "click_rating" itemprop = "ratingCount">{DETAIL.click_rating}</span> {LANG.rating_count}
    <span class = "hidden d-none hide" itemprop = "bestRating">5</span>
</span>
Ví dụ thay:
<!-- BEGIN: data_rating -->
<span itemscope itemtype = "http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
    <span itemprop = "rating" id = "numberrating">{DETAIL.numberrating}</span> -
    <span itemprop = "votes" id = "click_rating">{DETAIL.click_rating}</span> {LANG.rating_count}
</span>
<!-- END: data_rating -->
Thành:
<!-- BEGIN: data_rating -->
<span itemscope itemtype = "https://schema.org/AggregateRating">
    <span class = "hidden d-none hide" itemprop = "itemReviewed" itemscope itemtype = "https://schema.org/CreativeWorkSeries">
        <span class = "hidden d-none hide" itemprop = "name">{DETAIL.title}</span>
    </span>
    {LANG.rating_average}:
    <span id = "numberrating" itemprop = "ratingValue">{DETAIL.numberrating}</span> -
    <span id = "click_rating" itemprop = "ratingCount">{DETAIL.click_rating}</span> {LANG.rating_count}
    <span class = "hidden d-none hide" itemprop = "bestRating">5</span>
</span>
<!-- END: data_rating -->
*/
function updateFileNewsDetail($contents_file)
{
    $status = false;
    $find = '<!-- BEGIN: data_rating -->
    <span itemscope itemtype = "http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
        <span itemprop = "rating" id = "numberrating">{DETAIL.numberrating}</span> -
        <span itemprop = "votes" id = "click_rating">{DETAIL.click_rating}</span> {LANG.rating_count}
    </span>
    <!-- END: data_rating -->';
    $pattern = '/<!--\s+BEGIN:\s+data_rating\s+-->[\s\S]*?<!--\s+END:\s+data_rating\s+-->/';
    $replace = "<!-- BEGIN: data_rating -->";
    $replace.= "\n".str_repeat(" ",16)."<span itemscope itemtype = \"https://schema.org/AggregateRating\">";
    $replace.= "\n".str_repeat(" ",20)."<span class = \"hidden d-none hide\" itemprop = \"itemReviewed\" itemscope itemtype = \"https://schema.org/CreativeWorkSeries\">";
    $replace.= "\n".str_repeat(" ",24)."<span class = \"hidden d-none hide\" itemprop = \"name\">{DETAIL.title}</span>";
    $replace.= "\n".str_repeat(" ",20)."</span>";
    $replace.= "\n".str_repeat(" ",20)."{LANG.rating_average}:";
    $replace.= "\n".str_repeat(" ",20)."<span id = \"numberrating\" itemprop = \"ratingValue\">{DETAIL.numberrating}</span> -";
    $replace.= "\n".str_repeat(" ",20)."<span id = \"click_rating\" itemprop = \"ratingCount\">{DETAIL.click_rating}</span>";
    $replace.= "\n".str_repeat(" ",20)." {LANG.rating_count}";
    $replace.= "\n".str_repeat(" ",20)."<span class = \"hidden d-none hide\" itemprop = \"bestRating\">5</span>";
    $replace.= "\n".str_repeat(" ",16)."</span>";
    $replace.= "\n".str_repeat(" ",16)."<!-- END: data_rating -->";
    if (preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $find = $m[0];
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = "<!-- BEGIN: data_rating -->\n<span itemscope itemtype = \"https://schema.org/AggregateRating\">
    <span class = \"hidden d-none hide\" itemprop = \"itemReviewed\" itemscope itemtype = \"https://schema.org/CreativeWorkSeries\">
        <span class = \"hidden d-none hide\" itemprop = \"name\">{DETAIL.title}</span>
    </span>
    {LANG.rating_average}:
    <span id = \"numberrating\" itemprop = \"ratingValue\">{DETAIL.numberrating}</span> -
    <span id = \"click_rating\" itemprop = \"ratingCount\">{DETAIL.click_rating}</span> {LANG.rating_count}
    <span class = \"hidden d-none hide\" itemprop = \"bestRating\">5</span>
    </span>\n<!-- END: data_rating -->";
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
/*
Module page: Thêm cấu hình số ký tự tiêu đề, giới thiệu, hiển thị ảnh cho global.page.php
Việc sửa này không bắt buộc, nếu không sửa thì các cấu hình của block chỉ không hiển thị hình ảnh minh họa:

Sửa file (nếu có): themes/my_theme/modules/page/block.about.tpl tìm đến đoạn:

<h3 class = "margin-bottom"><a title = "{TITLE}" href = "{LINK}">{TITLE}</a></h3>
Sửa lại thành:

<!-- BEGIN: image -->
<div class = "image pull-left">
    <a href = "{LINK}" title = "{TITLE}"> <img src = "{IMAGE}" alt = "{TITLE}" class = "img-responsive" /></a>
</div>
<!-- END: image -->
<h3 class = "margin-bottom">
    <a title = "{TITLE}" href = "{LINK}">{TITLE}</a>
</h3>
*/
function updateFilePageBlockAbout($contents_file)
{
    $status = false;
    $find = '<h3 class = "margin-bottom"><a title = "{TITLE}" href = "{LINK}">{TITLE}</a></h3>';
    $pattern = '/<!-- BEGIN: image -->/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $pattern = '/<h3\s+class\s*=\s*"((.*\s+)?margin-bottom([^"]*\s*)?)"\s*>[\s\S]*?<\/h3>/';
        preg_match_all($pattern, $contents_file,$match);
        if ($h3 = $match[0][0]) {
            $replace  = "<!-- BEGIN: image -->";
            $replace .= "\n<div class = \"image pull-left\">";
            $replace .= "\n".str_repeat(" ",4)."<a href = \"{LINK}\" title = \"{TITLE}\"> <img src = \"{IMAGE}\" alt = \"{TITLE}\" class = \"img-responsive\" /></a>";
            $replace .= "\n</div>\n<!-- END: image -->\n".$h3;
            $contents_file = preg_replace($pattern,$replace,$contents_file);
        }
    }   
    $replace = '<!-- BEGIN: image -->
    <div class = "image pull-left">
        <a href = "{LINK}" title = "{TITLE}"> <img src = "{IMAGE}" alt = "{TITLE}" class = "img-responsive" /></a>
    </div>
    <!-- END: image -->
    <h3 class = "margin-bottom">
        <a title = "{TITLE}" href = "{LINK}">{TITLE}</a>
    </h3>';
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
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
    $status = false;
    $find = '{NV_BASE_SITEURL}themes/{BLOCK_THEME}/js/users.js hoặc {NV_BASE_SITEURL}themes/default/js/users.js';
    $replace = "{NV_BASE_SITEURL}themes/{BLOCK_JS}/js/users.js";
    $pattern1 = '/\{\s*NV_BASE_SITEURL\s*\}\s*themes\s*\/\s*\{\s*BLOCK_THEME\s*\}\s*\/js\s*\/\s*users\.js\s*/';
    $pattern2 = '/\{\s*NV_BASE_SITEURL\s*\}\s*themes\s*\/\s*default\s*\/js\s*\/\s*users\.js\s*/';
    if (preg_match($pattern1,$contents_file,$m)) {
        $status = true;
        $contents_file = preg_replace($pattern1,$replace,$contents_file); 
    }
    if (preg_match($pattern2,$contents_file,$m)) {
        $status = true;
        $contents_file = preg_replace($pattern2,$replace,$contents_file);
    }
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
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
    $status = false;
    $find = '$nv_Cache->delMod(\'settings\');';
    $pattern = '/\$gfonts\s*=\s*new\s+NukeViet\\\Client\\\Gfonts\(\);/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $pattern = '/\s*[^\w\d]\$nv_Cache->delMod\(\s*\'settings\s*\'\)\s*;/';
        $replace =  "\n".str_repeat(" ",4)."\$nv_Cache->delMod('settings');";
        $replace .= "\n".str_repeat(" ",4)."\$gfonts = new NukeViet\\Client\\Gfonts();";
        $replace .= "\n".str_repeat(" ",4)."\$gfonts->destroyAll();";
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = '$nv_Cache->delMod(\'settings\');
    $gfonts = new NukeViet\Client\Gfonts();
    $gfonts->destroyAll();';   
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
/*
Xóa bỏ tích hợp web Google+ (Việc này cần làm do Google đã gỡ bỏ nền tảng Google Plus):
Tìm và xóa các đoạn tương tự như sau trong các file tpl của giao diện

<div class = "g-plusone" data-size = "medium"></div>
Đối với giao diện mặc định chúng tôi kiểm tra nó có ở những file sau:

themes/my_theme/modules/news/detail.tpl
themes/my_theme/modules/page/main.tpl
themes/mobile_my_theme/modules/news/detail.tpl
*/
function updateFileGooglePlus($contents_file)
{
    $status = false;
    $find = '<div class = "g-plusone" data-size = "medium"></div>';
    $replace = 'Xóa dòng code được tìm thấy';
    $pattern = '/<div\s+class\s*=\s*"g-plusone"\s+data-size\s*=\s*"medium"\s*>\s*<\/div>\n*/';
    if (preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $contents_file = preg_replace($pattern,'',$contents_file);
    }
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
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
    $status = false;
    $find = '0 < $(".g-plusone").length && (window.___gcfg = {
        lang: nv_lang_data
    }, function() {
        var a = document.createElement("script");
        a.type = "text/javascript";
        a.async = !0;
        a.src = "//apis.google.com/js/plusone.js";
        var b = document.getElementsByTagName("script")[0];
        b.parentNode.insertBefore(a, b);
    }());';
    $replace = 'Xóa dòng code được tìm thấy';
    $pattern = '/0\s*<\s*\$\("\.g-plusone"\).length[\S\s\n]*?\}\(\)\);/';
    if (preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $contents_file = preg_replace($pattern,'',$contents_file);
    }
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
/*
Nếu website của bạn có tùy biến dữ liệu user với kiểu dữ liệu trình soạn thảo và đang bị lỗi không hiển thị trình soạn thảo, tồn tại file themes/ten_theme/js/users.js thì mở lên tìm
function reg_validForm(a) {
Thêm xuống dưới

    // Xử lý các trình soạn thảo
    if (typeof CKEDITOR !="undefined") {
        for (var instanceName in CKEDITOR.instances) {
            $('#' + instanceName).val(CKEDITOR.instances[instanceName].getData());
        }
    }
*/
function updateFileUsersJs($contents_file)
{
    $status = false;
    $find = 'function reg_validForm(a)';
    $pattern = '/function\s+reg_validForm\(a\)\s*\n*\s*[\s\S]*?CKEDITOR/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $pattern = '/(\s+|\n+)function\s+reg_validForm\s*\(\s*a\s*\)\s*\{/';
        $replace = "\nfunction reg_validForm(a) {";
        $replace .= "\n".str_repeat(" ",4)."if (typeof CKEDITOR !=\"undefined\") {";
        $replace .= "\n".str_repeat(" ",8)."for (var instanceName in CKEDITOR.instances) {";
        $replace .= "\n".str_repeat(" ",12)."$('#' + instanceName).val(CKEDITOR.instances[instanceName].getData());";
        $replace .= "\n".str_repeat(" ",8)."}";
        $replace .= "\n".str_repeat(" ",4)."}\n";
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = 'function reg_validForm(a) {
        // Xử lý các trình soạn thảo
    if (typeof CKEDITOR !="undefined") {
        for (var instanceName in CKEDITOR.instances) {
            $(\'#\' + instanceName).val(CKEDITOR.instances[instanceName].getData());
        }
    }';   
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
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
    $status = false;
    $find = 'window.location.href = location.reload()';
    $pattern = '/window.location.href\s*=\s*location.reload\(\s*\)/';
    $replace = "\n".str_repeat(" ",12)."location.reload()";
    if (preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = 'location.reload()';
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
/*
Nếu giao diện của bạn tồn tại themes/my_theme/modules/contact/form.tpl
Mở form.tpl tìm
<div class = "form-group">
    <label><input type = "checkbox" name = "sendcopy" value = "1" checked = "checked" /><span>{LANG.sendcopy}</span></label>
</div>
Thêm lên trên

        <!-- BEGIN: sendcopy -->
Thêm xuống dưới

        <!-- END: sendcopy -->
*/
function updateFileContactForm($contents_file)
{
    $status = false;
    $find = '<div class = "form-group">
    <label><input type = "checkbox" name = "sendcopy" value = "1" checked = "checked" /><span>{LANG.sendcopy}</span></label>
</div>';
    
    $pattern = '/<!--\s+BEGIN:\s+sendcopy\s+-->/';
    if (!preg_match($pattern,$contents_file,$m)) {
        $status = true;
        $pattern = '/<div\s+class\s*=\s*"\s*form-group\s*">\n*\s*<label>\n*\s*<input\s+type\s*=\s*"checkbox"\s+name\s*=\s*"sendcopy"\s+value\s*=\s*"1"\s+checked\s*=\s*"\s*checked\s*"\s*\/>\n*\s*<span>\n*\s*\{LANG.sendcopy\}\n*\s*<\/span>\n*\s*<\/label>\n*\s*<\/div>/';
        $replace = "<!-- BEGIN: sendcopy -->";
        $replace .= "\n".str_repeat(" ",8)."<div class = \"form-group\">";
        $replace .= "\n".str_repeat(" ",12)."<label><input type = \"checkbox\" name = \"sendcopy\" value = \"1\" checked = \"checked\" /><span>{LANG.sendcopy}</span></label>";
        $replace .= "\n".str_repeat(" ",8)."</div>";
        $replace .= "\n".str_repeat(" ",8)."<!-- END: sendcopy -->";
        $contents_file = preg_replace($pattern,$replace,$contents_file);
    }
    $replace = "<!-- BEGIN: sendcopy -->\n<div class = \"form-group\">
    <label><input type = \"checkbox\" name = \"sendcopy\" value = \"1\" checked = \"checked\" /><span>{LANG.sendcopy}</span></label>
</div>\n<!-- END: sendcopy -->";   
    return array(
        'content'=>$contents_file,
        'status'=>$status,
        'find'=>$find,
        'replace'=>$replace
    );
}
function updateResult($file,$key,$output_data,$contents_file,$item_type = 'php')
{
    if (empty($key)) return false;
    nv_get_update_result($key);
    nvUpdateContructItem($key, $item_type);
    if ($output_data['status'] && $output_data['content'] != $contents_file) {
        nvUpdateSetItemData($key, array(
            'status' => 1,
            'find' => $output_data['find'],
            'replace' => $output_data['replace']
        ));
        file_put_contents($file, $output_data['content'], LOCK_EX);
    }
    else {
        nvUpdateSetItemGuide($key, array(
            'find' => $output_data['find'],
            'replace' => $output_data['replace']
        ));
    }
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

$my_head .=  '<link href = "' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/styles/github.css" rel = "stylesheet">';
$my_head .=  '<script src = "' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js"></script>';
$my_head .=  '<script>hljs.initHighlightingOnLoad();</script>';

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
    $array_update_result['header'] = array(
        'title' => 'Chuyển breadcrumb từ vocabulary sang schema.org', 
        'note' => 'Chỉ ở file: themes/theme-cua-ban/layout/header_extended.tpl', 
        'files' => array()
    );
    $array_update_result['theme'] = array(
        'title' => 'Chỉnh sửa ở file theme.php', 
        'note' => 'Chỉ ở file: themes/theme-cua-ban/theme.php', 
        'files' => array()
    );
    $array_update_result['news'] = array(
        'title' => 'Sửa Review snippet module news', 
        'note' => 'Chỉ ở file: themes/theme-cua-ban/modules/news/detail.tpl', 
        'files' => array()
    );
    $array_update_result['page'] = array(
        'title' => 'Thêm cấu hình số ký tự tiêu đề, giới thiệu, hiển thị ảnh cho global.page.php', 
        'note' => "Việc sửa này không bắt buộc, nếu không sửa thì các cấu hình của block chỉ không hiển thị hình ảnh minh họa.
        \nChỉ ở file: themes/my_theme/modules/page/block.about.tpl", 
        'files' => array()
    );
    $array_update_result['users'] = array(
        'title' => 'Sửa lỗi giao diện block global.login.php và global.user_button.php', 
        'note' => "Chỉ ở file: themes/ten-theme/modules/users/block.login.tpl\ntheme/modules/users/block.user_button.tpl", 
        'files' => array()
    );
    $array_update_result['config'] = array(
        'title' => 'Xóa google fonts khi thay đổi thiết lập giao diện', 
        'note' => "Chỉ ở file: themes/ten-themes/config.php", 
        'files' => array()
    );
    $array_update_result['googleplus'] = array(
        'title' => 'Xóa bỏ tích hợp web Google+ ở file tpl', 
        'note' => "Chỉ ở file: themes/my_theme/modules/news/detail.tpl\nhemes/my_theme/modules/page/main.tpl\nthemes/mobile_my_theme/modules/news/detail.tpl", 
        'files' => array()
    );
    $array_update_result['googleplusjs'] = array(
        'title' => 'Xóa bỏ tích hợp web Google+ ở file js', 
        'note' => "Chỉ ở file: themes/my_theme/js/main.js\nthemes/mobile_my_theme/js/main.js", 
        'files' => array()
    );
    $array_update_result['CKEDITOR'] = array(
        'title' => 'Lỗi không hiển thị trình soạn thảo', 
        'note' => "Chỉ ở file: themes/ten_theme/js/users.js", 
        'files' => array()
    );
    $array_update_result['version4300'] = array(
        'title' => 'Cập nhật ở phiên bản nhỏ hơn 4.3.02', 
        'files' => array()
    );
    foreach ($files as $file) {
        $file_key = md5(strtolower($file));
        if (preg_match('/\/'.$theme_update.'\/layout\/header_extended\.tpl$/',$file,$m)) {
            $key="header";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFileBreadcrumb($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/theme\.php$/',$file,$m)) {
            $key= "theme" ;
            $$item_type = "php";
            $contents_file = file_get_contents($file);
            $output_data = updateFileTheme($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/modules\/news\/detail\.tpl$/',$file,$m)) {
            $key="news";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFileNewsDetail($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/modules\/page\/block.about\.tpl$/',$file,$m)) {
            $key="page";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFilePageBlockAbout($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/modules\/users\/block.login\.tpl$/',$file,$m)) {
            $key="users";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFileUserBlockLogin($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/modules\/users\/block.user_button\.tpl$/',$file,$m)) {
            $key="users";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFileUserBlockLogin($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/modules\/contact\/form\.tpl$/',$file,$m)) {
            $key="version4300";
            $item_type = 'tpl';
            $contents_file = file_get_contents($file);
            $output_data = updateFileContactForm($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/config\.php$/',$file,$m)) {
            $key="config";
            $item_type = 'php';
            $contents_file = file_get_contents($file);
            $output_data = updateFileConfig($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        if (preg_match('/\/'.$theme_update.'\/js\/users\.js$/',$file,$m)) {
            $key="CKEDITOR";
            $item_type = 'js';
            $contents_file = file_get_contents($file);
            $output_data = updateFileUsersJs($contents_file);
            updateResult($file,$key,$output_data,$contents_file, $item_type);
        }
        
        if (preg_match('/\.tpl$/',$file,$m)) {
            $key="googleplus";
            $contents_file = file_get_contents($file);
            $output_data = updateFileGooglePlus($contents_file);
            if (
                $output_data['status'] 
                || preg_match('\/modules\/news\/detail\.tpl$/',$file,$m)
                || preg_match('\/modules\/page\/main\.tpl$/',$file,$m)
                ) {
                    updateResult($file,$key,$output_data,$contents_file, $item_type);
            }
        }

        if (preg_match('/\.js$/',$file,$m)) {
            $key="googleplusjs";
            $contents_file = file_get_contents($file);
            $output_data = updateFileJsGooglePlus($contents_file);
            if (
                $output_data['status'] 
                || preg_match('/\/js\/main\.js$/',$file,$m)
            ) {
                updateResult($file,$key,$output_data,$contents_file, $item_type);
            }
            
            $key="version4300";
            $contents_file = file_get_contents($file);
            $output_data = updateFileJsReload($contents_file);
            if (
                $output_data['status'] 
                || preg_match('/\/js\/main\.js$/',$file,$m)
            ) {
                updateResult($file,$key,$output_data,$contents_file, $item_type);
            }
        }
    }
    // exit();
    //=====================================
    $storage_file = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $op . '.htm';

    $xtpl->assign('NUM_SECTION_AUTO', number_format($num_section_auto, 0, ',', '.'));
    $xtpl->assign('NUM_SECTION_MANUAL', number_format($num_section_manual, 0, ',', '.'));
    $xtpl->assign('FILE_STORAGE', NV_BASE_SITEURL . $storage_file);

    foreach ($array_update_result as $result) {
        $xtpl->assign('PARA_NAME', $result['title']);

        // Ghi chú cập nhật cho đoạn
        if (!empty($result['note'])) {
            $xtpl->assign('PARA_NOTE', $result['note']);
            $xtpl->parse('main.result.loop.note');
        }

        if (empty($result['files'])) {
            $xtpl->parse('main.result.loop.empty');
        } else {
            foreach ($result['files'] as $fileData) {
                $xtpl->assign('FILE_NAME', $fileData['name']);

                foreach ($fileData['data'] as $section) {
                    $section['find'] = nv_htmlspecialchars(str_replace(array("\t"), array("    "), $section['find']));
                    $section['replace'] = nv_htmlspecialchars(str_replace(array("\t"), array("    "), $section['replace']));

                    $xtpl->assign('SECTION', $section);

                    if (!empty($section['status'])) {
                        $xtpl->parse('main.result.loop.data.loop.section.is_auto');
                    } else {
                        $guide = $section['guide'];
                        $guide['find'] = !empty($guide['find']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['find']))) : '';
                        $guide['replace'] = !empty($guide['replace']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['replace']))) : '';
                        $guide['addbefore'] = !empty($guide['addbefore']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['addbefore']))) : '';
                        $guide['addafter'] = !empty($guide['addafter']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['addafter']))) : '';
                        $guide['delinline'] = !empty($guide['delinline']) ? nv_htmlspecialchars(preg_replace("/^\n(.*?)                    $/is", "\\1", str_replace(array("\t"), array("    "), $guide['delinline']))) : '';
                        $guide['findMessage'] = !empty($guide['findMessage']) ? $guide['findMessage'] : 'Tìm';
                        $guide['replaceMessage'] = !empty($guide['replaceMessage']) ? $guide['replaceMessage'] : 'Thay bằng';
                        $guide['addbeforeMessage'] = !empty($guide['addbeforeMessage']) ? $guide['addbeforeMessage'] : 'Thêm lên trên';
                        $guide['addafterMessage'] = !empty($guide['addafterMessage']) ? $guide['addafterMessage'] : 'Thêm xuống dưới';
                        $guide['delinlineMessage'] = !empty($guide['delinlineMessage']) ? $guide['delinlineMessage'] : 'Trong đoạn đó xóa';

                        $xtpl->assign('GUIDE', $guide);

                        if (!empty($guide['find'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.find');
                        }
                        if (!empty($guide['replace'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.replace');
                        }
                        if (!empty($guide['addbefore'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.addbefore');
                        }
                        if (!empty($guide['delinline'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.delinline');
                        }
                        if (!empty($guide['addafter'])) {
                            $xtpl->parse('main.result.loop.data.loop.section.no_auto.addafter');
                        }

                        $xtpl->parse('main.result.loop.data.loop.section.no_auto');
                    }

                    $xtpl->parse('main.result.loop.data.loop.section');
                }

                $xtpl->parse('main.result.loop.data.loop');
            }

            $xtpl->parse('main.result.loop.data');
        }

        $xtpl->parse('main.result.loop');
    }

    $xtpl->parse('main.result');

    if (file_exists(NV_ROOTDIR . '/' . $storage_file)) {
        nv_deletefile(NV_ROOTDIR . '/' . $storage_file);
    }

    $xtpl1 = new XTemplate('save.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl1->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl1->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
    $xtpl1->assign('CONTENTS', $xtpl->text('main.result'));

    $xtpl1->parse('main');
    $file_text = $xtpl1->text('main');

    file_put_contents(NV_ROOTDIR . '/' . $storage_file, $file_text, LOCK_EX);
    
} else {
    $xtpl->parse('main.form');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
