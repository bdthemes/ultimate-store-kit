<?php

namespace UltimateStoreKit\Modules\ProductStock\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

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

    // public function get_style_depends() {
    //     if ($this->usk_is_edit_mode()) {
    //         return ['usk-all-styles'];
    //     } else {
    //         return ['usk-product-stock'];
    //     }
    // }


    public function register_controls() {
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Stock Status', 'utlimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'stock_status_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-stock .usk-status' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->add_control(
            'stock_status_alignment',
            [
                'label'         => __('Alignment', 'ultiamte-store-kit'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title' => __('Left', 'ultiamte-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'    => [
                        'title' => __('Center', 'ultiamte-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'     => [
                        'title' => __('Right', 'ultiamte-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors'             => [
                    '{{WRAPPER}} .usk-product-stock'    => 'text-align: {{VALUE}}',
                ],
                'separator' => 'after'

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'stock_status_typography',
                'label'     => __('Typography', 'utlimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-product-stock .usk-status',
            ]
        );

        $this->end_controls_section();
    }


    public function render() {
        $this->usk_set_single_post_preview_data();
        global $product;
        if ($product->get_stock_status() === 'instock') {
            $stock_status = esc_html__('In Stock', 'ultimate-store-kit');
        } else {
            $stock_status = esc_html__('Out of Stock', 'ultimate-store-kit');
        }
        printf('<div class="usk-product-stock"><span class="usk-status">%1$s</span></div>', $stock_status);
    }
}
