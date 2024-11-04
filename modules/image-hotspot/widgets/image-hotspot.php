<?php

namespace UltimateStoreKit\Modules\ImageHotspot\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Image_Hotspot extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-image-hotspot';
    }

    public function get_title() {
        return esc_html__('Image Hotspot', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-image-hotspot usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'image hotspot', 'hotspot', 'wc', 'carousel', 'slider'];
    }

    public function get_script_depends() {
        return ['micromodal'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-image-hotspot'];
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
            'items_height',
            [
                'label' => esc_html__('Item Height', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', 'em'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1080,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'label' => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'full',
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => esc_html__('Content Position', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row-reverse' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .usk-image-hotspot .usk-item-box' => 'flex-direction: {{VALUE}};',
                    '(tablet){{WRAPPER}} .usk-image-hotspot .usk-item-box' => 'flex-direction: {{VALUE}};',
                    '(mobile){{WRAPPER}} .usk-image-hotspot .usk-item-box' => 'flex-direction: column;',
                ],
            ]
        );


        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Navigation', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_thumbs',
            [
                'label' => esc_html__('Show Thumbs', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        //Query
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->update_control(
            'product_limit',
            [
                'default' => 3,
            ]
        );
        $this->end_controls_section();

        $this->register_global_controls_additional();

        $this->start_controls_section(
            'section_marker_image',
            [
                'label' => __('Image Hotspot', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'hotspot_image',
            [
                'label'   => __('Image', 'ultimate-store-kit'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_responsive_control(
            'marker_x_position',
            [
                'label'     => esc_html__('X Postion', 'bdthemes-prime-slider'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot .usk-thumbs-slider {{CURRENT_ITEM}}.swiper-slide' => 'left: {{SIZE}}%;',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'marker_y_position',
            [
                'label'     => esc_html__('Y Postion', 'bdthemes-prime-slider'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot .usk-thumbs-slider {{CURRENT_ITEM}}.swiper-slide' => 'top: {{SIZE}}%;',
                ],
            ]
        );

        $repeater->add_control(
            'marker_tooltip_placement',
            [
                'label'       => esc_html__('Placement', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'top',
                'options'     => [
                    'top-start'    => esc_html__('Top Left', 'bdthemes-prime-slider'),
                    'top'          => esc_html__('Top', 'bdthemes-prime-slider'),
                    'top-end'      => esc_html__('Top Right', 'bdthemes-prime-slider'),
                    'bottom-start' => esc_html__('Bottom Left', 'bdthemes-prime-slider'),
                    'bottom'       => esc_html__('Bottom', 'bdthemes-prime-slider'),
                    'bottom-end'   => esc_html__('Bottom Right', 'bdthemes-prime-slider'),
                    'left'         => esc_html__('Left', 'bdthemes-prime-slider'),
                    'right'        => esc_html__('Right', 'bdthemes-prime-slider'),
                ],
                'render_type' => 'template',
            ]
        );

        $repeater->add_control(
            'advanced_option_toggle',
            [
                'label'        => __('Hotspot Style', 'bdthemes-prime-slider'),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __('None', 'bdthemes-prime-slider'),
                'label_on'     => __('Custom', 'bdthemes-prime-slider'),
                'return_value' => 'yes',
            ]
        );



        $repeater->start_popover();

        $repeater->add_control(
            'repeater_marker_color',
            [
                'label'       => esc_html__('Color', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot' => 'color: {{VALUE}};',
                ],
                'render_type' => 'ui',
                'condition'   => [
                    'advanced_option_toggle' => 'yes',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'        => 'repeater_marker_background',
                'selector'    => '{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot',
                'render_type' => 'ui',
                'condition'   => [
                    'advanced_option_toggle' => 'yes',
                ],
            ]
        );

        $repeater->end_popover();

        $this->add_control(
            'markers',
            [
                'label'       => esc_html__('Hotspot Items', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'marker_x_position' => [
                            'size' => 50,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 75,
                            'unit' => '%',
                        ],
                    ],
                    [
                        'marker_x_position' => [
                            'size' => 20,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 30,
                            'unit' => '%',
                        ],
                    ],
                    [
                        'marker_x_position' => [
                            'size' => 65,
                            'unit' => '%',
                        ],
                        'marker_y_position' => [
                            'size' => 20,
                            'unit' => '%',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render_image() {
        global $product;
        $settings = $this->get_settings_for_display();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
?>
        <div class="usk-image-wrap">
            <img class="usk-img" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
        </div>
    <?php
    }

    public function render_slider_header() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('image-hotspot', 'class', ['usk-image-hotspot']);
        $id = 'ultimate-store-kit-' . $this->get_id();

        $this->add_render_attribute('image-hotspot', 'id', $id);

        $this->add_render_attribute(
            [
                'image-hotspot' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            "slidesPerView" => isset($settings['product_limit']) ? $settings['product_limit'] : 3,
                            "watchSlidesProgress" => true,
                        ])),
                    ],
                ],
            ]
        );
    ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('image-hotspot'); ?>>
                <div class="swiper usk-main-slider">
                    <div class="swiper-wrapper">
                    <?php
                }

                public function render_slider_footer() {
                    $settings = $this->get_settings_for_display();

                    $thumb_url = Group_Control_Image_Size::get_attachment_image_src($settings['hotspot_image']['id'], 'full', $settings);
                    if (!$thumb_url) {
                        $thumb_url = $settings['hotspot_image']['url'];
                    }

                    ?>
                    </div>
                </div>

                <!-- thumbsslider -->
                <?php if ($settings['show_thumbs']): ?>
                    <div thumbsSlider="" class="usk-thumbs-slider swiper" style="background-image: url(<?php echo esc_url($thumb_url); ?>);">
                        <div class="swiper-wrapper">
                            <?php $this->render_thumbs_item(); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- thumbsslider -->
            </div>
        </div>
        <?php
                }

                public function print_price_output($output) {
                    $tags = [
                        'del' => ['aria-hidden' => []],
                        'span' => ['class' => []],
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
                            $categories = str_replace(',', '', wc_get_product_category_list($product->get_id()));

            ?>
                <div class="swiper-slide usk-item <?php esc_attr_e($have_rating, 'ultimate-store-kit'); ?>">
                    <div class="usk-item-box">
                        <?php $this->render_image(); ?>
                        <div class="usk-content">
                            <div class="usk-content-inner">
                                <?php if ('yes' == $settings['show_category']) : ?>
                                    <?php printf('<%1$s class="usk-category">%2$s</%1$s>', esc_attr($settings['category_tags']), wp_kses_post($categories)); ?>
                                <?php endif; ?>
                                <?php if ('yes' == $settings['show_title']) : ?>
                                    <?php printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title())); ?>
                                <?php endif; ?>
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
                        </div>
                    </div>
                </div>
            <?php endwhile;
                        wp_reset_postdata();
                    } else {
                        echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                    }
                }

                public function render_thumbs_item() {
                    $settings = $this->get_settings_for_display();

                    $hotspots = $settings['markers']; // Retrieve hotspots

                    $unique_ids = []; // Initialize an array to store unique IDs

                    if ($hotspots) {
                        foreach ($hotspots as $hotspot) {
                            $unique_ids[] = $hotspot['_id']; // Collect unique IDs
                        }
                    }

                    $this->query_product();
                    $wp_query = $this->get_query();

                    if ($wp_query->have_posts()) {
                        $index = 0;
            ?>
            <?php while ($wp_query->have_posts()): $wp_query->the_post();
                            global $product;
                            $id = $product->get_id();
                            $unique_id_class = isset($unique_ids[$index]) ? esc_attr($unique_ids[$index]) : '';


            ?>
                <div class="swiper-slide usk-item  elementor-repeater-item-<?php echo esc_attr($unique_id_class); ?>">
                    <div class="usk-item-box">
                        <?php $this->render_image(); ?>
                    </div>
                </div>
<?php
                            $index++;
                        endwhile;
                        wp_reset_postdata();
                    } else {
                        echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
                    }
                }

                public function render() {
                    $this->render_slider_header();
                    $this->render_loop_item();
                    $this->render_slider_footer();
                }
                public function query_product() {
                    $default = $this->getGroupControlQueryArgs();
                    $this->_query = new WP_Query($default);
                }
            }
