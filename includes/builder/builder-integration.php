<?php

if ( ! defined( 'WPINC' ) ) {
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
		add_filter( 'template_include', [ $this, 'set_builder_template' ], 9999 );
		add_action( 'elementor/editor/init', [ $this, 'set_sample_post' ], 999 );

		add_action( 'print_default_editor_scripts', array( $this, 'my_custom_fonts' ) );

		add_action( 'elementor/documents/register_controls', [ $this, 'register_document_controls' ] );
	}

	public function my_custom_fonts() {
		if ( is_admin() && Plugin::instance()->editor->is_edit_mode() ) {
			if ( isset( $_REQUEST['usk-template'] ) ) {
				wp_register_style( 'usk-template-builder-hide-preview-btn-inline', false ); // phpcs:ignore
				wp_enqueue_style( 'usk-template-builder-hide-preview-btn-inline' );
				wp_add_inline_style(
					'usk-template-builder-hide-preview-btn-inline',
					'#elementor-panel-footer-saver-preview {display:none!important}'
				);
			}
		}
	}
	function set_sample_post() {
		if ( Builder_Template_Helper::isTemplateEditMode() ) {
			$object = \UltimateStoreKit\Includes\Builder\Builder_Post_Singleton::instance();
			$object::set_sample_post();
		}
	}

	function register_document_controls( $document ) {
		if ( ! $document instanceof \Elementor\Core\DocumentTypes\PageBase
			|| ! $document::get_property( 'has_elements' ) ) {
			return;
		}

		if ( Plugin::instance()->preview->is_preview_mode() )
			return;

		if ( ! Builder_Template_Helper::isTemplateEditMode() ) {
			return;
		}

		global $post;

		if ( ! isset( $post->ID ) ) {
			return;
		}
		$meta = get_post_meta( $post->ID );

		$templateMeta = optional( $meta )[ Meta::TEMPLATE_TYPE ];
		if ( ! isset( $templateMeta[0] ) ) {
			return;
		}
		$postMeta = $templateMeta[0];
		$postMeta = explode( '|', $postMeta );
		$postType = $postMeta[0];

		if ( $postMeta[1] != 'single' ) {
			return;
		}

		$document->start_controls_section(
			'usk_page_setting_preview',
			[ 
				'label' => esc_html__( 'Builder Settings', 'ultimate-store-kit' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$document->add_control(
			'usk_builder_sample_post_id',
			[ 
				'label'       => __( 'Builder Post', 'ultimate-store-kit' ),
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
				'label'       => esc_html__( 'Apply & Preview', 'ultimate-store-kit' ),
				'label_block' => true,
				'show_label'  => false,
				'text'        => esc_html__( 'Apply & Preview', 'ultimate-store-kit' ),
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
	function set_builder_template( $template ) {
		if ( Builder_Template_Helper::isTemplateEditMode() ) {
			return $this->setBackendTemplate( $template );
		} else {
			return $this->setFrontendTemplate( $template );
		}
	}


	protected function setBackendTemplate( $template ) {
		return $template;
	}


	protected function setFrontendTemplate( $template ) {

		if ( get_post_type() == 'product' ) {
			global $product;
			$product = wc_get_product();
		}

		if ( defined( 'ELEMENTOR_PATH' ) ) {
			$elementorTem = ELEMENTOR_PATH . "modules/page-templates/templates/";
			$elementorTem = explode( $elementorTem, $template );
			if ( count( $elementorTem ) == 2 ) {
				return $template;
			}
		}

		if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_product_taxonomy() ) {
			if ( $custom_template = $this->get_template_id( 'shop' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/archive-product', $template );
			}
		}

		if ( is_cart() ) {
			if ( $custom_template = $this->get_template_id( 'cart', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/cart', $template );
			}
		}

		if ( is_order_received_page() ) {
			if ( $custom_template = $this->get_template_id( 'order-received', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/order-received', $template );
			}
		}

		if ( is_checkout() ) {
			if ( $custom_template = $this->get_template_id( 'checkout', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/checkout', $template );
			}
		}

		if ( is_single() && get_post_type() == 'product' ) {
			if ( $custom_template = $this->get_template_id( 'single', 'product' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'woocommerce/single-product', $template );
			}
		}

		if ( is_account_page() ) {
			global $wp;
			$query_vars = WC()->query->get_query_vars();

			/**
			 * Add wishlist endpoint
			 */
			$query_vars['wishlist'] = 'wishlist';

			if ( $endpoint = array_intersect_key( $wp->query_vars, $query_vars ) ) {
				$endpoint = array_key_first( $endpoint );

				if ( $endpoint && $custom_template = $this->get_template_id( $endpoint, 'account' ) ) {
					$this->current_template_id = $custom_template;

					if ( $newTemplate = $this->getTemplatePath( "woocommerce/{$endpoint}" ) ) {
						return $newTemplate;
					}

					return $this->getTemplatePath( "woocommerce/my-account", '' );
				}

				if ( $custom_template = $this->get_template_id( 'myaccount-orders', 'account' ) ) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath( 'woocommerce/my-account', $template );
				}

			} else {
				if ( $custom_template = $this->get_template_id( 'myaccount', 'account' ) ) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath( 'woocommerce/my-account', $template );
				}
			}
		}


		if ( is_single() ) {
			if ( $custom_template = $this->get_template_id( 'single', 'post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'single-post', $template );
			}
		}

		if ( is_archive() ) {
			if ( $custom_template = $this->get_template_id( 'archive', 'post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'archive-post', $template );
			}
		}

		if ( is_home() ) {
			if ( $custom_template = $this->get_template_id( 'home', 'post' ) ) {
				$this->current_template_id = $custom_template;
				return $this->getTemplatePath( 'home', $template );
			}
		}

		if ( $page_Id = intval( get_option( 'bdt_usk_compare_products_page_id' ) ) ) {
			if ( is_page( $page_Id ) ) {
				if ( $custom_template = $this->get_template_id( 'compare-products', 'product' ) ) {
					$this->current_template_id = $custom_template;
					return $this->getTemplatePath( 'home', $template );
				}
			}
		}

		return $template;
	}


	public function getThemeTemplatePath( $slug ) {

		$fullPath = get_template_directory() . "/ultimate-store-kit/$slug";
		if ( file_exists( $fullPath ) ) {
			return $fullPath;
		}
	}

	public function getPluginTemplatePath( $slug ) {

		$fullPath = BDTUSK_PATH . "includes/builder/templates/$slug";
		if ( file_exists( $fullPath ) ) {
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
	public function get_template_id( $slug, $postType = false ) {

		if ( null !== $this->current_template_id ) {
			return $this->current_template_id;
		}

		$templateId                = Builder_Template_Helper::getTemplate( $slug, $postType );
		$this->current_template_id = apply_filters( 'ultimate-store-kit-builder/custom-shop-template', $templateId );

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

		if ( $template = $this->getThemeTemplatePath( $phpSlug ) ) {
			return $template;
		}

		if ( $template = $this->getPluginTemplatePath( $phpSlug ) ) {
			return $template;
		}

		return $default;
	}

}


Builder_Integration::instance();


