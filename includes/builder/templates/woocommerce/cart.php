<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

use UltimateStoreKit\Builder\Builder_Integration;
use UltimateStoreKit\Builder\Cart_Render;

get_header( 'shop' );

do_action( 'woocommerce_before_cart' );

if ( Cart_Render::is_available() ) {
	Cart_Render::render_cart_page( Builder_Integration::instance()->current_template_id );
}

do_action( 'woocommerce_after_cart' );

get_footer( 'shop' );
