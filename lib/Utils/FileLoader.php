<?php

namespace Flynt\Utils;

use DirectoryIterator;

class FileLoader
{
    public static function iterateDir($dir, callable $callback)
    {
        $output = [];

        if (!is_dir($dir)) {
            return $output;
        }

        $directoryIterator = new DirectoryIterator($dir);

        foreach ($directoryIterator as $file) {
            if ($file->isDot()) {
                continue;
            }
            $callbackResult = call_user_func($callback, $file);
            array_push($output, $callbackResult);
        }

        return $output;
    }

    /**
     * Recursively require all files in a specific directory.
     *
     * Optionally able to specify the files in an array to load in a certain order.
     *
     * @param string $dir Directory to search through. Trailing slashes will be stripped.
     * @param array $files Optional array of files to include. If this is set, only the files specified will be loaded.
     **/
    public static function loadPhpFiles($dir = '', $files = [])
    {
        if (count($files) === 0) {
            $dir = get_template_directory() . '/' . $dir;

            self::iterateDir($dir, function ($file) {
                if ($file->isDir()) {
                    $dirPath = str_replace(get_template_directory(), '', $file->getPathname());
                    self::loadPhpFiles($dirPath);
                } elseif ($file->isFile() && $file->getExtension() === 'php') {
                    $filePath = $file->getPathname();
                    require_once $filePath;
                }
            });
        } else {
            array_walk($files, function ($file) use ($dir) {
                $filePath = $dir . $file;

                if (!locate_template($filePath, true, true)) {
                    trigger_error(
                        sprintf(__('Error locating %s for inclusion', 'flynt-theme'), $filePath),
                        E_USER_ERROR
                    );
                }
            });
        }
    }
}
