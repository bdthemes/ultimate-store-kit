<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

use UltimateStoreKit\Includes\Builder\Builder_Template_Helper;
use  UltimateStoreKit\Base\Singleton;


class Builder_Integration {

	use Singleton;

	private $current_template = null;
	public $current_template_id = null;

	function __construct() {
		add_filter( 'template_include', [ $this, 'set_builder_template' ], 12 );
	}

	public function getThemeTemplatePath( $slug ) {

		$fullPath  = get_template_directory()."/ultimate-store-kit/$slug";
		if ( file_exists( $fullPath ) ) {
			return $fullPath;
		}
	}

	public function getPluginTemplatePath( $slug ) {

		$fullPath  = BDTUSK_PATH."includes/builder/templates/$slug";
		if ( file_exists( $fullPath ) ) {
			return $fullPath;
		}
	}


	/**
	 * Rewrite default template
	 *
	 */
	function set_builder_template( $template ) {

		if ( get_post_type() == 'product' ) {
			global $product;
			$product = wc_get_product();
		}

		if(defined('ELEMENTOR_PATH')){
			$elementorTem = ELEMENTOR_PATH."modules/page-templates/templates/";
			$elementorTem = explode($elementorTem, $template);
			if(count($elementorTem) == 2) return $template;
		}

		if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_product_taxonomy() ) {
			if ( $custom_template = $this->get_template_id( 'shop' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/archive-product' ,$template);
			}
		}

		if ( is_cart() ) {
			if ( $custom_template = $this->get_template_id( 'cart', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/cart',$template );
			}
		}

		if ( is_checkout() ) {
			if ( $custom_template = $this->get_template_id( 'checkout', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/checkout',$template );
			}
		}

		if ( is_single() && get_post_type() == 'product' ) {
			if ( $custom_template = $this->get_template_id( 'single', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/single-product',$template );
			}
		}

		if ( is_account_page() ) {

			global $wp;
			$query_vars = WC()->query->get_query_vars();
			if ( $endpoint = array_intersect_key( $wp->query_vars, $query_vars ) ) {
				$endpoint = array_key_first( $endpoint );

				if ( $endpoint && $custom_template = $this->get_template_id( $endpoint , 'product' ) ) {
					$this->current_template_id = $custom_template;

					if($newTemplate = $this->getTemplatePath( "woocommerce/{$endpoint}")){
						return $newTemplate;
					}

					return $this->getTemplatePath( "woocommerce/my-account",'');
				}
			} else {
				if ( $endpoint && $custom_template = $this->get_template_id( 'myaccount', 'product' ) ) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath( 'woocommerce/my-account',$template );
				}
			}
		}


		if ( is_single() ) {
			if ( $custom_template = $this->get_template_id( 'single','post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'single-post' ,$template);
			}
		}

		if ( is_archive() ) {
			if ( $custom_template = $this->get_template_id( 'archive','post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'archive-post' ,$template);
			}
		}

		if ( is_home() ) {
			if ( $custom_template = $this->get_template_id( 'home','post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'home' ,$template);
			}
		}

		return $template;
	}

	/**
	 * Get Template Path ID
	 *
	 * @param $slug
	 * @param $postType
	 *
	 * @return mixed|void|null
	 */
	public function get_template_id( $slug, $postType = false ) {

		if ( null !== $this->current_template_id ) {
			return $this->current_template_id;
		}

		$templateId = Builder_Template_Helper::getTemplate( $slug, $postType );
		$this->current_template_id = apply_filters( 'ultimate-woo-kit-builder/custom-shop-template', $templateId );

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
	protected function getTemplatePath( $slug, $default = '' ) {
		$phpSlug = "{$slug}.php";

		if($template = $this->getThemeTemplatePath($phpSlug)){
			return $template;
		}

		if($template = $this->getPluginTemplatePath($phpSlug)){
			return $template;
		}

		return $default;
	}

}


Builder_Integration::instance();


