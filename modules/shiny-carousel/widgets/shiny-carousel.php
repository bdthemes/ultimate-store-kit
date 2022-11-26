<?php

namespace UltimateStoreKit\Modules\ShinyCarousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Shiny_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;

    public function get_name() {
        return 'usk-shiny-carousel';
    }

    public function get_title() {
        return esc_html__('Shiny Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-shiny-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'product-grid', 'table', 'wc'];
    }

    public function get_script_depends() {
        return ['micromodal'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-shiny-carousel'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/3VkvEpVaNAM';
    // }
    public function get_query() {
        return $this->_query;
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
                'label' => esc_html__('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options' => [
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
                'label' => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
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
                'label' => __('Query', 'bdthemes-element-pack'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->register_controls_wc_additional();
        $this->end_controls_section();
        // $this->register_global_controls_query();
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
                'selector'  => '{{WRAPPER}} .usk-shiny-carousel .usk-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // $this->add_group_control(
        //     Group_Control_Box_Shadow::get_type(),
        //     [
        //         'name'     => 'item_shadow',
        //         'selector' => '{{WRAPPER}} .usk-shiny-carousel .usk-item',
        //     ]
        // );

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
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        // $this->add_group_control(
        //     Group_Control_Box_Shadow::get_type(),
        //     [
        //         'name'     => 'item_hover_shadow',
        //         'selector' => '{{WRAPPER}} .usk-shiny-carousel .usk-item:hover',
        //     ]
        // );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->register_global_controls_grid_image();
        $this->register_global_controls_content();
        $this->register_global_controls_title();
        $this->register_global_controls_category();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();

        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Button', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart' => 'yes',
                ],
            ]
        );


        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .usk-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .added_to_cart' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-button.loading::after' => 'border-color: {{VALUE}}'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_background_color',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart',
            ]
        );
        $this->add_responsive_control(
            'button_width',
            [
                'label'         => esc_html__('Width', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel' => '--btn-width: {{SIZE}}%;',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'button_height',
            [
                'label'         => esc_html__('Height', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 20,
                        'max'   => 200,
                        'step'  => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_margin_spacing',
            [
                'label'         => esc_html__('Bottom Spacing', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 200,
                        'step'  => 1,
                    ]
                ],
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item:hover .usk-item-box .usk-image .added_to_cart' => 'transform: translateY(-{{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item:hover .usk-item-box .usk-image .usk-button' => 'transform: translateY(-{{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'btn_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  =>
                '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart',
            ]
        );

        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_shadow',
                'selector' => '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .usk-button, {{WRAPPER}} .usk-shiny-carousel .usk-item-box .usk-image .added_to_cart',
                'exclude' => ['line_height', 'letter_spacing'],
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .usk-button:hover, {{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .added_to_cart:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'btn_hover_bg',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .usk-button:hover, {{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .added_to_cart:hover'
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .usk-button:hover, {{WRAPPER}} .usk-shiny-carousel .usk-carousel .usk-item .usk-item-box .usk-image .added_to_cart:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();
        $this->register_global_controls_navigation_style();
    }

    public function render_image() {
        global $product;
        $tooltip_position = 'left';
        $settings = $this->get_settings_for_display();
        $gallery_thumbs = $product->get_gallery_image_ids();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
        if ($gallery_thumbs) {
            foreach ($gallery_thumbs as $key => $gallery_thumb) {
                if ($key == 0) :
                    $gallery_image_link = wp_get_attachment_image_url($gallery_thumb, $settings['image_size']);
                endif;
            }
        } else {
            $gallery_image_link = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
        }
?>
        <div class="usk-image">
            <a href="<?php echo get_permalink(); ?>">
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>" alt="<?php echo get_the_title(); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>" alt="<?php echo get_the_title(); ?>">
            </a>
            <?php $this->render_add_to_cart(); ?>
            <div class="usk-shoping">
                <?php $this->register_global_template_add_to_wishlist($tooltip_position); ?>
                <?php $this->register_global_template_quick_view($product->get_id(), $tooltip_position); ?>
            </div>

            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content">
                    <?php $this->register_global_template_badge_label(); ?>
                </div>
            </div>
        </div>
        <?php
    }
    public function render_add_to_cart() {
        global $product;
        $settings = $this->get_settings_for_display();
        if ('yes' == $settings['show_cart']) : ?>
            <?php if ($product) {
                $defaults = [
                    'quantity'   => 1,
                    'class'      => implode(
                        ' ',
                        array_filter(
                            [
                                'usk-button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            ]
                        )
                    ),
                    'attributes' => [
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ],
                ];
                $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
                if (isset($args['attributes']['aria-label'])) {
                    $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
                }
                echo apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon eicon-arrow-right"></i></a>',
                        esc_url($product->add_to_cart_url()),
                        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                        esc_html($product->add_to_cart_text())
                    ),
                    $product,
                    $args
                );
            }; ?>
        <?php endif;
    }
    public function print_price_output($output) {
        $tags = [
            'del' => ['aria-hidden' => []],
            'span'  => ['class' => []],
            'bdi' => [],
            'ins' => [],
        ];

        if (isset($output)) {
            echo wp_kses($output, $tags);
        }
    }
    public function render_loop_item() {
        $settings = $this->get_settings_for_display();
        // $wp_query = $this->register_global_template_query();
        $this->query_product();
        $wp_query = $this->get_query();

        if ($wp_query->have_posts()) { ?>
            <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                global $product;
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                $have_rating = ('yes' === $settings['show_rating']) ? 'usk-have-rating' : '';

            ?>
                <div class="swiper-slide">
                    <div class="usk-item <?php esc_attr_e($have_rating, 'ultimate-store-kit'); ?>">
                        <div class="usk-item-box">
                            <?php $this->render_image(); ?>
                            <div class="usk-content">
                                <?php if ('yes' == $settings['show_category']) : ?>
                                    <?php printf('<%1$s class="usk-category">%2$s</%1$s>', $settings['category_tags'], wc_get_product_category_list($product->get_id())); ?>
                                <?php endif; ?>
                                <?php printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', $settings['title_tags'], esc_url($product->get_permalink()), esc_html($product->get_title())); ?>
                                <?php if ('yes' == $settings['show_price']) : ?>
                                    <div class="usk-price">
                                        <?php $this->print_price_output($product->get_price_html()); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_rating']) : ?>
                                    <div class="usk-rating">
                                        <span><?php echo $this->register_global_template_wc_rating($average, $rating_count); ?></span>
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
