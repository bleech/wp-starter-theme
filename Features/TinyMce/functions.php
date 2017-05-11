<?php

namespace Flynt\Features\TinyMce;

use Flynt\Utils\Feature;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
    $toolbarsFromFile = getToolbarsFromJson();
    return $toolbarsFromFile['Default'][0];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    $options = Feature::getOptions('flynt-tiny-mce');

    if (isset($options[0]) && isset($options[0]['blockformatsConfigPath'])) {
        $configPath = $options[0]['blockformatsConfigPath'];
    } else {
        $configPath = 'config/blockformats.json';
    }

    $filePath = get_template_directory() . '/Features/TinyMce/' . $configPath;
    if (file_exists($filePath)) {
        $blockstyles = json_decode(file_get_contents($filePath), true);
        $blockstylesQueries = [];
        foreach ($blockstyles as $label => $tag) {
            $blockstylesQueries[] = $label . '=' . $tag;
        }
        $init['block_formats'] = implode(';', $blockstylesQueries);
    } else {
        $init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    }
    
    // Load Styleformat Dropdown and parse it into TinyMCE
    
    if (isset($options[0]) && isset($options[0]['styleformatsConfigPath'])) {
        $configPath = $options[0]['styleformatsConfigPath'];
    } else {
        $configPath = 'config/toolbars.json';
    }

    $filePath = get_template_directory() . '/Features/TinyMce/' . $configPath;
    if (file_exists($filePath)) {
        // Get contents as JSON string first and convert it to array for sending it to style_formats as true js array
        $loadedStyle = json_decode(file_get_contents($filePath), true);
        $init['style_formats'] = json_encode($loadedStyle);
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
