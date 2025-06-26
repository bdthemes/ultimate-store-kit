<?php

namespace UltimateStoreKit\Builder;

if (! defined('WPINC')) {
	die;
}

use Elementor\Controls_Manager;
use Elementor\Plugin;
use UltimateStoreKit\Includes\Builder\Builder_Template_Helper;
use UltimateStoreKit\Base\Singleton;
use UltimateStoreKit\Includes\Builder\Meta;
use UltimateStoreKit\Includes\Controls\SelectInput\Dynamic_Select;


class Builder_Integration {

	use Singleton;

	private $current_template = null;
	public $current_template_id = null;

	function __construct() {
		add_filter('template_include', [$this, 'set_builder_template'], 9999);
		add_action('elementor/editor/init', [$this, 'set_sample_post'], 999);

		add_action('print_default_editor_scripts', array($this, 'my_custom_fonts'));
		add_filter("elementor/document/urls/wp_preview", [$this, 'change_preview_editor_url'], 999, 2);

		add_action('elementor/documents/register_controls', [$this, 'register_document_controls']);

		// Add demo bypass filter for template preview
		add_filter('ultimate_store_kit/preview/verified_bypass', function ($verify) {
			// Check if we're in a demo environment or development site
			// For demo sites, you might want to check domain names or other indicators
			$demo_hosts = apply_filters('ultimate_store_kit/demo_hosts', [
				'storekit.pro',
				'demo.storekit.pro',
				'localhost',
				'127.0.0.1'
			]);

			$current_host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field($_SERVER['HTTP_HOST']) : '';

			foreach ($demo_hosts as $host) {
				if (strpos($current_host, $host) !== false) {
					return true;
				}
			}

			return $verify;
		});

		// Add filter to enable demo mode for preview URLs
		add_filter('ultimate_store_kit/preview/use_demo_bypass', function ($use_demo) {
			// Enable demo bypass in Elementor editor
			if (isset($_GET['action']) && $_GET['action'] === 'elementor') {
				return true;
			}
			return $use_demo;
		});
	}

	public function change_preview_editor_url($url, $document) {
		$post_id = $document->get_main_id();
		$template_type = get_post_meta($post_id, Meta::TEMPLATE_TYPE, true);

		if (empty($template_type) || get_post_type($post_id) !== Meta::POST_TYPE) {
			return $url;
		}

		$template_data = explode(Builder_Template_Helper::separator(), $template_type);
		if (count($template_data) < 2) {
			return $url;
		}

		$post_type = $template_data[0];
		$template_slug = $template_data[1];

		// Get template URL based on template type
		$template_url = '';

		// Check for product category first
		if ($template_slug === 'product-category') {
			$product_cats = get_terms([
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'number'     => 1,
			]);

			if (!empty($product_cats) && !is_wp_error($product_cats)) {
				$template_url = get_term_link($product_cats[0]);
			}
		}

		// Check for product tag
		elseif ($template_slug === 'product-tag') {
			$product_tags = get_terms([
				'taxonomy'   => 'product_tag',
				'hide_empty' => true,
				'number'     => 1,
			]);

			if (!empty($product_tags) && !is_wp_error($product_tags)) {
				$template_url = get_term_link($product_tags[0]);
			}
		}

		elseif ($template_slug === 'shop' || $template_slug === 'archive') {
			$template_url = get_permalink(wc_get_page_id('shop'));
		}

		elseif ($template_slug === 'single' && $post_type === 'product') {
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
			$page_settings_model = $page_settings_manager->get_model($post_id);
			$sample_product = $page_settings_model->get_settings('usk_builder_sample_post_id');

			$template_url = !empty($sample_product) ?
				get_permalink($sample_product) :
				$this->get_default_product_url();
		}

		elseif ($template_slug === 'cart') {
			$template_url = wc_get_cart_url();
		}

		elseif ($template_slug === 'checkout') {
			$template_url = wc_get_checkout_url();
		}

		elseif ($template_slug === 'myaccount' || strpos($template_slug, 'myaccount-') === 0) {
			$template_url = get_permalink(wc_get_page_id('myaccount'));
		}

		elseif ($template_slug === 'order-received') {
			$orders = wc_get_orders(['limit' => 1]);
			if (!empty($orders)) {
				$order = $orders[0];
				$order_id = $order->get_id();
				$template_url = add_query_arg('order-received', $order_id, wc_get_checkout_url());
			}
		}

		if (empty($template_url)) {
			return $url;
		}

		$is_demo = apply_filters('ultimate_store_kit/preview/use_demo_bypass', false);
		$nonce_value = $is_demo ? 'verified' : wp_create_nonce('template_preview_' . $post_id);

		$param = [
			'usk_template_id' => $post_id,
			'preview_nonce' => $nonce_value,
			'preview' => true
		];

		// Add parameters two URL
		$url = add_query_arg($param, $template_url);

		return $url;
	}

