<?php
namespace WPStarterTheme\Modules\PostListFilter;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=PostListFilter', function ($data, $parentData) {
  $postType = $parentData['query']->query_vars['post_type'];

  // TODO: Implement filtering for post_type on get_terms
  $terms = get_terms();
  $filters = [];

  foreach ($terms as $term) {
    $filters[$term->taxonomy][] = [
      'ID' => $term->term_id,
      'taxonomyID' => $term->term_taxonomy_id,
      'name' => $term->name,
      'lowerName' => strtolower($term->name),
      'count' => $term->count,
      'url' => get_term_link($term->term_id)
    ];
  }

  $data['filters'] = $filters;

  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostListFilter');
});
