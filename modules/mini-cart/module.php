<?php

namespace UltimateStoreKit\Modules\MiniCart;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {


	const TEMPLATE_MINI_CART = 'cart/mini-cart.php';
	const OPTION_NAME_USE_MINI_CART = 'use_mini_cart_template';

	public function __construct() {

		parent::__construct();

		wp_enqueue_script( 'wc-cart-fragments' );

		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'ultimate_store_kit_mini_cart_fragment' ] );
		add_filter( 'woocommerce_locate_template', [ $this, 'woocommerce_locate_template' ], 12, 3 );
	}

	public function render_markup() {
		?>
		<div class="toolset">
			<div class="ts-container">
				<div class="ts-nav-container"></div>
				<div class="ts-content-container">
					<div id="first" class="ts-content-item">
						<div class="widget_shopping_cart_content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function get_name() {
		return 'usk-mini-cart';
	}

	public function get_widgets() {

		$widgets = [ 'Mini_Cart' ];

		return $widgets;
	}

	public function woocommerce_locate_template( $template, $template_name, $template_path ) {

		if ( self::TEMPLATE_MINI_CART !== $template_name ) {
			return $template;
		}

		$plugin_path = BDTUSK_MODULES_PATH . 'mini-cart/templates/';

		if ( file_exists( $plugin_path . $template_name ) ) {
			$template = $plugin_path . $template_name;
		}

		return $template;
	}

	public function ultimate_store_kit_mini_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();

		?>
		<span class="usk-mini-cart-inner">
			<span class="usk-cart-button-text">
				<span class="usk-mini-cart-price-amount">
					<?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?>
				</span>
			</span>
			<span class="usk-mini-cart-button-icon">
				<span class="usk-cart-badge">
					<?php echo wp_kses_post( WC()->cart->get_cart_contents_count() ); ?>
				</span>
				<span class="usk-cart-icon">
					<i class="usk-icon-cart" aria-hidden="true"></i>
				</span>
			</span>
		</span>
		<?php
		$fragments['div.usk-mini-cart-toggle-btn .usk-mini-cart-inner'] = ob_get_clean();

		return $fragments;
	}
}
