<?php

namespace UltimateStoreKit\Modules\GlossyCarousel\Widgets;

use Elementor\Controls_Manager;

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
// use UltimateStoreKit\traits\Global_Swiper_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Glossy_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    // use Global_Swiper_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-glossy-carousel';
    }

    public function get_title() {
        return esc_html__('Glossy Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-glossy-carousel';
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
            return ['ultimate-store-kit-font', 'usk-glossy-carousel'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/P9proLYapgQ';
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
            'columns',
            [
                'label'          => esc_html__('Columns', 'ultimate-store-kit'),
                'type'           => Controls_Manager::SELECT,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options'        => [
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
                'label'   => esc_html__('Item Gap', 'bdthemes-prime-slider'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range'   => [
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
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->register_controls_wc_additional();
        $this->end_controls_section();


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
                'selector'  => '{{WRAPPER}} .usk-glossy-carousel .usk-item',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                    '{{WRAPPER}} .usk-glossy-carousel .usk-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->register_global_controls_grid_image();
        $this->register_global_controls_content();
        $this->register_global_controls_title();
        $this->register_global_controls_price();

        $this->start_controls_section(
            'section_style_rating',
            [
                'label'     => esc_html__('Rating', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_rating' => 'yes',
                ],
            ]
        );
        $this->start_controls_tabs(
            'tab_rating_star'
        );
        $this->start_controls_tab(
            'rating_star',
            [
                'label' => esc_html__('Star', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'rating_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'active_rating_color',
            [
                'label'     => esc_html__('Active Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_rating_review',
            [
                'label'     => esc_html__('Review', 'ultimate-store-kit'),
                'condition' => [
                    'hide_customer_review!' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'rating_review_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .woocommerce-product-rating .woocommerce-review-link'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .woocommerce-product-rating .woocommerce-review-link span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'rating_review_hover_color',
            [
                'label'     => esc_html__('Hover color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .woocommerce-product-rating .woocommerce-review-link:hover'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-glossy-carousel .usk-rating .woocommerce-product-rating .woocommerce-review-link:hover span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();

        //Navigation Style Global Controls
        $this->register_global_controls_navigation_style();
    }

    public function render_image() {
        global $product;
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
                <img class="img default-image" src="<?php echo esc_url($product_image); ?>" alt="<?php echo get_the_title(); ?>">
                <img class="img hover-image" src="<?php echo esc_url($gallery_image_link); ?>" alt="<?php echo get_the_title(); ?>">
            </a>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content">
                    <?php $this->register_global_template_badge_label(); ?>
                </div>
            </div>

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
        if ($wp_query->have_posts()) { ?>
            <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                global $product;
                $tooltip_position = 'right';
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                $have_rating = ('yes' == $settings['show_rating']) ? 'usk-have-rating' : ''; ?>

                <div class="swiper-slide usk-item <?php esc_attr_e($have_rating, 'utlimate-woo-kit'); ?>">
                    <div class=" usk-item-box">
                        <?php $this->render_image(); ?>
                        <div class="usk-content">
                            <?php if ('yes' == $settings['show_title']) :
                                printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', $settings['title_tags'], esc_url($product->get_permalink()), esc_html($product->get_title()));
                            endif; ?>
                            <?php if ('yes' == $settings['show_price']) : ?>
                                <div class="usk-price">
                                    <?php $this->print_price_output($product->get_price_html()); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ('yes' == $settings['show_rating']) : ?>
                                <div class="usk-rating">
                                    <?php echo $this->register_global_template_wc_rating($average, $rating_count); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="usk-shoping">
                            <?php
                            $this->register_global_template_add_to_wishlist($tooltip_position);
                            $this->register_global_template_quick_view($product->get_id(), $tooltip_position);
                            $this->register_global_template_add_to_cart($tooltip_position);

                            ?>
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
