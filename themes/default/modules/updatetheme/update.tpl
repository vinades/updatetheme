<!-- BEGIN: main -->
<!-- BEGIN: form -->
<div class="alert alert-info">Hệ thống phát hiện giao diện có giao diện <strong>{THEMEUPDATE}</strong>. Nhấp vào nút bên dưới để cập nhật ngay giao diện này.</div>
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
<!-- BEGIN: thongke -->
<div class="alert alert-success">
Tự động cập nhật giao diện thành công, dưới đây là các thông tin cần chú ý.<br />
- Tổng số file đã tự động cập nhật: <strong>{NUM_SECTION_AUTO}</strong><br />
</div>
<div>
    <h2 style="margin:15px 0px; color:#fff; padding:10px; background-color:#428bca"><strong>Các file đã được rửa chữa</strong></h2>
    <!-- BEGIN: file -->
    <div style="border-bottom:1px dashed #000;margin-bottom: 20px;">
        <p><strong>Tên file: </strong>{FILE_NAME}</p>
        <p>Đã đã được sửa bởi các chức năng sau</p>
        <ul>
            <!-- BEGIN: func -->
            <li>{FUNC}</li>
            <!-- END: func -->
        </ul>
    </div>
    <!-- END: file -->
</div>

<!-- END: thongke -->
<!-- BEGIN: result -->
<div class="alert alert-success">
Tự động cập nhật giao diện thành công, dưới đây là các thông tin cần chú ý.<br />
- Tổng số mục đã tự động cập nhật: <strong>{NUM_SECTION_AUTO}</strong><br />
- Tổng số mục cần làm bằng tay: <strong>{NUM_SECTION_MANUAL}</strong><br />
<em>Kết quả này đã được lưu lại trên hệ thống. Bạn có thể tra cứu lại <strong><ins><a href="{FILE_STORAGE}" target="_blank">tại đây</a></ins></strong> nếu cần thiết</em>
</div>

<!-- BEGIN: loop -->
<h1 class="margin-bottom">{PARA_NAME}:</h1>

<!-- BEGIN: note -->
<div class="alert alert-info">{PARA_NOTE}</div>
<!-- END: note -->

<!-- BEGIN: empty -->
<div class="alert alert-info">Giao diện không có phần này</div>
<!-- END: empty -->

<!-- BEGIN: data -->
<!-- BEGIN: loop -->
<h2 class="margin-bottom">Cập nhật {FILE_NAME}:</h2>

<!-- BEGIN: section -->
<div class="panel panel-default">
    <div class="panel-body">
        <!-- BEGIN: is_auto -->
        <blockquote class="m-bottom"><span class="text-success">Tự động cập nhật:</span></blockquote>
        Thay thế:
        <pre><code class="language-{SECTION.type}">{SECTION.find}</code></pre>
        Bằng:
        <pre><code class="language-{SECTION.type}">{SECTION.replace}</code></pre>
        <!-- END: is_auto -->
        <!-- BEGIN: no_auto -->
        <blockquote><span class="text-warning">Không thể cập nhật tự động phần này. Hãy xem hướng dẫn cập nhật thủ công sau:</span></blockquote>
        <!-- BEGIN: find -->
        {GUIDE.findMessage}:
        <pre><code class="language-{SECTION.type}">{GUIDE.find}</code></pre>
        <!-- END: find -->
        <!-- BEGIN: delinline -->
        {GUIDE.delinlineMessage}:
        <pre><code class="language-{SECTION.type}">{GUIDE.delinline}</code></pre>
        <!-- END: delinline -->
        <!-- BEGIN: replace -->
        {GUIDE.replaceMessage}:
        <pre><code class="language-{SECTION.type}">{GUIDE.replace}</code></pre>
        <!-- END: replace -->
        <!-- BEGIN: addbefore -->
        {GUIDE.addbeforeMessage}:
        <pre><code class="language-{SECTION.type}">{GUIDE.addbefore}</code></pre>
        <!-- END: addbefore -->
        <!-- BEGIN: addafter -->
        {GUIDE.addafterMessage}:
        <pre><code class="language-{SECTION.type}">{GUIDE.addafter}</code></pre>
        <!-- END: addafter -->
        <!-- END: no_auto -->
    </div>
</div>
<!-- END: section -->

<!-- END: loop -->
<!-- END: data -->

<!-- END: loop -->

<!-- END: result -->
<!-- END: main -->