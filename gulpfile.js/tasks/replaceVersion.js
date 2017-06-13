const gulp = require('gulp')
const replace = require('replace-in-file')
const pjson = require('../../package.json')

module.exports = function (config) {
  gulp.task('replaceVersion', function (cb) {
    // TODO: replace WordPress version in style.css as well
    try {
      // read current version from package.json
      config.replaceVersion.to = pjson.version
      console.log(`Replacing ${config.replaceVersion.from} with ${config.replaceVersion.to}...`)
      let changedFiles = replace.sync(config.replaceVersion)
      console.log('Modified files:', changedFiles.join(', '))
    } catch (error) {
      console.error('Error occurred:', error)
    }
    cb()
  })
}
