<?php

namespace UltimateStoreKit\Modules\ProductFilter\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Product_Filter extends Module_Base {

    public function get_name() {
        return 'usk-product-filter';
    }

    public function get_title() {
        return esc_html__('Filter', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-filter usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-archive'];
    }

    public function get_keywords() {
        return ['product', 'product-filter', 'table', 'wc'];
    }

    // public function get_script_depends() {
    //     return ['micromodal'];
    // }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-filter'];
        }
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_filter_item',
            [
                'label' => esc_html__('Filter Item', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'filter_taxonomies',
            [
                'label' => esc_html__('Taxonomies', ''),
                'type' => Controls_Manager::SELECT,
                'default' => 'product_cat',
                'options' => usk_get_taxonomies(),
            ]
        );
        $repeater->add_control(
            'filter_label',
            [
                'label'       => esc_html__('Label', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Filter By...', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'sorting_item_list',
            [
                'label' => esc_html__('Sorting List', 'ultimate-store-kit'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'filter_label'      => esc_html__('Filter By Search', 'ultimate-store-kit'),
                        'filter_taxonomies' => 'search',
                    ],
                    [
                        'filter_label'      => esc_html__('Filter By Price', 'ultimate-store-kit'),
                        'filter_taxonomies' => 'price',
                    ],
                    [
                        'filter_label'      => esc_html__('Filter By Category', 'ultimate-store-kit'),
                        'filter_taxonomies' => 'product_cat',
                    ],
                ],
                'title_field' => '{{{filter_label}}}',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_compare_button_style',
            [
                'label' => esc_html__('Content', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'content_spacing',
            [
                'label' => esc_html__('Spacing', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'selectors' => [
                    '{{WRAPPER}}  .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap' => 'padding: {{SIZE}}{{UNIT}} 0px;',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'content_section_title',
            [
                'label' => esc_html__('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-title .usk-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'title_bg_color',
                'label' => esc_html__('Backgorund', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-title .usk-title',
            ]
        );
        $this->add_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-title .usk-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_radius',
            [
                'label' => esc_html__('Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-title .usk-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typogaphy', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-title .usk-title',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_filter_label',
            [
                'label' => esc_html__('Label', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content div label span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content div label span',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_search',
            [
                'label' => esc_html__('Search', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'search_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter-search .usk-filter-search input' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'search_bg_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter-search .usk-filter-search input' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'search_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter-search .usk-filter-search input',
            ]
        );
        $this->add_control(
            'heading_search_icon',
            [
                'label' => esc_html__('Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'search_icon_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter-search .usk-filter-search button i' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_badge',
            [
                'label' => esc_html__('Badge', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'badge_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content div .usk-term-count' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'badge_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content div .usk-term-count' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_price',
            [
                'label' => esc_html__('Price', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'price_style_layout',
            [
                'label' => esc_html__('Display', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'usk-block-layout',
                'options' => [
                    'usk-inline-layout' => esc_html__('Inline', 'ultimate-store-kit'),
                    'usk-block-layout' => esc_html__('Block', 'ultimate-store-kit'),
                ],
            ]
        );
        $this->add_control(
            'price_label_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content .usk-range-value .usk-range-input label' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content .usk-range-value .usk-range-input .usk-currency' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_label_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-filters-content-wrapper .usk-single-filter .usk-single-filter-wrap .usk-filter-content .usk-range-value .usk-range-input',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'style_section_button',
            [
                'label' => esc_html__('Button', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'action_btn_tabs'
        );
        $this->start_controls_tab(
            'action_btn_submit',
            [
                'label' => esc_html__('Submit', 'utlimate-store-kit'),
            ]
        );
        $this->add_control(
            'submit_btn_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'submit_btn_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'submit_btn_hover_heading',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'submit_btn_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'submit_btn_hover_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'submit_btn_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'submit_btn_radius',
            [
                'label' => esc_html__('Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_btn_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-submit button',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'action_btn_reset',
            [
                'label' => esc_html__('Reset', 'utlimate-store-kit'),
            ]
        );
        $this->add_control(
            'reset_btn_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'reset_btn_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'reset_btn_hover_heading',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'reset_btn_hover_color',
            [
                'label' => esc_html__('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'reset_btn_hover_bg_color',
            [
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'reset_btn_padding',
            [
                'label' => esc_html__('Padding', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'reset_btn_radius',
            [
                'label' => esc_html__('Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'reset_btn_typography',
                'label' => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-filter .usk-action-btn-wrapper .usk-filter-reset .usk-reset-btn',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    public function render_search_field() {
        $section_id = $this->get_raw_data()['id']; ?>
        <div class="usk-single-filter-search usk-single-filter-<?php echo $section_id; ?>">
            <div class="usk-filter-search usk-single-filter-<?php echo $section_id; ?>">
                <?php
                $input = isset($_GET['q']) ? $_GET['q'] : '';
                printf('<input type="search" class="usk-radio" name="q" value="%1$s" placeholder="search"><button><i class="icon eicon-search"></i></button>', $input);
                ?>
            </div>
        </div>
    <?php
    }
    public function render_sortby_field() {
        $section_id = $this->get_raw_data()['id']; ?>
        <div class="usk-filter-content  usk-item-content-<?php echo $section_id; ?>">
            <?php
            $sort_options = usk_get_order_options();
            foreach ($sort_options as $key => $sort_option) :
                if (isset($_GET['filter']['orderby'])) {
                    $checked = checked($key, $_GET['filter']['orderby'], false);
                } else {
                    $checked = '';
                }
                printf('<div><input type="radio" class="usk-radio-btn" id="%1$s" name="filter[orderby]" value="%1$s" %2$s><label for="%1$s" class="usk-term-label"><span>%3$s</span></label></div>', $key, $checked, $sort_option);
            endforeach; ?>
        </div>
    <?php
    }
    public function render_orderby_field() {
        $section_id = $this->get_raw_data()['id']; ?>
        <div class="usk-filter-content  usk-item-content-<?php echo $section_id; ?>">
            <?php
            if (!empty($_GET['filter']['order'])) {
                $checked = $_GET['filter']['order'];
                if ('ASC' == $checked) {
                    $asc = 'checked';
                    $desc = '';
                } else {
                    $desc = 'checked';
                    $asc = '';
                }
            } else {
                $asc = '';
                $desc = 'checked';
            }
            printf('<div><input id="order_asc" class="usk-radio-btn"name="filter[order]" type="radio" %1$s value="%2$s"><label for="order_asc" class="usk-radio-btn-label"><span>%2$s</span></label></div>', $asc, __('ASC', 'ultimate-store-kit'));
            printf('<div><input id="order_desc" class="usk-radio-btn"name="filter[order]" type="radio" %1$s value="%2$s"><label for="order_desc" class="usk-radio-btn-label"><span>%2$s</span></label></div>', $desc, __('DESC', 'ultimate-store-kit'));
            ?>
        </div>
    <?php
    }
    public function render_price_field() {
        $settings = $this->get_settings_for_display();
        $section_id = $this->get_raw_data()['id']; ?>
        <div class="usk-filter-content  usk-item-content-<?php echo $section_id; ?>">
            <?php
            $min_price = isset($_GET['filter']['min_price']) ? $_GET['filter']['min_price'] : false;
            $max_price = isset($_GET['filter']['min_price']) ? $_GET['filter']['max_price'] : false;
            if ($settings['price_style_layout'] == 'usk-inline-layout') {
                $placeholer_min = 'min';
                $placeholer_max = 'max';
            } else {
                $placeholer_min = '0';
                $placeholer_max = '300';
            }
            ?>
            <div class="usk-range-value <?php esc_attr_e($settings['price_style_layout'], 'ultimate-store-kit'); ?>">
                <div class="usk-range-input">
                    <span class="usk-currency"><?php echo get_woocommerce_currency_symbol(); ?></span>
                    <input type="number" class="usk-input-price" id="min_price" name="filter[min_price]" value="<?php echo $min_price; ?>" placeholder="<?php esc_attr_e($placeholer_min, 'ultimate-store-kit'); ?>" min="0">
                    <label for="min_price"><?php esc_html_e('Min', 'ultimate-store-kit'); ?></label>
                </div>
                <div class="usk-range-input">
                    <span class="usk-currency"><?php echo get_woocommerce_currency_symbol(); ?></span>
                    <input type="number" class="usk-input-price" id="max_price" name="filter[max_price]" value="<?php echo $max_price; ?>" placeholder="<?php esc_attr_e($placeholer_max, 'ultimate-store-kit'); ?>" min="0">
                    <label for="max_price"><?php esc_html_e('Max', 'ultimate-store-kit'); ?></label>
                </div>
            </div>
        </div>
    <?php
    }
    public function render() {
        global $wp;
        $settings = $this->get_settings_for_display();
        $section_id = $this->get_raw_data()['id'];
        $form_action = preg_replace('%\/page/[0-9]+%', '', home_url($wp->request)); ?>
        <form method="get" action="<?php esc_attr($form_action); ?>">
            <div class="usk-filter usk-filter-vertical">
                <div class="usk-filters-content-wrapper">
                    <?php foreach ($settings['sorting_item_list'] as $taxonomies) :
                        $taxonomy = get_taxonomy($taxonomies['filter_taxonomies']);
                        $terms = get_terms($taxonomies['filter_taxonomies']);
                    ?>
                        <?php if ($taxonomy !== false && count($terms) > 0) : ?>
                            <div class="usk-single-filter usk-single-filter-<?php echo $section_id; ?>">
                                <div class="usk-single-filter-wrap">
                                    <div class="usk-filter-title usk-item usk-item-<?php echo $section_id; ?>">
                                        <?php printf('<h3 class="usk-title">%s</h3>', $taxonomies['filter_label']); ?>
                                    </div>
                                    <div class="usk-filter-content">
                                        <?php
                                        $i = 0;
                                        foreach ($terms as $term) :
                                            // var_dump($term->count);
                                            if (isset($_GET['filter']['taxonomies'][$taxonomy->name]) && in_array($term->slug, $_GET['filter']['taxonomies'][$taxonomy->name])) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }
                                            if ($taxonomy->name === 'pa_color') {
                                                $value = str_replace('-', '', $term->slug);
                                                $backgorund = 'style="background:' . $value . '"';
                                                $class_name = 'usk-color-btn';
                                            } else {
                                                $backgorund = '';
                                                $class_name = '';
                                            }
                                            printf(
                                                '<div>
                                                    <div class="usk-input-wrapper">
                                                    <input type="checkbox" class="usk-checkbox-btn %9$s" id="%1$s" name="filter[taxonomies][%2$s][%3$s]" value="%5$s" %4$s>
                                                    <label for="%1$s" class="usk-term-label"><span>%6$s</span></label>
                                                </div>
                                                <span class="usk-term-count" %8$s>%7$s</span>
                                                </div>',
                                                $taxonomy->labels->singular_name . '_' . $term->slug,
                                                $taxonomy->name,
                                                $i,
                                                $checked,
                                                $term->slug,
                                                $term->name,
                                                $term->count,
                                                $backgorund,
                                                $class_name
                                            );
                                            $i++;
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php
                        if ($taxonomies['filter_taxonomies'] === 'search') : ?>
                            <div class="usk-single-filter usk-single-filter-<?php echo $section_id; ?>">
                                <div class="usk-single-filter-wrap">
                                    <div class="usk-filter-title usk-item usk-item-<?php echo $section_id; ?>">
                                        <h3 class="usk-title"><?php esc_html_e($taxonomies['filter_label'], 'utlimate-store-kit'); ?></h3>
                                    </div>
                                    <div class="usk-filter-search">
                                        <?php
                                        $input = isset($_GET['q']) ? $_GET['q'] : '';
                                        printf('<input type="search" class="usk-radio" name="q" value="%1$s" placeholder="search"><button><i class="icon eicon-search"></i></button>', $input);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endif;
                        if ($taxonomies['filter_taxonomies'] === 'price') : ?>
                            <div class="usk-single-filter usk-single-filter-<?php echo $section_id; ?>">
                                <div class="usk-single-filter-wrap">
                                    <div class="usk-filter-title usk-item usk-item-<?php echo $section_id; ?>">
                                        <h3 class="usk-title"><?php esc_html_e($taxonomies['filter_label'], 'utlimate-store-kit'); ?></h3>
                                    </div>
                                    <?php $this->render_price_field(); ?>
                                </div>
                            </div>
                        <?php
                        endif;
                        if ($taxonomies['filter_taxonomies'] === 'orderby') : ?>
                            <div class="usk-single-filter usk-single-filter-<?php echo $section_id; ?>">
                                <div class="usk-single-filter-wrap">
                                    <div class="usk-filter-title usk-item usk-item-<?php echo $section_id; ?>">
                                        <h3 class="usk-title"><?php esc_html_e($taxonomies['filter_label'], 'utlimate-store-kit'); ?></h3>
                                    </div>
                                    <?php $this->render_orderby_field(); ?>
                                </div>
                            </div>
                        <?php endif;
                        if ($taxonomies['filter_taxonomies'] === 'order') : ?>
                            <div class="usk-single-filter usk-single-filter-<?php echo $section_id; ?>">
                                <div class="usk-single-filter-wrap">
                                    <div class="usk-filter-title usk-item usk-item-<?php echo $section_id; ?>">
                                        <h3 class="usk-title"><?php esc_html_e($taxonomies['filter_label'], 'utlimate-store-kit'); ?></h3>
                                    </div>
                                    <?php $this->render_sortby_field(); ?>
                                </div>
                            </div>
                    <?php
                        endif;
                    endforeach; ?>
                </div>
                <div class="usk-action-btn-wrapper">
                    <span class="usk-filter-submit">
                        <button type="submit">Submit</button>
                    </span>
                    <span class="usk-filter-reset">
                        <?php
                        printf('<a href="%s" class="usk-reset-btn">Reset</a>', home_url($wp->request));
                        ?>
                    </span>
                </div>
            </div>
        </form>
<?php
    }
}
