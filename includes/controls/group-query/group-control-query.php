<?php

namespace UltimateStoreKit\Includes\Controls\GroupQuery;

use Elementor\Controls_Manager;
use UltimateStoreKit\Includes\Controls\SelectInput\Dynamic_Select;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

trait Group_Control_Query {

	public function register_query_builder_controls() {

		$this->add_control(
			'product_source',
			[ 
				'label'   => __( 'Source', 'ultimate-store-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->getGroupControlQueryPostTypes(),
				'default' => 'product',
			]
		);
		$this->add_control(
			'product_limit',
			[ 
				'label'   => esc_html__( 'Product Limit', 'ultimate-store-kit' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
			]
		);

		$this->add_control(
			'product_selected_ids',
			[ 
				'label'       => __( 'Search & Select', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [ 
					'query' => 'posts',
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
					'product_source!' => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->start_controls_tab(
			'tab_product_include',
			[ 
				'label'     => __( 'Include', 'ultimate-store-kit' ),
				'condition' => [ 
					'product_source!' => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'product_include_by',
			[ 
				'label'       => __( 'Include By', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => [ 
					'authors' => __( 'Authors', 'ultimate-store-kit' ),
					'terms'   => __( 'Terms', 'ultimate-store-kit' ),
				],
				'condition'   => [ 
					'product_source!' => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'product_include_author_ids',
			[ 
				'label'       => __( 'Authors', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [ 
					'query' => 'authors',
				],
				'condition'   => [ 
					'product_include_by' => 'authors',
					'product_source!'    => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'product_include_term_ids',
			[ 
				'label'       => __( 'Terms', 'ultimate-store-kit' ),
				'description' => __( 'Terms are items in a taxonomy. The available taxonomies are: Categories, Tags, Formats and custom taxonomies.', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'placeholder' => __( 'Type and select terms', 'ultimate-store-kit' ),
				'query_args'  => [ 
					'query'        => 'terms',
					'widget_props' => [ 
						'post_type' => 'product_source'
					]
				],
				'condition'   => [ 
					'product_include_by' => 'terms',
					'product_source!'    => [ 'manual_selection', 'current_query', '_related_post_type' ],
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_product_exclude',
			[ 
				'label'     => __( 'Exclude', 'ultimate-store-kit' ),
				'condition' => [ 
					'product_source!' => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'product_exclude_by',
			[ 
				'label'       => __( 'Exclude By', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => [ 
					'authors'          => __( 'Authors', 'ultimate-store-kit' ),
					'current_post'     => __( 'Current Post', 'ultimate-store-kit' ),
					'manual_selection' => __( 'Manual Selection', 'ultimate-store-kit' ),
					'terms'            => __( 'Terms', 'ultimate-store-kit' ),
				],
				'condition'   => [ 
					'product_source!' => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'posts_exclude_ids',
			[ 
				'label'       => __( 'Search & Select', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [ 
					'query'        => 'posts',
					'widget_props' => [ 
						'post_type' => 'product_source'
					]
				],
				'condition'   => [ 
					'product_source!'    => [ 'manual_selection', 'current_query' ],
					'product_exclude_by' => 'manual_selection',
				]
			]
		);

		$this->add_control(
			'product_exclude_author_ids',
			[ 
				'label'       => __( 'Authors', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'query_args'  => [ 
					'query' => 'authors',
				],
				'condition'   => [ 
					'product_exclude_by' => 'authors',
					'product_source!'    => [ 'manual_selection', 'current_query' ],
				]
			]
		);

		$this->add_control(
			'product_exclude_term_ids',
			[ 
				'label'       => __( 'Terms', 'ultimate-store-kit' ),
				'description' => __( 'Terms are items in a taxonomy. The available taxonomies are: Categories, Tags, Formats and custom taxonomies.', 'ultimate-store-kit' ),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => true,
				'label_block' => true,
				'placeholder' => __( 'Type and select terms', 'ultimate-store-kit' ),
				'query_args'  => [ 
					'query'        => 'terms',
					'widget_props' => [ 
						'post_type' => 'product_source'
					]
				],
				'condition'   => [ 
					'product_exclude_by' => 'terms',
					'product_source!'    => [ 'manual_selection', 'current_query', '_related_post_type' ],
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
			'product_select_date',
			[ 
				'label'     => __( 'Date', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'anytime',
				'options'   => [ 
					'anytime' => __( 'All', 'ultimate-store-kit' ),
					'today'   => __( 'Past Day', 'ultimate-store-kit' ),
					'week'    => __( 'Past Week', 'ultimate-store-kit' ),
					'month'   => __( 'Past Month', 'ultimate-store-kit' ),
					'quarter' => __( 'Past Quarter', 'ultimate-store-kit' ),
					'year'    => __( 'Past Year', 'ultimate-store-kit' ),
					'exact'   => __( 'Custom', 'ultimate-store-kit' ),
				],
				'condition' => [ 
					'product_source!' => 'current_query',
				]
			]
		);

		$this->add_control(
			'product_date_before',
			[ 
				'label'       => __( 'Before', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __( 'Setting a ‘Before’ date will show all the posts published until the chosen date (inclusive).', 'ultimate-store-kit' ),
				'condition'   => [ 
					'product_select_date' => 'exact',
					'product_source!'     => 'current_query',
				]
			]
		);

		$this->add_control(
			'product_date_after',
			[ 
				'label'       => __( 'After', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::DATE_TIME,
				'description' => __( 'Setting an ‘After’ date will show all the posts published since the chosen date (inclusive).', 'ultimate-store-kit' ),
				'condition'   => [ 
					'product_select_date' => 'exact',
					'product_source!'     => 'current_query',
				]
			]
		);

		$this->add_control(
			'product_orderby',
			[ 
				'label'   => __( 'Order By', 'ultimate-store-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [ 
					'title'         => __( 'Title', 'ultimate-store-kit' ),
					'ID'            => __( 'ID', 'ultimate-store-kit' ),
					'date'          => __( 'Date', 'ultimate-store-kit' ),
					'author'        => __( 'Author', 'ultimate-store-kit' ),
					'comment_count' => __( 'Comment Count', 'ultimate-store-kit' ),
					'menu_order'    => __( 'Menu Order', 'ultimate-store-kit' ),
					'modified'      => __( 'Modified', 'ultimate-store-kit' ),
					'rand'          => __( 'Random', 'ultimate-store-kit' ),
					'price'         => __( 'Price', 'ultimate-store-kit' ),
					'sales'         => __( 'Sales', 'ultimate-store-kit' ),
				]
			]
		);
		$this->add_control(
			'product_order',
			[ 
				'label'     => __( 'Order', 'ultimate-store-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'desc',
				'options'   => [ 
					'asc'  => __( 'ASC', 'ultimate-store-kit' ),
					'desc' => __( 'DESC', 'ultimate-store-kit' ),
				],
				'condition' => [ 
					'product_source!' => 'current_query',
				]
			]
		);
		// Others Features
	}

	public function register_controls_wc_additional() {
		$this->add_control(
			'product_show_only',
			[ 
				'label'   => esc_html__( 'Show Product', 'ultimate-store-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [ 
					'all'      => esc_html__( 'All Products', 'ultimate-store-kit' ),
					'onsale'   => esc_html__( 'On Sale', 'ultimate-store-kit' ),
					'featured' => esc_html__( 'Featured', 'ultimate-store-kit' ),
				]
			]
		);
		$this->add_control(
			'product_hide_free',
			[ 
				'label' => esc_html__( 'Hide Free Product', 'ultimate-store-kit' ),
				'type'  => Controls_Manager::SWITCHER,

			]
		);
		$this->add_control(
			'product_hide_out_stock',
			[ 
				'label' => esc_html__( 'Hide Out of Stock', 'ultimate-store-kit' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'product_only_with_featured_image',
			[ 
				'label'        => __( 'Only Featured Image Post', 'ultimate-store-kit' ),
				'description'  => __( 'Enable to display posts only when featured image is present.', 'ultimate-store-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [ 
					'product_source!' => 'current_query',
				]
			]
		);
		$this->add_control(
			'query_id',
			[ 
				'label'       => __( 'Query ID', 'ultimate-store-kit' ),
				'description' => __( 'Give your Query a custom unique id to allow server side filtering', 'ultimate-store-kit' ),
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'before',
			]
		);
	}

	private function setMetaQueryArgs() {

		$args = [];

		if ( 'current_query' === $this->getGroupControlQueryPostType() ) {
			$args['posts_per_page'] = $this->get_settings( 'product_limit' );
			return $args;
		}

		$args['paged']          = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
		$args['posts_per_page'] = $this->get_settings( 'product_limit' );
		$args['order']          = $this->get_settings( 'product_order' );
		// $args['orderby'] = $this->get_settings('product_orderby');

		if ( 'product' === $this->getGroupControlQueryPostType() ) {
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			if ( 'yes' == $this->get_settings( 'product_hide_free' ) ) {
				$args['meta_query'][] = [ 
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				];
			}

			if ( 'yes' == $this->get_settings( 'product_hide_out_stock' ) ) {
				$args['tax_query'][] = [ 
					[ 
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['outofstock'],
						'operator' => 'NOT IN',
					],
				]; // WPCS: slow query ok.
			}
			switch ( $this->get_settings( 'product_show_only' ) ) {
				case 'featured':
					$args['tax_query'][] = [ 
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['featured'],
					];
					break;
				case 'onsale':
					$product_ids_on_sale = wc_get_product_ids_on_sale();
					$product_ids_on_sale[] = 0;
					$args['post__in'] = $product_ids_on_sale;
					break;
			}
			switch ( $this->get_settings( 'product_orderby' ) ) {
				case 'price':
					$args['meta_key'] = '_price'; // WPCS: slow query ok.
					$args['orderby'] = 'meta_value_num';
					break;
				case 'sales':
					$args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
					$args['orderby'] = 'meta_value_num';
					break;
				default:
					$args['orderby'] = $this->get_settings( 'product_orderby' );
			}
		}



		/**
		 * Set Feature Images
		 */
		if ( $this->get_settings( 'product_only_with_featured_image' ) === 'yes' ) {
			$args['meta_key'] = '_thumbnail_id';
		}

		/**
		 * Set Date
		 */

		$selected_date = $this->get_settings( 'product_select_date' );

		if ( ! empty( $selected_date ) ) {
			$date_query = [];

			switch ( $selected_date ) {
				case 'today':
					$date_query['after'] = '-1 day';
					break;

				case 'week':
					$date_query['after'] = '-1 week';
					break;

				case 'month':
					$date_query['after'] = '-1 month';
					break;

				case 'quarter':
					$date_query['after'] = '-3 month';
					break;

				case 'year':
					$date_query['after'] = '-1 year';
					break;

				case 'exact':
					$after_date = $this->get_settings( 'product_date_after' );
					if ( ! empty( $after_date ) ) {
						$date_query['after'] = $after_date;
					}

					$before_date = $this->get_settings( 'product_date_before' );
					if ( ! empty( $before_date ) ) {
						$date_query['before'] = $before_date;
					}

					$date_query['inclusive'] = true;
					break;
			}

			if ( ! empty( $date_query ) ) {
				$args['date_query'] = $date_query;
			}
		}

		return $args;
	}

	protected function getGroupControlQueryArgs() {

		$settings                 = $this->get_settings();
		$args                     = $this->setMetaQueryArgs();
		$args['post_status']      = 'publish';
		$args['suppress_filters'] = false;
		$exclude_by               = $this->getGroupControlQueryParamBy( 'exclude' );

		// /**
		//  * Set Ignore Sticky
		//  */
		// if (
		// 	$this->getGroupControlQueryPostType() === 'post'
		// 	&& $this->get_settings('posts_ignore_sticky_posts') === 'yes'
		// ) {
		// 	$args['ignore_sticky_posts'] = true;

		// 	if (in_array('current_post', $exclude_by)) {
		// 		$args['post__not_in'] = [get_the_ID()];
		// 	}
		// }


		if ( $this->getGroupControlQueryPostType() === 'manual_selection' ) {
			/**
			 * Set Including Manually
			 */
			$selected_ids      = $this->get_settings( 'product_selected_ids' );
			$selected_ids      = wp_parse_id_list( $selected_ids );
			$args['post_type'] = 'product';
			if ( ! empty( $selected_ids ) ) {
				$args['post__in'] = $selected_ids;
			}
			$args['ignore_sticky_posts'] = 1;
		} elseif ( 'current_query' === $this->getGroupControlQueryPostType() ) {
			/**
			 * Make Current Query
			 */
			$wp_query = $GLOBALS['wp_query']->query_vars;

			if ( isset( $wp_query['usk-template-builder'] ) && 'shop-page' === $wp_query['usk-template-builder'] || isset( $_GET['usk-template'] ) || \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$args['post_type'] = 'product';
			} else {
				$args['post_type'] = 'product';
			}

			$args['paged']          = 1;

			$page          = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
			$page          = absint( empty( $_GET['product-page'] ) ? $page : $_GET['product-page'] );
			$args['paged'] = $page;

			if ( isset( $wp_query['product_cat'] ) ) {
				$args['product_cat'] = $wp_query['product_cat'];
			}
			
			$args['posts_per_page'] = $this->get_settings( 'product_limit' );
			$args                   = apply_filters( 'ultimate_store_kit/query/get_query_args/current_query', $args );

		} elseif ( '_related_post_type' === $this->getGroupControlQueryPostType() ) {
			/**
			 * Set Related Query
			 */
			$post_id           = get_queried_object_id();
			$related_post_id   = is_singular() && ( 0 !== $post_id ) ? $post_id : null;
			$args['post_type'] = get_post_type( $related_post_id );

			$include_by = $this->getGroupControlQueryParamBy( 'include' );
			if ( in_array( 'authors', $include_by ) ) {
				$args['author__in'] = wp_parse_id_list( $settings['product_include_author_ids'] );
			} else {
				$args['author__in'] = get_post_field( 'post_author', $related_post_id );
			}

			$exclude_by = $this->getGroupControlQueryParamBy( 'exclude' );
			if ( in_array( 'authors', $exclude_by ) ) {
				$args['author__not_in'] = wp_parse_id_list( $settings['product_exclude_author_ids'] );
			}

			if ( in_array( 'current_post', $exclude_by ) ) {
				$args['post__not_in'] = [ get_the_ID() ];
			}

			$args['ignore_sticky_posts'] = 1;
			$args                        = apply_filters( 'ultimate_store_kit/query/get_query_args/related_query', $args );
		} else {

			/**
			 * Set Post Type
			 */
			$args['post_type'] = $this->getGroupControlQueryPostType();

			/**
			 * Set Exclude Post
			 */
			$exclude_by   = $this->getGroupControlQueryParamBy( 'exclude' );
			$current_post = [];

			if ( in_array( 'current_post', $exclude_by ) && is_singular() ) {
				$current_post = [ get_the_ID() ];
			}

			if ( in_array( 'manual_selection', $exclude_by ) ) {
				$exclude_ids          = $settings['posts_exclude_ids'];
				$args['post__not_in'] = array_merge( $current_post, wp_parse_id_list( $exclude_ids ) );
			}
			/**
			 * Set Authors
			 */
			$include_by    = $this->getGroupControlQueryParamBy( 'include' );
			$exclude_by    = $this->getGroupControlQueryParamBy( 'exclude' );
			$include_users = [];
			$exclude_users = [];

			if ( in_array( 'authors', $include_by ) ) {
				$include_users = wp_parse_id_list( $settings['product_include_author_ids'] );
			}

			if ( in_array( 'authors', $exclude_by ) ) {
				$exclude_users = wp_parse_id_list( $settings['product_exclude_author_ids'] );
				$include_users = array_diff( $include_users, $exclude_users );
			}

			if ( ! empty( $include_users ) ) {
				$args['author__in'] = $include_users;
			}

			if ( ! empty( $exclude_users ) ) {
				$args['author__not_in'] = $exclude_users;
				;
			}

			/**
			 * Set Taxonomy
			 */
			$include_by    = $this->getGroupControlQueryParamBy( 'include' );
			$exclude_by    = $this->getGroupControlQueryParamBy( 'exclude' );
			$include_terms = [];
			$exclude_terms = [];
			$terms_query   = [];

			if ( in_array( 'terms', $include_by ) ) {
				$include_terms = wp_parse_id_list( $settings['product_include_term_ids'] );
			}

			if ( in_array( 'terms', $exclude_by ) ) {
				$exclude_terms = wp_parse_id_list( $settings['product_exclude_term_ids'] );
				$include_terms = array_diff( $include_terms, $exclude_terms );
			}

			if ( ! empty( $include_terms ) ) {
				$tax_terms_map = $this->mapGroupControlQuery( $include_terms );

				foreach ( $tax_terms_map as $tax => $terms ) {
					$terms_query[] = [ 
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'IN',
					];
				}
			}

			if ( ! empty( $exclude_terms ) ) {
				$tax_terms_map = $this->mapGroupControlQuery( $exclude_terms );

				foreach ( $tax_terms_map as $tax => $terms ) {
					$terms_query[] = [ 
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'NOT IN',
					];
				}
			}

			if ( ! empty( $terms_query ) ) {
				$args['tax_query']             = $terms_query;
				$args['tax_query']['relation'] = 'AND';
			}

			$page          = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
			$page          = absint( empty( $_GET['product-page'] ) ? $page : $_GET['product-page'] );
			$args['paged'] = $page;
		}

		$query_id = $this->get_settings( 'query_id' );
		if ( ! empty( $query_id ) ) {
			add_action( 'pre_get_posts', [ $this, 'pre_get_posts_query_filter' ] );
		}

		return $args;
	}


	/**
	 * @return mixed
	 */
	private function getGroupControlQueryPostType() {
		return $this->get_settings( 'product_source' );
	}

	/**
	 * Get Query Params by args
	 *
	 * @param string $by
	 *
	 * @return array|mixed
	 */
	private function getGroupControlQueryParamBy( $by = 'exclude' ) {
		$mapBy = [ 
			'exclude' => 'product_exclude_by',
			'include' => 'product_include_by',
		];

		$setting = $this->get_settings( $mapBy[ $by ] );

		return ( ! empty( $setting ) ? $setting : [] );
	}

	/**
	 * @param array $term_ids
	 *
	 * @return array
	 */
	private function mapGroupControlQuery( $term_ids = [] ) {
		$terms = get_terms(
			[ 
				'term_taxonomy_id' => $term_ids,
				'hide_empty'       => false,
			]
		);

		$tax_terms_map = [];

		foreach ( $terms as $term ) {
			$taxonomy                     = $term->taxonomy;
			$tax_terms_map[ $taxonomy ][] = $term->term_id;
		}

		return $tax_terms_map;
	}

	/**
	 * @return array|string[]|\WP_Post_Type[]
	 */
	private function getGroupControlQueryPostTypes() {

		$post_types = [ 
			'product'            => __( 'Product', 'ultimate-store-kit' ),
			'manual_selection'   => __( 'Manual Selection', 'ultimate-store-kit' ),
			'current_query'      => __( 'Current Query', 'ultimate-store-kit' ),
			'_related_post_type' => __( 'Related', 'ultimate-store-kit' ),
		];

		// $post_types = array_merge($post_types, $extra_types);

		return $post_types;
	}

	public function pre_get_posts_query_filter( $wp_query ) {
		if ( $this ) {
			$query_id = $this->get_settings( 'query_id' );
			do_action( "ultimate_store_kit/query/{$query_id}", $wp_query, $this );
		}
	}
}
