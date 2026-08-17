<?php
/**
 * Login & Register page wrapper for the Ultimate Store Kit builder.
 *
 * Loaded by Builder_Integration::setFrontendTemplate() when a logged-out
 * visitor lands on the My Account page and the site has an enabled
 * `account|login` template. A single template handles both authentication
 * flows because WooCommerce's own form-login.php renders the login and
 * registration forms on the same URL — there is no separate /register/
 * endpoint in WooCommerce.
 *
 * @package UltimateStoreKit
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- usk_ / BDTUSK_ / ultimate-store-kit- are this plugin's established public prefixes. Ultimate Store Kit Pro calls into these names, as does third-party integration code, so renaming them is a breaking change. Plugin Check only recognises prefixes derived verbatim from the slug and so reports them as unprefixed.

use UltimateStoreKit\Builder\Builder_Integration;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * Standard WC layout hook — themes rely on this to open their wrappers
 * (woocommerce_output_content_wrapper). Keeping it lets the login page
 * inherit the theme's account-area layout instead of escaping it.
 */
do_action('woocommerce_before_main_content');

// Display WooCommerce notices (login errors, password-reset success, etc.).
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
	echo Elementor\Plugin::instance()->frontend->get_builder_content($usk_template_id, false); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor renders and escapes the builder content itself.
} else {
	// Fallback to WC's stock login/register form so the page is never empty.
	wc_get_template('myaccount/form-login.php');
}

do_action('woocommerce_after_customer_login_form');

do_action('woocommerce_after_main_content');

get_footer('shop');
