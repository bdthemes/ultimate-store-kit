<?php

/**
 * Admin Menu Handler
 */

namespace UltimateStoreKit\Admin;

use UltimateStoreKit\Base\Singleton;
use UltimateStoreKit\Admin\Feeds;
use UltimateStoreKit\Admin\Biggopties;

if (!defined('ABSPATH')) {
    exit;
}

class Dashboard {
    use Singleton;

    private function __construct() {
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_filter('plugin_action_links_' . BDTUSK_PBNAME, [$this, 'plugin_action_meta']);
        add_action('admin_init', [$this, 'init']);
    }

    public function init() {
        Feeds::get_instance();
        Biggopties::get_instance();
    }

    /**
     * Register admin menu.
     *
     * Add new Ultimate Store Kit Settings admin menu.
     */
    public function register_admin_menu() {
        if (! current_user_can('manage_options')) {
            return;
        }

        add_menu_page(
            esc_html__('Ultimate Store Kit', 'ultimate-store-kit'),
            esc_html__('Ultimate Store Kit', 'ultimate-store-kit'),
            'manage_options',
            'ultimate-store-kit',
            [$this, 'print_admin_page'],
            $this->ultimate_store_kit_icon(),
            '58.7'
        );

        add_submenu_page(
            'ultimate-store-kit',
            esc_html__('Welcome', 'ultimate-store-kit'),
            esc_html__('Welcome', 'ultimate-store-kit'),
            'manage_options',
            'ultimate-store-kit'
        );
    }

