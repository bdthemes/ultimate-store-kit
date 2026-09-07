<?php

namespace UltimateStoreKit;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- BDTUSK_ / ultimate_store_kit_ / ultimate-store-kit- are this plugin's established public prefixes.

use Elementor\Plugin;

final class usk_Modal {

    /**
     * Quick-view modal Kit control ids that were unprefixed before 3.1.2.
     *
     * Elementor Kit controls all live in one flat namespace shared with every
     * other plugin that registers a Kit tab, so ids like "modal_width" and
     * "button_text" were collision-prone. They are now prefixed. The values are
     * stored user data, so the old ids are still recognised: read falls back to
     * the legacy id, and migrate_legacy_kit_settings() rewrites the stored keys
     * once so Elementor keeps generating the Kit CSS for the style controls.
     *
     * @var string[] legacy id => current id
     */
    const LEGACY_KIT_SETTING_IDS = [
        'modal_layout'                   => 'ultimate_store_kit_modal_layout',
        'modal_width'                    => 'ultimate_store_kit_modal_width',
        'modal_height'                   => 'ultimate_store_kit_modal_height',
        'modal_animation'                => 'ultimate_store_kit_modal_animation',
        'close_btn_heading'              => 'ultimate_store_kit_modal_close_btn_heading',
        'show_close_btn'                 => 'ultimate_store_kit_modal_show_close_btn',
        'button_style'                   => 'ultimate_store_kit_modal_button_style',
        'button_text'                    => 'ultimate_store_kit_modal_button_text',
        'btn_place'                      => 'ultimate_store_kit_modal_btn_place',
        'modal_background'               => 'ultimate_store_kit_modal_background',
        'modal_overlay'                  => 'ultimate_store_kit_modal_overlay',
        'modal_close_btn'                => 'ultimate_store_kit_modal_close_btn',
        'close_btn_normal'               => 'ultimate_store_kit_modal_close_btn_normal',
        'modal_close_btn_color'          => 'ultimate_store_kit_modal_close_btn_color',
        'modal_close_btn_bg_color'       => 'ultimate_store_kit_modal_close_btn_bg_color',
        'close_btn_hover'                => 'ultimate_store_kit_modal_close_btn_hover',
        'modal_close_btn_hover_color'    => 'ultimate_store_kit_modal_close_btn_hover_color',
        'modal_close_btn_hover_bg_color' => 'ultimate_store_kit_modal_close_btn_hover_bg_color',
        'modal_close_btn_tabs'           => 'ultimate_store_kit_modal_close_btn_tabs',
        'modal_heading_title'            => 'ultimate_store_kit_modal_heading_title',
        'title_tab_normal'               => 'ultimate_store_kit_modal_title_tab_normal',
        'modal_title_color'              => 'ultimate_store_kit_modal_title_color',
        'title_tab_hover'                => 'ultimate_store_kit_modal_title_tab_hover',
        'modal_title_hover_color'        => 'ultimate_store_kit_modal_title_hover_color',
        'modal_title_tabs'               => 'ultimate_store_kit_modal_title_tabs',
        'modal_title_typography'         => 'ultimate_store_kit_modal_title_typography',
        'modal_rating_star'              => 'ultimate_store_kit_modal_rating_star',
        'modal_rating_normal'            => 'ultimate_store_kit_modal_rating_normal',
        'rating_color'                   => 'ultimate_store_kit_modal_rating_color',
        'modal_rating_active'            => 'ultimate_store_kit_modal_rating_active',
        'active_rating_color'            => 'ultimate_store_kit_modal_active_rating_color',
        'modal_rating_tabs'              => 'ultimate_store_kit_modal_rating_tabs',
        'modal_sale_price_heading'       => 'ultimate_store_kit_modal_sale_price_heading',
        'price_regular_tab'              => 'ultimate_store_kit_modal_price_regular_tab',
        'regular_price_color'            => 'ultimate_store_kit_modal_regular_price_color',
        'price_sale_tab'                 => 'ultimate_store_kit_modal_price_sale_tab',
        'sale_price_color'               => 'ultimate_store_kit_modal_sale_price_color',
        'sale_price_typography'          => 'ultimate_store_kit_modal_sale_price_typography',
        'modal_price_tabs'               => 'ultimate_store_kit_modal_price_tabs',
        'modal_heading_desc'             => 'ultimate_store_kit_modal_heading_desc',
        'modal_desc_color'               => 'ultimate_store_kit_modal_desc_color',
        'modal_desc_typography'          => 'ultimate_store_kit_modal_desc_typography',
        'modal_heading_btn'              => 'ultimate_store_kit_modal_heading_btn',
        'modal_tab_normal'               => 'ultimate_store_kit_modal_tab_normal',
        'modal_btn_color'                => 'ultimate_store_kit_modal_btn_color',
        'modal_btn_bg_color'             => 'ultimate_store_kit_modal_btn_bg_color',
        'modal_btn_tab_hover'            => 'ultimate_store_kit_modal_btn_tab_hover',
        'modal_btn_hover_color'          => 'ultimate_store_kit_modal_btn_hover_color',
        'modal_btn_hover_bg_color'       => 'ultimate_store_kit_modal_btn_hover_bg_color',
        'modal_btn_tabs'                 => 'ultimate_store_kit_modal_btn_tabs',
        'modal_heading_stock'            => 'ultimate_store_kit_modal_heading_stock',
        'modal_stock_color'              => 'ultimate_store_kit_modal_stock_color',
        'modal_stock_typography'         => 'ultimate_store_kit_modal_stock_typography',
        'modal_heading_sku'              => 'ultimate_store_kit_modal_heading_sku',
        'sku_tab_label'                  => 'ultimate_store_kit_modal_sku_tab_label',
        'modal_sku_label_color'          => 'ultimate_store_kit_modal_sku_label_color',
        'modal_sku_label_typography'     => 'ultimate_store_kit_modal_sku_label_typography',
        'sku_tab_value'                  => 'ultimate_store_kit_modal_sku_tab_value',
        'modal_sku_color'                => 'ultimate_store_kit_modal_sku_color',
        'modal_sku_typography'           => 'ultimate_store_kit_modal_sku_typography',
        'modal_sku_tabs'                 => 'ultimate_store_kit_modal_sku_tabs',
        'modal_heading_category'         => 'ultimate_store_kit_modal_heading_category',
        'category_tab_label'             => 'ultimate_store_kit_modal_category_tab_label',
        'modal_category_label_color'     => 'ultimate_store_kit_modal_category_label_color',
        'modal_category_label_typography' => 'ultimate_store_kit_modal_category_label_typography',
        'category_tab_value'             => 'ultimate_store_kit_modal_category_tab_value',
        'modal_category_color'           => 'ultimate_store_kit_modal_category_color',
        'modal_category_typography'      => 'ultimate_store_kit_modal_category_typography',
        'modal_category_tabs'            => 'ultimate_store_kit_modal_category_tabs',
    ];

