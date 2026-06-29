/**
 * Custom Layout Admin JS
 * - CodeMirror on HTML/CSS/JS fields
 * - File browser that populates ACF text fields
 * - Upload new files to assets/css or assets/js
 */
(function($) {
    'use strict';

    const PATTERNS = {
        html: 'field_custom_layout_html',
        css:  'field_custom_layout_css',
        js:   'field_custom_layout_js',
    };

    const CM_MODES = {
        html: { mode: 'htmlmixed',  lineNumbers: true, autoCloseTags: true, matchBrackets: true, indentUnit: 2, tabSize: 2, lineWrapping: true },
        css:  { mode: 'css',        lineNumbers: true, matchBrackets: true, indentUnit: 2, tabSize: 2, lineWrapping: true },
        js:   { mode: 'javascript', lineNumbers: true, matchBrackets: true, indentUnit: 2, tabSize: 2, lineWrapping: true },
    };

    const initialised = new WeakSet();

    function isClone($el) {
        const name = $el.attr('name') || '';
        const id   = $el.attr('id') || '';
        return name.includes('acfcloneindex') || id.includes('acfcloneindex');
    }

    function initCodeMirror($ta, mode) {
        if (isClone($ta)) return;
        if (initialised.has($ta[0])) return;
        if (!wp || !wp.CodeMirror) return;

        const editor = wp.CodeMirror.fromTextArea($ta[0], {
            ...CM_MODES[mode],
            theme: 'default',
        });

        editor.on('change', () => $ta.val(editor.getValue()));
        initialised.add($ta[0]);
        setTimeout(() => editor.refresh(), 200);
    }

    function initAllEditors() {
        $('textarea').each(function() {
            const $ta = $(this);
            if (isClone($ta)) return;
            const name = $ta.attr('name') || '';
            const id   = $ta.attr('id') || '';

            if (name.includes(PATTERNS.html) || id.includes(PATTERNS.html)) {
                initCodeMirror($ta, 'html');
            } else if (name.includes(PATTERNS.css) || id.includes(PATTERNS.css)) {
                initCodeMirror($ta, 'css');
            } else if (name.includes(PATTERNS.js) || id.includes(PATTERNS.js)) {
                initCodeMirror($ta, 'js');
            }
        });
    }

    // ── File browser ─────────────────────────────────────────

    const fileCache = { css: null, js: null };

    function getFileList(type, callback) {
        if (fileCache[type]) { callback(fileCache[type]); return; }
        $.post(acfVipCodeEditor.ajaxUrl, {
            action: 'techark_get_asset_files',
            nonce:  acfVipCodeEditor.nonce,
            type:   type,
        }, function(r) {
            if (r.success) {
                fileCache[type] = r.data.files || [];
                callback(fileCache[type]);
            }
        });
    }

    function buildFileBrowsers() {
        $('[data-layout="custom_layout"]').each(function() {
            const $layout = $(this);
            if ($layout.closest('[data-name="acfcloneindex"]').length) return;
            if ($layout.find('.acf-vip-file-browser').length) return;

            // Find ACF input fields by placeholder text
            const $cssInput = $layout.find('input').filter(function() {
                return ($(this).attr('placeholder') || '').includes('owl.carousel.min.css');
            });
            const $jsInput = $layout.find('input').filter(function() {
                return ($(this).attr('placeholder') || '').includes('owl.carousel.min.js');
            });

            if (!$cssInput.length) return;

            const $browser = $('<div class="acf-vip-file-browser"></div>');

            ['css', 'js'].forEach(type => {
                const $acfInput = type === 'css' ? $cssInput : $jsInput;

                const $row = $(`
                    <div class="acf-vip-asset-row">
                        <label class="acf-vip-asset-label">${type.toUpperCase()} File</label>
                        <select class="acf-vip-file-select">
                            <option value="">— Select from assets/${type}/ —</option>
                        </select>
                        <label class="acf-vip-upload-btn button button-small">
                            ↑ Upload .${type}
                            <input type="file" accept=".${type}" style="display:none">
                        </label>
                        <span class="acf-vip-upload-status"></span>
                    </div>
                `);

                const $select   = $row.find('select');
                const $status   = $row.find('.acf-vip-upload-status');
                const $fileIn   = $row.find('input[type="file"]');

                // Load files
                getFileList(type, files => {
                    files.forEach(f => $select.append(`<option value="${f}">${f}</option>`));
                    if ($acfInput.val()) $select.val($acfInput.val());
                });

                // Sync to ACF field
                $select.on('change', function() {
                    $acfInput.val($(this).val()).trigger('change');
                });

                // Upload
                $fileIn.on('change', function() {
                    const file = this.files[0];
                    if (!file) return;
                    $status.text('Uploading...').css('color', '#666');

                    const fd = new FormData();
                    fd.append('action', 'techark_upload_asset_file');
                    fd.append('nonce',  acfVipCodeEditor.nonce);
                    fd.append('type',   type);
                    fd.append('file',   file);

                    $.ajax({
                        url: acfVipCodeEditor.ajaxUrl,
                        type: 'POST', data: fd,
                        processData: false, contentType: false,
                        success: function(r) {
                            if (r.success) {
                                const fn = r.data.filename;
                                $status.text('✓ ' + fn).css('color', '#46b450');
                                fileCache[type] = null;
                                getFileList(type, files => {
                                    $select.empty().append(`<option value="">— Select —</option>`);
                                    files.forEach(f => $select.append(`<option value="${f}">${f}</option>`));
                                    $select.val(fn).trigger('change');
                                });
                            } else {
                                $status.text('✗ ' + r.data).css('color', '#dc3232');
                            }
                        },
                        error: () => $status.text('✗ Failed').css('color', '#dc3232'),
                    });
                });

                $browser.append($row);
            });

            // Insert browser AFTER the CSS File ACF field row — inside the same visible container
            const $cssFieldRow = $cssInput.closest('.acf-field');
            $cssFieldRow.after($browser);
        });
    }

    // ── Boot ─────────────────────────────────────────────────

    function initAll() {
        initAllEditors();
        buildFileBrowsers();
    }

    $(document).ready(function() {
        setTimeout(initAll, 800);
        acf.addAction('append', function($el) {
            setTimeout(function() {
                initAllEditors();
                buildFileBrowsers();
            }, 400);
        });
    });

})(jQuery);
