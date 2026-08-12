<?php

namespace UltimateStoreKit\Includes\Builder;

class Builder_Template_Helper {

	public static function isTemplateEditMode() {
		if ( get_post_type() == Meta::POST_TYPE ) {
			return true;
		}

		if ( isset( $_REQUEST[ Meta::POST_TYPE ] ) ) {
			return true;
		}
	}

	public static function separator() {
		return '|';
	}

	public static function templates( $single = false ) {
		$shop_item = [ 
			'shop'           => 'Shop Page',
			'archive'        => 'Archive Page',
			'single'         => 'Single Page',
			'category'       => 'Category Page',
			'tag'            => 'Tag Page',
			'cart'           => 'Cart Page',
			'checkout'       => 'Checkout',
			'order-received' => 'Order Received (Thank You Page)',
		];

		$my_account = [ 
			'login'        => 'Login & Register',
			'myaccount'    => 'Dashboard',
			'orders'       => 'Orders',
			'downloads'    => 'Downloads',
			'edit-address' => 'Address',
			'edit-account' => 'Account Details',
			'wishlist'     => 'Wishlist',
			'logout'       => 'Customer Logout',
		];

		// Endpoints that belong to the order/checkout flow rather than the
		// authenticated account area. Everything else from WC()->query is treated
		// as an account screen so the dropdown grouping matches the routing in
		// Builder_Integration::setFrontendTemplate(), which looks endpoint
		// templates up under the `account` post-type group.
		$order_flow_endpoints = apply_filters(
			'ultimate_store_kit_builder_order_flow_endpoints',
			[ 'order-pay', 'order-received' ]
		);

		if ( $wcItems = WC()->query->get_query_vars() ) {
			foreach ( $wcItems as $key => $item ) {
				$label = ucwords( str_replace( '-', ' ', $key ) );
				if ( in_array( $key, $order_flow_endpoints, true ) ) {
					// Keep hand-written labels (e.g. order-received) intact.
					if ( ! isset( $shop_item[ $key ] ) ) {
						$shop_item[ $key ] = $label;
					}
				} else {
					$my_account[ $key ] = $label;
				}
			}
		}

		$product = [ 
			'product' => $shop_item,
			'account' => $my_account,
		];

		$templates = apply_filters(
			'ultimate_store_kit_builder_templates',
			$product
		);

		if ( $single ) {
			$separator = static::separator();
			$return    = [];
			if ( is_array( $templates ) && ! empty( $templates ) ) {
				foreach ( $templates as $keys => $items ) {
					if ( is_array( $items ) ) {
						foreach ( $items as $itemKey => $item ) {
							$return[ "{$keys}{$separator}{$itemKey}" ] = $item;
						}
					}
				}
			}

			return apply_filters(
				'ultimate_store_kit_builder_all_templates',
				$return
			);
		}

		return $templates;
	}

	public static function templateForSelectDropdown() {
		return static::templates();
	}

	public static function getTemplateByIndex( $index ) {
		$index     = trim( $index );
		$templates = static::templates( true );

		return array_key_exists( $index, $templates ) ? $templates[ $index ] : false;
	}

	public static function getTemplatePostTypeByIndex( $index ) {
		$index = trim( $index );
		if ( $item = explode( static::separator(), $index ) ) {
			return get_post_type_object( $item[0] );
		}
	}

	public static function is_elementor_active() {
		return did_action( 'elementor/loaded' );
	}

	public static function getTemplate( $slug, $postType = false ) {
		if ( ! $postType ) {
			$postType = get_post_type();
		}

		$separator       = static::separator();
		$template        = strtolower( "{$postType}{$separator}{$slug}" );
		$enabledTemplate = strtolower( Meta::TEMPLATE_ID . $template );

		/**
		 * important area for debugging
		 */

		return get_option( $enabledTemplate );
	}

	public static function getTemplateId( $templateType ) {
		$metaIndex = strtolower( Meta::TEMPLATE_ID . $templateType );
		return intval( get_option( $metaIndex ) );
	}
}