    public function ultimate_store_kit_icon() {
        return 'data:image/svg+xml;base64,PCEtLSBHZW5lcmF0ZWQgYnkgSWNvTW9vbi5pbyAtLT4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMTAiIGhlaWdodD0iMTAyNCIgdmlld0JveD0iMCAwIDEwMTAgMTAyNCI+Cjx0aXRsZT48L3RpdGxlPgo8ZyBpZD0iaWNvbW9vbi1pZ25vcmUiPgo8L2c+CjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik05MTEuNjM4IDg3OS44NzhsLTUxLjQxNi01MDMuMzU3Yy01LjkzNS01Ni44NDMtNTMuNTk1LTEwMC43NzUtMTExLjUxNC0xMDAuNzc1LTAuMTExIDAtMC4yMjIgMC0wLjMzMiAwaC00NzIuNzQ4Yy0wLjE2MSAwLTAuMzUyLTAuMDAyLTAuNTQ1LTAuMDAyLTU4LjM2OSAwLTEwNi4yOTIgNDQuNzE3LTExMS4zODIgMTAxLjc2MWwtMC4wMzEgMC40MjktNDYuMDE3IDUwMy4zNTdjLTAuMjkzIDMuMDQzLTAuNDYgNi41OC0wLjQ2IDEwLjE1NCAwIDYyLjA5OCA1MC4zMjQgMTEyLjQ0MSAxMTIuNDEzIDExMi40NzJoNTcwLjIwMWM2Mi4xMDYtMC4xMDggMTEyLjQxMS01MC40NzggMTEyLjQxMS0xMTIuNiAwLTQuMDI5LTAuMjEyLTguMDA4LTAuNjI1LTExLjkyOGwwLjA0MiAwLjQ5ek0yMjkuNjExIDkwNS41ODVjLTAuMDE0IDAtMC4wMzMgMC0wLjA1MCAwLTcuNDU0IDAtMTMuNDk2LTYuMDQzLTEzLjQ5Ni0xMy40OTYgMC0wLjQwOCAwLjAxNy0wLjgxMSAwLjA1NC0xLjIwOGwtMC4wMDMgMC4wNTIgNDYuMDE3LTUwMy4zNTdjMC03LjA5OSA1Ljc1NS0xMi44NTQgMTIuODU0LTEyLjg1NHYwaDQ3Mi44OTRjNi45NjUgMC4wMjEgMTIuNjk3IDUuMjY1IDEzLjQ5MSAxMi4wMTlsMC4wMDcgMC4wNjQgMjEuNTk0IDIwOS4zODljLTczLjk4NCAzLjU5NC0xNDAuODE0IDMxLjU1OS0xOTMuMjggNzUuOTdsMC40NzItMC4zOTFjLTgwLjIwOCA2OC42MzktMTEzLjExNCAxNjcuMTAxLTEyNi40ODIgMjMzLjI5OHpNNzk5LjgwOCA5MDUuNTg1aC0yMzEuMzY5YzEyLjg1NC00OC45NzMgMzcuNjYxLTExMi4zNDMgODguNDM1LTE1NS41MzIgMzYuNzM0LTMwLjYyIDgzLjk4LTQ5Ljc2MyAxMzUuNjQzLTUxLjQwN2wwLjM1MS0wLjAwOSAxOS42NjYgMTkxLjM5M2MwLjEwNiAwLjYxOCAwLjE2NSAxLjMzIDAuMTY1IDIuMDU3IDAgNy4wOTktNS43NTUgMTIuODU0LTEyLjg1NCAxMi44NTQtMC4wMTQgMC0wLjAyNiAwLTAuMDQwIDBoMC4wMDJ6Ij48L3BhdGg+CjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0zNjIuNjQ5IDIzNWMwLjExNSAwLjAwMiAwLjI1IDAuMDAyIDAuMzg1IDAuMDAyIDI3LjI2MSAwIDQ5LjM1OS0yMi4wOTggNDkuMzU5LTQ5LjM1OSAwIDAgMC0wLjAwMiAwLTAuMDAydjBjMi4wMDMtNTQuNjQ3IDQ2Ljc4Ni05OC4xODYgMTAxLjczOC05OC4xODZzOTkuNzM1IDQzLjU0IDEwMS43MzMgOTguMDA0bDAuMDA1IDAuMTgyYzEuMzc4IDI2LjIyNCAyMi45NzggNDYuOTY2IDQ5LjQyMyA0Ni45NjZzNDguMDQ1LTIwLjc0MiA0OS40MTgtNDYuODQzbDAuMDA1LTAuMTIyYzAuMDQyLTEuNTEyIDAuMDY0LTMuMjkzIDAuMDY0LTUuMDc4IDAtMTEwLjgxNi04OS44MzQtMjAwLjY0OC0yMDAuNjQ4LTIwMC42NDhzLTIwMC42NDggODkuODM0LTIwMC42NDggMjAwLjY0OGMwIDEuNzg2IDAuMDIzIDMuNTY2IDAuMDY5IDUuMzRsLTAuMDA1LTAuMjYyYzAgMCAwIDAgMCAwIDAgMjcuMTcxIDIxLjk1MiA0OS4yMTMgNDkuMDg4IDQ5LjM1OWgwLjAxNHoiPjwvcGF0aD4KPC9zdmc+Cg==';
    }

    /**
     * Print admin page.
     */
    public function print_admin_page() {
?>
        <div class="ultimate-store-kit-admin-root font-sans"></div>
<?php
    }
    public function enqueue_admin_scripts() {
        $screen = get_current_screen();


        if ('toplevel_page_ultimate-store-kit' !== $screen->id) {
            return;
        }

        $asset_data = $this->get_asset_file('assets/admin');

        wp_enqueue_script(
            'ultimate-store-kit-admin',
            BDTUSK_ASSETS_URL . 'admin/admin.js',
            $asset_data['dependencies'],
            $asset_data['version'],
            true
        );

        wp_localize_script(
            'ultimate-store-kit-admin',
            'ultimateStoreKitAdminData',
            [
                'widgets' => $this->get_widgets_data(),
                'savedSettings' => $this->get_saved_settings(),
                'version' => BDTUSK_VER,
                'restUrl' => esc_url_raw(rest_url('ultimate-store-kit/v1/')),
                'restNonce' => wp_create_nonce('wp_rest'),
                'isPro' => function_exists('usk_license_validation') ? usk_license_validation() : false,
                'isProPluginActive' => defined('BDTUSK_PRO_VER'),
                'adminUrl' => admin_url(),
                'licenseData' => apply_filters('ultimate_store_kit_license_data', []),
            ]
        );

        wp_enqueue_style(
            'ultimate-store-kit-admin',
            BDTUSK_ASSETS_URL . 'admin/style-admin.css',
            [],
            $asset_data['version']
        );

        wp_enqueue_style('wp-components');
    }

