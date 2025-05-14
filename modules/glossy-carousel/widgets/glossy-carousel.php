<?php

namespace UltimateStoreKit\Modules\GlossyCarousel\Widgets;

use Elementor\Controls_Manager;

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
// use UltimateStoreKit\traits\Global_Swiper_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\Templates\USK_Glossy_Grid_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Glossy_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    // use Global_Swiper_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-glossy-carousel';
    }

    public function get_title() {
        return esc_html__('Glossy Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-glossy-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'product-grid', 'table', 'wc'];
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'micromodal', 'usk-site'];
        } else {
            return ['swiper', 'micromodal', 'usk-glossy-carousel'];
        }
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-glossy-carousel'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/P9proLYapgQ';
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
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__('Columns', 'ultimate-store-kit'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 3,
                'tablet_default' => 2,
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
        $this->add_responsive_control(
            'items_gap',
            [
                'label'   => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range'   => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'size' => 20,
                ],
                'mobile_default' => [
                    'size' => 20,
                ],
            ]
        );
        $this->register_global_controls_grid_layout();

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


        $this->register_global_controls_additional();
        $this->register_global_controls_carousel_navigation();
        $this->register_global_controls_carousel_settings();
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Items', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'selector'  => '{{WRAPPER}} .usk-glossy-carousel .usk-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'item_border_border!' => '',
                ],
            ]
        );
        $this->add_control(
            'item_box_shadow_color',
            [
                'label'     => esc_html__('Shadow Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-product-hover:before' => 'box-shadow: 0 8px 55px {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_shape_color',
            [
                'label'     => esc_html__('Shape Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-product-hover:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->register_global_controls_grid_image();
        $this->register_global_controls_content();
        $this->register_global_controls_title();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();

        //Navigation Style Global Controls
        $this->register_global_controls_navigation_style();
    }

    public function render_loop_item() {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();
        if ($wp_query->have_posts()) :
            while ($wp_query->have_posts()) : $wp_query->the_post();
                global $product;
                $template = new USK_Glossy_Grid_Template($settings, 'glossy-carousel');
                $template->render_glossy_grid_item($product, $settings);
            endwhile;
            wp_reset_postdata();
        else :
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        endif;
    }

    public function render() {
        $this->register_global_template_carousel_header();
        $this->render_loop_item();
        $this->usk_register_global_template_carousel_footer();
    }
    public function query_product() {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
}
