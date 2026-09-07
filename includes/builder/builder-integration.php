<?php

namespace UltimateStoreKit\Builder;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- BDTUSK_ / ultimate_store_kit_ / ultimate-store-kit- are this plugin's established public prefixes.

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

		// The template preview used to accept the literal string "verified" in place
		// of a nonce whenever $_SERVER['HTTP_HOST'] contained one of a list of demo
		// hostnames. Because Host is attacker-controlled and the check was a substring
		// match, any unauthenticated visitor could render the Elementor content of an
		// arbitrary post id -- including drafts and private posts -- on any site whose
		// Host reached PHP as localhost/127.0.0.1 (common behind a reverse proxy) or
		// whose domain merely contained one of those strings. Preview is now gated on
		// the real per-post nonce plus an edit_post capability check; see get_template_id().
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
		} elseif ($template_slug === 'shop' || $template_slug === 'archive') {
			$template_url = get_permalink(wc_get_page_id('shop'));
		} elseif ($template_slug === 'single' && $post_type === 'product') {
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
			$page_settings_model = $page_settings_manager->get_model($post_id);
			$sample_product = $page_settings_model->get_settings('usk_builder_sample_post_id');

			$template_url = !empty($sample_product) ?
				get_permalink($sample_product) :
				$this->get_default_product_url();
		} elseif ($template_slug === 'cart') {
			$template_url = wc_get_cart_url();
		} elseif ($template_slug === 'checkout') {
			$template_url = wc_get_checkout_url();
		} elseif (
			$template_slug === 'myaccount'
			|| $template_slug === 'login'
			|| strpos($template_slug, 'myaccount-') === 0
		) {
			$template_url = get_permalink(wc_get_page_id('myaccount'));
		} elseif ($template_slug === 'order-received') {
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

		$param = [
			'ultimate_store_kit_template_id'    => $post_id,
			'ultimate_store_kit_preview_nonce'  => wp_create_nonce('ultimate_store_kit_template_preview_' . $post_id),
			'preview'                           => true
		];

		// Add parameters two URL
		$url = add_query_arg($param, $template_url);

		return $url;
	}

	public function my_custom_fonts() {
		if (is_admin() && Plugin::instance()->editor->is_edit_mode()) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only check on whether a builder template is open; only enqueues a style.
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

		$templateMeta = ultimate_store_kit_optional($meta)[Meta::TEMPLATE_TYPE];
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


		if ( is_cart() ) {
			$cart_template = $this->resolve_cart_template( $template );

			if ( $cart_template ) {
				return $cart_template;
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

			$endpoint_match = array_intersect_key($wp->query_vars, $query_vars);

			// Logged-out visitors landing on /my-account/ (no endpoint) see the
			// single Login & Register template, which is responsible for both
			// authentication flows. WooCommerce's own form-login.php renders
			// the login and registration forms on the same URL, so one
			// template covers both intents.
			if (! is_user_logged_in() && empty($endpoint_match)) {
				if ($custom_template = $this->get_template_id('login', 'account')) {
					$this->current_template_id = $custom_template;

					if ($newTemplate = $this->getTemplatePath('woocommerce/login')) {
						return $newTemplate;
					}

					return $this->getTemplatePath('woocommerce/my-account', $template);
				}
			}

			if ($endpoint = $endpoint_match) {
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

		if ($page_Id = ultimate_store_kit_get_compare_page_option()) {
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

		// Handle template preview from URL parameters.
		if (!empty($_GET['preview']) && !empty($_GET['ultimate_store_kit_template_id']) && !empty($_GET['ultimate_store_kit_preview_nonce'])) {
			$usk_template_id = absint(wp_unslash($_GET['ultimate_store_kit_template_id']));
			$nonce = sanitize_text_field(wp_unslash($_GET['ultimate_store_kit_preview_nonce']));

			// The nonce is bound to the specific template and to the user who
			// generated it, and the capability check makes sure a leaked preview
			// URL cannot be replayed by someone who may not edit the template.
			$nonce_verified = $usk_template_id
				&& wp_verify_nonce($nonce, 'ultimate_store_kit_template_preview_' . $usk_template_id)
				&& current_user_can('edit_post', $usk_template_id);

			if ($nonce_verified && get_post_type($usk_template_id) === Meta::POST_TYPE) {
				$template_type = get_post_meta($usk_template_id, Meta::TEMPLATE_TYPE, true);
				if (!empty($template_type)) {
					$template_data = explode(Builder_Template_Helper::separator(), $template_type);
					if (count($template_data) >= 2 && $template_data[1] === $slug && ($postType === false || $template_data[0] === $postType)) {
						$this->current_template_id = $usk_template_id;
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
	 * Resolve the plugin cart template for WooCommerce cart requests.
	 *
	 * @param string $template Default WordPress template path.
	 * @return string|false
	 */
	protected function resolve_cart_template( $template ) {
		if ( ! Cart_Render::is_available() ) {
			return false;
		}

		$custom_template           = $this->get_template_id( 'cart', 'product' );
		$this->current_template_id = $custom_template ? absint( $custom_template ) : null;

		return $this->getTemplatePath( 'woocommerce/cart', $template );
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
