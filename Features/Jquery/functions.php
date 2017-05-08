<?php

namespace Flynt\Features\Jquery;

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    $jqueryVersion = wp_scripts()->registered['jquery']->ver;
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/' . $jqueryVersion . '/jquery.min.js', false, $jqueryVersion, true);
    wp_add_inline_script('jquery', 'window.jQuery||document.write("<script src=\"' . esc_url(Asset::requireUrl('vendor/jquery.min.js')) . '\"><\/script>")');
});
