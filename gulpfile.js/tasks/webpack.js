const path = require('path')
const fs = require('fs')
const gulp = require('gulp')

let previousAssets = []
let previousHash

function removeUnusedAssets (stats) {
  const basePath = path.join(
    stats.compilation.options.context,
    stats.compilation.outputOptions.path
  )
  const currentAssets = Object.keys(stats.compilation.assets)
  const unusedAssets = previousAssets.filter(function (asset) {
    return currentAssets.indexOf(asset) === -1
  })
  unusedAssets.forEach(function (asset) {
    const assetPath = path.join(basePath, asset)
    if (fs.existsSync(assetPath)) {
      fs.unlinkSync(assetPath)
    }
  })
  previousAssets = currentAssets
}

const webpackTask = function (callback) {
  const gutil = require('gulp-util')
  var initialCompile = false
  return function (err, stats) {
    if (err) {
      throw new gutil.PluginError('webpack:build', err)
    }

    if (stats.compilation.errors.length > 0) {
      const handleErrors = require('../utils/handleErrors.js')
      stats.compilation.errors.forEach(function (error) {
        error.plugin = 'Webpack'
        handleErrors(error)
      })
    }

    if (previousHash !== stats.hash) {
      previousHash = stats.hash
      removeUnusedAssets(stats)
      if (global.watchMode) {
        const browserSync = require('browser-sync')
        browserSync.reload()
      }
      gutil.log('[webpack:build] Completed\n' + stats.toString({
        assets: true,
        chunks: false,
        chunkModules: false,
        colors: true,
        hash: false,
        timings: false,
        version: false
      }))
    }
    if (!initialCompile) {
      initialCompile = true
      callback()
    }
  }
}

module.exports = function (webpackConfig, config) {
  gulp.task('webpack:build', function (callback) {
    const webpack = require('webpack')
    config.webpack.production = true
    webpack(webpackConfig(config.webpack), webpackTask(callback))
  })

  gulp.task('webpack:watch', function (callback) {
    const webpack = require('webpack')
    module.exports.watching = webpack(webpackConfig(config.webpack)).watch(null, webpackTask(callback))
  })
}
