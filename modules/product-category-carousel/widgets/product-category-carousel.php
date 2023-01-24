<?php

namespace UltimateStoreKit\Modules\ProductCategoryCarousel\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use UltimateStoreKit\Traits\Global_Widget_Controls;
use UltimateStoreKit\Traits\Global_Terms_Query_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;


if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Product_Category_Carousel extends Module_Base {
	use Global_Widget_Controls;
	use Global_Terms_Query_Controls;
	use Global_Widget_Template;


	// private $_query = null;

	public function get_name() {
		return 'usk-product-category-carousel';
	}

	public function get_title() {
		return  esc_html__('Product Category Carousel', 'ultimate-store-kit');
	}

	public function get_icon() {
		return 'usk-widget-icon usk-icon-product-category-carousel';
	}

	public function get_categories() {
		return ['ultimate-store-kit'];
	}

	public function get_keywords() {
		return ['product', 'category', 'carousel', 'tags'];
	}

	public function get_style_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['usk-all-styles'];
		} else {
			return ['ultimate-store-kit-font', 'usk-product-category-carousel'];
		}
	}

	public function get_script_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['usk-all-styles'];
		} else {
			return ['usk-product-category-carousel'];
		}
	}

	public function get_query() {
		return $this->_query;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__('Layout', 'ultimate-store-kit'),
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label'      => esc_html__('Style', 'ultimate-store-kit'),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'style-1',
				'options'    => [
					'style-1'  	=> esc_html__('Style-1', 'ultimate-store-kit'),
					'style-2' 	=> esc_html__('Style-2', 'ultimate-store-kit'),
					'style-3' 	=> esc_html__('Style-3', 'ultimate-store-kit'),
					'style-4' 	=> esc_html__('Style-4', 'ultimate-store-kit'),
					'style-5'   => esc_html__('Style-5', 'ultimate-store-kit'),
					'style-6'   => esc_html__('Style-6', 'ultimate-store-kit'),
				],
			]
		);
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__('Columns', 'ultimate-store-kit'),
				'type' => Controls_Manager::SELECT,
				'default' => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'options' => [
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
					7 => '7',
					8 => '8',
				],
			]
		);
		$this->add_responsive_control(
			'items_gap',
			[
				'label' => esc_html__('Item Gap', 'ultimate-store-kit'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'tablet_default' => [
					'size' => 20,
				],
				'mobile_default' => [
					'size' => 20,
				],
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label'     => esc_html__('Alignment', 'ultimate-store-kit'),
				'type'      => Controls_Manager::HIDDEN,
			]
		);

		$this->add_control(
			'title_tags',
			[
				'label'   => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => ultimate_store_kit_title_tags(),
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'label'   => esc_html__('Image Size', 'ultimate-store-kit'),
				'exclude' => ['custom'],
				'default' => 'medium',
			]
		);

		$this->add_control(
			'item_limit',
			[
				'label' => esc_html__('Item Limit', 'ultimate-store-kit'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 6,
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'     => esc_html__('Column Gap', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_height',
			[
				'label'     => esc_html__('Item Height(px)', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 350,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-grid .usk-item' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'     => esc_html__('Show Image', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_thumbnail',
				'exclude'   => ['custom',],
				'default'   => 'large',
				'condition' => [
					'show_image' => 'yes'
				]
			]
		);
		$this->add_control(
			'show_count',
			[
				'label'     => esc_html__('Show Count', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				// 'separator' => 'before'
			]
		);
		$this->end_controls_section();
		$this->render_terms_query_controls('product_cat');
		$this->register_global_controls_carousel_navigation();
		$this->register_global_controls_carousel_settings();
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => esc_html__('Item', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'item_tabs'
		);
		$this->start_controls_tab(
			'item_tab_normal',
			[
				'label' => esc_html__('Normal', 'ultimate-store-kit'),
			]
		);

		$this->add_control(
			'style_5_category_bg',
			[
				'label'     => __('Overlay Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel.style-5 .usk-category-image:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'layout_style' => [
						'style-5'
					]
				]
			]
		);
		$this->add_responsive_control(
			'item_padding',
			[
				'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .' . $this->get_name() . ' .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'item_margin',
			[
				'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .' . $this->get_name() . ' .usk-item'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'item_border',
				'label'     => esc_html__('Border', 'ultimate-store-kit'),
				'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item',
			]
		);
		$this->add_responsive_control(
			'item_radius',
			[
				'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .' . $this->get_name() . ' .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'item_tab_hover',
			[
				'label' => esc_html__('Hover', 'ultimate-store-kit'),
			]
		);
		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__('Image', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_style' => [
						'style-6'
					]
				]
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'     => esc_html__('Width', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 350,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		
		$this->add_responsive_control(
			'image_height',
			[
				'label'     => esc_html__('Height', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 350,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'image_border',
				'label'     => esc_html__('Border', 'ultimate-store-kit'),
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img',
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[
				'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .usk-product-category-carousel.style-6 .usk-category-image img',
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_style' => [
						'style-1',
						'style-2',
						'style-5'
					]
				]
			]
		);


		$this->start_controls_tabs(
			'content_tabs'
		);
		$this->start_controls_tab(
			'content_tab_normal',
			[
				'label' => esc_html__('Normal', 'ultimate-store-kit'),
			]
		);
		$this->add_control(
			'category_overlay_blur_effect',
			[
				'label'       => esc_html__('Glassmorphism', 'ultimate-store-kit'),
				'type'        => Controls_Manager::SWITCHER,
				'description' => sprintf(__('This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'ultimate-store-kit'), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>'),
				'default'     => 'no',
			]
		);

		$this->add_control(
			'content_overlay_blur_level',
			[
				'label'     => __('Blur Level', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default'   => [
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [
					'category_overlay_blur_effect' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'content_background',
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content',
				'condition' => [
					'category_overlay_blur_effect!' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_margin',
			[
				'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'content_border',
				'label'     => esc_html__('Border', 'ultimate-store-kit'),
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content',
			]
		);
		$this->add_responsive_control(
			'content_radius',
			[
				'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_shadow',
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'content_tab_hover',
			[
				'label' => esc_html__('Hover', 'ultimate-store-kit'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'content_hover_background',
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content',
				'condition' => [
					'category_overlay_blur_effect!' => 'yes'
				]
			]
		);
		$this->add_control(
			'content_hover_border_color',
			[
				'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'content_hover_shadow',
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_category',
			[
				'label' => esc_html__('Category', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'category_tabs'
		);
		$this->start_controls_tab(
			'category_tab_normal',
			[
				'label' => esc_html__('Normal', 'ultimate-store-kit'),
			]
		);
		$this->add_control(
			'category_color',
			[
				'label'     => esc_html__('Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'style_4_category_bg',
				'label'     => esc_html__('Backgorund', 'ultimate-store-kit'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .title',
				'condition' => [
					'layout_style' => [
						'style-4'
					]
				]
			]
		);

		$this->add_responsive_control(
			'category_margin',
			[
				'label'      => esc_html__('Margin', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'category_padding',
			[
				'label'      => esc_html__('Padding', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => [
						'style-4'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label'    => esc_html__('Typography', 'ultimate-store-kit'),
				'exclude' => ['line_height'],
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .title',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'category_tab_hover',
			[
				'label' => esc_html__('Hover', 'ultimate-store-kit'),
			]
		);
		$this->add_control(
			'hover_category_color',
			[
				'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content .title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_count',
			[
				'label' => esc_html__('Count', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'count_tabs'
		);
		$this->start_controls_tab(
			'count_tab_normal',
			[
				'label' => esc_html__('Normal', 'ultimate-store-kit'),
				'condition' => [
					'layout_style!' => [
						'style-5'
					]
				]
			]
		);
		$this->add_control(
			'count_color',
			[
				'label'     => esc_html__('Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count > *' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'count_background',
				'label'     => esc_html__('Background', 'ultimate-store-kit'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count > *',
				'condition' => [
					'layout_style' => [
						'style-2'
					]
				]
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'style4_count_background',
				'label'     => esc_html__('Background', 'ultimate-store-kit'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel.style-4 .usk-category-count',
				'condition' => [
					'layout_style' => [
						'style-4',
					]
				]
			]
		);
		$this->add_responsive_control(
			'count_number_size',
			[
				'label'         => esc_html__('Size', 'ultimate-store-kit'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'default'       => [
					'unit'      => 'px',
					'size'      => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count > *' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout_style' => [
						'style-2'
					]
				]
			]
		);

		$this->add_responsive_control(
			'count_margin',
			[
				'label'      => __('Margin', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'layout_style!' => [
					'style-4'
				]
			]
		);

		$this->add_responsive_control(
			'count_padding',
			[
				'label'      => __('Padding', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'layout_style!' => [
					'style-4'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'count_typography',
				'label'    => esc_html__('Typography', 'ultimate-store-kit'),
				'selector' => '{{WRAPPER}} .usk-product-category-carousel .usk-item .usk-content .usk-category-count > *',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'count_tab_hover',
			[
				'label' => esc_html__('Hover', 'ultimate-store-kit'),
				'condition' => [
					'layout_style!' => [
						'style-4'
					]
				]
			]
		);
		$this->add_control(
			'count_color_hover',
			[
				'label'     => esc_html__('Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content .usk-category-count > *' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'count_hover_background',
				'label'     => esc_html__('Background', 'ultimate-store-kit'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .usk-product-category-carousel .usk-item:hover .usk-content .usk-category-count > *',
				'condition' => [
					'layout_style' => [
						'style-2',
					]
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->register_global_controls_navigation_style();
	}

	public function render_query() {
		$settings = $this->get_settings_for_display();
		$args = [
			'orderby'    => isset($settings['orderby']) ? $settings['orderby'] : 'name',
			'order'      => isset($settings['order']) ? $settings['order'] : 'ASC',
			'hide_empty' => isset($settings['hide_empty']) && ($settings['hide_empty'] == 'yes') ? 1 : 0,
		];


		switch ($settings['display_category']) {
			case 'all':
				if (isset($settings['cats_include_by_id']) && !empty($settings['cats_include_by_id'])) {
					$args['include'] = $settings['cats_include_by_id'];
				}
				if (isset($settings['cats_exclude_by_id']) && !empty($settings['cats_exclude_by_id'])) {
					$args['exclude'] = $settings['cats_exclude_by_id'];
				}
				break;
			case 'child':
				if ($settings['parent_cats'] != 'none' &&  !empty($settings['parent_cats'])) {
					$args['child_of'] = $settings['parent_cats'];
				}
				break;
			case 'parents':
				$args['parent'] = 0;
				break;
		}
		$categories = get_terms('product_cat', $args);
		return $categories;
	}
	public function render_loop_item() {
		$settings = $this->get_settings_for_display();
		$categories = $this->render_query();

?>
		<?php foreach ($categories as $index => $category) :
			$category_thumb_id = get_term_meta($category->term_id, 'thumbnail_id', true);
			$img_url     = wp_get_attachment_image_url($category_thumb_id, $settings['image_thumbnail_size']);
			$category_image = $img_url ? $img_url : Utils::get_placeholder_image_src();
			$term_link = get_term_link($category->slug, 'product_cat');

		?>
			<a class="usk-item category-link swiper-slide" href="<?php echo esc_url($term_link); ?>">
				<?php if ($settings['show_image']) : ?>
					<div class="usk-category-image">
						<img src="<?php echo esc_url($category_image); ?>" alt="">
					</div>
				<?php endif; ?>
				<div class="usk-content">
					<?php printf('<h3 class="title">%s</h3>', $category->name); ?>
					<?php
					if ($settings['show_count']) :
						printf('<p class="usk-category-count"><span class="usk-count-number">%s</span><span class="usk-count-text">products</span></p>', $category->count);
					endif;
					?>
				</div>
			</a>
<?php
			if (!empty($settings['item_limit']['size'])) {
				if ($index == ($settings['item_limit']['size'] - 1)) break;
			}
		endforeach;
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute('usk-carousel-wrapper', 'class', [$settings['layout_style']]);
		$this->register_global_template_carousel_header();
		$this->render_loop_item();
		$this->usk_register_global_template_carousel_footer();
	}
}
