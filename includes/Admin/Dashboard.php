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
        // After the Template Builder entry (202), so the deals entry stays last.
        add_action('admin_menu', [$this, 'register_deals_menu'], 203);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_filter('plugin_action_links_' . BDTUSK_PBNAME, [$this, 'plugin_action_meta']);
        add_action('admin_init', [$this, 'init']);
    }

    public function init() {
        $this->redirect_to_deals();
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

    /**
     * Deals page the free version's "Up To 86% Off" menu entry opens.
     */
    const DEALS_URL = 'https://bdthemes.com/deals/?utm_source=UltimateStoreKit&utm_medium=plugin_menu&utm_campaign=UltimateStoreKit';

    /**
     * Free version only: the BdThemes deals page (admin_init redirects there).
     */
    public function register_deals_menu() {
        if (true === ultimate_store_kit_is_pro_activated()) {
            return;
        }

        add_submenu_page(
            'ultimate-store-kit',
            esc_html__('Ultimate Store Kit', 'ultimate-store-kit'),
            esc_html__('Up To 86% Off', 'ultimate-store-kit'),
            'manage_options',
            'ultimate-store-kit_deals',
            [$this, 'print_admin_page']
        );

        add_action('admin_head', [$this, 'deals_menu_assets']);
    }

    /**
     * Send the "Up To 86% Off" menu entry to the BdThemes deals page.
     *
     * @return void
     */
    public function redirect_to_deals() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only check of the current admin page slug, no form data processed.
        if (! isset($_GET['page']) || 'ultimate-store-kit_deals' !== $_GET['page'] || ! current_user_can('manage_options')) {
            return;
        }

        // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect -- Intentional redirect to the external BdThemes deals page; wp_safe_redirect() would block this off-site host.
        wp_redirect(self::DEALS_URL);
        exit;
    }

    /**
     * Highlight the deals entry and open it in a new tab.
     *
     * @return void
     */
    public function deals_menu_assets() {
?>
        <style>
            #adminmenu #toplevel_page_ultimate-store-kit a[href$="page=ultimate-store-kit_deals"] {
                color: #ffc107;
                font-weight: 600;
            }
            #adminmenu #toplevel_page_ultimate-store-kit a[href$="page=ultimate-store-kit_deals"]:hover,
            #adminmenu #toplevel_page_ultimate-store-kit a[href$="page=ultimate-store-kit_deals"]:focus {
                color: #ffffff;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var link = document.querySelector('#toplevel_page_ultimate-store-kit a[href$="page=ultimate-store-kit_deals"]');
                if (link) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            });
        </script>
