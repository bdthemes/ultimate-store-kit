<?php

namespace UltimateStoreKit\Builder;

use Elementor\Plugin;
use UltimateStoreKit\Modules\PageCart\Widgets\Page_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cart_Render {

	/**
	 * Whether the Page Cart widget can be rendered on the storefront.
	 */
	public static function is_available() {
		return function_exists( 'WC' ) && self::is_widget_registered( Page_Cart::WIDGET_NAME );
	}

	/**
	 * Output cart page content for the builder cart template.
	 *
	 * Priority: Theme Builder cart template → Elementor cart page → widget fallback.
	 *
	 * @param int|null $builder_template_id Assigned Theme Builder cart template ID.
	 */
	public static function render_cart_page( $builder_template_id = null ) {
		$builder_template_id = absint( $builder_template_id );

		if ( $builder_template_id && self::echo_template_content( $builder_template_id ) ) {
			return;
		}

		$cart_page_content = self::get_wc_page_elementor_content( wc_get_page_id( 'cart' ) );

		if ( $cart_page_content ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $cart_page_content;

			return;
		}

		self::render_widget();
	}

	/**
	 * Render Elementor content from a WooCommerce page built with Elementor.
	 *
	 * @param int $page_id Page ID.
	 * @return string
	 */
	protected static function get_wc_page_elementor_content( $page_id ) {
		$page_id = absint( $page_id );

		if ( ! $page_id || ! did_action( 'elementor/loaded' ) ) {
			return '';
		}

		if ( ! Plugin::instance()->db->is_built_with_elementor( $page_id ) ) {
			return '';
		}

		return Plugin::instance()->frontend->get_builder_content_for_display( $page_id );
	}

	/**
	 * Render the Page Cart widget with default settings (fallback).
	 *
	 * @param array $settings Optional widget settings.
	 */
	public static function render_widget( array $settings = [] ) {
		if ( ! self::is_available() ) {
			return;
		}

		self::enqueue_assets();

		$widget_type = Plugin::instance()->widgets_manager->get_widget_types( Page_Cart::WIDGET_NAME );

		if ( ! $widget_type ) {
			return;
		}

		$element = Plugin::instance()->elements_manager->create_element_instance(
			[
				'elType'     => 'widget',
				'widgetType' => Page_Cart::WIDGET_NAME,
				'id'         => Page_Cart::WIDGET_NAME . '-fallback',
				'settings'   => wp_parse_args( $settings, Page_Cart::get_default_settings() ),
				'elements'   => [],
			],
			[],
			$widget_type
		);

		if ( ! $element ) {
			return;
		}

		ob_start();
		$element->render_content();
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo ob_get_clean();
	}

	/**
	 * Whether an Elementor widget is registered.
	 *
	 * @param string $widget_slug Widget slug.
	 */
	protected static function is_widget_registered( $widget_slug ) {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		return (bool) Plugin::instance()->widgets_manager->get_widget_types( $widget_slug );
	}

	/**
	 * Render saved Elementor builder template content.
	 *
	 * @param int $template_id Builder template post ID.
	 * @return bool Whether content was rendered.
	 */
	protected static function echo_template_content( $template_id ) {
		$template_id = absint( $template_id );

		if ( ! $template_id ) {
			return false;
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo Plugin::instance()->frontend->get_builder_content( $template_id, false );

		return true;
	}

	/**
	 * Enqueue Page Cart widget styles on fallback render.
	 */
	protected static function enqueue_assets() {
		foreach ( Page_Cart::get_frontend_style_handles() as $style_handle ) {
			if ( ! wp_style_is( $style_handle, 'enqueued' ) ) {
				wp_enqueue_style( $style_handle );
			}
		}
	}
}
