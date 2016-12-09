<?php
namespace WPStarterTheme\Modules\ImageHero;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_image_size('wpsPostListLg', 200, 200, true);
add_image_size('wpsPostListSm', 768, 768, true);

add_filter('WPStarter/modifyModuleData?name=PostList', function ($data, $parentData) {
  $page = get_query_var('paged');
  $maxPosts = get_field('postsPerPage', 'option');
  $data['queryArgs'] = [
    'post_type' => 'post',
    'posts_per_page' => $maxPosts,
    'paged' => $page
  ];

  if(isset($_GET['category']))
    $data['queryArgs']['cat'] = $_GET['category'];

  if(isset($_GET['tag']))
    $data['queryArgs']['tag_id'] = $_GET['tag'];

  // Use overwriteQueryArgs so you can control the query from outside the module (customData, etc.)
  if (isset($data['overwriteQueryArgs'])) {
    $data['queryArgs'] = array_replace($data['queryArgs'], $data['overwriteQueryArgs']);
  }

  $data['query'] = new \WP_Query($data['queryArgs']);
  $data['posts'] = $data['query']->posts;

  // Check if Posts exists on this page
  if (empty($data['posts'])) {
    wp_redirect('/notfound');
    exit;
  }

  $data['meta'] = [
    'maxNumPages' => $data['query']->max_num_pages,
    'currentPage' => $page
  ];
  $data['readMoreTitle'] = get_field('moreTitle', 'option');

  $data['posts'] = array_map(function ($post) {
    $tags = get_the_tags($post->ID);
    if ($tags) {
      $tags = array_map(function ($tag) {
        return [
          'name' => $tag->name,
          // @codingStandardsIgnoreLine
          'url' => get_tag_link($tag->term_id)
        ];
      }, $tags);
    }
    $categories = get_the_category($post->ID);
    if ($categories) {
      $categories = array_map(function ($cat) {
        return [
          'name' => $cat->name,
          // @codingStandardsIgnoreLine
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
      // @codingStandardsIgnoreLine
      'title' => $post->post_title,
      'content' => get_field('excerpt', $post->ID),
      'image' => $postImage,
      'url' => get_permalink($post->ID),
      'tags' => $tags,
      'categories' => $categories
    ];
  }, $data['posts']);

  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostList');
});