<?php
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

        wp_set_script_translations('ultimate-store-kit-admin', 'ultimate-store-kit');

        wp_localize_script(
            'ultimate-store-kit-admin',
            'ultimateStoreKitAdminData',
            [
                'widgets' => $this->get_widgets_data(),
                'savedSettings' => $this->get_saved_settings(),
                'version' => BDTUSK_VER,
                'restUrl' => esc_url_raw(rest_url('ultimate-store-kit/v1/')),
                'restNonce' => wp_create_nonce('wp_rest'),
                'isPro' => function_exists('ultimate_store_kit_license_validation') ? ultimate_store_kit_license_validation() : false,
                'isProPluginActive' => defined('BDTUSK_PRO_VER'),
                'adminUrl' => admin_url(),
                'licenseData' => apply_filters('ultimate_store_kit_license_data', []),
                'userName' => wp_get_current_user()->display_name,
                'templateBuilderUrl' => admin_url('edit.php?post_type=usk-template-builder'),
                'templatesCount' => $this->count_builder_templates(),
                'templatesActive' => $this->count_active_builder_templates(),
                'system' => $this->get_system_status(),
                'releases' => $this->get_recent_releases(),
                'assetStats' => class_exists('\UltimateStoreKit\Includes\Asset_Combiner') ? \UltimateStoreKit\Includes\Asset_Combiner::stats() : null,
            ]
        );

        // Widget glyphs (usk-icon-*) for the widget cards.
        wp_enqueue_style('usk-admin-font', BDTUSK_ASSETS_URL . 'css/font' . (is_rtl() ? '-rtl' : '') . '.css', [], BDTUSK_VER);

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

        if (!function_exists('get_plugins') || !function_exists('is_plugin_active')) {
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
                $action_url = admin_url('update.php?action=install-plugin&plugin=' . urlencode($plugin_name) . '&_wpnonce=' . wp_create_nonce('install-plugin_' . $plugin_name));
            }
        } elseif (!$is_active) {
            $action_type = 'activate';
            $action_label = __('Activate Plugin', 'ultimate-store-kit');
            $message = __('Activate the required plugin first, then you can activate this feature.', 'ultimate-store-kit');
            $action_url = admin_url('plugins.php?action=activate&plugin=' . urlencode($plugin_path) . '&plugin_status=all&paged=1&s&_wpnonce=' . wp_create_nonce('activate-plugin_' . $plugin_path));
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

    /**
     * Published Template Builder templates.
     *
     * @return int
     */
    private function count_builder_templates() {
        $counts = wp_count_posts('usk-template-builder');

        return isset($counts->publish) ? (int) $counts->publish : 0;
    }

    /**
     * Templates in use: one per assigned template type, plus switched-on
     * conditional templates.
     *
     * @return int
     */
    private function count_active_builder_templates() {
        global $wpdb;

        // phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- One cheap count for the dashboard.
        $assigned = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->options} WHERE option_name LIKE %s AND option_value <> ''",
            $wpdb->esc_like('ultimate_store_kit_template_') . '%'
        ));

        $conditional = (int) $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id WHERE pm.meta_key = %s AND pm.meta_value = '1' AND p.post_status = 'publish'",
            '_ultimate_store_kit_template_conditional_active'
        ));
        // phpcs:enable WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

        return $assigned + $conditional;
    }

    /**
     * Server and plugin checks for the dashboard's System status card.
     *
     * @return array[] Rows of label, value and status (ok|warn|bad).
     */
    private function get_system_status() {
        $memory      = wp_convert_hr_to_bytes((string) ini_get('memory_limit'));
        $max_exec    = (int) ini_get('max_execution_time');
        $php_version = PHP_VERSION;

        $rows = [
            [
                'label'  => __('PHP version', 'ultimate-store-kit'),
                'value'  => $php_version,
                'status' => version_compare($php_version, '7.4', '>=') ? 'ok' : 'bad',
            ],
            [
                'label'  => __('Memory limit', 'ultimate-store-kit'),
                'value'  => $memory < 0 ? __('Unlimited', 'ultimate-store-kit') : (string) ini_get('memory_limit'),
                'status' => ($memory < 0 || $memory >= 256 * MB_IN_BYTES) ? 'ok' : 'warn',
            ],
            [
                'label'  => __('Max execution time', 'ultimate-store-kit'),
                'value'  => 0 === $max_exec ? __('Unlimited', 'ultimate-store-kit') : (string) $max_exec,
                'status' => (0 === $max_exec || $max_exec >= 90) ? 'ok' : 'warn',
            ],
            [
                'label'  => __('WooCommerce', 'ultimate-store-kit'),
                'value'  => defined('WC_VERSION') ? WC_VERSION : __('Not active', 'ultimate-store-kit'),
                'status' => defined('WC_VERSION') ? 'ok' : 'warn',
            ],
            [
                'label'  => __('Elementor', 'ultimate-store-kit'),
                'value'  => defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : __('Not active', 'ultimate-store-kit'),
                'status' => defined('ELEMENTOR_VERSION') ? 'ok' : 'bad',
            ],
        ];

        return $rows;
    }

    /**
     * The latest releases from readme.txt's changelog, for Recent activity.
     *
     * @param int $limit Number of releases.
     * @return array[] version, date, summary (first entry) and counts of added/fixed/updated entries.
     */
    private function get_recent_releases($limit = 5) {
        $readme = BDTUSK_PATH . 'readme.txt';

        if (!is_readable($readme)) {
            return [];
        }

        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local plugin file.
        $contents = (string) file_get_contents($readme);
        $start    = strpos($contents, '== Changelog ==');

        if (false === $start) {
            return [];
        }

        $releases = [];
        $current  = null;

        foreach (preg_split('/\R/', substr($contents, $start)) as $line) {
            $line = trim($line);

            if (preg_match('/^=\s*([0-9][0-9.]*)\s*(?:\[([^\]]*)\]|[-–]\s*(.*?))?\s*=$/u', $line, $m)) {
                if ($current) {
                    $releases[] = $current;
                    if (count($releases) >= $limit) {
                        $current = null;
                        break;
                    }
                }
                $current = [
                    'version' => $m[1],
                    'date'    => trim(!empty($m[2]) ? $m[2] : (isset($m[3]) ? $m[3] : '')),
                    'summary' => '',
                    'counts'  => ['added' => 0, 'fixed' => 0, 'updated' => 0],
                ];
                continue;
            }

            if ($current && preg_match('/^\*\s*(Added|Fixed|Updated|Tweaked|Improved|Security)\s*:\s*(.+)$/i', $line, $m)) {
                $type = strtolower($m[1]);
                $type = in_array($type, ['added', 'fixed'], true) ? $type : 'updated';
                $current['counts'][$type]++;

                if ('' === $current['summary']) {
                    $current['summary'] = wp_strip_all_tags($m[2]);
                }
            }
        }

        if ($current) {
            $releases[] = $current;
        }

        return array_slice($releases, 0, $limit);
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
