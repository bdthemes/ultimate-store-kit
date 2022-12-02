<?php

namespace UltimateStoreKit\Modules\ProductTitle\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Title extends Module_Base {

    public function get_name() {
        return 'usk-product-title';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Title', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-title usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'title', 'heading', 'product'];
    }



    protected function register_controls() {
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Product Title', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-usk-title .product_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}}.elementor-widget-usk-title .product_title',
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
                    '{{WRAPPER}}.elementor-widget-usk-title .product_title'   => 'text-align: {{VALUE}}; margin: 0;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $this->usk_set_single_post_preview_data();
        woocommerce_template_single_title();
    }
}
