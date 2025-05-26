<?php

namespace UltimateStoreKit\Modules\ProductAccordion\Widgets;

use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Product_Accordion extends Module_Base
{
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name()
    {
        return 'usk-product-accordion';
    }
    public function get_title()
    {
        return BDTUSK . esc_html__('Product Accordion', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-product-accordion';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['woocommerce', 'shop', 'store', 'title', 'heading', 'product'];
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-product-accordion', 'usk-font'];
        }
    }

    public function get_script_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['micromodal', 'usk-accordion'];
        } else {
            return ['micromodal', 'usk-product-accordion', 'usk-accordion'];
        }
    }

    public function get_custom_help_url()
    {
        return 'https://youtu.be/uWSRAnKjEEU?si=VAxAf_aryJYvmqbQ';
    }

    public function get_query()
    {
        return $this->_query;
    }
    public function has_widget_inner_wrapper(): bool
    {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );
        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => __('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_tags',
            [
                'label' => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $this->add_control(
            'show_description',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'excerpt_limit',
            [
                'label' => esc_html__('Text Limit', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::NUMBER,
                'default' => 25,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

        $this->add_responsive_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Top', 'ultimate-store-kit'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Bottom', 'ultimate-store-kit'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-single-item-box' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->register_controls_wc_additional();
        $this->update_control(
            'product_limit',
            [
                'label' => esc_html__('Product Limit', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Additional Options', 'ultimate-store-kit'),
            ]
        );
        $this->start_controls_tabs(
            'tabs_show_hide_content'
        );
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
                'default' => 'yes',
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
            'show_cart',
            [
                'label' => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_wishlist',
            [
                'label' => esc_html__('Wishlist', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ultimate-store-kit'),
                'label_off' => esc_html__('Hide', 'ultimate-store-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
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
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'title_tabs'
        );
        $this->start_controls_tab(
            'title_tabs_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_background_normal',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion-header',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion',
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'item_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_radius',
            [
                'label' => esc_html__('Header Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'border_shadow',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger span',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_tabs_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'title_h_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:hover span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_background_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion-header:hover',
            ]
        );
        $this->add_control(
            'item_border_hover_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_border_border!' => ''
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Open & Close Icon', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'icon_style_tabs'
        );
        $this->start_controls_tab(
            'icon_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after',
            ]
        );
        $this->add_responsive_control(
            'icon_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_font_size',
            [
                'label' => esc_html__('Font Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:after' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'icon_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'icon_h_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:hover:after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_h_background',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-accordion .usk-accordion-trigger:hover:after' => 'background: {{VALUE}}',
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
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-single-item',
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-single-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_space_between',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-single-item-box' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->register_global_controls_grid_image();
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
                    '{{WRAPPER}} .usk-product-accordion .usk-category a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'category_bg_color',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-category a',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_shadow',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-category a',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_category_bg_color',
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-category a:hover',
            ]
        );
        $this->add_control(
            'hover_category_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-category a:hover' => 'border-color: {{VALUE}};',
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
        $this->register_global_controls_price();
        $this->start_controls_section(
            'secion_style_excerpt',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-desc' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'desc_margin',
            [
                'label' => __('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'label' => __('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-desc',
            ]
        );
        $this->end_controls_section();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
        $this->start_controls_section(
            'style_action_btn',
            [
                'label' => esc_html__('Action Button', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'action_btn_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-shoping a',
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'action_btn_tabs'
        );
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_border',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart' => 'border-color: {{VALUE}}',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button:hover, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button:hover, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_border_hover',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-button:hover, {{WRAPPER}} .usk-product-accordion .usk-shoping .added_to_cart:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wishlist_icon_border',
                'label' => __('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist:hover .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'wishlist_icon_border!' => ''
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist.usk-active .icon::before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
                ],
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-quickview .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'quickview_icon_border',
                'label' => __('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-quickview',
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
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-quickview:hover .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-accordion .usk-shoping .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render_header()
    {
        ?>
        <div class="ultimate-store-kit">
            <div class="usk-product-accordion">
                <?php
    }

    public function render_footer()
    {
        ?>
            </div>
        </div>

        <?php
    }
    protected function render_add_to_cart($tooltip_position)
    {
        global $product;
        $settings = $this->get_settings_for_display();
        if ('yes' == $settings['show_cart']): ?>
            <?php if ($product) {
                $defaults = [
                    'quantity' => 1,
                    'class' => implode(
                        ' ',
                        array_filter(
                            [
                                'usk-button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            ]
                        )
                    ),
                    'attributes' => [
                        'data-product_id' => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label' => $product->add_to_cart_description(),
                        'rel' => 'nofollow',
                    ],
                ];
                $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
                if (isset($args['attributes']['aria-label'])) {
                    $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
                }
                echo wp_kses_post(apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon usk-icon-arrow-right-8"></i></a>',
                        esc_url($product->add_to_cart_url()),
                        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                        esc_html($product->add_to_cart_text())
                    ),
                    $product,
                    $args
                ));
            }
            ; ?>
        <?php endif;
    }
    public function print_price_output($output)
    {
        $tags = [
            'del' => ['aria-hidden' => []],
            'span' => ['class' => []],
            'bdi' => [],
            'ins' => [],
        ];

        if (isset($output)) {
            echo wp_kses($output, $tags);
        }
    }
    public function render_loop_item()
    {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();
        if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()):
                $wp_query->the_post();
                global $product;
                $product_id = $product->get_id();
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                $image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
                $categories = str_replace(',', '', wc_get_product_category_list($product->get_id()));

                ?>
                <div class="usk-accordion usk-item">
                    <div class="usk-accordion-header">
                        <div class="usk-accordion-trigger">
                            <span>
                                <?php echo esc_html($product->get_name()); ?>
                            </span>
                        </div>
                    </div>
                    <div class="usk-item-box">
                        <div class="usk-single-item usk-content">
                            <div class="usk-single-item-box usk-flex usk-flex-row@s usk-flex-column usk-flex-middle">
                                <div class="usk-image">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                        <img src="<?php echo esc_url($image); ?>" />
                                    </a>
                                </div>
                                <div class="usk-content-wrapper">
                                    <?php if ('yes' == $settings['show_category']):
                                        printf('<div class="usk-category">%1$s</div>', wp_kses_post($categories));
                                    endif; ?>
                                    <?php if ('yes' == $settings['show_price']): ?>
                                        <div class="usk-price">
                                            <?php $this->print_price_output($product->get_price_html()); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ('yes' == $settings['show_description']): ?>
                                        <div class="usk-desc">
                                            <p class="desc">
                                                <?php echo esc_html(wp_trim_words($product->get_short_description(), $settings['excerpt_limit'], '...')); ?>
                                            </p>
                                        </div>
                                        <?php
                                    endif; ?>
                                    <?php if ('yes' == $settings['show_rating']): ?>
                                        <div class="usk-rating">
                                            <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="usk-action-btn usk-shoping">
                                        <?php $this->render_add_to_cart('top'); ?>
                                        <?php $this->register_global_template_add_to_wishlist('top', $settings); ?>
                                        <?php $this->register_global_template_quick_view($product_id, 'top', $settings); ?>
                                    </div>
                                </div>
                                <div class="usk-badge-label-wrapper">
                                    <div class="usk-badge-label-content usk-flex">
                                        <?php $this->register_global_template_badge_label($settings); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata();
        } else {
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        }
    }
    protected function render()
    {
        $this->render_header();
        $this->render_loop_item();
        $this->render_footer();
    }
    public function query_product()
    {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
}
