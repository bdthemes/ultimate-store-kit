module.exports = function (grunt) {
    grunt.initConfig({
        copy: {
            assets: {
                files: [
                    {
                        expand: true,
                        cwd: "src/images/",
                        src: "**",
                        dest: "assets/images/",
                    },
                    {
                        expand: true,
                        cwd: "src/fonts/",
                        src: "**",
                        dest: "assets/fonts/",
                    },
                    {
                        expand: true,
                        cwd: "src/admin/images/",
                        src: "**",
                        dest: "admin/assets/images/",
                    },
                    {
                        expand: true,
                        cwd: "src/vendor/css/",
                        src: "**",
                        dest: "assets/vendor/css",
                    },
                    {
                        expand: true,
                        cwd: "src/admin/css/",
                        src: ["bdt-uikit.css"],
                        dest: "admin/assets/css/",
                    },
                ],
            },
        },

        sass: {
            options: {
                implementation: require("sass"),
                sourceMap: false,
            },
            outputStyle: "expanded",
            dist: {
                files: [
                    {
                        // widgets
                        expand: true,
                        cwd: "src/scss/widgets",
                        src: "**",
                        dest: "assets/css/",
                        ext: ".css",

                        rename: function (dest, src) {
                            return dest + src.replace(/(.+)\.css$/, "usk-$1.css");
                        },
                    },
                    {
                        expand: true,
                        cwd: "src/scss/",
                        src: [
                            "*",
                            "!admin.scss",
                            "!admin-notice.scss",
                            "!ultimate-builder.scss",
                            "!tooltip.scss",
                            "!star.scss",
                            "!overrides.scss",
                            "!modal.scss",
                            "!elementor.scss",
                            "!**/fonts/**",
                            "!**/widgets/**",
                        ],
                        dest: "assets/css/",
                        ext: ".css",

                        rename: function (dest, src) {
                            return dest + src.replace(/(.+)\.css$/, "usk-$1.css");
                        },
                    },
                    {
                        expand: true,
                        cwd: "src/scss/",
                        src: ["admin.scss", "admin-notice.scss", "ultimate-builder.scss"],

                        dest: "admin/assets/css/",
                        ext: ".css",

                        rename: function (dest, src) {
                            return dest + src.replace(/(.+)\.css$/, "usk-$1.css");
                        },
                    },
                ],
            },
        },

        rtlcss: {
            siteRTL: {
                options: {
                    opts: {
                        clean: true,
                    },
                    plugins: [],
                    saveUnmodified: true,
                },

                expand: true,
                cwd: "assets/css/",
                src: ["**/*.css", "!**/*.rtl.css"],
                dest: "assets/css/",
                ext: ".rtl.css",
            },
            adminRTL: {
                options: {
                    opts: {
                        clean: true,
                    },
                    plugins: [],
                    saveUnmodified: true,
                },
                expand: true,
                cwd: "admin/assets/css/",
                src: ["**/*.css", "!**/*.rtl.css"],
                dest: "admin/assets/css/",
                ext: ".rtl.css",
            },
            vendorRTL: {
                options: {
                    opts: {
                        clean: true,
                    },
                    plugins: [],
                    saveUnmodified: true,
                },
                expand: true,
                cwd: "assets/vendor/css/",
                src: ["**/*.css", "!**/*.rtl.css"],
                dest: "assets/vendor/css/",
                ext: ".rtl.css",
            },
        },

        terser: {
            dist: {
                options: {
                    mangle: true,
                },
                files: [
                    {
                        expand: true,
                        cwd: "src/admin/js/",
                        src: "*.js",
                        dest: "admin/assets/js/",
                        ext: ".min.js",
                    },
                    {
                        expand: true,
                        cwd: "src/js/widgets/",
                        src: "*.js",
                        dest: "assets/js/widgets/",
                        ext: ".min.js",
                    },
                    {
                        expand: true,
                        cwd: "src/vendor/js/",
                        src: ["*.js", "!jquery.slickmodal.js"],
                        dest: "assets/vendor/js/",
                        ext: ".min.js",
                    },
                    {
                        expand: true,
                        cwd: "src/vendor/js/",
                        src: "jquery.slickmodal.js",
                        dest: "assets/vendor/js/",
                        ext: ".slickmodal.min.js",
                    },
                    {
                        expand: true,
                        cwd: "src/vendor/js/",
                        src: "tippy.all.min.js",
                        dest: "assets/vendor/js/",
                        ext: ".all.min.js",
                    },
                    {
                        expand: true,
                        cwd: "src/js/",
                        src: ["usk-editor.js", "usk-core.js", "usk-admin.js"],
                        dest: "assets/js/",
                        ext: ".min.js",
                    },
                ],
            },
        },

        concat: {
            widgets: {
                src: [
                    "assets/js/widgets/*",
                ],
                dest: "assets/js/usk-site.min.js",
                ext: "min.js",

                options: {
                    banner: ";(function($, elementor){\n'use strict';\n",
                    footer: "\n})(jQuery, window.elementorFrontend);",
                },
            },
        },

        watch: {
            styles: {
                files: ["src/scss/*.scss", "src/scss/**/*.scss"], // which files to watch
                tasks: ["sass", "rtlcss"],
                options: {
                    nospawn: true,
                },
            },
            scripts: {
                files: ["src/js/*.js", "src/js/**/*.js", "package.json"],
                tasks: ["terser", "concat"],
                options: {
                    spawn: false,
                },
            },
        },
    });

    grunt.loadNpmTasks("grunt-contrib-copy");
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks("grunt-rtlcss");
    grunt.loadNpmTasks("grunt-terser");
    grunt.loadNpmTasks("grunt-contrib-concat");
    grunt.loadNpmTasks("grunt-contrib-watch");

    if (process.env.NODE_ENV === "development") {
        grunt.registerTask("default", [
            "copy",
            "sass",
            "rtlcss",
            "terser",
            "concat",
            "watch",
        ]);
    } else {
        grunt.registerTask("default", [
            "copy",
            "sass",
            "rtlcss",
            "terser",
            "concat",
        ]);
    }
};
