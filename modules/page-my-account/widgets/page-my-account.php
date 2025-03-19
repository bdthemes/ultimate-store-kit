<?php

namespace UltimateStoreKit\Modules\PageMyAccount\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Page_My_Account extends Module_Base {

    public function get_show_in_panel_tags() {
        return ['shop_single'];
    }

    public function get_name() {
        return 'usk-page-my-account';
    }

    public function get_title() {
        return BDTUSK . esc_html__('My Account (Page)', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-page-my-account usk-new';
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
            return ['usk-font', 'usk-page-my-account'];
        }
    }
    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }
    protected function register_controls() {

        $start = is_rtl() ? 'end' : 'start';
		$end = is_rtl() ? 'start' : 'end';
    
        $this->start_controls_section(
            'section_page_my_account',
            [
                'label' => esc_html__('My Account', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'my_account_nav_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => esc_html__('Vertical', 'ultimate-store-kit'),
                    'horizontal' => esc_html__('Horizontal', 'ultimate-store-kit'),
                ],
                'prefix_class' => 'usk-my-account-tabs-layout-',
                'render_type' => 'template',
            ]
        );
        $this->add_responsive_control(
			'my_account_nav_alignment',
			[
				'label' => esc_html__( 'Alignment', 'ultimate-store-kit' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'ultimate-store-kit' ),
						'icon' => "eicon-align-$start-h",
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ultimate-store-kit' ),
						'icon' => 'eicon-align-center-h',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'ultimate-store-kit' ),
						'icon' => "eicon-align-$end-h",
					],
					'space-between' => [
						'title' => esc_html__( 'Stretch', 'ultimate-store-kit' ),
						'icon' => 'eicon-align-stretch-h',
					],
				],
				'condition' => [
					'my_account_nav_layout' => 'horizontal',
				],
                'selectors' => [
					'{{WRAPPER}}.usk-my-account-tabs-layout-horizontal .woocommerce-MyAccount-navigation ul' => '{{VALUE}}',
					'{{WRAPPER}}.usk-my-account-tabs-layout-horizontal .woocommerce-MyAccount-navigation ul > li' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'flex-start' => 'justify-content: flex-start;',
					'center' => 'justify-content: center;',
					'flex-end' => 'justify-content: flex-end;',
					'space-between' => 'justify-content: space-between; flex: auto;',
				],
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'section_page_my_account_style',
            [
                'label' => esc_html__('My Account', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'my_account_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce',
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'my_account_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'my_account_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'my_account_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'my_account_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'my_account_space_between',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        /**
         * Account Navigation
         */
        $this->start_controls_section(
            'section_page_my_account_navigation_style',
            [
                'label' => esc_html__('Account Navigation', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'navigation_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul',
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'navigation_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'navigation_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'navigation_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'navigation_gap',
            [
                'label' => esc_html__('Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'navigation_heading',
            [
                'label' => esc_html__('Nav Items', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs('tabs_navigation_items');
        $this->start_controls_tab(
            'tab_navigation_items_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'navigation_items_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'navigation_items_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a',
                'exclude' => ['image'],
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'navigation_items_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'navigation_items_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'navigation_items_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'navigation_items_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li a',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_navigation_items_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'navigation_items_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'navigation_items_hover_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li:hover a',
                'exclude' => ['image'],
			]
		);
        $this->add_control(
            'navigation_items_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li:hover a' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation_items_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_navigation_items_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'navigation_items_active_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li.is-active a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'navigation_items_active_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li.is-active a',
                'exclude' => ['image'],
			]
		);
        $this->add_control(
            'navigation_items_active_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-navigation ul li.is-active a' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation_items_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Account Content
         */
        $this->start_controls_section(
            'section_page_my_account_content_style',
            [
                'label' => esc_html__('Account Content', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_text_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_link_color',
            [
                'label' => esc_html__('Link Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_link_hover_color',
            [
                'label' => esc_html__('Link Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content',
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_spacing',
            [
                'label' => esc_html__('Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content p',
            ]
        );
        $this->end_controls_section();

        /**
         * Account Orders & Downloads
         */
        $this->start_controls_section(
            'section_page_my_account_table_style',
            [
                'label' => esc_html__('Orders / Downloads', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'orders_table_heading',
            [
                'label' => esc_html__('Table', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'orders_table_border_width',
            [
                'label' => esc_html__('Border Width', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table th' => 'border-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table td' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table th' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table td' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_header_heading',
            [
                'label' => esc_html__('Table Header', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'orders_table_header_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table thead th' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_header_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table thead th' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'orders_table_header_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orders_table_header_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table thead th',
            ]
        );
        $this->add_control(
            'orders_table_body_heading',
            [
                'label' => esc_html__('Table Body', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'orders_table_body_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr > td, {{WRAPPER}} .usk-page-my-account table tbody > tr > th' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_body_link_color',
            [
                'label' => esc_html__('Link Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr > td a, {{WRAPPER}} .usk-page-my-account table tbody > tr > th a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_body_link_hover_color',
            [
                'label' => esc_html__('Link Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr > td a:hover, {{WRAPPER}} .usk-page-my-account table tbody > tr > th a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_body_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr > td, {{WRAPPER}} .usk-page-my-account table tbody > tr > th' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_body_odd_color',
            [
                'label' => esc_html__('Odd Row Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr:nth-child(odd) > td, {{WRAPPER}} .usk-page-my-account table tbody > tr:nth-child(odd) > th' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'orders_table_body_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account table tbody > tr > td, {{WRAPPER}} .usk-page-my-account table tbody > tr > th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orders_table_body_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account table tbody > tr > td, {{WRAPPER}} .usk-page-my-account table tbody > tr > th',
            ]
        );

        $this->add_control(
            'orders_table_actions_heading',
            [
                'label' => esc_html__('Actions Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs('tabs_orders_table_actions');
        $this->start_controls_tab(
            'tab_orders_table_actions_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'orders_table_actions_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_actions_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orders_table_actions_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'orders_table_actions_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'orders_table_actions_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orders_table_actions_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_orders_table_actions_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'orders_table_actions_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_actions_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'orders_table_actions_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-MyAccount-content table .button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orders_table_actions_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Account Address
         */
        $this->start_controls_section(
            'section_page_my_account_address_style',
            [
                'label' => esc_html__('Address', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'address_heading',
            [
                'label' => esc_html__('Address Info', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'address_title_color',
            [
                'label' => esc_html__('Title Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'address_title_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-Address h2',
            ]
        );
        $this->add_control(
            'address_link_color',
            [
                'label' => esc_html__('Edit Link Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'address_link_hover_color',
            [
                'label' => esc_html__('Edit Link Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'address_link_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-Address a',
            ]
        );
        
        $this->add_control(
            'address_info_color',
            [
                'label' => esc_html__('Address Info Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address address' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'address_info_typography',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-Address address',
            ]
        );
        $this->add_control(
            'address_divider_color',
            [
                'label' => esc_html__('Divider Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address .woocommerce-Address-title' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'address_background',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-Address',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'address_border',
                'selector' => '{{WRAPPER}} .usk-page-my-account .woocommerce-Address',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'address_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'address_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-page-my-account .woocommerce-Address' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Form Fields
         */
        $this->start_controls_section(
            'section_page_my_account_form_fields_style',
            [
                'label' => esc_html__('Form Fields', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Title
        $this->add_control(
            'form_fields_title_heading',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'form_fields_title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_title_typography',
                'selector' => '{{WRAPPER}} .woocommerce-MyAccount-content form h2',
            ]
        );

        // Fields
        $this->add_control(
            'form_fields_heading',
            [
                'label' => esc_html__('Fields', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_fields_label_color',
            [
                'label' => esc_html__('Label Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_label_typography',
                'label' => esc_html__('Label Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .woocommerce-MyAccount-content form label',
            ]
        );
        $this->add_control(
            'form_fields_input_color',
            [
                'label' => esc_html__('Input Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_fields_input_background_color',
            [
                'label' => esc_html__('Input Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_input_border_color',
            [
                'label' => esc_html__('Input Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_fields_input_border_radius',
            [
                'label' => esc_html__('Input Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_fields_input_padding',
            [
                'label' => esc_html__('Input Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_input_typography',
                'label' => esc_html__('Input Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .woocommerce-MyAccount-content form input, {{WRAPPER}} .woocommerce-MyAccount-content form select, {{WRAPPER}} .woocommerce-MyAccount-content form textarea',
            ]
        );

        // Submit Button
        $this->add_control(
            'form_fields_submit_heading',
            [
                'label' => esc_html__('Submit Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs('tabs_form_fields_submit');
        $this->start_controls_tab(
            'tab_form_fields_submit_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'form_fields_submit_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_submit_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'form_fields_submit_border',
                'selector' => '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'form_fields_submit_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_fields_submit_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_submit_typography',
                'selector' => '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_form_fields_submit_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'form_fields_submit_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_submit_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_fields_submit_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-MyAccount-content form button[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'form_fields_submit_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render() {

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $screen = isset($wp->query_vars['edit-address']) ? $wp->query_vars['edit-address'] : '';

        if (!is_user_logged_in()) {
            esc_html_e('You need logged in first', 'ultimate-store-kit');
        } else { ?>
            <div class="usk-page-my-account">

                <?php if ($this->usk_is_edit_mode()) : ?>
                    
                    <!-- WooCommerce My Account Profile TODO -->
                    <!-- <div class="usk-my-account-profile usk-flex">
                        <?php //echo get_avatar(get_current_user_id(), 80); ?>
                        <div>
                            <p><?php //echo esc_html('Hello', 'ultimate-store-kit'); ?></p>
                            <h5><?php //echo esc_html(get_the_author_meta('display_name', get_current_user_id())); ?></h5>
                        </div>
                    </div> -->

                    <div class="woocommerce usk-myaccount-edit-mode">

                        <!-- WooCommerce My Account Navigation -->
                        <?php woocommerce_account_navigation(); ?>

                        <!-- WooCommerce My Account Content -->
                        <div class="woocommerce-MyAccount-content">
                            <div class="usk-myaccount-dashboard">
                                <?php woocommerce_account_content(); ?>
                            </div>
                            <div class="usk-myaccount-orders" style="display: none;">
                                <?php woocommerce_account_orders($paged); ?>
                            </div>
                            <div class="usk-myaccount-downloads" style="display: none;">
                                <?php echo woocommerce_account_downloads(); ?>
                            </div>
                            <div class="usk-myaccount-address" style="display: none;">
                                <?php woocommerce_account_edit_address($screen); ?>
                            </div>
                            <div class="usk-myaccount-payment-methods" style="display: none;">
                                <?php woocommerce_account_payment_methods(); ?>
                            </div>
                            <div class="usk-myaccount-details" style="display: none;">
                                <?php woocommerce_account_edit_account(); ?>
                            </div>

                        </div>

                    </div>

                <?php else : ?>

                    <?php echo do_shortcode('[woocommerce_my_account]'); ?>

                <?php endif; ?>
            
            </div>
        <?php
        }
    }
}
