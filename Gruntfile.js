module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';'
      },
      joust: {
        src: [
          // The order is important!
          'src/js/libs/jquery.js',
          'src/js/libs/underscore.js',
          'src/js/libs/backbone.js',
          'src/js/libs/backbone.upload.js',
          'src/js/views/NodeView.js',
          'src/js/views/TextView.js',
          'src/js/views/ImageView.js',
          'src/js/models/NodeModel.js',
          'src/js/models/TextModel.js',
          'src/js/models/ImageModel.js',
          'src/js/models/UploadModel.js',
          'src/js/collections/NodeCollection.js',
          'src/js/app.js',
        ],
        dest: 'src/js/joust.js'
      },
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'

      },
      dist: {
        files: {
          'public/js/<%= pkg.name %>.min.js': ['<%= concat.joust.dest %>'],
        }
      }
    },
    jshint: {
          files: ['Gruntfile.js', 'src/js/views/*.js', 'src/js/models/*.js', 'src/js/collections/*.js'],
          options: {
            globals: {
              jQuery: true,
              console: true,
              module: true,
              document: true
            }
          }
    },
    clean: {
      js: ['src/js/<%= pkg.name %>.js']
    },
    sass: {
        dist: {
          options: {
            style: 'compressed'
          },
          files: {
            'public/css/joust.min.css': 'src/css/joust.scss',
          }
        }
      }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'clean', 'sass']);

};