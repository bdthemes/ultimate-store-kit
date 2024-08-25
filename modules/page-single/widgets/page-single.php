<?php

namespace UltimateStoreKit\Modules\PageSingle\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Page_Single extends Module_Base {

    // public function get_show_in_panel_tags() {
    //     return ['shop_single'];
    // }

    public function get_name() {
        return 'usk-page-single';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Single Product (Page)', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-page-single usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'additional', 'info'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-page-single'];
        }
    }

    public function register_controls() {
        $this->register_controls_title();
        $this->register_controls_price();
        $this->register_controls_add_to_cart();
        $this->register_controls_tabs();
        $this->register_controls_product_related();
        $this->start_controls_section(
            'section_style_badge',
            [
                'label' => __('Sale Badge', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'sale_badge_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-single span.onsale' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'sale_badge_background',
                'label'     => __('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-page-single span.onsale',
            ]
        );
        $this->end_controls_section();
    }
    protected function register_controls_title() {
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
                    '{{WRAPPER}} .woocommerce div.product .product_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .woocommerce div.product .product_title',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls_price() {
        $this->start_controls_section(
            'price',
            [
                'label' => __('Product Price', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product p.price,{{WRAPPER}} .woocommerce div.product span.price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .woocommerce div.product p.price ins, {{WRAPPER}} .woocommerce div.product span.price ins' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'selector' => '{{WRAPPER}} .woocommerce div.product p.price,{{WRAPPER}} .woocommerce div.product span.price',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'short_desc_color',
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

        $this->end_controls_section();
    }
    protected function register_controls_add_to_cart() {

        $this->start_controls_section(
            'section_style_add_to_cart',
            [
                'label' => __('Add To Cart', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_add_to_cart_style');

        $this->start_controls_tab(
            'tab_add_to_cart_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'add_to_cart_text_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product form.cart .button' => 'color: {{VALUE}}; cursor:pointer;'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'add_to_cart_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'types' => [
                    'classic', 'gradient'
                ],
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#1E87F0',
                    ],
                ],
                'selector' => '{{WRAPPER}} .woocommerce div.product form.cart .button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'add_to_cart_border',
                'label'          => __('Border', 'ultimate-store-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '0',
                            'left'     => '0',
                            'isLinked' => false,
                        ],
                    ],
                    // 'color'  => [
                    //     'default' => '#8D99AE',
                    // ],
                ],
                'selector' => '{{WRAPPER}} .woocommerce div.product form.cart .button',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'add_to_cart_border_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product form.cart .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // $this->add_responsive_control(
        //     'add_to_cart_padding',
        //     [
        //         'label' => __('Padding', 'ultimate-store-kit'),
        //         'type' => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', 'em', '%'],
        //         'selectors' => [
        //             '{{WRAPPER}} .woocommerce div.product form.cart .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );
        $this->add_responsive_control(
            'add_to_cart_size',
            [
                'label'         => __('Size', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product form.cart *' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'add_to_cart_typography',
                'selector' => '{{WRAPPER}} .woocommerce div.product form.cart .button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'add_to_cart_box_shadow',
                'selector' => '{{WRAPPER}} .woocommerce div.product form.cart .button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_add_to_cart_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'add_to_cart_hover_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product form.cart .button:hover, {{WRAPPER}} .woocommerce div.product form.cart .button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'add_to_cart_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product form.cart .button:hover, {{WRAPPER}} .woocommerce div.product form.cart .button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'add_to_cart_hover_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .woocommerce div.product form.cart .button:hover, {{WRAPPER}} .elementor-button:focus',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'qty_style',
            [
                'label'     => __('Quantity Field', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'qty_fields_width',
            [
                'label' => esc_html__('Width', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-single .woocommerce .quantity .qty'  => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_fields_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'color: {{VALUE}} ',
                    '{{WRAPPER}} .quantity input[type=number]::placeholder' => 'color: {{VALUE}} ',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'qty_fields_background',
                'exclude'  => ['image'],
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'qty_fields_border',
                'label'          => __(
                    'Border',
                    'ultimate-store-kit'
                ),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color'  => [
                        'default' => '#a4afb7',
                    ],
                ],
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'qty_fields_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '3',
                    'right'    => '3',
                    'bottom'   => '3',
                    'left'     => '3',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_fields_padding',
            [
                'label'   => __('Padding', 'ultimate-store-kit'),
                'type'    => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_fields_margin',
            [
                'label'   => __('Margin', 'ultimate-store-kit'),
                'type'    => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'qty_fields_typography',
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'qty_fields_shadow',
                'selector' => '{{WRAPPER}} .quantity input[type=number]'
            ]
        );
        $this->end_controls_section();
    }

    protected function register_controls_tabs() {

        // $this->start_controls_section(
        //     'tabs_nav_style_section',
        //     [
        //         'label' => __('Tabs', 'ultimate-store-kit'),
        //         'tab'   => Controls_Manager::TAB_STYLE,
        //     ]
        // );

        // $this->add_responsive_control(
        //     'tabs_nav_align',
        //     [
        //         'label'     => __('Alignment', 'ultimate-store-kit'),
        //         'type'      => Controls_Manager::CHOOSE,
        //         'options'   => [
        //             'left'   => [
        //                 'title' => __('Left', 'ultimate-store-kit'),
        //                 'icon'  => 'eicon-text-align-left',
        //             ],
        //             'center' => [
        //                 'title' => __(
        //                     'Center',
        //                     'ultimate-store-kit'
        //                 ),
        //                 'icon'  => 'eicon-text-align-center',
        //             ],
        //             'right'  => [
        //                 'title' => __(
        //                     'Right',
        //                     'ultimate-store-kit'
        //                 ),
        //                 'icon'  => 'eicon-text-align-right',
        //             ],
        //         ],
        //         'desktop_default' => 'left',
        //         'tablet_default' => 'left',
        //         'mobile_default' => 'left',
        //         'toggle' => false,
        //         'selectors' => [
        //             '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs' => 'justify-content: {{VALUE}};',
        //         ],
        //     ]
        // );

        // $this->add_responsive_control(
        //     'tabs_nav_padding',
        //     [
        //         'label'      => esc_html__('Padding', 'ultimate-store-kit'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', 'em', '%'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );

        // $this->add_responsive_control(
        //     'tabs_nav_item_radius',
        //     [
        //         'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', 'em', '%'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );
        // $this->add_group_control(
        //     Group_Control_Border::get_type(),
        //     [
        //         'name'        => 'tabs_nav_border',
        //         'selector'    => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs',
        //     ]
        // );

        // $this->end_controls_section();

        $this->start_controls_section(
            'tabs_nav_item_style_section',
            [
                'label' => __('Tabs Item', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'tabs_nav_item_padding',
            [
                'label'      => esc_html__(
                    'Padding',
                    'ultimate-store-kit'
                ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_item_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tabs_nav_item_typography',
                'selector' => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_nav_item_border',
                'selector'    => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a',
            ]
        );


        $this->add_responsive_control(
            'tabs_nav_item_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_tabs_nav');

        $this->start_controls_tab(
            'tabs_nav_item_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_item_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a',
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_item_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_item_color_hover',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg_hover',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover',
            ]
        );

        $this->add_control(
            'tabs_nav_item_border_color_hover',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'tabs_nav_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_active',
            [
                'label' => __('Active', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_color_active',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li.active a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_bg_active',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li.active a',
            ]
        );

        $this->add_control(
            'tabs_nav_item_border_color_active',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'tabs_nav_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce div.product .woocommerce-tabs ul.tabs li.active a' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_content',
            [
                'label' => __('Tabs Content', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_content_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-single .woocommerce-tabs .wc-tab' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_content_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-page-single .woocommerce-tabs .wc-tab',
            ]
        );

        $this->add_responsive_control(
            'tabs_content_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-single .woocommerce-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_content_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-single .woocommerce-tabs .wc-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_content_border',
                'selector'    => '{{WRAPPER}} .usk-page-single .woocommerce-tabs .wc-tab',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_product_related() {

        $this->start_controls_section(
            'section_style_product_related',
            [
                'label' => __('Related Product', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'tabs_product_related'
        );
        $this->start_controls_tab(
            'tab_product_related_heading',
            [
                'label' => __('Heading', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'related_heading_color',
            [
                'label'     => __( 'Color', 'ultimate-store-kit' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-single .related.products > h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'related_heading_typography',
                'selector' => '{{WRAPPER}} .usk-page-single .related.products > h2',
            ]
        );

        $this->add_responsive_control(
            'related_heading_margin',
            [
                'label'      => __('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px', 'em', '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-related .related.products > h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_product_related_title',
            [
                'label' => __('Title', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'related_title_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product .woocommerce-loop-product__title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'related_title_typography',
                'selector' => '{{WRAPPER}} .woocommerce ul.products li.product .woocommerce-loop-product__title',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_product_related_price',
            [
                'label' => __('Price', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'related_price_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product .price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'related_price_typography',
                'selector' => '{{WRAPPER}} .woocommerce ul.products li.product .price',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_product_related_cart',
            [
                'label' => __('Cart', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'related_cart_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product a.button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'related_cart_background_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce ul.products li.product a.button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'related_cart_padding',
            [
                'label'                 => __( 'Padding', 'ultimate-store-kit' ),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .woocommerce ul.products li.product a.button'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'related_cart_typography',
                'label'     => __( 'Typography', 'ultimate-store-kit' ),
                'selector'  => '{{WRAPPER}} .woocommerce ul.products li.product a.button',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render() { 
        $product_id = '';
        $product = wc_get_product(get_the_ID());
        if ($product) {
            $product_id = $product->get_id();
        }        
        ?>
        <div class="usk-page-single">
            <?php echo do_shortcode('[product_page id="' . $product_id . '"]'); ?>
        </div>
        <?php
    }
}
