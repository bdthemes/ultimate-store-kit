<?php

namespace UltimateStoreKit\Modules\SubCategoryCarousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Traits\Global_Terms_Query_Controls;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;



if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Sub_Category_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Terms_Query_Controls;
    use Global_Widget_Template;
    public function get_name() {
        return 'usk-sub-category-carousel';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Sub Category Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-sub-category-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['ultimate-store-kit', 'shop', 'store', 'sub', 'heading', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-sub-category-carousel'];
        }
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-sub-category-carousel'];
        }
    }
    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    public function has_widget_inner_wrapper(): bool {
			return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
		}
		protected function register_controls() {
        $this->start_controls_section(
            'section_content_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label'          => __('Columns', 'ultimate-store-kit'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options'        => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ],
            ]
        );
        $this->add_control(
            'alignment',
            [
                'label'     => __('Title', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'traditional',
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
                'name'    => 'category_thumbnail',
                'label'   => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'medium',
            ]
        );

        $this->add_responsive_control(
            'item_flex_direction',
            [
                'label' => esc_html__( 'Direction', 'ultimate-store-kit' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__( 'Row - horizontal', 'ultimate-store-kit' ),
                        'icon' => 'eicon-arrow-right',
                    ],
                    'column' => [
                        'title' => esc_html__( 'Column - vertical', 'ultimate-store-kit' ),
                        'icon' => 'eicon-arrow-down',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__( 'Row - reversed', 'ultimate-store-kit' ),
                        'icon' => 'eicon-arrow-left',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__( 'Column - reversed', 'ultimate-store-kit' ),
                        'icon' => 'eicon-arrow-up',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__( 'Text Align', 'ultimate-store-kit' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'ultimate-store-kit' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'ultimate-store-kit' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'ultimate-store-kit' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'ultimate-store-kit' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_term_query',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs(
            'tabs_terms_include_exclude',
            []
        );
        $this->start_controls_tab(
            'tab_term_include',
            [
                'label' => __('Include', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'cats_include_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => ultimate_store_kit_get_only_parent_cats('product_cat'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_term_exclude',
            [
                'label' => __('Exclude', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'cats_exclude_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => ultimate_store_kit_get_only_parent_cats('product_cat'),
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name'       => esc_html__('Name', 'ultimate-store-kit'),
                    'count'  => esc_html__('Count', 'ultimate-store-kit'),
                    'slug' => esc_html__('Slug', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => __('Descending', 'ultimate-store-kit'),
                    'asc' => __('Ascending', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'hide_empty',
            [
                'label'         => __('Hide Empty', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();
        $this->register_global_controls_carousel_navigation();
        $this->register_global_controls_carousel_settings();

        $this->start_controls_section(
            'section_content_thumbs_settings',
            [
                'label' => __('Image Settings', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'thumbs_autoplay',
            [
                'label'         => __('Auto Play', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Yes', 'ultimate-store-kit'),
                'label_off'     => __('No', 'ultimate-store-kit'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        
        $this->add_control(
            'thumbs_loop',
            [
                'label'         => __('Loop', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Yes', 'ultimate-store-kit'),
                'label_off'     => __('No', 'ultimate-store-kit'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        
        $this->add_control(
            'thumbs_autoplay_speed',
            [
                'label'         => __('Delay', 'ultimate-store-kit'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 0,
                'max'           => 10000,
                'step'          => 5,
                'default'       => 1500,
                'dynamic'       => ['active' => true],
                'condition' => [
                    'thumbs_autoplay' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'thumbs_slide_speed',
            [
                'label'         => __('Speed', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 5000,
                        'step'  => 1,
                    ]
                ],
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 1500,
                ]
            ]
        );

        $this->add_control(
            'thumbs_effect',
            [
                'label'      => __('Effect', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SELECT,
                'options'    => [
                    'fade'  => __('Fade', 'ultimate-store-kit'),
                    'slide' => __('Slide', 'ultimate-store-kit'),
                    'creative' => __('Creative', 'ultimate-store-kit'),
                ],
                'default'    => 'fade',
                'dynamic'    => ['active' => true],
            ]
        );
        //creative effect control
		$this->add_control(
			'creative_effect',
			[ 
				'label'     => esc_html__( 'Creative Effect', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'creative-1',
				'options'   => [ 
					'creative-1' => esc_html__( 'Creative 1', 'ultimate-store-kit' ),
					'creative-2' => esc_html__( 'Creative 2', 'ultimate-store-kit' ),
					'creative-3' => esc_html__( 'Creative 3', 'ultimate-store-kit' ),
					'creative-4' => esc_html__( 'Creative 4', 'ultimate-store-kit' ),
					'creative-5' => esc_html__( 'Creative 5', 'ultimate-store-kit' ),
				],
				'condition' => [ 
					'thumbs_effect' => 'creative',
				],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab
         */
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
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'item_background',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-item',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-sub-category-carousel .usk-item',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'item_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-item',
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
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_shadow',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-item:hover',
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
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => esc_html__('Height', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min'  => 10,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__('Width', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 1,
                    ],
                    '%'  => [
                        'min'  => 10,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_alignment',
            [
                'label' => esc_html__( 'Alignment', 'ultimate-store-kit' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'ultimate-store-kit' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'ultimate-store-kit' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'ultimate-store-kit' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left' => 'margin-left: inherit;',
                    'center' => 'margin-left: auto; margin-right: auto;',
                    'right' => 'margin-right: inherit;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider' => '{{VALUE}}',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'image_width[size]',
                            'operator' => '>',
                            'value' => 0,
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'item_flex_direction',
                                    'operator' => '==',
                                    'value' => 'column',
                                ],
                                [
                                    'name' => 'item_flex_direction',
                                    'operator' => '==',
                                    'value' => 'column-reverse',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .swiper-slide',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-name' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-name',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_sub_category',
            [
                'label' => esc_html__('Sub Category', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_category_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-list a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_sub_category_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-list a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_category_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-list a',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_all_category',
            [
                'label' => esc_html__('Read More', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'all_category_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_all_category_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'all_category_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'all_category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a',
            ]
        );
        $this->end_controls_section();

        $this->register_global_controls_navigation_style();
    }

    public function render_items() {
        $settings = $this->get_settings_for_display();
        $args = [
            'taxonomy' => 'product_cat',
            'orderby'    => isset($settings['orderby']) ? $settings['orderby'] : 'name',
            'order'      => isset($settings['order']) ? $settings['order'] : 'ASC',
            'hide_empty' => isset($settings['hide_empty']) && ($settings['hide_empty'] == 'yes') ? 1 : 0,
        ];
        if (isset($settings['cats_include_by_id']) && !empty($settings['cats_include_by_id'])) {
            $args['include'] = $settings['cats_include_by_id'];
        }
        if (isset($settings['cats_exclude_by_id']) && !empty($settings['cats_exclude_by_id'])) {
            $args['exclude'] = $settings['cats_exclude_by_id'];
        }
        // print_r($args);
        $taxonomies = get_terms($args);
        if (!(empty($taxonomies))) :
            $index  = 50;
            foreach ($taxonomies as $category) :
                if ($category->parent == 0 && get_term_children($category->term_id, 'product_cat')) :
                    $this->add_render_attribute('sub-category-item', [
                        'class' => [
                            'usk-item swiper-slide'
                        ],
                        'data-settings' => [
                            wp_json_encode(array_filter([
                                "autoplay"              => ("yes" == $settings["thumbs_autoplay"]) ? ["delay" => $settings["thumbs_autoplay_speed"] + $index += rand(500, 1500)] : false,
                                "loop"                  => ($settings["thumbs_loop"] == "yes") ? true : false,
                                "speed"                 => $settings["thumbs_slide_speed"]["size"],
                                "fadeEffect"          => [ 'crossFade' => true ],
                                "effect"                => $settings["thumbs_effect"],
                                "creativeEffect" => isset($settings["creative_effect"]) ? $settings["creative_effect"] : false,
                            ]))
                        ]
                    ], null, true);
?>
                    <div <?php $this->print_render_attribute_string('sub-category-item'); ?>>
                        <div class="swiper usk-image-slider">
                            <div class="swiper-wrapper">
                                <?php
                                $parentcategory_thumb_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $images = [$parentcategory_thumb_id];

                                // Get subcategories for the specified parent category
                                $args = array(
                                    'taxonomy'   => 'product_cat',
                                    'orderby'    => isset($settings['orderby']) ? $settings['orderby'] : 'name',
                                    'order'      => isset($settings['order']) ? $settings['order'] : 'ASC',
                                    'hide_empty' => isset($settings['hide_empty']) && ($settings['hide_empty'] == 'yes') ? 1 : 0,
                                    'parent'     => $category->term_id,
                                );

                                $subcategories = get_terms($args);

                                foreach ($subcategories as $subcategory) :
                                    if ($subcategory->parent == $category->term_id) {
                                        $subcategory_thumb_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                                        $images[] = $subcategory_thumb_id;
                                    }
                                endforeach;

                                foreach ($images as $image_id) :
                                    $img_url     = wp_get_attachment_image_url($image_id, $settings['category_thumbnail_size']);
                                    if (!(empty($img_url))) : ?>
                                        <div class="swiper-slide">
                                            <div class="usk-image-wrap">
                                                <img class="usk-img" src="<?php echo esc_url($img_url); ?>" />
                                            </div>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="usk-content">

                            <?php printf('<%1$s class="usk-name">%2$s</%1$s>', esc_attr($settings['title_tags']), esc_html($category->name)); ?>
                            <div class="usk-list">
                                <?php
                                foreach ($subcategories as $key => $subcategory) :
                                    if ($subcategory->parent == $category->term_id) {
                                        printf('<a href="%1$s">%2$s</a>', esc_url(get_term_link($subcategory->term_id, 'product_cat')), esc_html($subcategory->name));
                                    }
                                endforeach;
                                ?>
                            </div>

                            <div class="usk-link-btn">
                                <?php printf(
                                    '<a href="%2$s"><span>%1$s</span><i class="usk-icon-arrow-right-8"></i></a>',
                                     /* translators: %s: Category name */ 
                                    sprintf(esc_html__('All %s', 'ultimate-store-kit'), $category->name),
                                    esc_url(get_term_link($category->term_id, 'product_cat'))
                                ); ?>
                            </div>
                        </div>
                    </div>
<?php
                endif;
            endforeach;
        endif;
    }
    public function render() {
        $this->register_global_template_carousel_header();
        $this->render_items();
        $this->usk_register_global_template_carousel_footer();
    }
}
