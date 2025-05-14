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

        // Register get variation data AJAX handler
        \add_action('wp_ajax_get_variation_data', [$this, 'get_variation_data']);
        \add_action('wp_ajax_nopriv_get_variation_data', [$this, 'get_variation_data']);

        \add_action('wp_ajax_usk_add_to_cart', [$this, 'usk_add_to_cart']);
        \add_action('wp_ajax_nopriv_usk_add_to_cart', [$this, 'usk_add_to_cart']);

        // Add handler for finding variation ID
        \add_action('wp_ajax_usk_find_variation', [$this, 'usk_find_variation']);
        \add_action('wp_ajax_nopriv_usk_find_variation', [$this, 'usk_find_variation']);

        \add_action('ultimate_store_kit_quick_view_product_title', 'woocommerce_template_single_title');
        \add_action('ultimate_store_kit_quick_view_product_single_rating', 'woocommerce_template_single_rating');
        \add_action('ultimate_store_kit_quick_view_product_single_price', 'woocommerce_template_single_price');
        \add_action('ultimate_store_kit_quick_view_product_single_excerpt', 'woocommerce_template_single_excerpt');
        \add_action('ultimate_store_kit_quick_view_product_single_add_to_cart', 'woocommerce_template_single_add_to_cart');
        \add_action('ultimate_store_kit_quick_view_product_single_meta', 'woocommerce_template_single_meta');
        \add_action('ultimate_store_kit_quick_view_product_sale_flash', 'woocommerce_show_product_sale_flash');
        \add_action('ultimate_store_kit_quick_shiny_grid_view_product_images', [$this, 'ultimate_store_kit_quick_view_product_images']);
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
            $image_src = \wp_get_attachment_image_src($image_id, 'full');
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
                $additional_image_src = \wp_get_attachment_image_src($gallery_ids[0], 'full');
                if ($additional_image_src) {
                    $variation_data['additional_image'] = $additional_image_src[0];
                }
            } else {
                // If variation has no gallery images, use product gallery for hover effect
                $product_gallery = $product->get_gallery_image_ids();
                if (!empty($product_gallery)) {
                    $additional_image_src = \wp_get_attachment_image_src($product_gallery[0], 'full');
                    if ($additional_image_src) {
                        $variation_data['additional_image'] = $additional_image_src[0];
                    }
                }
            }
        }

        \wp_send_json_success($variation_data);
    }

    public function usk_add_to_cart() {
        check_ajax_referer('usk_add_to_cart', 'nonce');

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
        $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

        // Get product and validate
        $product = wc_get_product($product_id);
        if (!$product) {
            wp_send_json_error(['message' => 'Product not found']);
            return;
        }

        // Add to cart based on product type
        try {
            // For variable products, we need variation ID and attributes
            if ($product->is_type('variable') && $variation_id) {
                // Validate that the variation exists
                $variation = wc_get_product($variation_id);
                if (!$variation || $variation->get_parent_id() !== $product_id) {
                    wp_send_json_error(['message' => 'Invalid variation']);
                    return;
                }

                // Get all available product variations
                $available_variations = $product->get_available_variations();
                $variation_data = [];

                // Collect and validate attributes
                $product_attributes = $product->get_attributes();
                foreach ($product_attributes as $attribute_name => $attribute) {
                    if ($attribute->get_variation()) {
                        $taxonomy = 'attribute_' . $attribute_name;

                        if (isset($_POST[$taxonomy])) {
                            $value = sanitize_text_field($_POST[$taxonomy]);
                            $variation_data[$taxonomy] = $value;
                        }
                    }
                }

                // Verify we have all required variation attributes
                if (count($variation_data) === 0) {
                    wp_send_json_error(['message' => 'No variation attributes provided']);
                    return;
                }

                // Double-check the variation ID matches the provided attributes
                $data_store = \WC_Data_Store::load('product');
                $matching_variation = $data_store->find_matching_product_variation($product, $variation_data);

                if ($matching_variation !== $variation_id) {
                    // Use the correct variation ID
                    $variation_id = $matching_variation;
                    if (!$variation_id) {
                        wp_send_json_error(['message' => 'No matching variation found for the provided attributes']);
                        return;
                    }
                }

                // Add to cart with verified data
                $cart_item_key = WC()->cart->add_to_cart(
                    $product_id,
                    $quantity,
                    $variation_id,
                    $variation_data
                );
            } else {
                // Simple product
                $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
            }

            if ($cart_item_key) {
                do_action('woocommerce_ajax_added_to_cart', $product_id);

                // Prepare fragments
                $fragments = [];
                ob_start();
                woocommerce_mini_cart();
                $mini_cart = ob_get_clean();
                $fragments['div.widget_shopping_cart_content'] = $mini_cart;

                wp_send_json([
                    'success' => true,
                    'fragments' => $fragments,
                    'cart_hash' => WC()->cart->get_cart_hash(),
                    'message' => 'Product added to cart'
                ]);
            } else {
                $cart_error = wc_get_notices('error');
                $error_message = 'Failed to add to cart';

                if (!empty($cart_error)) {
                    wc_clear_notices();
                    $error_message = strip_tags($cart_error[0]['notice']);
                }

                wp_send_json_error([
                    'message' => $error_message
                ]);
            }
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    /**
     * AJAX handler to find the correct variation ID from attribute combinations
     */
    public function usk_find_variation() {
        if (!isset($_POST['product_id']) || !isset($_POST['attributes']) || !is_array($_POST['attributes'])) {
            wp_send_json_error(['message' => 'Invalid data']);
            return;
        }

        $product_id = absint($_POST['product_id']);
        $attributes = $_POST['attributes'];

        $product = wc_get_product($product_id);
        if (!$product || !$product->is_type('variable')) {
            wp_send_json_error(['message' => 'Invalid product']);
            return;
        }

        // Format attributes for WooCommerce
        $formatted_attributes = [];
        foreach ($attributes as $name => $value) {
            $formatted_attributes['attribute_' . $name] = sanitize_text_field($value);
        }

        // Find matching variation
        $data_store = \WC_Data_Store::load('product');
        $variation_id = $data_store->find_matching_product_variation($product, $formatted_attributes);

        if ($variation_id) {
            wp_send_json_success([
                'variation_id' => $variation_id
            ]);
        } else {
            wp_send_json_error(['message' => 'No matching variation found']);
        }

        exit;
    }
}
