<?php

namespace UltimateStoreKit\Modules\MobileMenu\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Utils;

// use UltimateStoreKit\traits\Global_Widget_Controls;
// use UltimateStoreKit\traits\Global_Widget_Template;

if (! defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Mobile_Menu extends Module_Base {
	// use Global_Widget_Controls;
	// use Global_Widget_Template;

	public function get_name() {
		return 'usk-mobile-menu';
	}

	public function get_title() {
		return esc_html__('Mobile Menu', 'ultimate-store-kit');
	}

	public function get_icon() {
		return 'usk-widget-icon usk-icon-mobile-menu';
	}

	public function get_categories() {
		return ['ultimate-store-kit'];
	}

	public function get_keywords() {
		return [ 'icon', 'mobile', 'menu', 'nav', 'navbar' ];
	}

	public function get_style_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['usk-all-styles'];
		} else {
			return ['usk-mobile-menu'];
		}
	}

	public function get_script_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['popper', 'tippyjs', 'usk-site'];
		} else {
			return ['popper', 'tippyjs', 'usk-mobile-menu'];
		}
	}

	public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
	}

	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'ep_section_menu',
			[ 
				'label' => __( 'Menu Items', 'ultimate-store-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'menu_style',
			[ 
				'label'   => __( 'Menu Style', 'ultimate-store-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [ 
					'style-1' => __( 'Default', 'ultimate-store-kit' ),
					'style-2' => __( 'Border', 'ultimate-store-kit' ),
					'style-3' => __( 'Tooltip', 'ultimate-store-kit' ),
					'style-4' => __( 'Circle with Tooltip', 'ultimate-store-kit' ),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'menu_icon',
			[ 
				'label'       => __( 'Icon', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',

			]
		);

		$repeater->add_control(
			'menu_text',
			[ 
				'label' => __( 'Menu Text', 'ultimate-store-kit' ),
				'type'  => Controls_Manager::TEXT,
				'dynamic' 	  => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'link',
			[ 
				'label'       => __( 'Link', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 
					'active' => true,
				],
				'default'     => [ 'url' => '' ],
				'description' => __( 'Add your section id WITH the # key. e.g: #my-id also you can add internal/external URL', 'ultimate-store-kit' ),
				'label_block' => true,
				'placeholder' => __( 'https://your-link.com', 'ultimate-store-kit' ),
			]
		);

		$this->add_control(
			'menu_items',
			[ 
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'menu_text' => __( 'Home', 'ultimate-store-kit' ),
						'menu_icon' => [ 'value' => 'fas fa-home', 'library' => 'fa-solid' ],
					],
					[ 
						'menu_text' => __( 'Cart', 'ultimate-store-kit' ),
						'menu_icon' => [ 'value' => 'fas fa-shopping-cart', 'library' => 'fa-solid' ],
					],
					[ 
						'menu_text' => __( 'Account', 'ultimate-store-kit' ),
						'menu_icon' => [ 'value' => 'fas fa-user', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ elementor.helpers.renderIcon( this, menu_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ menu_text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tooltip_settings',
			[ 
				'label'     => __( 'Tooltip Settings', 'ultimate-store-kit' ),
				'condition' => [ 
					'menu_style' => [ 'style-3', 'style-4' ],
				],
			]
		);

		$this->add_control(
			'menu_tooltip',
			[ 
				'label'              => __( 'Tooltip', 'ultimate-store-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'render_type'        => 'template',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'menu_tooltip_placement',
			[ 
				'label'     => esc_html__( 'Placement', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'top',
				'options'   => [ 
					'top-start'    => esc_html__( 'Top Left', 'ultimate-store-kit' ),
					'top'          => esc_html__( 'Top', 'ultimate-store-kit' ),
					'top-end'      => esc_html__( 'Top Right', 'ultimate-store-kit' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'ultimate-store-kit' ),
					'bottom'       => esc_html__( 'Bottom', 'ultimate-store-kit' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'ultimate-store-kit' ),
					'left'         => esc_html__( 'Left', 'ultimate-store-kit' ),
					'right'        => esc_html__( 'Right', 'ultimate-store-kit' ),
				],
				'condition' => [ 
					'menu_tooltip' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'menu_tooltip_animation',
			[ 
				'label'     => esc_html__( 'Animation', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'shift-toward',
				'options'   => [ 
					'shift-away'   => esc_html__( 'Shift-Away', 'ultimate-store-kit' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'ultimate-store-kit' ),
					'fade'         => esc_html__( 'Fade', 'ultimate-store-kit' ),
					'scale'        => esc_html__( 'Scale', 'ultimate-store-kit' ),
					'perspective'  => esc_html__( 'Perspective', 'ultimate-store-kit' ),
				],
				'condition' => [ 
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_x_offset',
			[ 
				'label'     => esc_html__( 'X Offset', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 0,
				],
				'condition' => [ 
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_y_offset',
			[ 
				'label'     => esc_html__( 'Y Offset', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 0,
				],
				'condition' => [ 
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_arrow',
			[ 
				'label'     => esc_html__( 'Arrow', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [ 
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_trigger',
			[ 
				'label'       => __( 'Trigger on Click', 'ultimate-store-kit' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::SWITCHER,
				'condition'   => [ 
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		//Style
		$this->start_controls_section(
			'ep_section_style_menu',
			[ 
				'label' => __( 'Menu Items', 'ultimate-store-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[ 
				'label' => esc_html__( 'Normal', 'ultimate-store-kit' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link',
			]
		);

		$this->add_control(
			'item_border_type',
			[ 
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [ 
					''       => esc_html__( 'Default', 'ultimate-store-kit' ),
					'none'   => esc_html__( 'None', 'ultimate-store-kit' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'ultimate-store-kit' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'ultimate-store-kit' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'ultimate-store-kit' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'ultimate-store-kit' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'ultimate-store-kit' ),
				],
				'selectors' => [ 
					'{{SELECTOR}} .usk-mobile-menu-wrap .usk-mobile-menu-link' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [ 
					'menu_style' => 'style-2',
				],
			]
		);

		$this->add_responsive_control(
			'item_border_width',
			[ 
				'label'     => __( 'Border Width', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}}' => '--usk-border-width: {{SIZE}}{{UNIT}};'
				],
				'condition' => [ 
					'item_border_type!' => [ 'none' ],
					'menu_style'        => 'style-2',
				],
			]
		);

		$this->add_control(
			'item_border_color',
			[ 
				'label'     => __( 'Border Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link' => 'border-color: {{SIZE}}{{UNIT}};'
				],
				'condition' => [ 
					'item_border_type!' => [ 'none' ],
					'menu_style'        => 'style-2',
				],
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		//margin
		$this->add_responsive_control(
			'item_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[ 
				'label' => esc_html__( 'Hover', 'ultimate-store-kit' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_hover_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover',
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'item_border_type!' => [ 'none' ],
                    'menu_style'        => 'style-2',
				],
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_hover_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'ep_section_style_menu_icon',
			[ 
				'label' => __( 'Menu Icon', 'ultimate-store-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_icon_style' );

		$this->start_controls_tab(
			'tab_item_icon_normal',
			[ 
				'label' => esc_html__( 'Normal', 'ultimate-store-kit' ),
			]
		);

		$this->add_control(
			'item_icon_color',
			[ 
				'label'     => esc_html__( 'Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_icon_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'item_icon_border',
				'selector'  => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_icon_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_icon_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_icon_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu',
			]
		);

		$this->add_responsive_control(
			'item_icon_size',
			[ 
				'label'     => __( 'Size', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-mobile-menu' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_icon_hover',
			[ 
				'label' => esc_html__( 'Hover', 'ultimate-store-kit' ),
			]
		);

		$this->add_control(
			'item_icon_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-mobile-menu'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-mobile-menu svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_icon_hover_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-mobile-menu',
			]
		);

		$this->add_control(
			'item_icon_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'item_icon_border_border!' => [ 'none' ],
				],
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-mobile-menu' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_icon_hover_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-mobile-menu',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'ep_section_style_menu_text',
			[ 
				'label' => __( 'Menu Text', 'ultimate-store-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_text_style' );

		$this->start_controls_tab(
			'tab_item_text_normal',
			[ 
				'label' => esc_html__( 'Normal', 'ultimate-store-kit' ),
			]
		);

		$this->add_control(
			'item_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_text_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'item_text_border',
				'selector'  => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_text_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_text_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_text_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_text_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu',
			]
		);

		//typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'item_text_typography',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap span.usk-text-mobile-menu',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_text_hover',
			[ 
				'label' => esc_html__( 'Hover', 'ultimate-store-kit' ),
			]
		);

		$this->add_control(
			'item_text_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-text-mobile-menu' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'item_text_hover_background',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-text-mobile-menu',
			]
		);

		$this->add_control(
			'item_text_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'item_text_border_border!' => [ 'none' ],
				],
				'selectors' => [ 
					'{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-text-mobile-menu' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_text_hover_box_shadow',
				'selector' => '{{WRAPPER}} .usk-mobile-menu-wrap .usk-mobile-menu-link:hover span.usk-text-mobile-menu',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//tooltip style
		$this->start_controls_section(
			'section_style_tooltip',
			[ 
				'label'     => esc_html__( 'Tooltip', 'ultimate-store-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'menu_style'   => [ 'style-3', 'style-4' ],
					'menu_tooltip' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'menu_tooltip_width',
			[ 
				'label'       => esc_html__( 'Width', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 
					'px',
					'em',
				],
				'range'       => [ 
					'px' => [ 
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'   => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"]' => 'max-width: calc({{SIZE}}{{UNIT}} - 10px) !important;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'menu_tooltip_typography',
				'selector' => '.tippy-box[data-theme="usk-tippy-{{ID}}"]',
			]
		);

		$this->add_control(
			'menu_tooltip_title_color',
			[ 
				'label'     => esc_html__( 'Title Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"] .usk-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"]' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_tooltip_text_align',
			[ 
				'label'     => esc_html__( 'Text Alignment', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [ 
					'left'   => [ 
						'title' => esc_html__( 'Left', 'ultimate-store-kit' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'ultimate-store-kit' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [ 
						'title' => esc_html__( 'Right', 'ultimate-store-kit' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"]' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'menu_tooltip_background',
				'selector' => '.tippy-box[data-theme="usk-tippy-{{ID}}"], .tippy-box[data-theme="usk-tippy-{{ID}}"] .tippy-backdrop',
			]
		);

		$this->add_control(
			'menu_tooltip_arrow_color',
			[ 
				'label'     => esc_html__( 'Arrow Color', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"] .tippy-arrow' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_tooltip_padding',
			[ 
				'label'       => __( 'Padding', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%' ],
				'selectors'   => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"] .tippy-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'menu_tooltip_border',
				'label'       => esc_html__( 'Border', 'ultimate-store-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tippy-box[data-theme="usk-tippy-{{ID}}"]',
			]
		);

		$this->add_responsive_control(
			'menu_tooltip_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'ultimate-store-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="usk-tippy-{{ID}}"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'menu_tooltip_box_shadow',
				'selector' => '.tippy-box[data-theme="usk-tippy-{{ID}}"]',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'mobile-menu', 'class', 'usk-mobile-menu-wrap usk-mobile-menu-' . $settings['menu_style'] );

		if ( empty( $settings['menu_items'] ) ) {
			return;
		}

		?>

		<div <?php $this->print_render_attribute_string( 'mobile-menu' ); ?>>
			<ul>
				<?php
				foreach ( $settings['menu_items'] as $index => $item ) :
					$repeater_key    = 'menu_item' . $index;
					$tag             = 'div ';
					$tooltip_content = '<span class="usk-title">' . $item['menu_text'] . '</span>';
					$this->add_render_attribute( $repeater_key, 'class', 'usk-mobile-menu-link', true );
					$this->add_render_attribute( $repeater_key, 'data-tippy-content', htmlspecialchars( $tooltip_content, ENT_QUOTES, 'UTF-8' ), true );

					if ( $item['link']['url'] ) {
						$tag = 'a ';
						$this->add_render_attribute( $repeater_key, 'class', 'usk-mobile-menu-link', true );

						$this->add_link_attributes( $repeater_key, $item['link'] );
					}

					if ( $item['menu_text'] and $settings['menu_tooltip'] ) {
						// Tooltip settings
						$this->add_render_attribute( $repeater_key, 'class', 'usk-tippy-tooltip' );
						$this->add_render_attribute( $repeater_key, 'data-tippy', '', true );

						if ( $settings['menu_tooltip_placement'] ) {
							$this->add_render_attribute( $repeater_key, 'data-tippy-placement', $settings['menu_tooltip_placement'], true );
						}

						if ( $settings['menu_tooltip_animation'] ) {
							$this->add_render_attribute( $repeater_key, 'data-tippy-animation', $settings['menu_tooltip_animation'], true );
						}

						if ( $settings['menu_tooltip_x_offset']['size'] or $settings['menu_tooltip_y_offset']['size'] ) {
							$this->add_render_attribute( $repeater_key, 'data-tippy-offset', '[' . $settings['menu_tooltip_x_offset']['size'] . ',' . $settings['menu_tooltip_y_offset']['size'] . ']', true );
						}

						if ( 'yes' == $settings['menu_tooltip_arrow'] ) {
							$this->add_render_attribute( $repeater_key, 'data-tippy-arrow', 'true', true );
						} else {
							$this->add_render_attribute( $repeater_key, 'data-tippy-arrow', 'false', true );
						}

						if ( 'yes' == $settings['menu_tooltip_trigger'] ) {
							$this->add_render_attribute( $repeater_key, 'data-tippy-trigger', 'click', true );
						}
					}

					?>
					<li class="usk-mobile-menu-list">
						<<?php echo esc_attr( $tag ) . ' '; ?> 			<?php $this->print_render_attribute_string( $repeater_key ); ?>>

							<?php if ( ! empty( $item['menu_icon']['value'] ) ) : ?>
								<span class="usk-mobile-menu">
									<?php Icons_Manager::render_icon( $item['menu_icon'], [ 'aria-hidden' => 'true' ] ); ?>
								</span>
							<?php endif; ?>

							<span class="usk-text-mobile-menu"><?php echo wp_kses_post( $item['menu_text'] ); ?></span>

						</<?php echo esc_attr( $tag ); ?>>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php
	}
}
