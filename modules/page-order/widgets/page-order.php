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

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Page_Order extends Module_Base
{

    public function get_show_in_panel_tags()
    {
        return ['shop_single'];
    }

    public function get_name()
    {
        return 'usk-page-order';
    }

    public function get_title()
    {
        return BDTUSK . esc_html__('Order Page', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-page-order usk-new';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit-order-thankyou'];
    }
    public function show_in_panel()
    {
        return get_post_type() === 'usk-template-builder' || get_post_type() === 'elementor_library' || get_post_type() === 'product';
    }

    public function get_keywords()
    {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'additional', 'info'];
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-add-to-cart', 'usk-page-order'];
        }
    }
    public function has_widget_inner_wrapper(): bool
    {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout_thankyou_orders',
            [
                'label' => __('ThankYou Order', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'thankyou_spacing',
            [
                'label' => __('Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-order-page-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'thankyou_show_order_id',
            [
                'label' => __('Show Order ID', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'after'
            ]
        );
        $this->add_control(
            'thankyou_order_received_text',
            [
                'label' => __('Description', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [ 'active' => true ],
                'rows' => 5,
                'default' => __('Thank you. Your order has been received.', 'ultimate-store-kit'),
                'placeholder' => __('Thank you. Your order has been received.', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'thankyour_order_alignment',
            [
                'label' => __('Alignment', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .usk-page-order-heading' => 'text-align:{{VALUE}}; display:block;'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_thankyou_orders_style',
            [
                'label' => __('Order Heading', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thankyou_orders_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-page-order .usk-page-order-heading',
            ]
        );

        $this->add_control(
            'thankyou_orders_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .usk-page-order-heading' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_style_thankyou_order'
        );

        $this->start_controls_tab(
            'tab_style_thankyou_order_heading',
            [
                'label' => __('Title', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'heading_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .usk-page-order-heading .thankyou-order-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}}  .usk-page-order .thankyou-order-heading',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_style_thankyou_order_desc',
            [
                'label' => __('Description', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'desc_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .thankyou-order-desc ' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .thankyou-order-desc',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // Order Details List Style Section
        $this->start_controls_section(
            'section_style_order_details_list',
            [
                'label' => esc_html__('Order Card', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Container Style
        $this->add_control(
            'order_list_container_heading',
            [
                'label' => esc_html__('Container', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'order_list_columns',
            [
                'label' => esc_html__('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .order_details' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'order_list_gap',
            [
                'label' => esc_html__('Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .order_details' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );



        // Typography Style
        $this->add_control(
            'order_list_typography_heading',
            [
                'label' => esc_html__('Items', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('order_list_typography_tabs');

        $this->start_controls_tab(
            'order_list_typography_wrapper',
            [
                'label' => esc_html__('Wrapper', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'order_list_item_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .order_details li',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'order_list_item_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .order_details li' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'order_list_icon_color_style-border',
            [
                'label' => esc_html__('Style Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order_details li, {{WRAPPER}} .usk-page-order .order_details li:last-of-type' => 'border-left-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();
        // Label Typography Tab
        $this->start_controls_tab(
            'order_list_typography_label',
            [
                'label' => esc_html__('Label', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'order_list_label_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .order_details li .usk-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'order_list_label_typography',
                'selector' => '{{WRAPPER}} .order_details li .usk-label',
            ]
        );

        $this->end_controls_tab();

        // Value Typography Tab
        $this->start_controls_tab(
            'order_list_typography_value',
            [
                'label' => esc_html__('Value', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'order_list_value_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .order_details li .usk-value' => 'color: {{VALUE}};',
                ],
                'default' => '#1e293b',
            ]
        );

        $this->add_control(
            'order_list_total_value_color',
            [
                'label' => esc_html__('Total Value Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .order_details li.total .usk-value' => 'color: {{VALUE}};',
                ],
                'default' => '#0f766e',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'order_list_value_typography',
                'selector' => '{{WRAPPER}} .order_details li .usk-value',
            ]
        );

        $this->end_controls_tab();


        // Icon Typography Tab
        $this->start_controls_tab(
            'order_list_typography_icon',
            [
                'label' => esc_html__('Icon', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'order_list_icon_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .order_details li .usk-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'order_list_icon_global_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .order_details li .usk-icon' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section_order_details',
            [
                'label' => esc_html__('Order Details', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('order_details_title_tabs');

        $this->start_controls_tab(
            'order_details_wrap_tab',
            [
                'label' => esc_html__('Wrapper', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'order_details_wrap_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details',
            ]
        );

        $this->add_control(
            'order_details_wrap_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'order_details_heading_tab',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'order_details_title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'order_details_title_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title::after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'order_details_title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details__title',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'order_details_tabs_heading',
            [
                'label' => esc_html__('Table', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('order_details_tabs_tables');

        $this->start_controls_tab(
            'order_details_tabs_table_header',
            [
                'label' => esc_html__('Header', 'ultimate-store-kit'),
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'table_header_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table thead , {{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tfoot tr:last-child',
            ]
        );

        $this->add_control(
            'table_header_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-table thead th, {{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tfoot tr:last-child th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_header_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table thead th',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'order_details_tabs_table_body',
            [
                'label' => esc_html__('Body', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'table_body_odd_row',
            [
                'label' => esc_html__('Odd Row', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'table_body_odd_row_bg_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_body_odd_row_text_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(odd) td.product-name a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(odd) td .product-quantity' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(odd) td.product-total .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_body_even_row',
            [
                'label' => esc_html__('Even Row', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'table_body_even_row_bg_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_body_even_row_text_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(even) td.product-name a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(even) td .product-quantity' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tbody tr:nth-child(even) td.product-total .amount' => 'color: {{VALUE}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_body_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td',
            ]
        );

        $this->add_control(
            'table_body_meta_heading',
            [
                'label' => esc_html__('Meta Data', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'table_body_meta_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name dl dt' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name dl dd' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name .wc-item-meta li' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name .wc-item-meta li p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_body_meta_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name dl dt, {{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name dl dd, {{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name .wc-item-meta li, {{WRAPPER}} .usk-page-order .woocommerce-table tbody td.product-name .wc-item-meta li p',
            ]
        );




        $this->end_controls_tab();

        $this->start_controls_tab(
            'order_details_tabs_table_footer',
            [
                'label' => esc_html__('Footer', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'table_footer_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table tfoot',
            ]
        );

        $this->add_control(
            'table_footer_text_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tfoot tr th' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-order .woocommerce-table tfoot tr td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_footer_total_color',
            [
                'label' => esc_html__('Total Amount Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .woocommerce-table tfoot tr:last-child td .amount' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'table_footer_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-table tfoot tr th, {{WRAPPER}} .usk-page-order .woocommerce-table tfoot tr td',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();

        $this->add_control(
            'order_again_button_heading',
            [
                'label' => esc_html__('Order Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('order_again_button_tabs');
        $this->start_controls_tab(
            'tab_order_again_button_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'order_again_button_text_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'order_again_button_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#1E87F0',
                    ],
                ],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'order_again_button_border',
                'label'          => __('Border', 'ultimate-store-kit'),
                'default' => 'n',
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button',
            ]
        );

        $this->add_control(
            'order_again_button_border_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'order_again_button_padding',
            [
                'label' => __('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'order_again_button_typography',
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'order_again_button_box_shadow',
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_order_again_button_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'order_again_button_hover_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'order_again_button_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'order_again_button_border_border!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'order_again_button_hover_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-order-details .order-again .button:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'styles_section_thankyou_address_details',
            [
                'label' => esc_html__('Address Details', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('thankyou_address_details_tabs');

        $this->start_controls_tab(
            'thankyou_address_details_wrapper',
            [
                'label' => esc_html__('Wrapper', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thankyou_address_details_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column',
            ]
        );



        $this->add_control(
            'thankyou_address_details_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'thankyou_address_details_title_tab',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'thankyou_address_details_title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'thankyou_address_details_title_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column__title::after' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'thankyou_address_details_title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column__title',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'thankyou_address_details_address_tab',
            [
                'label' => esc_html__('Address', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'thankyou_address_details_address_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column address, 
                    {{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'thankyou_address_details_address_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column address, 
                    {{WRAPPER}} .usk-page-order .woocommerce-customer-details .woocommerce-columns .woocommerce-column p',
            )
        );

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    protected function get_last_order_id()
    {
        global $wpdb;
        $statuses = array_keys(wc_get_order_statuses());
        $statuses = implode("','", $statuses);
        $results = $wpdb->get_col("
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'shop_order'
        AND post_status IN ('$statuses')");
        return reset($results);
    }


    public function order_thank_you($order)
    {
        $settings = $this->get_settings_for_display();
        $order_received_text = $settings['thankyou_order_received_text'];

        ?>
        <div class="usk-page-order-heading">
            <?php if ($settings['thankyou_show_order_id'] === 'yes'):
                printf('<h3 class="thankyou-order-heading">%1$s # %2$s</h3>', esc_html__('Order', 'ultimate-store-kit'), esc_html($order->get_order_number()));
            endif; ?>
            <p class="thankyou-order-desc">
                <?php if ($order->has_status('failed')):
                    echo esc_html__('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'ultimate-store-kit');
                    ?>
                <?php else:
                    echo wp_kses_post(apply_filters('woocommerce_thankyou_order_received_text', esc_html__($order_received_text, 'ultimate-store-kit'), $order));
                endif; ?>
            </p>
        </div>
        <?php
    }
    public function thank_your_order_details($order)
    {
        $order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
        $show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
        $downloads = $order->get_downloadable_items();
        $show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();
        ?>
        <?php
        if ($show_downloads) {
            wc_get_template(
                'order/order-downloads.php',
                array(
                    'downloads' => $downloads,
                    'show_title' => true,
                )
            );
        }
        ?>
        <div class="woocommerce-order-details">
            <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

            <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'ultimate-store-kit'); ?></h2>

            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                <thead>
                    <tr>
                        <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'ultimate-store-kit'); ?>
                        </th>
                        <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'ultimate-store-kit'); ?>
                        </th>
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
                                'order' => $order,
                                'item_id' => $item_id,
                                'item' => $item,
                                'show_purchase_note' => $show_purchase_note,
                                'purchase_note' => $product ? $product->get_purchase_note() : '',
                                'product' => $product,
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
                    <?php if ($order->get_customer_note()): ?>
                        <tr>
                            <th><?php esc_html_e('Note:', 'ultimate-store-kit'); ?></th>
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

    public function thank_you_order_confirmation($order)
    { ?>
        <ul class="order_details">
            <li class="order">
                <svg class="usk-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span class="usk-label"><?php esc_html_e('Order number:', 'ultimate-store-kit'); ?></span>
                <strong class="usk-value"><?php echo esc_html($order->get_order_number()); ?></strong>
            </li>
            <li class="date">
                <svg class="usk-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="usk-label"><?php esc_html_e('Order Date:', 'ultimate-store-kit'); ?></span>
                <strong class="usk-value"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></strong>
            </li>
            <li class="order-status">
                <svg class="usk-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="usk-label"><?php echo esc_html__('Order status', 'ultimate-store-kit'); ?></span>
                <strong class="usk-value"><?php echo wp_kses_post(wc_get_order_status_name($order->get_status())); ?></strong>
            </li>
            <li class="total">
                <svg class="usk-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="usk-label"><?php esc_html_e('Total:', 'ultimate-store-kit'); ?></span>
                <strong class="usk-value"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
            </li>
            <?php if ($order->get_payment_method_title()): ?>
                <li class="method">
                    <svg class="usk-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="usk-label"><?php esc_html_e('Payment method:', 'ultimate-store-kit'); ?></span>
                    <strong class="usk-value"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                </li>
            <?php endif; ?>
        </ul>
        <?php do_action('woocommerce_receipt_' . $order->get_payment_method(), $order->get_id()); ?>
    <?php
    }
    public function thank_you_customer_address($order)
    {
        $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
        if ($show_customer_details) {
            $show_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address();
            ?>
            <div class="woocommerce-customer-details">
                <?php if ($show_shipping): ?>

                    <div class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
                        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                        <?php endif; ?>

                        <h2 class="woocommerce-column__title"><?php esc_html_e('Billing address', 'ultimate-store-kit'); ?></h2>

                        <address>
                            <?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'ultimate-store-kit'))); ?>

                            <?php if ($order->get_billing_phone()): ?>
                                <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
                            <?php endif; ?>

                            <?php if ($order->get_billing_email()): ?>
                                <p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
                            <?php endif; ?>
                        </address>

                        <?php if ($show_shipping): ?>

                        </div><!-- /.col-1 -->

                        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
                            <h2 class="woocommerce-column__title"><?php esc_html_e('Shipping address', 'ultimate-store-kit'); ?></h2>
                            <address>
                                <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'ultimate-store-kit'))); ?>
                                <?php if ($order->get_shipping_phone()): ?>
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
    public function render()
    {
        // Check if we're in Elementor editor
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            // Get last order for preview
            $orders = wc_get_orders(array('limit' => 1));
            if (!empty($orders)) {
                $order = $orders[0];
            } else {
                echo esc_html__('No orders found. Please create a test order to preview this widget.', 'ultimate-store-kit');
                return;
            }
        } else {
            // Normal frontend rendering
            global $wp;
            $order_id = isset($wp->query_vars['order-received']) ? $wp->query_vars['order-received'] : $this->get_last_order_id();

            if (!$order_id) {
                return;
            }

            $order = wc_get_order($order_id);
        }

        if (!$order) {
            return;
        }
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
