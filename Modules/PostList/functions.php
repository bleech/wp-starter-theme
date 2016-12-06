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
  $data['posts'] = array_map(function($post) {
    $tags = get_the_tags($post->ID);
    if($tags) {
      $tags = array_map(function($tag) {
        return [
          'name' => $tag->name,
          'url' => get_tag_link($tag->term_id)
        ];
      }, $tags);
    }
    $categories = get_the_category($post->ID);
    if($categories) {
      $categories = array_map(function($cat) {
        return [
          'name' => $cat->name,
          'url' => get_category_link($cat->term_id)
        ];
      }, $categories);
    }
    $postImage = get_field('thumbnail', $post->ID);
    $postImage['imageConfig'] = [
      'default' => 'wpsPostListLg',
      'sizes' => [
        'wpsPostListSm' => '(max-width: 767px)'
      ]
    ];

    return [
      'title' => $post->title,
      'content' => get_field('excerpt', $post->ID),
      'image' => $postImage,
      'url' => $post->url,
      'tags' => $tags,
      'categories' => $categories
    ];
  }, $data['posts']);

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
});
