<?php
namespace WPStarterTheme\Modules\ImageHero;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_image_size('wpsPostListLg', 200, 200, true);
add_image_size('wpsPostListSm', 768, 768, true);

add_filter('WPStarter/modifyModuleData?name=PostList', function ($data, $parentData) {
  $data['readMoreTitle'] = 'Read more';

  $data['posts'] = array_map(function ($post) {
    $tags = get_the_tags($post['ID']);
    if ($tags) {
      $tags = array_map(function ($tag) {
        return [
          'name' => $tag->name,
          // @codingStandardsIgnoreLine
          'url' => get_tag_link($tag->term_id)
        ];
      }, $tags);
    }
    $categories = get_the_category($post['ID']);
    if ($categories) {
      $categories = array_map(function ($cat) {
        return [
          'name' => $cat->name,
          // @codingStandardsIgnoreLine
          'url' => get_category_link($cat->term_id)
        ];
      }, $categories);
    }
    $postImage = get_field('thumbnail', $post['ID']);
    $postImage['imageConfig'] = [
      'default' => 'wpsPostListLg',
      'sizes' => [
        'wpsPostListSm' => '(max-width: 767px)'
      ]
    ];

    return [
      'title' => $post['post_title'],
      'content' => get_field('excerpt', $post['ID']),
      'image' => $postImage,
      'url' => $post['post_url'],
      'tags' => $tags,
      'categories' => $categories
    ];
  }, $parentData['posts']);

  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
});
