<?php
namespace Flynt\Components\TeaserGrid;

use Flynt\DataFilters\MainQuery;
use Flynt\Features\Components\Component;

add_filter('Flynt/modifyComponentData?name=TeaserGrid', function ($data) {
  $data['teaserItems'] = array_map(function ($item) {

    if ($item['linkType'] == 'internalLink') {
      // $item['post'] = MainQuery::addAdditionalDefaultDataSinglePost($item['post']);
    }

    return $item;
  }, $data['teaserItems']);

  return $data;
});
