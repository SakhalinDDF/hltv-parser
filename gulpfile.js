'use strict';

const gulp       = require('gulp'),
      sass       = require('gulp-sass'),
      csso       = require('gulp-csso'),
      sourcemaps = require('gulp-sourcemaps'),
      merge      = require('merge-stream'),
      scss       = {
          'frontend/assets/*/*.scss': 'frontend/assets'
      };

gulp.task('scss', () => {
    return merge(Object.keys(scss).map(source => {
        let destination = scss[source];

        return gulp.src(source)
            .pipe(sourcemaps.init())
            .pipe(sass().on('error', sass.logError))
            .pipe(csso({restructure: false}))
            .pipe(sourcemaps.write('.'))
            .pipe(gulp.dest(destination));
    }));
});

gulp.task('scss:watch', gulp.series('scss', () => {
    gulp.watch('frontend/**/*.scss', gulp.series('scss'));
}));

gulp.task('default', gulp.series('scss:watch'));
