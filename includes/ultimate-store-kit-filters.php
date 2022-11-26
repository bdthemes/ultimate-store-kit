<?php


/**
 * Ultimate Store Kit widget filters
 * @since 3.0.0
 */

use UltimateStoreKit\Admin\ModuleService;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Settings Filters
if (!function_exists('ultimate_store_kit_is_dashboard_enabled')) {
    function ultimate_store_kit_is_dashboard_enabled() {
        return apply_filters('ultimatestorekit/settings/dashboard', true);
    }
}

if (!function_exists('ultimate_store_kit_is_widget_enabled')) {
    function ultimate_store_kit_is_widget_enabled($widget_id, $options = []) {

        if (!$options) {
            $options = get_option('ultimate_store_kit_active_modules', []);
        }

        if (ModuleService::is_module_active($widget_id, $options)) {
            $widget_id = str_replace('-', '_', $widget_id);
            return apply_filters("ultimatestorekit/wc_widget/{$widget_id}", true);
        }
    }
}

if (!function_exists('ultimate_store_kit_is_general_widget_enabled')) {
    function ultimate_store_kit_is_general_widget_enabled($widget_id, $options = []) {

        if (!$options) {
            $options = get_option('ultimate_store_kit_general_modules', []);
        }

        if (ModuleService::is_module_active($widget_id, $options)) {
            $widget_id = str_replace('-', '_', $widget_id);
            return apply_filters("ultimatestorekit/general_widget/{$widget_id}", true);
        }
    }
}

if (!function_exists('ultimate_store_kit_is_edd_enabled')) {
    function ultimate_store_kit_is_edd_enabled($widget_id, $options = []) {

        if (!$options) {
            $options = get_option('ultimate_store_kit_edd_modules', []);
        }

        if (ModuleService::is_module_active($widget_id, $options)) {
            $widget_id = str_replace('-', '_', $widget_id);
            return apply_filters("ultimatestorekit/edd_widget/{$widget_id}", true);
        }
    }
}

if (!function_exists('ultimate_store_kit_is_asset_optimization_enabled')) {
    function ultimate_store_kit_is_asset_optimization_enabled() {
        $asset_manager = ultimate_store_kit_option('asset-manager', 'ultimate_store_kit_other_settings', 'off');
        if ($asset_manager == 'on') {
            return apply_filters("ultimatestorekit/optimization/asset_manager", true);
        }
    }
}