    const MIGRATED_OPTION = 'ultimate_store_kit_kit_modal_ids_migrated';

    public function __construct() {
        add_action('wp_footer', [$this, 'usk_render_data']);
        add_action('elementor/init', [__CLASS__, 'migrate_legacy_kit_settings']);
    }

    /**
     * Rewrite the active Kit's stored quick-view control ids to the prefixed
     * names, once per site.
     *
     * Only the handful of controls read in PHP go through usk_get_kit_setting();
     * the rest are style controls whose CSS Elementor generates from the stored
     * settings array, so a read-side fallback alone would silently drop every
     * saved colour and typography value. Group controls store derived keys
     * ("<id>_font_size", "<id>_typography_font_family") and responsive controls
     * store "<id>_tablet"/"<id>_mobile", so keys are matched by prefix.
     *
     * @return void
     */
    public static function migrate_legacy_kit_settings() {
        if (get_option(self::MIGRATED_OPTION)) {
            return;
        }

        if (! class_exists('\Elementor\Plugin') || ! isset(Plugin::$instance->kits_manager)) {
            return;
        }

        $kit_id = Plugin::$instance->kits_manager->get_active_id();

        if (! $kit_id) {
            return;
        }

        $settings = get_post_meta($kit_id, '_elementor_page_settings', true);

        if (is_array($settings) && $settings) {
            $changed = false;

            // Longest legacy id first so "modal_close_btn" cannot swallow the
            // keys belonging to "modal_close_btn_hover_color".
            $legacy_ids = array_keys(self::LEGACY_KIT_SETTING_IDS);
            usort($legacy_ids, function ($a, $b) {
                return strlen($b) - strlen($a);
            });

            foreach ($legacy_ids as $legacy_id) {
                $current_id = self::LEGACY_KIT_SETTING_IDS[$legacy_id];

                foreach (array_keys($settings) as $key) {
                    if ($key !== $legacy_id && strpos($key, $legacy_id . '_') !== 0) {
                        continue;
                    }

                    $new_key = $current_id . substr($key, strlen($legacy_id));

                    if (! isset($settings[$new_key])) {
                        $settings[$new_key] = $settings[$key];
                        unset($settings[$key]);
                        $changed = true;
                    }
                }
            }

            if ($changed) {
                update_post_meta($kit_id, '_elementor_page_settings', $settings);

                // The Kit's generated CSS still references the old ids.
                if (isset(Plugin::$instance->files_manager)) {
                    Plugin::$instance->files_manager->clear_cache();
                }
            }
        }

        update_option(self::MIGRATED_OPTION, 1);
    }

