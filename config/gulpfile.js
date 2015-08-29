// npm install gulp gulp-ruby-sass gulp-autoprefixer gulp-uglify gulp-minify-css gulp-imagemin gulp-rename gulp-concat gulp-cache gulp-livereload gulp-sass del gulp-jsmin gulp-clean --save-dev
'use strict';
var gulp         = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss    = require('gulp-minify-css'),
    uglify       = require('gulp-uglify'),
    imagemin     = require('gulp-imagemin'),
    rename       = require('gulp-rename'),
    concat       = require('gulp-concat'),
    cache        = require('gulp-cache'),
    livereload   = require('gulp-livereload'),
    del          = require('del'),
    sass         = require('gulp-sass'),
    jsmin        = require("gulp-jsmin"),
    paths = {

      assets: {
        scss:   "../assets/scss/**/*.scss",
        css:    "../assets/css/**/*.css",
        js:     "../assets/js/**/*.js",
        images: "../assets/images/**/*",
        vendor: "../assets/vendor/**/*",
      },

      build: {
        css:    "../build/assets/css/",
        js:     "../build/assets/js/",
        images: "../build/assets/images/",
        vendor: "../build/assets/vendor/",
      }

    }

gulp.task('default', function() {
    gulp.start('styles', 'scripts','depcss','depjs', 'images', 'watch');
});

gulp.task('images', function() {
  return gulp.src(paths.assets.images)
    .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
    .pipe(gulp.dest(paths.build.images))
    .pipe(livereload());
});

gulp.task('styles', function() {

  del('paths.build.css', function (err, paths) {
    console.log("Bob says: main.min.css has been recreated");
  });

  return gulp.src(paths.assets.scss, { style: 'expanded' })
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(autoprefixer('last 2 version'))
    .pipe(concat('main.css'))
    .pipe(gulp.dest(paths.assets.css))
    .pipe(minifycss())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(paths.build.css))
    .pipe(livereload());
});

gulp.task('depcss', function() {
  return gulp.src(paths.assets.css, { style: 'expanded' })
    .pipe(autoprefixer('last 2 version'))
    .pipe(concat('dependencies.css'))
    .pipe(minifycss())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(paths.build.vendor))
    .pipe(livereload());
});

gulp.task('depjs', function() {
  return gulp.src(paths.assets.vendor, { style: 'expanded' })
    .pipe(minifycss())
    .pipe(uglify())
    .pipe(gulp.dest(paths.build.vendor))
    .pipe(livereload());
});


gulp.task('scripts', function() {

  del('paths.build.js', function (err, paths) {
    console.log("Bob says: main.min.js has been recreated");
  });

  return gulp.src(paths.assets.js)
    .pipe(concat('main.js'))
    .pipe(jsmin())
    .pipe(uglify())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(paths.build.js))
    .pipe(livereload());
});

gulp.task('watch', function() {
  livereload.listen();

  // Watch .scss files
  gulp.watch('../assets/scss/**/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('../assets/js/**/*.js', ['scripts']);

  // Watch image files
  gulp.watch('../assets/images/**/*', ['images']);

});
