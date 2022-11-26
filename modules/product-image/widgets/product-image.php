<?php

namespace UltimateStoreKit\Modules\ProductImage\Widgets;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Image extends Module_Base {

    public function get_name() {
        return 'usk-product-image';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Image', 'ultimate-store-kit-pro');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-image usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['account', 'my-account', 'address'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-product-image'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    protected function render() {
        $product = wc_get_product();
        $this->__set_editor_builder_data();
        woocommerce_show_product_images();
        // woocommerce_show_product_thumbnails();
    }
}
