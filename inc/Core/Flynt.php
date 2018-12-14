<?php
namespace Flynt;

use Flynt\Defaults;
use Flynt\BuildConstructionPlan;
use Flynt\Render;
use Flynt\ComponentManager;

function initDefaults()
{
    Defaults::init();
}

function registerComponent($componentName, $componentPath = null)
{
    $componentManager = ComponentManager::getInstance();
    $componentManager->registerComponent($componentName, $componentPath);
}

function registerComponentsFromPath($componentBasePath)
{
    foreach (glob("{$componentBasePath}/*", GLOB_ONLYDIR) as $componentPath) {
        $componentName = basename($componentPath);
        registerComponent($componentName, $componentPath);
    }
}

function renderComponent($componentName, $data)
{
    // var_dump($componentName, $data);die();
    $data = apply_filters(
        'Flynt/addComponentData',
        $data,
        $componentName
    );
    $output = apply_filters(
        'Flynt/renderComponent',
        null,
        $componentName,
        $data
    );

    return is_null($output) ? '' : $output;
}

add_filter('Flynt/renderComponent', function ($output, $componentName, $data) {
    return apply_filters(
        "Flynt/renderComponent?name={$componentName}",
        $output,
        $componentName,
        $data
    );
}, 10, 3);

add_filter('Flynt/addComponentData', function ($data, $componentName) {
    return apply_filters(
        "Flynt/addComponentData?name={$componentName}",
        $data,
        $componentName
    );
}, 10, 2);

function registerFields($scope, $fields, $type = null)
{
    if (empty($type)) {
        global $flyntCurrentFieldType;
        $type = $flyntCurrentFieldType ?? 'Components';
    }
    foreach ($fields as $key => $fieldData) {
        $key = ucfirst($key);
        $keyFilter = "Flynt/{$type}/{$scope}/Fields/{$key}";
        add_filter($keyFilter, function () use ($fieldData) {
            return $fieldData;
        });
        if (!empty($fieldData['sub_fields'])) {
            add_filter($keyFilter . '/SubFields', function () use ($fieldData) {
                return $fieldData['sub_fields'];
            });
        }
    }
}
