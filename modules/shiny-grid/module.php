<?php

namespace UltimateStoreKit\Modules\ShinyGrid;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

    public static function is_active() {
        return class_exists('woocommerce');
    }

    public function get_name() {
        return 'usk-shiny-grid';
    }

    public function get_widgets() {
        return ['Shiny_Grid'];
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

    public function load_assets() {
        // Load WooCommerce variation scripts for product variations
        // \wp_enqueue_script('wc-add-to-cart-variation');

        // Load additional scripts for quick view functionality
        \wp_enqueue_script('prettyPhoto');
        \wp_enqueue_style('woocommerce_prettyPhoto_css');
    }

    public function __construct() {

        parent::__construct();

        if (!empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && is_admin()) {
            add_action('init', [$this, 'register_wc_hooks'], 5);
        }

        // Load variation scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        /**
         * Modal data
         */
        add_action('wp_ajax_nopriv_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);
        add_action('wp_ajax_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);

        // Register get variation data AJAX handler
        add_action('wp_ajax_get_variation_data', [$this, 'get_variation_data']);
        add_action('wp_ajax_nopriv_get_variation_data', [$this, 'get_variation_data']);

        add_action('ultimate_store_kit_quick_view_product_title', 'woocommerce_template_single_title');
        add_action('ultimate_store_kit_quick_view_product_single_rating', 'woocommerce_template_single_rating');
        add_action('ultimate_store_kit_quick_view_product_single_price', 'woocommerce_template_single_price');
        add_action('ultimate_store_kit_quick_view_product_single_excerpt', 'woocommerce_template_single_excerpt');
        add_action('ultimate_store_kit_quick_view_product_single_add_to_cart', 'woocommerce_template_single_add_to_cart');
        add_action('ultimate_store_kit_quick_view_product_single_meta', 'woocommerce_template_single_meta');
        add_action('ultimate_store_kit_quick_view_product_sale_flash', 'woocommerce_show_product_sale_flash');
        add_action('ultimate_store_kit_quick_shiny_grid_view_product_images', [$this, 'ultimate_store_kit_quick_view_product_images']);
    }

    public function ultimate_store_kit_wc_product_quick_view_content() {
        $product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
        ultimate_store_kit_wc_product_quick_view_content($product_id);
    }

    public function ultimate_store_kit_quick_view_product_images() {
        ultimate_store_kit_quick_view_product_images();
    }

    /**
     * AJAX handler to get variation data including images
     */
    public function get_variation_data() {
        if (!isset($_POST['product_id']) || !isset($_POST['variation_id'])) {
            \wp_send_json_error();
            return;
        }

        $product_id = \intval($_POST['product_id']);
        $variation_id = \intval($_POST['variation_id']);

        $product = \wc_get_product($product_id);
        $variation = \wc_get_product($variation_id);

        if (!$product || !$variation) {
            \wp_send_json_error();
            return;
        }

        $variation_data = [
            'image' => null,
            'additional_image' => null
        ];

        // Get the variation image
        $image_id = $variation->get_image_id();
        if ($image_id) {
            $image_src = \wp_get_attachment_image_src($image_id, 'woocommerce_thumbnail');
            if ($image_src) {
                $variation_data['image'] = [
                    'src' => $image_src[0],
                    'width' => $image_src[1],
                    'height' => $image_src[2],
                ];
            }

            // Get the gallery images for this variation
            $gallery_ids = $variation->get_gallery_image_ids();
            if (!empty($gallery_ids)) {
                $additional_image_src = \wp_get_attachment_image_src($gallery_ids[0], 'woocommerce_thumbnail');
                if ($additional_image_src) {
                    $variation_data['additional_image'] = $additional_image_src[0];
                }
            } else {
                // If variation has no gallery images, use product gallery for hover effect
                $product_gallery = $product->get_gallery_image_ids();
                if (!empty($product_gallery)) {
                    $additional_image_src = \wp_get_attachment_image_src($product_gallery[0], 'woocommerce_thumbnail');
                    if ($additional_image_src) {
                        $variation_data['additional_image'] = $additional_image_src[0];
                    }
                }
            }
        }

        \wp_send_json_success($variation_data);
    }
}
