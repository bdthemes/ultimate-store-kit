<?php

namespace UltimateStoreKit\Modules\ProductTabs\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Tabs extends Module_Base {

    public function get_name() {
        return 'usk-single-tabs';
    }

    public function get_title() {
        return esc_html__('Product Tabs', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-tabs';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['wc', 'single', 'tabs'];
    }


    protected function register_controls() {

        $this->start_controls_section(
            'tabs_nav_style_section',
            [
                'label' => __('Tabs', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_layout',
            [
                'label'     => __('Layout', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'inline'   => [
                        'title' => __('Inline', 'ultimate-store-kit'),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                    'block' => [
                        'title' => __('Block', 'ultimate-store-kit'),
                        'icon'  => 'eicon-editor-list-ul',
                    ],
                ],
                'desktop_default' => 'inline',
                'tablet_default' => 'inline',
                'mobile_default' => 'inline',
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li' => '{{VALUE}};',
                ],
                'selectors_dictionary' => [
                    'inline' => 'display: inline-flex !important;',
                    'block' => 'display: flex !important;',
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_align',
            [
                'label'     => __('Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'desktop_default' => 'left',
                'tablet_default' => 'left',
                'mobile_default' => 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_nav_border',
                'selector'    => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_nav_item_style_section',
            [
                'label' => __('Tabs Item', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'tabs_nav_item_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_item_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tabs_nav_item_typography',
                'selector' => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_nav_item_border',
                'selector'    => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a',
            ]
        );


        $this->add_responsive_control(
            'tabs_nav_item_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_tabs_nav');

        $this->start_controls_tab(
            'tabs_nav_item_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_item_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a',
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_item_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_item_color_hover',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg_hover',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a:hover',
            ]
        );

        $this->add_control(
            'tabs_nav_item_border_color_hover',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'tabs_nav_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_nav_active',
            [
                'label' => __('Active', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'tabs_nav_color_active',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li.active a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_bg_active',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li.active a',
            ]
        );

        $this->add_control(
            'tabs_nav_item_border_color_active',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'tabs_nav_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-data-tabs ul.wc-tabs li.active a' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_content',
            [
                'label' => __('Tabs Content', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_content_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_content_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-data-tabs .wc-tab',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_content_border',
                'selector'    => '{{WRAPPER}} .usk-product-data-tabs .wc-tab',
            ]
        );

        $this->add_responsive_control(
            'tabs_content_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-data-tabs .wc-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $product;

        // if ($this->__set_editor_product()) {
        $product = wc_get_product();

        if (empty($product)) {
            return;
        }

        setup_postdata($product->get_id());

?>

        <div class="usk-product-data-tabs">
            <?php woocommerce_output_product_data_tabs();  ?>
        </div>

        <script>
            // below code will work only on editor mode.
            jQuery('.wc-tabs li').removeClass('active');
            jQuery('.wc-tabs li:first').addClass('active');

            jQuery('.wc-tabs-wrapper .woocommerce-Tabs-panel').hide();
            jQuery('.wc-tabs-wrapper .woocommerce-Tabs-panel:first').show();

            jQuery('.wc-tabs a').click(function() {

                // Check for active
                jQuery('.wc-tabs li').removeClass('active');
                jQuery(this).parent().addClass('active');

                // Display active tab
                let currentTab = jQuery(this).attr('href');

                jQuery('.woocommerce-Tabs-panel').hide();
                jQuery(currentTab).show();

                return false;
            });
        </script>

        <?php

        // On render widget from Editor - trigger the init manually.
        if (wp_doing_ajax()) {
        ?>
            <script>
                jQuery('.usk-tabs-wrapper, .woocommerce-tabs, #rating').trigger('init');
            </script>

<?php
        }
    }
}
