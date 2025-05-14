<?php

namespace UltimateStoreKit\Modules\ProductImageAccordion\Widgets;

use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if (!defined('ABSPATH')) exit;

class Product_Image_Accordion extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-product-image-accordion';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Image Accordion', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-image-accordion';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['woocommerce', 'shop', 'store', 'title', 'heading', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-product-image-accordion'];
        }
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['micromodal', 'usk-site'];
        } else {
            return ['micromodal'];
        }
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }
    public function get_query() {
        return $this->_query;
    }
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
            'layout_height',
            [
                'label'         => esc_html__('Height', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ],
                ],
                'default'       => [
                    'unit'      => 'px',
                    'size'      => 600,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-image-accordion .usk-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'default_item_expand',
            [
                'label'   => esc_html__('Item Hover Expand(em)', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default'       => [
                    'size'      => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-product-image-accordion .usk-item:hover' => 'flex-basis: {{SIZE}}em;',
                ],
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
        $this->update_control(
            'product_limit',
            [
                'label'   => esc_html__('Product Limit', 'ultimate-store-kit'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->end_controls_section();
        $this->register_global_controls_additional();
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_width',
            [
                'label'       => __('Max Width', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 600,
                    ],
                ],
                'default' => [
                    'size' => 350,
                ],
                'selectors'   => [
                    '(desktop){{WRAPPER}} .usk-product-image-accordion .usk-content-box' => 'max-width: {{SIZE}}px;',
                    '(tablet){{WRAPPER}} .usk-product-image-accordion .usk-content-box' => 'max-width: {{SIZE}}px;',
                    '(mobile){{WRAPPER}} .usk-product-image-accordion .usk-content-box' => 'width: 100%;'
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'ultimate-store-kit'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-product-image-accordion .usk-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'     => esc_html__('Overlay Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-image-accordion .usk-image-wrap .usk-image::before' => 'background-image: linear-gradient(24deg, {{VALUE}}, transparent, rgba(255, 0, 0, 0));',
                ],
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
                    '{{WRAPPER}} .usk-product-image-accordion .usk-item .usk-content .usk-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-product-image-accordion .usk-item .usk-content .title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-product-image-accordion .usk-item .usk-content .title',
            ]
        );

        $this->end_controls_section();
        $this->register_global_controls_category();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();
    }


    public function render_header() { ?>
        <div class="ultimate-store-kit">
            <div class="usk-product-image-accordion">
                <div class="usk-grid-wrap">
                <?php
            }
            public function render_footer() { ?>
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
                        $tooltip_position = 'top';
                        $average = $product->get_average_rating();
                        $rating_count = $product->get_rating_count();
                        $product_id = $product->get_id(); ?>
                <div class="usk-item">
                    <div class="usk-item-box">
                        <div class="usk-image-wrap">
                            <div class="usk-image">
                                <a href="#">
                                    <img class="usk-img" src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
                                </a>
                            </div>
                        </div>
                        <div class="usk-badge-label-wrapper">
                            <div class="usk-badge-label-content usk-flex usk-flex-column">
                                <?php $this->register_global_template_badge_label($settings); ?>
                            </div>
                        </div>
                        <div class="usk-content-box">
                            <div class="usk-content">
                                <?php if ('yes' == $settings['show_category']) : ?>
                                    <div class="usk-category">
                                        <?php echo wp_kses_post(wc_get_product_category_list($product->get_id(), ' ')); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_title']) :
                                    printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title()));
                                endif; ?>
                                <?php if ('yes' == $settings['show_price']) : ?>
                                    <div class="usk-price">
                                        <?php $this->print_price_output($product->get_price_html()); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_rating']) : ?>
                                    <div class="usk-rating">
                                        <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="usk-shoping">
                                <?php $this->register_global_template_add_to_wishlist($tooltip_position, $settings); ?>
                                <?php $this->register_global_template_add_to_compare($tooltip_position, $settings); ?>
                                <?php $this->register_global_template_quick_view($product_id, $tooltip_position, $settings); ?>
                                <?php $this->register_global_template_add_to_cart($tooltip_position, $settings); ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
<?php wp_reset_postdata();
                } else {
                    echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                }
            }
            protected function render() {
                $this->render_header();
                $this->render_loop_item();
                $this->render_footer();
            }
            public function query_product() {
                $default = $this->getGroupControlQueryArgs();
                $this->_query = new WP_Query($default);
            }
        }
