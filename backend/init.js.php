<?php

/**
 * Rabbit Editor plugin - footer init.
 * Registers window.seContentEditors['markdown_v1'] (see acp/index.php's
 * content-editor mount/serialize glue). mount() receives the plugin's own
 * render_backend() payload (a raw markdown string, or null for a fresh page);
 * serialize() returns the current markdown string back to Core, which wraps
 * it in the {"editor":...,"content":...} envelope on save.
 *
 * Uses the ACE editor (ace-editor plugin, always active/core) in markdown
 * mode for syntax highlighting instead of a plain <textarea> - ace.js is
 * already loaded on every ACP page via ace-editor's backend/head.php, so this
 * needs no extra JS dependency. Falls back to a plain textarea if ACE isn't
 * available for some reason, mirroring ace-editor's own `if (window.ace)`
 * guard in its init.js.php.
 *
 * @var array $se_editor_current this editor plugin's info.json "editor" block
 * The `ace_theme` JS global is defined in the ACP <head> (see acp/index.php).
 */

$se_rabbit_id = $se_editor_current['id'] ?? 'markdown_v1';

?>
<script type="text/javascript">
    (function () {
        window.seContentEditors = window.seContentEditors || {};

        window.seContentEditors['<?php echo $se_rabbit_id; ?>'] = {
            mount: function (el, content) {
                var value = typeof content === 'string' ? content : '';

                if (!window.ace) {
                    var textarea = document.createElement('textarea');
                    textarea.className = 'form-control';
                    textarea.rows = 16;
                    textarea.value = value;
                    el.innerHTML = '';
                    el.appendChild(textarea);
                    return;
                }

                var editDiv = document.createElement('div');
                editDiv.className = 'form-control';
                editDiv.style.minHeight = '400px';
                el.innerHTML = '';
                el.appendChild(editDiv);

                var aceEditor = ace.edit(editDiv);
                aceEditor.$blockScrolling = Infinity;
                aceEditor.getSession().setMode('ace/mode/markdown');
                aceEditor.getSession().setValue(value, -1);
                aceEditor.setTheme('ace/theme/' + ace_theme);
                aceEditor.getSession().setUseWorker(false);
                aceEditor.setShowPrintMargin(false);

                el._aceEditor = aceEditor;
            },
            serialize: function (el) {
                if (el._aceEditor) {
                    return el._aceEditor.getValue();
                }
                var textarea = el.querySelector('textarea');
                return textarea ? textarea.value : '';
            }
        };
    })();
</script>
