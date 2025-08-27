<?php

namespace UltimateStoreKit\Modules\EddCategoryGrid\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Traits\Global_Terms_Query_Controls;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class EDD_Category_Grid extends Module_Base
{
    use Global_Terms_Query_Controls;
    public function get_name()
    {
        return 'usk-edd-category-grid';
    }

    public function get_title()
    {
        return esc_html__('EDD Category Grid', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-edd-category-grid';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['easy', 'digital', 'category', 'downloads', 'eshop', 'estore', 'profile', 'editor'];
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-edd-category-grid'];
        }
    }

    // public function get_script_depends() {
    //     if ($this->usk_is_edit_mode()) {
    //         return ['usk-scripts'];
    //     } else {
    //         return ['usk-edd-category'];
    //     }
    // }

    public function get_custom_help_url()
    {
        return 'https://youtu.be/z6MSJtvbxPQ';
    }

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

        $this->add_control(
            'skin_layout',
            [
                'label' => __('Skin', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => __('Style 1', 'ultimate-store-kit'),
                    'style-2' => __('Style 2', 'ultimate-store-kit'),
                    'style-3' => __('Style 3', 'ultimate-store-kit'),
                    'style-4' => __('Style 4', 'ultimate-store-kit'),
                    'style-5' => __('Style 5', 'ultimate-store-kit'),
                    // 'style-6'  => __('Style 6', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'ultimate-store-kit'),
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid' => 'grid-template-columns:repeat({{VALUE}}, 1fr)',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_gap',
            [
                'label' => __('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_height',
            [
                'label' => esc_html__('Item Height(px)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-edd-category-grid .usk-edd-category-grid-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin_layout!' => 'style-3',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_height_skin_3',
            [
                'label' => esc_html__('Item Height(px)', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .usk-edd-category-grid-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin_layout' => 'style-3',
                ],
            ]
        );
        $this->add_control(
            'is_use_image',
            [
                'label' => esc_html__('Use Static Image', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'category_image',
            [
                'label' => __('Select Image', 'ultimate-store-kit'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'is_use_image' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'category_thumbnail',
                'exclude' => ['custom'],
                'default' => 'medium',
                // 'condition' => [
                //     'is_use_image' => 'yes',
                // ],
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label' => esc_html__('Show Count', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                // 'separator' => 'before'
            ]
        );
        $this->end_controls_section();
        $this->render_terms_query_controls('download_category');

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'name' => 'items_background',
                'label' => esc_html__('Backgrund', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .usk-edd-category-grid-image',
            ]
        );
        $this->add_control(
            'item_overlay',
            [
                'label' => esc_html__('Overlay Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item-overlay' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'skin_layout!' => ['style-3'],
                ],
            ]
        );
        $this->add_control(
            'item_overlay_blur_effect',
            [
                'label' => esc_html__('Glassmorphism', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                // 'description' => sprintf(__('This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'ultimate-store-kit'), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>'),
                'description' => sprintf(
                    /* translators: 1: opening anchor tag, 2: closing anchor tag */
                    esc_html__('This feature will not work in the Firefox browser until you enable browser compatibility, so please %1$s look here %2$s.', 'ultimate-store-kit'),
                    '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">',
                    '</a>'
                ),
                'default' => 'yes',
                'condition' => [
                    'skin_layout' => [
                        'style-5',
                    ],
                ],
            ]
        );

        $this->add_control(
            'item_overlay_blur_level',
            [
                'label' => __('Blur Level', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'step' => 1,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid.style-5 .usk-edd-category-grid-image:before' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);',
                ],
                'condition' => [
                    'item_overlay_blur_effect' => 'yes',
                    'skin_layout' => [
                        'style-5',
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'selector' => '{{WRAPPER}} .usk-edd-category-grid.style-5 .usk-edd-category-grid-image:before',
                'condition' => [
                    'skin_layout' => [
                        'style-5',
                    ],
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
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item',
            ]
        );
        $this->add_responsive_control(
            'item_radius',
            [
                'label' => esc_html__('Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // $this->add_group_control(
        //     Group_Control_Box_Shadow::get_type(),
        //     [
        //         'name'     => 'item_shadow',
        //         'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item',
        //     ]
        // );
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
                'name' => 'items_hover_background',
                'label' => esc_html__('Backgrund', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .usk-edd-category-grid-image',
                'condition' => [
                    'skin_layout!' => 'style-5',
                ],
            ]
        );
        $this->add_control(
            'item_overlay_hover',
            [
                'label' => esc_html__('Overlay Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-item-overlay' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'skin_layout!' => ['style-3'],
                ],
            ]
        );
        $this->add_control(
            'item_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin_layout' => [
                        'style-1',
                    ],
                ],
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content',
                'condition' => [
                    'skin_layout' => 'style-1',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content',
            ]
        );
        $this->add_responsive_control(
            'content_radius',
            [
                'label' => esc_html__('Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'content_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'content_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-content' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_hover_shadow',
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-content',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // $this->add_responsive_control(
        //     'category_title_spacing',
        //     [
        //         'label'         => esc_html__('Bottom Spacing', 'ultimate-store-kit'),
        //         'type'          => Controls_Manager::SLIDER,
        //         'size_units'    => ['px'],
        //         'selectors' => [
        //             '{{WRAPPER}} .edd-cateogry-carousel .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        //         ],
        //     ]
        // );
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
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'style_5_category_bg',
                'label' => esc_html__('Backgorund', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .title',
                'condition' => [
                    'skin_layout' => [
                        'style-5',
                    ],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'style_6_category_bg',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid.style-5 .usk-edd-category-grid-image:before',
                'condition' => [
                    'skin_layout' => [
                        'style-6',
                    ],
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
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'skin_layout' => [
                        'style-4',
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'exclude' => ['line_height'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .title',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'category_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'condition' => [
                    'skin_layout!' => 'style-5',
                ],
            ]
        );
        $this->add_control(
            'hover_category_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-content .title' => 'color: {{VALUE}};',
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
                'tab' => Controls_Manager::TAB_STYLE,
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
                    'skin_layout!' => [
                        'style-5',
                    ],
                ],
            ]
        );
        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .edd-category-count > *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'count_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .edd-category-count > *',
                'condition' => [
                    'skin_layout' => [
                        'style-2',
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'count_number_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .edd-category-count > *' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin_layout' => [
                        'style-2',
                    ],
                ],
            ]
        );
        // $this->add_responsive_control(
        //     'count_padding',
        //     [
        //         'label'      => __('Padding', 'ultimate-store-kit'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', 'em', '%'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .edd-category-count > *' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'count_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item .edd-content .edd-category-count > *',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'count_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'count_color_hover',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-content .edd-category-count > *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'count_hover_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-edd-category-grid .edd-item:hover .edd-content .edd-category-count > *',
                'condition' => [
                    'skin_layout' => [
                        'style-2',
                    ],
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    public function render_query() {
        $settings = $this->get_settings_for_display();
        $args = [
			'taxonomy' => 'download_category',
            'orderby' => isset($settings['orderby']) ? $settings['orderby'] : 'name',
            'order' => isset($settings['order']) ? $settings['order'] : 'ASC',
            'hide_empty' => isset($settings['hide_empty']) && ($settings['hide_empty'] == 'yes') ? 0 : 1,
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
                if ($settings['parent_cats'] != 'none' && !empty($settings['parent_cats'])) {
                    $args['child_of'] = $settings['parent_cats'];
                }
                break;
            case 'parents':
                $args['parent'] = 0;
                break;
        }
        $categories = get_terms('download_category', $args);
        return $categories;
    }
    public function render_image() {
        $settings = $this->get_settings_for_display();
        $image_src = Utils::get_placeholder_image_src();
        ?>
		<div class="usk-edd-category-grid-image">
			<?php if ($settings['is_use_image']):
            $thumb_url = Group_Control_Image_Size::get_attachment_image_src($settings['category_image']['id'], 'category_thumbnail', $settings);
            if (!empty($thumb_url)) {
                $image_src = $settings['category_image']['url'];
            }
            $path_parts = pathinfo( $image_src );
            $image_alt_text  = isset( $path_parts['filename'] ) ? $path_parts['filename'] : '';
            ?>
					<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $image_alt_text ); ?>">

				<?php endif;?>
		</div><?php
	}
    public function render_loop_item() {
        $settings = $this->get_settings_for_display();
        $categories = $this->render_query();
        // print_r($categories);
        // die;
        ?>
		<?php
		if (!empty($categories)) {
            foreach ($categories as $index => $category):

                $category_thumb_id = get_term_meta($category->term_id, 'download_term_image', true);
                $img_url = wp_get_attachment_image_url($category_thumb_id, $settings['category_thumbnail_size']);
                $category_image = $img_url ? $img_url : Utils::get_placeholder_image_src();
                $image_alt_text = pathinfo( $category_image, PATHINFO_FILENAME );

                $this->add_render_attribute('edd-category-item', 'class', ['edd-item', 'category-link'], true);
                $this->add_render_attribute('edd-category-item', 'href', get_term_link($category->term_id, 'download_category'), true);?>
					<a <?php $this->print_render_attribute_string('edd-category-item');?>>

						<?php if (!$category_thumb_id) {
							$this->render_image();
						} else { ?>
							<div class="usk-edd-category-grid-image">
								<img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr( $image_alt_text ); ?>">
							</div>
						<?php } ?>
						
						<div class="edd-content">
							<?php printf('<h3 class="title">%s</h3>', esc_html($category->name));?>
							<?php if ($settings['show_count']):
                    printf('<p class="edd-category-count"><span class="edd-count-number">%s</span><span class="edd-count-text">products</span></p>', esc_html($category->count));
                endif;
                ?>
						</div>
						<div class="edd-item-overlay"></div>
					</a>
			<?php
    		// if (!empty($settings['item_limit']['size'])) {
                //     if ($index == ($settings['item_limit']['size'] - 1)) break;
                // }
            endforeach;
        } else {
            printf('<span class="bdt-warning">%s</span>', esc_html__('Opps, Nothing found to display', 'ultimate-store-kit'));
        }
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('usk-edd-category-grid', 'class', ['usk-edd-category-grid', $settings['skin_layout']]);?>
		<div <?php $this->print_render_attribute_string('usk-edd-category-grid');?>>
			<?php $this->render_loop_item();?>
		</div>
		<?php
	}
}
