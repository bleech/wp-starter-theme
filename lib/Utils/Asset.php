<?php

namespace Flynt\Utils;

// TODO: add async & defer (see https://matthewhorne.me/defer-async-wordpress-scripts/); also add to cdn fallback
// BUG: When there are several scripts registered, some with a CDN, some without, the CDN setting is only applied if it was set in the first instance.

class Asset
{
    const DEFAULT_OPTIONS = [
        'dependencies' => [],
        'version' => null,
        'inFooter' => true,
        'media' => 'all',
        'cdn' => []
    ];

    protected static $assetManifest;
    protected static $loadFromCdn = false;

    public static function requireUrl($asset)
    {
        return self::get('url', $asset);
    }

    public static function requirePath($asset)
    {
        return self::get('path', $asset);
    }

    public static function register($options)
    {
        return self::add('register', $options);
    }

    public static function enqueue($options)
    {
        return self::add('enqueue', $options);
    }

    protected static function get($returnType, $asset)
    {
        $distPath = get_template_directory() . '/dist';

        if (!isset(self::$assetManifest)) {
            $manifestPath = $distPath . '/rev-manifest.json';
            if (is_file($manifestPath)) {
                self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                self::$assetManifest = [];
            }
        }

        if (array_key_exists($asset, self::$assetManifest)) {
            $assetSuffix = self::$assetManifest[$asset];
        } else {
            $assetSuffix = $asset;
        }

        if ('path' == $returnType) {
            return $distPath . '/' . $assetSuffix;
        } else if ('url' == $returnType) {
            $distUrl = get_template_directory_uri() . '/dist';
            return $distUrl . '/' . $assetSuffix;
        }

        return false;
    }

    protected static function add($funcType, $options)
    {
        $options = array_merge(self::DEFAULT_OPTIONS, $options);

        if (!array_key_exists('name', $options)) {
            trigger_error('Cannot add asset: Name not provided!', E_USER_WARNING);
            return false;
        }

        if (!array_key_exists('path', $options)) {
            trigger_error('Cannot add asset: Path not provided!', E_USER_WARNING);
            return false;
        }

        $funcName = "wp_{$funcType}_{$options['type']}";
        $lastVar = $options['type'] === 'script' ? $options['inFooter'] : $options['media'];

        // allow external urls
        $path = $options['path'];
        if (!(StringHelpers::startsWith('http://', $path))
            && !(StringHelpers::startsWith('https://', $path))
            && !(StringHelpers::startsWith('//', $path))
        ) {
            $path = Asset::requireUrl($path);
        }

        if ('script' === $options['type']
            && true === self::$loadFromCdn
            && !empty($options['cdn'])
            && !empty($options['cdn']['check'])
            && !empty($options['cdn']['url'])
            && !wp_script_is($options['name'], 'registered')
            && !wp_script_is($options['name'], 'enqueued')
        ) {
            $cdnCheck = $options['cdn']['check'];
            $localPath = $path;
            $path = $options['cdn']['url'];
        }

        if (function_exists($funcName)) {
            $funcName(
                $options['name'],
                $path,
                $options['dependencies'],
                $options['version'],
                $lastVar
            );

            if (isset($localPath)) {
                wp_add_inline_script(
                    $options['name'],
                    "${cdnCheck}||document.write(\"<script src=\\\"${localPath}\\\"><\/script>\")"
                );
            }

            return true;
        }

        return false;
    }

    /**
     * Getter and setter for the loadFromCdn setting.
     *
     * @param boolean $load (optional) Value to set the parameter to.
     **/
    public static function loadFromCdn($load = null)
    {
        if (!isset($load)) {
            return self::$loadFromCdn;
        }
        self::$loadFromCdn = (bool) $load;
    }
}
