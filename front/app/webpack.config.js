const path = require('path')
const HTMLPlugin = require('html-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const CopyPlugin = require('copy-webpack-plugin');

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
        new CleanWebpackPlugin(),
        new CopyPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, 'src/images'),
                    to: path.resolve(__dirname, 'public/images')
                }
            ]
        })
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
                test: /\.(jpeg|jpg|png|ico|svg)$/,
                use: ['file-loader'],
            },
            // Fonts Loading
            {
                test: /\.(ttf|otf|eot|woff|woff2)$/,
                use: ['file-loader'],
            }
        ],
    },
}