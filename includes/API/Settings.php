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
        update_option($section, $sanitized);

        return $this->success(['message' => __('Settings saved successfully.', 'ultimate-store-kit')]);
    }
}
