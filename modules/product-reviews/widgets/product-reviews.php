<?php

namespace UltimateStoreKit\Modules\ProductReviews\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;
use WP_Query;


if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Product_Reviews extends Module_Base {

    public function get_name() {
        return 'usk-product-reviews';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Reviews', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-reviews';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['ultimate-store-kit', 'shop', 'store', 'reviews', 'heading', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-product-reviews'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/cjpkFVWBmH4';
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
                'label'     => esc_html__('Items Gap', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap' => 'grid-gap: {{SIZE}}px;',
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
                'default' => 'medium',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'items_limit',
            [
                'label'         => __('Limit', 'ultimae-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 20,
                        'step'  => 1,
                    ]
                ],
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 6,
                ]
            ]
        );
        $this->add_control(
            'offset',
            [
                'label'        => __('Offset', 'ultimate-store-kit'),
                'description' => __(' The number of comments to pass over in the query.', 'ultimate-store-kit'),
                'type'         => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'comment_date',
                'options' => [
                    'comment_author'   => __('Author', 'ultimate-store-kit'),
                    'comment_approved' => __('Approved', 'ultimate-store-kit'),
                    'comment_date'     => __('Date', 'ultimate-store-kit'),
                    'comment_content'  => __('Content', 'ultimate-store-kit'),
                    'none'             => __('Random', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'review_order',
            [
                'label'      => esc_html__('Order', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'DESC',
                'options'    => [
                    'ASC'  => esc_html__('Ascending', 'ultimate-store-kit'),
                    'DESC' => esc_html__('Descending', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'status',
            [
                'label'   => __('Status', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'approve',
                'options' => [
                    'approve' => __('Approve', 'ultimate-store-kit'),
                    'hold'    => __('Hold', 'ultimate-store-kit'),
                    'all'     => __('All', 'ultimate-store-kit'),
                ],
            ]
        );
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
                'selector'  => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item',
            ]
        );
        $this->add_control(
            'item_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item'    => 'border: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item',
            ]
        );
        $this->add_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_woocommerce_additional',
            [
                'label' => esc_html__('Additional', 'ultimate-store-kit'),
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
                'label'         => esc_html__('Review Text', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
                'default' => 'yes',
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

        $this->add_responsive_control(
            'space_beetwen',
            [
                'label'     => esc_html__('Space Between', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper' => 'grid-column-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-avatar-image img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-avatar-image img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-avatar-image img',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-title a',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_author',
            [
                'label' => esc_html__('Author', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'tabs_for_author'
        );
        $this->start_controls_tab(
            'author_meta',
            [
                'label' => esc_html__('Meta', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'author_meta_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'author_meta_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'author_meta_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name span',
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
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'author_name_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'author_name_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-info-wrap .usk-review-avatar-wrapper .usk-review-content .usk-review-author-name a',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_content_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-text:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-grid-wrap .usk-review-item .usk-review-text',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_rating',
            [
                'label'     => esc_html__('Rating', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                // 'condition' => [
                //     'show_rating' => 'yes',
                // ],
            ]
        );
        $this->add_control(
            'rating_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-rating .usk-rating-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'rating_bg_color',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-rating span .usk-rating-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'rating_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-rating .usk-rating-text',
            ]
        );
        $this->add_control(
            'rating_offset',
            [
                'label'     => __('O F F S E T', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'rating_horizontal_offset',
            [
                'label'         => __('Horizontal offset', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => -20,
                        'max'   => 20,
                        'step'  => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-rating' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'rating_vertical_offset',
            [
                'label'         => __('Vertical Offset', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => -20,
                        'max'   => 20,
                        'step'  => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit-review-wrapper .usk-review-rating' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    public function render_header() { ?>
        <div class="ultimate-store-kit">
            <div class="ultimate-store-kit-review-wrapper">
                <div class="usk-review-grid-wrap">
                <?php
            }
            public function render_footer() { ?>
                </div>
            </div>
        </div>
    <?php
            }
            public function render_image() {
                global $post, $product;
                $settings = $this->get_settings_for_display(); ?>
        <div class="usk-review-avatar-image">
            <a href="#">
                <img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']); ?>" alt="<?php echo get_the_title(); ?>">
            </a>
        </div>
        <?php
            }
            public function render_loop_item() {
                $settings = $this->get_settings_for_display();
                $query_args = [
                    'type' => 'review',
                    'order' => $settings['review_order'],
                    'status'    => $settings['status'],
                    'orderby'   => $settings['orderby'],
                    'number'    => $settings['items_limit']['size'],
                    'offset'    => $settings['offset'],
                    'post_type' => 'product',
                ];

                $comments_query = new \WP_Comment_Query;
                $comments = $comments_query->query($query_args);
                if ($comments) {
                    foreach ($comments as $index => $comment) :
                        $product_id = $comment->comment_post_ID;
                        $product = wc_get_product($product_id); ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="usk-waiting-approval-info">
                        <em><?php esc_html_e('Thanks, your review is awaiting for approval', 'ultimate-store-kit'); ?></em>
                    </p>
                <?php endif; ?>
                <div class="usk-review-item">
                    <div class="usk-review-info-wrap">
                        <div class="usk-review-avatar-wrapper">
                            <?php if ($settings['show_image']) : ?>
                                <div class="usk-review-avatar-image">
                                    <?php echo get_avatar($comment->comment_author_email, $size = '50'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="usk-review-content">
                                <?php
                                if ($settings['show_title']) :
                                    printf('<%1$s class="usk-review-title"><a href="%3$s">%2$s</a></%1$s>', $settings['title_tags'], $product->get_name(), $product->get_permalink());
                                endif; ?>
                                <?php if ($settings['show_author']) : ?>
                                    <div class="usk-review-author-name">
                                        <span><?php esc_html_e('purchase by', 'ultimate-store-kit'); ?></span>
                                        <?php printf('<a href="%2$s">%1$s</a>', $comment->comment_author, get_the_author_meta('url')); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($settings['show_rating']) : ?>
                        <div class="usk-review-rating">
                            <span>
                                <i class="usk-rating-icon eicon-star"></i>
                            </span>
                            <span class="usk-rating-text"><?php esc_html_e(floor($product->get_average_rating())); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($settings['show_review_text']) : ?>
                        <div class="usk-review-text">
                            <?php echo esc_html__($comment->comment_content, 'ultimate-store-kit'); ?>
                        </div>
                    <?php endif; ?>
                </div>
<?php
                    endforeach;
                } else {
                    echo "This product hasn't been rated yet.";
                }
            }

            protected function render() {
                $this->render_header();
                $this->render_loop_item();
                $this->render_footer();
            }
        }
