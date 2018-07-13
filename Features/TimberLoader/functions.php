<?php

namespace Flynt\Features\TimberLoader;

use Flynt;
use Timber\Image;
use Timber\Post;
use Timber\Timber;
use Twig_SimpleFunction;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// Render Component with Timber (Twig)
add_filter('Flynt/renderComponent', NS . 'renderTwigIndex', 10, 4);

// Convert ACF Images to Timber Images
add_filter('acf/format_value/type=image', NS . 'formatImage', 100);

// Convert ACF Gallery Images to Timber Images
add_filter('acf/format_value/type=gallery', NS . 'formatGallery', 100);

// Convert ACF Field of type post_object to a Timber\Post and add all ACF Fields of that Post
add_filter('acf/format_value/type=post_object', NS . 'formatPostObject', 100);

function renderTwigIndex($output, $componentName, $componentData, $areaHtml) {
    // get index file
    $componentManager = Flynt\ComponentManager::getInstance();
    $templateFilename = apply_filters('Flynt/Features/TimberLoader/templateFilename', 'index.twig');
    $templateFilename = apply_filters("Flynt/Features/TimberLoader/templateFilename?name=${componentName}", $templateFilename);
    $filePath = $componentManager->getComponentFilePath($componentName, $templateFilename);

    if (!is_file($filePath)) {
        trigger_error("Template not found: {$filePath}", E_USER_WARNING);
        return $output;
    }

    $addArea = function ($twig) use ($areaHtml) {

        $twig->addFunction(new Twig_SimpleFunction('area', function ($areaName) use ($areaHtml) {
            if (array_key_exists($areaName, $areaHtml)) {
                return $areaHtml[$areaName];
            }
        }));

        return $twig;
    };

    add_filter('get_twig', $addArea);

    $returnTimberPaths = function ($paths) use ($filePath) {
        array_unshift($paths, dirname($filePath));
        return $paths;
    };

    add_filter('timber/loader/paths', $returnTimberPaths);

    $output = Timber::fetch($filePath, $componentData);

    remove_filter('timber/loader/paths', $returnTimberPaths);

    remove_filter('get_twig', $addArea);

    return $output;
}

function formatImage($value) {
    if (!empty($value)) {
        $value = new Image($value);
    }
    return $value;
}

function formatGallery($value) {
    if (!empty($value)) {
        $value = array_map(function ($image) {
            return new Image($image);
        }, $value);
    }
    return $value;
}

function formatPostObject($value) {
    if (is_array($value)) {
        $value = array_map(NS . 'convertToTimberPost', $value);
    } else {
        $value = convertToTimberPost($value);
    }
    return $value;
}

function convertToTimberPost($value)
{
    if (!empty($value) && is_object($value) && get_class($value) === 'WP_Post') {
        $value = new Post($value);
    }
    return $value;
}
