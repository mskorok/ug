
// to build assets (sass/js/svg - run 'gulp'
// to build minified assets for production - run 'gulp --production'
// when resolving conflicts always run 'gulp --production', add all new assets and git push them

// to generate docs https://www.npmjs.com/package/markdown-styles required (npm install -g markdown-styles)
// docs stored in docs folder. Docs build in docs/build
// to build docs run 'gulp docs' after markdown-styles installed with -g

// to build SVG icons run 'gulp svg'


// process.env.DISABLE_NOTIFIER = true; // to temporary disable elixir notifications

var path = require('path');
var exec = require('child_process').exec;

var gulp = require('gulp');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
//var gutil = require("gulp-util"); // gutil.log() for debugging/testing

var elixir = require('laravel-elixir');

var svgstore = require('gulp-svgstore');
var svgmin = require('gulp-svgmin');
var inlineCss = require('gulp-inline-css');
var webFontsBase64 = require('gulp-google-fonts-base64-css');


// elixir extensions
require('./elixir-extensions');
//require('laravel-elixir-svg-symbols');


/**
 * Set custom (svg) config
 */
var config = {
    svgFolder: 'svg',
    svgOutputFolder: 'svg',
    svgIdPrefix: 'svg',
    svgIdFolderSeparator: '__',
    svgOutputFileName: 'sprites.svg'
};


/**
 * Set elixir config
 */
elixir.config.sourcemaps = false;
// this is the most important var. Laravel elixir functions working directory is assets directory.
elixir.config.assetsPath = 'resources/assets';
// document_root where public assets (js, css, etc.) will be copied
elixir.config.publicPath = 'public';
elixir.config.css.folder = 'css'; // src folder in elixir.config.assetsPath
elixir.config.css.outputFolder = 'css'; // destination folder in elixir.config.publicPath
elixir.config.css.sass.folder = 'sass'; // src folder in elixir.config.assetsPath
elixir.config.js.folder = 'js'; // src folder in elixir.config.assetsPath
elixir.config.js.outputFolder = 'js'; // destination folder in elixir.config.publicPath
// destination folder where versioned assets are compiled. Should be in elixir.config.publicPath
// default is 'build' directory. Remove it to place versioned assets in root directory
// to avoid problems with image paths
elixir.config.versioning.buildFolder = '';

// custom elixir config
elixir.config.bowerPath = 'vendor'; // should be inside elixir.config.assetsPath
elixir.config.fontsFolder = 'fonts'; // destination folder in elixir.config.publicPath
elixir.config.imagesFolder = 'images'; // destination folder in elixir.config.publicPath


/**
 * Begin elixir
 *
 * 1. deletes assets
 * 2. compiles JS and SASS
 * 3. puts assets to public
 * 4. adds random version hash to file names
 */
elixir(function (mix) {

    // Delete versioned json file and all js, css in public to prevent conflicts
    mix.task('delete-assets');

    // build admin js/css
    mix.rollup('admin.js');
    mix.sass('admin.scss');

    // build app js/css
    mix.rollup('app.js');
    mix.sass('app.scss');

    // build index js/css
    mix.rollup('index.js');
    mix.sass('index.scss');

    // version admin and app js/css
    mix.version([
        'public/css/admin.css', 'public/js/admin.js',
        'public/css/app.css', 'public/js/app.js',
        'public/css/index.css', 'public/js/index.js'
    ]);
});


gulp.task('delete-assets', function() {
    var cmd_rm = 'rm -f ';
    var cmd_slash = '/';
    if (process.platform === 'win32') {
        cmd_rm = 'del /F /Q ';
        cmd_slash = '\\';
    }
    exec(cmd_rm + '"' + elixir.config.publicPath + cmd_slash + 'rev-manifest.json"');
    //gutil.log(cmd_rm + '"' + elixir.config.publicPath + 'rev-manifest.json"');
    exec(cmd_rm + '"' + elixir.config.publicPath + cmd_slash + elixir.config.css.outputFolder + cmd_slash + '*"');
    exec(cmd_rm + '"' + elixir.config.publicPath + cmd_slash + elixir.config.js.outputFolder + cmd_slash + '*"');
});


gulp.task('docs', function() {
    // generate-md cli params/docs/themes: https://github.com/mixu/markdown-styles
    return exec('generate-md --input docs/src --output docs/build --layout docs/layouts/github-ext');
});


gulp.task('fonts', function() {
    // generate css with base64 of google fonts
    // you have to manually edit fonts_base64.scss file after - add "Bold" or what you need to local font name
    return gulp.src('./fonts.list')
        .pipe(webFontsBase64())
        .pipe(concat('fonts_base64.scss'))
        .pipe(gulp.dest('./' + elixir.config.assetsPath + '/' + elixir.config.css.sass.folder + '/build'));
});


// generate single SVG sprites file for inline usage
gulp.task('svg', function () {
    return gulp.src(
        elixir.config.assetsPath + '/' + config.svgFolder + '/**/*.svg')
        .pipe(rename(function (path) {
            var dir = path.dirname.split(path.sep)[0];
            var file_base_name_parts = [];
            if (config.svgIdPrefix.length > 0) {
                file_base_name_parts.push(config.svgIdPrefix);
            }
            if (dir !== '.') {
                file_base_name_parts.push(dir); // if subfolder -> add folder name to file name
            }
            file_base_name_parts.push(path.basename); // add icon file base name itself
            path.basename = file_base_name_parts.join(config.svgIdFolderSeparator); // combine all parts
        }))
        .pipe(svgmin(function (file) { // minify svg
            var prefix = path.basename(file.relative, path.extname(file.relative));
            return {
                plugins: [{
                    cleanupIDs: {
                        prefix: prefix + '-',
                        minify: true
                    }
                }, {
                    minifyStyles: true
                }]
            }
        }))
        .pipe(svgstore({inlineSvg: true})) // remove XML, DOCTYPE etc
        .pipe(inlineCss()) // remove <style> and inline css
        .pipe(rename(config.svgOutputFileName)) // rename output file
        .pipe(gulp.dest(elixir.config.publicPath + '/' + config.svgOutputFolder));
});
