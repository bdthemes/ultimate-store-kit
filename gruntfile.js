module.exports = function (grunt) {
    const jit_grunt = require('jit-grunt');
    const sass = require('node-sass');

    grunt.initConfig({
        sass: {
            dist: {
                options: {
                    implementation: sass
                },
                files: {
                    'assets/css/ultimate-store-kit-site.css': 'assets/scss/ultimate-store-kit-site.scss',
                    'assets/css/ultimate-store-kit-editor.css': 'assets/scss/ultimate-store-kit-editor.scss',
                    'assets/css/ultimate-store-kit-preview.css': 'assets/scss/ultimate-store-kit-preview.scss',
                    'assets/css/ultimate-store-kit-font.css': 'assets/scss/ultimate-store-kit-font.scss',
                    // 'assets/css/admin.css': 'assets/scss/admin.scss',
                    'admin/assets/css/usk-admin.css': 'assets/scss/admin.scss',
                    'assets/css/elementor.css': 'assets/scss/elementor.scss',
                    // 'assets/css/overrides.css': 'vendor/css/slickmodal.css',

                    //PAGES
                    'assets/css/usk-page-checkout.css': 'assets/scss/widgets/page-checkout.scss',
                    'assets/css/usk-page-order.css': 'assets/scss/widgets/page-order.scss',
                    'assets/css/usk-page-cart.css': 'assets/scss/widgets/page-cart.scss',
                    'assets/css/usk-page-my-account.css': 'assets/scss/widgets/page-my-account.scss',
                    'assets/css/usk-page-single.css': 'assets/scss/widgets/page-single.scss',

                    //Widget Css
                    'assets/css/usk-florence-grid.css': 'assets/scss/widgets/florence-grid.scss',
                    'assets/css/usk-florence-carousel.css': 'assets/scss/widgets/florence-carousel.scss',
                    'assets/css/usk-glossy-grid.css': 'assets/scss/widgets/glossy-grid.scss',
                    'assets/css/usk-glossy-carousel.css': 'assets/scss/widgets/glossy-carousel.scss',
                    'assets/css/usk-product-accordion.css': 'assets/scss/widgets/product-accordion.scss',
                    'assets/css/usk-product-category.css': 'assets/scss/widgets/product-category.scss',
                    'assets/css/usk-add-to-cart.css': 'assets/scss/widgets/add-to-cart.scss',
                    'assets/css/usk-florence-carousel.css': 'assets/scss/widgets/florence-carousel.scss',
                    'assets/css/usk-sub-category.css': 'assets/scss/widgets/sub-category.scss',
                    'assets/css/usk-sub-category-carousel.css': 'assets/scss/widgets/sub-category-carousel.scss',
                    'assets/css/usk-product-category-carousel.css': 'assets/scss/widgets/product-category-carousel.scss',
                    'assets/css/usk-product-image-accordion.css': 'assets/scss/widgets/product-image-accordion.scss',
                    'assets/css/usk-product-list.css': 'assets/scss/widgets/product-list.scss',
                    'assets/css/usk-product-reviews.css': 'assets/scss/widgets/product-reviews.scss',
                    'assets/css/usk-product-review-carousel.css': 'assets/scss/widgets/product-review-carousel.scss',
                    'assets/css/usk-mini-cart.css': 'assets/scss/widgets/mini-cart.scss',
                    'assets/css/usk-product-table.css': 'assets/scss/widgets/product-table.scss',
                    'assets/css/usk-shiny-grid.css': 'assets/scss/widgets/shiny-grid.scss',
                    'assets/css/usk-shiny-carousel.css': 'assets/scss/widgets/shiny-carousel.scss',
                    'assets/css/usk-showcase-slider.css': 'assets/scss/widgets/showcase-slider.scss',
                    'assets/css/usk-brand-grid.css': 'assets/scss/widgets/brand-grid.scss',
                    'assets/css/usk-brand-carousel.css': 'assets/scss/widgets/brand-carousel.scss',
                    'assets/css/usk-info-list.css': 'assets/scss/widgets/info-list.scss',
                    'assets/css/usk-featured-box.css': 'assets/scss/widgets/featured-box.scss',
                    'assets/css/usk-heaven-slider.css': 'assets/scss/widgets/heaven-slider.scss',
                    'assets/css/usk-mentor-slider.css': 'assets/scss/widgets/mentor-slider.scss',
                    'assets/css/usk-filter.css': 'assets/scss/widgets/filter.scss',


                    'assets/css/usk-product-related.css': 'assets/scss/widgets/product-related.scss',
                    'assets/css/usk-product-tabs.css': 'assets/scss/widgets/product-tabs.scss',
                    'assets/css/usk-product-image.css': 'assets/scss/widgets/product-image.scss',
                    //EDD
                    'assets/css/usk-edd-category-carousel.css': 'assets/scss/widgets/edd-category-carousel.scss',
                    'assets/css/usk-edd-category-grid.css': 'assets/scss/widgets/edd-category-grid.scss',
                    'assets/css/usk-edd-beauty-grid.css': 'assets/scss/widgets/edd-beauty-grid.scss',
                    'assets/css/usk-edd-classic-grid.css': 'assets/scss/widgets/edd-classic-grid.scss',
                    'assets/css/usk-edd-standard-grid.css': 'assets/scss/widgets/edd-standard-grid.scss',
                    'assets/css/usk-edd-trendy-grid.css': 'assets/scss/widgets/edd-trendy-grid.scss',
                    'assets/css/usk-edd-beauty-carousel.css': 'assets/scss/widgets/edd-beauty-carousel.scss',
                    'assets/css/usk-edd-classic-carousel.css': 'assets/scss/widgets/edd-classic-carousel.scss',
                    'assets/css/usk-edd-standard-carousel.css': 'assets/scss/widgets/edd-standard-carousel.scss',
                    'assets/css/usk-edd-trendy-carousel.css': 'assets/scss/widgets/edd-trendy-carousel.scss',
                    'assets/css/usk-all-styles.css': 'assets/scss/usk-all-styles.scss'
                }
            }
        },
        rtlcss: {
            myTask: {
                // task options
                options: {
                    // rtlcss options
                    opts: {
                        clean: true
                    },
                    // rtlcss plugins
                    plugins: [],
                    // save unmodified files
                    saveUnmodified: true
                },
                expand: true,
                cwd: 'assets/css/',
                dest: 'assets/css/',
                src: ['**/*.css', '!**/*.rtl.css'],
                ext: '.rtl.css'
            }
        },

        terser: {
            options: {
                compress: false
            },
            widget_js: {

                files: {
                    'assets/js/ultimate-store-kit-site.js': [
                        // 'assets/js/widgets/usk-compare-products.js',
                        'assets/js/widgets/usk-brand-carousel.js',
                        'assets/js/widgets/usk-florence-carousel.js',
                        'assets/js/widgets/usk-glossy-carousel.js',
                        'assets/js/widgets/usk-product-accordion.js',
                        'assets/js/widgets/usk-product-image-accordion.js',
                        'assets/js/widgets/usk-product-table.js',
                        'assets/js/widgets/usk-product-review-carousel.js',
                        'assets/js/widgets/usk-mini-cart.js',
                        'assets/js/widgets/usk-shiny-grid.js',
                        'assets/js/widgets/usk-shiny-carousel.js',
                        'assets/js/widgets/usk-showcase-slider.js',
                        'assets/js/widgets/usk-sub-category.js',
                        'assets/js/widgets/usk-sub-category-carousel.js',
                        'assets/js/widgets/usk-product-category-carousel.js',
                        'assets/js/widgets/usk-heaven-slider.js',
                        'assets/js/widgets/usk-mentor-slider.js',
                        //EDD
                        'assets/js/widgets/usk-edd-beauty-carousel.js',
                        'assets/js/widgets/usk-edd-classic-carousel.js',
                        'assets/js/widgets/usk-edd-standard-carousel.js',
                        'assets/js/widgets/usk-edd-trendy-carousel.js',
                        'assets/js/widgets/usk-edd-product-review-carousel.js',
                        'assets/js/widgets/usk-edd-category-carousel.js',

                        //CHECKOUT PAGE
                        'assets/js/widgets/usk-page-checkout.js',
                        // 'assets/js/widgets/usk-checkout-login-form.js',
                    ]
                }
            },
            plugin_js: {
                options: {
                    mangle: true
                },
                files: {
                    'assets/js/ultimate-store-kit-core.min.js': ['assets/js/ultimate-store-kit-core.js'],
                    'assets/js/ultimate-store-kit-site.min.js': ['assets/js/ultimate-store-kit-site.js'],
                    'assets/js/ultimate-store-kit-editor.min.js': ['assets/js/ultimate-store-kit-editor.js'],
                    'assets/js/ultimate-store-kit-admin.min.js': ['assets/js/ultimate-store-kit-admin.js'],
                    'assets/vendor/js/micromodal.min.js': ['assets/vendor/js/micromodal.js'],
                    'assets/vendor/js/datatables.min.js': ['assets/vendor/js/datatables.js'],
                    'assets/vendor/js/usk-accordion.min.js': ['assets/vendor/js/usk-accordion.js'],
                }
            }
        },

        watch: {
            styles: {
                files: ['assets/scss/**/*.scss'], // which files to watch
                tasks: ['sass', 'rtlcss'],
                options: {
                    nospawn: true
                }
            },
            scripts: {
                files: ['assets/js/widgets/*.js'],
                tasks: ['terser'],
                options: {
                    spawn: false,
                },
            }
        }
    });

    grunt.loadNpmTasks('grunt-rtlcss');
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks('grunt-terser');
    grunt.loadNpmTasks("grunt-sass");
    grunt.registerTask('default', ['sass', 'terser', 'watch']);
};