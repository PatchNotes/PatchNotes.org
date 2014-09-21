var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var sourcemaps = require('gulp-sourcemaps');
var less = require('gulp-less');
var del = require('del');

var paths = {
    less: ['assets/less/patchnotes.less'],
    scripts: [
        'assets/libraries/jquery/dist/jquery.min.js',
        'assets/libraries/bootstrap/dist/js/bootstrap.min.js',
        'assets/js/**/*'
    ],
    images: 'assets/img/**/*'
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use all packages available on npm
gulp.task('clean', function(cb) {
    // You can use multiple globbing patterns as you would with `gulp.src`
    del(['public/assets'], cb);
});

gulp.task('less', ['clean'], function() {
    return gulp.src(paths.less)
        .pipe(less())
        //.pipe(uglify())
        .pipe(concat('patchnotes.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('scripts', ['clean'], function() {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    return gulp.src(paths.scripts)
        .pipe(uglify())
        .pipe(concat('patchnotes.min.js'))
        .pipe(gulp.dest('public/assets/js'));
});

// Copy all static images
gulp.task('images', ['clean'], function() {
    return;
    /*
    return gulp.src(paths.images)
        // Pass in options to the task
        .pipe(imagemin({optimizationLevel: 5}))
        .pipe(gulp.dest('public/assets/img'));
    */
});

// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch(paths.less, ['less']);
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.images, ['images']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'less', 'scripts', 'images']);