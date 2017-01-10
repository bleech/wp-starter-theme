<?php

namespace Flynt\Utils;

class Log {
  public static function console($data) {
    self::consoleDebug($data);
  }

  public static function error($data) {
    self::consoleDebug($data, 'PHP', 'error');
  }

  public static function consoleDebug($data, $title = 'PHP', $logType = 'log') {
    $title .= '(' . self::getCallerFile(2) .'):';
    if (is_array($data) || is_object($data)) {
      $output = json_encode($data);
      echo "<script>console.$logType('$title', $output);</script>\n";
    } else {
      echo "<script>console.$logType('$title', '$data');</script>\n";
    }
  }

  public static function pp($data) {
    echo "<pre>";
    print_r($data);
    echo "<br />File: <strong>" . self::getCallerFile() . "</strong>";
    echo "</pre>\n";
  }

  protected static function getCallerFile($depth = 1) {
    $debug = debug_backtrace();
    $fileName = $debug[$depth]['file'];
    $templateDir = get_template_directory() . '/';
    return str_replace($templateDir, '', $fileName) . '#' . $debug[$depth]['line'];
  }
}
