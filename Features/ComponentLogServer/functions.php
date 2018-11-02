<?php

namespace Flynt\Features\ComponentLogServer;

use Flynt;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('Flynt/afterRegisterFeatures', function () {
    $componentManager = Flynt\ComponentManager::getInstance();
    $componentWhitelist = [];
    if (isset($_GET['component']) && !empty($_GET['component'])) {
        $componentWhitelist = explode(',', $_GET['component']);
    }
    if (count($componentWhitelist) === 0) {
        foreach ($componentManager->getAll() as $name => $path) {
            add_filter("Flynt/addComponentData?name={$name}", NS . 'addDebugInfo', 12, 3);
        }
    } else {
        foreach ($componentManager->getAll() as $name => $path) {
            if (in_array($name, $componentWhitelist)) {
                add_filter("Flynt/addComponentData?name={$name}", NS . 'addDebugInfo', 12, 3);
            }
        }
    }
}, 11);

function addDebugInfo($data, $parentData, $config)
{
    if ((WP_ENV === 'development' || current_user_can('editor') || current_user_can('administrator')) && isset($_GET['log'])) {
        consoleDebug([
            'component' => $config['name'],
            'config' => $config,
            'data' => $data,
            'parentData' => $parentData,
        ]);
    }

    return $data;
}

function consoleDebug($data, $postpone = true)
{
    $type = gettype($data);
    $output = json_encode($data);
    $result =  "<script>console.log({$output});</script>\n";
    echoDebug($result, $postpone);
}

function echoDebug($data, $postpone)
{
    if ($postpone) {
        add_action('wp_footer', function () use ($data) {
            echo $data;
        }, 30);
    } else {
        echo $data;
    }
}