    public function usk_get_kit_setting($setting_id) {
        global $usk_modal_settings;
        $return = '';
        if (!isset($usk_modal_settings['kit_settings'])) {
            $active_kit_id = Plugin::$instance->kits_manager->get_active_id();
            $kit = Plugin::$instance->documents->get($active_kit_id, false);

            // Check if kit exists and is a valid object before getting settings
            if ($kit && !is_wp_error($kit)) {
                $usk_modal_settings['kit_settings'] = $kit->get_settings();
            } else {
                // Fallback if kit is not available
                $usk_modal_settings['kit_settings'] = [];
            }
        }

        if (isset($usk_modal_settings['kit_settings'][$setting_id])) {
            $return = $usk_modal_settings['kit_settings'][$setting_id];
        } else {
            // Safety net for a Kit saved before the ids were prefixed, in case the
            // one-time migration has not run yet on this request.
            $legacy_id = array_search($setting_id, self::LEGACY_KIT_SETTING_IDS, true);

            if (false !== $legacy_id && isset($usk_modal_settings['kit_settings'][$legacy_id])) {
                $return = $usk_modal_settings['kit_settings'][$legacy_id];
            }
        }

        return apply_filters('ultimate_store_kit_modal_settings_' . $setting_id, $return);
    }
    public function usk_render_data() {
        $modal_width_desktop = $this->usk_get_kit_setting('ultimate_store_kit_modal_width');
        $modal_height = $this->usk_get_kit_setting('ultimate_store_kit_modal_height');
        $animation = $this->usk_get_kit_setting('ultimate_store_kit_modal_animation');
        $close_btn = $this->usk_get_kit_setting('ultimate_store_kit_modal_show_close_btn');
        $btn_style = $this->usk_get_kit_setting('ultimate_store_kit_modal_button_style');
        $btn_place = $this->usk_get_kit_setting('ultimate_store_kit_modal_btn_place');
        $button_text = $this->usk_get_kit_setting('ultimate_store_kit_modal_button_text');
        $modal_background = $this->usk_get_kit_setting('ultimate_store_kit_modal_background');
        $modal_overlay = $this->usk_get_kit_setting('ultimate_store_kit_modal_overlay');
?>
        <div class="product-quick-view" id="quick-view-id" data-modal-overlay="<?php echo esc_attr($modal_overlay); ?>" data-modal-bg="<?php echo esc_attr($modal_background); ?>" data-sm-init="true" data-modal-width="<?php echo esc_attr(is_array($modal_width_desktop) && isset($modal_width_desktop['size']) ? $modal_width_desktop['size'] : ''); ?>" data-modal-height="<?php echo esc_attr(is_array($modal_height) && isset($modal_height['size']) ? $modal_height['size'] : ''); ?>" data-btn-text="<?php echo esc_attr($button_text); ?>" data-btn-place="<?php echo esc_attr($btn_place); ?>" data-btn-style="<?php echo esc_attr($btn_style); ?>" data-close-btn="<?php echo esc_attr($close_btn); ?>" data-animation="<?php echo esc_attr($animation); ?>">
        </div>
<?php
    }
}
new usk_Modal();
