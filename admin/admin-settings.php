<?php

use UltimateStoreKit\Classes\Utils;
use UltimateStoreKit\Admin\ModuleService;
use Elementor\Tracker;
use Elementor\Modules\Usage\Module;


/**
 * Ultimate Store Kit Admin Settings Class
 */
class UltimateStoreKit_Admin_Settings
{
    public static $modules_list  = null;
    public static $modules_names = null;

    public static $modules_list_only_widgets  = null;
    public static $modules_names_only_widgets = null;

    public static $modules_list_only_edd_widgets  = null;
    public static $modules_names_only_edd_widgets = null;

    const PAGE_ID = 'ultimate_store_kit_options';

    private $settings_api;

    public $responseObj;
    public $showMessage   = false;
    private $is_activated = false;

    function __construct()
    {
        $this->settings_api = new UltimateStoreKit_Settings_API;

        if (!defined('BDTUSK_HIDE')) {
            add_action('admin_init', [$this, 'admin_init']);
            add_action('admin_menu', [$this, 'admin_menu'], 201);
            add_action('admin_menu', [$this, 'admin_get_pro_menu'], 202);
        }
    }

    public static function get_url()
    {
        return admin_url('admin.php?page=' . self::PAGE_ID);
    }

    function admin_init()
    {

        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->ultimate_store_kit_admin_settings());

        //initialize settings
        $this->settings_api->admin_init();
        $this->usk_redirect_to_get_pro();

