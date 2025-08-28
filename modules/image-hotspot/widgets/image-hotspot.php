<?php

namespace UltimateStoreKit\Modules\ImageHotspot\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Image_Hotspot extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-image-hotspot';
    }

    public function get_title() {
        return esc_html__('Image Hotspot', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-image-hotspot usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'image hotspot', 'hotspot', 'wc', 'carousel', 'slider'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-image-hotspot', 'tippy'];
        }
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'micromodal', 'popper', 'tippyjs', 'usk-site'];
        } else {
            return ['swiper', 'micromodal', 'popper', 'tippyjs', 'usk-image-hotspot'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/7vrY1aY5mMw';
    }

    public function get_query() {
        return $this->_query;
    }
    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }
    protected function register_controls() {
        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Image Hotspot', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'image_hotspot_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit') . BDTUSK_PC,
                'type' => Controls_Manager::SELECT,
                'default' => 'tooltip',
                'options' => [
                    'slider' => esc_html__('Slider', 'ultimate-store-kit'),
                    'tooltip' => esc_html__('Tooltip', 'ultimate-store-kit'),
                ],
                'classes' => BDTUSK_IS_PC,
            ]
        );

        $this->add_control(
            'hotspot_image',
            [
                'label'   => __('Image', 'ultimate-store-kit'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_resolution',
                'default'   => 'full',
            ]
        );
        $this->add_control(
            'hotspot_type',
            [
                'label' => __('Hotspot Type', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'image',
                'options' => [
                    'image' => [
                        'title' => __('Image', 'ultimate-store-kit'),
                        'icon' => 'eicon-image',
                    ],
                    'icon' => [
                        'title' => __('Icon', 'ultimate-store-kit'),
                        'icon' => 'eicon-plus',
                    ],
                ],
                'toggle' => false,
            ]
        );
        $this->add_control(
            'hotspot_icon',
            [
                'label' => __('Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->add_control(
            'slider_position',
            [
                'label' => esc_html__('Slider Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => false,
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
                'prefix_class' => 'usk-image-hotspot-slider-',
                'render_type' => 'template',
            ]
        );

        /**
         * Swiper Effects
         */
        $this->add_control(
            'swiper_effect',
            [
                'label'   => esc_html__('Slider Effect', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__('Slide', 'ultimate-store-kit'),
                    'fade'  => esc_html__('Fade', 'ultimate-store-kit'),
                    'cube'  => esc_html__('Cube', 'ultimate-store-kit'),
                    'flip'  => esc_html__('Flip', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );

        /**
         * Product Item Text Alignment
         */
        $this->add_responsive_control(
            'product_item_text_align',
            [
                'label'     => esc_html__('Text Alignment', 'ultimate-store-kit') . BDTUSK_NC,
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '.tippy-box[data-theme^=bdt-tippy-image-hotspot-] .usk-content-inner, {{WRAPPER}} .usk-grid-carousel .usk-content-inner' => 'text-align: {{VALUE}};',
                    '.tippy-box[data-theme^=bdt-tippy-image-hotspot-] .usk-rating, {{WRAPPER}} .usk-grid-carousel .usk-rating' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Query
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->update_control(
            'product_limit',
            [
                'default' => 3,
            ]
        );
        $this->end_controls_section();

        $this->register_global_controls_additional();

        $this->start_controls_section(
            'section_marker_image',
            [
                'label' => __('Hotspot Settings', 'ultimate-store-kit'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_responsive_control(
            'marker_x_position',
            [
                'label'     => esc_html__('X Postion', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}}.usk-thumbs-item' => 'left: {{SIZE}}%;',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'marker_y_position',
            [
                'label'     => esc_html__('Y Postion', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}}.usk-thumbs-item' => 'top: {{SIZE}}%;',
                ],
            ]
        );

        $repeater->add_control(
            'advanced_option_toggle',
            [
                'label'        => __('Hotspot Style', 'ultimate-store-kit'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __('None', 'ultimate-store-kit'),
                'label_on'     => __('Custom', 'ultimate-store-kit'),
                'return_value' => 'yes',
            ]
        );

        $repeater->start_popover();

        $repeater->add_control(
            'repeater_marker_color',
            [
                'label'       => esc_html__('Color', 'ultimate-store-kit'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box svg' => 'fill: {{VALUE}};',
                ],
                'render_type' => 'ui',
                'condition'   => [
                    'advanced_option_toggle' => 'yes',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'        => 'repeater_marker_background',
                'selector'    => '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box',
                'render_type' => 'ui',
                'condition'   => [
                    'advanced_option_toggle' => 'yes',
                ],
            ]
        );

        $repeater->end_popover();

        $this->add_control(
            'markers',
            [
                'label'       => esc_html__('Hotspot Items', 'ultimate-store-kit'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'marker_x_position' => [
                            'size' => 50,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 75,
                            'unit' => '%',
                        ],
                    ],
                    [
                        'marker_x_position' => [
                            'size' => 20,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 30,
                            'unit' => '%',
                        ],
                    ],
                    [
                        'marker_x_position' => [
                            'size' => 65,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 20,
                            'unit' => '%',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tooltip_settings',
            [
                'label' => __('Tooltip Settings', 'ultimate-store-kit'),
                'condition' => [
                    'image_hotspot_layout' => 'tooltip',
                ],
            ]
        );

        $this->add_control(
            'marker_tooltip_animation',
            [
                'label'       => esc_html__('Animation', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'shift-toward',
                'options'     => [
                    'shift-away'   => esc_html__('Shift-Away', 'ultimate-store-kit'),
                    'shift-toward' => esc_html__('Shift-Toward', 'ultimate-store-kit'),
                    'fade'         => esc_html__('Fade', 'ultimate-store-kit'),
                    'scale'        => esc_html__('Scale', 'ultimate-store-kit'),
                    'perspective'  => esc_html__('Perspective', 'ultimate-store-kit'),
                ],
                'render_type' => 'template',
            ]
        );
        $this->add_control(
            'marker_tooltip_placement',
            [
                'label'       => esc_html__('Placement', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'top',
                'options'     => [
                    'top-start'    => esc_html__('Top Left', 'ultimate-store-kit'),
                    'top'          => esc_html__('Top', 'ultimate-store-kit'),
                    'top-end'      => esc_html__('Top Right', 'ultimate-store-kit'),
                    'bottom-start' => esc_html__('Bottom Left', 'ultimate-store-kit'),
                    'bottom'       => esc_html__('Bottom', 'ultimate-store-kit'),
                    'bottom-end'   => esc_html__('Bottom Right', 'ultimate-store-kit'),
                    'left'         => esc_html__('Left', 'ultimate-store-kit'),
                    'right'        => esc_html__('Right', 'ultimate-store-kit'),
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'marker_tooltip_x_offset',
            [
                'label'   => esc_html__('Offset', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
            ]
        );

        $this->add_control(
            'marker_tooltip_y_offset',
            [
                'label'   => esc_html__('Distance', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
            ]
        );

        $this->add_control(
            'marker_tooltip_arrow',
            [
                'label' => esc_html__('Arrow', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'marker_tooltip_trigger',
            [
                'label'       => __('Trigger on Click', 'ultimate-store-kit'),
                'description' => __('Don\'t set yes when you set lightbox image with marker.', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        /**
         * Style
         */
        $this->start_controls_section(
            'section_style_image_hotspot',
            [
                'label' => esc_html__('Image Hotspot', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('tabs_image_hotspot_style');
        $this->start_controls_tab(
            'tab_image_hotspot_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'hotspot_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hotspot_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'hotspot_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'hotspot_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'hotspot_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'width: calc(24px + {{SIZE}}{{UNIT}}); height: calc(24px + {{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'hotspot_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box' => 'font-size: {{SIZE}}px;',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
            ]
        );
        $this->add_control(
            'hotspot_pulse_color',
            [
                'label' => esc_html__('Shadow Pulse Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'hotspot_pulse_size',
            [
                'label' => esc_html__('Shadow Pulse Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_image_hotspot_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'hotspot_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box:hover svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hotspot_background_hover',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box:hover',
            ]
        );
        $this->add_control(
            'hotspot_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_border_border!' => '',
                ],
            ]
        );
        $this->add_control(
            'hotspot_pulse_color_hover',
            [
                'label' => esc_html__('Shadow Pulse Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:hover:after' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_image_hotspot_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );
        $this->add_control(
            'hotspot_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item.swiper-slide-thumb-active .usk-thumbs-box i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item.swiper-slide-thumb-active .usk-thumbs-box svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hotspot_background_active',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item.swiper-slide-thumb-active .usk-thumbs-box',
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );
        $this->add_control(
            'hotspot_border_color_active',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item.swiper-slide-thumb-active .usk-thumbs-box' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_border_border!' => '',
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );
        $this->add_control(
            'hotspot_pulse_color_active',
            [
                'label' => esc_html__('Shadow Pulse Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item.swiper-slide-thumb-active:after' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * Layout Slider Style Start
         */
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Product Items', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'hotspot_gap',
            [
                'label' => esc_html__('Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot' => 'gap: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}}.usk-image-hotspot-slider-left .usk-image-hotspot-main' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '(desktop){{WRAPPER}}.usk-image-hotspot-slider-right .usk-image-hotspot-main' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}}.usk-image-hotspot-slider-left .usk-image-hotspot-main' => 'margin-left: auto;',
                    '(mobile){{WRAPPER}}.usk-image-hotspot-slider-right .usk-image-hotspot-main' => 'margin-right: auto;',
                ],
                'condition' => [
                    'image_hotspot_layout' => 'slider',
                ],
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
                'name'      => 'item_background',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_width',
            [
                'label'     => esc_html__('Width', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'     => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image-hotspot-main' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"]' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

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
                'name'      => 'item_hover_background',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover' => 'border-color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .tippy-content .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

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
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-image, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-image, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-image',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-item:hover .usk-image',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hover_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-item:hover .usk-image',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-item:hover .usk-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'content_border',
                'label'          => esc_html__('Border Color', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .' . $this->get_name() . ' .usk-content, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-content',
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
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
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
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-content, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item:hover .usk-content',
            ]
        );
        $this->add_control(
            'content_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'content_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-item:hover .usk-content' => 'border-color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item:hover .usk-content' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title:hover' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-title:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-title .title, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-title .title',
            ]
        );

        $this->end_controls_section();

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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'category_bg_color',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'category_border',
                'label'          => esc_html__('Border', 'ultimate-store-kit'),
                'selector'       => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_space_between',
            [
                'label'      => esc_html__('Space Between', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category' => 'gap: {{SIZE}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'category_shadow',
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'hover_category_bg_color',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a:hover',
            ]
        );
        $this->add_control(
            'hover_category_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-category a:hover' => 'border-color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-category a:hover' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price del' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price del' => 'color: {{VALUE}};',
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
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price'                                        => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price ins span'                               => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price .woocommerce-Price-amount.amount'       => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-price, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-price',
            ]
        );

        $this->end_controls_section();

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
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-rating .star-rating::before' => 'color: {{VALUE}};',
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
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                'name'      => 'badge_border',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-content > div .usk-badge',
            ]
        );
        $this->add_responsive_control(
            'badge_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-content > div .usk-badge'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-content > div .usk-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'badge_spacing',
            [
                'label'         => esc_html__('Space Between', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content' => 'gap: {{SIZE}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-content' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .' . $this->get_name() . ' .usk-badge-label-content > div .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-badge-label-content > div .usk-badge',
            ]
        );
        $this->start_controls_tabs(
            'label_badge_tabs'
        );
        $this->start_controls_tab(
            'sale_badge_tab',
            [
                'label'     => esc_html__('Sale', 'ultimate-store-kit'),
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'sale_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-sale-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'sale_badge_bg',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-sale-badge .usk-badge',
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'sale_badge_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-sale-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-sale-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('Discount', 'ultimate-store-kit'),
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'discount_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-percantage-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'discount_badge_bg',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-percantage-badge .usk-badge',
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'discount_badge_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-percantage-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-percantage-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('Stock', 'ultimate-store-kit'),
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'stock_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-stock-status-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'stock_badge_bg',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-stock-status-badge .usk-badge',
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'stock_badge_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-stock-status-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-stock-status-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('Trending', 'ultimate-store-kit'),
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'trending_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-trending-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'trending_badge_bg',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-trending-badge .usk-badge',
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'trending_badge_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-trending-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-trending-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('New', 'ultimate-store-kit'),
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'new_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-new-badge .usk-badge' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'new_badge_bg',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-new-badge .usk-badge',
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'new_badge_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-new-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-new-badge .usk-badge' => 'border-color: {{VALUE}} !important;',
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

        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Add to Cart', 'ultimate-store-kit'),
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button.loading::after' => 'border-color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button.loading::after' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_background_color',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'         => esc_html__('Width(%)', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . '' => '--btn-width: {{SIZE}}%;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"]' => '--btn-width: {{SIZE}}% !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label'         => esc_html__('Height(px)', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button:hover' => 'color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_hover_bg',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover, {{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button:hover, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart:hover',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-button:hover' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .' . $this->get_name() . ' .added_to_cart:hover' => 'border-color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-button:hover' => 'border-color: {{VALUE}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .added_to_cart:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'style_action_btn',
            [
                'label' => esc_html__('Action Button', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                'name'      => 'action_btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a, .tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'action_btn_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping a'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'action_btn_size',
            [
                'label'         => __('Icon Size', 'ultimate-store-kit'),
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
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-shoping a .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'font_family',
            [
                'label'                 => esc_html__('Tooltip Font', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::FONT,
                'selectors'             => [
                    '{{WRAPPER}}  .' . $this->get_name() . ' .usk-shoping a'    => 'font-family: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping a'    => 'font-family: {{VALUE}}',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_bg',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_icon_hover_bg',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wishlist_border_hover_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist:hover' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_bg',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'wishlist_active_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-wishlist.usk-active' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_compare_hover',
            [
                'label'     => esc_html__('Hover', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'compare_color_hover',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_hover',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_hover_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare:hover' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->add_control(
            'heading_compare_active',
            [
                'label'     => esc_html__('Active', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'compare_color_active',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare.usk-active' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_icon_bg_active',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare.usk-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'compare_border_active_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-compare.usk-active' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-compare.usk-active' => 'border-color: {{VALUE}} !important;',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
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
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'color: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_icon_bg_hover',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'quickview_border_hover_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . $this->get_name() . ' .usk-shoping .usk-shoping-icon-quickview:hover' => 'border-color: {{VALUE}} !important;',
                    '.tippy-box[data-theme="bdt-tippy-image-hotspot-{{ID}}"] .usk-item .usk-shoping .usk-shoping-icon-quickview:hover' => 'border-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'action_btn_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
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
            }; ?>
        <?php endif;
    }

    public function render_image() {
        global $product;
        $tooltip_position = 'left';
        $settings = $this->get_settings_for_display();

        $thumbnail_size = $settings['thumbnail_size'];

        $gallery_thumbs = $product->get_gallery_image_ids();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $thumbnail_size);

        if ($gallery_thumbs) {
            foreach ($gallery_thumbs as $key => $gallery_thumb) {
                if ($key == 0) :
                    $gallery_image_link = wp_get_attachment_image_url($gallery_thumb, $thumbnail_size);
                endif;
            }
        } else {
            $gallery_image_link = wp_get_attachment_image_url(get_post_thumbnail_id(), $thumbnail_size);
        }
        ?>
        <div class="usk-image">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
            <?php $this->render_add_to_cart(); ?>
            <div class="usk-shoping">
                <?php $this->register_global_template_add_to_wishlist($tooltip_position, $settings); ?>
                <?php $this->register_global_template_add_to_compare($tooltip_position, $settings); ?>
                <?php $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings); ?>
            </div>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content usk-flex usk-flex-column">
                    <?php $this->register_global_template_badge_label($settings); ?>
                </div>
            </div>
        </div>
    <?php
    }

    public function render_slider_header() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('image-hotspot', 'class', ['usk-image-hotspot usk-grid-carousel']);
        $id = 'image-hotspot-' . $this->get_id();

        $this->add_render_attribute('image-hotspot', 'id', $id);

        $this->add_render_attribute(
            [
                'image-hotspot' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'id' => $id,
                            "slidesPerView" => isset($settings['product_limit']) ? $settings['product_limit'] : 3,
                            "watchSlidesProgress" => true,
                            "sliderEffect"        => isset($settings["swiper_effect"]) ? $settings["swiper_effect"] : 'slide',
                            "image_hotspot_layout" => isset($settings['image_hotspot_layout']) ? $settings['image_hotspot_layout'] : 'slider',
                        ])),
                    ],
                ],
            ]
        );
    ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('image-hotspot'); ?>>
                <?php if ($settings['image_hotspot_layout'] == 'slider') : ?>
                    <div class="swiper usk-image-hotspot-main">
                        <div class="swiper-wrapper">
                        <?php endif;
                }

                public function render_slider_footer() {
                    $settings = $this->get_settings_for_display();

                    if ($settings['image_hotspot_layout'] == 'slider') {
                        $this->add_render_attribute('thumbs', 'class', 'usk-image-hotspot-thumbs swiper');
                    } else {
                        $this->add_render_attribute('thumbs', 'class', 'usk-image-hotspot-thumbs');
                    }

                        ?>
                        <?php if ($settings['image_hotspot_layout'] == 'slider') : ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- thumbsslider -->
                <div thumbsSlider="" <?php $this->print_render_attribute_string('thumbs'); ?>>
                    <?php
                    $image_size = $settings['image_resolution_size'];
                    $placeholder_image_src = Utils::get_placeholder_image_src();
                    $image_src             = wp_get_attachment_image_src($settings['hotspot_image']['id'], $image_size);
                    if (! $image_src) {
                        printf('<img src="%1$s" alt="%2$s">', esc_url($placeholder_image_src), esc_html(get_the_title()));
                    } else {
                        print(wp_get_attachment_image(
                            $settings['hotspot_image']['id'],
                            $image_size,
                            false,
                            [

                                'alt' => esc_html(get_the_title())
                            ]
                        ));
                    }
                    ?>
                    <div class="swiper-wrapper">
                        <?php $this->render_thumbs_item(); ?>
                    </div>
                </div>
                <!-- thumbsslider -->
            </div>
        </div>
    <?php
                }

                public function print_price_output($output) {
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

                public function render_product_content() {
                    $settings = $this->get_settings_for_display();

                    global $product;
                    $rating_count = $product->get_rating_count();
                    $average = $product->get_average_rating();
                    $have_rating = ('yes' === $settings['show_rating']) ? 'usk-have-rating' : '';
                    $categories = str_replace(',', '', wc_get_product_category_list($product->get_id()));

    ?>
        <div class="swiper-slide usk-item <?php echo esc_attr($have_rating); ?>">
            <div class="usk-item-box">
                <?php $this->render_image(); ?>
                <div class="usk-content">
                    <div class="usk-content-inner">
                        <?php if ('yes' == $settings['show_category']) : ?>
                            <?php printf('<%1$s class="usk-category">%2$s</%1$s>', esc_attr($settings['category_tags']), wp_kses_post($categories)); ?>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_title']) : ?>
                            <?php printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title())); ?>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_price']) : ?>
                            <div class="usk-price">
                                <?php $this->print_price_output($product->get_price_html()); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_rating']) : ?>
                            <div class="usk-rating">
                                <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
                }

                public function render_tooltip_product_content() {
                    ob_start();
                    $html = '';
                    $this->render_product_content();
                    $html .= ob_get_clean();
                    return $html;
                }

                public function render_loop_item() {
                    $settings = $this->get_settings_for_display();

                    $this->query_product();
                    $wp_query = $this->get_query();

                    if ($wp_query->have_posts()) { ?>
            <?php while ($wp_query->have_posts()) : $wp_query->the_post();


            ?>
                <?php $this->render_product_content(); ?>
        <?php endwhile;
                        wp_reset_postdata();
                    } else {
                        echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                    }
                }

                public function render_thumbs_image() {
                    global $product;
                    $settings = $this->get_settings_for_display();
                    $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['thumbnail_size']);
        ?>
        <div class="usk-image-wrap">
            <img class="usk-img" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
        </div>
        <?php
                }

                public function render_thumbs_item() {
                    $settings = $this->get_settings_for_display();

                    $hotspots = $settings['markers']; // Retrieve hotspots
                    $unique_ids = []; // Initialize an array to store unique IDs
                    if ($hotspots) {
                        foreach ($hotspots as $hotspot) {
                            $unique_ids[] = $hotspot['_id']; // Collect unique IDs
                        }
                    }

                    $this->query_product();
                    $wp_query = $this->get_query();

                    if ($wp_query->have_posts()) {
                        $index = 0;

                        while ($wp_query->have_posts()): $wp_query->the_post();
                            global $product;


                            $unique_id_class = isset($unique_ids[$index]) ? esc_attr($unique_ids[$index]) : '';

                            if ($settings['image_hotspot_layout'] == 'tooltip') {
                                $marker_title = $this->render_tooltip_product_content();

                                $this->add_render_attribute('marker', 'class', 'usk-thumbs-item  elementor-repeater-item-' . esc_attr($unique_id_class), true);

                                $this->add_render_attribute('marker', 'data-tippy-content', $marker_title, true);

                                $this->add_render_attribute('marker', 'class', 'bdt-tippy-tooltip');
                                $this->add_render_attribute('marker', 'data-tippy', '', true);

                                if ($settings['marker_tooltip_animation']) {
                                    $this->add_render_attribute('marker', 'data-tippy-animation', $settings['marker_tooltip_animation'], true);
                                }

                                if ($settings['marker_tooltip_x_offset']['size'] or $settings['marker_tooltip_y_offset']['size']) {
                                    $this->add_render_attribute('marker', 'data-tippy-offset', '[' . $settings['marker_tooltip_x_offset']['size'] . ',' . $settings['marker_tooltip_y_offset']['size'] . ']', true);
                                }

                                if ('yes' == $settings['marker_tooltip_arrow']) {
                                    $this->add_render_attribute('marker', 'data-tippy-arrow', 'true', true);
                                } else {
                                    $this->add_render_attribute('marker', 'data-tippy-arrow', 'false', true);
                                }

                                if ('yes' == $settings['marker_tooltip_trigger']) {
                                    $this->add_render_attribute('marker', 'data-tippy-trigger', 'click', true);
                                }

                                if ($settings['marker_tooltip_placement']) {
                                    $this->add_render_attribute('marker', 'data-tippy-placement', $settings['marker_tooltip_placement'], true);
                                }
                            } else {
                                $this->add_render_attribute('marker', 'class', 'swiper-slide usk-thumbs-item  elementor-repeater-item-' . esc_attr($unique_id_class), true);
                            }

        ?>
                <div <?php echo $this->get_render_attribute_string('marker'); ?>>
                    <div class="usk-thumbs-box">
                        <?php if ($settings['hotspot_type'] == 'image') : ?>
                            <?php $this->render_thumbs_image(); ?>
                        <?php else : ?>
                            <?php if ($settings['hotspot_icon']['value']) : ?>
                                <?php Icons_Manager::render_icon($settings['hotspot_icon'], ['aria-hidden' => 'true']); ?>
                            <?php else : ?>
                                <i class="usk-icon-plus-2" aria-hidden="true"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
<?php
                            $index++;
                        endwhile;

                        wp_reset_postdata();
                    } else {
                        echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                    }
                }

                public function render() {
                    $settings = $this->get_settings_for_display();

                    $this->render_slider_header();

                    if ($settings['image_hotspot_layout'] == 'slider') {
                        $this->render_loop_item();
                    }

                    $this->render_slider_footer();
                }
                public function query_product() {
                    $default = $this->getGroupControlQueryArgs();
                    $this->_query = new WP_Query($default);
                }
            }
