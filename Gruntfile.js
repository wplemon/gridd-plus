/* global module */
module.exports = function( grunt ) {

    grunt.initConfig({

        // Compile CSS
        sass: {
            main: {
				files: [ {
					expand: true,
					cwd: 'assets/css/',
					src: [ '**/*.scss' ],
					dest: 'assets/css',
					ext: '.css',
					extDot: 'first'
				} ]
            }
		},

		cssmin: {
			target: {
				options: {
					sourceMap: false
				},
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '**/*.css', '!**/*.min.css' ],
						dest: 'assets/css',
						ext: '.min.css'
					}
				]
			}
		},

		uglify: {
			dev: {
				options: {
					mangle: true
				},
				files: [
					{
						expand: true,
						src: [
							'assets/js/*.js',
							'!assets/js/*.min.js'
						],
						dest: '.',
						cwd: '.',
						rename: function( dst, src ) {
							return dst + '/' + src.replace( '.js', '.min.js' );
						}
					}
				]
			}
		},

		postcss: {
			options: {
				processors: [
					require( 'postcss-cssnext' )()
				]
			},
			assetsCSS: {
				src: 'assets/**/*.css'
			}
		},

		// Generate .pot translation file.
		makepot: {
			target: {
				options: {
					type: 'wp-theme',
					domainPath: 'languages'
				}
			}
		},

		// Watch task (run with "grunt watch")
        watch: {
            cssMain: {
                files: [
					'assets/css/*.scss',
					'assets/css/**/*.scss'
                ],
                tasks: [ 'sass:main', 'postcss:assetsCSS', 'cssmin' ]
			},
            js: {
                files: [
					'assets/js/*.js',
					'!assets/js/*.min.js'
                ],
                tasks: [ 'uglify' ]
			}
        }
    });

    grunt.loadNpmTasks( 'grunt-contrib-sass' );
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-po2mo' );

	grunt.registerTask( 'default', [ 'sass:main', 'postcss:assetsCSS', 'cssmin', 'uglify' ] );
	grunt.registerTask( 'css', [ 'sass:main', 'postcss:assetsCSS', 'cssmin' ] );
	grunt.registerTask( 'js', [ 'uglify' ] );
	grunt.registerTask( 'language', [ 'makepot' ] );
};
