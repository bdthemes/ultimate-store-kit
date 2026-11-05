<?php

/**
 * Core Plugin REST API Settings Handler
 *
 * Registers REST routes for saving core admin settings.
 * Loaded unconditionally so REST requests work outside is_admin().
 */

namespace UltimateStoreKit\API;

use UltimateStoreKit\API\Base;

if (!defined('ABSPATH')) {
    exit;
}

class Settings extends Base {

    private static $instance = null;

    public static function get_instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get_namespace() {
        return 'ultimate-store-kit/v1';
    }

    protected function get_routes() {
        return [
            [
                'path'     => '/settings',
                'methods'  => 'POST',
                'callback' => [$this, 'save_settings'],
            ],
            [
                'path'     => '/optimization/regenerate',
                'methods'  => 'POST',
                'callback' => [$this, 'regenerate_combined_assets'],
            ],
        ];
    }

    /**
     * Save core plugin settings.
     */
    public function save_settings(\WP_REST_Request $request) {
        $section  = sanitize_text_field($request->get_param('section'));
        $settings = $request->get_param('settings');

        $allowed_sections = [
            'ultimate_store_kit_active_modules',
            'ultimate_store_kit_edd_modules',
            'ultimate_store_kit_general_modules',
            'ultimate_store_kit_other_settings',
        ];

        if (!in_array($section, $allowed_sections, true)) {
            return $this->error('invalid_section', 'Invalid section');
        }

        $sanitized = $this->sanitize_settings($settings);

        // ultimate_store_kit_other_settings is shared: every module page keeps its
        // switch there, and Pro switches modules through its own route. A page
        // posts only what it knows, so merge instead of replacing, or saving one
        // page would switch off modules turned on elsewhere since it loaded.
        if ('ultimate_store_kit_other_settings' === $section) {
            $stored    = get_option($section, []);
            $sanitized = array_merge(is_array($stored) ? $stored : [], $sanitized);
        }

        update_option($section, $sanitized);

        return $this->success(['message' => __('Settings saved successfully.', 'ultimate-store-kit')]);
    }

    /**
     * Delete the combined asset files; pages rebuild them on their next view.
     */
    public function regenerate_combined_assets(\WP_REST_Request $request) {
        if (class_exists('\UltimateStoreKit\Includes\Asset_Combiner')) {
            \UltimateStoreKit\Includes\Asset_Combiner::flush();
        }

        return $this->success([
            'message' => __('Combined files cleared. Pages rebuild them on their next visit.', 'ultimate-store-kit'),
            'stats'   => class_exists('\UltimateStoreKit\Includes\Asset_Combiner') ? \UltimateStoreKit\Includes\Asset_Combiner::stats() : null,
        ]);
    }
}
