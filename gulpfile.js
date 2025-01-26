const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass')); // Use dart-sass
const cleanCSS = require('gulp-clean-css'); // Minify CSS
const postcss = require('gulp-postcss'); // PostCSS to add plugins like autoprefixer
const autoprefixer = require('autoprefixer'); // Autoprefixer plugin
const concat = require('gulp-concat'); // Concatenate JS files
const uglify = require('gulp-uglify'); // Minify JS files
const imagemin = require('gulp-imagemin'); // Minify images
const watch = require('gulp-watch'); // Watch for file changes

// Compile Sass, add prefixes, and minify CSS
gulp.task('sass', function(){
  return gulp.src('assets/scss/**/*.scss') // Compile all SCSS files
    .pipe(sass().on('error', sass.logError)) // Compile SCSS
    .pipe(postcss([autoprefixer()])) // Add prefixes using PostCSS
    .pipe(cleanCSS({compatibility: 'ie8'})) // Minify CSS
    .pipe(concat('style.min.css')) // Combine into one file
    .pipe(gulp.dest('dist/css')); // Output to dist/css
});

// Concat and Minify JavaScript
gulp.task('scripts', function() {
  return gulp.src('assets/js/**/*.js') // Specify JS files
    .pipe(uglify()) // Minify JS
    .pipe(concat('main.min.js')) // Combine into one file
    .pipe(gulp.dest('dist/js')); // Output to dist/js
});

// Minify Images
gulp.task('imagemin', function() {
  return gulp.src('src/images/*') // Source images
    .pipe(imagemin()) // Minify images
    .pipe(gulp.dest('dist/images')); // Output to dist/images
});

// Watch for Changes in SCSS, JS, and Images
gulp.task('watch', function() {
  gulp.watch('assets/scss/**/*.scss', gulp.series('sass')); // Watch SCSS
  gulp.watch('assets/js/**/*.js', gulp.series('scripts')); // Watch JS
  gulp.watch('src/images/*', gulp.series('imagemin')); // Watch images
});

// Default Task (to run all tasks)
gulp.task('default', gulp.parallel('sass', 'scripts', 'imagemin', 'watch'));
