<?php

namespace Flynt\Utils;

class Feature
{

    private static $initialFile = 'functions.php';
    private static $features = [];

    /**
     * Gets a feature options.
     *
     * @since 0.1.0
     *
     * @param string $feature The feature name.
     *
     * @return array/null Returns the options or null.
     */
    public static function getOptions($feature)
    {
        $feature = self::getFeature($feature);
        return $feature ? $feature['options'] : null;
    }

    /**
     * Gets a feature option.
     *
     * @since 0.1.0
     *
     * @param string $feature The feature name.
     * @param string $key The option key.
     *
     * @return mixed/null Returns the options or null.
     */
    public static function getOption($feature, $key)
    {
        $options = self::getOptions($feature);
        return is_array($options) && array_key_exists($key, $options) ? $options[$key] : null;
    }

    /**
     * Gets a feature directory.
     *
     * @since 0.1.0
     *
     * @param string $feature The feature name.
     *
     * @return string Returns the directory.
     */
    public static function getDir($feature)
    {
        $feature = self::getFeature($feature);
        return $feature ? $feature['dir'] : null;
    }

    /**
     * Registers a feature.
     *
     * @since 0.1.0
     *
     * @param string $feature The feature name.
     * @param string $basePath The feature base path.
     * @param array $options An array of options. Optional.
     *
     * @return boolean
     */
    public static function register($feature, $basePath, $options = [])
    {
        if (!isset(self::$features[$feature])) {
            $prettyName = StringHelpers::removePrefix('flynt', StringHelpers::kebapCaseToCamelCase($feature));
            $dir = implode('/', [$basePath, $prettyName]);
            $file = implode('/', [$dir, self::$initialFile]);

            if (is_file($file)) {
                $options = (array) $options;

                self::$features[$feature] = [
                'options' => $options,
                'dir' => $dir,
                'name' => $prettyName
                ];

                require_once $file;

                // execute post register actions
                do_action('Flynt/registerFeature', $prettyName, $options, $dir);
                do_action("Flynt/registerFeature?name={$prettyName}", $prettyName, $options, $dir);

                return true;
            }

            trigger_error("{$feature}: Could not register feature! File not found: {$file}", E_USER_WARNING);

            return false;
        }
    }

    /**
     * Checks if a feature is already registered.
     *
     * @since 0.1.0
     *
     * @param string $name The feature name.
     *
     * @return boolean
     */
    public static function isRegistered($name)
    {
        return array_key_exists($name, self::$features);
    }

    /**
     * Gets a feature.
     *
     * @since 0.1.0
     *
     * @param string $name The feature name.
     *
     * @return array
     */
    public static function getFeature($name)
    {
        if (isset(self::$features[$name])) {
            return self::$features[$name];
        }
        return false;
    }

    /**
     * Gets all the features.
     *
     * @since 0.1.0
     *
     * @return array
     */
    public static function getFeatures()
    {
        return self::$features;
    }

    /**
     * Sets the initial file of a feature.
     *
     * @since 0.1.0
     *
     * @param string $fileName The filename.
     */
    public static function setInitialFile($fileName)
    {
        self::$initialFile = $fileName;
    }
}
