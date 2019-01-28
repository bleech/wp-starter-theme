const gulp = require('gulp')

module.exports = function (config) {
  gulp.task('build', function (cb) {
    const runSequence = require('run-sequence')
    const isProduction = process.env.NODE_ENV === 'production'
    let tasks = ['copy', 'webpack:build', 'stylus']
    if (!isProduction) {
      tasks.push('lint');
    }

    runSequence(
      'clean',
      tasks,
      'rev',
      cb
    )
  })
}
