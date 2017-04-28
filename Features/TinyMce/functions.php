<?php

namespace Flynt\Features\TinyMce;

// Clean Up TinyMCE Buttons

// First Bar
add_filter('mce_buttons', function ($buttons) {
    return [
    'formatselect',
    // 'styleselect',
    'bold',
    'italic',
    'underline',
    'strikethrough',
    '|',
    'bullist',
    'numlist',
    '|',
    // 'outdent',
    // 'indent',
    // 'blockquote',
    // 'hr',
    // '|',
    // 'alignleft',
    // 'aligncenter',
    // 'alignright',
    // 'alignjustify',
    // '|',
    'link',
    'unlink',
    '|',
    // 'forecolor',
    'wp_more',
    // 'charmap',
    // 'spellchecker',
    'pastetext',
    'removeformat',
    '|',
    'undo',
    'redo',
    // 'wp_help',
    'fullscreen',
    // 'wp_adv', // toggle visibility of 2 menu level
    ];
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
    return [];
});

add_filter('tiny_mce_before_init', function ($init) {
    // Add block format elements you want to show in dropdown
    $init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    
    // Load Styleformat Dropdown and parse it into TinyMCE
    $filePath = get_template_directory() . '/Features/TinyMce/styleformats.json';
    if (file_exists($filePath)) {
        $loadedStyle = file_get_contents($filePath);
        $init['style_formats'] = $loadedStyle;
    }
    return $init;
});

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE
    $filePath = get_template_directory() . '/Features/TinyMce/toolbars.json';
    if (file_exists($filePath)) {
        $loadedToolbars = json_decode(file_get_contents($filePath), true);
        foreach ($loadedToolbars as $name => $toolbar) {
            array_unshift($toolbar, []);
            $toolbars[$name] = $toolbar;
        }
    }

    return $toolbars;
});