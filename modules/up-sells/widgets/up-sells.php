<?php

namespace UltimateStoreKit\Modules\UpSells\Widgets;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Up_Sells extends Module_Base {

    public function get_name() {
        return 'usk-up-sells';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Up Sells', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-up-sells';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'upsell', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-up-sells'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Up Sells', 'ultimate-store-kit'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        // if (!$this->__set_editor_product()) {
        //     return;
        // };

        woocommerce_upsell_display();
    }
}
