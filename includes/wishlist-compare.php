<?php

namespace UltimateStoreKit;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

if (!function_exists('is_plugin_active')) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

final class WishlistCompare {
    public function __construct() {
        add_action('wp_ajax_usk_add_to_wishlist', [$this, 'usk_add_to_wishlist']);
        add_action('wp_ajax_nopriv_usk_add_to_wishlist', [$this, 'usk_add_to_wishlist']);
        add_action('woocommerce_account_wishlist_endpoint', [$this, 'usk_wishlist_content']);
        add_filter('woocommerce_account_menu_items', [$this, 'usk_wishlist_link_my_account']);
        add_filter('query_vars', [$this, 'usk_wishlist_query_vars'], 0);
        add_action('init', [$this, 'usk_add_rewrite_flash_rules_endpoint']);
    }

    public function usk_add_to_wishlist() {
        $response = [
            'status'  => 0,
            'message' => __('Unauthorized!', 'ultimate-store-kit'),
        ];

        if (!isset($_POST['product_id'])) {
            $response['message'] = __('No product selected!', 'ultimate-store-kit');
            wp_send_json($response);
        }

        $product_id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';

        $user_id  = get_current_user_id();
        $wishlist = ultimate_store_kit_get_wishlist($user_id);

        if (($key = array_search($product_id, $wishlist)) !== false) {
            $response['action'] = 'removed';
            unset($wishlist[$key]);
        } else {
            $response['action'] = 'added';
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

    public function ultimate_store_kit_set_wishlist($wishlist, $user_id = 0) {
        $_wishlist_key = '_ultimate_store_kit_wishlist';
        $_wishlist     = [];
        // if ($user_id != 0) {
        //     update_user_meta($user_id, $_wishlist_key, $wishlist);
        // } else {
        setcookie($_wishlist_key, serialize($wishlist), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
        // }
    }

    //===========================================

    //  display wishlist item in my account page
    //===========================================
    public function usk_add_rewrite_flash_rules_endpoint() {
        add_rewrite_endpoint('wishlist', EP_ROOT | EP_PAGES);
    }

    // 2. Add new query var
    public function usk_wishlist_query_vars($vars) {
        $vars[] = 'wishlist';
        return $vars;
    }

    // 3. Insert the new endpoint into the My Account menu
    public function usk_wishlist_link_my_account($items) {
        $items['wishlist'] = 'Wishlist';
        return $items;
    }

    // 4. Add content to the new tab
    public function usk_wishlist_content() {
        $user_id     = get_current_user_id();
        $wishlist    = ultimate_store_kit_get_wishlist($user_id);
        $fav_product = new \WP_Query([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'post__in'       => $wishlist,
            'posts_per_page' => -1,
        ]);

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_enqueue_script('ultimate-store-kit-site', BDTUSK_ASSETS_URL . 'js/ultimate-store-kit-site' . $suffix . '.js', [
            'jquery',
            'elementor-frontend',
        ], BDTUSK_VER, true); // tooltip file should be separate
        wp_localize_script('ultimate-store-kit-site', 'ultimate_store_kit_ajax_config', [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ]);
?>
        <?php

        if ($wishlist) : ?>
            <div class="ultimate-store-kit-container">
                <div class="ultimate-store-kit-wishlist-wrap">
                    <table class="usk-table">
                        <thead>
                            <tr>
                                <th class="remove-title"><?php echo esc_html_x('Remove', 'Frontend', 'ultimate-store-kit'); ?></th>
                                <th class="product-title"><?php echo esc_html_x('Product', 'Frontend', 'ultimate-store-kit'); ?></th>
                                <th class="product-name"><?php echo esc_html_x('Product Name', 'Frontend', 'ultimate-store-kit'); ?></th>
                                <th class="price-title"><?php echo esc_html_x('Unit Price', 'Frontend', 'ultimate-store-kit'); ?></th>
                                <th class="stock-title"><?php echo esc_html_x('Stock Status', 'Frontend', 'ultimate-store-kit'); ?></th>
                                <th class="actions-title"><?php echo esc_html_x('Action', 'Frontend', 'ultimate-store-kit'); ?></th>
                            </tr>
                        </thead>
                        <tbody class="usk-table-body-content">
                            <?php

                            while ($fav_product->have_posts()) : $fav_product->the_post();
                                global $product;
                                $product_id = $product->get_ID();
                                $image      = wp_get_attachment_image_url(get_post_thumbnail_id(), 'full');
                            ?>
                                <tr>
                                    <td class="usk-remove-icon">
                                        <a href="javascript:void(0);" class="ajax_remove_from_wishlist remove-icon" data-product_id="<?php echo esc_attr($product_id); ?>">
                                            <i class="eicon-editor-close"></i>
                                        </a>
                                    </td>
                                    <td class="usk-product-image">
                                        <a href="<?php echo get_permalink(); ?>">
                                            <img src="<?php echo esc_url($image); ?>" alt="">
                                        </a>
                                    </td>
                                    <td class="usk-product-name">
                                        <a href="<?php echo get_permalink(); ?>">
                                            <?php echo esc_html($product->get_name());
                                            ?></a>
                                    </td>
                                    <td class="usk-price">
                                        <?php echo $product->get_price_html();
                                        ?>
                                    </td>
                                    <td class="usk-stock">
                                        <?php echo esc_html($product->get_stock_status());
                                        ?>
                                    </td>
                                    <td class="usk-auction-button">
                                        <a class="addto-cart" href="<?php echo esc_url($product->add_to_cart_url()); ?>">
                                            <?php echo esc_html($product->add_to_cart_text());
                                            ?></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<?php endif;
    }
}

new WishlistCompare();
