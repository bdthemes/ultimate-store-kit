<?php

namespace UltimateStoreKit\Modules\UpSells\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Up_Sells extends Module_Base
{

    public function get_name()
    {
        return 'usk-up-sells';
    }

    public function get_title()
    {
        return BDTUSK . esc_html__('Upsells', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-up-sells';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['woocommerce', 'shop', 'store', 'upsell', 'product'];
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-up-sells'];
        }
    }

    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }
    protected function register_controls() {
        $this->register_controls_upsell_content();
        $this->register_style_controls_heading();
        $this->register_controls_items();
        $this->register_controls_title();
        $this->register_controls_price();
        $this->register_controls_action_btn();
    }
    protected function register_controls_upsell_content()
    {

        $this->start_controls_section(
            'section_upsell_content',
            [
                'label' => __('Upsells', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'prefix_class' => 'usk-products-columns%s-',
                'default' => 4,
                'min' => 1,
                'max' => 12,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => __('Order By', 'ultimate-store-kit'),
                'type'         => Controls_Manager::SELECT,
                'default'     => 'date',
                'options'     => [
                    'date'     => __('Date', 'ultimate-store-kit'),
                    'title' => __('Title', 'ultimate-store-kit'),
                    'price' => __('Price', 'ultimate-store-kit'),
                    'popularity'     => __('Popularity', 'ultimate-store-kit'),
                    'rating'         => __('Rating', 'ultimate-store-kit'),
                    'rand'             => __('Random', 'ultimate-store-kit'),
                    'menu_order'     => __('Menu Order', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => __('Order', 'ultimate-store-kit'),
                'type'         => Controls_Manager::SELECT,
                'default'     => 'desc',
                'options'     => [
                    'asc'     => __('ASC', 'ultimate-store-kit'),
                    'desc'     => __('DESC', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_controls_heading()
    {
        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => __('Heading', 'ultimate-store-kit'),
                'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_heading',
            [
                'label'         => __('Heading', 'ultimate-store-kit'),
                'type'             => Controls_Manager::SWITCHER,
                'label_off'     => __('Hide', 'ultimate-store-kit'),
                'label_on'         => __('Show', 'ultimate-store-kit'),
                'default'         => 'yes',
                'return_value'     => 'yes',
                'prefix_class'     => 'usk-up-sells-show-heading-',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'         => __('Color', 'ultimate-store-kit'),
                'type'             => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .usk-up-sells .products > h2' => 'color: {{VALUE}}',
                ],
                'condition'     => [
                    'show_heading!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'             => 'heading_typography',
                'selector'         => '{{WRAPPER}} .usk-up-sells .products > h2',
                'condition'     => [
                    'show_heading!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_text_align',
            [
                'label' => __('Text Align', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells .products > h2' => 'text-align: {{VALUE}}',
                ],
                'condition' => [
                    'show_heading!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_spacing',
            [
                'label' => __('Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells .products > h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'show_heading!' => '',
                ],
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_grid_image()
    {
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
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-image',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item .usk-item-box .usk-image',
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
    protected function register_controls_content()
    {
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
    protected function register_controls_title()
    {
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
                    '.woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-category__title, .woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-product__title, .woocommerce {{WRAPPER}} ul.products li.product h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-category__title:hover, .woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-product__title:hover, .woocommerce {{WRAPPER}} ul.products li.product h3:hover' => 'color: {{VALUE}};',
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
                    '.woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-category__title, .woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-product__title, .woocommerce {{WRAPPER}} ul.products li.product h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-category__title, .woocommerce {{WRAPPER}} ul.products li.product .woocommerce-loop-product__title, .woocommerce {{WRAPPER}} ul.products li.product h3',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_price()
    {
        $this->start_controls_section(
            'section_style_price',
            [
                'label'     => esc_html__('Price', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('Sale Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells ul.products li.product .price'                                        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-up-sells ul.products li.product .price ins span'                               => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-up-sells ul.products li.product .price ins .woocommerce-Price-amount.amount'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-up-sells ul.products li.product .price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'regular_price_color',
            [
                'label'     => esc_html__('Regular Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.woocommerce {{WRAPPER}} .usk-up-sells ul.products li.product .price.amount' => 'color: {{VALUE}};',
                    '.woocommerce {{WRAPPER}} .usk-up-sells ul.products li.product .price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '.woocommerce {{WRAPPER}} .usk-up-sells ul.products li.product .price del' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-up-sells ul.products li.product .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '
                {{WRAPPER}} .usk-up-sells ul.products li.product .price',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_action_btn()
    {
        $this->start_controls_section(
            'style_action_btn',
            [
                'label' => esc_html__('Action Button', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'cart_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_bg',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button' => 'background: {{VALUE}}',
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
                    '{{WRAPPER}} .usk-up-sells ul.products .button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'cart_icon_bg_hover',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'cart_btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-up-sells ul.products .button',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'cart_btn_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cart_btn_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cart_btn_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-up-sells ul.products .button'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_button_typography',
                'label'     => __('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-up-sells ul.products .button',
            ]
        );

        $this->end_controls_section();
    }
    protected function register_controls_items()
    {
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
                'selector'  => '{{WRAPPER}} .usk-up-sells ul.products li.product',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'item_border',
                'label'       => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector'    => '{{WRAPPER}} .usk-up-sells ul.products li.product',
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
                    '{{WRAPPER}} .usk-up-sells ul.products li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .usk-up-sells ul.products li.product',
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-up-sells ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_alignment',
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
                'toggle'        => false,
                'selectors'     => [
                    '{{WRAPPER}} .usk-up-sells ul.products li.product' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }
    protected function render()
    {

        $this->usk_set_single_post_preview_data();
        $settings     = $this->get_settings_for_display();
        $limit         = '-1';
        $columns     = isset($settings['columns']) ? $settings['columns'] : 4;
        $orderby     = isset($settings['orderby']) ? $settings['orderby'] : 'date';
        $order         = isset($settings['order']) ? $settings['order'] : 'desc';
?>
        <div class="usk-up-sells">
            <?php woocommerce_upsell_display($limit, $columns, $orderby, $order); ?>
        </div>
<?php
    }
}
