<?php

namespace UltimateStoreKit\Modules\ProductList\Widgets;


use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
// use UltimateStoreKit\traits\Global_Swiper_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Product_List extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    // use Global_Swiper_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-product-list';
    }

    public function get_title() {
        return esc_html__('Product List', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-list';
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
            return ['ultimate-store-kit-font', 'usk-product-list'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/qJQ9wfdoMKg';
    }

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
            'items_gap',
            [
                'label'     => esc_html__('Items Gap', 'ultimate-wook'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap' => 'grid-gap: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image',
                'label'   => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

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

        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Additional', 'ultimate-store-kit'),
            ]
        );
        $this->start_controls_tabs(
            'tabs_show_hide_content'
        );
        $this->start_controls_tab(
            'show_content_tab',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => esc_html__('Price', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_rating',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'hide_customer_review',
            [
                'label' => esc_html__('Hide Review Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'product-grid'),
                'label_off' => esc_html__('No', 'product-grid'),
                // 'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_rating' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-recently-view-products .usk-rating .woocommerce-product-rating .woocommerce-review-link' => 'display:none',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'show_badge_tab',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_sale_badge',
            [
                'label' => esc_html__('Sale', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_discount_badge',
            [
                'label' => esc_html__('Percentage', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_stock_status',
            [
                'label' => esc_html__('Stock Status', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_trending_badge',
            [
                'label' => esc_html__('Trending', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_new_badge',
            [
                'label' => esc_html__('New', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'newness_days',
            [
                'label' => esc_html__('Newness Days', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 90,
                'description' => esc_html__('Define newness day from product created date; default newness day is 30', 'ultimate-store-kit'),
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        // $this-> add_control(
        //            'heading_show_hide_badge',
        //            [
        //                'label'     => esc_html__( 'Badge', 'ultimate-store-kit' ),
        //                'type'      => Controls_Manager::HEADING,
        //                'separator' => 'before',
        //            ]
        // );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Items', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_background',
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'types'     => ['classic', 'gradient'],
                'selector'  => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item',
            ]
        );
        $this->add_control(
            'item_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item'    => 'border: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item',
            ]
        );
        $this->add_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item .usk-item-box .usk-image-wrap',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item .usk-item-box .usk-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_shadow',
                'exclude'  => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item .usk-item-box .usk-image-wrap',
            ]
        );

        $this->end_controls_section();
        $this->register_global_controls_title();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->start_controls_section(
            'badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'label_badge_tabs'
        );
        $this->start_controls_tab(
            'sale_badge_tab',
            [
                'label'     => esc_html__('Sale', 'ultimate-store-kit'),
                'condition' => [
                    'show_sale_badge' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'sale_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-sale-badge .usk-badge' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'sale_badge_bg',
            [
                'label'     => esc_html__('Background', 'ultimae-woo-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-sale-badge .usk-badge' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'discount_badge_tab',
            [
                'label'     => esc_html__('Discount', 'ultimate-store-kit'),
                'condition' => [
                    'show_discount_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'discount_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-percantage-badge .usk-badge' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'discount_badge_bg',
            [
                'label'     => esc_html__('Background', 'ultimae-woo-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-percantage-badge .usk-badge' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'stock_badge_tab',
            [
                'label'     => esc_html__('Stock', 'ultimate-store-kit'),
                'condition' => [
                    'show_stock_status' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'stock_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-stock-status-badge .usk-badge' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'stock_badge_bg',
            [
                'label'     => esc_html__('Background', 'ultimae-woo-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-stock-status-badge .usk-badge' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'trending_badge_tab',
            [
                'label'     => esc_html__('Trending', 'ultimate-store-kit'),
                'condition' => [
                    'show_trending_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'trending_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-trending-badge .usk-badge' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'trending_badge_bg',
            [
                'label'     => esc_html__('Background', 'ultimae-woo-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-trending-badge .usk-badge' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'new_badge_tab',
            [
                'label'     => esc_html__('new', 'ultimate-store-kit'),
                'condition' => [
                    'show_new_badge' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'new_badge_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-new-badge .usk-badge' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'new_badge_bg',
            [
                'label'     => esc_html__('Background', 'ultimae-woo-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper .usk-new-badge .usk-badge' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'badge_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper div .usk-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'badge_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper div .usk-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper div .usk-badge'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper div .usk-badge',
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'badge_top_spacing',
            [
                'label'         => esc_html__('Top Spacing', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'badge_right_spacing',
            [
                'label'         => esc_html__('Right Spacing', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-list .usk-item .usk-badge-label-wrapper' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function render_header() { ?>
        <div class="ultimate-store-kit">
            <div class="usk-product-list">
                <div class="usk-list-wrap">
                <?php
            }
            public function render_footer() {
                ?>
                </div>
            </div>
        </div>
    <?php
            }
            public function render_image() {
                $settings = $this->get_settings_for_display();
                global $product;
    ?>
        <div class="usk-image-wrap">
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <img class="img image-default" src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
            </a>
        </div>
        <?php
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
                $this->query_product();
                $wp_query = $this->get_query();
                if ($wp_query) {
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        global $product;
                        $average = $product->get_average_rating();
                        $rating_count = $product->get_rating_count();
        ?>
                <div class="usk-item">
                    <div class="usk-item-box">
                        <?php
                        if ($settings['show_image']) :
                            $this->render_image();
                        endif;
                        ?>
                        <div class="usk-content">
                            <?php
                            if ($settings['show_title']) :
                                printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', $settings['title_tags'], $product->get_permalink(), $product->get_title());
                            endif; ?>
                            <?php if ($settings['show_rating']) : ?>
                                <div class="usk-rating">
                                    <?php echo $this->register_global_template_wc_rating($average, $rating_count); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ('yes' == $settings['show_price']) : ?>
                                <div class="usk-price">
                                    <?php $this->print_price_output($product->get_price_html()); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="usk-badge-label-wrapper">
                            <?php $this->register_global_template_badge_label(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
<?php
                    wp_reset_postdata();
                } else {
                    echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                }
            }

            public function render() {
                $this->render_header();
                $this->render_loop_item();
                $this->render_footer();
            }
            public function query_product() {
                $default = $this->getGroupControlQueryArgs();
                $default['post_type'] = 'product';
                unset($default['p']);
                $this->_query = new WP_Query($default);
            }
        }
