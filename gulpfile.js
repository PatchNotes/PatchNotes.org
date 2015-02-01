var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');
var less = require('gulp-less');
var del = require('del');

var paths = {
    fonts: 'assets/libraries/fontawesome/fonts/**/*.{ttf,woff,eof,svg}',
    less: ['assets/less/patchnotes.less'],
    scripts: [
        'assets/libraries/jquery/dist/jquery.min.js',
        'assets/libraries/bootstrap/dist/js/bootstrap.min.js',
        'assets/libraries/jquery-textfill/source/jquery.textfill.min.js',
        'assets/js/**/*'
    ],
    images: 'assets/img/**/*'
};

gulp.task('clean', function(cb) {
    return del(['public/assets/**/*'], cb);
});

gulp.task('fonts', ['clean'], function() {
    gulp.src(paths.fonts)
        .pipe(gulp.dest('public/assets/fonts'));
});

gulp.task('less', ['clean'], function() {
    gulp.src(paths.less)
        .pipe(less())
        //.pipe(uglify())
        .pipe(concat('patchnotes.min.css'))
        .pipe(gulp.dest('public/assets/css'));
});

gulp.task('scripts', ['clean'], function() {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    gulp.src(paths.scripts)
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
    gulp.watch(paths.fonts, ['fonts']);
    gulp.watch(paths.less, ['less']);
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.images, ['images']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['watch', 'fonts', 'less', 'scripts', 'images']);
gulp.task('compile', ['fonts', 'less', 'scripts', 'images']);