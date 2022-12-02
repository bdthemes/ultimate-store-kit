<?php

namespace UltimateStoreKit\Modules\ProductStock\Widgets;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Stock extends Module_Base {

    public function get_name() {
        return 'usk-produt-stock';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Stock', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-stock usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'stock', 'heading', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-product-stock'];
        }
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Product Stock', 'ultimate-store-kit'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $this->usk_set_single_post_preview_data();
        global $product;
        echo wc_get_stock_html($product);
    }
}
