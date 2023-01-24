<?php

namespace UltimateStoreKit\Modules\ProductImage\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Image extends Module_Base {

    public function get_name() {
        return 'usk-product-image';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Image', 'ultimate-store-kit-pro');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-image usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['account', 'my-account', 'address'];
    }

    public function get_script_depends() {
        $scripts = [];
        if (current_theme_supports('wc-product-gallery-zoom')) {
            $scripts[] = 'zoom';
        }
        if (current_theme_supports('wc-product-gallery-slider')) {
            $scripts[] = 'flexslider';
        }
        if (current_theme_supports('wc-product-gallery-lightbox')) {
            $scripts[] = 'photoswipe-ui-default';
        }
        $scripts[] = 'wc-single-product';

        return $scripts;
    }

    public function get_style_depends() {
        $styles = ['photoswipe', 'photoswipe-default-skin', 'woocommerce_prettyPhoto_css'];

        if (current_theme_supports('wc-product-gallery-lightbox')) {
            $styles[] = 'photoswipe-default-ski';
            add_action('wp_footer', 'woocommerce_photoswipe');
        }

        if ($this->usk_is_edit_mode()) {
            return array_merge(['usk-all-styles'], $styles);
        } else {
            return array_merge(['usk-product-image'], $styles);
        }
    }


    protected function register_controls() {

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_bgc',
            [
                'label'        => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'        => Controls_Manager::COLOR,
                'selectors'    => [
                    '{{WRAPPER}} img, .pswp__img' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .woocommerce-product-gallery__image img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'content_section_thumbs',
            [
                'label' => __('Thumbnails', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_responsive_control(
            'gallery_thumbs_width',
            [
                'label'      => esc_html__('Width', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ]
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 20,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'size' => 25,
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'size' => 25,
                    'unit' => '%',
                ],
                'default' => [
                    'size' => 20,
                    'unit' => '%',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'thumbs_border',
                'selector'       => '.usk-product-image .images.woocommerce-product-gallery .flex-control-thumbs li img',
            ],
        );

        $this->add_control(
            'thumbs_border_radius',
            [
                'label'      => esc_html__('Border Radius (px)', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .images.woocommerce-product-gallery .flex-control-thumbs li img' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'gallery_thumbs_row_gap',
            [
                'label'      => esc_html__('Row Gap (px)', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs li'                   => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs'                      => 'margin-left:-{{SIZE}}{{UNIT}};margin-right: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );



        $this->add_control(
            'gallery_thumbs_column_gap',
            [
                'label'      => esc_html__('Column Gap (px)', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs li'                   => 'padding-top: {{SIZE}}{{UNIT}};padding-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs'                      => 'margin-top:-{{SIZE}}{{UNIT}};margin-bottom: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbs_margin',
            [
                'label'      => esc_html__('Margin Top (px)', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => '5',
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image .flex-control-thumbs'   => 'margin-top: {{SIZE}}px;',
                ],
                'separator'     => 'before',
            ]
        );
        $this->end_controls_section();
    }


    protected function render() {

        $this->usk_set_single_post_preview_data(); ?>
        <div class="usk-product-image product">
            <?php woocommerce_show_product_images(); ?>
        </div>
        <?php

        if ($this->usk_is_edit_mode()) :
        ?>
            <script>
                jQuery('.woocommerce-product-gallery').each(function() {
                    jQuery(this).wc_product_gallery();
                });
            </script>
<?php
        endif;
    }
}
