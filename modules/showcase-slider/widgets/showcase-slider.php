<?php

namespace UltimateStoreKit\Modules\ShowcaseSlider\Widgets;


use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Showcase_Slider extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-showcase-slider';
    }

    public function get_title() {
        return esc_html__('Showcase Slider', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-showcase-slider';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'product-grid', 'table', 'wc'];
    }

    public function get_script_depends() {
        return ['micromodal'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-showcase-slider'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/3VkvEpVaNAM';
    // }
    public function get_query() {
        return $this->_query;
    }
    protected function register_controls() {
        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );
        $this->add_responsive_control(
            'items_height',
            [
                'label' => esc_html__('Item Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                    ],
                ],
                'tablet_default' => [
                    'size' => 280,
                ],
                'mobile_default' => [
                    'size' => 200,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-image-wrap' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 150,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'tablet_default' => [
                    'size' => 100,
                ],
                'mobile_default' => [
                    'size' => 0,
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
                'name'    => 'image',
                'label'   => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'full',
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
        $this->end_controls_section();
        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Additional', 'ultimate-store-kit'),
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
            'show_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        if ($this->get_name() !==  'usk-product-image-accordion') :
            $this->add_control(
                'show_excerpt',
                [
                    'label' => esc_html__('List Description', 'ultimate-store-kit'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'excerpt_limit',
                [
                    'label'     => esc_html__('Description Limit', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 25,
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
            ]
        );
        $this->add_control(
            'hide_customer_review',
            [
                'label' => esc_html__('Hide Review Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'product-grid'),
                'label_off' => esc_html__('No', 'product-grid'),
                // 'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_rating' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-rating   .woocommerce-review-link' => 'display:none',
                ],
            ]
        );
        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
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
        $this->register_global_controls_carousel_navigation();
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => __('Carousel Settings', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'coverflow_toggle',
            [
                'label'        => __('Coverflow Effect', 'ultimate-store-kit'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'coverflow_rotate',
            [
                'label'   => esc_html__('Rotate', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    'px' => [
                        'min'  => -360,
                        'max'  => 360,
                        'step' => 5,
                    ],
                ],
                'render_type'  => 'template',
            ]
        );

        $this->add_control(
            'coverflow_stretch',
            [
                'label'   => __('Stretch', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'step' => 10,
                        'max'  => 100,
                    ],
                ],
                'render_type'  => 'template',
            ]
        );

        $this->add_control(
            'coverflow_modifier',
            [
                'label'   => __('Modifier', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min'  => 1,
                        'step' => 1,
                        'max'  => 10,
                    ],
                ],
                'render_type'  => 'template',
            ]
        );

        $this->add_control(
            'coverflow_depth',
            [
                'label'   => __('Depth', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                ],
                'range' => [
                    'px' => [
                        'min'  => 0,
                        'step' => 10,
                        'max'  => 1000,
                    ],
                ],
                'render_type'  => 'template',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'hr_005',
            [
                'type'      => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __('Autoplay', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => esc_html__('Autoplay Speed', 'ultimate-store-kit'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pauseonhover',
            [
                'label' => esc_html__('Pause on Hover', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'type'           => Controls_Manager::SELECT,
                'label'          => esc_html__('Slides to Scroll', 'ultimate-store-kit'),
                'default'        => 1,
                'tablet_default' => 1,
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
            'centered_slides',
            [
                'label'   => __('Center Slide', 'ultimate-store-kit'),
                'description'   => __('Use even items from Layout > Columns settings for better preview.', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'grab_cursor',
            [
                'label'   => __('Grab Cursor', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => __('Loop', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );


        $this->add_control(
            'speed',
            [
                'label'   => __('Animation Speed (ms)', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 800,
                ],
                'range' => [
                    'px' => [
                        'min'  => 100,
                        'max'  => 5000,
                        'step' => 50,
                    ],
                ],
            ]
        );

        $this->add_control(
            'observer',
            [
                'label'       => __('Observer', 'ultimate-store-kit'),
                'description' => __('When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
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
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-item-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'content_border',
                'label'          => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item',
            ]
        );

        $this->add_responsive_control(
            'content_radius',
            [
                'label'      => esc_html__('Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => [
                    'px', 'em', '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item',
                
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
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-item-box:hover',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-item-box:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->register_global_controls_title();
        $this->register_global_controls_category();
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
            'regular_price_color',
            [
                'label'     => esc_html__('Regular Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-content .usk-price del' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('Sale Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price'                                        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price ins span'                               => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price .woocommerce-Price-amount.amount'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '
                {{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-price',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Button', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_background_color',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a',
            ]
        );
        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a',
                'exclude' => ['line_height', 'letter_spacing'],
                'separator' => 'before',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_hover_bg',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-showcase-slider-wrapper .usk-item .usk-button a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->register_global_controls_badge();
        $this->register_global_controls_rating();
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
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping a',
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping a'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping a'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'font_family',
            [
                'label'                 => esc_html__('Tooltip Font', 'font family'),
                'type'                  => Controls_Manager::FONT,
                'default'               => "'Open Sans', sans-serif",
                'selectors'             => [
                    '{{WRAPPER}} .usk-item .usk-shoping a'    => 'font-family: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'action_btn_separator',
            [
                'label'     => esc_html__('Button Separator', 'ultimate-store-kit'),
                'show_label' => false,
                'label_block' => false,
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_wishlist_hover',
            [
                'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'wishlist_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist:hover .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_bg',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_wishlist_active',
            [
                'label'     => esc_html__('Active', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'wishlist_active_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist.usk-active .icon::before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_bg',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-quickview .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_quickview_hover',
            [
                'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'quickview_color_hover',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-quickview:hover .icon:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg_hover',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        if (($this->get_name() !== 'usk-shiny-grid') && ($this->get_name() !== 'usk-shiny-carousel')) {
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
                    'label'     => esc_html__('Color', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-cart' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_icon_bg',
                [
                    'label'     => esc_html__('Background', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-cart' => 'background: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'heading_cart_hover',
                [
                    'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'cart_color_hover',
                [
                    'label'     => esc_html__('Color', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-cart:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'cart_icon_bg_hover',
                [
                    'label'     => esc_html__('Background', 'ultimate-store-kit'),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .usk-showcase-slider .usk-item .usk-shoping .usk-cart:hover' => 'background: {{VALUE}}',
                    ],
                ]
            );
        }
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label'      => __('Navigation', 'ultimate-store-kit'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '!=',
                            'value'    => 'none',
                        ],
                        [
                            'name'  => 'show_scrollbar',
                            'value' => 'yes',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'arrows_heading',
            [
                'label'     => __('Arrows', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation_arrows_style');

        $this->start_controls_tab(
            'tabs_nav_arrows_normal',
            [
                'label'     => __('Normal', 'ultimate-store-kit'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev i, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label'     => __('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'nav_arrows_border',
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next',
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev i,
					{{WRAPPER}} .usk-showcase-slider .usk-navigation-next i' => 'font-size: {{SIZE || 24}}{{UNIT}};',
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
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev' => 'margin-right: {{SIZE}}px;',
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'margin-left: {{SIZE}}px;',
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
                'label'     => __('Hover', 'ultimate-store-kit'),
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev:hover i, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next:hover i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_background',
            [
                'label'     => __('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev:hover, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next:hover' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['dots', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'nav_arrows_hover_border_color',
            [
                'label'     => __('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev:hover, {{WRAPPER}} .usk-showcase-slider .usk-navigation-next:hover'  => 'border-color: {{VALUE}};',
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
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_heading',
            [
                'label'     => __('Dots', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'hr_11',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_control(
            'active_dot_color',
            [
                'label'     => __('Active Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
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
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
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
                'label'     => __('Fraction', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_12',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'fraction_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-fraction' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'active_fraction_color',
            [
                'label'     => __('Active Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-current' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'fraction_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-fraction',
                'condition' => [
                    'navigation' => 'arrows-fraction',
                ],
            ]
        );

        $this->add_control(
            'hr_3',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_heading',
            [
                'label'     => __('Progresbar', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_13',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progresbar_color',
            [
                'label'     => __('Bar Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'progres_color',
            [
                'label'     => __('Progress Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_control(
            'hr_4',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_heading',
            [
                'label'     => __('Scrollbar', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'hr_14',
            [
                'type'      => Controls_Manager::DIVIDER,
                'condition' => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_color',
            [
                'label'     => __('Bar Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-scrollbar' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'scrollbar_drag_color',
            [
                'label'     => __('Drag Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-scrollbar .swiper-scrollbar-drag' => 'background: {{VALUE}}',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'scrollbar_height',
            [
                'label' => __('Height', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-container-horizontal > .swiper-scrollbar, {{WRAPPER}} .usk-showcase-slider .swiper-horizontal > .swiper-scrollbar' => 'height: {{SIZE}}px;',
                ],
                'condition'   => [
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
                'type'  => Controls_Manager::HEADING,
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
                'label'   => __('Arrows Horizontal Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 60,
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
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'     => 'arrows_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-arrows-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_ncy_position',
            [
                'label'   => __('Arrows Vertical Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-arrows-ncy: {{SIZE}}px;'
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'     => 'arrows_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_acx_position',
            [
                'label'   => __('Arrows Horizontal Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 60,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows',
                        ],
                        [
                            'name'  => 'arrows_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nnx_position',
            [
                'label'   => __('Dots Horizontal Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name'     => 'dots_position',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-dots-nnx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_nny_position',
            [
                'label'   => __('Dots Vertical Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'dots',
                        ],
                        [
                            'name'     => 'dots_position',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-dots-nny: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncx_position',
            [
                'label'   => __('Arrows & Dots Horizontal Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'     => 'both_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-both-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_ncy_position',
            [
                'label'   => __('Arrows & Dots Vertical Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'     => 'both_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-both-ncy: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cx_position',
            [
                'label'   => __('Arrows Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'  => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'both_cy_position',
            [
                'label'   => __('Dots Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-dots-container' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'both',
                        ],
                        [
                            'name'  => 'both_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncx_position',
            [
                'label'   => __('Arrows & Fraction Horizontal Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'     => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-arrows-fraction-ncx: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_ncy_position',
            [
                'label'   => __('Arrows & Fraction Vertical Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'tablet_default' => [
                    'size' => 40,
                ],
                'mobile_default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'conditions'   => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'     => 'arrows_fraction_position',
                            'operator' => '!=',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--' . $this->get_name() . '-arrows-fraction-ncy: {{SIZE}}px;'
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cx_position',
            [
                'label'   => __('Arrows Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-prev' => 'left: {{SIZE}}px;',
                    '{{WRAPPER}} .usk-showcase-slider .usk-navigation-next' => 'right: {{SIZE}}px;',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'  => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_fraction_cy_position',
            [
                'label'   => __('Fraction Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name'  => 'navigation',
                            'value' => 'arrows-fraction',
                        ],
                        [
                            'name'  => 'arrows_fraction_position',
                            'value' => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'progress_y_position',
            [
                'label'   => __('Progress Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-showcase-slider .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
                ],
                'condition' => [
                    'navigation' => 'progressbar',
                ],
            ]
        );

        $this->add_responsive_control(
            'scrollbar_vertical_offset',
            [
                'label'   => __('Scrollbar Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .swiper-container-horizontal > .swiper-scrollbar, {{WRAPPER}} .usk-showcase-slider .swiper-horizontal > .swiper-scrollbar' => 'bottom: {{SIZE}}px;',
                ],
                'condition'   => [
                    'show_scrollbar' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render_image() {
        $tooltip_position = 'top';
        global $product;
        $settings = $this->get_settings_for_display();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
?>
        <div class="usk-image-wrap">
            <img class="usk-image" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            <div class="usk-shoping">
                <?php
                $this->register_global_template_add_to_wishlist($tooltip_position);
                $this->register_global_template_quick_view($product->get_id(), $tooltip_position);
                $this->register_global_template_add_to_cart($tooltip_position);
                ?>
            </div>
        </div>
        <?php
    }
    public function render_add_to_cart() {
        global $product;
        $settings = $this->get_settings_for_display();
        if ('yes' == $settings['show_cart']) : ?>
            <?php if ($product) {
                $defaults = [
                    'quantity'   => 1,
                    'class'      => implode(
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
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ],
                ];
                $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
                if (isset($args['attributes']['aria-label'])) {
                    $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
                }
                echo apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon eicon-arrow-right"></i></a>',
                        esc_url($product->add_to_cart_url()),
                        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                        esc_html($product->add_to_cart_text())
                    ),
                    $product,
                    $args
                );
            }; ?>
        <?php endif;
    }
    function render_slider_header() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('slider', 'class', ['usk-showcase-slider']);
        $id = 'ultimate-store-kit-' . $this->get_id();
        $elementor_vp_lg = get_option('elementor_viewport_lg');
        $elementor_vp_md = get_option('elementor_viewport_md');
        $viewport_lg = !empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1023;
        $viewport_md = !empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;
        $this->add_render_attribute('slider', 'id', $id);
        $this->add_render_attribute('slider', 'class', ['usk-carousel', 'usk-carousel-layout', 'elementor-swiper']);
        if ('arrows' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'usk-arrows-align-' . $settings['arrows_position']);
        } elseif ('dots' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'usk-dots-align-' . $settings['dots_position']);
        } elseif ('both' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'usk-arrows-dots-align-' . $settings['both_position']);
        } elseif ('arrows-fraction' == $settings['navigation']) {
            $this->add_render_attribute('slider', 'class', 'usk-arrows-dots-align-' . $settings['arrows_fraction_position']);
        }

        if ('arrows-fraction' == $settings['navigation']) {
            $pagination_type = 'fraction';
        } elseif ('both' == $settings['navigation'] or 'dots' == $settings['navigation']) {
            $pagination_type = 'bullets';
        } elseif ('progressbar' == $settings['navigation']) {
            $pagination_type = 'progressbar';
        } else {
            $pagination_type = '';
        }

        $this->add_render_attribute(
            [
                'slider' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            "autoplay"       => ("yes" == $settings["autoplay"]) ? ["delay" => $settings["autoplay_speed"]] : false,
                            "loop"           => ($settings["loop"] == "yes") ? true : false,
                            "speed"          => $settings["speed"]["size"],
                            "pauseOnHover"   => ("yes" == $settings["pauseonhover"]) ? true : false,
                            "slidesPerView"  => 1,
                            "slidesPerGroup" => isset($settings["slides_to_scroll_mobile"]) ? (int)$settings["slides_to_scroll_mobile"] : 1,
							"spaceBetween"   => !empty($settings["items_gap_mobile"]["size"]) ? (int)$settings["items_gap_mobile"]["size"] : 20,
                            "centeredSlides" => true,
                            "grabCursor"     => ($settings["grab_cursor"] === "yes") ? true : false,
                            "effect"         => 'coverflow',
                            "observer"       => ($settings["observer"]) ? true : false,
                            "observeParents"            => ($settings["observer"]) ? true : false,
                            "breakpoints"               => [
                                (int) $viewport_md         => [
                                    "slidesPerView"  => 1.7,
                                    "spaceBetween"   => !empty($settings["items_gap_tablet"]["size"]) ? (int)$settings["items_gap_tablet"]["size"] : 20,
									"slidesPerGroup" => isset($settings["slides_to_scroll_tablet"]) ? (int)$settings["slides_to_scroll_tablet"] : 1,
                                ],
                                (int) $viewport_lg         => [
                                    "slidesPerView"  => 2,
                                    "spaceBetween"   => !empty($settings["items_gap"]["size"]) ? (int)$settings["items_gap"]["size"] : 20,
									"slidesPerGroup" => isset($settings["slides_to_scroll"]) ? (int)$settings["slides_to_scroll"] : 1,
                                ]
                            ],
                            "navigation"         => [
                                "nextEl" => "#" . $id . " .usk-navigation-next",
                                "prevEl" => "#" . $id . " .usk-navigation-prev",
                            ],
                            "pagination"         => [
                                "el"             => "#" . $id . " .swiper-pagination",
                                "type"           => $pagination_type,
                                "clickable"      => "true",
                                'dynamicBullets' => ("yes" == $settings["dynamic_bullets"]) ? true : false,
                            ],
                            "scrollbar" => [
                                "el"   => "#" . $id . " .swiper-scrollbar",
                                "hide" => "true",
                            ],
                            'coverflowEffect' => [
                                'rotate'       => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_rotate"]["size"]   : 0,
                                'stretch'      => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_stretch"]["size"]  : 0,
                                'depth'        => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_depth"]["size"]    : 100,
                                'modifier'     => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_modifier"]["size"] : 1,
                                'slideShadows' => false,
                            ],

                        ]))
                    ]
                ]
            ]
        );

        $swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
        $this->add_render_attribute('swiper', 'class', 'usk-showcase-slider-wrapper swiper-carousel ' . $swiper_class);
        ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('slider'); ?>>
                <div <?php echo $this->get_render_attribute_string('swiper'); ?>>
                    <div class="swiper-wrapper">
                    <?php
                }
                public function render_slider_footer() {
                    $settings = $this->get_settings_for_display();
                    ?>
                    </div>
                    <?php if ('yes' === $settings['show_scrollbar']) : ?>
                        <div class="swiper-scrollbar"></div>
                    <?php endif; ?>
                </div>

                <?php if ('both' == $settings['navigation']) : ?>
                    <?php $this->register_global_template_both_navigation(); ?>
                    <?php if ('center' === $settings['both_position']) : ?>
                        <div class="usk-position-z-index usk-position-bottom">
                            <div class="usk-dots-container">
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php elseif ('arrows-fraction' == $settings['navigation']) : ?>
                    <?php $this->register_global_template_arrows_fraction() ?>
                    <?php if ('center' === $settings['arrows_fraction_position']) : ?>
                        <div class="usk-dots-container">
                            <div class="swiper-pagination"></div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php $this->register_global_template_pagination(); ?>
                    <?php $this->register_global_template_navigation(); ?>

                <?php endif; ?>
            </div>
            <?php
                }
                public function print_price_output($output) {
                    $tags = [
                        'del' => ['aria-hidden' => []],
                        'span'  => ['class' => []],
                        'bdi' => [],
                        'ins' => [],
                    ];

                    if (isset($output)) {
                        echo wp_kses($output, $tags);
                    }
                }
                public function render_loop_item() {
                    $settings = $this->get_settings_for_display();
                    $id = 'usk-wc-product-' . $this->get_id();
                    $modal_id = wp_unique_id('modal-id-');

                    // $wp_query = $this->render_query();
                    $this->query_product();
                    $wp_query = $this->get_query();
                    if ($wp_query->have_posts()) { ?>
                <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                            global $product;
                            $rating_count = $product->get_rating_count();
                            $average = $product->get_average_rating();
                            $have_rating = ('yes' === $settings['show_rating']) ? 'usk-have-rating' : '';

                ?>
                    <div class="swiper-slide usk-item <?php esc_attr_e($have_rating, 'ultimate-store-kit'); ?>">
                        <?php $this->render_image(); ?>
                        <div class="usk-badge-label-wrapper">
                            <div class="usk-badge-label-content">
                                <?php $this->register_global_template_badge_label(); ?>
                            </div>
                        </div>
                        <div class="usk-item-box">
                            <div class="usk-content">
                                <?php if ('yes' == $settings['show_category']) : ?>
                                    <?php printf('<div class="usk-category">%1$s</div>', wc_get_product_category_list($product->get_id(), ' | ')); ?>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_title']) :
                                    printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', $settings['title_tags'], $product->get_permalink(), $product->get_title());
                                endif; ?>
                            </div>
                            <div class="usk-price-button-wrap">
                                <?php if ('yes' == $settings['show_button']) :
                                    printf('<div class="usk-button"><a href="%s">details</a></div>', get_permalink());
                                endif; ?>
                                <?php if (('yes' == $settings['show_price'])) : ?>
                                    <div class="usk-price">
                                        <?php
                                        $this->print_price_output($product->get_price_html());
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (('yes' == $settings['show_rating'])) : ?>
                                    <div class="usk-rating">
                                        <?php echo $this->register_global_template_wc_rating($average, $rating_count); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
    <?php endwhile;
                        wp_reset_postdata();
                    } else {
                        echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                    }
                }

                public function render() {
                    $this->render_slider_header();
                    $this->render_loop_item();
                    $this->render_slider_footer();
                }
                public function query_product() {
                    $default = $this->getGroupControlQueryArgs();
                    $this->_query = new WP_Query($default);
                }
            }
