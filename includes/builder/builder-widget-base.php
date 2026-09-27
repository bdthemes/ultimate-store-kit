<?php

namespace UltimateStoreKit\Includes\Builder;

use Elementor\Widget_Base;
use UltimateStoreKit\Ultimate_Store_Kit_Loader;


if (! defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- usk_ / BDTUSK_ / ultimate-store-kit- are this plugin's established public prefixes. Ultimate Store Kit Pro calls into these names, as does third-party integration code, so renaming them is a breaking change. Plugin Check only recognises prefixes derived verbatim from the slug and so reports them as unprefixed.

abstract class Builder_Widget_Base extends Widget_Base {

	public $__temp_query = null;
	public $__product_data = false;


	/**
	 * Check if we currently in Elementor mode
	 *
	 * @return void
	 */
	public function in_elementor() {
		$result = false;

		if (wp_doing_ajax()) {
			$result = isset($this->is_elementor_ajax);
		} elseif (
			\Elementor\Plugin::instance()->editor->is_edit_mode()
			|| \Elementor\Plugin::instance()->preview->is_preview_mode()
			|| Ultimate_Store_Kit_Loader::elementor()->editor->is_edit_mode()
			|| Ultimate_Store_Kit_Loader::elementor()->preview->is_preview_mode()
		) {
			$result = true;
		}

		return apply_filters('ultimate-store-kit-builder/in-elementor', $result);
	}

	protected function is_ultimate_builder_editor() {

		if (! $this->in_elementor() && ! wp_doing_ajax())
			return;
		if (get_post_type() !== Meta::POST_TYPE)
			return;

		return true;
	}


	/**
	 * Set editor data for ajax save only
	 */
	public function usk_set_single_post_preview_data() {

		if (! $this->is_ultimate_builder_editor()) {
			return;
		}

		global $post;

		$templateId = get_transient('ultimate_store_kit_template_id_' . get_current_user_id());
		$posts      = get_transient('ultimate_store_kit_template_sample_post_' . get_current_user_id());

		if ($posts instanceof \WP_Query && $posts->have_posts() && $templateId == $post->ID) {
			foreach ($posts->posts as $post) {
				$GLOBALS['post'] = $post;
				setup_postdata($post);
			}
		}
	}
}
