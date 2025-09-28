<?php

namespace UltimateStoreKit\Modules\ShowcaseSlider\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Showcase_Slider extends Module_Base
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
        return 'usk-showcase-slider';
    }

    public function get_title()
    {
        return esc_html__('Showcase Slider', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-showcase-slider';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['product', 'product slider', 'showcase slider', 'wc', 'carousel'];
    }

    public function get_script_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'micromodal', 'usk-site'];
        } else {
            return ['swiper', 'micromodal', 'usk-showcase-slider'];
        }
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-showcase-slider'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/3VkvEpVaNAM';
    // }
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
            'items_gap',
            [
                'label' => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 120,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'tablet_default' => [
                    'size' => 80,
                ],
                'mobile_default' => [
                    'size' => 0,
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
            'items_height',
            [
                'label' => esc_html__('Image Height', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-image-wrap' => 'height: {{SIZE}}{{UNIT}}',
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
                'default' => 'yes',
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
                'label_on' => esc_html__('Yes', 'ultimate-store-kit'),
                'label_off' => esc_html__('No', 'ultimate-store-kit'),
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
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_compare',
            [
                'label' => esc_html__('Compare', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
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
                'label' => __('Coverflow Effect', 'ultimate-store-kit'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
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
                'render_type' => 'template',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'hr_005',
            [
                'type' => Controls_Manager::DIVIDER,
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
                    'size' => 800,
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
                    '{{WRAPPER}} .swiper-carousel' => 'padding: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
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
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-item-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-item',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => [
                    'px',
                    'em',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_box_padding',
            [
                'label' => esc_html__('Content Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    'em',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-item-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-item',

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
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-item-box:hover',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_hover_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-item:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->register_global_controls_title();
        $this->register_global_controls_category();
        $this->register_global_controls_price();

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
                    '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background_color',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_spacing',
            [
                'label' => esc_html__('Right Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'btn_size_toggle',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
            ]
        );
        $this->start_popover();
        $this->add_responsive_control(
            'btn_height',
            [
                'label' => esc_html__('Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_size_toggle' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_width',
            [
                'label' => esc_html__('Width', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_size_toggle' => 'yes',
                ],
            ]
        );
        $this->end_popover();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button, {{WRAPPER}} .usk-showcase-slider .added_to_cart',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-button:hover, {{WRAPPER}} .usk-showcase-slider .added_to_cart:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hover_bg',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button:hover, {{WRAPPER}} .usk-showcase-slider .added_to_cart:hover',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-button:hover, {{WRAPPER}} .usk-showcase-slider .added_to_cart:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_shadow',
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-button:hover, {{WRAPPER}} .usk-showcase-slider .added_to_cart:hover',
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
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'action_btn_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-showcase-slider .usk-action-btn',
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-action-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-action-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'action_btn_gap',
            [
                'label' => esc_html__('Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'action_btn_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-action-btn' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    'show_wishlist' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'wishlist_normal_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                ],
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                ],
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        // Compare
        $this->start_controls_tab(
            'compare_tab',
            [
                'label' => esc_html__('Compare', 'ultimate-store-kit'),
                'condition' => [
                    'show_compare' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'compare_normal_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare' => 'background: {{VALUE}}',
                ],
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
            'compare_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_hover_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare:hover' => 'background: {{VALUE}}',
                ],
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
            'compare_active_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_active_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-compare.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'quickview_tab',
            [
                'label' => esc_html__('Quickview', 'ultimate-store-kit'),
                'condition' => [
                    'show_quick_view' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'quickview_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-quickview' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                ],
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
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-quickview:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-showcase-slider .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->register_global_controls_navigation_style();
    }

    public function render_image()
    {
        $tooltip_position = 'top';
        global $product;
        $settings = $this->get_settings_for_display();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
        ?>
        <div class="usk-image-wrap">
            <img class="usk-image" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            <div class="usk-shoping">
                <?php
                $this->register_global_template_add_to_wishlist($tooltip_position, $settings);
                $this->register_global_template_add_to_compare($tooltip_position, $settings);
                $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings);
                ?>
            </div>
            <?php $this->render_add_to_cart(); ?>
        </div>
        <?php
    }
    public function render_add_to_cart()
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
    public function render_slider_header()
    {
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
                            "autoplay" => ("yes" == $settings["autoplay"]) ? ["delay" => $settings["autoplay_speed"]] : false,
                            "loop" => ($settings["loop"] == "yes") ? true : false,
                            "speed" => $settings["speed"]["size"],
                            "pauseOnHover" => ("yes" == $settings["pauseonhover"]) ? true : false,
                            "slidesPerView" => 1,
                            "slidesPerGroup" => isset($settings["slides_to_scroll_mobile"]) ? (int) $settings["slides_to_scroll_mobile"] : 1,
                            "spaceBetween" => !empty($settings["items_gap_mobile"]["size"]) ? (int) $settings["items_gap_mobile"]["size"] : 0,
                            "centeredSlides" => true,
                            "grabCursor" => ($settings["grab_cursor"] === "yes") ? true : false,
                            "effect" => 'coverflow',
                            "observer" => ($settings["observer"]) ? true : false,
                            "observeParents" => ($settings["observer"]) ? true : false,
                            "breakpoints" => [
                                (int) $viewport_md => [
                                    "slidesPerView" => 1.7,
                                    "spaceBetween" => !empty($settings["items_gap_tablet"]["size"]) ? (int) $settings["items_gap_tablet"]["size"] : 0,
                                    "slidesPerGroup" => isset($settings["slides_to_scroll_tablet"]) ? (int) $settings["slides_to_scroll_tablet"] : 1,
                                ],
                                (int) $viewport_lg => [
                                    "slidesPerView" => 2,
                                    "spaceBetween" => !empty($settings["items_gap"]["size"]) ? (int) $settings["items_gap"]["size"] : 0,
                                    "slidesPerGroup" => isset($settings["slides_to_scroll"]) ? (int) $settings["slides_to_scroll"] : 1,
                                ],
                            ],
                            "navigation" => [
                                "nextEl" => "#" . $id . " .usk-navigation-next",
                                "prevEl" => "#" . $id . " .usk-navigation-prev",
                            ],
                            "pagination" => [
                                "el" => "#" . $id . " .swiper-pagination",
                                "type" => $pagination_type,
                                "clickable" => "true",
                                'dynamicBullets' => ("yes" == $settings["dynamic_bullets"]) ? true : false,
                            ],
                            "scrollbar" => [
                                "el" => "#" . $id . " .swiper-scrollbar",
                                "hide" => "true",
                            ],
                            'coverflowEffect' => [
                                'rotate' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_rotate"]["size"] : 0,
                                'stretch' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_stretch"]["size"] : 0,
                                'depth' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_depth"]["size"] : 100,
                                'modifier' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_modifier"]["size"] : 1,
                                'slideShadows' => false,
                            ],

                        ])),
                    ],
                ],
            ]
        );

        $this->add_render_attribute('swiper', 'class', 'usk-showcase-slider-wrapper swiper-carousel swiper');
        ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('slider'); ?>>
                <div <?php $this->print_render_attribute_string('swiper'); ?>>
                    <div class="swiper-wrapper">
                        <?php
    }
    public function render_slider_footer()
    {
        $settings = $this->get_settings_for_display();
        ?>
                    </div>
                    <?php if ('yes' === $settings['show_scrollbar']): ?>
                        <div class="swiper-scrollbar"></div>
                    <?php endif; ?>
                </div>

                <?php if ('both' == $settings['navigation']): ?>
                    <?php $this->register_global_template_both_navigation(); ?>
                    <?php if ('center' === $settings['both_position']): ?>
                        <div class="usk-position-z-index usk-position-bottom">
                            <div class="usk-dots-container">
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php elseif ('arrows-fraction' == $settings['navigation']): ?>
                    <?php $this->register_global_template_arrows_fraction() ?>
                    <?php if ('center' === $settings['arrows_fraction_position']): ?>
                        <div class="usk-dots-container">
                            <div class="swiper-pagination"></div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php $this->register_global_template_pagination(); ?>
                    <?php $this->register_global_template_navigation(); ?>

                <?php endif; ?>
            </div>
            <?php
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
        $id = 'usk-wc-product-' . $this->get_id();
        $modal_id = wp_unique_id('modal-id-');

        // $wp_query = $this->render_query();
        $this->query_product();
        $wp_query = $this->get_query();
        if ($wp_query->have_posts()) { ?>
                <?php while ($wp_query->have_posts()):
                    $wp_query->the_post();
                    global $product;
                    $rating_count = $product->get_rating_count();
                    $average = $product->get_average_rating();
                    $have_rating = ('yes' === $settings['show_rating']) ? 'usk-have-rating' : '';

                    ?>
                    <div class="swiper-slide usk-item <?php echo esc_attr($have_rating); ?>">
                        <?php $this->render_image(); ?>
                        <div class="usk-badge-label-wrapper">
                            <div class="usk-badge-label-content usk-flex usk-flex-column">
                                <?php $this->register_global_template_badge_label($settings); ?>
                            </div>
                        </div>
                        <div class="usk-item-box">
                            <div class="usk-content">
                                <?php if ('yes' == $settings['show_category']): ?>
                                    <?php printf('<div class="usk-category">%1$s</div>', wp_kses_post(wc_get_product_category_list($product->get_id(), ' '))); ?>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_title']):
                                    printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title()));
                                endif; ?>

                            </div>

                            <div class="usk-price-button-wrap">
                                <?php if (('yes' == $settings['show_price'])): ?>
                                    <div class="usk-price">
                                        <?php $this->print_price_output($product->get_price_html()); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (('yes' == $settings['show_rating'])): ?>
                                    <div class="usk-rating">
                                        <?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                <?php endwhile;
                wp_reset_postdata();
        } else {
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        }
    }

    public function render()
    {
        $this->render_slider_header();
        $this->render_loop_item();
        $this->render_slider_footer();
    }
    public function query_product()
    {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
}
