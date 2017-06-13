const gulp = require('gulp')
const gutil = require('gulp-util')
const pjson = require('../../package.json')
const replace = require('replace-in-file')

module.exports = function (config) {
  gulp.task('replaceVersion', function (cb) {
    try {
      // read current version from package.json
      config.replaceVersion.php.to = pjson.version
      gutil.log(`Replacing ${config.replaceVersion.php.from} with ${config.replaceVersion.php.to} in all PHP files.`)
      replace.sync(config.replaceVersion.php)

      // replace WordPress theme version in style.css
      gutil.log('Updating WordPress theme version.')
      config.replaceVersion.wordpress.to += pjson.version
      replace.sync(config.replaceVersion.wordpress)
    } catch (error) {
      gutil.error('Error occurred:', error)
    }
    cb()
  })
}
