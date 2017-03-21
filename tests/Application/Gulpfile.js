var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');

config = [
    '--rootPath',
    argv.rootPath || '../../../../../../../tests/Application/web/assets/',
    '--nodeModulesPath',
    argv.nodeModulesPath || '../../../../../../../tests/Application/node_modules/',
    '--vendorPath',
    argv.vendorPath || '../../../../../../../vendor/'
];

gulp.task('admin', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('shop', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('catalog-promotion', function() {
    return gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/semantic-ui-css/semantic.min.js',
        '../../vendor/sylius/sylius/src/Sylius/Bundle/UiBundle/Resources/private/js/**',
        '../../src/Resources/public/**'
    ])
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/assets/catalog/' + 'js/'))
    ;
});

gulp.task('default', ['admin', 'shop', 'catalog-promotion']);
