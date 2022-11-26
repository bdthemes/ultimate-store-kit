<?php

namespace UltimateStoreKit\Modules\Breadcrumbs\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Breadcrumbs extends Module_Base {

    public function get_name() {
        return 'usk-breadcrumbs';
    }

    public function get_title() {
        return esc_html__('Breadcrumbs', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-breadcrumbs usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['breadcrumbs'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'breadcrumb_style_section',
            [
                'label' => __('Style', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'important_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => __('If the design by this widget not working properly, please try to switch basic theme.', 'ultimate-store-kit'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-breadcrumb-wrapper .woocommerce-breadcrumb' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => __('Link Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-breadcrumb-wrapper .woocommerce-breadcrumb a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label'     => __('Hover Link Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-breadcrumb-wrapper .woocommerce-breadcrumb a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'breadcrumb_typography',
                'selector' => '{{WRAPPER}} .usk-wc-breadcrumb-wrapper .woocommerce-breadcrumb',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon'  => 'fas fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon'  => 'fas fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon'  => 'fas fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-breadcrumb-wrapper .woocommerce-breadcrumb'   => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        global $product;
        $product = wc_get_product();
        // if ($this->__set_editor_product()) {
?>

        <div class="usk-wc-breadcrumb-wrapper">
            <?php woocommerce_breadcrumb(); ?>
        </div>
<?php
    }
}

// }
