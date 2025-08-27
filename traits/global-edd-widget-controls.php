<?php

namespace UltimateStoreKit\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;



// use UltimateStoreKit\Modules\QueryControl\Controls\Group_Control_Posts;

defined('ABSPATH') || die();


trait Global_EDD_Widget_Controls {
    protected function register_global_edd_controls_carousel_layout() {
        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__('Columns', 'ultimate-store-kit'),
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
        $this->add_responsive_control(
            'items_gap',
            [
                'label'   => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range'   => [
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
            'alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-top-content' => 'text-align:{{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-content .usk-edd-price' => 'justify-content:{{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-content' => 'text-align:{{VALUE}}',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'label'     => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude'   => ['custom'],
                'default'   => 'medium',
            ]
        );

        $this->end_controls_section();
    }
    public function register_global_edd_controls_grid_layout() {
        $this->start_controls_section(
            'section_edd_grid_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__('Columns', 'ultimate-store-kit'),
                'type'           => Controls_Manager::SELECT,
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-wrapper' => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
                ]
            ]
        );

        $this->add_responsive_control(
            'items_columns_gap',
            [
                'label'     => esc_html__('Columns Gap', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-wrapper' => 'grid-column-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_row_gap',
            [
                'label'     => esc_html__('Row Gap', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-wrapper' => 'grid-row-gap: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-content .usk-edd-price' => 'justify-content:{{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item-box' => 'text-align:{{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-content' => 'text-align:{{VALUE}}',
                ]
            ]
        );
        $this->add_control(
            'show_tab',
            [
                'label'     => __('Title', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'traditional',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'label'     => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude'   => ['custom'],
                'default'   => 'medium',
            ]
        );
        $this->add_control(
            'show_pagination',
            [
                'label'     => esc_html__('Pagination', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );
        $this->end_controls_section();
    }
    protected function register_global_edd_controls_query() {
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->register_query_builder_controls();

        $this->update_control(
            'product_source',
            [
                'type'      => Controls_Manager::SELECT,
                'default'   => 'download',
                'options' => [
                    'download' => "Download",
                    'manual_selection'   => __('Manual Selection', 'ultimate-store-kit'),
                    'current_query'      => __('Current Query', 'ultimate-store-kit'),
                    '_related_post_type' => __('Related', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->update_control(
            'product_limit',
            [
                'label'   => esc_html__('Product Limit', 'ultimate-store-kit'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->update_control(
            'posts_selected_ids',
            [
                'query_args'  => [
                    'query' => 'posts',
                    'post_type' => 'download'
                ],
            ]
        );
        $this->update_control(
            'posts_offset',
            [
                'label' => __('Offset', 'ultimate-store-kit'),
                'type'  => Controls_Manager::NUMBER,
                'default'   => 0,

            ]
        );
        $this->add_control(
            'query_id',
            [
                'label'       => __('Query ID', 'ultimate-store-kit'),
                'description' => __('Give your Query a custom unique id to allow server side filtering', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'separator'   => 'before',
                'dynamic' => [ 'active' => true, ],
            ]
        );
        $this->end_controls_section();
    }
    protected function register_global_edd_controls_additional() {
        $this->start_controls_section(
            'section_edd_additional',
            [
                'label' => esc_html__('Additional', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'category_tags',
            [
                'label'     => esc_html__('Category HTML Tag', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h5',
                'options'   => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_category' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => esc_html__('Price', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
    }

    protected function register_global_edd_controls_grid_columns() {
        $this->start_controls_section(
            'section_style_columns_filter',
            [
                'label' => esc_html__('Columns Filter', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => ['show_tab' => 'yes']
            ]
        );

        $this->start_controls_tabs('style_columns_filter_tabs');

        $this->start_controls_tab(
            'tab_columns_filter_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'columns_filter_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'columns_filter_background',
                'exclude'  => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a',
            ]
        );

        $this->add_responsive_control(
            'columns_filter_border_width',
            [
                'label' => esc_html__('Border Width', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-filter-border-width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'columns_filter_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_filter_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_filter_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_columns_filter_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'columns_filter_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'columns_filter_hover_background',
                'exclude'  => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_columns_filter_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'columns_filter_active_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list.usk-tabs-active a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'columns_filter_active_background',
                'exclude'  => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-header .usk-grid-header-tabs .usk-grid-tabs-list.usk-tabs-active a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_global_edd_style_controls_items() {
        $this->start_controls_section(
            'section_style_item',
            [
                'label'     => esc_html__('Item', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_item_style');

        $this->start_controls_tab(
            'tab_item_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_background',
                'label'     => __('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'item_border',
                'label'       => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector'    => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'item_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item',
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Item Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Content Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item .usk-edd-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_hover_background',
                'label'     => __('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_shadow',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        if (($this->get_name() == 'usk-edd-trendy-grid') || ($this->get_name() == 'usk-edd-trendy-carousel')) :
            $this->add_control(
                'item_line_animation',
                [
                    'label'     => __('Line Animation', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'item_line_animation_color',
                [
                    'label'     => __('Color', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item::before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_responsive_control(
                'item_line_animation_height',
                [
                    'label'         => __('Height', 'ultimate-store-kit'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px',],
                    'range'         => [
                        'px'        => [
                            'min'   => 0,
                            'max'   => 10,
                            'step'  => 1,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-item::before' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        endif;

        $this->end_controls_section();
    }
    protected function register_global_edd_controls_grid_image() {
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'style_tabs_image'
        );
        $this->start_controls_tab(
            'image_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'image_background',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-image',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_shadow',
                'exclude'  => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .' . $this->get_name() . '-image',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'image_hover_background',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-item-box .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hover_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-item-box .usk-image',
                'separator'      => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_hover_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-item-box .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_hover_shadow',
                'exclude'  => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-item-box .usk-image',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_global_edd_controls_content() {
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_content_style');

        $this->start_controls_tab(
            'tab_content_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'content_background',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'content_border',
                'label'          => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content',
                'separator'      => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_content_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'content_hover_background',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content:hover',
            ]
        );
        $this->add_control(
            'content_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-content:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_global_edd_style_controls_title() {
        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Title', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-title a:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-title a',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_global_edd_style_controls_category() {
        $this->start_controls_section(
            'section_style_category',
            [
                'label'     => esc_html__('Category', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_category' => 'yes',
                ],
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'category_bg_color',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'category_border',
                'label'          => __('Border', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'category_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'category_shadow',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'hover_category_bg_color',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a:hover',
            ]
        );
        $this->add_control(
            'hover_category_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-category a:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'category_border_border!' => ''
                ],
                'separator' => 'before'
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_global_edd_style_controls_action_button() {
        $this->start_controls_section(
            'style_action_btn',
            [
                'label' => esc_html__('Action Button', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'action_btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button a, {{WRAPPER}} .' . $this->get_name() . ' .edd-add-to-cart',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button a, {{WRAPPER}} .' . $this->get_name() . ' .edd-add-to-cart'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button a, {{WRAPPER}} .' . $this->get_name() . ' .edd-add-to-cart'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button a, {{WRAPPER}} .' . $this->get_name() . ' .edd-add-to-cart'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        if (($this->get_name() == 'usk-edd-beauty-grid') || ($this->get_name() == 'usk-edd-beauty-carousel') || ($this->get_name() == 'usk-edd-standard-grid') || ($this->get_name() == 'usk-edd-standard-carousel')) :
            $this->add_responsive_control(
                'action_btn_space_between',
                [
                    'label'         => __('Space Between', 'ultimate-store-kit'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px'],
                    'range'         => [
                        'px'        => [
                            'min'   => 0,
                            'max'   => 50,
                            'step'  => 1,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button' => 'gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        endif;

        if (($this->get_name() == 'usk-edd-classic-grid') || ($this->get_name() == 'usk-edd-classic-carousel') || ($this->get_name() == 'usk-edd-trendy-grid') || ($this->get_name() == 'usk-edd-trendy-carousel')) :
            $this->add_responsive_control(
                'action_btn_space_between_classic_trendy',
                [
                    'label'         => __('Space Between', 'ultimate-store-kit'),
                    'type'          => Controls_Manager::SLIDER,
                    'size_units'    => ['px'],
                    'range'         => [
                        'px'        => [
                            'min'   => 0,
                            'max'   => 50,
                            'step'  => 1,
                        ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
        endif;

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'action_btn_typography',
                'label'     => __('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button a, {{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .edd-add-to-cart',
            ]
        );

        $this->start_controls_tabs(
            'action_btn_tabs'
        );
        $this->start_controls_tab(
            'view_details_tab',
            [
                'label' => esc_html__('View Details', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'view_details_normal_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-details-button a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'view_details_bg',
                'label'     => __('Title', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-details-button a',
            ]
        );
        $this->add_control(
            'heading_view_details_hover',
            [
                'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'view_details_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-details-button a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'view_details_hover_bg',
                'label'     => __('Title', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-details-button a:hover',
            ]
        );

        $this->add_control(
            'action_btn_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-details-button a:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'action_btn_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'purchase_btn_tab',
            [
                'label' => esc_html__('Purchase', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'purchase_btn_normal_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .blue' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'purchase_btn_bg',
                'label'     => __('Title', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .blue',
            ]
        );
        $this->add_control(
            'heading_purchase_btn_hover',
            [
                'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'purchase_btn_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .blue:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'purchase_btn_hover_bg',
                'label'     => __('Title', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .blue:hover',
            ]
        );

        $this->add_control(
            'action_btn_purchase_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-action-button .blue:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_global_edd_style_controls_price() {
        $this->start_controls_section(
            'section_style_price',
            [
                'label'     => esc_html__('Price', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-edd-price',
            ]
        );
        $this->end_controls_section();
    }
    protected function register_global_edd_controls_grid_pagination() {
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label'     => esc_html__('Pagination', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );
        $this->start_controls_tabs(
            'pagination_normal'
        );
        $this->start_controls_tab(
            'pagination_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li:not(.usk-active) a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li:not(.usk-active) a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'pagination_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li:not(.usk-active) a',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'pagination_alignment',
            [
                'label'     => esc_html__('Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'flex-start',
                'toggle'    => false,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination' => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'pagination_padding',
            [
                'label'                 => __('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-pagination li a'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_radius',
            [
                'label'                 => __('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-pagination li a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_spacing_top',
            [
                'label'     => esc_html__('Top Spacing', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination' => 'margin-top: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label'         => esc_html__('Space Between', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a, {{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a li span',
                // 'exclude'  => ['letter_spacing', 'text_decoration', 'text_transform', 'font_size', 'line_height'],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'pagination_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'hover_pagination_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_pagination_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'background:{{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_pagination_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'border-color:{{VALUE}};',
                ],
                // 'condition' => [
                //     'pagination_border!' => ' '
                // ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'pagination_tab_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'active_pagination_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'active_pagination_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'background:{{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'active_pagination_border_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'border-color: {{VALUE}};',
                ],
                // 'condition' => [
                //     'pagination_border!' => ''
                // ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
