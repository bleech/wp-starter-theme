<?php

namespace Flynt\Features\CustomPostTypes;

use Flynt;

class Translator
{
    public static function translateConfig($config)
    {
        $config = apply_filters(
            'Flynt/Features/CustomPostTypes/TranslateConfig',
            self::translateKeys($config)
        );

        $config = apply_filters(
            "Flynt/Features/CustomPostTypes/TranslateConfig?name={$config['name']}",
            $config
        );

        return $config;
    }

    protected static function translateKeys($config)
    {
        $config['label'] = self::translateNestedValues($config, 'label');
        $config['labels'] = self::translateNestedValues($config, 'labels');
        $config['singular_label'] = self::translateNestedValues($config, 'singular_label');
        $config['description'] = self::translateNestedValues($config, 'description');
        $config['rewrite']['slug'] = self::translateNestedValues($config, 'rewrite', 'slug');

        return $config;
    }

    // ...$args works in PHP 5.6+
    protected static function translateNestedValues(...$args)
    {
        if (count($args) === 0) {
            trigger_error('Invalid argument count for translation!', E_USER_WARNING);
            return [];
        }

        if (count($args) === 1) {
            return $args[0];
        }

        $value = Flynt\Helpers::extractNestedDataFromArray($args);

        if (empty($value)) {
            return null;
        }

        if (is_array($value)) {
            // assuming it's a single dimension
            return array_map(function ($item, $context) {
                return _x($item, $context, 'flynt-theme');
            }, $value, array_keys($value));
        } else {
            $context = array_pop($args);
            return _x($value, $context, 'flynt-theme');
        }
    }
}
