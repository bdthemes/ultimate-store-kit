<?php

/**
 * Abstract REST API Base Class
 *
 * Shared by both core and pro plugins to avoid redundant REST API code.
 */

namespace UltimateStoreKit\API;

if (!defined('ABSPATH')) {
    exit;
}

abstract class Base {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * REST namespace, e.g. 'ultimate-store-kit/v1'.
     */
    abstract protected function get_namespace();

    /**
     * Return an array of route definitions. Each element:
     * [
     *   'path'     => '/settings',
     *   'methods'  => 'POST',
     *   'callback' => [$this, 'method_name'],
     *   'args'     => [],                        // optional
     *   'permission_callback' => callable,        // optional, defaults to check_admin_permission
     * ]
     */
    abstract protected function get_routes();

    /**
     * Register all routes returned by get_routes().
     */
    public function register_routes() {
        foreach ($this->get_routes() as $route) {
            $config = [
                'methods'             => $route['methods'] ?? 'POST',
                'callback'            => $route['callback'],
                'permission_callback' => $route['permission_callback'] ?? [$this, 'check_admin_permission'],
            ];

            if (!empty($route['args'])) {
                $config['args'] = $route['args'];
            }

            register_rest_route($this->get_namespace(), $route['path'], $config);
        }
    }

    /**
     * Default permission callback — only administrators.
     */
    public function check_admin_permission() {
        return current_user_can('manage_options');
    }

    /**
     * Return a success REST response.
     */
    protected function success($data) {
        return rest_ensure_response($data);
    }

    /**
     * Return a WP_Error REST response.
     */
    protected function error($code, $message, $status = 400) {
        return new \WP_Error($code, $message, ['status' => $status]);
    }

    /**
     * Sanitize a flat key-value settings array.
     */
    protected function sanitize_settings($settings) {
        $sanitized = [];
        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                $sanitized[sanitize_text_field($key)] = sanitize_text_field($value);
            }
        }
        return $sanitized;
    }
}
