<?php

namespace UltimateStoreKit\Includes\Settings;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;
use Elementor\Core\Kits\Documents\Kit;
// use Elementor\Core\Experiments\Manager as Experiments_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Settings_Modal extends Tab_Base {

    // public function __construct() {
    //     // parent::__construct();
    //     add_action( 'wp_footer', [$this, 'modal_wrapper']);

    // }

    public function get_id() {
        return 'ultimate-store-kit-modal';
    }
    public function get_title() {
        return __('Modal Settings', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-icon-ultimate-store-kit';
    }

    public function get_help_url() {
        return '';
    }

    // public function get_group() {
    //     return 'theme-style';
    // }
    protected function register_tab_controls() {
        $this->start_controls_section(
            'ultimate_store_kit_modal_settings',
            [
                'label' => esc_html__('Modal', 'ultimate-store-kit'),
                'tab'   => 'ultimate-store-kit-modal',
            ]
        );
        $this->add_control(
            'modal_layout',
            [
                'label'     => esc_html__('Layout', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // $this->add_responsive_control(
        //         'modal_width',
        //         [
        //             'label'         => esc_html__( 'Width', 'ultimate-store-kit' ),
        //             'type'          => Controls_Manager::SLIDER,
        //         ]
        // );
        $this->add_responsive_control(
            'modal_width',
            [
                'label'         => esc_html__('Width', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'description' => esc_html__('You must need to update and preview changes for seeing updated result', 'ultimate-store-kit'),
                'size_units'    => ['px', '%', 'vh'],
                'range'         => [
                    'px'        => [
                        'min'   => 300,
                        'max'   => 1200,
                        'step'  => 5,
                    ]
                ]
            ]
        );
        $this->add_responsive_control(
            'modal_height',
            [
                'label'         => esc_html__('Height', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'description' => esc_html__('You must need to update and preview changes for seeing updated result', 'ultimate-store-kit'),
                'size_units'    => ['px', '%', 'vh'],
                'range'         => [
                    'px'        => [
                        'min'   => 300,
                        'max'   => 900,
                        'step'  => 5,
                    ]
                ]
            ]
        );
        $this->add_control(
            'modal_animation',
            [
                'label'      => esc_html__('Animation Type', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SELECT,
                'description' => esc_html__('You must need to update and preview changes for seeing updated result', 'ultimate-store-kit'),
                'default'    => 'zoomIn',
                'options'    => [
                    'zoomIn'            => esc_html__('ZoomIn', 'ultimate-store-kit'),
                    'zoomOut'           => esc_html__('ZoomOut', 'ultimate-store-kit'),
                    'slideInTop'        => esc_html__('SlideInTop', 'ultimate-store-kit'),
                    'slideInBottom'     => esc_html__('SlideInBottom', 'ultimate-store-kit'),
                    'slideInLeft'       => esc_html__('SlideInLeft', 'ultimate-store-kit'),
                    'slideInRight'      => esc_html__('SlideInRight', 'ultimate-store-kit'),
                    'slideInLeft'       => esc_html__('slideInLeft', 'ultimate-store-kit'),
                    'slideTop'          => esc_html__('slideTop', 'ultimate-store-kit'),
                    'slideBottom'       => esc_html__('slideBottom', 'ultimate-store-kit'),
                    'slideRight'        => esc_html__('slideRight', 'ultimate-store-kit'),
                    'slideLeft'         => esc_html__('slideLeft', 'ultimate-store-kit'),
                    'rotateIn'          => esc_html__('rotateIn', 'ultimate-store-kit'),
                    'rotateOut'         => esc_html__('rotateOut', 'ultimate-store-kit'),
                    'flipInX'           => esc_html__('flipInX', 'ultimate-store-kit'),
                    'flipInY'           => esc_html__('flipInY', 'ultimate-store-kit'),
                    'swingTop'          => esc_html__('swingTop', 'ultimate-store-kit'),
                    'swingBottom'       => esc_html__('swingBottom', 'ultimate-store-kit'),
                    'swingRight'        => esc_html__('swingRight', 'ultimate-store-kit'),
                    'swingLeft'         => esc_html__('swingLeft', 'ultimate-store-kit'),
                    'flash'             => esc_html__('flash', 'ultimate-store-kit'),
                    'pulse'             => esc_html__('pulse', 'ultimate-store-kit'),
                    'rubberBand'        => esc_html__('rubberBand', 'ultimate-store-kit'),
                    'shake'             => esc_html__('shake', 'ultimate-store-kit'),
                    'swing'             => esc_html__('swing', 'ultimate-store-kit'),
                    'tada'              => esc_html__('tada', 'ultimate-store-kit'),
                    'wobble'            => esc_html__('wobble', 'ultimate-store-kit'),
                    'bounce'            => esc_html__('bounce', 'ultimate-store-kit'),
                    'boune'             => esc_html__('boune', 'ultimate-store-kit'),
                    'bounceIn'          => esc_html__('bounceIn', 'ultimate-store-kit'),
                    'bounceInUp'        => esc_html__('bounceInUp', 'ultimate-store-kit'),
                    'bounceInDown'      => esc_html__('bounceInDown', 'ultimate-store-kit'),
                    'bounceInRight'     => esc_html__('bounceInRight', 'ultimate-store-kit'),
                    'bounceInLeft'      => esc_html__('bounceInLeft', 'ultimate-store-kit'),
                    'unFold'            => esc_html__('unFold', 'ultimate-store-kit'),
                    'flowIn'            => esc_html__('flowIn', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'close_btn_heading',
            [
                'label'     => esc_html__('Close Button', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'show_close_btn',
            [
                'label'         => esc_html__('Enable Close Button', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => esc_html__('Yes', 'ultimate-store-kit'),
                'label_off'     => esc_html__('No', 'ultimate-store-kit'),
                'return_value'  => 'yes',
                'default'       => 'yes',
            ]
        );
        // $this->add_control(
        //     'btn_place',
        //     [
        //         'label'      => esc_html__( 'Place', 'ultimate-store-kit' ),
        //         'type'       => Controls_Manager::SELECT,
        //         'default'    => 'inside',
        //         'options'    => [
        //             'inside' => esc_html__( 'Inside', 'ultimate-store-kit' ),
        //             ''  => esc_html__( 'OutSide', 'ultimate-store-kit' ),
        //         ],
        //         'condition' => [
        //             'show_close_btn' => 'yes'
        //         ]
        //     ]
        // );
        $this->add_control(
            'button_style',
            [
                'label'      => esc_html__('Button Style', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'cancel simple',
                'options'    => [
                    'cancel simple'  => esc_html__('Cancel Simple', 'ultimate-store-kit'),
                    'cancel circle'  => esc_html__('Cancel Circle', 'ultimate-store-kit'),
                    'cancel square'  => esc_html__('Cancel Square', 'ultimate-store-kit'),
                    'text simple'    => esc_html__('Text Simple', 'ultimate-store-kit'),
                    'text label'     => esc_html__('Text Label', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_close_btn' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => esc_html__('close', 'ultimate-store-kit'),
                'condition' => [
                    'show_close_btn' => 'yes',
                    'button_style' => [
                        'text simple',
                        'text label'
                    ]
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'ultimate_store_kit_modal_style',
            [
                'label' => esc_html__('Modal Style', 'ultimate-store-kit'),
                'tab'   => 'ultimate-store-kit-modal',
            ]
        );
        $this->add_control(
            'modal_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'render_type' => 'template'
            ]
        );
        $this->add_control(
            'modal_overlay',
            [
                'label'     => esc_html__('Overlay', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'render_type' => 'template'
            ]
        );
        $this->add_control(
            'modal_close_btn',
            [
                'label' => esc_html__('Close Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                // 'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_close_btn_tabs'
        );
        $this->start_controls_tab(
            'close_btn_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_close_btn_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.sm-button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'modal_close_btn_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.sm-button' => 'background: {{VALUE}} !important',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'close_btn_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_close_btn_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.sm-button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'modal_close_btn_hover_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.sm-button:hover' => 'background: {{VALUE}} !important',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'modal_heading_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_title_tabs'
        );
        $this->start_controls_tab(
            'title_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.usk-modal-page .usk-product-title .product_title' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'title_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_title_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.usk-modal-page .usk-product-title .product_title:hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        // $this->add_control(
        //     'modal_title_margin',
        //     [
        //         'label' => esc_html__('Margin', 'ultimate-store-kit'),
        //         'type' => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', '%', 'em'],
        //         'selectors' => [
        //             '.usk-modal-page .usk-product-title .product_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.usk-modal-page .usk-product-title .product_title',
            ]
        );
        $this->add_control(
            'modal_rating_star',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_rating_tabs'
        );
        $this->start_controls_tab(
            'modal_rating_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .usk-modal-page .usk-rating .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'modal_rating_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'active_rating_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .usk-modal-page .usk-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'modal_sale_price_heading',
            [
                'label' => esc_html__('Price', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_price_tabs'
        );
        $this->start_controls_tab(
            'price_regular_tab',
            [
                'label' => esc_html__('Regular', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'regular_price_color',
            [
                'label'     => esc_html__('Regular Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.usk-modal-page .usk-product-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '.usk-modal-page .usk-product-price del' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'price_sale_tab',
            [
                'label' => esc_html__('Sale', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.usk-modal-page .usk-product-price'                                        => 'color: {{VALUE}}',
                    '.usk-modal-page .usk-product-price ins span'                               => 'color: {{VALUE}}',
                    '.usk-modal-page .usk-product-price .woocommerce-Price-amount.amount'       => 'color: {{VALUE}}',
                    '.usk-modal-page .usk-product-price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '
                .usk-modal-page .usk-product-price .price *',
            ]
        );
        $this->add_control(
            'modal_heading_desc',
            [
                'label' => esc_html__('Description', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'modal_desc_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-desc p' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_desc_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-desc p',
            ]
        );
        $this->add_control(
            'modal_heading_btn',
            [
                'label' => esc_html__('Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_btn_tabs'
        );
        $this->start_controls_tab(
            'modal_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_btn_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-quick-action-wrap .cart button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'modal_btn_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-quick-action-wrap .cart button' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'modal_btn_tab_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_btn_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-quick-action-wrap .cart button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'modal_btn_hover_bg_color',
            [
                'label' => esc_html__('Hover Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-quick-action-wrap .cart button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'modal_heading_stock',
            [
                'label' => esc_html__('Stock Status', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'modal_stock_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.ultimate-store-kit-product-modal-wrap .usk-modal-page .usk-modal-content-box .usk-quick-action-wrap .out-of-stock' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_stock_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.ultimate-store-kit-product-modal-wrap .usk-modal-page .usk-modal-content-box .usk-quick-action-wrap .out-of-stock',
            ]
        );
        $this->add_control(
            'modal_heading_sku',
            [
                'label' => esc_html__('SKU', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_sku_tabs'
        );
        $this->start_controls_tab(
            'sku_tab_label',
            [
                'label' => esc_html__('Label', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_sku_label_color',
            [
                'label' => esc_html__('Label Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .sku_wrapper' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_sku_label_typography',
                'label' => esc_html__('Label Typography', 'ultimate-store-kit'),
                'selector' => '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .sku_wrapper .sku',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'sku_tab_value',
            [
                'label' => esc_html__('Value', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_sku_color',
            [
                'label' => esc_html__('Sku Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .sku_wrapper .sku' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_sku_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .sku_wrapper .sku',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'modal_heading_category',
            [
                'label' => esc_html__('Category', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->start_controls_tabs(
            'modal_category_tabs'
        );
        $this->start_controls_tab(
            'category_tab_label',
            [
                'label' => esc_html__('Label', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_category_label_color',
            [
                'label' => esc_html__('Label Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .posted_in' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_category_label_typography',
                'label' => esc_html__('Label Typography', 'ultimate-store-kit'),
                'selector' => '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .posted_in',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'category_tab_value',
            [
                'label' => esc_html__('Value', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'modal_category_color',
            [
                'label' => esc_html__('Category Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .posted_in a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'modal_category_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '.product-quick-view .usk-modal-page .usk-modal-product .product .usk-modal-content-box .usk-product-meta .posted_in a',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
