<?php

/**
 * Rabbit Editor bootstrap - registers the markdown_v1 content format.
 * Included for every active plugin, both frontend (app/routing.php) and
 * backend (acp/index.php).
 */

require_once __DIR__ . '/../render.php';

se_register_editor('markdown_v1', [
    'render_frontend' => 'rabbit_render_frontend',
    'render_backend' => 'rabbit_render_backend',
]);
