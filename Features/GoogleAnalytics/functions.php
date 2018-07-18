<?php

namespace Flynt\Features\GoogleAnalytics;

require_once __DIR__ . '/GoogleAnalytics.php';

use Flynt\Features\GoogleAnalytics\GoogleAnalytics;
use Flynt\Utils\Feature;
use Flynt\Utils\Asset;
use Flynt\Features\Acf\OptionPages;

add_action('init', 'Flynt\Features\GoogleAnalytics\init');

function init()
{
    $googleAnalyticsOptions = OptionPages::get('globalOptions', 'feature', 'GoogleAnalytics');
    $googleAnalyticsOptionsTranslatable = OptionPages::get('translatableOptions', 'feature', 'GoogleAnalytics');

    if ($googleAnalyticsOptions) {
        new GoogleAnalytics($googleAnalyticsOptions);
    }
}

add_action('wp_enqueue_scripts', function () {
    $gaOptions = OptionPages::get('globalOptions', 'feature', 'GoogleAnalytics');
    $gaOptionsTranslatable = OptionPages::get('translatableOptions', 'feature', 'GoogleAnalytics');

    Asset::enqueue([
        'type' => 'script',
        'name' => 'js-cookie',
        'path' => 'vendor/js-cookie.js'
    ]);

    Asset::enqueue([
        'type' => 'script',
        'name' => 'Flynt/Features/GoogleAnalytics',
        'path' => 'Features/GoogleAnalytics/script.js',
        'dependencies' => ['jquery', 'js-cookie']
    ]);

    $data = [
        'gaId' => $gaOptions['gaId'],
        'confirm' => $gaOptionsTranslatable['optOutConfirm'],
        'success' => $gaOptionsTranslatable['optOutSuccess']
    ];
    wp_localize_script('Flynt/Features/GoogleAnalytics', 'dataFlyntFeatureGoogleAnalytics', $data);
}, 100);
