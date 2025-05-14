<?php

namespace UltimateStoreKit\Modules\HeavenSlider\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Heaven_Slider extends Module_Base
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
        return 'usk-heaven-slider';
    }

    public function get_title()
    {
        return esc_html__('Heaven Slider', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-heaven-slider usk-new';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['product', 'heaven slider', 'table', 'wc', 'carousel', 'slider'];
    }

    public function get_script_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'micromodal', 'usk-site'];
        } else {
            return ['swiper', 'micromodal', 'usk-heaven-slider'];
        }
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-heaven-slider'];
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
            'items_height',
            [
                'label' => esc_html__('Item Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1080,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider' => 'height: {{SIZE}}{{UNIT}}',
                ],
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

        $this->add_control(
            'content_position',
            [
                'label' => esc_html__('Content Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row-reverse' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .usk-heaven-slider .usk-item-box' => 'flex-direction: {{VALUE}};',
                    '(tablet){{WRAPPER}} .usk-heaven-slider .usk-item-box' => 'flex-direction: {{VALUE}};',
                    '(mobile){{WRAPPER}} .usk-heaven-slider .usk-item-box' => 'flex-direction: column;',
                ],
            ]
        );


        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Navigation', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_thumbs',
            [
                'label' => esc_html__('Show Thumbs', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $this->end_controls_section();

        $this->register_global_controls_additional();

        /**
         * Slider settings
         */
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => __('Slider Settings', 'ultimate-store-kit'),
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
            'mousewheel',
            [
                'label' => __('Mousewheel', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
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

        $this->end_controls_section();

        /**
         * Start Style Controls
         */
        $this->start_controls_section(
            'section_style_items',
            [
                'label' => esc_html__('Slider', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'slider_items_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-heaven-slider',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'slider_items_border',
                'label' => __('Border', 'ultimate-store-kit'),
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
                        'default' => '#5bb300',
                    ],
                ],
                'selector' => '{{WRAPPER}} .usk-heaven-slider',
            ]
        );

        $this->add_responsive_control(
            'slider_items_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_items_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [
                    'px',
                    'em',
                    '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-main-slider .usk-image-wrap .usk-img',
            ]
        );

        $this->add_responsive_control(
            'image_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-main-slider .usk-image-wrap .usk-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-main-slider .usk-image-wrap .usk-img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-main-slider .usk-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-main-slider .usk-title a:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-main-slider .usk-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-main-slider .usk-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .usk-main-slider .usk-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
                'selector' => '{{WRAPPER}} .usk-main-slider .usk-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-main-slider .usk-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-main-slider .usk-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-main-slider .usk-text',
            ]
        );

        $this->end_controls_section();

        //Global Controls Price
        $this->register_global_controls_price();

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

        $this->add_responsive_control(
            'rating_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-main-slider .usk-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Global Controls Badge & Action Button
         */
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();

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
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_text_decoration_color',
            [
                'label' => esc_html__('Text Decoration Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a' => 'text-decoration-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'category_typography_text_decoration!' => 'none',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'category_bg_color',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-category a',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'category_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-category' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-category a',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_shadow',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-category a',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hover_category_bg_color',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-category a:hover',
            ]
        );
        $this->add_control(
            'hover_category_border_color',
            [
                'label' => esc_html__('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-category a:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'category_border_border!' => '',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __('Navigation', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'nav_arrows_icon',
            [
                'label' => esc_html__('Arrows Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => esc_html__('Default', 'ultimate-store-kit'),
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
            ]
        );

        $this->start_controls_tabs('tabs_navigation_arrows_style');

        $this->start_controls_tab(
            'tabs_nav_arrows_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'arrows_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'nav_arrows_border',
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-navigation-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn' => 'font-size: {{SIZE || 18}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-heaven-slider .usk-navigation-wrap' => 'grid-column-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_arrows_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'arrows_hover_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'arrows_hover_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn:hover',
            ]
        );

        $this->add_control(
            'nav_arrows_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-nav-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_thumbs_slide',
            [
                'label' => esc_html__('Thumbs', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_thumbs' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_thumbs_style');

        $this->start_controls_tab(
            'tabs_thumbs_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'thumbs_items_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-thumbs-slider .usk-item:before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'thumbs_items_border',
                'label' => __('Border', 'ultimate-store-kit'),
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
                        'default' => '#e8e8ea',
                    ],
                ],
                'selector' => '{{WRAPPER}} .usk-heaven-slider .usk-thumbs-slider .usk-item:before',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'thumbs_items_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-thumbs-slider .usk-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_thumbs_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'thumbs_items_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5bb300',
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-thumbs-slider .usk-item:hover::before' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'thumbs_items_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_thumbs_active',
            [
                'label' => __('Active', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'thumbs_items_active_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5bb300',
                'selectors' => [
                    '{{WRAPPER}} .usk-heaven-slider .usk-thumbs-slider .usk-item.swiper-slide-active::before' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'thumbs_items_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function render_image()
    {
        global $product;
        $settings = $this->get_settings_for_display();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
        ?>
        <div class="usk-image-wrap">
            <img class="usk-img" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
        </div>
        <?php
    }

    public function render_slider_header()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('slider', 'class', ['usk-heaven-slider']);
        $id = 'ultimate-store-kit-' . $this->get_id();

        $this->add_render_attribute('slider', 'id', $id);

        $this->add_render_attribute(
            [
                'slider' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            "autoplay" => ("yes" == $settings["autoplay"]) ? ["delay" => $settings["autoplay_speed"]] : false,
                            "loop" => ($settings["loop"] == "yes") ? true : false,
                            "speed" => $settings["speed"]["size"],
                            "pauseOnHover" => ("yes" == $settings["pauseonhover"]) ? true : false,
                            "grabCursor" => ($settings["grab_cursor"] === "yes") ? true : false,
                            "effect" => 'fade',
                            "fadeEffect" => ['crossFade' => true],
                            "lazy" => true,
                            "mousewheel" => ($settings["mousewheel"]) ? true : false,
                            "observer" => ($settings["observer"]) ? true : false,
                            "observeParents" => ($settings["observer"]) ? true : false,
                            "slidesPerView" => 1,
                            "loopedSlides" => 4,
                            "navigation" => [
                                "nextEl" => "#" . $id . " .usk-button-next",
                                "prevEl" => "#" . $id . " .usk-button-prev",
                            ],
                            "lazy" => [
                                "loadPrevNext" => "true",
                            ],

                        ])),
                    ],
                ],
            ]
        );
        ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('slider'); ?>>
                <div class="swiper usk-main-slider">
                    <div class="swiper-wrapper">
                        <?php
    }

    public function render_slider_footer()
    {
        $settings = $this->get_settings_for_display();
        ?>
                    </div>
                </div>

                <?php if ($settings['show_arrows']): ?>
                    <div class="usk-navigation-wrap" style="direction:ltr;">
                        <div class="usk-nav-btn usk-button-next">
                            <i class="usk-icon-arrow-right-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
                                aria-hidden="true"></i>
                        </div>
                        <div class="usk-nav-btn usk-button-prev">
                            <i class="usk-icon-arrow-left-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
                                aria-hidden="true"></i>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- thumbsslider -->
                <?php if ($settings['show_thumbs']): ?>
                    <div thumbsSlider="" class="usk-thumbs-slider swiper">
                        <div class="swiper-wrapper">
                            <?php $this->render_thumbs_item(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- thumbsslider -->
            </div>
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
                $tooltip_position = 'top';

                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                if ($settings['show_rating'] == 'yes') {
                    $this->add_render_attribute('usk-item', 'class', ['usk-item swiper-slide', 'usk-have-rating'], true);
                } else {
                    $this->add_render_attribute('usk-item', 'class', ['usk-item swiper-slide'], true);
                }

                ?>
                <div <?php $this->print_render_attribute_string('usk-item'); ?>>
                    <div class="usk-item-box">
                        <?php $this->render_image(); ?>
                        <div class="usk-content">

                            <div class="usk-badge-label-wrapper">
                                <div class="usk-badge-label-content usk-flex">
                                    <?php $this->register_global_template_badge_label($settings); ?>
                                </div>
                            </div>

                            <div>

                                <?php if ('yes' == $settings['show_category']): ?>
                                    <?php printf('<div class="usk-category">%1$s</div>', wp_kses_post(wc_get_product_category_list($product->get_id(), ' '))); ?>
                                <?php endif; ?>

                                <?php if ('yes' == $settings['show_title']):
                                    printf('<%1$s class="usk-title"><a href="%2$s">%3$s</a></%1$s>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title()));
                                endif; ?>

                                <?php if ('yes' == $settings['show_excerpt']): ?>
                                    <div class="usk-text">
                                        <?php echo wp_kses_post(wp_trim_words($product->get_short_description(), $settings['excerpt_limit'], '...')); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ('yes' == $settings['show_price']): ?>
                                    <div class="usk-price">
                                        <?php $this->print_price_output($product->get_price_html()); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ('yes' == $settings['show_rating']): ?>
                                    <div class="usk-rating">
                                        <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if ('yes' == $settings['show_cart'] or 'yes' == $settings['show_wishlist'] or 'yes' == $settings['show_quick_view']): ?>
                                    <div class="usk-shoping">
                                        <?php
                                        $this->register_global_template_add_to_wishlist($tooltip_position, $settings);
                                        $this->register_global_template_add_to_compare($tooltip_position, $settings);
                                        $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings);
                                        $this->register_global_template_add_to_cart($tooltip_position, $settings);
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        } else {
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        }
    }

    public function render_thumbs_item()
    {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();
        if ($wp_query->have_posts()) { ?>
            <?php while ($wp_query->have_posts()):
                $wp_query->the_post();
                global $product;

                ?>
                <div class="swiper-slide usk-item">
                    <div class="usk-item-box">
                        <?php $this->render_image(); ?>
                    </div>
                </div>
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
