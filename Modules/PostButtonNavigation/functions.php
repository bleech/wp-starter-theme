<?php
namespace WPStarterTheme\Modules\PostButtonNavigation;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=PostButtonNavigation', function ($data, $parentData) {
  $meta = $parentData['meta'];
  $data['nextPageURL'] = false;
  $data['prevPageURL'] = false;
  $data['labelPrevButton'] = get_field('prevLabel', 'option');
  $data['labelNextButton'] = get_field('nextLabel', 'option');
  $blogURL = get_permalink(get_option('page_for_posts'));
  if ($meta['currentPage'] === 0) {
    $meta['currentPage'] = 1;
  }

  if ($meta['currentPage'] === 1 || $meta['currentPage'] < $meta['maxNumPages']) {
    $data['nextPageURL'] = $blogURL . 'page/' . ($meta['currentPage'] + 1);
  }
  if ($meta['currentPage'] > 1) {
    $data['prevPageURL'] = $blogURL . 'page/' . ($meta['currentPage'] - 1);
  }
  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostButtonNavigation');
});
