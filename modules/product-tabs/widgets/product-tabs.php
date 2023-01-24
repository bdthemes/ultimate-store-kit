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
    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-product-tabs'];
        }
    }

    protected function register_controls() {

        $this->start_controls_section(
            'tabs_nav_style_section',
            [
                'label' => __('Tabs', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // $this->add_responsive_control(
        //     'tabs_nav_layout',
        //     [
        //         'label'     => __('Layout', 'ultimate-store-kit'),
        //         'type'      => Controls_Manager::CHOOSE,
        //         'options'   => [
        //             'inline'   => [
        //                 'title' => __('Inline', 'ultimate-store-kit'),
        //                 'icon'  => 'eicon-ellipsis-h',
        //             ],
        //             'block' => [
        //                 'title' => __('Block', 'ultimate-store-kit'),
        //                 'icon'  => 'eicon-editor-list-ul',
        //             ],
        //         ],
        //         'desktop_default' => 'inline',
        //         'tablet_default' => 'inline',
        //         'mobile_default' => 'inline',
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li' => '{{VALUE}};',
        //         ],
        //         'selectors_dictionary' => [
        //             'inline' => 'display: inline-flex !important;',
        //             'block' => 'display: flex !important;',
        //         ]
        //     ]
        // );

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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs' => 'justify-content: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_nav_item_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_nav_border',
                'selector'    => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tabs_nav_item_typography',
                'selector' => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_nav_item_border',
                'selector'    => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a',
            ]
        );


        $this->add_responsive_control(
            'tabs_nav_item_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a:hover'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_item_bg_hover',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a:hover',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li a:hover' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li.active a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_nav_bg_active',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li.active a',
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
                    '{{WRAPPER}} .usk-product-tabs ul.wc-tabs li.active a' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-product-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_content_bg',
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-product-tabs .wc-tab',
            ]
        );

        $this->add_control(
            'tabs_content_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-tabs .wc-tab' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_content_border',
                'selector'    => '{{WRAPPER}} .usk-product-tabs .wc-tab',
            ]
        );

        $this->add_responsive_control(
            'tabs_content_border_radius',
            [
                'label'      => __('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-tabs .wc-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $product_tabs = apply_filters('woocommerce_product_tabs', array());

        if (!empty($product_tabs)) : ?>

            <div class="usk-product-tabs woocommerce-tabs wc-tabs-wrapper">
                <ul class="tabs wc-tabs" role="tablist">
                    <?php foreach ($product_tabs as $key => $product_tab) : ?>
                        <li class="<?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
                            <a href="#tab-<?php echo esc_attr($key); ?>">
                                <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php foreach ($product_tabs as $key => $product_tab) : ?>
                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                        <?php
                        if (isset($product_tab['callback'])) {
                            call_user_func($product_tab['callback'], $key, $product_tab);
                        } ?>
                    </div>
                <?php endforeach; ?>

                <?php do_action('woocommerce_product_after_tabs'); ?>
            </div>

        <?php endif; ?>
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
                jQuery('.woocommerce-tabs, #rating').trigger('init');
            </script>

<?php
        }
    }
}