	public function my_custom_fonts() {
		if (is_admin() && Plugin::instance()->editor->is_edit_mode()) {
			if (isset($_REQUEST['usk-template'])) {
				wp_register_style('usk-template-builder-hide-preview-btn-inline', false); // phpcs:ignore
				wp_enqueue_style('usk-template-builder-hide-preview-btn-inline');
				wp_add_inline_style(
					'usk-template-builder-hide-preview-btn-inline',
					'#elementor-panel-footer-saver-preview {display:none!important}'
				);
			}
		}
	}
	function set_sample_post() {
		if (Builder_Template_Helper::isTemplateEditMode()) {
			$object = \UltimateStoreKit\Includes\Builder\Builder_Post_Singleton::instance();
			$object::set_sample_post();
		}
	}

	function register_document_controls($document) {
		if (
			! $document instanceof \Elementor\Core\DocumentTypes\PageBase
			|| ! $document::get_property('has_elements')
		) {
			return;
		}

		if (Plugin::instance()->preview->is_preview_mode())
			return;

		if (! Builder_Template_Helper::isTemplateEditMode()) {
			return;
		}

		global $post;

		if (! isset($post->ID)) {
			return;
		}
		$meta = get_post_meta($post->ID);

		$templateMeta = optional($meta)[Meta::TEMPLATE_TYPE];
		if (! isset($templateMeta[0])) {
			return;
		}
		$postMeta = $templateMeta[0];
		$postMeta = explode('|', $postMeta);
		$postType = $postMeta[0];

		if ($postMeta[1] != 'single') {
			return;
		}

		$document->start_controls_section(
			'usk_page_setting_preview',
			[
				'label' => esc_html__('Builder Settings', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'usk_builder_sample_post_id',
			[
				'label'       => __('Builder Post', 'ultimate-store-kit'),
				'type'        => Dynamic_Select::TYPE,
				'multiple'    => false,
				'label_block' => true,
				'query_args'  => [
					'post_type' => $postType
				],
			]
		);

		$document->add_control(
			'usk_builder_sample_apply_preview',
			[
				'type'        => Controls_Manager::BUTTON,
				'label'       => esc_html__('Apply & Preview', 'ultimate-store-kit'),
				'label_block' => true,
				'show_label'  => false,
				'text'        => esc_html__('Apply & Preview', 'ultimate-store-kit'),
				'separator'   => 'none',
				'event'       => 'ultimateStoreKitBuilderSetting:applySinglePagePostOnPreview',
			]
		);

		$document->end_controls_section();
	}

	/**
	 * Rewrite default template
	 *
	 */
	function set_builder_template($template) {
		if (Builder_Template_Helper::isTemplateEditMode()) {
			return $this->setBackendTemplate($template);
		} else {
			return $this->setFrontendTemplate($template);
		}
	}


	protected function setBackendTemplate($template) {
		return $template;
	}


	protected function setFrontendTemplate($template) {

		if (get_post_type() == 'product') {
			global $product;
			$product = wc_get_product();
		}

		if (defined('ELEMENTOR_PATH')) {
			$elementorTem = ELEMENTOR_PATH . "modules/page-templates/templates/";
			$elementorTem = explode($elementorTem, $template);
			if (count($elementorTem) == 2) {
				return $template;
			}
		}

		
		if (is_post_type_archive('product') || is_page(wc_get_page_id('shop')) || is_product_taxonomy()) {
			$template_type = 'shop';
			
			if (is_tax('product_cat')) {
				$template_type = 'category';
			} elseif (is_tax('product_tag')) {
				$template_type = 'tag';
			}
			
			if ($custom_template = $this->get_template_id($template_type)) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('woocommerce/archive-product', $template);
			}
		}
		

		if (is_cart()) {
			if ($custom_template = $this->get_template_id('cart', 'product')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('woocommerce/cart', $template);
			}
		}

		if (is_order_received_page()) {
			if ($custom_template = $this->get_template_id('order-received', 'product')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('woocommerce/order-received', $template);
			}
		}

		if (is_checkout()) {
			if ($custom_template = $this->get_template_id('checkout', 'product')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('woocommerce/checkout', $template);
			}
		}

		if (is_single() && get_post_type() == 'product') {
			if ($custom_template = $this->get_template_id('single', 'product')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('woocommerce/single-product', $template);
			}
		}

		if (is_account_page()) {
			global $wp;
			$query_vars = WC()->query->get_query_vars();

			/**
			 * Add wishlist endpoint
			 */
			$query_vars['wishlist'] = 'wishlist';

			if ($endpoint = array_intersect_key($wp->query_vars, $query_vars)) {
				$endpoint = array_key_first($endpoint);

				if ($endpoint && $custom_template = $this->get_template_id($endpoint, 'account')) {
					$this->current_template_id = $custom_template;

					if ($newTemplate = $this->getTemplatePath("woocommerce/{$endpoint}")) {
						return $newTemplate;
					}

					return $this->getTemplatePath("woocommerce/my-account", '');
				}

				if ($custom_template = $this->get_template_id('myaccount-orders', 'account')) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath('woocommerce/my-account', $template);
				}
			} else {
				if ($custom_template = $this->get_template_id('myaccount', 'account')) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath('woocommerce/my-account', $template);
				}
			}
		}


