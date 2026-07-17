<?php

/**
 * Rabbit Editor - markdown_v1 content-format handlers.
 * Registered via se_register_editor() in global/index.php.
 */

function rabbit_render_frontend(mixed $content): string {
    if (!is_string($content) || $content === '') {
        return '';
    }
    $parsedown = new Parsedown();
    return $parsedown->text($content);
}

function rabbit_render_backend(mixed $content): mixed {
    return is_string($content) ? $content : '';
}
