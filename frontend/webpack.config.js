const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
    mode: 'development',
    entry: './src/main.js',
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.sass|\.css/,
                /*use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ],*/
                loader: 'sass-loader',
            },
            /*{
                test: /\.js$/,
                use: {
                    loader: "babel-loader"
                }
            },*/
        ],
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: "./public/index.html"
        }),
        new VueLoaderPlugin()
    ],
}