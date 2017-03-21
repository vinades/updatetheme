<!-- BEGIN: main -->
<!-- BEGIN: form -->
<div class="alert alert-info">Hệ thống phát hiện giao diện có giao diện <strong>{THEMEUPDATE}</strong>. Nhấp vào nút bên dưới để cập nhật ngay giao diện này từ 4.0.29 lên 4.1.00</div>
<form method="post" action="" class="margin-bottom-lg">
    <input type="hidden" name="submit" value="1"/>
    <input type="submit" value="CẬP NHẬT GIAO DIỆN {THEMEUPDATE}" class="btn btn-primary btn-lg btn-block btn-submitupdate"/>
</form>
<script type="text/javascript">
$(function() {
    $('.btn-block btn-submitupdate').click(function() {
        $(this).prop('disabled', true);
    });
});
</script>
<!-- END: form -->

<!-- BEGIN: result -->
<div class="alert alert-success">Tự động cập nhật giao diện thành công, dưới đây là các thông tin cần chú ý.</div>

<h1>Chỉnh sửa tương thích jquery 3</h1>

<!-- BEGIN: empty_jquery_compality -->
<div class="alert alert-info">Không có file nào cần cập nhật tương thích</div>
<!-- END: empty_jquery_compality -->

<!-- BEGIN: jquery_compality -->
<p>Các file đã tự động sửa để tương thích</p>
<ul class="list-group">
    <!-- BEGIN: loop --><li class="list-group-item">{FILE}</li><!-- END: loop -->
</ul>
<!-- END: jquery_compality -->

<h1>Chỉnh sửa file theme.php</h1>

<!-- BEGIN: rewrite_theme_auto -->
<p>Hệ thống đã tự động cập nhật tương thích</p>
<!-- END: rewrite_theme_auto -->

<!-- BEGIN: rewrite_theme_manual -->
<p>Hệ thống không tìm thấy quy luật để tự cập nhật tương thích, bạn cần mở file <strong>{NV_TEMP_DIR}/theme-update/{THEMEUPDATE}/theme.php</strong> lên và sửa như sau:</p>
<p>
Tìm
<pre>
<code class="language-php">
    global $home, $array_mod_title, $lang_global, $language_array
</code>
</pre>
Trong dòng đó thêm vào cuối trước dấu <code>;</code>
<pre>
<code class="language-php">
, $rewrite_keys
</code>
</pre>
</p>
<p>
Tìm
<pre>
<code class="language-php">
$xtpl-&gt;assign('THEME_SEARCH_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;amp;' . NV_NAME_VARIABLE . '=seek&amp;q=');
</code>
</pre>
Thay lại thành
<pre>
<code class="language-php">

if (empty($rewrite_keys)) {
    $xtpl-&gt;assign('THEME_SEARCH_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;amp;' . NV_NAME_VARIABLE . '=seek&amp;amp;q=');
} else {
    $xtpl-&gt;assign('THEME_SEARCH_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;amp;' . NV_NAME_VARIABLE . '=seek', true) . '?q=');
}
</code>
</pre>
</p>
<!-- END: rewrite_theme_manual -->

<!-- BEGIN: voting -->
<h1>Cập nhật giao diện module voting</h1>

<h2>Cập nhật main.tpl</h2>

<!-- BEGIN: voting_main_auto -->
<p>Hệ thống đã tự động cập nhật tương thích</p>
<!-- END: voting_main_auto -->

<!-- BEGIN: voting_main_manual -->
<p>Hệ thống không tìm thấy quy luật để tự cập nhật tương thích, bạn cần mở file <strong>{NV_TEMP_DIR}/theme-update/{THEMEUPDATE}/modules/voting/main.tpl</strong> lên và sửa như sau:</p>
<p>
Tìm
<pre>
<code class="language-html">
&lt;!-- END: loop --&gt;
&lt;!-- END: main --&gt;
</code>
</pre>
Thêm lên trên
<pre>
<code class="language-html">
&lt;!-- BEGIN: captcha --&gt;
&lt;div id=&quot;voting-modal-&lcub;VOTING.vid&rcub;&quot; class=&quot;hidden&quot;&gt;
    &lt;div class=&quot;m-bottom&quot;&gt;
        &lt;strong&gt;&lcub;LANG.enter_captcha&rcub;&lt;/strong&gt;
    &lt;/div&gt;
    &lt;div class=&quot;clearfix&quot;&gt;
        &lt;div class=&quot;margin-bottom&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-xs-12&quot;&gt;
                    &lt;input type=&quot;text&quot; class=&quot;form-control rsec&quot; value=&quot;&quot; name=&quot;captcha&quot; maxlength=&quot;&lcub;GFX_MAXLENGTH&rcub;&quot;/&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-xs-12&quot;&gt;
                    &lt;img class=&quot;captchaImg display-inline-block&quot; src=&quot;&lcub;SRC_CAPTCHA&rcub;&quot; height=&quot;32&quot; alt=&quot;&lcub;N_CAPTCHA&rcub;&quot; title=&quot;&lcub;N_CAPTCHA&rcub;&quot; /&gt;
    				&lt;em class=&quot;fa fa-pointer fa-refresh margin-left margin-right&quot; title=&quot;&lcub;CAPTCHA_REFRESH&rcub;&quot; onclick=&quot;change_captcha('.rsec');&quot;&gt;&lt;/em&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;input type=&quot;button&quot; name=&quot;submit&quot; class=&quot;btn btn-primary btn-block&quot; value=&quot;&lcub;VOTING.langsubmit&rcub;&quot; onclick=&quot;nv_sendvoting_captcha(this, &lcub;VOTING.vid&rcub;, '&lcub;LANG.enter_captcha_error&rcub;');&quot;/&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;!-- END: captcha --&gt;
