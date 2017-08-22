<?php

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockStyleguide');
});

add_filter('Flynt/addComponentData?name=BlockStyleguide', function ($data) {
    $data['colors'] = [
        [
            'name' => '$globalColorBackground',
            'hex' => '#fff'
        ],
        [
            'name' => '$globalColorBrand',
            'hex' => '#254fc7'
        ],
        [
            'name' => '$globalColorHeadline',
            'hex' => '#153cab'
        ],
        [
            'name' => '$globalColorText',
            'hex' => '#000'
        ]
    ];

    $data['fonts'] = [
        [
            'name' => '$globalFontPrimary',
            'font' => 'Helvetica, Arial, sans-serif'
        ],
        [
            'name' => '$globalFontSecondary',
            'font' => 'Georgia, Times, serif'
        ]
    ];

    return $data;
});
