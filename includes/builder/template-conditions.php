<?php

namespace UltimateStoreKit\Includes\Builder;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- usk_ / ultimate_store_kit_ are this plugin's established public prefixes.

/**
 * Display conditions for Template Builder templates.
 *
 * A template type normally has one active template, recorded in the
 * ultimate_store_kit_template_<type> option. A template that has display
 * conditions is instead "conditional": it is never written to that option,
 * and it wins over the option's template only on the products or terms it
 * names. Several conditional templates of one type can be active at once.
 *
 * Supported types and what their conditions match:
 * - product|single:   products, product categories (and their children), product tags
 * - product|category: product categories (and their children)
 * - product|tag:      product tags
 */
class Template_Conditions {

	/**
	 * Post meta holding the conditions: ['products' => int[], 'product_cat' => int[], 'product_tag' => int[]].
	 */
	const META = '_ultimate_store_kit_template_conditions';

	/**
	 * Post meta flag: 1 while a conditional template is switched on.
	 */
	const ACTIVE_META = '_ultimate_store_kit_template_conditional_active';

	/**
	 * @var array<string, int> Matched template per type for this request.
	 */
	private static $cache = [];

	/**
	 * Which condition keys each template type accepts.
	 *
	 * @return array<string, string[]>
	 */
	public static function supported_types() {
		return apply_filters(
			'ultimate_store_kit_builder_condition_types',
			[
				'product|single'   => ['products', 'product_cat', 'product_tag'],
				'product|category' => ['product_cat'],
				'product|tag'      => ['product_tag'],
			]
		);
	}

	/**
	 * Whether a template type can have display conditions.
	 *
	 * @param string $type Template type, e.g. "product|single".
	 * @return bool
	 */
	public static function supports($type) {
		return array_key_exists(strtolower((string) $type), self::supported_types());
	}

	/**
	 * Keep only the condition keys and IDs that are valid for a type.
	 *
	 * @param string $type       Template type.
	 * @param mixed  $conditions Raw conditions.
	 * @return array<string, int[]> Empty when the type has no conditions.
	 */
	public static function sanitize($type, $conditions) {
		$types = self::supported_types();
		$type  = strtolower((string) $type);

		if (! isset($types[$type]) || ! is_array($conditions)) {
			return [];
		}

		$clean = [];

		foreach ($types[$type] as $key) {
			if (empty($conditions[$key])) {
				continue;
			}

			$ids = array_values(array_unique(array_filter(array_map('absint', (array) $conditions[$key]))));

			if ($ids) {
				$clean[$key] = $ids;
			}
		}

		return $clean;
	}

	/**
	 * Stored conditions of a template.
	 *
	 * @param int $template_id Template post ID.
	 * @return array<string, int[]>
	 */
	public static function get($template_id) {
		$conditions = get_post_meta($template_id, self::META, true);

		return is_array($conditions) ? $conditions : [];
	}

	/**
	 * Whether a template has display conditions.
	 *
	 * @param int $template_id Template post ID.
	 * @return bool
	 */
	public static function has_conditions($template_id) {
		return ! empty(self::get($template_id));
	}

	/**
	 * Whether a conditional template is switched on.
	 *
	 * @param int $template_id Template post ID.
	 * @return bool
	 */
	public static function is_active($template_id) {
		return (bool) get_post_meta($template_id, self::ACTIVE_META, true);
	}

	/**
	 * Save a template's conditions and on/off state.
	 *
	 * With conditions the template stops being the type's default, so the
	 * default option is released if it pointed here. Without conditions the
	 * caller handles the default option as before.
	 *
	 * @param int    $template_id Template post ID.
	 * @param string $type        Template type.
	 * @param mixed  $conditions  Raw conditions.
	 * @param bool   $enabled     Status switch.
	 * @return bool Whether the template is conditional after saving.
	 */
	public static function save($template_id, $type, $conditions, $enabled) {
		$conditions = self::sanitize($type, $conditions);

		if (empty($conditions)) {
			delete_post_meta($template_id, self::META);
			delete_post_meta($template_id, self::ACTIVE_META);

			return false;
		}

		update_post_meta($template_id, self::META, $conditions);

		if ($enabled) {
			update_post_meta($template_id, self::ACTIVE_META, 1);
		} else {
			delete_post_meta($template_id, self::ACTIVE_META);
		}

		if ((int) Meta::get_template_option($type) === (int) $template_id) {
			Meta::delete_template_option($type);
		}

		return true;
	}

