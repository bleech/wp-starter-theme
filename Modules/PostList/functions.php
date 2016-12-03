<?php

add_filter('WPStarter/modifyModuleData?name=PostList', function ($data) {
  $data['posts'] = apply_filters('WPStarterTheme/DataFilters/Posts', [], 5, 'long');
  $data['posts'] = [
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/100x100',
      'content' => 'This is a short excerpt for this post we should use have in here'
    ],
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/100x100',
      'content' => 'This is a short excerpt for this post we should use have in here'
    ],
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/100x100',
      'content' => 'This is a short excerpt for this post we should use have in here'
    ],
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/100x100',
      'content' => 'This is a short excerpt for this post we should use have in here'
    ],
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/100x100',
      'content' => 'This is a short excerpt for this post we should use have in here'
    ]
  ];

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
}
