<?php

namespace UltimateStoreKit;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Ultimate Store Kit Admin Settings class.
 */
class UltimateStoreKit_Settings {
    /**
     * The single class instance.
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * UltimateStoreKit_Settings constructor.
     */
    private function __construct() {
        add_action('admin_menu', [$this, 'register_admin_menu'], 20);
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
            esc_html__('Store Kit', 'ultimate-store-kit'),
            esc_html__('Store Kit', 'ultimate-store-kit'),
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
        <div class="ultimate-store-kit-admin-root"></div>
<?php
    }
}


UltimateStoreKit_Settings::instance();
