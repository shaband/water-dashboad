const path = require('path')

module.exports = {
    output: {

       chunkFilename: 'js/chunks/[name].js?id=[chunkhash]'
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/src'),
            '@assets': path.resolve(__dirname, 'resources/assets'),
            '@sass': path.resolve(__dirname, 'resources/sass'),
            '@layout': path.resolve(__dirname, 'resources/js/src/layouts'),
            '@views': path.resolve(__dirname, 'resources/js/src/views'),
            '@request': path.resolve(__dirname, 'resources/js/src/http/requests'),
            '@component': path.resolve(__dirname, 'resources/js/src/components'),

        }
    }
}
