const path = require('path')
const webpack = require('webpack')
const glob = require('glob')
const HardSourcePlugin = require('hard-source-webpack-plugin')

module.exports = function (config) {
  const babelQuery = {
    presets: [
      ['es2015', {loose: true}]
    ],
    plugins: [
      'transform-class-properties',
      [
        'babel-plugin-transform-builtin-extend', {
          globals: ['Error', 'Array', 'Object'],
          approximate: true
        }
      ]
    ]
  }
  const output = {
    name: 'browser',
    output: {
      path: path.join(__dirname, '../dist'),
      publicPath: 'http://localhost:3000/'
    },
    devtool: config.production ? false : 'inline-source-map',
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /(node_modules)/,
          use: [{
            loader: 'babel-loader',
            options: babelQuery
          }]
        }
      ]
    },
    resolve: {
      modules: [
        'node_modules'
      ],
      descriptionFiles: [
        'package.json'
      ],
      mainFields: ['main', 'browser']
    },
    resolveLoader: {
      alias: {
        'with-babel': `babel-loader?${JSON.stringify(babelQuery)}`
      }
    },
    plugins: [
      new webpack.LoaderOptionsPlugin({
        debug: !config.production
      }),
      new HardSourcePlugin()
    ],
    externals: {
      jquery: 'jQuery'
    }
  }
  if (config.production) {
    output.plugins = output.plugins || []
    output.plugins.push(
      new webpack.DefinePlugin({
        PRODUCTION: JSON.stringify(true),
        'process.env': {
          'NODE_ENV': JSON.stringify('production')
        }
      })
    )
    output.plugins.push(new webpack.optimize.UglifyJsPlugin({
      sourceMap: false
    }))
    output.plugins.push(new webpack.optimize.AggressiveMergingPlugin())
  }
  output.entry = function () {
    const entries = [].concat(config.entry)
    return entries.reduce(function (carry, entry) {
      glob.sync(entry).forEach(function (filePath) {
        const chunkName = path.normalize(removeExtension(filePath))
        carry[chunkName] = filePath
      })
      return carry
    }, {})
  }
  return output
}

function removeExtension (filePath) {
  return path.join(
    path.dirname(filePath),
    path.basename(filePath, path.extname(filePath))
  )
}
