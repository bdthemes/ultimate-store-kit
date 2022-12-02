<?php

namespace UltimateStoreKit\Modules\ProductPrice\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Price extends Module_Base {

    public function get_name() {
        return 'usk-product-price';
    }

    public function get_title() {
        return esc_html__('Product Price', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-price usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['price', 'product price'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'price',
            [
                'label' => __('Product Price', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_align',
            [
                'label'       => __('Alignment', 'ultimate-store-kit'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'  => [
                        'left' => __('Start', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'center' => __('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'right' => __('End', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'     => is_rtl() ? 'left' : 'right',
                'toggle'      => false,
                'label_block' => false,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-price' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'price_regular',
            [
                'label' => __('Regular Price', 'ultimate-store-kit'),
            ]
        );



        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}, {{WRAPPER}} del' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'selector' => '{{WRAPPER}} del',
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'price_sale',
            [
                'label' => __('Sale price ', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'price_color_sale',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ins' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography_sale',
                'selector' => '{{WRAPPER}} ins',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $this->usk_set_single_post_preview_data();



?>

        <div class="usk-product-price">
            <?php
            woocommerce_template_single_price();
            ?>
        </div>

        <style>
            .usk-product-price p {
                margin: 0;
            }

            .usk-product-price ins {
                background: transparent;
            }
        </style>
<?php
    }
}
