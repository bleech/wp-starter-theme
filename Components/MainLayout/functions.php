<?php
namespace Flynt\Components\MainLayout;

use Timber\Timber;
use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('MainLayout', [
    [
      'name' => 'console-polyfill',
      'type' => 'script',
      'path' => 'vendor/console.js'
    ],
    [
      'name' => 'babel-polyfill',
      'type' => 'script',
      'path' => 'vendor/babel-polyfill.js'
    ],
    [
      'name' => 'document-register-element',
      'type' => 'script',
      'path' => 'vendor/document-register-element.js'
    ],
    [
      'name' => 'picturefill',
      'path' => 'vendor/picturefill.js',
      'type' => 'script'
    ],
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ]
  ]);
});

add_filter('Flynt/addComponentData?name=MainLayout', function ($data) {
  $context = Timber::get_context();
  $context['post'] = Timber::get_post();
  $templateUrl = get_template_directory_uri();

  $data['favicons'] = array_map(function($favicon) {
    return [
      'url' => $favicon['image']->abs_url,
      'size' => $favicon['size'] . 'x' . $favicon['size']
    ];
  }, $data['favicons']);

  $data['touchIcons'] = array_map(function($touchIcon) {
    return [
      'url' => $touchIcon['image']->abs_url,
      'size' => $touchIcon['size'] . 'x' . $touchIcon['size']
    ];
  }, $data['touch_icons']);

  $data['pageUrl'] = get_home_url();

  $data['feedTitle'] = $context['site']->name . ' ' . __('Feed');
  $data['dir'] = is_rtl() ? 'rtl' : 'ltr';

  return array_merge($context, $data);
});
