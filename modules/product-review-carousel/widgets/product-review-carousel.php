<?php

namespace UltimateStoreKit\Modules\ProductReviewCarousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;

// use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Product_Review_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;

    public function get_name() {
        return 'usk-product-review-carousel';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Review Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-review-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['ultimate-store-kit', 'shop', 'store', 'reviews', 'carousel', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-product-review-carousel'];
        }
    }
    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-site'];
        } else {
            return ['swiper', 'usk-product-review-carousel'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
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
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'ultimate-store-kit'),
                'type' => Controls_Manager::HIDDEN,
            ]
        );

        $this->add_control(
            'title_tags',
            [
                'label' => esc_html__('Title HTML Tag', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'items_limit',
            [
                'label' => __('Limit', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
            ]
        );
        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'ultimate-store-kit'),
                'description' => __(' The number of comments to pass over in the query.', 'ultimate-store-kit'),
                'type' => Controls_Manager::TEXT,
                'dynamic' 	=> [ 'active' => true ],
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'comment_date',
                'options' => [
                    'comment_author' => __('Author', 'ultimate-store-kit'),
                    'comment_approved' => __('Approved', 'ultimate-store-kit'),
                    'comment_date' => __('Date', 'ultimate-store-kit'),
                    'comment_content' => __('Content', 'ultimate-store-kit'),
                    'none' => __('Random', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'review_order',
            [
                'label' => esc_html__('Order', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'ultimate-store-kit'),
                    'DESC' => esc_html__('Descending', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'status',
            [
                'label' => __('Status', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'approve',
                'options' => [
                    'approve' => __('Approve', 'ultimate-store-kit'),
                    'hold' => __('Hold', 'ultimate-store-kit'),
                    'all' => __('All', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Additional Options', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Avatar', 'ultimate-store-kit'),
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
            'show_author',
            [
                'label' => esc_html__('Author', 'ultimate-store-kit'),
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
            'show_review_text',
            [
                'label' => esc_html__('Review Text', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'review_text_limit',
            [
                'label' => esc_html__('Review Text Limit', 'ultimate-store-kit'),
                'type' => Controls_Manager::NUMBER,
                'default' => 15,
                'condition' => [
                    'show_review_text' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        $this->register_global_controls_carousel_navigation();
        $this->register_global_controls_carousel_settings();
        /**
         * Style Tab
         */
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-item',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-item',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-item',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Avatar', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
			'avatar_size',
			[
				'label'     => __('Size', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'25'  => '25 x 25',
					'35'  => '35 x 35',
					'45'  => '45 x 45',
					'60'  => '60 x 60',
					'80'  => '80 x 80',
					'100' => '100 x 100',
					'120' => '120 x 120',
					'150' => '150 x 150',
				],
				'default'   => '80',
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'label' => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-avatar-img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-avatar-img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'space_beetwen',
            [
                'label' => esc_html__('Space Between', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-avatar-wrap' => 'gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_shadow',
                'exclude' => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-avatar-img',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-title',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_review_text' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-text',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_author',
            [
                'label' => esc_html__('Author', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_author' => 'yes',
                ],
            ]
        );
        $this->start_controls_tabs(
            'tabs_for_author'
        );
        $this->start_controls_tab(
            'author_meta',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'author_meta_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-author-name span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_meta_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-author-name span',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'author_name',
            [
                'label' => esc_html__('Name', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'author_name_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-author-name a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'author_name_hover_color',
            [
                'label' => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-author-name a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-author-name a',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_rating',
            [
                'label' => esc_html__('Rating', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_rating' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'rating_bg_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-rating span .usk-rating-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'rating_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-rating span .usk-rating-icon' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Text Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-rating-text' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rating_typography',
                'label' => esc_html__('Text Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-review-carousel .usk-rating-text',
            ]
        );
        $this->add_control(
            'rating_offset_toggle',
            [
                'label' => __('Offset', 'ultimate-store-kit'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'rating_horizontal_offset',
            [
                'label' => __('Horizontal', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-rating' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'rating_offset_toggle' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'rating_vertical_offset',
            [
                'label' => __('Vertical', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-review-carousel .usk-rating' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'rating_offset_toggle' => 'yes',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();
        $this->register_global_controls_navigation_style();
    }

    public function render_image() {
        global $post, $product;
        $settings = $this->get_settings_for_display(); ?>
        <div class="usk-avatar-img">
            <a href="#">
                <img src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
        </div>
        <?php
    }
    public function render_loop_item() {
        $settings = $this->get_settings_for_display();
        $query_args = [
            'type' => 'review',
            'order' => $settings['review_order'],
            'status' => $settings['status'],
            'orderby' => $settings['orderby'],
            'number' => $settings['items_limit']['size'],
            'offset' => $settings['offset'],
            'post_type' => 'product',
        ];

        $comments_query = new \WP_Comment_Query;
        $comments = $comments_query->query($query_args);
        if ($comments) {
            foreach ($comments as $index => $comment):
                $product_id = $comment->comment_post_ID;
                $product = wc_get_product($product_id); ?>
                <?php if ($comment->comment_approved == '0'): ?>
                    <p class="usk-waiting-approval-info">
                        <em><?php esc_html_e('Thanks, your review is awaiting for approval', 'ultimate-store-kit'); ?></em>
                    </p>
                <?php endif; ?>
                <div class="usk-item swiper-slide">
                    <div class="usk-avatar-wrap usk-flex usk-flex-middle usk-flex-wrap">
                        <?php if ($settings['show_image']): ?>
                            <div class="usk-avatar-img usk-flex-inline">
                                <?php echo get_avatar($comment->comment_author_email, $settings['avatar_size']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="usk-content-wrap">
                            <?php if ($settings['show_title']) :
                                printf('<%1$s class="usk-title"><a href="%3$s">%2$s</a></%1$s>', esc_attr($settings['title_tags']), esc_html($product->get_name()), esc_url($product->get_permalink()));
                            endif; ?>
                            <?php if ($settings['show_author']): ?>
                                <div class="usk-author-name">
                                    <span><?php esc_html_e('purchase by', 'ultimate-store-kit'); ?></span>
                                    <?php printf('<a href="%2$s">%1$s</a>', esc_html($comment->comment_author), esc_url(get_the_author_meta('url'))); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($settings['show_rating']): ?>
                        <div class="usk-rating">
                            <span>
                                <i class="usk-rating-icon usk-icon-star-full"></i>
                            </span>
                            <span class="usk-rating-text">
                                <?php 
                                printf(
                                    /* translators: %s is the average rating number */
                                    esc_html__('%s', 'ultimate-store-kit'),
                                    esc_html(floor($product->get_average_rating()))
                                ); 
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if ($settings['show_review_text']): ?>
                        <div class="usk-text">

                            <?php echo esc_html(wp_trim_words($comment->comment_content, $settings['review_text_limit'], '...')); ?>

                        </div>
                    <?php endif; ?>
                </div>
<?php
            endforeach;
        } else {
            echo esc_html__('No reviews found', 'ultimate-store-kit');
        }
    }

    protected function render() {
        $this->register_global_template_carousel_header();
        $this->render_loop_item();
        $this->usk_register_global_template_carousel_footer();
    }
}
