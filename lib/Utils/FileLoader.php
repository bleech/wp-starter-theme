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

    // TODO fix this, this makes no sense (require only works for php files...?)
    // recursively load all files with a specified extension
    // optionally able to specify the files in an array to load in a certain order
    public static function loadFilesWithExtension($fileExtension, $dir = '', $files = [])
    {

        if (count($files) === 0) {
            $dir = get_template_directory() . '/' . $dir;

            self::iterateDir($dir, function ($file) use ($fileExtension) {

                if ($file->isDir()) {
                    $dirPath = str_replace(get_template_directory(), '', $file->getPathname());
                    self::loadFilesWithExtension($fileExtension, $dirPath, []);
                } elseif ($file->isFile() && $file->getExtension() === $fileExtension) {
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

    public static function loadPhpFiles($dir = '', $files = [])
    {
        $fileExtension = 'php';
        self::loadFilesWithExtension('php', $dir, $files);
    }
}
