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
        \add_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function remove_products_post_class_filter() {
        \remove_filter('post_class', [$this, 'add_product_post_class']);
    }

    public function register_wc_hooks() {
        \wc()->frontend_includes();
    }

    public function load_assets() {
        // Load WooCommerce variation scripts for product variations
        \wp_enqueue_script('wc-add-to-cart-variation');

        // Load additional scripts for quick view functionality
        \wp_enqueue_script('prettyPhoto');
        \wp_enqueue_style('woocommerce_prettyPhoto_css');
        \wp_localize_script('usk-shiny-grid', 'usk_ajax_config', [
            'ajax_url' => \admin_url('admin-ajax.php'),
            'nonce' => \wp_create_nonce('usk_add_to_cart'),
        ]);
    }

    public function __construct() {
        parent::__construct();

        if (!empty($_REQUEST['action']) && 'elementor' === $_REQUEST['action'] && \is_admin()) {
            \add_action('init', [$this, 'register_wc_hooks'], 5);
        }

        // Load variation scripts and styles
        \add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        /**
         * Modal data
         */
        \add_action('wp_ajax_nopriv_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);
        \add_action('wp_ajax_ultimate_store_kit_wc_product_quick_view_content', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);

        \add_action('wp_ajax_usk_add_to_cart', [$this, 'usk_add_to_cart']);
        \add_action('wp_ajax_nopriv_usk_add_to_cart', [$this, 'usk_add_to_cart']);

        \add_action('ultimate_store_kit_quick_view_product_title', 'woocommerce_template_single_title');
        \add_action('ultimate_store_kit_quick_view_product_single_rating', 'woocommerce_template_single_rating');
        \add_action('ultimate_store_kit_quick_view_product_single_price', 'woocommerce_template_single_price');
        \add_action('ultimate_store_kit_quick_view_product_single_excerpt', 'woocommerce_template_single_excerpt');
        \add_action('ultimate_store_kit_quick_view_product_single_add_to_cart', 'woocommerce_template_single_add_to_cart');
        \add_action('ultimate_store_kit_quick_view_product_single_meta', 'woocommerce_template_single_meta');
        \add_action('ultimate_store_kit_quick_view_product_sale_flash', 'woocommerce_show_product_sale_flash');
        \add_action('ultimate_store_kit_quick_shiny_grid_view_product_images', [$this, 'ultimate_store_kit_quick_view_product_images']);

        // Get available variations AJAX
        \add_action('wp_ajax_usk_get_available_variations', [$this, 'usk_get_available_variations']);
        \add_action('wp_ajax_nopriv_usk_get_available_variations', [$this, 'usk_get_available_variations']);

        // Filter product class
        \add_action('woocommerce_before_shop_loop_item', [$this, 'add_products_post_class_filter']);
        \add_action('woocommerce_after_shop_loop_item', [$this, 'remove_products_post_class_filter']);

        // Quick view support
        \add_action('wp_ajax_ultimate_store_kit_wc_product_quick_view', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);
        \add_action('wp_ajax_nopriv_ultimate_store_kit_wc_product_quick_view', [$this, 'ultimate_store_kit_wc_product_quick_view_content']);
    }

    public function ultimate_store_kit_wc_product_quick_view_content() {
        $product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
        ultimate_store_kit_wc_product_quick_view_content($product_id);
    }

    public function ultimate_store_kit_quick_view_product_images() {
        ultimate_store_kit_quick_view_product_images();
    }


    public function usk_add_to_cart() {
        \check_ajax_referer('usk_add_to_cart', 'nonce');

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
        $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

        // Get product and validate
        $product = \wc_get_product($product_id);
        if (!$product) {
            \wp_send_json_error(['message' => 'Product not found']);
            return;
        }

        // Add to cart based on product type
        try {
            // For variable products, we need variation ID and attributes
            if ($product->is_type('variable') && $variation_id) {
                // Validate that the variation exists
                $variation = \wc_get_product($variation_id);
                if (!$variation || $variation->get_parent_id() !== $product_id) {
                    \wp_send_json_error(['message' => 'Invalid variation']);
                    return;
                }

                // Extract all variation attributes from the request
                $variation_data = [];
                foreach ($_POST as $key => $value) {
                    // Check if this is an attribute
                    if (strpos($key, 'attribute_') === 0) {
                        $variation_data[$key] = \sanitize_text_field($value);
                    }
                }

                // If no attributes found, try to get them from the variation
                if (empty($variation_data)) {
                    $attributes = $variation->get_attributes();
                    if (!empty($attributes)) {
                        foreach ($attributes as $name => $value) {
                            if (!empty($value)) {
                                $variation_data['attribute_' . $name] = $value;
                            }
                        }
                    }
                }

                // Verify we have all required variation attributes
                if (empty($variation_data)) {
                    \wp_send_json_error(['message' => 'Missing variation attributes']);
                    return;
                }

                // Add to cart with verified data
                $cart_item_key = \WC()->cart->add_to_cart(
                    $product_id,
                    $quantity,
                    $variation_id,
                    $variation_data
                );
            } else {
                // Simple product
                $cart_item_key = \WC()->cart->add_to_cart($product_id, $quantity);
            }

            if ($cart_item_key) {
                \do_action('woocommerce_ajax_added_to_cart', $product_id);

                // Prepare fragments for cart update
                $fragments = [];
                \ob_start();
                \woocommerce_mini_cart();
                $mini_cart = \ob_get_clean();
                $fragments['div.widget_shopping_cart_content'] = $mini_cart;

                \wp_send_json([
                    'success' => true,
                    'fragments' => $fragments,
                    'cart_hash' => \WC()->cart->get_cart_hash(),
                    'message' => 'Product added to cart'
                ]);
            } else {
                $cart_error = \wc_get_notices('error');
                $error_message = 'Failed to add to cart';

                if (!empty($cart_error)) {
                    \wc_clear_notices();
                    $error_message = \strip_tags($cart_error[0]['notice']);
                }

                \wp_send_json_error([
                    'message' => $error_message
                ]);
            }
        } catch (\Exception $e) {
            \wp_send_json_error([
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }


    /**
     * AJAX handler to get available variations for a product
     */
    public function usk_get_available_variations() {
        if (!isset($_POST['product_id'])) {
            \wp_send_json_error(['message' => 'Invalid product ID']);
            return;
        }

        $product_id = \absint($_POST['product_id']);
        $product = \wc_get_product($product_id);

        if (!$product || !$product->is_type('variable')) {
            \wp_send_json_error(['message' => 'Not a variable product']);
            return;
        }

        // Get all available variations
        $available_variations = $product->get_available_variations();

        // Clean up variation data to only include what's needed for attribute filtering
        $clean_variations = [];
        foreach ($available_variations as $variation) {
            $clean_variations[] = [
                'variation_id' => $variation['variation_id'],
                'attributes' => $variation['attributes'],
                'is_in_stock' => $variation['is_in_stock'],
                'is_purchasable' => $variation['is_purchasable'],
                'image' => $variation['image'],
                'price_html' => $variation['price_html'],
            ];
        }

        \wp_send_json_success($clean_variations);
        exit;
    }
}
