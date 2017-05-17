<?php

namespace Flynt\Features\TinyMce;

use Flynt\Utils\Feature;
use Flynt\Utils\Asset;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        $toolbars = $config['toolbars'];
        if (isset($toolbars['default']) && isset($toolbars['default'][0])) {
            return $toolbars['default'][0];
        }
    }
    return $buttons;
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    $config = getConfig();
    if ($config) {
        if (isset($config['blockstyles'])) {
            $init['block_formats'] = getBlockFormats($config['blockstyles']);
        }

        if (isset($config['styleformats'])) {
            // Get contents as JSON string first and convert it to array (in getConfig call) for sending it to style_formats as true js array
            $init['style_formats'] = json_encode($config['styleformats']);
        }
    }

    return $init;
});

// TODO: refactor this
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        $toolbarsFromFile = $config['toolbars'];
        if (!empty($toolbarsFromFile)) {
            $toolbars = [];
            foreach ($toolbars as $name => $toolbar) {
                array_unshift($toolbar, []);
                $toolbars[$name] = $toolbar;
            }
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

// TODO: refactor this using php array functions
function getBlockFormats($blockstyles)
{
    if (!empty($blockstyles)) {
        $blockstylesQueries = [];
        foreach ($blockstyles as $label => $tag) {
            $blockstylesQueries[] = $label . '=' . $tag;
        }
        return implode(';', $blockstylesQueries);
    }
    return '';
}
