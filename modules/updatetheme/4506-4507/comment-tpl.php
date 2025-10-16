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
 * Cập nhật tpl module comment
 */
if (preg_match('/\/main\.tpl$/', $file)) {
    nv_get_update_result('comment');
    nvUpdateContructItem('comment', 'html');

    if (preg_match("/\<\!\-\-[\s]*BEGIN\:[\s]*editor[\s]*\-\-\>(.*?)\<\!\-\-[\s]*END\:[\s]*editor[\s]*\-\-\>/is", $output_data, $m)) {
        $find = $m[0];
        $replace = '<!-- BEGIN: editor -->
                <link rel="stylesheet" href="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/ckeditor.css?t={TIMESTAMP}">
                <script type="text/javascript" src="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/ckeditor.js?t={TIMESTAMP}"></script>
                <script type="text/javascript" src="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/language/{NV_LANG_INTERFACE}.js?t={TIMESTAMP}"></script>
                <script type="text/javascript">
                (async () => {
                    await ClassicEditor
                    .create(document.getElementById("commentcontent"), {
                        language: \'{NV_LANG_INTERFACE}\',
                        removePlugins: ["NVBox"],
                        image: {insert: {integrations: ["url"]}},
                        nvmedia: {insert: {integrations: ["url"]}},
                        toolbar: {
                            items: [
                                \'undo\',
                                \'redo\',
                                \'selectAll\',
                                \'|\',
                                \'link\',
                                \'bookmark\',
                                \'imageInsert\',
                                \'nvmediaInsert\',
                                \'insertTable\',
                                \'nviframeInsert\',
                                \'nvdocsInsert\',
                                \'code\',
                                \'codeBlock\',
                                \'horizontalLine\',
                                \'specialCharacters\',
                                \'pageBreak\',
                                \'|\',
                                \'findAndReplace\',
                                \'showBlocks\',
                                \'|\',
                                \'bulletedList\',
                                \'numberedList\',
                                \'outdent\',
                                \'indent\',
                                \'blockQuote\',
                                \'heading\',
                                \'fontSize\',
                                \'fontFamily\',
                                \'fontColor\',
                                \'fontBackgroundColor\',
                                \'highlight\',
                                \'alignment\',
                                \'|\',
                                \'bold\',
                                \'italic\',
                                \'underline\',
                                \'emoji\',
                                \'strikethrough\',
                                \'subscript\',
                                \'superscript\',
                                \'|\',
                                \'sourceEditing\',
                                \'nvtools\',
                                \'removeFormat\',
                                \'fullscreen\'
                            ],
                            shouldNotGroupWhenFull: false
                        },
                        nukeviet: {
                            editorId: \'commentcontent\'
                        }
                    }).then(editor => {
                        editor.editing.view.document.on(\'keydown\', (event, data) => {
                            if (data.ctrlKey && data.keyCode == 13) {
                                $(\'#formcomment form\').submit();
                            }
                        });
                    }).catch(error => {
                        console.error(error);
                    });
                })();
                </script>
                <!-- END: editor -->';
        $output_data = str_replace($find, $replace, $output_data);

        nvUpdateSetItemData('comment', [
            'status' => 1,
            'find' => $find,
            'replace' => $replace
        ]);
    } else {
        nvUpdateSetItemGuide('comment', [
            'findMessage' => 'Tìm đoạn code này',
            'find' => '<!-- BEGIN: editor --> ... <!-- END: editor -->',
            'replace' => '<!-- BEGIN: editor -->
                <link rel="stylesheet" href="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/ckeditor.css?t={TIMESTAMP}">
                <script type="text/javascript" src="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/ckeditor.js?t={TIMESTAMP}"></script>
                <script type="text/javascript" src="{NV_STATIC_URL}{NV_EDITORSDIR}/ckeditor5-classic/language/{NV_LANG_INTERFACE}.js?t={TIMESTAMP}"></script>
                <script type="text/javascript">
                (async () => {
                    await ClassicEditor
                    .create(document.getElementById("commentcontent"), {
                        language: \'{NV_LANG_INTERFACE}\',
                        removePlugins: ["NVBox"],
                        image: {insert: {integrations: ["url"]}},
                        nvmedia: {insert: {integrations: ["url"]}},
                        toolbar: {
                            items: [
                                \'undo\',
                                \'redo\',
                                \'selectAll\',
                                \'|\',
                                \'link\',
                                \'bookmark\',
                                \'imageInsert\',
                                \'nvmediaInsert\',
                                \'insertTable\',
                                \'nviframeInsert\',
                                \'nvdocsInsert\',
                                \'code\',
                                \'codeBlock\',
                                \'horizontalLine\',
                                \'specialCharacters\',
                                \'pageBreak\',
                                \'|\',
                                \'findAndReplace\',
                                \'showBlocks\',
                                \'|\',
                                \'bulletedList\',
                                \'numberedList\',
                                \'outdent\',
                                \'indent\',
                                \'blockQuote\',
                                \'heading\',
                                \'fontSize\',
                                \'fontFamily\',
                                \'fontColor\',
                                \'fontBackgroundColor\',
                                \'highlight\',
                                \'alignment\',
                                \'|\',
                                \'bold\',
                                \'italic\',
                                \'underline\',
                                \'emoji\',
                                \'strikethrough\',
                                \'subscript\',
                                \'superscript\',
                                \'|\',
                                \'sourceEditing\',
                                \'nvtools\',
                                \'removeFormat\',
                                \'fullscreen\'
                            ],
                            shouldNotGroupWhenFull: false
                        },
                        nukeviet: {
                            editorId: \'commentcontent\'
                        }
                    }).then(editor => {
                        editor.editing.view.document.on(\'keydown\', (event, data) => {
                            if (data.ctrlKey && data.keyCode == 13) {
                                $(\'#formcomment form\').submit();
                            }
                        });
                    }).catch(error => {
                        console.error(error);
                    });
                })();
                </script>
                <!-- END: editor -->'
        ]);
    }
}