		if (is_single()) {
			if ($custom_template = $this->get_template_id('single', 'post')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('single-post', $template);
			}
		}

		if (is_archive()) {
			if ($custom_template = $this->get_template_id('archive', 'post')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('archive-post', $template);
			}
		}

		if (is_home()) {
			if ($custom_template = $this->get_template_id('home', 'post')) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath('home', $template);
			}
		}

		if ($page_Id = intval(get_option('bdt_usk_compare_products_page_id'))) {
			if (is_page($page_Id)) {
				if ($custom_template = $this->get_template_id('compare-products', 'product')) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath('home', $template);
				}
			}
		}

		return $template;
	}


	public function getThemeTemplatePath($slug) {

		$fullPath = get_template_directory() . "/ultimate-store-kit/$slug";
		if (file_exists($fullPath)) {
			return $fullPath;
		}
	}

	public function getPluginTemplatePath($slug) {

		$fullPath = BDTUSK_PATH . "includes/builder/templates/$slug";
		if (file_exists($fullPath)) {
			return $fullPath;
		}
	}


	/**
	 * Get Template Path ID
	 *
	 * @param $slug
	 * @param $postType
	 *
	 * @return mixed|void|null
	 */
	public function get_template_id($slug, $postType = false) {
		// If we already have a template ID for this request, return it
		if (null !== $this->current_template_id) {
			return $this->current_template_id;
		}

		// Handle template preview from URL parameters
		if (!empty($_GET['preview']) && !empty($_GET['usk_template_id']) && !empty($_GET['preview_nonce'])) {
			$usk_template_id = sanitize_text_field(wp_unslash($_GET['usk_template_id']));
			$nonce = sanitize_text_field(wp_unslash($_GET['preview_nonce']));

			// Special handling for demo bypass
			$is_demo_bypass = ($nonce === 'verified');
			$nonce_verified = $is_demo_bypass ?
				apply_filters('ultimate_store_kit/preview/verified_bypass', false) :
				wp_verify_nonce($nonce, 'template_preview_' . $usk_template_id);

			if ($nonce_verified) {
				// For demo bypass mode, we don't need to check template type
				if ($is_demo_bypass) {
					$this->current_template_id = (int)$usk_template_id;
					return $this->current_template_id;
				}

				// For normal preview, check template type
				$template_type = get_post_meta($usk_template_id, Meta::TEMPLATE_TYPE, true);
				if (!empty($template_type)) {
					$template_data = explode(Builder_Template_Helper::separator(), $template_type);
					if (count($template_data) >= 2 && $template_data[1] === $slug && ($postType === false || $template_data[0] === $postType)) {
						$this->current_template_id = (int)$usk_template_id;
						return $this->current_template_id;
					}
				}
			}
		}

		// Regular template retrieval
		$templateId = Builder_Template_Helper::getTemplate($slug, $postType);
		$this->current_template_id = apply_filters('ultimate-store-kit-builder/custom-shop-template', $templateId);

		return $this->current_template_id;
	}


	/**
	 * Get Template Path
	 *
	 * @param $slug
	 * @param $default
	 *
	 * @return mixed|string|void
	 */
	protected function getTemplatePath($slug, $default = '') {
		$phpSlug = "{$slug}.php";

		if ($template = $this->getThemeTemplatePath($phpSlug)) {
			return $template;
		}

		if ($template = $this->getPluginTemplatePath($phpSlug)) {
			return $template;
		}

		return $default;
	}

	/**
	 * Get default product URL with proper error checking
	 *
	 * @return string
	 */
	protected function get_default_product_url() {
		$products = wc_get_products(['status' => 'publish', 'limit' => 1]);
		
		if (!empty($products) && isset($products[0]) && is_object($products[0])) {
			$product = $products[0];
			if (method_exists($product, 'get_id')) {
				return get_permalink($product->get_id());
			}
		}
		
		// Fallback to shop page if no products found
		return get_permalink(wc_get_page_id('shop'));
	}
}


Builder_Integration::instance();
