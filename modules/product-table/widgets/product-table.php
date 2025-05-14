<?php

namespace UltimateStoreKit\Modules\ProductTable\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\Traits\Global_Widget_Controls;
use UltimateStoreKit\Classes\Utils;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Product_Table extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;
    // use Global_Widget_Template;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-product-table';
    }

    public function get_title() {
        return esc_html__('Product Table', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-table';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'product-table', 'table', 'wc'];
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['datatables', 'micromodal', 'usk-site'];
        } else {
            return ['datatables', 'micromodal', 'usk-product-table'];
        }
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'datatables', 'usk-product-table'];
        }
    }
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

        $this->add_control(
            'table_header_alignment',
            [
                'label'   => esc_html__('Header Alignment', 'ultimate-store-kit'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table th' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'table_data_alignment',
            [
                'label'   => esc_html__('Data Alignment', 'ultimate-store-kit'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table td' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'show_searching',
            [
                'label'   => esc_html__('Search', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'   => esc_html__('Paginatioin', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_info',
            [
                'label'   => esc_html__('Footer Info', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_change_length',
            [
                'label'   => esc_html__('Length Select Field', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'show_pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_ordering',
            [
                'label'   => esc_html__('Ordering', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
        $this->add_control(
            'orderColumn',
            [
                'label'   => esc_html__('Order by', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'separator' => 'before',
                'default' => 'default',
                'options' => [
                    'default'  => esc_html__('Default', 'ultimate-store-kit'),
                    'title'  => esc_html__('Title', 'ultimate-store-kit'),
                    'description' => esc_html__('Description', 'ultimate-store-kit'),
                    'categories' => esc_html__('Categories', 'ultimate-store-kit'),
                    'price' => esc_html__('Price', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'orderColumnQry',
            [
                'label'   => esc_html__('Order', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'desc' => esc_html__('Descending', 'ultimate-store-kit'),
                    'asc'  => esc_html__('Ascending', 'ultimate-store-kit'),
                ],
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
            'show_thumb',
            [
                'label'   => esc_html__('Show Thumbnail', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'open_thumb_in_lightbox',
            [
                'label'      => esc_html__('Open Thumb in Lightbox', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => esc_html__('Title', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_tags',
            [
                'label'   => __('Title HTML Tag', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label'     => esc_html__('Description', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'description_limit',
            [
                'label'      => esc_html__('Description Limit', 'ultimate-store-kit'),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 10,
                'condition' => [
                    'show_description' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label'   => esc_html__('Rating', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label'   => esc_html__('Price', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label'     => esc_html__('Categories', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_tags',
            [
                'label'     => esc_html__('Tags', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_quantity',
            [
                'label'   => esc_html__('Quantity', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_cart',
            [
                'label'   => esc_html__('Add to Cart', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_quick_view',
            [
                'label'   => esc_html__('Quick View', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_hide_options_separator',
            [
                'label'     => esc_html__('SHOW / HIDE', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'thumbs_hide_on',
            [
                'label'       => __('Thumbs hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_thumb' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'title_hide_on',
            [
                'label'       => __('Title hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'description_hide_on',
            [
                'label'       => __('Description hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_description' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'categories_hide_on',
            [
                'label'       => __('Categories hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_categories' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'tags_hide_on',
            [
                'label'       => __('Tags hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_tags' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'rating_hide_on',
            [
                'label'       => __('Rating hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_rating' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'price_hide_on',
            [
                'label'       => __('Price hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_categories' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'quick_view_hide_on',
            [
                'label'       => __('Quick View hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_quick_view' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'quantity_hide_on',
            [
                'label'       => __('Quantity hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_quantity' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'cart_hide_on',
            [
                'label'       => __('Add to Cart hide on', 'ultimate-store-kit'),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'options'     => [
                    'desktop' => __('Desktop', 'ultimate-store-kit'),
                    'tablet'  => __('Tablet', 'ultimate-store-kit'),
                    'mobile'  => __('Mobile', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_cart' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_table',
            [
                'label'     => esc_html__('Table', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'table_header_heading',
            [
                'label'     => esc_html__('Header', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'table_heading_color',
            [
                'label'     => esc_html__('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'table_heading_background',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table th' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'table_header_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-wc-products table th',
            ]
        );

        $this->add_control(
            'cell_border',
            [
                'label'     => esc_html__('Cell Border', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Show', 'ultimate-store-kit'),
                'label_off' => esc_html__('Hide', 'ultimate-store-kit'),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cell_border_width',
            [
                'label'   => __('Border Width', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table th' => 'border-width: {{SIZE}}px !important;',
                    '{{WRAPPER}} .usk-wc-products table td' => 'border-width: {{SIZE}}px;',
                ],
                'condition' => [
                    'cell_border' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cell_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table td'                  => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .usk-wc-products table th'                  => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .usk-wc-products table.dataTable.no-footer' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'cell_border' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'table_cell_padding',
            [
                'label'      => esc_html__('Cell Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products table.usk-wc-product td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_effect',
            [
                'label'     => esc_html__('Hover Effect', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'stripe',
            [
                'label'     => esc_html__('stripe', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
            ]
        );

        $this->start_controls_tabs('tabs_table_style');
        $this->start_controls_tab(
            'tab_table_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
                'condition' => [
                    'stripe' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'table_odd_row_background',
            [
                'label'     => esc_html__('Odd Row Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table.dataTable.stripe tbody tr.odd' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'table_even_row_background',
            [
                'label'     => esc_html__('Even Row Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table.dataTable.stripe tbody tr.even' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_table_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
                'condition' => [
                    'stripe' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'table_odd_row_hover_background',
            [
                'label'     => esc_html__('Row Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products table.dataTable.stripe tbody tr:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'stripe' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_search_field_style',
            [
                'label' => esc_html__('Search Field', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_searching' => 'yes'
                ]
            ]
        );

        //Label heading
        $this->add_control(
            'search_text_color_heading',
            [
                'label'     => esc_html__('Label', 'ultimate-store-kit'),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'search_text_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .dataTables_filter label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'search_text_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-wc-products .dataTables_filter label',
            ]
        );

        $this->add_responsive_control(
            'search_spacing',
            [
                'label'     => esc_html__('Bottom Spacing', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .dataTables_filter' => 'margin-bottom: {{SIZE}}px;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_search_field_style');
        $this->start_controls_tab(
            'tab_search_field_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'search_field_text_color',
            [
                'label'     => esc_html__('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_background_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'search_field_border',
                'label'       => esc_html__('Border', 'ultimate-store-kit'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .usk-wc-products input[type*="search"], {{WRAPPER}} .usk-wc-products select',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'search_field_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'search_field_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'search_field_typography',
                'selector' => '{{WRAPPER}} .usk-wc-products input[type*="search"]',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_search_field_focus',
            [
                'label' => esc_html__('Focus', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'search_field_focus_text_color',
            [
                'label'     => esc_html__('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_focus_background_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_focus_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_focus_border_width',
            [
                'label'   => __('Border Width', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]:focus' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'search_field_focus_border_radius',
            [
                'label'   => __('Border Radius', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products input[type*="search"]:focus' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_select_field_style',
            [
                'label'     => esc_html__('Length Select Field', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_change_length' => 'yes'
                ]
            ]
        );

        $this->start_controls_tabs('tabs_select_field_style');

        $this->start_controls_tab(
            'tab_select_field_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'select_field_text_color',
            [
                'label'     => esc_html__('Number Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products select'   => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'select_text_color',
            [
                'label'     => esc_html__('Label Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .dataTables_length label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_field_background_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'select_field_border',
                'label'       => esc_html__('Border', 'ultimate-store-kit'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .usk-wc-products select',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'select_field_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'select_field_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'select_text_typography',
                'selector'  => '{{WRAPPER}} .usk-wc-products .dataTables_length label, {{WRAPPER}} .usk-wc-products .dataTables_length label select',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_select_field_focus',
            [
                'label' => esc_html__('Focus', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'select_field_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'select_field_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products select:focus'   => 'border-color: {{VALUE}};',
                ],
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
                'condition' => [
                    'show_thumb' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'label'    => esc_html__('Image Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-wc-products .usk-wc-product-image img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'    => 'image_shadow',
                'exclude' => [
                    'shadow_position',
                ],
                'selector' => '{{WRAPPER}} .usk-wc-products .usk-wc-product-image img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Title', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-title .usk-wc-product-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_title_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-title .usk-wc-product-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // $this->add_responsive_control(
        //     'title_margin',
        //     [
        //         'label'      => esc_html__('Margin', 'ultimate-store-kit'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', '%'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-title .usk-wc-product-title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-title .usk-wc-product-title a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label'     => esc_html__('Description', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-description .usk-wc-product-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-description .usk-wc-product-description',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_categories',
            [
                'label'      => esc_html__('Categories', 'ultimate-store-kit'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_categories' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'categories_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-categories .usk-wc-product-categories a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'categories_hover_color',
            [
                'label'     => esc_html__('Hover Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-categories .usk-wc-product-categories a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'categories_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-categories .usk-wc-product-categories a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tags',
            [
                'label'      => esc_html__('Tags', 'ultimate-store-kit'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_tags' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'tags_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-product-tags'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-wc-product-tags a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tags_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-wc-product-tags, {{WRAPPER}} .usk-wc-product-tags a',
            ]
        );

        $this->end_controls_section();

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

        $this->add_control(
            'rating_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .star-rating:before' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'active_rating_color',
            [
                'label'     => esc_html__('Active Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFCC00',
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .star-rating span' => 'color: {{VALUE}};',
                ],
            ]
        );

        // $this->add_responsive_control(
        //     'rating_margin',
        //     [
        //         'label'      => esc_html__('Margin', 'ultimate-store-kit'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', '%'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .usk-wc-products .star-rating span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_price',
            [
                'label'     => esc_html__('Price', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_price' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'regular_price_color',
            [
                'label'     => esc_html__('Regular Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price del .woocommerce-Price-amount.amount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-wc-products .usk-item .usk-content .usk-wc-product .usk-wc-product-price del' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'sale_price_color',
            [
                'label'     => esc_html__('Sale Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price'                                        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price ins span'                               => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price .woocommerce-Price-amount.amount'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price > .woocommerce-Price-amount.amount bdi' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sale_price_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '
                {{WRAPPER}} .usk-wc-products .usk-wc-product .usk-wc-product-price .price',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_quick_view',
            [
                'label'     => esc_html__('Quick View', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quick_view' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_quick_view_style');

        $this->start_controls_tab(
            'tab_quick_view_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'quick_view_text_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'quick_view_background_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'quick_view_border',
                'label'       => esc_html__('Border', 'ultimate-store-kit'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'quick_view_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'quick_view_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'quick_view_shadow',
                'selector' => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'quick_view_typography',
                'selector'  => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview i',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_quick_view_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'quick_view_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'quick_view_background_hover_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'quick_view_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'quick_view_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-quick-view-title .usk-shoping-icon-quickview:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'section_syle_quantity',
            [
                'label' => esc_html__('Quantity', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_quantity' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'quantity_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-quantity .quantity input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'quantity_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-quantity .quantity input' => 'border-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'quantity_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-quantity .quantity input',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Cart', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_cart' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'label'       => esc_html__('Border', 'ultimate-store-kit'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_fullwidth',
            [
                'label'     => esc_html__('Fullwidth Cart', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products .usk-wc-add-to-cart .button' => 'width: 100%;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_shadow',
                'selector' => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                //'scheme'    => Schemes\Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Text Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => esc_html__('Background Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-products-table .usk-wc-product .usk-wc-add-to-cart .button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label'     => esc_html__('Footer', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_datatable_footer_style');

        $this->start_controls_tab(
            'tab_datatable_pagination',
            [
                'label' => esc_html__('Pagination', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'pagination_spacing',
            [
                'label'     => esc_html__('Spacing', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .usk-wc-product'    => 'margin-bottom: {{SIZE}}px;',
                    // '{{WRAPPER}} .dataTables_paginate' => 'margin-top: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.usk-pagination li a'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} ul.usk-pagination li span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .paginate_button'          => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'active_pagination_color',
            [
                'label'     => esc_html__('Active Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.usk-pagination li.usk-active a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .paginate_button.current'          => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_margin',
            [
                'label'     => esc_html__('Margin', 'ultimate-store-kit'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ul.usk-pagination li a'    => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    '{{WRAPPER}} ul.usk-pagination li span' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    '{{WRAPPER}} .paginate_button'          => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} ul.usk-pagination li a, {{WRAPPER}} ul.usk-pagination li span, {{WRAPPER}} .dataTables_paginate',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_datatable_info',
            [
                'label' => __('Page Info', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'info_spacing',
            [
                'label'     => esc_html__('Spacing', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .dataTables_info' => 'margin-top: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dataTables_info' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'info_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .dataTables_info',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function render_query() {
        $settings = $this->get_settings_for_display();

        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $exclude_products = ($settings['exclude_products']) ? explode(',', $settings['exclude_products']) : [];

        $query_args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'posts_per_page'      => $settings['posts_per_page'],
            'ignore_sticky_posts' => 1,
            'meta_query'          => [],
            'tax_query'           => ['relation' => 'AND'],
            'paged'               => $paged,
            //'order'               => $settings['order'],
            'post__not_in'        => $exclude_products,
        );

        $product_visibility_term_ids = wc_get_product_visibility_term_ids();


        if ('by_name' === $settings['source'] and !empty($settings['product_categories'])) {
            $query_args['tax_query'][] = [
                'taxonomy'           => 'product_cat',
                'field'              => 'slug',
                'terms'              => $settings['product_categories'],
                'post__not_in'       => $exclude_products,
            ];
        }

        if ('yes' == $settings['hide_free']) {
            $query_args['meta_query'][] = [
                'key'     => '_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'DECIMAL',
            ];
        }

        if ('yes' == $settings['hide_out_stock']) {
            $query_args['tax_query'][] = [
                [
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['outofstock'],
                    'operator' => 'NOT IN',
                ],
            ]; // WPCS: slow query ok.
        }


        switch ($settings['show_product_type']) {
            case 'featured':
                $query_args['tax_query'][] = [
                    'taxonomy' => 'product_visibility',
                    'field'    => 'term_taxonomy_id',
                    'terms'    => $product_visibility_term_ids['featured'],
                ];
                break;
            case 'onsale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
        }

        return new WP_Query($query_args);
    }

    public function render_header() {


        $settings = $this->get_settings();
        $id = $this->get_id();
        $page_length = (isset($settings['show_per_page']) && !empty($settings['show_per_page'])) ? $settings['show_per_page'] : '10';


        $this->add_render_attribute('wc-products', 'class', ['usk-wc-products', 'usk-wc-products-table']);

        $this->add_render_attribute(
            [
                'wc-products' => [
                    'data-settings' => [
                        wp_json_encode([
                            "order"         => [],
                            'paging'        => ($settings['show_pagination'] == 'yes') ? true : false,
                            // 'paging'        => isset($settings['show_pagination']) == 'yes' ? true : false,
                            'info'          => ($settings['show_info'] == 'yes') &&  ($settings['show_pagination'] == 'yes') ? true : false,
                            'bLengthChange' => ($settings['show_change_length']) ? true : false,
                            'searching'     => ($settings['show_searching'] == 'yes') ? true : false,
                            'ordering'      => ($settings['show_ordering']) ? true : false,
                            'pageLength'    => (int) $page_length,
                            'orderColumn'   => $settings['orderColumn'],
                            'orderColumnQry' => $settings['orderColumnQry'],
                            // 'hideHeader'    => (!empty($settings['hide_header']) ? $settings['hide_header'] : 'no'),
                        ])
                    ]
                ]
            ]
        );

?>
        <div <?php $this->print_render_attribute_string('wc-products'); ?>>

            <?php

        }

        public function render_loop_item() {
            $settings = $this->get_settings();
            $id = 'usk-wc-products-table-' . $this->get_id();

            // $wp_query = $this->render_query();
            $this->query_product();
            $wp_query = $this->get_query();


            if ($wp_query->have_posts()) {

                $this->add_render_attribute('wc-product-table', 'class', ['usk-table-middle', 'usk-wc-product', 'usk-table', 'usk-table-striped']);

                $this->add_render_attribute('wc-product-table', 'id', esc_attr($id));

                if ($settings['cell_border']) {
                    $this->add_render_attribute('wc-product-table', 'class', 'cell-border');
                }

                if ($settings['stripe']) {
                    $this->add_render_attribute('wc-product-table', 'class', 'stripe');
                }

                if ($settings['hover_effect']) {
                    $this->add_render_attribute('wc-product-table', 'class', 'hover');
                }

                $this->add_render_attribute('usk-wc-product-title', 'class', 'usk-wc-product-title');
                $title_hide_on = ultimate_store_kit_hide_on_class($settings['title_hide_on']);
                $this->add_render_attribute('usk-title', ['class' => ['usk-title', $title_hide_on]], true);

                $thumbs_hide_on = ultimate_store_kit_hide_on_class($settings['thumbs_hide_on']);
                $this->add_render_attribute('usk-thumb', ['class' => ['usk-thumb', $thumbs_hide_on]], true);

                $description_hide_on = ultimate_store_kit_hide_on_class($settings['description_hide_on']);
                $this->add_render_attribute('usk-description', ['class' => ['usk-description', $description_hide_on]], true);

                $categories_hide_on = ultimate_store_kit_hide_on_class($settings['categories_hide_on']);
                $this->add_render_attribute('usk-categories', ['class' => ['usk-categories', 'usk-product-table-align', $categories_hide_on]], true);

                $tags_hide_on = ultimate_store_kit_hide_on_class($settings['tags_hide_on']);
                $this->add_render_attribute('usk-tags', ['class' => ['usk-tags', 'usk-product-table-align', $tags_hide_on]], true);

                $rating_hide_on = ultimate_store_kit_hide_on_class($settings['rating_hide_on']);
                $this->add_render_attribute('usk-rating', ['class' => ['usk-rating', 'usk-product-table-align', $rating_hide_on]], true);

                $price_hide_on = ultimate_store_kit_hide_on_class($settings['price_hide_on']);
                $this->add_render_attribute('usk-price', ['class' => ['usk-price', 'usk-product-table-align', $price_hide_on]], true);

                $quick_view_hide_on = ultimate_store_kit_hide_on_class($settings['quick_view_hide_on']);
                $this->add_render_attribute('usk-quick-view', ['class' => ['usk-quick-view-title', 'usk-product-table-align', $quick_view_hide_on]], true);

                $quantity_hide_on = ultimate_store_kit_hide_on_class($settings['quantity_hide_on']);
                $this->add_render_attribute('usk-quantity', ['class' => ['usk-quantity', 'usk-product-table-align', $quantity_hide_on]], true);

                $cart_hide_on = ultimate_store_kit_hide_on_class($settings['cart_hide_on']);
                $this->add_render_attribute('usk-cart', ['class' => ['usk-cart', 'usk-product-table-align', $cart_hide_on]], true);


            ?>
                <table <?php $this->print_render_attribute_string('wc-product-table'); ?>>
                    <thead>
                        <tr>
                            <?php if ($settings['show_thumb']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-thumb'); ?> data-orderable="false"><?php esc_html_e('Image', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_title']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-title'); ?>>
                                    <?php esc_html_e('Title', 'ultimate-store-kit'); ?>
                                </th>
                            <?php endif; ?>

                            <?php if ($settings['show_description']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-description'); ?>><?php esc_html_e('Description', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>


                            <?php if ($settings['show_categories']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-categories'); ?>><?php esc_html_e('Categories', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_tags']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-tags'); ?> data-orderable="false"><?php esc_html_e('Tags', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_rating']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-rating'); ?> data-orderable="false"><?php esc_html_e('Rating', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_price']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-price'); ?>><?php esc_html_e('Price', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_quick_view']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-quick-view'); ?> data-orderable="false"><?php esc_html_e('Quick View', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_quantity']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-quantity'); ?> data-orderable="false"><?php esc_html_e('Quantity', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                            <?php if ($settings['show_cart']) : ?>
                                <th <?php $this->print_render_attribute_string('usk-cart'); ?> data-orderable="false"><?php esc_html_e('Cart', 'ultimate-store-kit'); ?></th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            <?php global $product;
                            $average = $product->get_average_rating();
                            $rating_count = $product->get_rating_count();
                            ?>
                            <tr>
                                <?php if ($settings['show_thumb']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-thumb'); ?>>
                                        <?php $this->render_image($settings); ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_title']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-title'); ?>>
                                        <<?php echo esc_attr(Utils::get_valid_html_tag($settings['title_tags'])); ?> <?php $this->print_render_attribute_string('usk-wc-product-title'); ?>>
                                            <a href="<?php the_permalink(); ?>" class="usk-link-reset">
                                                <?php the_title(); ?>
                                            </a>
                                        </<?php echo esc_attr(Utils::get_valid_html_tag($settings['title_tags'])); ?>>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_description']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-description'); ?>>
                                        <div class="usk-wc-product-description">
                                            <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), $settings['description_limit'], '...')); ?>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_categories']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-categories'); ?>>
                                        <span class="usk-wc-product-categories">
                                            <?php echo wp_kses_post(wc_get_product_category_list(get_the_ID(), ' ', '<span>', '</span>')); ?>
                                        </span>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_tags']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-tags'); ?>>
                                        <span class="usk-wc-product-tags">
                                            <?php echo wp_kses_post(wc_get_product_tag_list(get_the_ID(), ', ', '<span>', '</span>')); ?>
                                        </span>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_rating']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-rating'); ?>>
                                        <div class="usk-wc-rating">
                                            <?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?>
                                        </div>
                                    </td>
                                <?php endif; ?>


                                <?php if ($settings['show_price']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-price'); ?> data-order="<?php echo esc_attr($product->get_price()); ?>">
                                        <span class="usk-wc-product-price">
                                            <?php woocommerce_template_single_price(); ?>
                                        </span>
                                    </td>
                                <?php endif; ?>


                                <?php if ($settings['show_quick_view']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-quick-view'); ?>>
                                        <?php $this->register_global_template_quick_view($product->get_id(), 'top', $settings) ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_quantity']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-quantity'); ?>>
                                        <div class="usk-wc-quantity">
                                            <?php if ($product->is_purchasable() and $product->is_in_stock()) { ?>
                                                <?php if ($product->is_type('simple')) : ?>
                                                    <?php woocommerce_quantity_input(); ?>
                                                <?php endif; ?>
                                            <?php } else {
                                                echo esc_html($product->get_stock_status());
                                            } ?>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <?php if ($settings['show_cart']) : ?>
                                    <td <?php $this->print_render_attribute_string('usk-cart'); ?>>
                                        <div class="usk-wc-add-to-cart">
                                            <?php woocommerce_template_loop_add_to_cart(); ?>
                                        </div>
                                    </td>
                                <?php endif; ?>

                            </tr>

                        <?php endwhile;
                        wp_reset_postdata(); ?>

                    </tbody>
                </table>
            <?php

            } else {
                echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There is no product', 'ultimate-store-kit') . '<div>';
            }
        }

        public function render_image($settings) {
            $this->add_render_attribute('product_image_wrapper', 'class', 'usk-wc-product-image usk-display-inline-block', true);

            if ('yes' === $settings['open_thumb_in_lightbox']) {
                $this->add_render_attribute('product_image', 'data-elementor-open-lightbox', 'yes', true); // no
                $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                $this->add_render_attribute('product_image', 'href', $img_url[0], true);
                //$this->add_render_attribute( 'product_image_wrapper', 'usk-lightbox', '' );
            } else {
                $this->add_render_attribute('product_image', 'href', get_the_permalink(), true);
            }

            ?>
            <div <?php $this->print_render_attribute_string('product_image_wrapper'); ?>>
                <a <?php $this->print_render_attribute_string('product_image'); ?>>
                    <img src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'thumbnail')); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
                </a>
            </div>
        <?php
        }

        public function render_footer() {
        ?>
        </div>
<?php
        }

        public function render() {
            $this->render_header();
            $this->render_loop_item();
            $this->render_footer();
        }
        public function query_product() {
            $default = $this->getGroupControlQueryArgs();
            $this->_query = new WP_Query($default);
        }
    }
