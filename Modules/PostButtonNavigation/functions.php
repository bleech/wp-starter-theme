<?php
namespace WPStarterTheme\Modules\PostButtonNavigation;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=PostButtonNavigation', function ($data, $parentData) {
  $data['nextPageURL'] = false;
  $data['prevPageURL'] = false;
  $blogURL = get_permalink(get_option('page_for_posts'));
  if($parentData['meta']['current_page'] === 1 || $parentData['meta']['current_page'] < $parentData['meta']['max_num_pages']) {
    $data['nextPageURL'] = $blogURL . 'page/' . ($parentData['meta']['current_page'] + 1);
  }
  if($parentData['meta']['current_page'] > 1) {
    $data['prevPageURL'] = $blogURL . 'page/' . ($parentData['meta']['current_page'] - 1);
  }
  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostButtonNavigation');
});