	/**
	 * The conditional template that applies to the current request, if any.
	 *
	 * @param string $slug      Template slug, e.g. "single".
	 * @param string $post_type Template group, e.g. "product".
	 * @return int Template ID, 0 when none matches.
	 */
	public static function match($slug, $post_type) {
		$type = strtolower("{$post_type}|{$slug}");

		if (! self::supports($type)) {
			return 0;
		}

		if (array_key_exists($type, self::$cache)) {
			return self::$cache[$type];
		}

		$context = self::request_context($type);

		self::$cache[$type] = $context ? self::find_template($type, $context) : 0;

		return self::$cache[$type];
	}

	/**
	 * What the current request is about, in condition terms.
	 *
	 * @param string $type Template type.
	 * @return array<string, int[]>|null Null when the request is not one this type serves.
	 */
	private static function request_context($type) {
		if ('product|single' === $type) {
			$product_id = is_singular('product') ? get_queried_object_id() : 0;

			if (! $product_id) {
				return null;
			}

			return [
				'products'    => [$product_id],
				'product_cat' => self::with_ancestors(wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']), 'product_cat'),
				'product_tag' => self::ids(wp_get_post_terms($product_id, 'product_tag', ['fields' => 'ids'])),
			];
		}

		$taxonomy = 'product|category' === $type ? 'product_cat' : 'product_tag';

		if (! is_tax($taxonomy)) {
			return null;
		}

		$term_id = get_queried_object_id();

		return [
			$taxonomy => 'product_cat' === $taxonomy ? self::with_ancestors([$term_id], $taxonomy) : [$term_id],
		];
	}

	/**
	 * Most specific active conditional template matching a context.
	 *
	 * A product condition beats a tag, a tag beats a category, and a direct
	 * category beats a parent category; ties go to the newest template.
	 *
	 * @param string               $type    Template type.
	 * @param array<string, int[]> $context Request context.
	 * @return int
	 */
	private static function find_template($type, $context) {
		$templates = get_posts([
			'post_type'        => Meta::POST_TYPE,
			'post_status'      => 'publish',
			'posts_per_page'   => -1,
			'fields'           => 'ids',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'no_found_rows'    => true,
			'suppress_filters' => false,
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- Few builder templates; runs once per request and type.
			'meta_query'       => [
				[
					'key'   => Meta::TEMPLATE_TYPE,
					'value' => $type,
				],
				[
					'key'   => self::ACTIVE_META,
					'value' => '1',
				],
			],
		]);

		$best_id    = 0;
		$best_score = 0;

		foreach ($templates as $template_id) {
			$score = self::score(self::get($template_id), $context);

			if ($score > $best_score) {
				$best_score = $score;
				$best_id    = (int) $template_id;
			}
		}

		return $best_id;
	}

	/**
	 * How specifically a template's conditions match a context (0 = no match).
	 *
	 * @param array<string, int[]> $conditions Template conditions.
	 * @param array<string, int[]> $context    Request context.
	 * @return int
	 */
	private static function score($conditions, $context) {
		if (! empty($conditions['products']) && ! empty($context['products']) && array_intersect($conditions['products'], $context['products'])) {
			return 400;
		}

		if (! empty($conditions['product_tag']) && ! empty($context['product_tag']) && array_intersect($conditions['product_tag'], $context['product_tag'])) {
			return 300;
		}

		if (! empty($conditions['product_cat']) && ! empty($context['product_cat'])) {
			// Context categories are ordered: own terms first, then ancestors.
			foreach ($context['product_cat'] as $position => $term_id) {
				if (in_array($term_id, $conditions['product_cat'], true)) {
					return 200 - min($position, 99);
				}
			}
		}

		return 0;
	}

	/**
	 * Term IDs followed by all their ancestors.
	 *
	 * @param mixed  $term_ids Term IDs (or a WP_Error).
	 * @param string $taxonomy Taxonomy.
	 * @return int[]
	 */
	private static function with_ancestors($term_ids, $taxonomy) {
		$term_ids = self::ids($term_ids);
		$all      = $term_ids;

		foreach ($term_ids as $term_id) {
			$all = array_merge($all, array_map('intval', get_ancestors($term_id, $taxonomy, 'taxonomy')));
		}

		return array_values(array_unique($all));
	}

	/**
	 * @param mixed $ids IDs or a WP_Error.
	 * @return int[]
	 */
	private static function ids($ids) {
		return is_array($ids) ? array_map('intval', $ids) : [];
	}

	/**
	 * Short human description of a template's conditions, for the list table.
	 *
	 * @param int $template_id Template post ID.
	 * @return string Plain text.
	 */
	public static function describe($template_id) {
		$conditions = self::get($template_id);
		$parts      = [];

		if (! empty($conditions['products'])) {
			$titles  = array_map('get_the_title', array_slice($conditions['products'], 0, 3));
			$parts[] = sprintf(
				/* translators: %s: Comma-separated product names. */
				__('Products: %s', 'ultimate-store-kit'),
				implode(', ', $titles) . (count($conditions['products']) > 3 ? '…' : '')
			);
		}

		foreach (['product_cat' => __('Categories: %s', 'ultimate-store-kit'), 'product_tag' => __('Tags: %s', 'ultimate-store-kit')] as $taxonomy => $label) {
			if (empty($conditions[$taxonomy])) {
				continue;
			}

			$names = [];
			foreach (array_slice($conditions[$taxonomy], 0, 3) as $term_id) {
				$term = get_term($term_id, $taxonomy);
				if ($term && ! is_wp_error($term)) {
					$names[] = $term->name;
				}
			}

			$parts[] = sprintf($label, implode(', ', $names) . (count($conditions[$taxonomy]) > 3 ? '…' : ''));
		}

		return implode('; ', $parts);
	}

	/**
	 * A published product that a conditional single template applies to, for its preview.
	 *
	 * @param int $template_id Template post ID.
	 * @return int Product ID, 0 when the template has no conditions or nothing matches.
	 */
	public static function sample_product($template_id) {
		$conditions = self::get($template_id);

		if (! empty($conditions['products'])) {
			foreach ($conditions['products'] as $product_id) {
				if ('publish' === get_post_status($product_id)) {
					return (int) $product_id;
				}
			}
		}

		$tax_query = [];
		foreach (['product_cat', 'product_tag'] as $taxonomy) {
			if (! empty($conditions[$taxonomy])) {
				$tax_query[] = [
					'taxonomy' => $taxonomy,
					'terms'    => $conditions[$taxonomy],
				];
			}
		}

		if (! $tax_query) {
			return 0;
		}

		$tax_query['relation'] = 'OR';

		$products = get_posts([
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- One product for an editor preview.
			'tax_query'      => $tax_query,
		]);

		return $products ? (int) $products[0] : 0;
	}

	/**
	 * A term's name prefixed with its ancestors ("Clothing › Shirts").
	 *
	 * @param \WP_Term $term Term.
	 * @return string Plain text.
	 */
	public static function term_label($term) {
		$names = [$term->name];

		foreach (get_ancestors($term->term_id, $term->taxonomy, 'taxonomy') as $ancestor_id) {
			$ancestor = get_term($ancestor_id, $term->taxonomy);
			if ($ancestor && ! is_wp_error($ancestor)) {
				array_unshift($names, $ancestor->name);
			}
		}

		return implode(' › ', $names);
	}

	/**
	 * Names of a template's condition products, for the AJAX product picker.
	 *
	 * @param int $template_id Template being edited, 0 for a new one.
	 * @return array<int, string> Product ID => name.
	 */
	public static function selected_products($template_id) {
		$conditions = $template_id ? self::get($template_id) : [];
		$products   = [];

		foreach ($conditions['products'] ?? [] as $product_id) {
			$product = function_exists('wc_get_product') ? wc_get_product($product_id) : null;
			if ($product) {
				$products[$product_id] = wp_strip_all_tags($product->get_formatted_name());
			}
		}

		return $products;
	}
}
