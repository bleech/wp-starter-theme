<?php

namespace Flynt\Features\TinyMce;

use Flynt\Utils\Feature;
use Flynt\Utils\Asset;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
    $toolbars = getToolbars();
    return $toolbars['default'][0];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    $init['block_formats'] = getBlockFormats();
    $init['style_formats'] = getStyleFormats();

    return $init;
});

// TODO: refactor this
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $toolbarsFromFile = getToolbars();
    if ($toolbarsFromFile) {
        $toolbars = [];
        foreach ($toolbars as $name => $toolbar) {
            array_unshift($toolbar, []);
            $toolbars[$name] = $toolbar;
        }
    }

    return $toolbars;
});

function getConfig()
{
    $filePath = Asset::requirePath('/Features/TinyMce/config.json');
    if (file_exists($filePath)) {
        return json_decode(file_get_contents($filePath), true);
    } else {
        return false;
    }
}

function getToolbars() {
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        return $config['toolbars'];
    }
    return [];
}

// TODO: refactor this using php array functions
// TODO: consider removing default return
function getBlockFormats()
{
    $config = getConfig();
    if ($config && isset($config['blockstyles'])) {
        $blockstyles = $config['blockstyles'];
        $blockstylesQueries = [];
        foreach ($blockstyles as $label => $tag) {
            $blockstylesQueries[] = $label . '=' . $tag;
        }
        return implode(';', $blockstylesQueries);
    }
    return 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
}

function getStyleFormats()
{
    $config = getConfig();
    if ($config && isset($config['styleformats'])) {
        // Get contents as JSON string first and convert it to array for sending it to style_formats as true js array
        $loadedStyle = $config['styleformats'];
        return json_encode($loadedStyle);
    }
    return false;
}
