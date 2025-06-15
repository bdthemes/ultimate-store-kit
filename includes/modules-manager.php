<?php

namespace UltimateStoreKit;

use UltimateStoreKit\Admin\ModuleService;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

final class Manager {


    public function register_module_and_assets() {

        ModuleService::get_widget_settings(function ($settings) {
            $wc_widgets        = $settings['settings_fields']['ultimate_store_kit_active_modules'];
            $edd_widgets       = $settings['settings_fields']['ultimate_store_kit_edd_modules'];
            $general_widgets   = $settings['settings_fields']['ultimate_store_kit_general_modules'];

            /**
             * Our Widget
             */
            foreach ($general_widgets as $widget) {
                if (ultimate_store_kit_is_general_widget_enabled($widget['name'])) {
                    $this->load_module_instance($widget);
                }
            }

            foreach ($wc_widgets as $widget) {
                if (ultimate_store_kit_is_widget_enabled($widget['name'])) {
                    if (isset($widget['plugin_path']) && ModuleService::is_plugin_active($widget['plugin_path'])) {
                        $this->load_module_instance($widget);
                    }
                }
            }

            /**
             * EDD Widget
             */
            foreach ($edd_widgets as $widget) {
                if (ultimate_store_kit_is_edd_enabled($widget['name'])) {
                    if (isset($widget['plugin_path']) && ModuleService::is_plugin_active($widget['plugin_path'])) {
                        $this->load_module_instance($widget);
                    }
                }
            }
            // Static module if need
            $this->load_module_instance(['name' => 'elementor']);
        });
    }

    public function load_module_instance($module) {


        $direction = is_rtl() ? '.rtl' : '';


        $module_id  = $module['name'];
        $class_name = str_replace('-', ' ', $module_id);
        $class_name = str_replace(' ', '', ucwords($class_name));
        $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\\Module';


        if (!ultimate_store_kit_is_preview()) {
            // register widgets css
            if (ModuleService::has_module_style($module_id)) {
                wp_register_style('usk-' . $module_id, BDTUSK_URL . 'assets/css/usk-' . $module_id . $direction . '.css', [], BDTUSK_VER);
            }
            // register widget JS
            if (ModuleService::has_module_script($module_id)) {
                wp_register_script('usk-' . $module_id, BDTUSK_URL . 'assets/js/widgets/usk-' . $module_id . '.min.js', ['jquery'], BDTUSK_VER, true);
            }
        }


        if (class_exists($class_name)) {
            $class_name::instance();
        }
    }

    public function __construct() {

        $this->register_module_and_assets();
    }
}
