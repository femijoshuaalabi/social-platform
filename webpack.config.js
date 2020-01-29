const path = require('path');
//const HtmlwebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry: {
        app: ['babel-polyfill','./src/app.js']
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: 'app.bundle.js',
        publicPath: '/'
    },
    devServer: {
        inline: false,
        contentBase: "./dist",
    },
    module: {
        rules: [{
            test: /\.js?$/,
            exclude: /node_modules/,
            loader: 'babel-loader',
            query: {
                presets: ["@babel/preset-env","@babel/preset-react"],
                "plugins": [
                    [
                      "@babel/plugin-proposal-class-properties"
                    ]
                ]
            }
        }]
    },
    mode: 'development',
    devServer: {
        historyApiFallback: true,
    },
    watchOptions: {
        aggregateTimeout: 300,
        poll: true,
        ignored: [/node_modules/,
                '**/*.bundle.css',
                '**/*.bundle.js',
                '**/*.html',
                '**/*.php',
                '**/*.xml']
    }
}