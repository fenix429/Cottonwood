/*global module:false*/
module.exports = function(grunt) {

// Project configuration.
grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
        ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
    // Task configuration.
    concat: {
        options: {
            banner: '<%= banner %>',
            stripBanners: true
        },
        dist: {
            src: ['public/scripts/*.js'],
            dest: 'tmp/scripts_concat.js'
        }
    },
    uglify: {
        options: {
            banner: '<%= banner %>'
        },
        dist: {
            src: '<%= concat.dist.dest %>',
            dest: 'public/<%= pkg.name %>.min.js'
        }
    },
    jshint: {
        options: {
            curly: true,
            eqeqeq: true,
            immed: true,
            latedef: true,
            newcap: true,
            noarg: true,
            sub: true,
            undef: true,
            unused: true,
            boss: true,
            eqnull: true,
            browser: true,
            globals: {
                require: true,
                define: true
            }
        },
        gruntfile: {
            src: 'Gruntfile.js'
        },
        app_files: {
            src: ['public/scripts/*.js']
        },
        lib_test: {
            src: ['lib/**/*.js', 'test/**/*.js']
        }
    },
    less: {
        options: {
            paths: ['public/components'],
            //dumpLineNumbers: true
        },
        compile: {
            files: [{
                expand: true,        // Enable dynamic expansion.
                cwd: 'public/less/', // Src matches are relative to this path.
                src: ['**/*.less'],  // Actual pattern(s) to match.
                dest: 'public/styles/', // Destination path prefix.
                ext: '.css',         // Dest filepaths will have this extension.
            }]
        }
    },
    /*
    qunit: {
        files: ['test/ ** /*.html'] // <- remove spaces when uncommenting
    },
    */
    watch: {
        gruntfile: {
            files: '<%= jshint.gruntfile.src %>',
            tasks: ['jshint:gruntfile']
        },
        less_files: {
            files: 'public/less/*.less',
            tasks: ['less']
        }
        /*,
        app_files: {
            files: '<%= jshint.app_files.src %>',
            tasks: ['jshint:app_files', 'qunit']
        },
        lib_test: {
            files: '<%= jshint.lib_test.src %>',
            tasks: ['jshint:lib_test', 'qunit']
        }*/
    }
});

// These plugins provide necessary tasks.
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-less');
grunt.loadNpmTasks('grunt-contrib-uglify');
//grunt.loadNpmTasks('grunt-contrib-qunit');
grunt.loadNpmTasks('grunt-contrib-jshint');
grunt.loadNpmTasks('grunt-contrib-watch');

// Default task.
grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify']);

};