<?php

namespace Flynt\Components\AccordionVertical;

use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('AccordionVertical');
});

add_filter('Flynt/addComponentData?name=AccordionVertical', function ($data) {
    $data['toggleIconSrc'] = Asset::requireUrl('Components/AccordionVertical/assets/toggleIcon.svg');
    return $data;
});
