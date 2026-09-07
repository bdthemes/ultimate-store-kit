<?php

namespace UltimateStoreKit;

if (! defined('ABSPATH')) {
	exit;
}

// Exit if accessed directly

final class WishlistCompare {
	public function __construct() {
		add_action('wp_ajax_usk_add_to_wishlist', [$this, 'usk_add_to_wishlist']);
		add_action('wp_ajax_nopriv_usk_add_to_wishlist', [$this, 'usk_add_to_wishlist']);

		add_action('wp_ajax_usk_remove_wishlist', [$this, 'usk_remove_wishlist']);
		add_action('wp_ajax_nopriv_usk_remove_wishlist', [$this, 'usk_remove_wishlist']);

		add_action('wp_ajax_usk_add_to_compare_products', [$this, 'usk_add_to_compare_products']);
		add_action('wp_ajax_nopriv_usk_add_to_compare_products', [$this, 'usk_add_to_compare_products']);

		add_action('wp_ajax_usk_remove_from_compare_products', [$this, 'usk_remove_from_compare_products']);
		add_action('wp_ajax_nopriv_usk_remove_from_compare_products', [$this, 'usk_remove_from_compare_products']);

		//wishlist
		// add_action('woocommerce_account_wishlist_endpoint', [$this, 'usk_wishlist_content']);
		// add_filter('woocommerce_account_menu_items', [$this, 'usk_wishlist_link_my_account']);
		// add_filter('query_vars', [$this, 'usk_wishlist_query_vars'], 0);
		// add_action('init', [$this, 'usk_add_rewrite_flash_rules_endpoint']);
	}

	/**
	 * CSRF check for the wishlist/compare endpoints.
	 *
	 * A logged-out visitor's list lives entirely in their own cookie, and their
	 * pages are routinely served from a full-page cache where an embedded nonce
	 * would already be stale — enforcing one there breaks the feature without
	 * protecting any server-side state. A logged-in request writes to user meta,
	 * so that path gets the check.
	 */
	private function verify_request() {
		if (! is_user_logged_in()) {
			return;
		}

		check_ajax_referer('usk_wishlist_compare', 'nonce');
	}

	// Every handler below calls verify_request() first, which PHPCS cannot follow.
	// See its docblock for why the logged-out path is deliberately exempt.
	// phpcs:disable WordPress.Security.NonceVerification.Missing

	public function usk_add_to_wishlist() {
		$this->verify_request();

		$response = [
			'status'  => 0,
			'message' => __('Unauthorized!', 'ultimate-store-kit'),
		];

		if (! isset($_POST['product_id'])) {
			$response['message'] = __('No product selected!', 'ultimate-store-kit');
			wp_send_json($response);
		}

		$product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;

		$user_id  = get_current_user_id();
		$wishlist = ultimate_store_kit_get_wishlist($user_id);

		$wishlistCounter = count($wishlist);

		if (($key = array_search($product_id, $wishlist)) !== false) {
			$response['action'] = 'removed';
			$response['count']  = --$wishlistCounter;
			unset($wishlist[$key]);
		} else {
			// Only gate additions. A removal just drops an id the visitor already
			// holds, so it must keep working even if the product was since unpublished.
			if (! ultimate_store_kit_is_public_product($product_id)) {
				$response['message'] = __('Invalid product!', 'ultimate-store-kit');
				wp_send_json($response);
			}

			if ($wishlistCounter >= ultimate_store_kit_get_list_item_limit()) {
				$response['message'] = __('Wishlist is full!', 'ultimate-store-kit');
				wp_send_json($response);
			}

			$response['action'] = 'added';
			$response['count']  = ++$wishlistCounter;
			$wishlist[]         = $product_id;
		}

		$wishlist = array_unique($wishlist);

		// update wishlist
		$this->ultimate_store_kit_set_wishlist($wishlist, $user_id);

		// send response
		$response['status'] = 1;

		if ($response['action'] == 'added') {
			$response['message'] = __("Wishlist item Added!", "ultimate-store-kit");
			wp_send_json($response);
		} else {
			$response['message'] = __("Add To Wishlist", "ultimate-store-kit");
			wp_send_json($response);
		}
	}

	/**
	 * Remove a single product from the wishlist.
	 *
	 * Deliberately idempotent rather than a toggle: the remove control is bound by
	 * more than one script, so a click can fire this twice. A toggle would remove
	 * the product and then immediately put it back.
	 */
	public function usk_remove_wishlist() {
		$this->verify_request();

		$response = [
			'status'  => 0,
			'message' => __('Unauthorized!', 'ultimate-store-kit'),
		];

		if (! isset($_POST['product_id'])) {
			$response['message'] = __('No product selected!', 'ultimate-store-kit');
			wp_send_json($response);
		}

		$product_id = absint($_POST['product_id']);
		$user_id    = get_current_user_id();
		$wishlist   = ultimate_store_kit_get_wishlist($user_id);

		if (($key = array_search($product_id, $wishlist)) !== false) {
			unset($wishlist[$key]);
		}

		$this->ultimate_store_kit_set_wishlist($wishlist, $user_id);

		// Report the post-condition, not what this particular call changed, so a
		// duplicate request still tells the UI the row is gone.
		$response['status']  = 1;
		$response['action']  = 'removed';
		$response['count']   = count($wishlist);
		$response['message'] = __('Wishlist item removed!', 'ultimate-store-kit');

		wp_send_json($response);
	}

