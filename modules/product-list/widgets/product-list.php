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
        return ['product', 'product list', 'table', 'wc', 'list'];
    }

    public function get_script_depends() {
        return ['micromodal'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-product-list'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/qJQ9wfdoMKg';
    }

    public function get_query() {
        return $this->_query;
    }
    public function has_widget_inner_wrapper(): bool {
			return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
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
                'label_on' => esc_html__('Yes', 'ultimate-store-kit'),
                'label_off' => esc_html__('No', 'ultimate-store-kit'),
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
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'item_border_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item',
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

        $this->add_responsive_control(
            'item_image_size',
            [
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ultimate-store-kit .usk-list-wrap .usk-item .usk-item-box .usk-image-wrap' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->register_global_controls_title();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
    }

    public function render_header() {
        ?>
        <div class="ultimate-store-kit">
            <div class="usk-product-list">
                <div class="usk-list-wrap usk-flex usk-flex-column">
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
        <div class="usk-image-wrap usk-flex">
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <img class="img image-default" src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
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
            <div class="usk-item-box usk-flex usk-flex-middle">
                <?php
                if ($settings['show_image']) :
                    $this->render_image();
                endif;
                ?>
                <div class="usk-content usk-flex usk-flex-column usk-flex-center">
                    <?php
                    if ($settings['show_title']) :
                        printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title()));
                    endif; ?>
                    <?php if ($settings['show_rating']) : ?>
                        <div class="usk-rating">
                            <?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ('yes' == $settings['show_price']) : ?>
                        <div class="usk-price usk-flex usk-flex-middle">
                            <?php $this->print_price_output($product->get_price_html()); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( 'yes' == $settings['show_sale_badge'] || 'yes' == $settings['show_discount_badge'] || 'yes' == $settings['show_stock_status'] || 'yes' == $settings['show_trending_badge'] || 'yes' == $settings['show_new_badge'] ) : ?>
                    <div class="usk-badge-label-wrapper">
                        <div class="usk-badge-label-content usk-flex">
                            <?php $this->register_global_template_badge_label($settings); ?>
                        </div>
                    </div>
                    <?php endif; ?>
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