</code>
</pre>
</p>
<!-- END: voting_main_manual -->

<h2>Cập nhật global.voting.tpl</h2>

<!-- BEGIN: voting_block_auto -->
<p>Hệ thống đã tự động cập nhật tương thích</p>
<!-- END: voting_block_auto -->

<!-- BEGIN: voting_block_manual -->
<p>Hệ thống không tìm thấy quy luật để tự cập nhật tương thích, bạn cần mở file <strong>{NV_TEMP_DIR}/theme-update/{THEMEUPDATE}/modules/voting/global.voting.tpl</strong> lên và sửa như sau:</p>
<p>
Tìm
<pre>
<code class="language-html">
&lt;input class=&quot;btn btn-success btn-sm&quot; type=&quot;button&quot; value=&quot;&lcub;VOTING.langsubmit&rcub;&quot; onclick=&quot;nv_sendvoting(this.form, '&lcub;VOTING.vid&rcub;', '&lcub;VOTING.accept&rcub;', '&lcub;VOTING.checkss&rcub;', '&lcub;VOTING.errsm&rcub;');&quot; /&gt;
&lt;input class=&quot;btn btn-primary btn-sm&quot; value=&quot;&lcub;VOTING.langresult&rcub;&quot; type=&quot;button&quot; onclick=&quot;nv_sendvoting(this.form, '&lcub;VOTING.vid&rcub;', 0, '&lcub;VOTING.checkss&rcub;', '');&quot; /&gt;
</code>
</pre>
Thay lại thành
<pre>
<code class="language-html">
&lt;input class=&quot;btn btn-success btn-sm&quot; type=&quot;button&quot; value=&quot;&lcub;VOTING.langsubmit&rcub;&quot; onclick=&quot;nv_sendvoting(this.form, '&lcub;VOTING.vid&rcub;', '&lcub;VOTING.accept&rcub;', '&lcub;VOTING.checkss&rcub;', '&lcub;VOTING.errsm&rcub;', '&lcub;VOTING.active_captcha&rcub;');&quot; /&gt;
&lt;input class=&quot;btn btn-primary btn-sm&quot; value=&quot;&lcub;VOTING.langresult&rcub;&quot; type=&quot;button&quot; onclick=&quot;nv_sendvoting(this.form, '&lcub;VOTING.vid&rcub;', 0, '&lcub;VOTING.checkss&rcub;', '', '&lcub;VOTING.active_captcha&rcub;');&quot; /&gt;
</code>
</pre>
</p>
<p>
Tìm
<pre>
<code class="language-html">
&lt;!-- END: main --&gt;
</code>
</pre>
Thêm lên trên
<pre>
<code class="language-html">
&lt;!-- BEGIN: captcha --&gt;
&lt;div id=&quot;voting-modal-&lcub;VOTING.vid&rcub;&quot; class=&quot;hidden&quot;&gt;
    &lt;div class=&quot;m-bottom&quot;&gt;
        &lt;strong&gt;&lcub;LANG.enter_captcha&rcub;&lt;/strong&gt;
    &lt;/div&gt;
    &lt;div class=&quot;clearfix&quot;&gt;
        &lt;div class=&quot;margin-bottom&quot;&gt;
            &lt;div class=&quot;row&quot;&gt;
                &lt;div class=&quot;col-xs-12&quot;&gt;
                    &lt;input type=&quot;text&quot; class=&quot;form-control rsec&quot; value=&quot;&quot; name=&quot;captcha&quot; maxlength=&quot;&lcub;GFX_MAXLENGTH&rcub;&quot;/&gt;
                &lt;/div&gt;
                &lt;div class=&quot;col-xs-12&quot;&gt;
                    &lt;img class=&quot;captchaImg display-inline-block&quot; src=&quot;&lcub;SRC_CAPTCHA&rcub;&quot; height=&quot;32&quot; alt=&quot;&lcub;N_CAPTCHA&rcub;&quot; title=&quot;&lcub;N_CAPTCHA&rcub;&quot; /&gt;
    				&lt;em class=&quot;fa fa-pointer fa-refresh margin-left margin-right&quot; title=&quot;&lcub;CAPTCHA_REFRESH&rcub;&quot; onclick=&quot;change_captcha('.rsec');&quot;&gt;&lt;/em&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/div&gt;
        &lt;input type=&quot;button&quot; name=&quot;submit&quot; class=&quot;btn btn-primary btn-block&quot; value=&quot;&lcub;VOTING.langsubmit&rcub;&quot; onclick=&quot;nv_sendvoting_captcha(this, &lcub;VOTING.vid&rcub;, '&lcub;LANG.enter_captcha_error&rcub;');&quot;/&gt;
    &lt;/div&gt;
&lt;/div&gt;
&lt;!-- END: captcha --&gt;
</code>
</pre>
</p>
<!-- END: voting_block_manual -->

<!-- BEGIN: js -->

<h2>Cập nhật voting.js</h2>

<div class="alert alert-info">
    Bạn cần đối chiếu <strong>{NV_TEMP_DIR}/theme-update/{THEMEUPDATE}/js/voting.js</strong> với <strong>themes/default/js/voting.js</strong> để chỉnh sửa phù hợp với chức năng mới (thêm captcha)
</div>
<!-- END: js -->

<!-- END: voting -->

<!-- BEGIN: news -->
<h1>Cập nhật giao diện module news</h1>

<!-- END: news -->

<!-- BEGIN: users -->
<h1>Cập nhật giao diện module users</h1>

<!-- END: users -->

<!-- END: result -->
<!-- END: main -->