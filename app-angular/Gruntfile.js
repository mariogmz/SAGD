module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    concat: {
      libs: {
        options: {
          separator: ';'
        },
        src: [
          './bower_components/angular/angular.js',
          './bower_components/angular-ui-router/release/angular-ui-router.js',
          './bower_components/satellizer/satellizer.js'
        ],
        dest: './public/libs/frontend.js'
      },
      js: {
        src: [
          './app/**/*module*.js',
          './app/**/*.js'
        ],
        dest: './public/js/all.js'
      }
    },
    sass: {
      dist: {
        options : {
          style: 'expanded'
        },
        files: {
          './public/css/application.css' : './app/stylesheets/application.scss'
        }
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      libs: {
        files: {
          './public/libs/frontend.min.js' : './public/libs/frontend.js'
        }
      }
    },
    watch: {
      libs: {
        files: [
          './bower_components/angular/angular.js',
          './bower_components/angular-ui-router/release/angular-ui-router.js',
          './bower_components/satellizer/satellizer.js'
        ],
        tasks: ['concat:libs', 'uglify:libs'],
        options: {
          livereload: true
        }
      },
      js: {
        files: ['./app/**/*.js'],
        tasks: ['concat:js'],
        options: {
          livereload: true
        }
      },
      sass: {
        files: ['./app/stylesheets/**/*.scss'],
        tasks: ['sass'],
        options: {
          livereload: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('default', ['watch']);
};
