let mix = require('laravel-mix').mix;

//mix.setPublicPath('/');

mix.js('resources/assets/js/admin/app.js', 'public/js/admin.js')
   .sass('resources/assets/sass/admin.scss', 'public/css');

// Full API
// mix.js(src, output);
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.combine(files, destination);
// mix.copy(from, to);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public'); <-- Useful for Node apps.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
