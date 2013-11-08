module.exports = function (grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		less: {
			development: {
				options: {
					paths: ["public/assets/less/bootstrap"]
				},
				files: {
					"public/assets/css/bootstrap.css": "public/assets/less/bootstrap/bootstrap.less",
					"public/assets/css/patchnotes.css": "public/assets/less/patchnotes.less"
				}
			},
			production: {
				options: {
					paths: ["public/assets/less/bootstrap"],
					cleancss: true
				},
				files: {
					"public/assets/css/bootstrap.min.css": "public/assets/less/bootstrap/bootstrap.less",
					"public/assets/css/patchnotes.css": "public/assets/less/patchnotes.less"
				}
			}
		},
		watch: {
			scripts: {
				files: ['public/assets/**/*'],
				tasks: ['default'],
				options: {
					spawn: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('default', ['less']);
	grunt.registerTask('production', ['less:production']);

};
