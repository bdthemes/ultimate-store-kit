<?php

namespace UltimateStoreKit\Modules\AddToCart\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Add_To_Cart extends Module_Base {

    public function get_show_in_panel_tags() {
        return ['shop_single'];
    }

    public function get_name() {
        return 'usk-add-to-cart';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Add To Cart', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-add-to-cart';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'add to cart'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-add-to-cart'];
        }
    }


    public function unescape_html($safe_text, $text) {
        return $text;
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_product',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'show_quantity',
            [
                'label'     => esc_html__('Show Quantity Field', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Hide', 'ultimate-store-kit'),
                'label_on'  => esc_html__('Show', 'ultimate-store-kit'),
            ]
        );
        $this->add_responsive_control(
            'add_to_cart_spacing',
            [
                'label'         => __('Space Between', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} form.cart' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_quantity' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'quantity',
            [
                'label'       => esc_html__('Default Quantity', 'ultimate-store-kit'),
                'description' => esc_html__('Buyer will get this number of this Product', 'ultimate-store-kit'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1,
                'condition'   => [
                    'show_quantity' => '',
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'   => __('Text', 'ultimate-store-kit'),
                'type'    => Controls_Manager::TEXT,
                'default'     => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'placeholder' => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'dynamic' => [
                    'active' => true,
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'add_to_cart_icon',
            [
                'label' => __('Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::ICONS,
                'label_block' => false,
                'skin' => 'inline'
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => __('Icon Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left'    => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'add_to_cart_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_indent',
            [
                'label' => __('Icon Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'add_to_cart_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'ultimate-store-kit'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_style_add_to_cart',
            [
                'label' => __('Add To Cart', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_add_to_cart_style');

        $this->start_controls_tab(
            'tab_add_to_cart_normal',
            [
                'label' => __('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'add_to_cart_text_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}}; cursor:pointer;',
                    '{{WRAPPER}} .elementor-button svg *' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'add_to_cart_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#1E87F0',
                    ],
                ],
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'add_to_cart_border',
                'label'          => __('Border', 'ultimate-post-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '0',
                            'left'     => '0',
                            'isLinked' => false,
                        ],
                    ],
                    // 'color'  => [
                    //     'default' => '#8D99AE',
                    // ],
                ],
                'selector' => '{{WRAPPER}} .elementor-button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'add_to_cart_border_radius',
            [
                'label' => __('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'add_to_cart_padding',
            [
                'label' => __('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'add_to_cart_typography',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'add_to_cart_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_add_to_cart_hover',
            [
                'label' => __('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'add_to_cart_hover_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-button:hover svg *, {{WRAPPER}} .elementor-button:focus svg *' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'add_to_cart_hover_border_color',
            [
                'label' => __('Border Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'add_to_cart_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'add_to_cart_hover_background',
                'label' => __('Background', 'ultimate-store-kit'),
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .elementor-button:hover, {{WRAPPER}} .elementor-button:focus',
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'ultimate-store-kit'),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'separator' => 'before'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'qty_style',
            [
                'label'     => __('Quantity Field', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quantity' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'qty_fields_width',
            [
                'label' => esc_html__('Width', 'ultimate-store-kit'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 11
                ],
                'selectors' => [
                    '{{WRAPPER}} .cart .quantity'  => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_fields_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'color: {{VALUE}} ',
                    '{{WRAPPER}} .quantity input[type=number]::placeholder' => 'color: {{VALUE}} ',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'qty_fields_background',
                'exclude'  => ['image'],
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'qty_fields_border',
                'label'          => __('Border', 'ultimate-post-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color'  => [
                        'default' => '#a4afb7',
                    ],
                ],
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'qty_fields_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'      => '3',
                    'right'    => '3',
                    'bottom'   => '3',
                    'left'     => '3',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'qty_fields_padding',
            [
                'label'   => __('Padding', 'ultimate-store-kit'),
                'type'    => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'qty_fields_margin',
            [
                'label'   => __('Margin', 'ultimate-store-kit'),
                'type'    => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .quantity input[type=number]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} ;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'qty_fields_typography',
                'selector' => '{{WRAPPER}} .quantity input[type=number]',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'qty_fields_shadow',
                'selector' => '{{WRAPPER}} .quantity input[type=number]'
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->usk_set_single_post_preview_data();
        global $product;
        $product = wc_get_product(get_the_ID());
        if ($settings['show_quantity']) {
            $this->render_form_button($product);
        } else {
            $this->render_ajax_button($product);
        }
    }

    /**
     * @param \WC_Product $product
     */
    private function render_ajax_button($product) {
        $settings = $this->get_settings_for_display();

        if ($product) {
            if (version_compare(WC()->version, '3.0.0', '>=')) {
                $product_type = $product->get_type();
            } else {
                $product_type = $product->product_type;
            }

            $class = implode(' ', array_filter([
                'product_type_' . $product_type,
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
            ]));

            $this->add_render_attribute(
                'button',
                [
                    'rel' => 'nofollow',
                    'href' => $product->add_to_cart_url(),
                    'data-quantity' => $settings['quantity'] ? $settings['quantity'] : 1,
                    'data-product_id' => $product->get_id(),
                    'class' => $class,
                ]
            );
        } elseif (current_user_can('manage_options')) {
            $settings['text'] = __('Please set a valid product', 'ultimate-store-kit');
            $this->set_settings($settings);
        }


        $this->add_render_attribute('wrapper', 'class', 'elementor-button-wrapper');

        $this->add_render_attribute('button', 'class', 'elementor-button');
        $this->add_render_attribute('button', 'role', 'button');

        if (!empty($settings['button_css_id'])) {
            $this->add_render_attribute('button', 'id', $settings['button_css_id']);
        }

        // if ( ! empty( $settings['size'] ) ) {
        //     $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        // }

        if ($settings['hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['hover_animation']);
        }

?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <a <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>

    <?php
    }

    protected function render_text() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute([
            'content-wrapper' => [
                'class' => 'elementor-button-content-wrapper',
            ],
            'icon-align' => [
                'class' => [
                    'elementor-button-icon',
                    'elementor-align-icon-' . $settings['icon_align'],
                ],
            ],
            'text' => [
                'class' => 'elementor-button-text',
            ],
        ]);

        $this->add_inline_editing_attributes('text', 'none');
    ?>
        <span <?php echo $this->get_render_attribute_string('content-wrapper'); ?>>
            <?php if (!empty($settings['icon']) || !empty($settings['add_to_cart_icon']['value'])) : ?>
                <span <?php echo $this->get_render_attribute_string('icon-align'); ?>>
                    <?php Icons_Manager::render_icon($settings['add_to_cart_icon'], ['aria-hidden' => 'true']); ?>
                </span>
            <?php endif; ?>
            <span <?php echo $this->get_render_attribute_string('text'); ?>><?php echo $settings['text']; ?></span>
        </span>
<?php
    }

    private function render_form_button($product) {
        if (!$product && current_user_can('manage_options')) {
            echo __('Please set a valid product', 'ultimate-store-kit');

            return;
        }

        $text_callback = function () {
            ob_start();
            $this->render_text();

            return ob_get_clean();
        };

        add_filter('woocommerce_get_stock_html', '__return_empty_string');
        add_filter('woocommerce_product_single_add_to_cart_text', $text_callback);
        add_filter('esc_html', [$this, 'unescape_html'], 10, 2);

        ob_start();
        woocommerce_template_single_add_to_cart();
        $form = ob_get_clean();
        $form = str_replace('single_add_to_cart_button', 'single_add_to_cart_button elementor-button', $form);
        echo $form;

        remove_filter('woocommerce_product_single_add_to_cart_text', $text_callback);
        remove_filter('woocommerce_get_stock_html', '__return_empty_string');
        remove_filter('esc_html', [$this, 'unescape_html']);
    }
}
