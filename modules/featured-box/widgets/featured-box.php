<?php
    
namespace UltimateStoreKit\Modules\FeaturedBox\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Group_Control_Css_Filter;
use Elementor\this;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Featured_Box extends Module_Base
{
    
    public function get_name()
    {
        return 'usk-featured-box';
    }
    
    public function get_title()
    {
        return  esc_html__('Featured Box', 'ultimate-store-kit');
    }
    
    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-featured-box';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }
    
    public function get_keywords()
    {
        return [ 'services', 'list', 'featured', 'box', 'info' ];
    }
    
    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return [ 'usk-styles' ];
        } else {
            return [ 'usk-featured-box' ];
        }
    }
    
    // public function get_custom_help_url() {
    //  return 'https://youtu.be/a_wJL950Kz4';
    // }
        
    protected function register_controls()
    {
        
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__('New Featured Box', 'ultimate-store-kit'),
                'placeholder' => __('Enter your title', 'ultimate-store-kit'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'title_link',
            [
                'label'       => esc_html__('Title Link', 'ultimate-store-kit'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => esc_html__('Text', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic'     => ['active' => true],
                'default'     => esc_html__('Don\'t miss the last opportunity.', 'ultimate-store-kit'),
                'condition' => [
                    'show_text' => 'yes',
                ],
                'separator' => 'before',
                // 'rows' => 4
            ]
        );

        $this->add_control(
            'meta',
            [
                'label'       => esc_html__('Meta', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => ['active' => true],
                'default'     => esc_html__('Monthly Discount', 'ultimate-store-kit'),
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label'       => esc_html__('Button Text', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Shop Now', 'ultimate-store-kit'),
                'placeholder' => esc_html__('Button Text', 'ultimate-store-kit'),
                'condition' => [
                    'show_readmore' => 'yes',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'readmore_link',
            [
                'label'       => esc_html__('Link', 'ultimate-store-kit'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_readmore' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __('Image', 'ultimate-store-kit'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'medium',
                'exclude'   => ['custom']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_settings',
            [
                'label' => __('Additional Settings', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label'     => esc_html__('Height', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-featured-box-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label'     => esc_html__('Content Width', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .usk-featured-box .usk-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'position',
            [
                'label'     => esc_html__('Content Position', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'options'   => [
                    'top'   => [
                        'title' => esc_html__('Top', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'bottom'  => [
                        'title' => esc_html__('Bottom', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'toggle' => false
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-content' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        // $this->add_control(
        //     'background_image_toggle',
        //     [
        //         'label' => __('Background Image Settings', 'ultimate-store-kit'),
        //         'type' => Controls_Manager::POPOVER_TOGGLE,
        //         'label_off' => __('None', 'ultimate-store-kit'),
        //         'label_on' => __('Custom', 'ultimate-store-kit'),
        //         'return_value' => 'yes',
        //         'separator' => 'before'
        //     ]
        // );
        
        // $this->start_popover();

        // $this->add_responsive_control(
        //     'background_image_position',
        //     [
        //         'label'   => _x( 'Position', 'bdthemes-prime-slider' ),
        //         'type'    => Controls_Manager::SELECT,
        //         'default' => '',
        //         'options' => [
        //             ''              => _x( 'Default', 'bdthemes-prime-slider' ),
        //             'center center' => _x( 'Center Center', 'bdthemes-prime-slider' ),
        //             'center left'   => _x( 'Center Left', 'bdthemes-prime-slider' ),
        //             'center right'  => _x( 'Center Right', 'bdthemes-prime-slider' ),
        //             'top center'    => _x( 'Top Center', 'bdthemes-prime-slider' ),
        //             'top left'      => _x( 'Top Left', 'bdthemes-prime-slider' ),
        //             'top right'     => _x( 'Top Right', 'bdthemes-prime-slider' ),
        //             'bottom center' => _x( 'Bottom Center', 'bdthemes-prime-slider' ),
        //             'bottom left'   => _x( 'Bottom Left', 'bdthemes-prime-slider' ),
        //             'bottom right'  => _x( 'Bottom Right', 'bdthemes-prime-slider' ),
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-position: {{VALUE}};',
        //         ],
        //         'condition' => [
        //             'background_image_toggle' => 'yes'
        //         ],
        //         'render_type' => 'ui',
        //     ]
        // );

        // $this->add_responsive_control(
        //     'background_image_attachment',
        //     [
        //         'label'   => _x( 'Attachment', 'bdthemes-prime-slider' ),
        //         'type'    => Controls_Manager::SELECT,
        //         'default' => '',
        //         'options' => [
        //             ''       => _x( 'Default', 'bdthemes-prime-slider' ),
        //             'scroll' => _x( 'Scroll', 'bdthemes-prime-slider' ),
        //             'fixed'  => _x( 'Fixed', 'bdthemes-prime-slider' ),
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-attachment: {{VALUE}};',
        //         ],
        //         'condition' => [
        //             'background_image_toggle' => 'yes'
        //         ],
        //         'render_type' => 'ui',
        //     ]
        // );

        // $this->add_responsive_control(
        //     'background_image_repeat',
        //     [
        //         'label'      => _x( 'Repeat', 'bdthemes-prime-slider' ),
        //         'type'       => Controls_Manager::SELECT,
        //         'default'    => '',
        //         'options'    => [
        //             ''          => _x( 'Default', 'bdthemes-prime-slider' ),
        //             'no-repeat' => _x( 'No-repeat', 'bdthemes-prime-slider' ),
        //             'repeat'    => _x( 'Repeat', 'bdthemes-prime-slider' ),
        //             'repeat-x'  => _x( 'Repeat-x', 'bdthemes-prime-slider' ),
        //             'repeat-y'  => _x( 'Repeat-y', 'bdthemes-prime-slider' ),
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-repeat: {{VALUE}};',
        //         ],
        //         'condition' => [
        //             'background_image_toggle' => 'yes'
        //         ],
        //         'render_type' => 'ui',
        //     ]
        // );
        
        // $this->add_responsive_control(
        //     'background_image_size',
        //     [
        //         'label'      => _x( 'Size', 'bdthemes-prime-slider' ),
        //         'type'       => Controls_Manager::SELECT,
        //         'default'    => '',
        //         'options'    => [
        //             ''        => _x( 'Default', 'bdthemes-prime-slider' ),
        //             'auto'    => _x( 'Auto', 'bdthemes-prime-slider' ),
        //             'cover'   => _x( 'Cover', 'bdthemes-prime-slider' ),
        //             'contain' => _x( 'Contain', 'bdthemes-prime-slider' ),
        //             'initial' => _x( 'Custom', 'bdthemes-prime-slider' ),
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-size: {{VALUE}};',
        //         ],
        //         'condition' => [
        //             'background_image_toggle' => 'yes'
        //         ],
        //         'render_type' => 'ui',
        //     ]
        // );
        
        // $this->add_responsive_control(
        //     'background_image_width',
        //     [
        //         'label' => _x( 'Width', 'bdthemes-prime-slider' ),
        //         'type' => Controls_Manager::SLIDER,
        //         'size_units' => [ 'px', 'em', '%', 'vw' ],
        //         'range' => [
        //             'px' => [
        //                 'min' => 0,
        //                 'max' => 1000,
        //             ],
        //             '%' => [
        //                 'min' => 0,
        //                 'max' => 100,
        //             ],
        //             'vw' => [
        //                 'min' => 0,
        //                 'max' => 100,
        //             ],
        //         ],
        //         'default' => [
        //             'size' => 100,
        //             'unit' => '%',
        //         ],
        //         'required' => true,
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-featured-box .usk-image-wrap' => 'background-size: {{SIZE}}{{UNIT}} auto',

        //         ],
        //         'condition' => [
        //             'background_image_size' => [ 'initial' ],
        //         ],
        //         'render_type' => 'ui',
        //     ]
        // );

        // $this->end_popover();

        $this->add_control(
            'show_title',
            [
                'label'   => __('Show Title', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'   => __('Title HTML Tag', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'show_text',
            [
                'label'   => esc_html__('Show Text', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label'   => esc_html__('Show Meta', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_readmore',
            [
                'label'   => esc_html__('Show Button', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_wrapper_link',
            [
                'label'   => esc_html__('Show Wrapper link', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'wrapper_link',
            [
                'label'       => esc_html__('Wrapper Link', 'ultimate-store-kit'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_wrapper_link' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        
        //Style
        $this->start_controls_section(
            'section_style_items',
            [
                'label' => __('Featured Box', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                'selector'  => '{{WRAPPER}} .usk-featured-box-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'item_border',
                'label'          => esc_html__('Border', 'ultimate-store-kit'),
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
                'selector'       => '{{WRAPPER}} .usk-featured-box-item',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box-item .usk-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box-item',
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
                'selector'  => '{{WRAPPER}} .usk-featured-box-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333',
                'condition' => [
                    'item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box-item:hover' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_box_shadow',
                'selector' => '{{WRAPPER}} .usk-featured-box-item:hover',
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
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
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
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_text' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box .usk-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-text',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => __('Meta', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_color_hover',
            [
                'label'     => __('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box .usk-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-meta',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_readmore',
            [
                'label'     => esc_html__('Button', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_readmore' => 'yes',
                ],
            ]
        );

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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'readmore_background',
                'selector'  => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'readmore_border',
                'label'          => esc_html__('Border', 'ultimate-store-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color'  => [
                        'default' => '#D90429',
                    ],
                ],
                'selector'       => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'readmore_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'readmore_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'readmore_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-featured-box .usk-link-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'readmore_typography',
                'selector' => '{{WRAPPER}} .usk-featured-box .usk-link-btn a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'readmore_box_shadow',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
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
                'name'      => 'readmore_hover_background',
                'selector'  => '{{WRAPPER}} .usk-featured-box .usk-link-btn a:before',
            ]
        );

        $this->add_control(
            'readmore_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
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
    }


    public function render_title()
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_title']) {
            return;
        }

        $this->add_render_attribute(
            [
                'title-link' => [
                    'href'   => isset($settings['title_link']['url']) && !empty($settings['title_link']['url']) ? esc_url($settings['title_link']['url']) : 'javascript:void(0);',
                    'target' => $settings['title_link']['is_external'] ? '_blank' : '_self'
                ]
            ],
            '',
            '',
            true
        );

        if (!empty($settings['title'])) {
            printf('<%1$s class="usk-title"><a %2$s title="%3$s">%3$s</a></%1$s>', $settings['title_tag'], $this->get_render_attribute_string('title-link'), wp_kses_post($settings['title']));
        }
    }

    public function render_text()
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_text']) {
            return;
        }

        ?>
        <?php if ($settings['text']) : ?>
            <div class="usk-text">
                <?php echo wp_kses_post($settings['text']); ?>
            </div>
        <?php endif;
    }

    public function render_meta()
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_meta']) {
            return;
        }

        ?>
        <?php if ($settings['meta']) : ?>
            <div class="usk-meta">
                <?php echo wp_kses_post($settings['meta']); ?>
            </div>
        <?php endif;
    }

    public function rendar_image() {
		$settings = $this->get_settings_for_display();

		$image_src = Group_Control_Image_Size::get_attachment_image_src($settings['image']['id'], 'thumbnail', $settings);

		if ($image_src) {
			$image_final_src = $image_src;
		} elseif ($settings['image']['url']) {
			$image_final_src = $settings['image']['url'];
		} else {
			return;
		}
		?>

		<div class="usk-image-wrap" style="background-image: url('<?php echo esc_url($image_final_src); ?>')"></div>

		<?php
	}

    public function render_readmore()
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_readmore']) {
            return;
        }

        $this->add_render_attribute(
            [
                'readmore-link' => [
                    'href'   => isset($settings['readmore_link']['url']) ? esc_url($settings['readmore_link']['url']) : '#',
                    'target' => $settings['readmore_link']['is_external'] ? '_blank' : '_self'
                ]
            ],
            '',
            '',
            true
        );

        ?>
        <?php if (( ! empty($settings['readmore_link']['url'])) && ( $settings['show_readmore'] )) : ?>
            <div class="usk-link-btn">
                <a <?php echo $this->get_render_attribute_string('readmore-link'); ?>>
                    <span><?php echo esc_html($settings['readmore_text']); ?></span>
                </a>
            </div>
        <?php endif; ?>
        <?php
    }
        
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute('featured-box', 'class', 'usk-featured-box usk-fb-content-position-' . $settings['position']);

        $this->add_render_attribute(
            [
                'link' => [
                    'href'   => isset($settings['wrapper_link']['url']) && !empty($settings['wrapper_link']['url']) ? esc_url($settings['wrapper_link']['url']) : 'javascript:void(0);',
                    'target' => $settings['show_wrapper_link'] == 'yes' and $settings['wrapper_link']['is_external'] ? '_blank' : '_self'
                ]
            ],
            '',
            '',
            true
        );

        ?>
        <div <?php $this->print_render_attribute_string('featured-box'); ?>>
    
            <div class="usk-featured-box-item">
                <?php $this->rendar_image(); ?>
                <div class="usk-content">
                    <?php $this->render_meta(); ?>
                    <?php $this->render_title(); ?>
                    <?php $this->render_text(); ?>
                    <?php $this->render_readmore(); ?>
                </div>
            </div>
            <?php
            if ($settings['show_wrapper_link'] == 'yes' and !empty($settings['wrapper_link']['url'])) {
                printf('<a %1$s class="usk-featured-box-wrapper-link"></a>', $this->get_render_attribute_string('link'));
            }?>

        </div>
        <?php
    }
}
