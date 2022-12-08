const path = require('path');
const glob = require('glob');
// css extraction and minification
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

// clean out build dir in-between builds
const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const jsFiles = glob.sync('./assets/src/js/**.js').reduce(function (obj, el) {
  obj[path.parse(el).name] = el;
  return obj
}, {});
const cssFiles = glob.sync('./assets/src/css/**.scss').reduce(function (obj, el) {
  obj[path.parse(el).name] = el;
  return obj
}, {});
let allFiles = {};
for (const key in cssFiles) {
  if (jsFiles[key]) {
    allFiles[key] = [jsFiles[key], cssFiles[key]];
  } else {
    allFiles[key] = cssFiles[key];
  }
}
module.exports = [
  {
    entry: allFiles,
    output: {
      filename: '[name].min.js',
      path: path.resolve(__dirname, './assets/dist/js')
    },
    module: {
      rules: [
        // js babelization
        {
          test: /\.(js|jsx)$/,
          exclude: /node_modules/,
          loader: 'babel-loader'
        },
        // sass compilation
        {
          test: /\.(sass|scss)$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
        },
        // loader for webfonts (only required if loading custom fonts)
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: './css/build/font/[name][ext]',
          }
        },
        // loader for images and icons (only required if css references image files)
        {
          test: /\.(png|jpg|gif)$/,
          type: 'asset/resource',
          generator: {
            filename: './css/build/img/[name][ext]',
          }
        },
      ]
    },
    plugins: [
      // clear out build directories on each build
      new CleanWebpackPlugin({
        cleanOnceBeforeBuildPatterns: [
          './assets/dist/*',
          // './assets/dist/*'
        ]
      }),
      // css extraction into dedicated file
      new MiniCssExtractPlugin({
        filename: '../css/[name].min.css'
      }),
    ],
    optimization: {
      // minification - only performed when mode = production
      minimizer: [
        // js minification - special syntax enabling webpack 5 default terser-webpack-plugin
        `...`,
        // css minification
        new CssMinimizerPlugin(),
      ]
    },
  }
];