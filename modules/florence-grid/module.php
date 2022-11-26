<?php

namespace UltimateStoreKit\Modules\FlorenceGrid;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {
	public static function is_active() {
		return class_exists('woocommerce');
	}

	public function get_name() {
		return 'usk-florence-grid';
	}

	public function get_widgets() {
		return ['Florence_Grid'];
	}

	public function add_product_post_class($classes) {
		$classes[] = 'product';

		return $classes;
	}

	public function add_products_post_class_filter() {
		add_filter('post_class', [$this, 'add_product_post_class']);
	}

	public function remove_products_post_class_filter() {
		remove_filter('post_class', [$this, 'add_product_post_class']);
	}

	public function register_wc_hooks() {
		wc()->frontend_includes();
	}

	public $wcqv_plugin_dir_url;

	public function __construct() {

		parent::__construct();

		if (!empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && is_admin()) {
			add_action('init', [$this, 'register_wc_hooks'], 5);
		}

		$this->wcqv_plugin_dir_url = BDTUSK_URL;



		add_action('wp_enqueue_scripts', array($this, 'load_assets'));
		/**
		 * Modal data
		 */
		add_action('wp_ajax_nopriv_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);
		add_action('wp_ajax_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);

		add_action('ultimate_store_kit_wc_product_quick_view_product_sale_flash', 'woocommerce_show_product_sale_flash');
		add_action('ultimate_store_kit_quick_florence_grid_view_product_images', [$this, 'ultimate_store_kit_quick_view_product_images']);
		add_action('ultimate_store_kit_quick_view_product_title', 'woocommerce_template_single_title');
		add_action('ultimate_store_kit_quick_view_product_single_rating', 'woocommerce_template_single_rating');
		add_action('ultimate_store_kit_quick_view_product_single_price', 'woocommerce_template_single_price');
		add_action('ultimate_store_kit_quick_view_product_single_excerpt', 'woocommerce_template_single_excerpt');
		add_action('ultimate_store_kit_quick_view_product_single_add_to_cart', 'woocommerce_template_single_add_to_cart');
		add_action('ultimate_store_kit_quick_view_product_single_meta', 'woocommerce_template_single_meta');
	}

	public function load_assets() {
		// wp_register_script( 'frontend_js', BDTUSK_URL . '/assets/js/widgets/frontend.js', array( 'jquery' ), '1.0', true );
		// wp_enqueue_script( 'frontend_js' );

		wp_enqueue_script('wc-add-to-cart-variation');
		wp_enqueue_script('thickbox');

		wp_enqueue_script('prettyPhoto');
		wp_enqueue_style('woocommerce_prettyPhoto_css');
	}


	public function ultimate_store_kit_wc_product_quick_view_content() {
		$product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
		ultimate_store_kit_wc_product_quick_view_content($product_id);
	}

	public function ultimate_store_kit_quick_view_product_images() {
		ultimate_store_kit_quick_view_product_images();
	}
}
