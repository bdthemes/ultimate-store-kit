<?php

namespace UltimateStoreKit\Modules\ProductRelated\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Related extends Module_Base {

    public function get_name() {
        return 'usk-product-related';
    }

    public function get_title() {
        return esc_html__('Product Related', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-related';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['wc', 'related', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-product-related'];
        }
    }


    protected function register_controls() {
        $this->start_controls_section(
            'section_product_related_layout',
            [
                'label' => __('Product Related', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'column',
            [
                'label' => __('Select Column', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1'  => __('1 Column', 'ultimate-store-kit'),
                    '2'  => __('2 Column', 'ultimate-store-kit'),
                    '3'  => __('3 Column', 'ultimate-store-kit'),
                    '4'  => __('4 Column', 'ultimate-store-kit'),
                    '5'  => __('5 Column', 'ultimate-store-kit'),
                    '6'  => __('6 Column', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => __('Heading Style', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_align',
            [
                'label'         => __('Heading Alignment', 'ultimate-store-kit'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'    => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'     => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-related .related.products  > h2' => 'text-align: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-related .related.products > h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .usk-product-related .related.products > h2',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label'      => __('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-related .related.products > h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        global $product;
        $column = (int) $settings['column'];

?>
        <div class="usk-product-related">
            <?php if (!is_a($product, 'WC_Product')) {
                $product = wc_get_product(get_the_id());
            }
            woocommerce_related_products(array(
                'posts_per_page' => 4,
                'columns'        => $column,
                'orderby'        => 'rand'
            )); ?>
        </div>

<?php
    }
}
