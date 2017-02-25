<?php

namespace Flynt\Utils;

class Asset {
  protected static $assetManifest;

  public static function requireUrl($asset) {
    $distPath = get_template_directory() . '/dist';
    $distUrl = get_template_directory_uri() . '/dist';
    if (!isset(self::$assetManifest)) {
      $manifestPath = $distPath . '/rev-manifest.json';
      self::$assetManifest = [];
      if (is_file($manifestPath)) {
        self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
      }
    }
    $assetSuffix = $asset;
    if (array_key_exists($asset, self::$assetManifest)) {
      $assetSuffix = self::$assetManifest[$asset];
    }
    return $distUrl . '/' . $assetSuffix;
  }

  public static function requirePath($asset) {
    $distPath = get_template_directory() . '/dist';
    $distUrl = get_template_directory_uri() . '/dist';
    if (!isset(self::$assetManifest)) {
      $manifestPath = $distPath . '/rev-manifest.json';
      self::$assetManifest = [];
      if (is_file($manifestPath)) {
        self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
      }
    }
    $assetSuffix = $asset;
    if (array_key_exists($asset, self::$assetManifest)) {
      $assetSuffix = self::$assetManifest[$asset];
    }
    return $distPath . '/' . $assetSuffix;
  }
}