        if ( _is_usk_pro_activated() ) {
            $this->bdt_redirect_to_renew_link();
        }
    }

    // Redirect to Ultimate Store Kit Pro pricing page
    public function usk_redirect_to_get_pro()
    {
        if (isset($_GET['page']) && $_GET['page'] === self::PAGE_ID . '_get_pro') {
            wp_redirect('https://store.bdthemes.com/ultimate-store-kit?utm_source=UltimateStoreKit&utm_medium=PluginPage&utm_campaign=UltimateStoreKit&coupon=SUMMER25');
            exit;
        }
    }

    /**
     * Redirect to license renewal page
     *
     * @access public
     *
     */
    public function bdt_redirect_to_renew_link() {
        if (isset($_GET['page']) && $_GET['page'] === self::PAGE_ID . '_license_renew') {
            wp_redirect('https://account.bdthemes.com/');
            exit;
        }
    }

    function admin_menu()
    {
        add_menu_page(
            BDTUSK_TITLE . ' ' . esc_html__('Dashboard', 'ultimate-store-kit'),
            BDTUSK_TITLE,
            'manage_options',
            self::PAGE_ID,
            [$this, 'plugin_page'],
            $this->ultimate_store_kit_icon(),
            58.5
        );

        add_submenu_page(
            self::PAGE_ID,
            BDTUSK_TITLE,
            esc_html__('WC Widgets', 'ultimate-store-kit'),
            'manage_options',
            self::PAGE_ID . '#ultimate_store_kit_active_modules',
            [$this, 'display_page'],
        );

        add_submenu_page(
            self::PAGE_ID,
            BDTUSK_TITLE,
            esc_html__('EDD Widgets', 'ultimate-store-kit'),
            'manage_options',
            self::PAGE_ID . '#ultimate_store_kit_edd_modules',
            [$this, 'display_page'],
        );

        add_submenu_page(
            self::PAGE_ID,
            BDTUSK_TITLE,
            esc_html__('Other Widgets', 'ultimate-store-kit'),
            'manage_options',
            self::PAGE_ID . '#ultimate_store_kit_general_modules',
            [$this, 'display_page'],
        );

        add_submenu_page(
            self::PAGE_ID,
            BDTUSK_TITLE,
            esc_html__('Other Settings', 'ultimate-store-kit'),
            'manage_options',
            self::PAGE_ID . '#ultimate_store_kit_other_settings',
            [$this, 'display_page']
        );
    }

    function admin_get_pro_menu()
    {
        if (true !== _is_usk_pro_activated()) {
            add_submenu_page(
                self::PAGE_ID,
                BDTUSK_TITLE,
                esc_html__('Upgrade For Up to 83% Off!', 'ultimate-store-kit'),
                'manage_options',
                self::PAGE_ID . '_get_pro',
                [$this, 'display_page']
            );
        }
    }

    function ultimate_store_kit_icon()
    {
        return 'data:image/svg+xml;base64,PCEtLSBHZW5lcmF0ZWQgYnkgSWNvTW9vbi5pbyAtLT4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMTAiIGhlaWdodD0iMTAyNCIgdmlld0JveD0iMCAwIDEwMTAgMTAyNCI+Cjx0aXRsZT48L3RpdGxlPgo8ZyBpZD0iaWNvbW9vbi1pZ25vcmUiPgo8L2c+CjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik05MTEuNjM4IDg3OS44NzhsLTUxLjQxNi01MDMuMzU3Yy01LjkzNS01Ni44NDMtNTMuNTk1LTEwMC43NzUtMTExLjUxNC0xMDAuNzc1LTAuMTExIDAtMC4yMjIgMC0wLjMzMiAwaC00NzIuNzQ4Yy0wLjE2MSAwLTAuMzUyLTAuMDAyLTAuNTQ1LTAuMDAyLTU4LjM2OSAwLTEwNi4yOTIgNDQuNzE3LTExMS4zODIgMTAxLjc2MWwtMC4wMzEgMC40MjktNDYuMDE3IDUwMy4zNTdjLTAuMjkzIDMuMDQzLTAuNDYgNi41OC0wLjQ2IDEwLjE1NCAwIDYyLjA5OCA1MC4zMjQgMTEyLjQ0MSAxMTIuNDEzIDExMi40NzJoNTcwLjIwMWM2Mi4xMDYtMC4xMDggMTEyLjQxMS01MC40NzggMTEyLjQxMS0xMTIuNiAwLTQuMDI5LTAuMjEyLTguMDA4LTAuNjI1LTExLjkyOGwwLjA0MiAwLjQ5ek0yMjkuNjExIDkwNS41ODVjLTAuMDE0IDAtMC4wMzMgMC0wLjA1MCAwLTcuNDU0IDAtMTMuNDk2LTYuMDQzLTEzLjQ5Ni0xMy40OTYgMC0wLjQwOCAwLjAxNy0wLjgxMSAwLjA1NC0xLjIwOGwtMC4wMDMgMC4wNTIgNDYuMDE3LTUwMy4zNTdjMC03LjA5OSA1Ljc1NS0xMi44NTQgMTIuODU0LTEyLjg1NHYwaDQ3Mi44OTRjNi45NjUgMC4wMjEgMTIuNjk3IDUuMjY1IDEzLjQ5MSAxMi4wMTlsMC4wMDcgMC4wNjQgMjEuNTk0IDIwOS4zODljLTczLjk4NCAzLjU5NC0xNDAuODE0IDMxLjU1OS0xOTMuMjggNzUuOTdsMC40NzItMC4zOTFjLTgwLjIwOCA2OC42MzktMTEzLjExNCAxNjcuMTAxLTEyNi40ODIgMjMzLjI5OHpNNzk5LjgwOCA5MDUuNTg1aC0yMzEuMzY5YzEyLjg1NC00OC45NzMgMzcuNjYxLTExMi4zNDMgODguNDM1LTE1NS41MzIgMzYuNzM0LTMwLjYyIDgzLjk4LTQ5Ljc2MyAxMzUuNjQzLTUxLjQwN2wwLjM1MS0wLjAwOSAxOS42NjYgMTkxLjM5M2MwLjEwNiAwLjYxOCAwLjE2NSAxLjMzIDAuMTY1IDIuMDU3IDAgNy4wOTktNS43NTUgMTIuODU0LTEyLjg1NCAxMi44NTQtMC4wMTQgMC0wLjAyNiAwLTAuMDQwIDBoMC4wMDJ6Ij48L3BhdGg+CjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0zNjIuNjQ5IDIzNWMwLjExNSAwLjAwMiAwLjI1IDAuMDAyIDAuMzg1IDAuMDAyIDI3LjI2MSAwIDQ5LjM1OS0yMi4wOTggNDkuMzU5LTQ5LjM1OSAwIDAgMC0wLjAwMiAwLTAuMDAydjBjMi4wMDMtNTQuNjQ3IDQ2Ljc4Ni05OC4xODYgMTAxLjczOC05OC4xODZzOTkuNzM1IDQzLjU0IDEwMS43MzMgOTguMDA0bDAuMDA1IDAuMTgyYzEuMzc4IDI2LjIyNCAyMi45NzggNDYuOTY2IDQ5LjQyMyA0Ni45NjZzNDguMDQ1LTIwLjc0MiA0OS40MTgtNDYuODQzbDAuMDA1LTAuMTIyYzAuMDQyLTEuNTEyIDAuMDY0LTMuMjkzIDAuMDY0LTUuMDc4IDAtMTEwLjgxNi04OS44MzQtMjAwLjY0OC0yMDAuNjQ4LTIwMC42NDhzLTIwMC42NDggODkuODM0LTIwMC42NDggMjAwLjY0OGMwIDEuNzg2IDAuMDIzIDMuNTY2IDAuMDY5IDUuMzRsLTAuMDA1LTAuMjYyYzAgMCAwIDAgMCAwIDAgMjcuMTcxIDIxLjk1MiA0OS4yMTMgNDkuMDg4IDQ5LjM1OWgwLjAxNHoiPjwvcGF0aD4KPC9zdmc+Cg==';
    }

    function get_settings_sections()
    {
        $sections = [
            [
                'id'    => 'ultimate_store_kit_active_modules',
                'title' => esc_html__('WC Widgets', 'ultimate-store-kit'),
            ],
            [
                'id'    => 'ultimate_store_kit_edd_modules',
                'title' => esc_html__('EDD Widgets', 'ultimate-store-kit'),
            ],
            [
                'id'    => 'ultimate_store_kit_general_modules',
                'title' => esc_html__('Other Widgets', 'ultimate-store-kit'),
            ],
            [
                'id'    => 'ultimate_store_kit_other_settings',
                'title' => esc_html__('Other Settings', 'ultimate-store-kit'),
            ],
        ];
        return $sections;
    }

    protected function ultimate_store_kit_admin_settings()
    {
        return ModuleService::get_widget_settings(function ($settings) {
            $settings_fields    = $settings['settings_fields'];

            self::$modules_list = array_merge($settings_fields['ultimate_store_kit_active_modules'], $settings_fields['ultimate_store_kit_edd_modules'], $settings_fields['ultimate_store_kit_general_modules']);
            self::$modules_list_only_widgets  = $settings_fields['ultimate_store_kit_active_modules'];
            self::$modules_list_only_edd_widgets = $settings_fields['ultimate_store_kit_edd_modules'];

            return $settings_fields;
        });
    }



    /**
     * Get separate widgets name
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_usk_only_widgets()
    {
        $names = self::$modules_names_only_widgets;

        if (null === $names) {
            $names = array_map(
                function ($item) {
                    return isset($item['name']) ? 'usk-' . str_replace('_', '-', $item['name']) : 'none';
                },
                self::$modules_list_only_widgets
            );
        }

        return $names;
    }

    /**
     * Get widgets name
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_usk_widgets_names()
    {
        $names = self::$modules_names;

        if (null === $names) {
            $names = array_map(
                function ($item) {
                    return isset($item['name']) ? 'usk-' . str_replace('_', '-', $item['name']) : 'none';
                },
                self::$modules_list
            );
        }

        return $names;
    }
    /**
     * Get used widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */
    public static function get_used_widgets()
    {

        $used_widgets = array();

        if (class_exists('Elementor\Modules\Usage\Module')) {

            $module     = Module::instance();
            
            $old_error_level = error_reporting();
 			error_reporting(E_ALL & ~E_WARNING); // Suppress warnings
 			$elements = $module->get_formatted_usage('raw');
 			error_reporting($old_error_level); // Restore

            $usk_widgets = self::get_usk_widgets_names();

            if (is_array($elements) || is_object($elements)) {

                foreach ($elements as $post_type => $data) {
                    foreach ($data['elements'] as $element => $count) {
                        if (in_array($element, $usk_widgets, true)) {
                            if (isset($used_widgets[$element])) {
                                $used_widgets[$element] += $count;
                            } else {
                                $used_widgets[$element] = $count;
                            }
                        }
                    }
                }
            }
        }

        return $used_widgets;
    }

    /**
     * Get used separate widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_used_only_widgets()
    {

        $used_widgets = array();

        if (class_exists('Elementor\Modules\Usage\Module')) {

            $module     = Module::instance();
            
            $old_error_level = error_reporting();
 			error_reporting(E_ALL & ~E_WARNING); // Suppress warnings
 			$elements = $module->get_formatted_usage('raw');
 			error_reporting($old_error_level); // Restore
            
            $usk_widgets = self::get_usk_only_widgets();

            if (is_array($elements) || is_object($elements)) {

                foreach ($elements as $post_type => $data) {
                    foreach ($data['elements'] as $element => $count) {
                        if (in_array($element, $usk_widgets, true)) {
                            if (isset($used_widgets[$element])) {
                                $used_widgets[$element] += $count;
                            } else {
                                $used_widgets[$element] = $count;
                            }
                        }
                    }
                }
            }
        }

        return $used_widgets;
    }

    /**
     * Get used only separate edd_widgets widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_usk_only_edd_widgets_names()
    {
        $names = self::$modules_names_only_edd_widgets;

        if (null === $names) {
            $names = array_map(
                function ($item) {
                    return isset($item['name']) ? 'usk-' . str_replace('_', '-', $item['name']) : 'none';
                },
                self::$modules_list_only_edd_widgets
            );
        }

        return $names;
    }
    public static function get_used_only_edd_widgets()
    {

        $used_widgets = array();

        if (class_exists('Elementor\Modules\Usage\Module')) {

            $module     = Module::instance();
            
            $old_error_level = error_reporting();
 			error_reporting(E_ALL & ~E_WARNING); // Suppress warnings
 			$elements = $module->get_formatted_usage('raw');
 			error_reporting($old_error_level); // Restore
            
            $usk_widgets = self::get_usk_only_edd_widgets_names();

            if (is_array($elements) || is_object($elements)) {

                foreach ($elements as $post_type => $data) {
                    foreach ($data['elements'] as $element => $count) {
                        if (in_array($element, $usk_widgets, true)) {
                            if (isset($used_widgets[$element])) {
                                $used_widgets[$element] += $count;
                            } else {
                                $used_widgets[$element] = $count;
                            }
                        }
                    }
                }
            }
        }

        return $used_widgets;
    }

    /**
     * Get unused widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_unused_widgets()
    {

        if (!current_user_can('install_plugins')) {
            die();
        }

        $usk_widgets = self::get_usk_widgets_names();

        $used_widgets = self::get_used_widgets();

        $unused_widgets = array_diff($usk_widgets, array_keys($used_widgets));

        return $unused_widgets;
    }

    /**
     * Get unused separate widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_unused_only_widgets()
    {

        if (!current_user_can('install_plugins')) {
            die();
        }

        $usk_widgets = self::get_usk_only_widgets();

        $used_widgets = self::get_used_only_widgets();

        $unused_widgets = array_diff($usk_widgets, array_keys($used_widgets));

        return $unused_widgets;
    }

    /**
     * Get unused separate edd_widgets widgets.
     *
     * @access public
     * @return array
     * @since 6.0.0
     *
     */

    public static function get_unused_only_edd_widgets()
    {

        if (!current_user_can('install_plugins')) {
            die();
        }

        $usk_widgets = self::get_usk_only_edd_widgets_names();

        $used_widgets = self::get_used_only_edd_widgets();

        $unused_widgets = array_diff($usk_widgets, array_keys($used_widgets));

        return $unused_widgets;
    }

    /**
     * Get Welcome Panel
     *
     * @access public
     * @return void
     */

    public function ultimate_store_kit_welcome()
    {
        $track_nw_msg = '';
        if (!Tracker::is_allow_track()) {
            $track_nw = esc_html__('This feature is not working because the Elementor Usage Data Sharing feature is Not Enabled.', 'ultimate-store-kit');
            $track_nw_msg = 'bdt-tooltip="' . $track_nw . '"';
        }
?>

        <div class="bdt-dashboard-panel" bdt-scrollspy="target: > div > div > .bdt-card; cls: bdt-animation-slide-bottom-small; delay: 300">
            <div class="bdt-grid bdt-grid-medium" bdt-grid bdt-height-match="target: > div > .bdt-card">
                <div class="bdt-width-1-2@m bdt-width-1-4@l">
                    <div class="bdt-widget-status bdt-card bdt-card-body" <?php echo wp_kses_post($track_nw_msg); ?>>

                        <?php
                        $used_widgets    = count(self::get_used_widgets());
                        $un_used_widgets = count(self::get_unused_widgets());
                        ?>


                        <div class="bdt-count-canvas-wrap">
                            <h1 class="bdt-feature-title"><?php esc_html_e('All Widgets', 'ultimate-store-kit'); ?></h1>
                            <div class="bdt-flex bdt-flex-between bdt-flex-middle">
                                <div class="bdt-count-wrap">
                                    <div class="bdt-widget-count"><?php esc_html_e('Used: ', 'ultimate-store-kit'); ?> <b><?php echo esc_html($used_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Unused: ', 'ultimate-store-kit'); ?> <b><?php echo esc_html($un_used_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Total: ', 'ultimate-store-kit'); ?>
                                        <b><?php echo esc_html($used_widgets) + esc_html($un_used_widgets); ?></b>
                                    </div>
                                </div>

                                <div class="bdt-canvas-wrap">
                                    <canvas id="bdt-db-total-status" style="height: 100px; width: 100px;" data-label="Total Widgets Status - (<?php echo esc_attr($used_widgets) + esc_attr($un_used_widgets); ?>)" data-labels="<?php echo esc_attr('Used, Unused'); ?>" data-value="<?php echo esc_attr($used_widgets) . ',' . esc_attr($un_used_widgets); ?>" data-bg="#FFD166, #fff4d9" data-bg-hover="#0673e1, #e71522"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="bdt-width-1-2@m bdt-width-1-4@l">
                    <div class="bdt-widget-status bdt-card bdt-card-body" <?php echo wp_kses_post($track_nw_msg); ?>>

                        <?php
                        $used_only_widgets   = count(self::get_used_only_widgets());
                        $unused_only_widgets = count(self::get_unused_only_widgets());
                        ?>


                        <div class="bdt-count-canvas-wrap">
                            <h1 class="bdt-feature-title"><?php esc_html_e('WooCommerce', 'ultimate-store-kit'); ?></h1>
                            <div class="bdt-flex bdt-flex-between bdt-flex-middle">
                                <div class="bdt-count-wrap">
                                    <div class="bdt-widget-count"><?php esc_html_e('Used: ', 'ultimate-store-kit'); ?><b><?php echo esc_html($used_only_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Unused: ', 'ultimate-store-kit'); ?><b><?php echo esc_html($unused_only_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Total: ', 'ultimate-store-kit'); ?>
                                        <b><?php echo esc_html($used_only_widgets) + esc_html($unused_only_widgets); ?></b>
                                    </div>
                                </div>

                                <div class="bdt-canvas-wrap">
                                    <canvas id="bdt-db-only-widget-status" style="height: 100px; width: 100px;" data-label="WooCommerce Widgets Status - (<?php echo esc_attr($used_only_widgets) + esc_attr($unused_only_widgets); ?>)" data-labels="<?php echo esc_attr('Used, Unused'); ?>" data-value="<?php echo esc_attr($used_only_widgets) . ',' . esc_attr($unused_only_widgets); ?>" data-bg="#EF476F, #ffcdd9" data-bg-hover="#0673e1, #e71522"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="bdt-width-1-2@m bdt-width-1-4@l">
                    <div class="bdt-widget-status bdt-card bdt-card-body" <?php echo wp_kses_post($track_nw_msg); ?>>

                        <?php
                        $used_only_edd_widgets   = count(self::get_used_only_edd_widgets());
                        $unused_only_edd_widgets = count(self::get_unused_only_edd_widgets());
                        ?>


                        <div class="bdt-count-canvas-wrap">
                            <h1 class="bdt-feature-title"><?php esc_html_e('EDD', 'ultimate-store-kit'); ?></h1>
                            <div class="bdt-flex bdt-flex-between bdt-flex-middle">
                                <div class="bdt-count-wrap">
                                    <div class="bdt-widget-count"><?php esc_html_e('Used: ', 'ultimate-store-kit'); ?><b><?php echo esc_html($used_only_edd_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Unused: ', 'ultimate-store-kit'); ?><b><?php echo esc_html($unused_only_edd_widgets); ?></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Total: ', 'ultimate-store-kit'); ?><b><?php echo esc_html($used_only_edd_widgets) + esc_html($unused_only_edd_widgets); ?></b>
                                    </div>
                                </div>

                                <div class="bdt-canvas-wrap">
                                    <canvas id="bdt-db-only-edd_widgets-status" style="height: 100px; width: 100px;" data-label="EDD Widgets Status - (<?php echo esc_attr($used_only_edd_widgets) + esc_attr($unused_only_edd_widgets); ?>)" data-labels="<?php echo esc_attr('Used, Unused'); ?>" data-value="<?php echo esc_attr($used_only_edd_widgets) . ',' . esc_attr($unused_only_edd_widgets); ?>" data-bg="#06D6A0, #B6FFEC" data-bg-hover="#0673e1, #e71522"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="bdt-width-1-2@m bdt-width-1-4@l">
                    <div class="bdt-widget-status bdt-card bdt-card-body" <?php echo wp_kses_post($track_nw_msg); ?>>

                        <div class="bdt-count-canvas-wrap">
                            <h1 class="bdt-feature-title"><?php esc_html_e('Active', 'ultimate-store-kit'); ?></h1>
                            <div class="bdt-flex bdt-flex-between bdt-flex-middle">
                                <div class="bdt-count-wrap">
                                    <div class="bdt-widget-count"><?php esc_html_e('WooCommerce: ', 'ultimate-store-kit'); ?><b id="bdt-total-widgets-status-core"></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('EDD: ', 'ultimate-store-kit'); ?><b id="bdt-total-widgets-status-3rd"></b></div>
                                    <div class="bdt-widget-count"><?php esc_html_e('Total: ', 'ultimate-store-kit'); ?><b id="bdt-total-widgets-status-heading"></b></div>
                                </div>

                                <div class="bdt-canvas-wrap">
                                    <canvas id="bdt-total-widgets-status" style="height: 100px; width: 100px;" data-label="Total Active Widgets Status" data-labels="<?php echo esc_attr('WooCommerce, EDD'); ?>" data-bg="#0680d6, #B0EBFF" data-bg-hover="#0673e1, #B0EBFF">
                                    </canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="bdt-grid bdt-grid-medium" bdt-grid bdt-height-match="target: > div > .bdt-card">
                <div class="bdt-width-2-5@m bdt-support-section">
                    <div class="bdt-support-content bdt-card bdt-card-body">
                        <?php
                        echo '<h1 class="bdt-feature-title">' . esc_html__('Support And Feedback', 'ultimate-store-kit') . '</h1>';
                        echo '<p>' . esc_html__('Feeling like to consult with an expert? Take live Chat support immediately from', 'ultimate-store-kit') . ' <a href="https://storekit.pro/" target="_blank" rel="">UltimteStoreKit</a>. ' . esc_html__('We are always ready to help you 24/7.', 'ultimate-store-kit') . '</p>';
                        echo '<p><strong>' . esc_html__('Or if you’re facing technical issues with our plugin, then please create a support ticket', 'ultimate-store-kit') . '</strong></p>';
                        echo '<a class="bdt-button bdt-btn-blue bdt-margin-small-top bdt-margin-small-right" target="_blank" rel="" href="https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/">' . esc_html__('Knowledge Base', 'ultimate-store-kit') . '</a>';
                        echo '<a class="bdt-button bdt-btn-grey bdt-margin-small-top" target="_blank" href="https://bdthemes.com/support/">' . esc_html__('Get Support', 'ultimate-store-kit') . '</a>';
                        ?>
                    </div>
                </div>

                <div class="bdt-width-3-5@m">
                    <div class="bdt-card bdt-card-body bdt-system-requirement">
                        <h1 class="bdt-feature-title bdt-margin-small-bottom"><?php esc_html_e('System Requirement', 'ultimate-store-kit'); ?></h1>
                        <?php $this->ultimate_store_kit_system_requirement(); ?>
                    </div>
                </div>
            </div>
            <div class="bdt-grid bdt-grid-medium" bdt-grid bdt-height-match="target: > div > .bdt-card">
                <div class="bdt-width-1-2@m bdt-support-section">
                    <div class="bdt-card bdt-card-body bdt-feedback-bg">
                        <?php
                        echo '<h1 class="bdt-feature-title">' . esc_html__('Feedback', 'ultimate-store-kit') . '</h1>';
                        echo '<p>' . esc_html__('We are always looking for feedback from our users. If you have any suggestions or feedback, please let us know.', 'ultimate-store-kit') . '</p>';
                        echo '<a class="bdt-button bdt-btn-grey bdt-margin-small-top" target="_blank" rel="" href="https://feedback.bdthemes.com/b/6vr2250l/feature-requests/">' . esc_html__('Request Feature', 'ultimate-store-kit') . '</a>';
                        ?>
                    </div>
                </div>

                <div class="bdt-width-1-2@m">
                    <div class="bdt-card bdt-card-body bdt-tryaddon-bg">
                        <?php
                        echo '<h1 class="bdt-feature-title">' . esc_html__('Try Our Others Plugins', 'ultimate-store-kit') . '</h1>';
                        echo '<p style="max-width: 520px;">' . esc_html__('Element Pack, Prime Slider, Ultimate Post Kit, Pixel Gallery & Live Copy Paste addons for Elementor is the best slider, blogs and eCommerce plugin for WordPress. Also, try our new plugin ZoloBlocks for Gutenberg.', 'ultimate-store-kit') . '</p>';
                        echo '<div class="bdt-others-plugins-link">';
                        echo '<a class="bdt-button bdt-btn-ep bdt-margin-small-right" target="_blank" href="https://wordpress.org/plugins/bdthemes-element-pack-lite/" bdt-tooltip="' . esc_html__('Element Pack Lite provides more than 50+ essential elements for everyday applications to simplify the whole web building process. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('Element pack', 'ultimate-store-kit') . '</a>';
                        echo '<a class="bdt-button bdt-btn-ps bdt-margin-small-right" target="_blank" rel="" href="https://wordpress.org/plugins/bdthemes-prime-slider-lite/" bdt-tooltip="' . esc_html__('The revolutionary slider builder addon for Elementor with next-gen superb interface. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('Prime Slider', 'ultimate-store-kit') . '</a>';
                        echo '<a class="bdt-button bdt-btn-zb bdt-margin-small-right" target="_blank" rel="" href="https://wordpress.org/plugins/zoloblocks/" bdt-tooltip="' . esc_html__('ZoloBlocks is a collection of creative Gutenberg blocks for WordPress. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('ZoloBlocks', 'ultimate-store-kit') . '</a>';
                        echo '<br>';
                        echo '<a class="bdt-button bdt-btn-upk bdt-margin-small-right" target="_blank" rel="" href="https://wordpress.org/plugins/ultimate-post-kit/" bdt-tooltip="' . esc_html__('Best blogging addon for building quality blogging website with fine-tuned features and widgets. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('Ultimate Post Kit', 'ultimate-store-kit') . '</a>';
                        echo '<a class="bdt-button bdt-btn-pg bdt-margin-small-right" target="_blank" href="https://wordpress.org/plugins/pixel-gallery/" bdt-tooltip="' . esc_html__('Pixel Gallery provides more than 30+ essential elements for everyday applications to simplify the whole web building process. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('Pixel Gallery', 'ultimate-store-kit') . '</a>';
                        echo '<a class="bdt-button bdt-btn-live-copy bdt-margin-small-right" target="_blank" rel="" href="https://wordpress.org/plugins/live-copy-paste/" bdt-tooltip="' . esc_html__('Superfast cross-domain copy-paste mechanism for WordPress websites with true UI copy experience. It\'s Free! Download it.', 'ultimate-store-kit') . '">' . esc_html__('Live Copy Paste', 'ultimate-store-kit') . '</a>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>


    <?php
    }

    /**
     * Get Pro
     *
     * @access public
     * @return void
     */

    function ultimate_store_kit_get_pro()
    {
    ?>
        <div class="bdt-dashboard-panel" bdt-scrollspy="target: > div > div > .bdt-card; cls: bdt-animation-slide-bottom-small; delay: 300">

            <div class="bdt-grid" bdt-grid bdt-height-match="target: > div > .bdt-card" style="max-width: 800px; margin-left: auto; margin-right: auto;">
                <div class="bdt-width-1-1@m bdt-comparision bdt-text-center">
                    <div class="bdt-flex bdt-flex-between bdt-flex-middle">
                        <div class="bdt-text-left">
                            <?php
                            echo '<h1 class="bdt-text-bold">' . esc_html__('WHY GO WITH PRO?', 'ultimate-store-kit') . '</h1>';
                            echo '<h2>' . esc_html__('Just Compare With Ultimate Store Kit Free Vs Pro', 'ultimate-store-kit') . '</h2>';
                            ?>
                        </div>
                        <?php if (true !== _is_usk_pro_activated()) : ?>
                            <div class="bdt-purchase-button">
                                <a href="https://storekit.pro/pricing" target="_blank"><?php esc_html_e('Purchase Now', 'ultimate-store-kit'); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div>

                        <ul class="bdt-list bdt-list-divider bdt-text-left bdt-text-normal" style="font-size: 15px;">


                            <li class="bdt-text-bold">
                                <div class="bdt-grid">
                                    <?php
                                    echo '<div class="bdt-width-expand@m">' . esc_html__('Features', 'ultimate-store-kit') . '</div>';
                                    echo '<div class="bdt-width-auto@m">' . esc_html__('Free', 'ultimate-store-kit') . '</div>';
                                    echo '<div class="bdt-width-auto@m">' . esc_html__('Pro', 'ultimate-store-kit') . '</div>';
                                    ?>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <div class="bdt-width-expand@m"><span bdt-tooltip="pos: top-left; title: Lite have 35+ Widgets but Pro have 100+ core widgets"><?php esc_html_e('Core Widgets', 'ultimate-store-kit'); ?></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <?php echo '<div class="bdt-width-expand@m">' . esc_html__('Theme Compatibility', 'ultimate-store-kit') . '</div>'; ?>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <?php echo '<div class="bdt-width-expand@m">' . esc_html__('Dynamic Content & Custom Fields Capabilities', 'ultimate-store-kit') . '</div>'; ?>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <?php echo '<div class="bdt-width-expand@m">' . esc_html__('Proper Documentation', 'ultimate-store-kit') . '</div>'; ?>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <?php echo '<div class="bdt-width-expand@m">' . esc_html__('Updates & Support', 'ultimate-store-kit') . '</div>'; ?>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <div class="bdt-width-expand@m"><?php echo esc_html__('Ready Made Blocks', 'ultimate-store-kit'); ?></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <div class="bdt-width-expand@m"><?php echo esc_html__('Ready Made Pages', 'ultimate-store-kit'); ?></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <?php echo '<div class="bdt-width-expand@m">' . esc_html__('Rooten Theme Pro Features', 'ultimate-store-kit') . '</div>'; ?>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-no"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                            <li class="">
                                <div class="bdt-grid">
                                    <div class="bdt-width-expand@m"><?php echo esc_html__('Priority Support', 'ultimate-store-kit'); ?></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-no"></span></div>
                                    <div class="bdt-width-auto@m"><span class="dashicons dashicons-yes"></span></div>
                                </div>
                            </li>
                        </ul>

                        <div class="bdt-more-features bdt-card bdt-card-body bdt-margin-medium-top bdt-padding-large">
                            <ul class="bdt-list bdt-list-divider bdt-text-left" style="font-size: 15px;">
                                <li>
                                    <div class="bdt-grid bdt-grid-small">
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Incredibly Advanced', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Refund or Cancel Anytime', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Dynamic Content', 'ultimate-store-kit'); ?>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="bdt-grid bdt-grid-small">
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Super-Flexible Widgets', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' 24/7 Premium Support', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Third Party Plugins', 'ultimate-store-kit'); ?>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="bdt-grid bdt-grid-small">
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Special Discount!', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Custom Field Integration', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' With Live Chat Support', 'ultimate-store-kit'); ?>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="bdt-grid bdt-grid-small">
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Trusted Payment Methods', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Interactive Effects', 'ultimate-store-kit'); ?>
                                        </div>
                                        <div class="bdt-width-1-3@m">
                                            <span class="dashicons dashicons-heart"></span><?php esc_html_e(' Video Tutorial', 'ultimate-store-kit'); ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <?php if (true !== _is_usk_pro_activated()) : ?>
                                <div class="bdt-purchase-button bdt-margin-medium-top">
                                    <a href="https://storekit.pro/pricing" target="_blank"><?php esc_html_e('Purchase Now', 'ultimate-store-kit'); ?></a>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    <?php
    }


    function ultimate_store_kit_system_requirement()
    {
        $php_version        = phpversion();
        $max_execution_time = ini_get('max_execution_time');
        $memory_limit       = ini_get('memory_limit');
        $post_limit         = ini_get('post_max_size');
        $uploads            = wp_upload_dir();
        $upload_path        = $uploads['basedir'];
        $yes_icon           = '<i class="dashicons-before dashicons-yes"></i>';
        $no_icon            = '<i class="dashicons-before dashicons-no-alt"></i>';
        $icon_validation = [
            'i' => [
                'class' => []
            ]
        ];

        $environment = Utils::get_environment_info();

    ?>
        <ul class="check-system-status bdt-grid bdt-child-width-1-2@m bdt-grid-small ">
            <li>
                <div>

                    <span class="label1"><?php esc_html_e('PHP Version:', 'ultimate-store-kit'); ?> </span>

                    <?php
                    if (version_compare($php_version, '7.0.0', '<')) {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s (Min: 7.0 Recommended)</span>', esc_html($php_version));
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s</span>', esc_html($php_version));
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('Maximum execution time:', 'ultimate-store-kit'); ?> </span>

                    <?php
                    if ($max_execution_time < '90') {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s ( Min: 90 Recommended)</span>', esc_html($max_execution_time));
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s</span>', esc_html($max_execution_time));
                    }
                    ?>
                </div>
            </li>
            <li>
                <div>
                    <span class="label1"><?php esc_html_e('Memory Limit:', 'ultimate-store-kit'); ?> </span>

                    <?php
                    if (intval($memory_limit) < '256') {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s (Min: 256M Recommended)</span>', esc_html($memory_limit));
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s</span>', esc_html($memory_limit));
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('Max Post Limit:', 'ultimate-store-kit'); ?> </span>

                    <?php
                    if (intval($post_limit) < '32') {
                        printf('<span class="invalid">%1$s</span>',  wp_kses($no_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s (Min: 32M Recommended)</span>', esc_html($post_limit));
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        printf('<span class="label2">Currently: %1$s</span>', esc_html($post_limit));
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('Uploads folder writable:', 'ultimate-store-kit'); ?></span>

                    <?php
                    if (!is_writable($upload_path)) {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('MultiSite: ', 'ultimate-store-kit'); ?></span>

                    <?php
                    if ($environment['wp_multisite']) {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        echo '<span class="label2">MultiSite</span>';
                    } else {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                        echo '<span class="label2">No MultiSite </span>';
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('GZip Enabled:', 'ultimate-store-kit'); ?></span>

                    <?php
                    if ($environment['gzip_enabled']) {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                    } else {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                    }
                    ?>
                </div>
            </li>

            <li>
                <div>
                    <span class="label1"><?php esc_html_e('Debug Mode: ', 'ultimate-store-kit'); ?></span>
                    <?php
                    if ($environment['wp_debug_mode']) {
                        printf('<span class="invalid">%1$s</span>', wp_kses($no_icon, $icon_validation));
                        echo '<span class="label2">Currently Turned On</span>';
                    } else {
                        printf('<span class="valid">%1$s</span>', wp_kses($yes_icon, $icon_validation));
                        echo '<span class="label2">Currently Turned Off</span>';
                    }
                    ?>
                </div>
            </li>

        </ul>

        <div class="bdt-admin-alert">
            <strong><?php esc_html_e('Note:', 'ultimate-store-kit'); ?></strong> <?php esc_html_e('If you have multiple addons like', 'ultimate-store-kit'); ?> <b><?php esc_html_e('Ultimate Store Kit', 'ultimate-store-kit'); ?></b>
            <?php esc_html_e('so you need some more requirement some
      cases so make sure you added more memory for others addon too.', 'ultimate-store-kit'); ?>
        </div>
    <?php
    }

    function plugin_page()
    {

        echo '<div class="wrap ultimate-store-kit-dashboard">';
        printf('<h1>%1$s ' . esc_html__('Settings', 'ultimate-store-kit') . '</h1>', esc_html(BDTUSK_TITLE));

        $this->settings_api->show_navigation();

    ?>

        <div class="bdt-switcher bdt-tab-container bdt-container-xlarge" style="touch-action: pan-y pinch-zoom;">
            <!-- <div class="bdt-switcher"> -->
            <div id="ultimate_store_kit_welcome_page" class="bdt-option-page group">
                <?php $this->ultimate_store_kit_welcome(); ?>
            </div>

            <?php
            $this->settings_api->show_forms();
            ?>

            <?php if (_is_usk_pro_activated() !== true) : ?>
                <div id="ultimate_store_kit_get_pro" class="bdt-option-page group">
                    <?php $this->ultimate_store_kit_get_pro(); ?>
                </div>
            <?php endif; ?>

            <div id="ultimate_store_kit_license_settings_page" class="bdt-option-page group">

                <?php
                if (_is_usk_pro_activated() == true) {
                    apply_filters('usk_license_page', '');
                }

                ?>

                <?php if (!defined('BDTUSK_WL')) {
                    $this->footer_info();
                } ?>
            </div>

        </div>

        </div>

        <?php if (!defined('BDTUSK_WL')) {
            //$this->footer_info();
        } ?>

        <?php

        $this->script();

        ?>

    <?php
    }

    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script()
    {
    ?>
        <script>
            jQuery(document).ready(function() {
                jQuery('.bdt-no-result').removeClass('bdt-animation-shake');
            });

            function filterSearch(e) {
                var parentID = '#' + jQuery(e).data('id');
                var search = jQuery(parentID).find('.bdt-search-input').val().toLowerCase();

                jQuery(".bdt-options .usk-option-item").filter(function() {
                    jQuery(this).toggle(jQuery(this).attr('data-widget-name').toLowerCase().indexOf(search) > -1)
                });

                if (!search) {
                    jQuery(parentID).find('.bdt-search-input').attr('bdt-filter-control', "");
                    jQuery(parentID).find('.bdt-widget-all').trigger('click');
                } else {
                    jQuery(parentID).find('.bdt-search-input').attr('bdt-filter-control', "filter: [data-widget-name*='" + search + "']");
                    jQuery(parentID).find('.bdt-search-input').removeClass('bdt-active'); // Thanks to Bar-Rabbas
                    jQuery(parentID).find('.bdt-search-input').trigger('click');
                }
            }

            jQuery('.bdt-options-parent').each(function(e, item) {
                var eachItem = '#' + jQuery(item).attr('id');
                jQuery(eachItem).on("beforeFilter", function() {
                    jQuery(eachItem).find('.bdt-no-result').removeClass('bdt-animation-shake');
                });

                jQuery(eachItem).on("afterFilter", function() {

                    var isElementVisible = false;
                    var i = 0;

                    if (jQuery(eachItem).closest(".usk-options-parent").eq(i).is(":visible")) {} else {
                        isElementVisible = true;
                    }

                    while (!isElementVisible && i < jQuery(eachItem).find(".bdt-option-item").length) {
                        if (jQuery(eachItem).find(".bdt-option-item").eq(i).is(":visible")) {
                            isElementVisible = true;
                        }
                        i++;
                    }

                    if (isElementVisible === false) {
                        jQuery(eachItem).find('.bdt-no-result').addClass('bdt-animation-shake');
                    }
                });


            });


            function clearSearchInputs(context) {
				context.find('.bdt-search-input').val('').attr('bdt-filter-control', '');
			}

			jQuery('.bdt-widget-filter-nav li a').on('click', function () {
				const wrapper = jQuery(this).closest('.bdt-widget-filter-wrapper');
				clearSearchInputs(wrapper);
			});

			jQuery('.bdt-dashboard-navigation li a').on('click', function () {
				const tabContainer = jQuery(this).closest('.bdt-dashboard-navigation').siblings('.bdt-tab-container');
				clearSearchInputs(tabContainer);
					tabContainer.find('.bdt-search-input').trigger('keyup');
			});


            jQuery(document).ready(function($) {
                'use strict';

                function hashHandler() {
                    var $tab = jQuery('.ultimate-store-kit-dashboard .bdt-tab');
                    if (window.location.hash) {
                        var hash = window.location.hash.substring(1);
                        bdtUIkit.tab($tab).show(jQuery('#bdt-' + hash).data('tab-index'));
                    }
                }

                function onWindowLoad() {
                    hashHandler();
                }

                if (document.readyState === 'complete') {
					onWindowLoad();
				} else {
					jQuery(window).on('load', onWindowLoad);
				}

                window.addEventListener("hashchange", hashHandler, true);

                jQuery('.toplevel_page_ultimate_store_kit_options > ul > li > a ').on('click', function(event) {
                    jQuery(this).parent().siblings().removeClass('current');
                    jQuery(this).parent().addClass('current');
                });

                jQuery('#ultimate_store_kit_active_modules_page a.bdt-active-all-widget').on('click', function(e) {
                    e.preventDefault();
                    jQuery('#ultimate_store_kit_active_modules_page .usk-option-item:not(.usk-pro-inactive) .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).attr('checked', 'checked').prop("checked", true);
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-deactive-all-widget').removeClass('bdt-active');
                });

                jQuery('#ultimate_store_kit_active_modules_page a.bdt-deactive-all-widget').on('click', function(e) {
                    e.preventDefault();
                    jQuery('#ultimate_store_kit_active_modules_page .usk-option-item:not(.usk-pro-inactive) .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).removeAttr('checked');
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-active-all-widget').removeClass('bdt-active');
                });

                jQuery('#ultimate_store_kit_edd_modules_page a.bdt-active-all-widget').on('click', function() {

                    jQuery('#ultimate_store_kit_edd_modules_page .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).attr('checked', 'checked').prop("checked", true);
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-deactive-all-widget').removeClass('bdt-active');
                });

                jQuery('#ultimate_store_kit_edd_modules_page a.bdt-deactive-all-widget').on('click', function() {

                    jQuery('#ultimate_store_kit_edd_modules_page .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).removeAttr('checked');
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-active-all-widget').removeClass('bdt-active');
                });

                /**
                 * Others Widget
                 */
                jQuery('#ultimate_store_kit_general_modules_page a.bdt-active-all-widget').on('click', function() {

                    jQuery('#ultimate_store_kit_general_modules_page .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).attr('checked', 'checked').prop("checked", true);
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-deactive-all-widget').removeClass('bdt-active');
                });
                jQuery('#ultimate_store_kit_general_modules_page a.bdt-deactive-all-widget').on('click', function() {

                    jQuery('#ultimate_store_kit_general_modules_page .checkbox:visible').not("[disabled]").each(function() {
                        jQuery(this).removeAttr('checked');
                    });

                    jQuery(this).addClass('bdt-active');
                    jQuery('a.bdt-active-all-widget').removeClass('bdt-active');
                });


                jQuery('form.settings-save').on('submit', function(event) {
                    event.preventDefault();

                    bdtUIkit.notification({
                        message: '<div bdt-spinner></div> <?php esc_html_e('Please wait, Saving settings...', 'ultimate-store-kit') ?>',
                        timeout: false
                    });

                    jQuery(this).ajaxSubmit({
                        success: function() {
                            bdtUIkit.notification.closeAll();
                            bdtUIkit.notification({
                                message: '<span class="dashicons dashicons-yes"></span> <?php esc_html_e('Settings Saved Successfully.', 'ultimate-store-kit') ?>',
                                status: 'primary'
                            });
                        },
                        error: function(data) {
                            bdtUIkit.notification.closeAll();
                            bdtUIkit.notification({
                                message: '<span bdt-icon=\'icon: warning\'></span> <?php esc_html_e('Unknown error, make sure access is correct!', 'ultimate-store-kit') ?>',
                                status: 'warning'
                            });
                        }
                    });

                    return false;
                });

                jQuery('#ultimate_store_kit_active_modules_page .usk-pro-inactive .checkbox').each(function() {
                    jQuery(this).removeAttr('checked');
                    jQuery(this).attr("disabled", true);
                });
                jQuery('#ultimate_store_kit_edd_modules_page .usk-pro-inactive .checkbox').each(function() {
                    jQuery(this).removeAttr('checked');
                    jQuery(this).attr("disabled", true);
                });
                jQuery('#ultimate_store_kit_general_modules_page .usk-pro-inactive .checkbox').each(function() {
                    jQuery(this).removeAttr('checked');
                    jQuery(this).attr("disabled", true);
                });
                jQuery('#ultimate_store_kit_other_settings_page .usk-pro-inactive .checkbox').each(function() {
                    jQuery(this).removeAttr('checked');
                    jQuery(this).attr("disabled", true);
                });
            });

            jQuery(document).ready(function ($) {
                const getProLink = $('a[href="admin.php?page=ultimate_store_kit_options_get_pro"]');
                if (getProLink.length) {
                    getProLink.attr('target', '_blank');
                }
            });

            jQuery(document).ready(function ($) {
                const renewalLink = $('a[href="admin.php?page=ultimate_store_kit_options_license_renew"]');
                if (renewalLink.length) {
                    renewalLink.attr('target', '_blank');
                }
            });

        </script>
    <?php
    }

    function footer_info()
    {
    ?>
        <div class="ultimate-store-kit-footer-info">
            <p><?php esc_html_e('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit'); ?> <a target="_blank" href="https://bdthemes.com"><?php esc_html_e('BdThemes', 'ultimate-store-kit'); ?></a> <?php esc_html_e('Team.', 'ultimate-store-kit'); ?> <br><?php esc_html_e('All
        rights reserved by BdThemes.', 'ultimate-store-kit'); ?></p>
        </div>
<?php
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages()
    {
        $pages         = get_pages();
        $pages_options = [];
        if ($pages) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }
}

new UltimateStoreKit_Admin_Settings();