    public function get_asset_file($filepath) {
        $asset_path = BDTUSK_PATH . $filepath . '.asset.php';

        if (file_exists($asset_path)) {
            return include $asset_path;
        }

        return [
            'dependencies' => [],
            'version'      => BDTUSK_VER,
        ];
    }

    public function get_widgets_data() {
        if (!class_exists('\UltimateStoreKit\Admin\ModuleService')) {
            require_once BDTUSK_ADMIN_PATH . 'module-settings.php';
        }

        $widget_data = \UltimateStoreKit\Admin\ModuleService::get_widget_settings(function ($settings) {
            return $settings['settings_fields'];
        });

        foreach ($widget_data as $section_key => $section_widgets) {
            if (!is_array($section_widgets)) {
                continue;
            }

            foreach ($section_widgets as $index => $widget) {
                if (!is_array($widget)) {
                    continue;
                }

                $widget_data[$section_key][$index]['dependency'] = $this->get_widget_dependency_data($widget);
            }
        }

        return $widget_data;
    }

    private function get_widget_dependency_data($widget) {
        $plugin_name = !empty($widget['plugin_name']) ? $widget['plugin_name'] : '';
        $plugin_path = !empty($widget['plugin_path']) ? $widget['plugin_path'] : '';
        $paid = !empty($widget['paid']) ? $widget['paid'] : '';

        if (empty($plugin_name) || empty($plugin_path)) {
            return null;
        }

        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $installed_plugins = get_plugins();
        $is_installed = isset($installed_plugins[$plugin_path]);
        $is_active = $is_installed && is_plugin_active($plugin_path);

        $action_url = '';
        $action_label = '';
        $action_type = '';
        $message = '';

        if (!$is_installed) {
            $action_type = 'install';
            $action_label = __('Install Plugin', 'ultimate-store-kit');
            $message = __('Install the required plugin first, then you can activate this feature.', 'ultimate-store-kit');

            if (!empty($paid)) {
                $action_url = $paid;
                $action_label = __('Download Plugin', 'ultimate-store-kit');
            } else {
                $action_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $plugin_name), 'install-plugin_' . $plugin_name);
            }
        } elseif (!$is_active) {
            $action_type = 'activate';
            $action_label = __('Activate Plugin', 'ultimate-store-kit');
            $message = __('Activate the required plugin first, then you can activate this feature.', 'ultimate-store-kit');
            $action_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin_path . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin_path);
        }

        return [
            'pluginName' => $plugin_name,
            'pluginPath' => $plugin_path,
            'isInstalled' => $is_installed,
            'isActive' => $is_active,
            'actionUrl' => $action_url,
            'actionLabel' => $action_label,
            'actionType' => $action_type,
            'message' => $message,
        ];
    }

    public function get_saved_settings() {
        return [
            'ultimate_store_kit_active_modules'  => get_option('ultimate_store_kit_active_modules', []),
            'ultimate_store_kit_edd_modules'      => get_option('ultimate_store_kit_edd_modules', []),
            'ultimate_store_kit_general_modules'  => get_option('ultimate_store_kit_general_modules', []),
            'ultimate_store_kit_other_settings'   => get_option('ultimate_store_kit_other_settings', []),
        ];
    }

    public function plugin_action_meta($links) {

        $links = array_merge([sprintf('<a href="%s">%s</a>', ultimate_store_kit_dashboard_link('#welcome'), esc_html__('Settings', 'ultimate-store-kit'))], $links);


        return $links;
    }
}
