<?php

namespace UltimateStoreKit\Traits;

use Elementor\Controls_Manager;

defined('ABSPATH') || die();
trait Global_Terms_Query_Controls {
    protected function render_terms_query_controls($taxonomy = 'category') {

        $this->start_controls_section(
            'section_term_query',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_category',
            [
                'label' => __('Type', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'all',
                'options' => [
                    'all' => __('All', 'ultimate-store-kit'),
                    'parents' => __('Only Parents', 'ultimate-store-kit'),
                    'child' => __('Only Child', 'ultimate-store-kit')
                ],
            ]
        );

        // $this->add_control(
        // 	'item_limit',
        // 	[
        // 		'label' => esc_html__('Item Limit', 'ultimate-store-kit'),
        // 		'type'  => Controls_Manager::SLIDER,
        // 		'range' => [
        // 			'px' => [
        // 				'min' => 1,
        // 				'max' => 20,
        // 			],
        // 		],
        // 		'default' => [
        // 			'size' => 6,
        // 		],
        // 	]
        // );

        $this->start_controls_tabs(
            'tabs_terms_include_exclude',
            [
                'condition' => ['display_category' => 'all']
            ]
        );
        $this->start_controls_tab(
            'tab_term_include',
            [
                'label' => __('Include', 'ultimate-store-kit'),
                'condition' => ['display_category' => 'all']
            ]
        );

        $this->add_control(
            'cats_include_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'display_category' => 'all'
                ],
                'options' => ultimate_store_kit_get_category($taxonomy),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_term_exclude',
            [
                'label' => __('Exclude', 'ultimate-store-kit'),
                'condition' => ['display_category' => 'all']
            ]
        );

        $this->add_control(
            'cats_exclude_by_id',
            [
                'label' => __('Categories', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'display_category' => 'all'
                ],
                'options' => ultimate_store_kit_get_category($taxonomy),
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'child_cats_notice',
            [
                'type'              => Controls_Manager::RAW_HTML,
                'raw'               => __('WARNING!, Must Select Parent Category from Child Categories of.', 'ultimate-store-kit'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'condition' => [
                    'display_category' => 'child',
                    'parent_cats' => 'none'
                ],
            ],
        );
        $this->add_control(
            'parent_cats',
            [
                'label' => __('Child Categories of', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => ultimate_store_kit_get_only_parent_cats($taxonomy),
                'condition' => [
                    'display_category' => 'child'
                ],
            ]
        );


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
                    // 'menu_order' => esc_html__('Menu Order', 'ultimate-store-kit'),
                    // 'rand'       => esc_html__('Random', 'ultimate-store-kit'),
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
    }
}
