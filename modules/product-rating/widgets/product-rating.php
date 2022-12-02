<?php

namespace UltimateStoreKit\Modules\ProductRating\Widgets;

use UltimateStoreKit\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Rating extends Module_Base {

    public function get_name() {
        return 'usk-product-rating';
    }

    public function get_title() {
        return esc_html__('Product Rating', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-rating usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['rating', 'product rating', 'review'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'product_rating_style_section',
            [
                'label' => __('Product Rating', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'star_rating_heading',
            [
                'label'   => esc_html__('Star Rating', 'ultimate-store-kit'),
                'type'    => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'fill_star_rating_color',
            [
                'label'     => __('Fill Star Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-rating .star-rating span::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'empty_star_rating_color',
            [
                'label'     => __('Empty Star Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-rating .star-rating::before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'star_rating_typo',
                'selector' => '{{WRAPPER}} .usk-product-rating .star-rating',
            ]
        );

        $this->add_control(
            'review_link_heading',
            [
                'label'   => esc_html__('Review Link', 'ultimate-store-kit'),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );


        $this->add_control(
            'review_link_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-rating .woocommerce-review-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'review_link_typo',
                'selector' => '{{WRAPPER}} .usk-product-rating .woocommerce-review-link',
            ]
        );

        $this->add_control(
            'review_count_heading',
            [
                'label'   => esc_html__('Review Count', 'ultimate-store-kit'),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'review_count_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-rating .woocommerce-review-link .count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'review_count_typo',
                'selector' => '{{WRAPPER}} .usk-product-rating .woocommerce-review-link .count',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $product;

        // if ((!wc_review_ratings_enabled()) or (!$this->usk_set_single_post_type_editor_builder_data())) {
        //     return;
        // }

        $this->usk_set_single_post_type_editor_builder_data();

        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        if ($rating_count >= 0) : ?>

            <div class="usk-product-rating">
                <?php echo wc_get_rating_html($average, $rating_count); // WPCS: XSS ok.
                ?>
                <?php if (comments_open()) : ?>
                    <?php //phpcs:disable
                    ?>
                    <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf(_n('%s customer review', '%s customer reviews', $review_count, 'woocommerce'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>)</a>
                    <?php // phpcs:enable
                    ?>
                <?php endif ?>
            </div>

<?php endif;
    }

    public function render_plain_content() {
    }
}
