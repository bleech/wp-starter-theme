<?php

namespace Flynt\Components\BlockCookieNotification;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockCookieNotification', [
        [
            'type' => 'script',
            'name' => 'js-cookie',
            'path' => 'vendor/js-cookie.js'
        ]
    ]);
});
