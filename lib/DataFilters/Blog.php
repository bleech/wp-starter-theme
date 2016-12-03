<?php

namespace WPStarterTheme\DataFilters;

use WPStarterTheme\Helpers\StringHelpers;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarterTheme/DataFilters/PostButtonNavigation', ['WPStarterTheme\DataFilters\Blog', 'setPostButtonNavigationData'], 10, 3);

class Blog {

  public static function setPostButtonNavigationData($data) {
    $data['labelPrevButton'] = 'Previous Page';
    $data['labelNextButton'] = 'Next Page';

    return $data;
  }

}
