<?php
/**
 * Register page wrapper for the Ultimate Store Kit builder.
 *
 * Loaded by Builder_Integration::setFrontendTemplate() when a logged-out
 * visitor hits the My Account page with `?action=register` (or the
 * `ultimate_store_kit/account/auth_intent` filter returns 'register')
 * and the site has an enabled `account|register` template.
 *
 * @package UltimateStoreKit
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

use UltimateStoreKit\Builder\Builder_Integration;

get_header('shop');

do_action('woocommerce_before_main_content');

if (function_exists('wc_print_notices')) {
	wc_print_notices();
}

$usk_template_id = Builder_Integration::instance()->current_template_id;

$usk_has_content = false;
if ($usk_template_id && class_exists('Elementor\Plugin')) {
	$usk_elementor_data = get_post_meta($usk_template_id, '_elementor_data', true);

	if (is_string($usk_elementor_data)) {
		$decoded = json_decode($usk_elementor_data, true);
		$usk_has_content = is_array($decoded) && ! empty($decoded);
	} elseif (is_array($usk_elementor_data)) {
		$usk_has_content = ! empty($usk_elementor_data);
	}
}

do_action('woocommerce_before_customer_login_form');

if ($usk_has_content) {
	echo Elementor\Plugin::instance()->frontend->get_builder_content($usk_template_id, false);
} else {
	// Fallback: WC's stock form-login.php renders both login + registration
	// (when registration is enabled in WooCommerce > Settings > Accounts).
	wc_get_template('myaccount/form-login.php');
}

do_action('woocommerce_after_customer_login_form');

do_action('woocommerce_after_main_content');

get_footer('shop');
