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


trait Global_Widget_Controls
{
    protected function register_global_controls_grid_layout()
    {
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-content' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-rating' => 'justify-content: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-variation-group' => 'justify-content: {{VALUE}}',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'medium_large',
            ]
        );
    }
    protected function register_global_controls_query()
    {
        $this->start_controls_section(
            'section_content_query',
            [
                'label' => esc_html__('Query', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'source',
            [
                'label' => _x('Source', 'Posts Query Control', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Show All', 'ultimate-store-kit'),
                    'by_name' => esc_html__('Manual Selection', 'ultimate-store-kit'),
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'product_categories',
            [
                'label' => esc_html__('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'options' => ultimate_store_kit_get_category('product_cat'),
                'default' => [],
                'label_block' => true,
                'multiple' => true,
                'condition' => [
                    'source' => 'by_name',
                ],
            ]
        );

        $this->add_control(
            'exclude_products',
            [
                'label' => esc_html__('Exclude Product(s)', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true, ],
                'placeholder' => 'product_id',
                'label_block' => true,
                'description' => esc_html__('Write product id here, if you want to exclude multiple products so use comma as separator. Such as 1 , 2', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Product Limit', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 9,
            ]
        );

        $this->add_control(
            'show_product_type',
            [
                'label' => esc_html__('Show Product', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all' => esc_html__('All Products', 'ultimate-store-kit'),
                    'onsale' => esc_html__('On Sale', 'ultimate-store-kit'),
                    'featured' => esc_html__('Featured', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order by', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'ultimate-store-kit'),
                    'price' => esc_html__('Price', 'ultimate-store-kit'),
                    'sales' => esc_html__('Sales', 'ultimate-store-kit'),
                    'rand' => esc_html__('Random', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'ultimate-store-kit'),
                    'ASC' => esc_html__('Ascending', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Pagination', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                // 'default' => 'yes'
            ]
        );

        $this->add_control(
            'show_per_page',
            [
                'label' => esc_html__('Show Per Page', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '10',
                'options' => [
                    '10' => '10',
                    '25' => '25',
                    '50' => '50',
                    '100' => '100',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hide_free',
            [
                'label' => esc_html__('Hide Free', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_out_stock',
            [
                'label' => esc_html__('Hide Out of Stock', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_additional()
    {
        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Settings', 'ultimate-store-kit'),
            ]
        );
        $this->start_controls_tabs(
            'tabs_show_hide_content'
        );
        $this->start_controls_tab(
            'show_content_tab',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
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
                'label' => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );
        if ($this->get_name() !== 'usk-glossy-grid' && $this->get_name() !== 'usk-glossy-carousel'):
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
                    'label' => esc_html__('Category HTML Tag', 'ultimate-store-kit'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'h5',
                    'options' => ultimate_store_kit_title_tags(),
                    'condition' => [
                        'show_category' => 'yes',
                    ],
                ]
            );
        endif;
        if ($this->get_name() !== 'usk-product-image-accordion' && $this->get_name() !== 'usk-heaven-slider' && $this->get_name() !== 'usk-glossy-grid' && $this->get_name() !== 'usk-florence-grid'):
            $this->add_control(
                'show_excerpt',
                [
                    'label' => esc_html__('Text', 'ultimate-store-kit'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'separator' => 'before',
                    'condition' => [
                        'layout_style' => 'list',
                    ]
                ]
            );
            $this->add_control(
                'excerpt_limit',
                [
                    'label' => esc_html__('Text Limit', 'ultimate-store-kit'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 15,
                    'condition' => [
                        'show_excerpt' => 'yes',
                        'layout_style' => 'list'
                    ],
                ]
            );
        endif;
        //enable this option for heaven slider
        if ($this->get_name() === 'usk-heaven-slider'):
            $this->add_control(
                'show_excerpt',
                [
                    'label' => esc_html__('Text', 'ultimate-store-kit'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'excerpt_limit',
                [
                    'label' => esc_html__('Text Limit', 'ultimate-store-kit'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 25,
                    'condition' => [
                        'show_excerpt' => 'yes',
                    ],
                ]
            );
        endif;
        $this->add_control(
            'show_rating',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
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
        if ($this->get_name() === 'usk-shiny-grid'):
            $this->add_control(
                'show_variation',
                [
                    'label' => esc_html__('Show Variation', 'ultimate-store-kit') . BDTUSK_PC,
                    'type' => Controls_Manager::SWITCHER,
                    'separator' => 'before',
                    'default' => 'no',
                    'classes' => BDTUSK_IS_PC
                ]
            );
            $this->add_control(
                'show_variation_sequential',
                [
                    'label' => esc_html__('Show Variation Sequential', 'ultimate-store-kit'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'no',
                    'condition' => [
                        'show_variation' => 'yes',
                    ],
                ]
            );
        endif;
        if ($this->get_name() === 'usk-image-hotspot'):
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'thumbnail',
                    'label' => __('Image Size', 'ultimate-store-kit'),
                    'default' => 'full',
                    'separator' => 'before',
                ]
            );
        endif;

        $this->end_controls_tab();
        $this->start_controls_tab(
            'show_sale_badge_tab',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_sale_badge',
            [
                'label' => esc_html__('Sale', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_discount_badge',
            [
                'label' => esc_html__('Percentage', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_stock_status',
            [
                'label' => esc_html__('Stock Status', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                // 'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_trending_badge',
            [
                'label' => esc_html__('Trending', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_new_badge',
            [
                'label' => esc_html__('New', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'newness_days',
            [
                'label' => esc_html__('Newness Days', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 30,
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'show_action_btn_tab',
            [
                'label' => esc_html__('Action btn', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_wishlist',
            [
                'label' => esc_html__('Wishlist', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_compare',
            [
                'label' => esc_html__('Compare', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'show_quick_view',
            [
                'label' => esc_html__('Quick View', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_cart',
            [
                'label' => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_global_controls_grid_columns()
    {
        $this->start_controls_section(
            'section_style_columns_filter',
            [
                'label' => esc_html__('Columns Filter', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'columns_filter_background',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a',
            ]
        );

        $this->add_responsive_control(
            'columns_filter_border_width',
            [
                'label' => esc_html__('Border Width', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
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
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_filter_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_filter_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'columns_filter_hover_background',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list a:hover',
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list.usk-tabs-active a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'columns_filter_active_background',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-grid-tabs-list.usk-tabs-active a',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_global_controls_result_count()
    {
        $this->start_controls_section(
            'section_style_result_count',
            [
                'label' => esc_html__('Count Result', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_tab' => 'yes',
                    'show_result_count' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'result_count_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-result-count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'result_count_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-result-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'result_count_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .woocommerce-result-count',
            ]
        );

        $this->end_controls_section();
    }

    protected function register_global_controls_grid_items()
    {
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Items', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('item_tabs');

        $this->start_controls_tab(
            'item_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        if ($this->get_name() !== 'usk-glossy-grid') {
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'item_shadow',
                    'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item',
                ]
            );
        }

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_hover_background',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_border_border!' => '',
                ],
            ]
        );

        if ($this->get_name() !== 'usk-glossy-grid') {
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'item_hover_shadow',
                    'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover',
                ]
            );
        }
        if ($this->get_name() === 'usk-glossy-grid') {
            $this->add_control(
                'item_box_shadow_color',
                [
                    'label' => esc_html__('Shadow Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-glossy-grid .usk-product-hover:before' => 'box-shadow: 0 8px 55px {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'item_shape_color',
                [
                    'label' => esc_html__('Shape Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-glossy-grid .usk-product-hover:before' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
        }

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_global_controls_grid_image()
    {
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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

        $this->add_responsive_control(
            'list_image_size',
            [
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'layout_style' => 'list',
                ],
                'separator' => 'after',
            ]
        );

        $this->add_responsive_control(
            'list_image_size_filter',
            [
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_tab' => 'yes',
                ],
                'separator' => 'after',
            ]
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_background',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-image',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow',
                'exclude' => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-image',
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
                'name' => 'image_hover_background',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_hover_border',
                'label' => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_hover_shadow',
                'exclude' => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_global_controls_content()
    {
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'name' => 'content_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
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
                'name' => 'content_hover_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content:hover',
            ]
        );
        $this->add_control(
            'content_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'content_border_border!' => '',
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

    protected function register_global_controls_title()
    {
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-title .title',
            ]
        );

        $this->end_controls_section();
    }

    public function register_global_controls_add_to_cart()
    {
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button.loading::after' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_color',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Width(%)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . '' => '--btn-width: {{SIZE}}%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label' => esc_html__('Height(px)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hover_bg',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function register_global_controls_category()
    {
        $this->start_controls_section(
            'section_style_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'category_bg_color',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'category_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_space_between',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_shadow',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a',
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_category_bg_color',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover',
            ]
        );
        $this->add_control(
            'hover_category_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover' => 'border-color: {{VALUE}};',
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

    protected function register_global_controls_excerpt()
    {
        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                    'layout_style' => 'list'

                ]
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-list-layout .usk-desc' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-list-layout .usk-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-list-layout .usk-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-list-layout .usk-desc',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_price()
    {
        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'regular_price_color',
            [
                'label' => esc_html__('Regular Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price del' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'sale_price_color',
            [
                'label' => esc_html__('Sale Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price ins span' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price .woocommerce-Price-amount.amount' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sale_price_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '
                {{WRAPPER}} .' . $this->get_name() . ' .usk-price',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_rating()
    {
        $this->start_controls_section(
            'section_style_rating',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_rating' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-rating .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_rating_color',
            [
                'label' => esc_html__('Active Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_action_btn()
    {
        $this->start_controls_section(
            'style_action_btn',
            [
                'label' => esc_html__('Action Button', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'show_cart',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_wishlist',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_quick_view',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_compare',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'action_btn_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_size',
            [
                'label' => __('Icon Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-shoping a .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'font_family',
            [
                'label' => esc_html__('Tooltip Font', 'ultimate-store-kit'),
                'type' => Controls_Manager::FONT,
                'selectors' => [
                    '{{WRAPPER}} .usk-shoping a' => 'font-family: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs(
            'action_btn_tabs'
        );
        $this->start_controls_tab(
            'wishlist_tab',
            [
                'label' => esc_html__('Wishlist', 'ultimate-store-kit'),
                'condition' => [
                    'show_wishlist' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'wishlist_normal_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_wishlist_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'wishlist_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_border_hover_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );

        $this->add_control(
            'heading_wishlist_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'wishlist_active_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'compare_tab',
            [
                'label' => esc_html__('Compare', 'ultimate-store-kit'),
                'condition' => [
                    'show_compare' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'compare_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_compare_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'compare_color_hover',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_hover_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_compare_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'compare_color_active',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_active',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_active_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'quickview_tab',
            [
                'label' => esc_html__('Quickview', 'ultimate-store-kit'),
                'condition' => [
                    'show_quick_view' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'quickview_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_quickview_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'quickview_color_hover',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_border_hover_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();

        if ($this->get_name() !== 'usk-shiny-grid' && $this->get_name() !== 'usk-shiny-carousel'):
            $this->start_controls_tab(
                'add_to_cart_tab',
                [
                    'label' => esc_html__('Cart', 'ultimate-store-kit'),
                    'condition' => [
                        'show_cart' => 'yes'
                    ]
                ]
            );
            $this->add_control(
                'cart_color',
                [
                    'label' => esc_html__('Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_icon_bg',
                [
                    'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart' => 'background: {{VALUE}}',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart' => 'background: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_border_color',
                [
                    'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart' => 'border-color: {{VALUE}} !important;',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart' => 'border-color: {{VALUE}} !important;',
                    ],
                    'condition' => [
                        'action_btn_border_border!' => ''
                    ]
                ]
            );
            $this->add_control(
                'heading_cart_hover',
                [
                    'label' => esc_html__('Hover', 'ultimate-store-kit'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'cart_color_hover',
                [
                    'label' => esc_html__('Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart:hover' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_icon_bg_hover',
                [
                    'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart:hover' => 'background: {{VALUE}}',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart:hover' => 'background: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_border_hover_color',
                [
                    'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-cart:hover' => 'border-color: {{VALUE}} !important;',
                        '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .added_to_cart:hover' => 'border-color: {{VALUE}} !important;',
                    ],
                    'condition' => [
                        'action_btn_border_border!' => ''
                    ]
                ]
            );
            $this->end_controls_tab();
        endif;
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_global_controls_grid_pagination()
    {
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => esc_html__('Pagination', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'pagination_alignment',
            [
                'label' => esc_html__('Alignment', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination' => 'justify-content: {{VALUE}};',
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li:not(.usk-active) a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li:not(.usk-active) a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'pagination_padding',
            [
                'label' => __('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-pagination li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-pagination li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_spacing_top',
            [
                'label' => esc_html__('Top Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination' => 'margin-top: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a, {{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a li span',
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_pagination_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'background:{{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_pagination_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li a:hover' => 'border-color:{{VALUE}};',
                ],
                'condition' => [
                    'pagination_border_border!' => ''
                ],
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
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'active_pagination_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'background:{{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'active_pagination_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-pagination li.usk-active a' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register global controls for badge
     */
    protected function register_global_controls_badge()
    {
        $this->start_controls_section(
            'badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'show_sale_badge',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_discount_badge',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_stock_status',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_trending_badge',
                            'value' => 'yes'
                        ],
                        [
                            'name' => 'show_new_badge',
                            'value' => 'yes'
                        ]
                    ]
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge',
            ]
        );
        $this->add_responsive_control(
            'badge_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_spacing',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge',
            ]
        );
        $this->add_responsive_control(
            'badge_display_type',
            [
                'label' => esc_html__('Display Type', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Inline', 'ultimate-store-kit'),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                    'column' => [
                        'title' => esc_html__('Grid', 'ultimate-store-kit'),
                        'icon' => 'eicon-ellipsis-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'label_badge_tabs'
        );
        $this->start_controls_tab(
            'sale_badge_tab',
            [
                'label' => esc_html__('Sale', 'ultimate-store-kit'),
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'sale_badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sale_badge_bg',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge',
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'sale_badge_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_sale_badge' => 'yes',
                    'badge_border_border!' => '',
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'discount_badge_tab',
            [
                'label' => esc_html__('Discount', 'ultimate-store-kit'),
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'discount_badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'discount_badge_bg',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge',
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'discount_badge_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_discount_badge' => 'yes',
                    'badge_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'stock_badge_tab',
            [
                'label' => esc_html__('Stock', 'ultimate-store-kit'),
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'stock_badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'stock_badge_bg',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge',
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'stock_badge_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_stock_status' => 'yes',
                    'badge_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trending_badge_tab',
            [
                'label' => esc_html__('Trending', 'ultimate-store-kit'),
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'trending_badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'trending_badge_bg',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge',
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'trending_badge_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_trending_badge' => 'yes',
                    'badge_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'new_badge_tab',
            [
                'label' => esc_html__('New', 'ultimate-store-kit'),
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'new_badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'new_badge_bg',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge',
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'new_badge_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_new_badge' => 'yes',
                    'badge_border_border!' => '',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_global_controls_carousel_navigation()
    {
        $this->start_controls_section(
            'section_content_navigation',
            [
                'label' => __('Navigation', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => __('Navigation', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'arrows',
                'options' => [
                    'both' => esc_html__('Arrows and Dots', 'ultimate-store-kit'),
                    'arrows-fraction' => esc_html__('Arrows and Fraction', 'ultimate-store-kit'),
                    'arrows' => esc_html__('Arrows', 'ultimate-store-kit'),
                    'dots' => esc_html__('Dots', 'ultimate-store-kit'),
                    'progressbar' => esc_html__('Progress', 'ultimate-store-kit'),
                    'none' => esc_html__('None', 'ultimate-store-kit'),
                ],
                'prefix_class' => 'usk-navigation-type-',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'both_position',
            [
                'label' => __('Arrows and Dots Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => ultimate_store_kit_navigation_position(),
                'condition' => [
                    'navigation' => 'both',
                ],
            ]
        );

        $this->add_control(
            'arrows_fraction_position',
            [
                'label' => __('Arrows and Fraction Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => ultimate_store_kit_navigation_position(),
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label' => __('Arrows Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => ultimate_store_kit_navigation_position(),
                'condition' => [
                    'navigation' => 'arrows',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => __('Dots Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom-center',
                'options' => ultimate_store_kit_pagination_position(),
                'condition' => [
                    'navigation' => 'dots',
                ],

            ]
        );

        $this->add_control(
            'progress_position',
            [
                'label' => __('Progress Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'bottom' => esc_html__('Bottom', 'ultimate-store-kit'),
                    'top' => esc_html__('Top', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'dynamic_bullets',
            [
                'label' => __('Dynamic Bullets?', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_control(
            'show_scrollbar',
            [
                'label' => __('Show Scrollbar?', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'nav_arrows_icon',
            [
                'label' => esc_html__('Arrows Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => esc_html__('Style 1', 'ultimate-store-kit'),
                    '2' => esc_html__('Style 2', 'ultimate-store-kit'),
                    '3' => esc_html__('Style 3', 'ultimate-store-kit'),
                    '4' => esc_html__('Style 4', 'ultimate-store-kit'),
                    '5' => esc_html__('Style 5', 'ultimate-store-kit'),
                    '6' => esc_html__('Style 6', 'ultimate-store-kit'),
                    '7' => esc_html__('Style 7', 'ultimate-store-kit'),
                    '8' => esc_html__('Style 8', 'ultimate-store-kit'),
                    '9' => esc_html__('Style 9', 'ultimate-store-kit'),
                    '10' => esc_html__('Style 10', 'ultimate-store-kit'),
                    '11' => esc_html__('Style 11', 'ultimate-store-kit'),
                    '12' => esc_html__('Style 12', 'ultimate-store-kit'),
                    '13' => esc_html__('Style 13', 'ultimate-store-kit'),
                    '14' => esc_html__('Style 14', 'ultimate-store-kit'),
                    '15' => esc_html__('Style 15', 'ultimate-store-kit'),
                    '16' => esc_html__('Style 16', 'ultimate-store-kit'),
                    '17' => esc_html__('Style 17', 'ultimate-store-kit'),
                    '18' => esc_html__('Style 18', 'ultimate-store-kit'),
                    'circle-1' => esc_html__('Style 19', 'ultimate-store-kit'),
                    'circle-2' => esc_html__('Style 20', 'ultimate-store-kit'),
                    'circle-3' => esc_html__('Style 21', 'ultimate-store-kit'),
                    'circle-4' => esc_html__('Style 22', 'ultimate-store-kit'),
                    'square-1' => esc_html__('Style 23', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'navigation' => ['arrows-fraction', 'both', 'arrows'],
                ],
            ]
        );

        $this->add_control(
            'hide_arrow_on_mobile',
            [
                'label' => __('Hide Arrows on Mobile', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'navigation' => ['arrows-fraction', 'arrows', 'both'],
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_navigation_style()
    {
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'operator' => '!=',
                            'value' => 'none',
                        ],
                        [
                            'name' => 'show_scrollbar',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_heading',
            [
                'label' => __('Arrows', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation_arrows_style');

        $this->start_controls_tab(
            'tabs_nav_arrows_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev i, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label' => __('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nav_arrows_border',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next',
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label' => __('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev i,
					{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next i' => 'font-size: {{SIZE || 24}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_space',
            [
                'label' => __('Space Between Arrows', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev' => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'margin-left: {{SIZE}}px;',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_arrows_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev:hover i, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next:hover i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_background',
            [
                'label' => __('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev:hover, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'nav_arrows_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev:hover, {{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'nav_arrows_border_border!' => '',
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr_1',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_heading',
            [
                'label' => __('Dots', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'hr_11',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'active_dot_color',
            [
                'label' => __('Active Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_width_size',
            [
                'label' => __('Width(px)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_height_size',
            [
                'label' => __('Height(px)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'hr_22',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_heading',
            [
                'label' => __('Fraction', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_12',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-fraction' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'active_fraction_color',
            [
                'label' => __('Active Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-current' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'fraction_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-fraction',
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_3',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_heading',
            [
                'label' => __('Progresbar', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_13',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_color',
            [
                'label' => __('Bar Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progres_color',
            [
                'label' => __('Progress Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_4',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_heading',
            [
                'label' => __('Scrollbar', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hr_14',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_color',
            [
                'label' => __('Bar Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-scrollbar' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_drag_color',
            [
                'label' => __('Drag Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-scrollbar .swiper-scrollbar-drag' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'scrollbar_height',
            [
                'label' => __('Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-horizontal > .swiper-scrollbar' => 'height: {{SIZE}}px;',
                ],
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hr_05',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'navi_offset_heading',
            [
                'label' => __('Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'hr_6',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_responsive_control(
            'arrows_ncx_position',
            [
                'label' => __('Arrows Horizontal Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name' => 'arrows_position',
                            'operator' => '!=',
                            'value' => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-arrows-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_ncy_position',
            [
                'label' => __('Arrows Vertical Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-arrows-ncy: {{SIZE}}px;'
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows',
                        ],
                        // [
                        //     'name'     => 'arrows_position',
                        //     'operator' => '!=',
                        //     'value'    => 'center',
                        // ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_acx_position',
            [
                'label' => __('Arrows Horizontal Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -60,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name' => 'arrows_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nnx_position',
            [
                'label' => __('Dots Horizontal Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name' => 'dots_position',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-dots-nnx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nny_position',
            [
                'label' => __('Dots Vertical Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'tablet_default' => [
                    'size' => 30,
                ],
                'mobile_default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name' => 'dots_position',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-dots-nny: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncx_position',
            [
                'label' => __('Arrows & Dots Horizontal Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name' => 'both_position',
                            'operator' => '!=',
                            'value' => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-both-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncy_position',
            [
                'label' => __('Arrows & Dots Vertical Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name' => 'both_position',
                            'operator' => '!=',
                            'value' => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-both-ncy: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cx_position',
            [
                'label' => __('Arrows Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -60,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name' => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cy_position',
            [
                'label' => __('Dots Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-dots-container' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name' => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncx_position',
            [
                'label' => __('Arrows & Fraction Horizontal Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name' => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value' => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-arrows-fraction-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncy_position',
            [
                'label' => __('Arrows & Fraction Vertical Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'tablet_default' => [
                    'size' => 0,
                ],
                'mobile_default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name' => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value' => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--usk-swiper-carousel-arrows-fraction-ncy: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cx_position',
            [
                'label' => __('Arrows Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => -60,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name' => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cy_position',
            [
                'label' => __('Fraction Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name' => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'progress_y_position',
            [
                'label' => __('Progress Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_responsive_control(
            'scrollbar_vertical_offset',
            [
                'label' => __('Scrollbar Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .swiper-horizontal > .swiper-scrollbar' => 'bottom: {{SIZE}}px;',
                ],
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_carousel_settings()
    {
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => __('Carousel Settings', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'skin',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'carousel',
                'options' => [
                    'carousel' => esc_html__('Carousel', 'ultimate-store-kit'),
                    'coverflow' => esc_html__('Coverflow', 'ultimate-store-kit'),
                ],
                'prefix_class' => 'usk-carousel-style-',
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'coverflow_toggle',
            [
                'label' => __('Coverflow Effect', 'ultimate-store-kit'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'condition' => [
                    'skin' => 'coverflow'
                ]
            ]
        );

        $this->start_popover();

        $this->add_control(
            'coverflow_rotate',
            [
                'label' => esc_html__('Rotate', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    'px' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 5,
                    ],
                ],
                'condition' => [
                    'coverflow_toggle' => 'yes'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'coverflow_stretch',
            [
                'label' => __('Stretch', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 10,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'coverflow_toggle' => 'yes'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'coverflow_modifier',
            [
                'label' => __('Modifier', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'step' => 1,
                        'max' => 10,
                    ],
                ],
                'condition' => [
                    'coverflow_toggle' => 'yes'
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'coverflow_depth',
            [
                'label' => __('Depth', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 10,
                        'max' => 1000,
                    ],
                ],
                'condition' => [
                    'coverflow_toggle' => 'yes'
                ],
                'render_type' => 'template',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'hr_005',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'skin' => 'coverflow'
                ]
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pauseonhover',
            [
                'label' => esc_html__('Pause on Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Slides to Scroll', 'ultimate-store-kit'),
                'default' => 1,
                'tablet_default' => 1,
                'mobile_default' => 1,
                'options' => [
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
            'centered_slides',
            [
                'label' => __('Center Slide', 'ultimate-store-kit'),
                'description' => __('Use even items from Layout > Columns settings for better preview.', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'grab_cursor',
            [
                'label' => __('Grab Cursor', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => __('Loop', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );


        $this->add_control(
            'speed',
            [
                'label' => __('Animation Speed (ms)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 5000,
                        'step' => 50,
                    ],
                ],
            ]
        );

        $this->add_control(
            'observer',
            [
                'label' => __('Observer', 'ultimate-store-kit'),
                'description' => __('When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'item_shadow_padding',
            [
                'label' => __('Match Padding', 'ultimate-store-kit'),
                'description' => __('You have to add padding for matching overlaping normal/hover box shadow when you used Box Shadow option.', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 50,
                    ]
                ],
                'default' => [
                    'size' => 10
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-carousel' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'item_match_height',
            [
                'label' => __('Item Match Height', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'usk-item-match-height--',
                'render_type' => 'template'
            ]
        );

        $this->end_controls_section();
    }
    protected function register_global_controls_variation()
    {
        $this->start_controls_section(
            'section_global_variation',
            [
                'label' => __('Variation', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_variation' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('tabs_variation_style');

        $this->start_controls_tab(
            'tab_variation_wrapper',
            [
                'label' => esc_html__('Wrapper', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'variation_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_variation_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'variation_color_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-color-button' => '--usk-variation-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'variation_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-color-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_variation_size',
            [
                'label' => esc_html__('Common', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'variation_size_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'variation_size_typography',
                'selector' => '{{WRAPPER}} .usk-variations-container .usk-variation-button',
            ]
        );

        $this->add_control(
            'variation_size_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'variation_size_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-pa_size-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'variation_size_border',
                'selector' => '{{WRAPPER}} .usk-variations-container .usk-variation-button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'variation_size_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_hover_heading',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'variation_size_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_hover_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_active_heading',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'variation_size_active_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_active_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'variation_size_active_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-variations-container .usk-variation-button.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}
