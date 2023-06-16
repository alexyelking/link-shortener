const path = require('path')
const HTMLPlugin = require('html-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')

module.exports = {
    entry: './src/js/app.js',
    output: {
        filename: 'bundle.[chunkhash].js',
        path: path.resolve(__dirname, 'public')
    },
    devServer: {
        port: 3000
    },
    plugins: [
        new HTMLPlugin({
            template: './src/html/index.html'
        }),
        new CleanWebpackPlugin()
    ],
    module: {
        rules: [
            // HTML Loader
            {
                test: /\.html$/,
                use: ['html-loader'],
            },
            // CSS loading
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader'],
            },
            // Images loading
            {
                test: /\.png/,
                type: 'asset/resource'
            },
            // Fonts Loading
            {
                test: /\.(ttf|otf|eot|woff|woff2)$/,
                type: 'asset/resource'
            }
        ],
    },
}