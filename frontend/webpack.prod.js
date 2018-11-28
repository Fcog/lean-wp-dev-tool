const webpack = require('webpack')
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const merge = require('webpack-merge')
const common = require('./webpack.common.js')

module.exports = merge(common, {
  mode: 'production',
  output: {
    publicPath: './'
  },
  devtool: 'none',
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery'
    })
  ],
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        sourceMap: true,
        uglifyOptions: {
          compress: {
            warnings: false,
            drop_console: true,
            booleans: false,
            loops: false
          },
          output: {
            comments: true,
            beautify: true
          }
        }
      }),
      new OptimizeCssAssetsPlugin({
        assetNameRegExp: /\.css$/,
        cssProcessor: require('cssnano'),
        cssProcessorOptions: {
          discardComments: { removeAll: true },
          safe: true,
          autoprefixer: {
            add: true,
            browsers: [
              'last 2 versions',
              'iOS >= 8'
            ]
          }
        },
        canPrint: true
      }, {
        copyUnmodified: true
      })
    ]
  }
})
