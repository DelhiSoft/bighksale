const project = require("./project.js");
const gulp = require("gulp");
const task = {
    optimize: require("gulp-imagemin"),
    webp: require("gulp-webp"),
    srcmap: require("gulp-sourcemaps"),
    serve: require('browser-sync'),
    concat: require('gulp-concat'),
    debug: require('gulp-debug'),
    validate:{
        css:require('gulp-analyze-css')
    },
    minify: {
        js: require("gulp-uglify"),
        css: require("gulp-csso"),
        sass: require("gulp-sass")
    }
};

/* Gulp tasks */
gulp.task("sass", function() {
    return gulp
        .src(project.src + "/" + project.sass)
        .pipe(task.srcmap.init())
        .pipe(task.minify.sass())
        .on("error", function(err) {
            console.log(err.toString());
            this.emit("end");
        })
        .pipe(task.srcmap.write("map/"))
        .pipe(gulp.dest(project.src+"/css/compiled/"));
});
gulp.task('check-css',function(){
    return gulp
        .src(project.src+"/"+project.css)
        .pipe(task.validate.css())
        .pipe(gulp.dest("../temp"));
})
gulp.task("minify-css", function() {
    return gulp
        .src(project.src + project.css)
        .pipe(task.srcmap.init())
        .pipe(task.concat("css/style.min.css"))
        .pipe(task.debug())
        .pipe(task.minify.css({debug:true}))
        .pipe(task.srcmap.write("."))
        .pipe(gulp.dest(project.dest));
        // .pipe(gulp.dest('../temp'));
        
});

gulp.task("minify-js", function() {
    return gulp
        .src(project.src + project.js)
        .pipe(task.srcmap.init())
        .pipe(task.concat("js/script.min.js"))
        .pipe(task.minify.js())
        .pipe(task.srcmap.write("."))
        .pipe(gulp.dest(project.dest));
});
gulp.task("optimize-jpg", function() {
    return gulp
        .src(project.src + project.image.jpg)
        .pipe(task.debug())
        .pipe(task.optimize())
        .pipe(gulp.dest(project.dest + "images"));
});
gulp.task("optimize-png", function() {
    return gulp
        .src(project.src + project.image.png)
        .pipe(task.optimize())
        .pipe(gulp.dest(project.dest + "images"));
});
gulp.task("create-webp-jpg", function() {
    return gulp
        .src(project.src + project.image.jpg)
        .pipe(task.webp())
        .pipe(gulp.dest(project.dest + "/webp/jpg"));
});
gulp.task("create-webp-png", function() {
    return gulp
        .src(project.src + project.image.png)
        .pipe(task.webp())
        .pipe(gulp.dest(project.dest + "/webp/png"));
});

gulp.task("create-webp", gulp.parallel("create-webp-png", "create-webp-jpg"));
gulp.task("optimize", gulp.parallel("optimize-png", "optimize-jpg"));
gulp.task("minify", gulp.parallel("minify-js", "minify-css"));
gulp.task("build", gulp.parallel('optimize', 'minify', 'create-webp'));
gulp.task('preview', function() {
    task.serve({
        proxy: project.url,
        port: 8080
    });
    gulp.watch(project.views).on('change', task.serve.reload);
});
gulp.task('autominify-css',function(){
    gulp.watch(project.src+project.css).on('change',gulp.series(['sass','minify-css']));
})