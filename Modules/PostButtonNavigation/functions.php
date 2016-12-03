<?php
namespace WPStarterTheme\Modules\PostButtonNavigation;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=PostButtonNavigation', function ($data) {
  
  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PostButtonNavigation');
});
