<?php

namespace UltimateStoreKit\Modules\FeaturedBox\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Featured_Box extends Module_Base {

    public function get_name() {
        return 'usk-featured-box';
    }

    public function get_title() {
        return esc_html__('Featured Box', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-featured-box';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['services', 'list', 'featured', 'box', 'info', 'featured box'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-styles'];
        } else {
            return ['usk-featured-box'];
        }
    }

    // public function get_custom_help_url() {
    //  return 'https://youtu.be/a_wJL950Kz4';
    // }

    public function has_widget_inner_wrapper(): bool {
			return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
		}
		protected function register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs('tabs_layout');
        $this->start_controls_tab(
            'tab_content',
            [
                'label' => __('Content', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__('New Featured Box', 'ultimate-store-kit'),
                'placeholder' => __('Enter your title', 'ultimate-store-kit'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta',
            [
                'label' => esc_html__('Meta Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Monthly Discount', 'ultimate-store-kit'),
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Button Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Shop Now', 'ultimate-store-kit'),
                'label_block' => true,
                'dynamic' => ['active' => true],
                'condition' => [
                    'show_readmore' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'readmore_link',
            [
                'label' => esc_html__('Button Link', 'ultimate-store-kit'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'http://your-link.com',
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_readmore' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'image',
            [
                'label' => __('Image', 'ultimate-store-kit'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-image: url("{{URL}}");',
                ],
                'has_sizes' => true,
                'render_type' => 'template',
            ]
        );
        $this->add_responsive_control(
            'position',
            [
                'label' => esc_html__( 'Position', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'separator' => 'before',
                'options' => [
                    '' => esc_html__( 'Default', 'ultimate-store-kit' ),
                    'center center' => esc_html__( 'Center Center', 'ultimate-store-kit' ),
                    'center left' => esc_html__( 'Center Left', 'ultimate-store-kit' ),
                    'center right' => esc_html__( 'Center Right', 'ultimate-store-kit' ),
                    'top center' => esc_html__( 'Top Center', 'ultimate-store-kit' ),
                    'top left' => esc_html__( 'Top Left', 'ultimate-store-kit' ),
                    'top right' => esc_html__( 'Top Right', 'ultimate-store-kit' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'ultimate-store-kit' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'ultimate-store-kit' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'ultimate-store-kit' ),
                    'initial' => esc_html__( 'Custom', 'ultimate-store-kit' ),
    
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-position: {{VALUE}};',
                ],
                'condition' => [
                    'image[url]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'xpos', 
            [
                'label' => esc_html__( 'X Position', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SLIDER,
                'responsive' => true,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
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
                        'min' => -800,
                        'max' => 800,
                    ],
                    'em' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                ],
                'condition' => [
                    'position' => [ 'initial' ],
                    'image[url]!' => '',
                ],
                'required' => true,
            ]
        );
		
        $this->add_responsive_control(
            'ypos', 
            [
                'label' => esc_html__( 'Y Position', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SLIDER,
                'responsive' => true,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
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
                        'min' => -800,
                        'max' => 800,
                    ],
                    'em' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-position: {{xpos.SIZE}}{{xpos.UNIT}} {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'position' => [ 'initial' ],
                    'image[url]!' => '',
                ],
                'required' => true,
            ]
        );

        $this->add_responsive_control(
            'repeat', 
            [
                'label' => esc_html_x( 'Repeat', 'Background Control', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'ultimate-store-kit' ),
                    'no-repeat' => esc_html__( 'No-repeat', 'ultimate-store-kit' ),
                    'repeat' => esc_html__( 'Repeat', 'ultimate-store-kit' ),
                    'repeat-x' => esc_html__( 'Repeat-x', 'ultimate-store-kit' ),
                    'repeat-y' => esc_html__( 'Repeat-y', 'ultimate-store-kit' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-repeat: {{VALUE}};',
                ],
                'condition' => [
                    'image[url]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'size', 
            [
                'label' => esc_html__( 'Display Size', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'ultimate-store-kit' ),
                    'auto' => esc_html__( 'Auto', 'ultimate-store-kit' ),
                    'cover' => esc_html__( 'Cover', 'ultimate-store-kit' ),
                    'contain' => esc_html__( 'Contain', 'ultimate-store-kit' ),
                    'initial' => esc_html__( 'Custom', 'ultimate-store-kit' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-size: {{VALUE}};',
                ],
                'condition' => [
                    'image[url]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_width', 
            [
                'label' => esc_html__( 'Width', 'ultimate-store-kit' ),
                'type' => Controls_Manager::SLIDER,
                'responsive' => true,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'required' => true,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-size: {{SIZE}}{{UNIT}} auto',
    
                ],
                'condition' => [
                    'size' => [ 'initial' ],
                    'image[url]!' => '',
                ],
            ]
        );
		
        
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_optional',
            [
                'label' => __('Optional', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'title_link',
            [
                'label' => esc_html__('Title Link', 'ultimate-store-kit'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'http://your-link.com',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Don\'t miss the last opportunity.', 'ultimate-store-kit'),
                'condition' => [
                    'show_text' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => esc_html__('Badge Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('New', 'ultimate-store-kit'),
                'condition' => [
                    'badge' => 'yes',
                ],
                'separator' => 'before',
            ]
        );
        


        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_settings',
            [
                'label' => __('Additional Options', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label' => esc_html__('Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 300,
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__('Content Width', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => esc_html__('Content Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'ultimate-store-kit'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'ultimate-store-kit'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => false,
            ]
        );

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
                    '{{WRAPPER}} .usk-featured-box .usk-content' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_text',
            [
                'label' => esc_html__('Show Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => esc_html__('Show Meta', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_readmore',
            [
                'label' => esc_html__('Show Button', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit') . BDTUSK_NC,
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_wrapper_link',
            [
                'label' => esc_html__('Show Wrapper link', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wrapper_link',
            [
                'label' => esc_html__('Wrapper Link', 'ultimate-store-kit'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => 'http://your-link.com',
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_wrapper_link' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_style_items',
            [
                'label' => __('Featured Box', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'name' => 'item_background',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                // 'fields_options' => [
                //  'border' => [
                //      'default' => 'solid',
                //  ],
                //  'width'  => [
                //      'default' => [
                //          'top'      => '1',
                //          'right'    => '1',
                //          'bottom'   => '1',
                //          'left'     => '1',
                //          'isLinked' => false,
                //      ],
                //  ],
                //  'color'  => [
                //      'default' => '#eee',
                //  ],
                // ],
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-item',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-item .usk-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-item',
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
                'name' => 'item_hover_background',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333',
                'condition' => [
                    'item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-item:hover' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_hover_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-title a' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-title a:hover' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Text', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_text' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-text',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => __('Meta', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_color_hover',
            [
                'label' => __('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-meta',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_readmore',
            [
                'label' => esc_html__('Button', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_readmore' => 'yes',
                ],
            ]
        );

        $this->add_control(
			'button_offset_toggle',
			[
				'label' => __('Offset', 'ultimate-store-kit'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __('None', 'ultimate-store-kit'),
				'label_on' => __('Custom', 'ultimate-store-kit'),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_responsive_control(
			'button_x_position',
			[
				'label'   => __( 'X', 'ultimate-store-kit' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
				'condition' => [
					'button_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-button-x-offset: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'button_y_position',
			[
				'label'   => __( 'Y', 'ultimate-store-kit' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
				'condition' => [
					'button_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-button-y-offset: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'button_rotate',
			[
				'label'   => __( 'Rotate', 'ultimate-store-kit' ),
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
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'condition' => [
					'button_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-button-rotate: {{SIZE}}deg;'
				],
			]
		);
		$this->end_popover();

        $this->start_controls_tabs('tabs_readmore_style');

        $this->start_controls_tab(
            'tab_readmore_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'readmore_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'readmore_background',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'readmore_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#D90429',
                    ],
                ],
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'readmore_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'readmore_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'readmore_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'readmore_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'readmore_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_readmore_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'readmore_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a span::before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a span::after' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'readmore_hover_background',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a:before',
            ]
        );

        $this->add_control(
            'readmore_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'readmore_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'badge' => 'yes',
                    'badge_text!' => '',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_position',
            [
                'label' => esc_html__('Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top-right',
                'options' => [
                    'top-left' => esc_html__('Top Left', 'ultimate-store-kit'),
                    'top-right' => esc_html__('Top Right', 'ultimate-store-kit'),
                    'bottom-left' => esc_html__('Bottom Left', 'ultimate-store-kit'),
                    'bottom-right' => esc_html__('Bottom Right', 'ultimate-store-kit'),
                ],
                'selectors_dictionary' => [
                    'top-left' => 'top: 0; left: 0;',
                    'top-right' => 'top: 0; right: 0;',
                    'bottom-left' => 'bottom: 0; left: 0;',
                    'bottom-right' => 'bottom: 0; right: 0;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge' => '{{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_badge_style');
        $this->start_controls_tab(
            'tab_badge_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'badge_background',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-badge',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-badge',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-badge',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-badge',
            ]
        );
        $this->add_control(
			'badge_offset_toggle',
			[
				'label' => __('Offset', 'ultimate-store-kit'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __('None', 'ultimate-store-kit'),
				'label_on' => __('Custom', 'ultimate-store-kit'),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();
		$this->add_responsive_control(
			'badge_x_position',
			[
				'label'   => __( 'X', 'ultimate-store-kit' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
				'condition' => [
					'badge_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-badge-x-offset: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'badge_y_position',
			[
				'label'   => __( 'Y', 'ultimate-store-kit' ),
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
						'min' => -800,
						'max' => 800,
					],
				],
				'condition' => [
					'badge_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-badge-y-offset: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'badge_rotate',
			[
				'label'   => __( 'Rotate', 'ultimate-store-kit' ),
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
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'condition' => [
					'badge_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}}' => '--usk-badge-rotate: {{SIZE}}deg;'
				],
			]
		);
		$this->end_popover();
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_badge_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'badge_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'badge_hover_background',
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-badge:hover',
            ]
        );
        $this->add_control(
            'badge_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'badge_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-badge:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render_title() {
        $settings = $this->get_settings_for_display();

        if (!$settings['show_title']) {
            return;
        }

        if ( ! empty($settings['title_link']['url']) && ! empty($settings['title']) ) {
            $this->add_link_attributes('title-link', $settings['title_link'], true);
        }

        if (!empty($settings['title'])) {
            printf('<%1$s class="usk-title"><a %2$s title="%3$s">%3$s</a></%1$s>', esc_attr($settings['title_tag']), wp_kses_post($this->get_render_attribute_string('title-link')), wp_kses_post($settings['title']));
        }
    }

    public function render_text() {
        $settings = $this->get_settings_for_display();

        if (!$settings['show_text']) {
            return;
        }

        ?>
        <?php if ($settings['text']): ?>
            <div class="usk-text">
                <?php echo wp_kses_post($settings['text']); ?>
            </div>
        <?php endif;
    }

    public function render_meta() {
        $settings = $this->get_settings_for_display();

        if (!$settings['show_meta']) {
            return;
        }

        ?>
        <?php if ($settings['meta']): ?>
            <div class="usk-meta">
                <?php echo wp_kses_post($settings['meta']); ?>
            </div>
        <?php endif;
    }

    public function rendar_image() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['image']['url'])) {
            return;
        }

        ?>

		<div class="usk-image-wrap"></div>

		<?php
    }

    public function render_readmore() {
        $settings = $this->get_settings_for_display();

        if (!$settings['show_readmore']) {
            return;
        }

        if (!empty($settings['readmore_link']['url'])) {
            $this->add_link_attributes('readmore-link', $settings['readmore_link'], true);
        }

        ?>
        <?php if ((!empty($settings['readmore_link']['url'])) && ($settings['show_readmore'])): ?>
            <div class="usk-link-btn">
                <a <?php $this->print_render_attribute_string('readmore-link');?>>
                    <span><?php echo esc_html($settings['readmore_text']); ?></span>
                </a>
            </div>
        <?php endif;?>
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('featured-box', 'class', 'usk-featured-box usk-fb-content-position-' . $settings['content_position']);

        if (!empty($settings['wrapper_link']['url'])) {
            $this->add_link_attributes('link', $settings['wrapper_link'], true);
        }
        $this->add_render_attribute('link', 'class', 'usk-featured-box-wrapper-link', true);

        ?>
        <div <?php $this->print_render_attribute_string('featured-box');?>>

            <div class="usk-item">
                <?php $this->rendar_image();?>
                <div class="usk-content">
                    <?php $this->render_meta();?>
                    <?php $this->render_title();?>
                    <?php $this->render_text();?>
                    <?php $this->render_readmore();?>
                </div>
            </div>
            <?php
            if ($settings['badge'] == 'yes' and !empty($settings['badge_text'])) {
                printf('<div class="usk-badge">%1$s</div>', esc_html($settings['badge_text']));
            }
            if ($settings['show_wrapper_link'] == 'yes' and !empty($settings['wrapper_link']['url'])) { ?>
                <a <?php $this->print_render_attribute_string('link'); ?>></a>
            <?php } ?>

        </div>
        <?php
    }
}
