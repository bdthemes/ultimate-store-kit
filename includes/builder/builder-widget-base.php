<?php

namespace UltimateStoreKit\Includes\Builder;

use Elementor\Widget_Base;



if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

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
			$result = $this->is_elementor_ajax;
		} elseif (
			\Elementor\Plugin::instance()->editor->is_edit_mode()
			|| \Elementor\Plugin::instance()->preview->is_preview_mode()
		) {
			$result = true;
		}

		return apply_filters('ultimate-store-kit-builder/in-elementor', $result);
	}

	protected function is_ultimate_builder_editor() {

		if (!$this->in_elementor() && !wp_doing_ajax()) return;
		if (get_post_type() !== Meta::POST_TYPE) return;

		return true;
	}

	/**
	 * Set editor product
	 */

    /**
     * Set editor product
     */
    public function __set_editor_builder_data()
    {

        if (!$this->is_ultimate_builder_editor()) {
            return;
        }

        global $post;

        $templateId = get_transient('ultimate_store_template_id');
        $posts      = get_transient('ultimate_store_template_sample_post');

        if ($posts instanceof \WP_Query && $posts->have_posts() && $templateId == $post->ID) {
            foreach ($posts->posts as $post) {
                $GLOBALS['post'] = $post;
                setup_postdata($post);
            }
        }
    }

//	public function __set_editor_builder_data() {
//
//		if (!$this->is_ultimate_builder_editor()) return;
//
//		global $post, $wp_query;
//
//		$meta     = get_post_meta($post->ID);
//		$postMeta = optional($meta[Meta::TEMPLATE_TYPE])[0];
//		$postMeta = explode('|', $postMeta);
//		$postType = $postMeta[0];
//
//		$args = [
//			'post_type'      => $postType,
//			'post_status'    => ['publish', 'pending', 'draft', 'future'],
//			'posts_per_page' => 1,
//		];
//
//		$sample_product = optional($meta)[Meta::SAMPLE_POST_ID];
//
//		if ($sample_product = optional($sample_product)[0]) {
//			$args['p'] = $sample_product;
//		}
//
//		$wp_query = new \WP_Query($args);
//
//		if ($wp_query->have_posts()) {
//			foreach ($wp_query->posts as $post) {
//				setup_postdata($post);
//			}
//		} else {
//			esc_html_e('Please add at least one product with "publish", "pending", "draft" or "future" status', 'ultimate-store-kit');
//		}
//	}
}
