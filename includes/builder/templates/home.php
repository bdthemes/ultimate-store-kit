<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

use UltimateStoreKit\Builder\Builder_Integration;

get_header();

do_action('ultimate-store-kit-builder/woocommerce/before-main-content');

if (class_exists('Elementor\Plugin')) {
	echo Elementor\Plugin::instance()->frontend->get_builder_content(Builder_Integration::instance()->current_template_id, false);
}

do_action('ultimate-store-kit-builder/woocommerce/after-main-content');
get_footer();
