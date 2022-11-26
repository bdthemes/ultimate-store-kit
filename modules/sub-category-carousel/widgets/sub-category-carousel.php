<?php

namespace UltimateStoreKit\Modules\SubCategoryCarousel\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Traits\Global_Terms_Query_Controls;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;



if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class Sub_Category_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Terms_Query_Controls;
    use Global_Widget_Template;
    public function get_name() {
        return 'usk-sub-category-carousel';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Sub Category Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-sub-category-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['ultimate-store-kit', 'shop', 'store', 'sub', 'heading', 'product'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-sub-category-carousel'];
        }
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-sub-category-carousel'];
        }
    }
    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label'          => __('Columns', 'ultimate-store-kit'),
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
        $this->add_control(
            'alignment',
            [
                'label'     => __('Title', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'traditional',
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
                'name'    => 'category_thumbnail',
                'label'   => esc_html__('Image Size', 'ultimate-store-kit'),
                'exclude' => ['custom'],
                'default' => 'medium',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_term_query',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs(
            'tabs_terms_include_exclude',
            []
        );
        $this->start_controls_tab(
            'tab_term_include',
            [
                'label' => __('Include', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'cats_include_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => ultimate_store_kit_get_only_parent_cats('product_cat'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_term_exclude',
            [
                'label' => __('Exclude', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'cats_exclude_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => ultimate_store_kit_get_only_parent_cats('product_cat'),
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name'       => esc_html__('Name', 'ultimate-store-kit'),
                    'count'  => esc_html__('Count', 'ultimate-store-kit'),
                    'slug' => esc_html__('Slug', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => __('Descending', 'ultimate-store-kit'),
                    'asc' => __('Ascending', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'hide_empty',
            [
                'label'         => __('Hide Empty', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();
        $this->register_global_controls_carousel_navigation();
        $this->register_global_controls_carousel_settings();

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'item_tabs'
        );
        $this->start_controls_tab(
            'item_tab_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'item_background',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item',
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label'                 => esc_html__('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item',
            ]
        );
        $this->add_responsive_control(
            'item_radius',
            [
                'label'                 => esc_html__('Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item',
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
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_shadow',
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-sub-category-item:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
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
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .usk-image-wrap .usk-img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .usk-image-wrap .usk-img ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // $this->add_group_control(
        //     Group_Control_Box_Shadow::get_type(),
        //     [
        //         'name'     => 'image_shadow',
        //         'exclude'  => [
        //             'shadow_position',
        //         ],
        //         'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-image-slider .usk-image-wrap .usk-img',
        //     ]
        // );

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
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-name:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-category-name',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_sub_category',
            [
                'label' => esc_html__('Sub Category', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_category_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-list li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_sub_category_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-list li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_category_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-category-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-category-list li a',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_all_category',
            [
                'label' => esc_html__('All Category', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'all_category_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_all_category_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'all_category_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'all_category_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-sub-category-carousel .usk-link-btn a',
            ]
        );
        $this->end_controls_section();

        $this->register_global_controls_navigation_style();
    }

    public function render_items() {
        $settings = $this->get_settings_for_display();
        $args = [
            'taxonomy' => 'product_cat',
            'orderby'    => isset($settings['orderby']) ? $settings['orderby'] : 'name',
            'order'      => isset($settings['order']) ? $settings['order'] : 'ASC',
            'hide_empty' => isset($settings['hide_empty']) && ($settings['hide_empty'] == 'yes') ? 0 : 1,
        ];
        if (isset($settings['cats_include_by_id']) && !empty($settings['cats_include_by_id'])) {
            $args['include'] = $settings['cats_include_by_id'];
        }
        if (isset($settings['cats_exclude_by_id']) && !empty($settings['cats_exclude_by_id'])) {
            $args['exclude'] = $settings['cats_exclude_by_id'];
        }
        // print_r($args);
        $taxonomies = get_terms($args);
        if (!(empty($taxonomies))) :
            foreach ($taxonomies as $category) :
                if ($category->parent == 0 && get_term_children($category->term_id, 'product_cat')) :
                    $this->add_render_attribute('sub-category-item', [
                        'class' => [
                            'usk-sub-category-item swiper-slide'
                        ],
                        // 'data-settings' => [
                        //     wp_json_encode(array_filter([
                        //         "autoplay"              => ("yes" == $settings["thumbs_autoplay"]) ? ["delay" => $settings["thumbs_autoplay_speed"]] : false,
                        //         "loop"                  => ($settings["thumbs_loop"] == "yes") ? true : false,
                        //         "speed"                 => $settings["thumbs_slide_speed"]["size"],
                        //         "effect"                => $settings["thumbs_effect"],
                        //     ]))
                        // ]
                    ], null, true);
?>
                    <div <?php $this->print_render_attribute_string('sub-category-item'); ?>>
                        <div class="swiper usk-image-slider">
                            <div class="swiper-wrapper">
                                <?php
                                $parentcategory_thumb_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $images = [$parentcategory_thumb_id];

                                foreach ($taxonomies as $subcategory) :
                                    if ($subcategory->parent == $category->term_id) {
                                        $subcategory_thumb_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                                        $images[] = $subcategory_thumb_id;
                                    }
                                endforeach;

                                foreach ($images as $image_id) :
                                    $img_url     = wp_get_attachment_image_url($image_id, $settings['category_thumbnail_size']);
                                    if (!(empty($img_url))) : ?>
                                        <div class="usk-item swiper-slide">
                                            <a href="#" class="usk-image-wrap">
                                                <img class="usk-img" src="<?php echo $img_url; ?>" />
                                            </a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                        <div class="usk-category-content">

                            <?php printf('<%1$s class="usk-category-name">%2$s</%1$s>', $settings['title_tags'], esc_html($category->name)); ?>
                            <ul class="usk-category-list">
                                <?php
                                foreach ($taxonomies as $key => $subcategory) :
                                    if (($subcategory->parent == $category->term_id) && ($subcategory->count > 0)) {
                                        printf('<li><a href="%1$s">%2$s</a></li>', get_term_link($subcategory->term_id, 'product_cat'), $subcategory->name);
                                    }
                                endforeach;
                                ?>
                            </ul>

                            <div class="usk-link-btn">
                                <?php printf('<a href="%2$s"><span>%1$s</span><i class="eicon-arrow-right"></i>', esc_html('All ' . $category->name . ''), get_term_link($category->term_id, 'product_cat')); ?>
                                </a>
                            </div>
                        </div>
                    </div>
<?php
                endif;
            endforeach;
        endif;
    }
    public function render() {
        $this->register_global_template_carousel_header();
        $this->render_items();
        $this->usk_register_global_template_carousel_footer();
    }
}
