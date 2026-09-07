<?php

namespace UltimateStoreKit\Includes\Builder;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use  UltimateStoreKit\Base\Singleton;

class Builder_Post_Singleton {
    use Singleton;

    public static function set_sample_post($postId = null) {
        global $post;

        if (!$postId) {
            $postId = $post->ID;
        }

        $meta = get_post_meta($postId);

        $templateMeta = ultimate_store_kit_optional($meta)[Meta::TEMPLATE_TYPE];

        if (!isset($templateMeta[0])) {
            return;
        }

        $postMeta = $templateMeta[0];
        $postMeta = explode('|', $postMeta);
        $postType = $postMeta[0];

        $args = [
            'post_type' => $postType,
            'post_status' => ['publish', 'pending', 'draft', 'future'],
            'posts_per_page' => 1,
        ];

        $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
        $page_settings_model = $page_settings_manager->get_model($postId);
        $sample_product = $page_settings_model->get_settings('usk_builder_sample_post_id');

        if ($sample_product) {
            $args['p'] = $sample_product;
        }

        $wp_query = new \WP_Query($args);

        if ($wp_query->have_posts()) {
            $post = $wp_query->posts[0];
            // An explicit lifetime is required: a transient stored with no expiry is
            // autoloaded on every request, so these editor-preview handoffs otherwise
            // accumulate one permanent wp_options row per user who opens the builder.
            set_transient('ultimate_store_kit_template_id_' . get_current_user_id(), $postId, HOUR_IN_SECONDS);
            set_transient('ultimate_store_kit_template_sample_post_' . get_current_user_id(), $wp_query, HOUR_IN_SECONDS);
            $GLOBALS['post'] = $post;
            setup_postdata($post);
        }
    }
}
