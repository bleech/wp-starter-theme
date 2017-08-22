<?php

namespace Flynt\Components\NavigationBreadcrumb;

use Flynt\Features\Components\Component;
use Flynt\Features\AdminNotices\AdminNoticeManager;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationBreadcrumb');
});

add_action('admin_init', 'Flynt\Components\NavigationBreadcrumb\addYoastRequiredNotice');

add_filter('Flynt/addComponentData?name=NavigationBreadcrumb', function ($data) {
    if (checkYoastActivated()) {
        $data['breadcrumbs'] = getOutput('yoast_breadcrumb');
    }
    return $data;
});

function checkYoastActivated()
{
    return function_exists('yoast_breadcrumb');
}

function addYoastRequiredNotice()
{
    if (!checkYoastActivated()) {
        $manager = AdminNoticeManager::getInstance();
        $message = ["This component requires the Yoast SEO plugin. Please install and active Yoast SEO."];
        $options = [
            'type' => 'error',
            'title' => 'NavigationBreadcrumb Error',
            'dismissible' => false,
            'filenames' => 'functions.php'
        ];
        $manager->addNotice($message, $options);
    }
}

function getOutput($function)
{
    ob_start();
    $function();
    $output = ob_get_contents();
    ob_get_clean();
    return $output;
}
