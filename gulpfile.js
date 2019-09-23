var gulp = require("gulp"),
    sass = require("gulp-sass"),
    postcss = require("gulp-postcss"),
    autoprefixer = require("autoprefixer"),
    cssnano = require("cssnano"),
    sourcemaps = require("gulp-sourcemaps");

var paths = {
    css: {
        // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
        src: "resources/sass/*.scss",
        // Compiled files will end up in whichever folder it's found in (partials are not compiled)
        dest: "public/css"
    }
};

// Define tasks after requiring dependencies
function css() {
    return (
        gulp
            .src(paths.css.src)

            // Use sass with the files found, and log any errors
            .pipe(sourcemaps.init())
            .pipe(sass())
            .on("error", sass.logError)
            .pipe(postcss([autoprefixer(), cssnano()]))

            .pipe(sourcemaps.write())
            .pipe(gulp.dest(paths.css.dest))
    );
}


// Expose the task by exporting it
// This allows you to run it from the commandline using
// $ gulp css
exports.css = css;

function watch(){
    css();
    // gulp.watch takes in the location of the files to watch for changes
    // and the name of the function we want to run on change
    gulp.watch(paths.css.src, css)
}

exports.watch = watch