<?php

namespace Flynt\Features\TinyMce;

use Flynt\Utils\Feature;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
    $toolbarsFromFile = getToolbarsFromJson();
    return $toolbarsFromFile['Default'];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    
    // Load Styleformat Dropdown and parse it into TinyMCE
    $options = Feature::getOptions('flynt-tiny-mce');
    if (isset($options[0]) && isset($options[0]['styleformatsConfigPath'])) {
        $configPath = $options[0]['styleformatsConfigPath'];
    } else {
        $configPath = 'config/toolbars.json';
    }

    $filePath = get_template_directory() . '/Features/TinyMce/' . $configPath;
    if (file_exists($filePath)) {
        $loadedStyle = file_get_contents($filePath);
        $init['style_formats'] = $loadedStyle;
    }
    return $init;
});

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $toolbarsFromFile = getToolbarsFromJson();
    if ($toolbarsFromFile) {
        $toolbars = [];
        foreach ($toolbars as $name => $toolbar) {
            array_unshift($toolbar, []);
            $toolbars[$name] = $toolbar;
        }
    }

    return $toolbars;
});

function getToolbarsFromJson()
{
    $options = Feature::getOptions('flynt-tiny-mce');
    if (isset($options[0]) && isset($options[0]['toolbarsConfigPath'])) {
        $configPath = $options[0]['toolbarsConfigPath'];
    } else {
        $configPath = 'config/toolbars.json';
    }

    $filePath = get_template_directory() . '/Features/TinyMce/' . $configPath;
    if (file_exists($filePath)) {
        return json_decode(file_get_contents($filePath), true);
    } else {
        return false;
    }
}
