<?php

namespace UltimateStoreKit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

final class WishlistCompare {
	public function __construct() {
		add_action( 'wp_ajax_usk_add_to_wishlist', [ $this, 'usk_add_to_wishlist' ] );
		add_action( 'wp_ajax_nopriv_usk_add_to_wishlist', [ $this, 'usk_add_to_wishlist' ] );

		add_action( 'wp_ajax_usk_add_to_compare_products', [ $this, 'usk_add_to_compare_products' ] );
		add_action( 'wp_ajax_nopriv_usk_add_to_compare_products', [ $this, 'usk_add_to_compare_products' ] );

		add_action( 'wp_ajax_usk_remove_from_compare_products', [ $this, 'usk_remove_from_compare_products' ] );
		add_action( 'wp_ajax_nopriv_usk_remove_from_compare_products', [ $this, 'usk_remove_from_compare_products' ] );

		//wishlist
		// add_action('woocommerce_account_wishlist_endpoint', [$this, 'usk_wishlist_content']);
		// add_filter('woocommerce_account_menu_items', [$this, 'usk_wishlist_link_my_account']);
		// add_filter('query_vars', [$this, 'usk_wishlist_query_vars'], 0);
		// add_action('init', [$this, 'usk_add_rewrite_flash_rules_endpoint']);
	}

	public function usk_add_to_wishlist() {
		$response = [ 
			'status'  => 0,
			'message' => __( 'Unauthorized!', 'ultimate-store-kit' ),
		];

		if ( ! isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'ultimate-store-kit' );
			wp_send_json( $response );
		}

		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';

		$user_id  = get_current_user_id();
		$wishlist = ultimate_store_kit_get_wishlist( $user_id );

		$wishlistCounter = count( $wishlist );

		if ( ( $key = array_search( $product_id, $wishlist ) ) !== false ) {
			$response['action'] = 'removed';
			$response['count']  = --$wishlistCounter;
			unset( $wishlist[ $key ] );
		} else {
			$response['action'] = 'added';
			$response['count']  = ++$wishlistCounter;
			$wishlist[]         = $product_id;
		}

		$wishlist = array_unique( $wishlist );

		// update wishlist
		$this->ultimate_store_kit_set_wishlist( $wishlist, $user_id );

		// send response
		$response['status'] = 1;

		if ( $response['action'] == 'added' ) {
			$response['message'] = __( "Wishlist item Added!", "ultimate-store-kit" );
			wp_send_json( $response );
		} else {
			$response['message'] = __( "Add To Wishlist", "ultimate-store-kit" );
			wp_send_json( $response );
		}
	}

	public function ultimate_store_kit_set_wishlist( $wishlist, $user_id = 0 ) {
		$_wishlist_key     = '_ultimate_store_kit_wishlist';
		$user_id           = get_current_user_id();
		$existing_wishlist = ultimate_store_kit_get_wishlist( $user_id );

		$wishlist = array_unique( array_merge( $existing_wishlist, $wishlist ) );

		setcookie( $_wishlist_key, json_encode( $wishlist ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}

	public function get_compare_product_page_id() {
		if ( $comparePage = ultimate_store_kit_compare_product_page() ) {
			return $comparePage->ID;
		}
	}


	//======================================
	//=========COMPARE PRODUCTS=============
	//======================================
	public function usk_add_to_compare_products() {
		$response = [ 
			'status'  => 0,
			'message' => __( 'Unauthorized!', 'ultimate-store-kit' ),
		];

		if ( ! isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'ultimate-store-kit' );
			wp_send_json( $response );
		}

		$user_id          = get_current_user_id();
		$compare_products = usk_get_compare_products( $user_id );

		// count compare products
		if ( is_array( $compare_products ) ) {
			$response['count'] = count( $compare_products ) + 1;
		}

		//add to compare products
		$response['action'] = 'added';
		$compare_products[] = $_POST['product_id'];

		$compare_products = array_unique( $compare_products );

		// update compare_productsusk_add_to_compare_products
		$this->ultimate_store_kit_set_compare_products( $compare_products, $user_id );

		// send response
		$response['status'] = 1;
		if ( $response['action'] == 'added' ) {
			$response['message'] = __( "Added", "ultimate-store-kit" );
			$response['url']     = '';
			if ( $pageId = $this->get_compare_product_page_id() ) {
				$response['url'] = get_permalink( $pageId );
			}

			wp_send_json( $response );
		} else {
			$response['message'] = __( "Compare", "ultimate-store-kit" );
			wp_send_json( $response );
		}
	}
	public function usk_remove_from_compare_products() {
		$response = [ 
			'status'  => 0,
			'message' => __( 'Unauthorized!', 'ultimate-store-kit' ),
		];
		if ( ! isset( $_POST['product_id'] ) ) {
			$response['message'] = __( 'No product selected!', 'ultimate-store-kit' );
			wp_send_json( $response );
		}
		$user_id          = get_current_user_id();
		$compare_products = usk_get_compare_products( $user_id );

		//add remove from compare products
		if ( ( $key = array_search( $_POST['product_id'], $compare_products ) ) !== false ) {
			$response['action'] = 'removed';
			unset( $compare_products[ $key ] );
		}
		$compare_products = array_unique( $compare_products );

		// update compare_products
		$this->ultimate_store_kit_set_compare_products( $compare_products, $user_id );

		// send response
		$response['status']  = 1;
		/* translators: %s is the action performed on the compared product */
		$response['message'] = sprintf( __( 'Compared product item: %s.', 'ultimate-store-kit' ), $response['action'] );
		
		wp_send_json( $response );
	}
	public function ultimate_store_kit_set_compare_products( $compare_products, $user_id = 0 ) {
		$_compare_products_key = '_ultimate_store_kit_compare_products';
		$_compare_products     = [];

		if ( $user_id != 0 ) {
			update_user_meta( $user_id, $_compare_products_key, $compare_products );
		} else {
			setcookie( $_compare_products_key, json_encode( $compare_products ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		}
	}
}

new WishlistCompare();
