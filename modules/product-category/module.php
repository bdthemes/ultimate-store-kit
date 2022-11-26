<?php

namespace UltimateStoreKit\Modules\ProductCategory;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

    public static function is_active() {
        return class_exists('woocommerce');
    }

    public function get_name() {
        return 'usk-product-category';
    }

    public function get_widgets() {
        return ['Product_Category'];
    }

    public function add_product_post_class($classes) {
        $classes[] = 'product';

        return $classes;
    }

    public function add_products_post_class_filter() {
        add_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function remove_products_post_class_filter() {
        remove_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function register_wc_hooks() {
        wc()->frontend_includes();
    }
}
