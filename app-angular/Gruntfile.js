module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    ngconstant: {
      options: {
        name: 'blocks.env',
        wrap: '(function (){\n  "use strict";\n\n {%= __ngModule %} }());'
      },
      development: {
        options: {
          dest: 'app/blocks/env/env.js',
        },
        constants: {
          'ENV': {
            name: 'development',
            applicationFqdn: "http://api.sagd.app",
            apiNamespace: "/api",
            version: "/v1",
            cache_time: 1,
            cache_whitelist: [
              'codigo_postal',
              'domicilio',
              'familia',
              'garantia',
              'marca',
              'margen',
              'proveedor',
              'subfamilia',
              'unidad'
            ],
            socketEndpoint: 'ws://socket.sagd.app'
          }
        }
      },
      stage: {
        options: {
          dest: 'app/blocks/env/env.js',
        },
        constants: {
          'ENV': {
            name: 'stage',
            applicationFqdn: "https://zegucomarb.dyndns.info:8080",
            apiNamespace: "/api",
            version: "/v1",
            cache_time: 2,
            cache_whitelist: [
              'codigo_postal',
              'domicilio',
              'familia',
              'garantia',
              'marca',
              'margen',
              'proveedor',
              'subfamilia',
              'unidad'
            ],
            socketEndpoint: 'wss://zegucomarb.dyndns.info:8081'
          }
        }
      }
    },
    copy: {
      main: {
        files: [{
          expand: true,
          flatten: true,
          src: ['./bower_components/font-awesome/fonts/*'],
          dest: './public/fonts/',
          filter: 'isFile'
        }]
      }
    },
    concat: {
      libs: {
        options: {
          separator: ';'
        },
        src: [
          './bower_components/api-check/dist/api-check.js',
          './bower_components/jquery/dist/jquery.js',
          './bower_components/angular/angular.js',
          './bower_components/angular-animate/angular-animate.js',
          './bower_components/angular-messages/angular-messages.js',
          './bower_components/angular-ui-router/release/angular-ui-router.js',
          './bower_components/satellizer/satellizer.js',
          './bower_components/angular-formly/dist/formly.js',
          './bower_components/angularUtils-pagination/dirPagination.js',
          './bower_components/bootstrap/dist/js/bootstrap.js',
          './bower_components/pnotify/src/pnotify.core.js',
          './bower_components/pnotify/src/pnotify.desktop.js',
          './bower_components/pnotify/src/pnotify.buttons.js',
          './bower_components/pnotify/src/pnotify.nonblock.js',
          './bower_components/pnotify/src/pnotify.callbacks.js',
          './bower_components/lscache/lscache.js',
          './node_modules/socket.io/node_modules/socket.io-client/socket.io.js',
          './bower_components/angular-socket-io/socket.js'
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
          './bower_components/api-check/dist/api-check.js',
          './bower_components/jquery/dist/jquery.js',
          './bower_components/angular/angular.js',
          './bower_components/angular-animate/angular-animate.js',
          './bower_components/angular-messages/angular-messages.js',
          './bower_components/angular-ui-router/release/angular-ui-router.js',
          './bower_components/satellizer/satellizer.js',
          './bower_components/angular-formly/dist/formly.js',
          './bower_components/angularUtils-pagination/dirPagination.js',
          './bower_components/bootstrap/dist/js/bootstrap.js',
          './bower_components/pnotify/src/pnotify.core.js',
          './bower_components/pnotify/src/pnotify.desktop.js',
          './bower_components/pnotify/src/pnotify.buttons.js',
          './bower_components/pnotify/src/pnotify.nonblock.js',
          './bower_components/pnotify/src/pnotify.callbacks.js'
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

  grunt.loadNpmTasks('grunt-ng-constant');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('dev', function() {
    grunt.task.run([
      'ngconstant:development',
      'copy',
      'concat',
      'uglify',
      'sass'
    ]);
  });

  grunt.registerTask('stage', function() {
    grunt.task.run([
      'ngconstant:stage',
      'copy',
      'concat',
      'uglify',
      'sass'
    ]);
  });

  grunt.registerTask('default', ['watch']);
};
