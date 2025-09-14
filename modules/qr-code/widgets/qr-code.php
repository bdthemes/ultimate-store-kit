<?php

namespace UltimateStoreKit\Modules\QrCode\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use UltimateStoreKit\Base\Module_Base;


if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class QR_Code extends Module_Base {

    public function get_name() {
        return 'usk-qr-code';
    }

    public function get_title() {
        return esc_html__('QR Code', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-qr-code usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'qr', 'code', 'bar', 'scan', 'qr code'];
    }

    // public function get_script_depends() {
    //     return ['usk-checkout-coupon-form'];
    // }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-qr-code'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/3VkvuskVaNAM';
    // }
    public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }
    protected function is_dynamic_content(): bool {
		return false;
	}
    protected function register_controls() {
        $this->start_controls_section(
            'section_content_qrcode',
            [
                'label' => __('QR Code', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'qr_code_dimesion_size',
            [
                'label'         => __('Dimension Size', 'ultimate-store-kit'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 50,
                'max'           => 800,
                'step'          => 1,
                'default'       => 150,
            ]
        );

        $this->add_control(
            'qr_code_cart_url',
            [
                'label'         => __('Enable Add to Cart URL', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'yes',
                'default'       => 'no',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'qr_code_product_quantity',
            [
                'label'         => __('Quantity', 'ultimate-store-kit'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'max'           => 1000,
                'step'          => 1,
                'default'       => 1,
                'dynamic'       => ['active' => true],
                'condition' => [
                    'qr_code_cart_url' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'qr_code_alignemnt',
            [
                'label'         => __('Alignement', 'ultimate-store-kit'),
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
                'selectors' => [
                    '{{WRAPPER}} .usk-qrcode' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_last_order_id() {
        global $wpdb;
        $results = $wpdb->get_col(
            "
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'product'
        AND post_status = 'publish'"
        );
        return reset($results);
    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $product_id =  ultimate_store_kit_is_preview() ? $this->get_last_order_id() : $product_id = get_the_ID();
        $quantity = (!empty($settings['qr_code_product_quantity']) ? $settings['qr_code_product_quantity'] : 1);
        if ('yes' === $settings['qr_code_cart_url']) {
            $product_url = get_the_permalink($product_id) . sprintf('?add-to-cart=%s&quantity=%s', $product_id, $quantity);
        } else {
            $product_url = get_the_permalink($product_id);
        }
        $size    = (!empty($settings['qr_code_dimesion_size']) ? $settings['qr_code_dimesion_size'] : 150);
        $dimension = $size . 'x' . $size;
        $image_src = sprintf('//api.qrserver.com/v1/create-qr-code/?size=%s&ecc=L&qzone=1&data=%s', $dimension, urlencode($product_url));
        printf('<div class="usk-qrcode"><img src="%1$s" alt="%2$s"></div>', esc_url($image_src), esc_html(get_the_title($product_id)));
    }
}
