<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;
use Timber\Menu;
use Flynt\Features\Acf\OptionPages;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationMain');
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;
    $data['siteTitle'] = get_bloginfo('name');
    return $data;
});
