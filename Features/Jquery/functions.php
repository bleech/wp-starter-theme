<?php

namespace Flynt\Features\Jquery;

use Flynt\Utils\Asset;
use Flynt\Utils\Feature;

add_action('wp_enqueue_scripts', function () {
    $options = Feature::getOption('flynt-jquery', 0);
    $jqueryVersion = wp_scripts()->registered['jquery']->ver;
    wp_deregister_script('jquery');
    if (isset($options['cdn']) && true === $options['cdn']) {
        // load jQuery from Google CDN, falling back to local WordPress-bundled file
        $jqueryLocalUrl = esc_url(includes_url("/js/jquery/jquery.js?ver=${jqueryVersion}"));
        wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/${jqueryVersion}/jquery.min.js", false, null, true);
        wp_add_inline_script('jquery', "window.jQuery||document.write(\"<script src=\\\"${jqueryLocalUrl}\\\"><\/script>\")");
    } else {
        // make sure jQuery loads in footer by default
        $jqueryLocalUrl = includes_url('/js/jquery/jquery.js');
        wp_register_script('jquery', $jqueryLocalUrl, false, $jqueryVersion, true);
    }
});
