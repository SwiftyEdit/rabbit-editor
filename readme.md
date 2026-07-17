# Rabbit Editor Plugin

Markdown content-format editor for SwiftyEdit page content.

Unlike the WYSIWYG/code editor plugins (TinyMCE, ACE), this is a **content-format
editor**: it doesn't just swap the input widget for a `<textarea>`, it defines its
own storage format. When active and selected for a field, the content is stored
as `{"editor": "markdown_v1", "content": "<markdown source>"}` instead of raw
HTML. See `docs/v2/{de,en}/09-02-plugins.md` ("editor" info.json field) for how
content-format editors are registered and rendered.

- Editor id: `markdown_v1`, `mode: "format"` (not `core` - must be activated
  like any other plugin).
- Frontend rendering: Markdown → HTML via Parsedown (`render.php`,
  `rabbit_render_frontend()`).
- Backend editing: an ACE editor instance in `ace/mode/markdown`
  (`backend/init.js.php`) - reuses the ACE editor plugin's already-loaded
  `ace.js`/theme assets, no separate JS dependency or build step of its own.
  Falls back to a plain `<textarea>` if ACE isn't available for some reason.

## Requirements

The `ace-editor` plugin must ship `mode-markdown.js` in its published assets
(`public/assets/editors/ace/`). If missing, add `'mode-markdown.js'` to
`plugins/ace-editor/build.mjs`'s file list and run `npm install && npm run build`
in `plugins/ace-editor/`.

Markdown-to-HTML rendering (`render.php`) requires the `Parsedown` class to be
available (e.g. via SwiftyEdit core or a bundled dependency).

## License

GPL-3.0 — see [license.txt](license.txt).
