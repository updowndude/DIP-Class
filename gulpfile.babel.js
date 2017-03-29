// by correy winke
// 10/17/16
// import the libraries
import gulp from 'gulp';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import csswring from 'csswring';
import cssnext from 'postcss-cssnext';
import gulpWebpack from 'webpack-stream';
import livereload from 'gulp-livereload';
import webpack from 'webpack';

// build out css using sass and postcsss
gulp.task('sass', () => {
	// extra transfromer after sass to css
	const processors = [
		// minifier for css
		csswring,
		// use new css
		cssnext
	];

	// compile sass to css then use post css
	return gulp.src('sass/myStyle.sass')
		.pipe(sass().on('error', sass.logError))
        // transfrome css with transfromer
		.pipe(postcss(processors))
    .pipe(gulp.dest('dist'))
	.pipe(livereload());
});

gulp.task('jsx', () => {
	return gulp.src('js/layout.js')
		.pipe(gulpWebpack({
            // handles the build step for new Javascript to older Javascript
			module: {
				loaders: [{
					test: /.js?$/,
					loader: 'babel-loader',
					include: __dirname,
					exclude: /node_modules/,
					query: {
						presets: [['es2015', {modules: false}]],
						plugins: ['async-to-promises']
					}
				}]
			},
			output: {
				filename: 'my-com.js'
			},
			// devtool: 'inline-sourcemap',
			plugins: [new webpack.optimize.UglifyJsPlugin()]
		}))
		.pipe(gulp.dest('dist'))
    .pipe(livereload());
});

// look at file and reload the browser
gulp.task('index', () => {
	gulp.src('index.php')
    .pipe(livereload());
});

gulp.task('php', () => {
	gulp.src('php/**/*.php')
    .pipe(livereload());
});

// watch's file then fire off a task tom complete
gulp.task('default', () => {
	livereload({start: true});
	gulp.watch('sass/*.sass', ['sass']);
	gulp.watch('js/*.js', ['jsx']);
	gulp.watch('index.php', ['index']);
	gulp.watch('php/**/*.php', ['php']);
});
