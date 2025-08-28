<?php

namespace UltimateStoreKit\Includes\Controls\GroupQuery;

use Elementor\Controls_Manager;
use UltimateStoreKit\Includes\Controls\SelectInput\Dynamic_Select;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

trait Group_Control_Query
{

	public function register_query_builder_controls()
	{

		$this->add_control(
			'product_source',
			[
				'label'   => __('Source', 'ultimate-store-kit'),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->getGroupControlQueryPostTypes(),
				'default' => 'product',
			]
		);
		$this->add_control(
			'product_limit',
			[
				'label'   => esc_html__('Product Limit', 'ultimate-store-kit'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'product_selected_ids',
			[
				'label'       => __('Search & Select', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'posts',
					'post_type' => 'product',
				],
				'condition'   => [
					'product_source' => 'manual_selection',
				]
			]
		);

		$this->start_controls_tabs(
			'tabs_product_include_exclude',
			[
				'condition' => [
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->start_controls_tab(
			'tab_product_include',
			[
				'label'     => __('Include', 'ultimate-store-kit'),
				'condition' => [
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_by',
			[
				'label'       => __('Include By', 'ultimate-store-kit'),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => [
					'categories' => __('Categories', 'ultimate-store-kit'),
					'tags'       => __('Tags', 'ultimate-store-kit'),
					'brands'     => __('Brands', 'ultimate-store-kit'),
					'attributes' => __('Attributes', 'ultimate-store-kit'),
					'date'      => __('Date', 'ultimate-store-kit'),
					'image'   => __('Product Image', 'ultimate-store-kit'),
					'price'   => __('Price', 'ultimate-store-kit'),
					'stock'   => __('Stock', 'ultimate-store-kit'),
				],
				'condition'   => [
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_category_ids',
			[
				'label'       => __('Categories', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_cat',
				],
				'condition'   => [
					'product_include_by' => 'categories',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_tag_ids',
			[
				'label'       => __('Tags', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_tag',
				],
				'condition'   => [
					'product_include_by' => 'tags',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_brand_ids',
			[
				'label'       => __('Brands', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_brand',
				],
				'condition'   => [
					'product_include_by' => 'brands',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_attribute_ids',
			[
				'label'       => __('Attributes', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_attributes',
				],
				'condition'   => [
					'product_include_by' => 'attributes',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_include_date',
			[
				'label'     => __('Date', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'anytime',
				'options'   => [
					'anytime' => __('All', 'ultimate-store-kit'),
					'today'   => __('Past Day', 'ultimate-store-kit'),
					'week'    => __('Past Week', 'ultimate-store-kit'),
					'month'   => __('Past Month', 'ultimate-store-kit'),
					'quarter' => __('Past Quarter', 'ultimate-store-kit'),
					'year'    => __('Past Year', 'ultimate-store-kit'),
					'exact'   => __('Custom', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_source!' => 'manual_selection',
					'product_include_by' => 'date',
				]
			]
		);

		$this->add_control(
			'product_date_before',
			[
				'label'       => __('Before', 'ultimate-store-kit'),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __('Setting a "Before" date will show all the posts published until the chosen date (inclusive).', 'ultimate-store-kit'),
				'condition'   => [
					'product_include_date' => 'exact',
					'product_source!'     => 'manual_selection',
				]
			]
		);

		$this->add_control(
			'product_date_after',
			[
				'label'       => __('After', 'ultimate-store-kit'),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __('Setting an "After" date will show all the posts published since the chosen date (inclusive).', 'ultimate-store-kit'),
				'condition'   => [
					'product_include_date' => 'exact',
					'product_source!'     => 'manual_selection',
				]
			]
		);

		$this->add_control(
			'product_image_include',
			[
				'label' => esc_html__('Product Image', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('Default', 'ultimate-store-kit'),
					'set' => esc_html__('Set', 'ultimate-store-kit'),
					'not_set' => esc_html__('Not Set', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_include_by' => 'image',
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_price_include',
			[
				'label' => esc_html__('Price', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('Default', 'ultimate-store-kit'),
					'set' => esc_html__('Set', 'ultimate-store-kit'),
					'not_set' => esc_html__('Not Set', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_include_by' => 'price',
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_stock_include',
			[
				'label' => esc_html__('Stock', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''          => esc_html__('Default', 'ultimate-store-kit'),
					'in_stock'       => esc_html__('In Stock', 'ultimate-store-kit'),
					'out_of_stock'   => esc_html__('Out of Stock', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_include_by' => 'stock',
					'product_source!' => ['manual_selection'],
				]
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_product_exclude',
			[
				'label'     => __('Exclude', 'ultimate-store-kit'),
				'condition' => [
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_exclude_by',
			[
				'label'       => __('Exclude By', 'ultimate-store-kit'),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => [
					'categories' => __('Categories', 'ultimate-store-kit'),
					'tags'       => __('Tags', 'ultimate-store-kit'),
					'brands'     => __('Brands', 'ultimate-store-kit'),
					'attributes' => __('Attributes', 'ultimate-store-kit'),
					'manual_selection' => __('Manual Selection', 'ultimate-store-kit'),
					'date'      => __('Date', 'ultimate-store-kit'),
					'image'     => __('Product Image', 'ultimate-store-kit'),
					'price'     => __('Price', 'ultimate-store-kit'),
					'stock'     => __('Stock', 'ultimate-store-kit'),
				],
				'condition'   => [
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'posts_exclude_ids',
			[
				'label'       => __('Search & Select', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query'        => 'posts',
					'post_type'    => 'product',
				],
				'condition'   => [
					'product_source!'    => ['manual_selection'],
					'product_exclude_by' => 'manual_selection',
				]
			]
		);

		$this->add_control(
			'product_exclude_category_ids',
			[
				'label'       => __('Categories', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_cat',
				],
				'condition'   => [
					'product_exclude_by' => 'categories',
					'product_source!'    => ['manual_selection'],
				]
			]
		);
		$this->add_control(
			'product_exclude_tag_ids',
			[
				'label'       => __('Tags', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_tag',
				],
				'condition'   => [
					'product_exclude_by' => 'tags',
					'product_source!'    => ['manual_selection'],
				]
			]
		);
		$this->add_control(
			'product_exclude_brand_ids',
			[
				'label'       => __('Brands', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_brand',
				],
				'condition'   => [
					'product_exclude_by' => 'brands',
					'product_source!'    => ['manual_selection'],
				]
			]
		);
		$this->add_control(
			'product_exclude_attribute_ids',
			[
				'label'       => __('Attributes', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [
					'query' => 'product_attributes',
				],
				'condition'   => [
					'product_exclude_by' => 'attributes',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_exclude_date',
			[
				'label'     => __('Date', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'anytime',
				'options'   => [
					'anytime' => __('All', 'ultimate-store-kit'),
					'today'   => __('Past Day', 'ultimate-store-kit'),
					'week'    => __('Past Week', 'ultimate-store-kit'),
					'month'   => __('Past Month', 'ultimate-store-kit'),
					'quarter' => __('Past Quarter', 'ultimate-store-kit'),
					'year'    => __('Past Year', 'ultimate-store-kit'),
					'exact'   => __('Custom', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_exclude_by' => 'date',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_exclude_date_before',
			[
				'label'       => __('Before', 'ultimate-store-kit'),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __('Show all posts published until the chosen date (inclusive).', 'ultimate-store-kit'),
				'condition'   => [
					'product_exclude_date' => 'exact',
					'product_source!'      => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_exclude_date_after',
			[
				'label'       => __('After', 'ultimate-store-kit'),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __('Show all posts published since the chosen date (inclusive).', 'ultimate-store-kit'),
				'condition'   => [
					'product_exclude_date' => 'exact',
					'product_source!'      => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_image_exclude',
			[
				'label' => esc_html__('Product Image', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('Default', 'ultimate-store-kit'),
					'set' => esc_html__('Set', 'ultimate-store-kit'),
					'not_set' => esc_html__('Not Set', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_exclude_by' => 'image',
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_price_exclude',
			[
				'label' => esc_html__('Price', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('Default', 'ultimate-store-kit'),
					'set' => esc_html__('Set', 'ultimate-store-kit'),
					'not_set' => esc_html__('Not Set', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_exclude_by' => 'price',
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_stock_exclude',
			[
				'label' => esc_html__('Stock', 'ultimate-store-kit'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''          => esc_html__('Default', 'ultimate-store-kit'),
					'in_stock'       => esc_html__('In Stock', 'ultimate-store-kit'),
					'out_of_stock'   => esc_html__('Out of Stock', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_exclude_by' => 'stock',
					'product_source!' => ['manual_selection'],
				]
			]
		);

		$this->add_control(
			'product_exclude_term_ids',
			[
				'label'       => __('Terms', 'ultimate-store-kit'),
				'description' => __('Terms are items in a taxonomy. The available taxonomies are: Categories, Tags, Formats and custom taxonomies.', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'placeholder' => __('Type and select terms', 'ultimate-store-kit'),
				'query_args'  => [
					'query'        => 'terms',
					'widget_props' => [
						'post_type' => 'product_source'
					]
				],
				'condition'   => [
					'product_exclude_by' => 'terms',
					'product_source!'    => ['manual_selection'],
				]
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'product_divider',
			[
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [
					'product_source!' => 'current_query',
				]
			]
		);

		$this->add_control(
			'product_orderby',
			[
				'label'   => __('Order By', 'ultimate-store-kit'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'title'         => __('Title', 'ultimate-store-kit'),
					'ID'            => __('ID', 'ultimate-store-kit'),
					'date'          => __('Date', 'ultimate-store-kit'),
					'author'        => __('Author', 'ultimate-store-kit'),
					'comment_count' => __('Comment Count', 'ultimate-store-kit'),
					'menu_order'    => __('Menu Order', 'ultimate-store-kit'),
					'modified'      => __('Modified', 'ultimate-store-kit'),
					'rand'          => __('Random', 'ultimate-store-kit'),
					'price'         => __('Price', 'ultimate-store-kit'),
					'sales'         => __('Sales', 'ultimate-store-kit'),
				]
			]
		);
		$this->add_control(
			'product_order',
			[
				'label'     => __('Order', 'ultimate-store-kit'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'desc',
				'options'   => [
					'asc'  => __('ASC', 'ultimate-store-kit'),
					'desc' => __('DESC', 'ultimate-store-kit'),
				],
				'condition' => [
					'product_source!' => 'current_query',
				]
			]
		);
	}

	public function register_controls_wc_additional()
	{
		$this->add_control(
			'query_id',
			[
				'label'       => __('Query ID', 'ultimate-store-kit'),
				'description' => __('Give your Query a custom unique id to allow server side filtering', 'ultimate-store-kit'),
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'before',
				'dynamic' 	  => [ 'active' => true ],
			]
		);
	}

	/**
	 * @return array|string[]|\WP_Post_Type[]
	 */
	private function getGroupControlQueryPostTypes()
	{

		$post_types = [
			'product'            => __('Product', 'ultimate-store-kit'),
			'sale'               => __('On Sale', 'ultimate-store-kit'),
			'featured'           => __('Featured', 'ultimate-store-kit'),
			'manual_selection'   => __('Manual Selection', 'ultimate-store-kit'),
		];

		return $post_types;
	}

	public function pre_get_posts_query_filter($wp_query)
	{
		if ($this) {
			$query_id = $this->get_settings('query_id');
			do_action("ultimate_store_kit/query/{$query_id}", $wp_query, $this);
		}
	}

	private function get_product_source_args($source)
	{
		$args = [];

		switch ($source) {
			case 'sale':
				$args['meta_query'] = [
					[
						'key'     => '_sale_price',
						'value'   => 0,
						'compare' => '>',
					],
				];
				break;
			case 'featured':
				$args['tax_query'] = [
					[
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					],
				];
				break;
			case 'manual_selection':
				$selected_ids = $this->get_settings('product_selected_ids');
				if (!empty($selected_ids)) {
					$args['post__in'] = $selected_ids;
				}
				break;
		}

		return $args;
	}

	/**
	 * Apply "Include By" logic to WP_Query args.
	 */
	private function apply_include_by_args($args, $settings)
	{
		$include_by = $settings['product_include_by'] ?? [];

		if (!is_array($include_by)) {
			$include_by = [$include_by];
		}

		// Categories
		if (in_array('categories', $include_by) && !empty($settings['product_include_category_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $settings['product_include_category_ids'],
				'operator' => 'IN',
			];
		}

		// Tags
		if (in_array('tags', $include_by) && !empty($settings['product_include_tag_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_tag',
				'field'    => 'term_id',
				'terms'    => $settings['product_include_tag_ids'],
				'operator' => 'IN',
			];
		}

		// Brands
		if (in_array('brands', $include_by) && !empty($settings['product_include_brand_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_brand',
				'field'    => 'term_id',
				'terms'    => $settings['product_include_brand_ids'],
				'operator' => 'IN',
			];
		}

		// Attributes
		if (in_array('attributes', $include_by) && !empty($settings['product_include_attribute_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_attributes',
				'field'    => 'term_id',
				'terms'    => $settings['product_include_attribute_ids'],
				'operator' => 'IN',
			];
		}

		// Date
		if (in_array('date', $include_by) && !empty($settings['product_include_date'])) {
			$date_query = [];
			switch ($settings['product_include_date']) {
				case 'today':
					$date_query['after'] = '1 day ago';
					break;
				case 'week':
					$date_query['after'] = '1 week ago';
					break;
				case 'month':
					$date_query['after'] = '1 month ago';
					break;
				case 'quarter':
					$date_query['after'] = '3 months ago';
					break;
				case 'year':
					$date_query['after'] = '1 year ago';
					break;
				case 'exact':
					if (!empty($settings['product_date_after'])) {
						$date_query['after'] = $settings['product_date_after'];
					}
					if (!empty($settings['product_date_before'])) {
						$date_query['before'] = $settings['product_date_before'];
					}
					$date_query['inclusive'] = true;
					break;
			}
			if (!empty($date_query)) {
				$args['date_query'][] = $date_query;
			}
		}

		// Product Image
		if (in_array('image', $include_by) && isset($settings['product_image_include']) && $settings['product_image_include'] !== '') {
			if ($settings['product_image_include'] === 'set') {
				$args['meta_query'][] = [
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				];
			} elseif ($settings['product_image_include'] === 'not_set') {
				$args['meta_query'][] = [
					'key'     => '_thumbnail_id',
					'compare' => 'NOT EXISTS',
				];
			}
		}

		// Price
		if (in_array('price', $include_by) && isset($settings['product_price_include']) && $settings['product_price_include'] !== '') {
			if ($settings['product_price_include'] === 'set') {
				$args['meta_query'][] = [
					'key'     => '_price',
					'compare' => 'EXISTS',
				];
			} elseif ($settings['product_price_include'] === 'not_set') {
				$args['meta_query'][] = [
					'key'     => '_price',
					'compare' => 'NOT EXISTS',
				];
			}
		}

		// Stock
		if (in_array('stock', $include_by) && isset($settings['product_stock_include']) && $settings['product_stock_include'] !== '') {
			if ($settings['product_stock_include'] === 'in_stock') {
				$args['meta_query'][] = [
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				];
			} elseif ($settings['product_stock_include'] === 'out_of_stock') {
				$args['meta_query'][] = [
					'key'     => '_stock_status',
					'value'   => 'outofstock',
					'compare' => '=',
				];
			}
		}

		return $args;
	}

	/**
	 * Apply "Exclude By" logic to WP_Query args.
	 */
	private function apply_exclude_by_args($args, $settings)
	{
		$exclude_by = $settings['product_exclude_by'] ?? [];

		if (!is_array($exclude_by)) {
			$exclude_by = [$exclude_by];
		}

		// Categories
		if (in_array('categories', $exclude_by) && !empty($settings['product_exclude_category_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $settings['product_exclude_category_ids'],
				'operator' => 'NOT IN',
			];
		}

		// Tags
		if (in_array('tags', $exclude_by) && !empty($settings['product_exclude_tag_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_tag',
				'field'    => 'term_id',
				'terms'    => $settings['product_exclude_tag_ids'],
				'operator' => 'NOT IN',
			];
		}

		// Brands
		if (in_array('brands', $exclude_by) && !empty($settings['product_exclude_brand_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_brand',
				'field'    => 'term_id',
				'terms'    => $settings['product_exclude_brand_ids'],
				'operator' => 'NOT IN',
			];
		}

		// Attributes
		if (in_array('attributes', $exclude_by) && !empty($settings['product_exclude_attribute_ids'])) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_attributes',
				'field'    => 'term_id',
				'terms'    => $settings['product_exclude_attribute_ids'],
				'operator' => 'NOT IN',
			];
		}

		// Manual Selection
		if (in_array('manual_selection', $exclude_by) && !empty($settings['posts_exclude_ids'])) {
			$args['post__not_in'] = $settings['posts_exclude_ids'];
		}

		// Date
		if (in_array('date', $exclude_by) && !empty($settings['product_exclude_date'])) {
			$date_query = [];
			switch ($settings['product_exclude_date']) {
				case 'today':
					$date_query['before'] = '1 day ago';
					break;
				case 'week':
					$date_query['before'] = '1 week ago';
					break;
				case 'month':
					$date_query['before'] = '1 month ago';
					break;
				case 'quarter':
					$date_query['before'] = '3 months ago';
					break;
				case 'year':
					$date_query['before'] = '1 year ago';
					break;
				case 'exact':
					if (!empty($settings['product_exclude_date_after'])) {
						$date_query['after'] = $settings['product_exclude_date_after'];
					}
					if (!empty($settings['product_exclude_date_before'])) {
						$date_query['before'] = $settings['product_exclude_date_before'];
					}
					$date_query['inclusive'] = true;
					break;
			}
			if (!empty($date_query)) {
				$args['date_query'][] = $date_query;
			}
		}

		// Product Image
		if (in_array('image', $exclude_by) && isset($settings['product_image_exclude']) && $settings['product_image_exclude'] !== '') {
			if ($settings['product_image_exclude'] === 'set') {
				$args['meta_query'][] = [
					'key'     => '_thumbnail_id',
					'compare' => 'NOT EXISTS',
				];
			} elseif ($settings['product_image_exclude'] === 'not_set') {
				$args['meta_query'][] = [
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				];
			}
		}

		// Price
		if (in_array('price', $exclude_by) && isset($settings['product_price_exclude']) && $settings['product_price_exclude'] !== '') {
			if ($settings['product_price_exclude'] === 'set') {
				$args['meta_query'][] = [
					'key'     => '_price',
					'compare' => 'NOT EXISTS',
				];
			} elseif ($settings['product_price_exclude'] === 'not_set') {
				$args['meta_query'][] = [
					'key'     => '_price',
					'compare' => 'EXISTS',
				];
			}
		}

		// Stock
		if (in_array('stock', $exclude_by) && isset($settings['product_stock_exclude']) && $settings['product_stock_exclude'] !== '') {
			if ($settings['product_stock_exclude'] === 'in_stock') {
				$args['meta_query'][] = [
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '!=',
				];
			} elseif ($settings['product_stock_exclude'] === 'out_of_stock') {
				$args['meta_query'][] = [
					'key'     => '_stock_status',
					'value'   => 'outofstock',
					'compare' => '!=',
				];
			}
		}

		return $args;
	}

	protected function getGroupControlQueryArgs()
	{
		$settings         = $this->get_settings();
		$source           = $settings['product_source'] ?? 'product';
		$page             = max(1, get_query_var('paged'), get_query_var('page'));
		$page             = absint(empty($_GET['product-page']) ? $page : $_GET['product-page']);
		$paged            = absint($page);

		$args = [
			'post_type' => 'product',
			'paged'     => $paged
		];

		if (!empty($settings['product_limit'])) {
			$args['posts_per_page'] = $settings['product_limit'];
		}

		$args = $args + $this->get_product_source_args($source);

		// Apply "Include By" logic
		$args = $this->apply_include_by_args($args, $settings);

		// Apply "Exclude By" logic
		$args = $this->apply_exclude_by_args($args, $settings);

		// Apply Order and OrderBy
		if (!empty($settings['product_orderby'])) {
			switch ($settings['product_orderby']) {
				case 'price':
					$args['meta_key'] = '_price';
					$args['orderby'] = 'meta_value_num';
					break;
				case 'sales':
					$args['meta_key'] = 'total_sales';
					$args['orderby'] = 'meta_value_num';
					break;
				default:
					$args['orderby'] = $settings['product_orderby'];
			}
		}

		if (!empty($settings['product_order'])) {
			$args['order'] = $settings['product_order'];
		}

		$query_id = $this->get_settings('query_id');
		if (! empty($query_id)) {
			add_action('pre_get_posts', [$this, 'pre_get_posts_query_filter']);
		}

		return $args;
	}
}