	/**
	 * Persist the wishlist.
	 *
	 * @param array $wishlist Full list to store — this replaces what is stored.
	 * @param int   $user_id  Unused; kept for signature compatibility. The wishlist
	 *                        is cookie-backed for every visitor, logged in or not.
	 */
	public function ultimate_store_kit_set_wishlist($wishlist, $user_id = 0) {
		$_wishlist_key = '_ultimate_store_kit_wishlist';

		// Straight write, not a merge. This previously merged the incoming list back
		// into the stored one, which silently undid every removal — nothing could
		// ever leave a wishlist. Reindexed because unset() leaves a gap, and a gapped
		// array json_encodes to an object that the getter then discards.
		$wishlist = array_values(array_unique($wishlist));

		setcookie($_wishlist_key, wp_json_encode($wishlist), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
	}

	public function get_compare_product_page_id() {
		// ultimate_store_kit_compare_product_page() already returns an int post id.
		// Reading ->ID off it warned under PHP 8 and evaluated to null, so the
		// "Added" response never carried a compare page URL.
		return ultimate_store_kit_compare_product_page();
	}


	//======================================
	//=========COMPARE PRODUCTS=============
	//======================================
	public function usk_add_to_compare_products() {
		$this->verify_request();

		$response = [
			'status'  => 0,
			'message' => __('Unauthorized!', 'ultimate-store-kit'),
		];

		if (! isset($_POST['product_id'])) {
			$response['message'] = __('No product selected!', 'ultimate-store-kit');
			wp_send_json($response);
		}

		$product_id = absint($_POST['product_id']);

		if (! ultimate_store_kit_is_public_product($product_id)) {
			$response['message'] = __('Invalid product!', 'ultimate-store-kit');
			wp_send_json($response);
		}

		$user_id          = get_current_user_id();
		$compare_products = ultimate_store_kit_get_compare_products($user_id);

		if (! is_array($compare_products)) {
			$compare_products = [];
		}

		if (count($compare_products) >= ultimate_store_kit_get_list_item_limit() && ! in_array($product_id, $compare_products)) {
			$response['message'] = __('Compare list is full!', 'ultimate-store-kit');
			wp_send_json($response);
		}

		// count compare products
		$response['count'] = count($compare_products) + 1;

		//add to compare products
		$response['action'] = 'added';
		$compare_products[] = $product_id;

		$compare_products = array_unique($compare_products);

		// update compare_productsusk_add_to_compare_products
		$this->ultimate_store_kit_set_compare_products($compare_products, $user_id);

		// send response
		$response['status'] = 1;
		if ($response['action'] == 'added') {
			$response['message'] = __("Added", "ultimate-store-kit");
			$response['url']     = '';
			if ($pageId = $this->get_compare_product_page_id()) {
				$response['url'] = get_permalink($pageId);
			}

			wp_send_json($response);
		} else {
			$response['message'] = __("Compare", "ultimate-store-kit");
			wp_send_json($response);
		}
	}
	public function usk_remove_from_compare_products() {
		$this->verify_request();

		$response = [
			'status'  => 0,
			'message' => __('Unauthorized!', 'ultimate-store-kit'),
		];
		if (! isset($_POST['product_id'])) {
			$response['message'] = __('No product selected!', 'ultimate-store-kit');
			wp_send_json($response);
		}
		$product_id       = absint($_POST['product_id']);
		$user_id          = get_current_user_id();
		$compare_products = ultimate_store_kit_get_compare_products($user_id);

		//add remove from compare products
		if (($key = array_search($product_id, $compare_products)) !== false) {
			$response['action'] = 'removed';
			unset($compare_products[$key]);
		}

		// Reindex: unset() leaves a gap, and a gapped array json_encodes to an
		// object, which breaks the cookie read back in ultimate_store_kit_get_compare_products().
		$compare_products = array_values(array_unique($compare_products));

		// update compare_products
		$this->ultimate_store_kit_set_compare_products($compare_products, $user_id);

		// send response
		$response['status']  = 1;
		/* translators: %s is the action performed on the compared product */
		$response['message'] = sprintf(__('Compared product item: %s.', 'ultimate-store-kit'), $response['action']);

		wp_send_json($response);
	}
	public function ultimate_store_kit_set_compare_products($compare_products, $user_id = 0) {
		$_compare_products_key = '_ultimate_store_kit_compare_products';
		$_compare_products     = [];

		if ($user_id != 0) {
			update_user_meta($user_id, $_compare_products_key, $compare_products);
		} else {
			setcookie($_compare_products_key, json_encode($compare_products), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
		}
	}

	// phpcs:enable WordPress.Security.NonceVerification.Missing
}

new WishlistCompare();
