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
    /**
     * Whether Asset Optimization (Store Kit > Performance) is switched on.
     *
     * With it on, the site stylesheet and script load only on pages that show an
     * Ultimate Store Kit widget, and the widget CSS and JS files a page loads are
     * joined into combined files; see UltimateStoreKit\Includes\Asset_Combiner.
     *
     * @return bool
     */
    function ultimate_store_kit_is_asset_optimization_enabled() {
        $enabled = ('on' === ultimate_store_kit_option('asset-manager', 'ultimate_store_kit_other_settings', 'off'));

        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Established public hook name.
        return (bool) apply_filters('ultimatestorekit/optimization/asset_manager', $enabled);
    }
}

if (!function_exists('ultimate_store_kit_module_asset_depends')) {
    /**
     * The shared handles every widget stylesheet or script depends on.
     *
     * The site stylesheet (`usk-site`) and script (`usk-core`, which carries
     * ultimate_store_kit_ajax_config) are what widget files build on. Every
     * `usk-<module>` handle depends on them, so a page that loads a widget gets
     * them in the right order; with Asset Optimization on, that is also the only
     * way they load. Ultimate Store Kit Pro registers its widgets the same way.
     *
     * @param string $type      'css' or 'js'.
     * @param string $module_id Module slug.
     * @return string[]
     */
    function ultimate_store_kit_module_asset_depends($type, $module_id = '') {
        $depends = 'js' === $type ? ['jquery', 'usk-core'] : ['usk-site'];

        /**
         * Filters the handles an Ultimate Store Kit widget stylesheet or script depends on.
         *
         * @param string[] $depends   Handles the module file depends on.
         * @param string   $type      'css' or 'js'.
         * @param string   $module_id Module slug.
         */
        return (array) apply_filters('ultimate_store_kit/module/asset_depends', $depends, $type, $module_id);
    }
}
