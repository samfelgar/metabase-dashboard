let mix = require('laravel-mix')

require('./mix')

mix
    .setPublicPath('dist')
    .js('resources/js/tool.js', 'js')
    .vue({ version: 3 })
    .sass('resources/sass/tool.scss', 'scss',)
    .nova('samfelgar/metabase-dashboard')
