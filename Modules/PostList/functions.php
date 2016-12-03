<?php
namespace WPStarterTheme\Modules\ImageHero;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_image_size('wpsPostListLg', 200, 200, true);
add_image_size('wpsPostListSm', 768, 768, true);

add_filter('WPStarter/modifyModuleData?name=PostList', function ($data) {
  $data['readMoreTitle'] = 'Read more';
  
  $data['posts'] = apply_filters('WPStarterTheme/DataFilters/Posts', [], 5, 'long');
  $data['posts'] = [
    [
      'title' => '1 Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/768x768',
      'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
      'tags' => [
        [
          'name' => 'News',
          'url' => '#'
        ],
        [
          'name' => 'Info',
          'url' => '#'
        ]
      ],
      'categories' => [
        [
          'name' => 'A Category',
          'url' => '#'
        ],
        [
          'name' => 'A Category',
          'url' => '#'
        ]
      ]
    ],
    [
      'title' => '2 Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/768x768',
      'content' => 'This is a short excerpt for this post we should use have in here',
      'tags' => [
        [
          'name' => 'News',
          'url' => '#'
        ],
        [
          'name' => 'Info',
          'url' => '#'
        ]
      ],
      'categories' => [
        [
          'name' => 'A Category',
          'url' => '#'
        ],
        [
          'name' => 'A Category',
          'url' => '#'
        ]
      ]
    ],
    [
      'title' => '3 Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/768x768',
      'content' => 'This is a short excerpt for this post we should use have in here',
      'tags' => [
        [
          'name' => 'News',
          'url' => '#'
        ],
        [
          'name' => 'Info',
          'url' => '#'
        ]
      ],
      'categories' => [
        [
          'name' => 'A Category',
          'url' => '#'
        ],
        [
          'name' => 'A Category',
          'url' => '#'
        ]
      ]
    ],
    [
      'title' => '4 Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/768x768',
      'content' => 'This is a short excerpt for this post we should use have in here',
      'tags' => [
        [
          'name' => 'News',
          'url' => '#'
        ],
        [
          'name' => 'Info',
          'url' => '#'
        ]
      ],
      'categories' => [
        [
          'name' => 'A Category',
          'url' => '#'
        ],
        [
          'name' => 'A Category',
          'url' => '#'
        ]
      ]
    ],
    [
      'title' => 'Hello World, this is a demo post',
      'url' => '#',
      'image' => 'http://placehold.it/768x768',
      'content' => 'This is a short excerpt for this post we should use have in here',
      'tags' => [
        [
          'name' => 'News',
          'url' => '#'
        ],
        [
          'name' => 'Info',
          'url' => '#'
        ]
      ],
      'categories' => [
        [
          'name' => 'A Category',
          'url' => '#'
        ],
        [
          'name' => 'A Category',
          'url' => '#'
        ]
      ]
    ]
  ];

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
});
