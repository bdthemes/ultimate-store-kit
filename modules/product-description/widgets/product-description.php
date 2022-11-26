<?php

namespace UltimateStoreKit\Modules\ProductDescription\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Description extends Module_Base {

    public function get_name() {
        return 'usk-product-description';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Description', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-description';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'description', 'product'];
    }


    protected function register_controls() {
        $this->start_controls_section(
            'section_sd_style',
            [
                'label' => __('Product Description', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sd_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-product-details__short-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sd_color_typo',
                'selector' => '{{WRAPPER}} .woocommerce-product-details__short-description',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'   => __('Alignment', 'ultimate-store-kit'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'toggle'  => false,
                'options' => [
                    'left'   => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify'  => [
                        'title' => __('Justify', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-product-details__short-description'   => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .woocommerce-product-details__short-description p'   => 'margin: 0;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // global $product;
        // $product = wc_get_product();
        woocommerce_template_single_excerpt();
    }
}
