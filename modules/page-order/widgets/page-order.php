<?php

namespace UltimateStoreKit\Modules\PageOrder\Widgets;

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
class Page_Order extends Module_Base {

    public function get_show_in_panel_tags() {
        return ['shop_single'];
    }

    public function get_name() {
        return 'usk-page-order';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Order Page', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-page-order usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'additional', 'info'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-add-to-cart'];
        }
    }
    protected function register_controls() {
        $this->start_controls_section(
            'section_layout_thankyou_orders',
            [
                'label' => __('ThankYou Order', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'thankyou_padding',
                'label'     => __('Padding', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order .usk-page-order-heading',
            ]
        );
        $this->add_control(
            'thankyou_show_order_id',
            [
                'label'         => __('Show Order ID', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'separator'     => 'after'
            ]
        );
        $this->add_control(
            'thankyou_order_received_text',
            [
                'label'       => __('Description', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => __('Thank you. Your order has been received.', 'ultimate-store-kit'),
                'placeholder' => __('Thank you. Your order has been received.', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'thankyour_order_alignment',
            [
                'label'         => __('Alignment', 'ultimate-store-kit'),
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
                'default'       => 'center',
                'toggle'        => false,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .usk-page-order-heading' => 'text-align:{{VALUE}}; display:block;'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_thankyou_orders_style',
            [
                'label' => __('Style', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'tabs_style_thankyou_order'
        );
        $this->start_controls_tab(
            'tab_style_thankyou_order_heading',
            [
                'label' => __('H E A D I N G', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .thankyou-order-heading ' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_margin',
            [
                'label'                 => __('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .thankyou-order-heading'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'heading_typography',
                'label'     => __('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}}  .usk-page-order .thankyou-order-heading',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_style_thankyou_order_desc',
            [
                'label' => __('D E S C R I P T I O N', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'desc_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .thankyou-order-desc ' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_margin',
            [
                'label'                 => __('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .thankyou-order-desc'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'desc_typography',
                'label'     => __('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order .thankyou-order-desc',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // order detals

        $this->start_controls_section(
            'style_section_header',
            [
                'label' => esc_html__('Header', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'header_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title, {{WRAPPER}} .usk-page-order .woocommerce-order-downloads__title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'header_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title, {{WRAPPER}} .usk-page-order .woocommerce-order-downloads__title'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'header_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title, {{WRAPPER}} .usk-page-order .woocommerce-order-downloads__title'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'header_alignment',
            [
                'label'         => __('Alignment', 'ultimate-store-kit'),
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
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title, {{WRAPPER}} .usk-page-order .woocommerce-order-downloads__title' => 'text-align:{{VALUE}}'
                ],
                'default'       => 'left',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'header_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title, {{WRAPPER}} .usk-page-order .woocommerce-order-downloads__title',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_table',
            [
                'label' => __('Table', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'stripe_style',
            [
                'label' => __('Stripe Style', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_responsive_control(
            'table_padding',
            [
                'label'      => __('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order  ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'table_margin',
            [
                'label'      => __('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order  ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'table_border',
                'label'     => __('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order ',
            ]
        );

        $this->add_responsive_control(
            'table_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order  ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_table_header',
            [
                'label' => esc_html__('Table : Header', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_text_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order  thead th' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_background',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order  thead' => 'background: {{VALUE}}',
                ],
            ]
        );
        // $this->add_group_control(
        //     Group_Control_Background::get_type(),
        //     [
        //         'name'      => 'heading_background',
        //         'label'     => esc_html__('Background', 'ultimate-store-kit'),
        //         'types'     => ['classic', 'gradient'],
        //         'selector'  => '{{WRAPPER}} .usk-page-order  thead th',
        //     ]
        // );
        $this->add_responsive_control(
            'table_header_padding',
            [
                'label'      => __('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order  thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'table_heading_border_width!' => 'none'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'table_heading_border',
                'label'     => __('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order  thead th',
            ]
        );
        $this->add_responsive_control(
            'table_header_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order  thead th' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'table_heading_border_width!' => 'none'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'table_heading_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order  thead th',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_table_body',
            [
                'label' => esc_html__('Table : Body', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'cell_border',
                'label'     => __('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order tr',
            ]
        );

        $this->add_responsive_control(
            'cell_padding',
            [
                'label'      => __('Cell Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-page-order tr' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'body_text_typography',
                'selector' => '{{WRAPPER}} .usk-page-order td',
            ]
        );

        $this->start_controls_tabs('tabs_body_style');

        $this->start_controls_tab(
            'tab_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'normal_background',
            [
                'label'     => __('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'normal_color',
            [
                'label'     => __('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(odd) :is(th, td, span, .amount)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Link Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(odd) :is(th, td, span, .amount) a' => 'color: {{VALUE}}',
                ],
            ]
        );



        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_stripe',
            [
                'label'     => __('Stripe', 'ultimate-store-kit'),
                'condition' => [
                    'stripe_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'stripe_background',
            [
                'label'     => __('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe_style' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'stripe_color',
            [
                'label'     => __('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(even) :is(th, td, span, .amount)' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe_style' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'stripe_link_color',
            [
                'label'     => __('Link Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tbody tr:nth-child(even) :is(th, td, span, .amount) a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe_style' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_table_footer',
            [
                'label' => esc_html__('Table : Footer', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'tabs_style_table_footer'
        );
        $this->start_controls_tab(
            'table_footer_tab_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'table_footer_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tfoot tr:nth-child(odd) :is(th, td, span, .amount)' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'table_footer_bg_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tfoot tr:nth-child(odd)' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'table_footer_border',
                'label'     => __('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order tfoot tr',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'table_footer_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order tfoot tr > *',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'table_footer_tab_striped',
            [
                'label' => __('Striped', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'table_footer_striped_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tfoot tr:nth-child(even) :is(th, td, span, .amount)' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'table_footer_striped_bg_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order table tfoot tr:nth-child(even)' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_section_order_again',
            [
                'label' => esc_html__('Order Again Button', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'order_again_tabs'
        );
        $this->start_controls_tab(
            'order_again_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'order_again_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order-again a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'order_again_bg_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order-again a' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'order_again_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'order_again_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order-again a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'order_again_hover_bg_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order-again a:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'order_again_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .order-again a'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'order_again_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .order-again a'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'order_again_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-page-order .order-again a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'order_again_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-page-order .order-again a',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'styles_section_thankyou_address_details',
            [
                'label' => esc_html__('Address Details', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'thankyou_address_details_wrapper',
            [
                'label'        => esc_html__('Wrapper', 'ultimate-store-kit'),
                'type'        => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'thankyou_addrss_details_alignment',
            [
                'label'         => __('Alignment', 'ultiamte-store-kit-pro'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title' => __('Left', 'ultiamte-store-kit-pro'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'    => [
                        'title' => __('Center', 'ultiamte-store-kit-pro'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'     => [
                        'title' => __('Right', 'ultiamte-store-kit-pro'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'thankyou_address_details_title_heading',
            [
                'label'        => esc_html__('Title', 'ultimate-store-kit'),
                'type'        => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'thankyou_address_details_title_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order :is(h2, .woocommerce-column__title)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'           => 'thankyou_address_details_title_typography',
                'label'          => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .usk-page-order :is(h2, .woocommerce-column__title)',
            )
        );

        // Style Heading - Address
        $this->add_control(
            'thankyou_address_details_address_heading',
            [
                'label'        => esc_html__('Address', 'ultimate-store-kit'),
                'type'        => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'thankyou_address_details_address_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order :not(.woocommerce-column__title)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'           => 'thankyou_address_details_address_typography',
                'label'          => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .usk-page-order :not(.woocommerce-column__title)',
            )
        );
    }
    protected function get_last_order_id() {
        global $wpdb;
        $statuses = array_keys(wc_get_order_statuses());
        $statuses = implode("','", $statuses);
        $results = $wpdb->get_col("
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'shop_order'
        AND post_status IN ('$statuses')");
        return reset($results);
    }


    public function order_thank_you($order) {
        $settings = $this->get_settings_for_display();
        $order_received_text = $settings['thankyou_order_received_text'];

?>
        <div class="usk-page-order-heading">
            <?php if ($settings['thankyou_show_order_id'] === 'yes') :
                printf('<h3 class="thankyou-order-heading">%1$s # %2$s</h3>', esc_html__('Order', 'ultimate-store-kit'), esc_html($order->get_order_number()));
            endif; ?>
            <p class="thankyou-order-desc">
                <?php if ($order->has_status('failed')) :
                    echo esc_html__('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'ultimate-store-kit');
                ?>
                <?php else :
                    echo wp_kses_post(apply_filters('woocommerce_thankyou_order_received_text', esc_html__($order_received_text, 'ultimate-store-kit'), $order));
                endif; ?>
            </p>
        </div>
    <?php
    }
    public function thank_your_order_details($order) {
        $order_items           = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
        $show_purchase_note    = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
        $downloads             = $order->get_downloadable_items();
        $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
    ?>
        <?php
        if ($show_downloads) {
            wc_get_template(
                'order/order-downloads.php',
                array(
                    'downloads'  => $downloads,
                    'show_title' => true,
                )
            );
        }
        ?>
        <div class="woocommerce-order-details">
            <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

            <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>

            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'woocommerce'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    do_action('woocommerce_order_details_before_order_table_items', $order);

                    foreach ($order_items as $item_id => $item) {
                        $product = $item->get_product();

                        wc_get_template(
                            'order/order-details-item.php',
                            array(
                                'order'              => $order,
                                'item_id'            => $item_id,
                                'item'               => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                'product'            => $product,
                            )
                        );
                    }

                    do_action('woocommerce_order_details_after_order_table_items', $order);
                    ?>
                </tbody>

                <tfoot>
                    <?php
                    foreach ($order->get_order_item_totals() as $key => $total) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($total['label']); ?></th>
                            <td><?php echo ('payment_method' === $key) ? esc_html($total['value']) : wp_kses_post($total['value']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <?php if ($order->get_customer_note()) : ?>
                        <tr>
                            <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                            <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                        </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
            <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
        </div>

    <?php
        /**
         * Action hook fired after the order details.
         *
         * @since 4.4.0
         * @param WC_Order $order Order data.
         */
        do_action('woocommerce_after_order_details', $order);
    }

    public function thank_you_order_confirmation($order) { ?>
        <ul class="order_details">
            <li class="order">
                <span class="usk-label"> <?php esc_html_e('Order number:', 'woocommerce'); ?></span>
                <strong class="usk-value"><?php echo esc_html($order->get_order_number()); ?></strong>
            </li>
            <li class="date">
                <span class="usk-label"><?php esc_html_e('Order Date:', 'woocommerce'); ?></span>
                <strong class="usk-value"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></strong>
            </li>
            <li class="order-status">
                <span class="usk-label"><?php echo esc_html__('Order status', 'ultimate-store-kit'); ?></span>
                <strong class="usk-value"><?php echo wp_kses_post(wc_get_order_status_name($order->get_status())); ?></strong>
            </li>
            <li class="total">
                <span class="usk-label"><?php esc_html_e('Total:', 'woocommerce'); ?></span>
                <strong class="usk-value"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
            </li>
            <?php if ($order->get_payment_method_title()) : ?>
                <li class="method">
                    <span class="usk-label"><?php esc_html_e('Payment method:', 'woocommerce'); ?></span>
                    <strong class="usk-value"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                </li>
            <?php endif; ?>
        </ul>
        <?php do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id()); ?>
        <?php
    }
    public function thank_you_customer_address($order) {
        $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
        if ($show_customer_details) {
            $show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
        ?>
            <div class="woocommerce-customer-details">
                <?php if ($show_shipping) : ?>

                    <div class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
                        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                        <?php endif; ?>

                        <h2 class="woocommerce-column__title"><?php esc_html_e('Billing address', 'woocommerce'); ?></h2>

                        <address>
                            <?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'woocommerce'))); ?>

                            <?php if ($order->get_billing_phone()) : ?>
                                <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
                            <?php endif; ?>

                            <?php if ($order->get_billing_email()) : ?>
                                <p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
                            <?php endif; ?>
                        </address>

                        <?php if ($show_shipping) : ?>

                        </div><!-- /.col-1 -->

                        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
                            <h2 class="woocommerce-column__title"><?php esc_html_e('Shipping address', 'woocommerce'); ?></h2>
                            <address>
                                <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'woocommerce'))); ?>
                                <?php if ($order->get_shipping_phone()) : ?>
                                    <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_shipping_phone()); ?></p>
                                <?php endif; ?>
                            </address>
                        </div><!-- /.col-2 -->
                    </div><!-- /.col2-set -->

                <?php endif; ?>

                <?php do_action('woocommerce_order_details_after_customer_details', $order); ?>

            </div>
        <?php
        }
    }
    public function render() {
        global $wp;
        $order_id =  isset($wp->query_vars['order-received']) ? $wp->query_vars['order-received'] : $this->get_last_order_id();

        if ( ! $order_id ) {
            return;
        }
        
        $order = wc_get_order($order_id);
        ?>
        <div class="usk-page-order">
            <?php
            $this->order_thank_you($order);
            $this->thank_you_order_confirmation($order);
            $this->thank_your_order_details($order);
            $this->thank_you_customer_address($order);
            ?>
        </div>
<?php

    }
}
