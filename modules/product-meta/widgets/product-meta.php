<?php

namespace UltimateStoreKit\Modules\ProductMeta\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Meta extends Module_Base {

    public function get_name() {
        return 'usk-product-meta';
    }

    public function get_title() {
        return esc_html__('Product Meta', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-meta usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['wc', 'meta', 'product'];
    }


    protected function register_controls() {

        $this->start_controls_section(
            'meta_style_section',
            [
                'label' => __('Style', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // $this->add_responsive_control(
        //     'spacing',
        //     [
        //         'label'     => __('Spacing', 'ultimate-store-kit'),
        //         'type'      => Controls_Manager::SLIDER,
        //         'range'     => [
        //             'px' => [
        //                 'min' => 0,
        //                 'max' => 100,
        //             ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .usk-product-meta .usk-label'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2);
        //         margin-left: calc({{SIZE}}{{UNIT}}/2);',

        //             '{{WRAPPER}} .usk-product-meta'  => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2);
        //         margin-left: calc(-{{SIZE}}{{UNIT}}/2);',
        //         ],
        //     ]
        // );

        $this->start_controls_tabs('label_style_tabs');

        $this->start_controls_tab(
            'label_tab',
            [
                'label' => __('Label', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-meta .usk-label'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_color_typo',
                'selector' => '{{WRAPPER}} .usk-product-meta .usk-label',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'link_tab',
            [
                'label' => __('Link', 'ultimate-store-kit'),
            ]
        );


        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-meta .sku_wrapper a'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'link_color_typo',
                'selector' => '{{WRAPPER}} .usk-product-meta  a',
            ]
        );


        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    public function render() {
        // global $product;

        $this->usk_set_single_post_preview_data();
        $product = wc_get_product();
?>
        <div class="usk-product-meta">

            <?php do_action('woocommerce_product_meta_start'); ?>

            <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
                <span class="sku_wrapper">
                    <span class="usk-label"> <?php esc_html_e('SKU:', 'ultimate-store-kit'); ?></span>
                    <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'ultimate-store-kit'); ?></span>
                </span>
            <?php endif; ?>

            <?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="usk-label posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'ultimate-store-kit') . ' ', '</span>'); ?>

            <?php echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="usk-label tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'ultimate-store-kit') . ' ', '</span>'); ?>

            <?php do_action('woocommerce_product_meta_end'); ?>

        </div>
<?php
    }
}
