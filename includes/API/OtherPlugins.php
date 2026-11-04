<?php

namespace UltimateStoreKit\API;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * REST routes for the dashboard's Other Plugins page: the BdThemes plugins
 * with their WordPress.org details and local status, and installing one of
 * them. Only the slugs listed here can be installed. Activation uses
 * WordPress core's own nonce-signed link, built here per plugin.
 */
class OtherPlugins extends Base {

	/** Plugin details from WordPress.org, refreshed weekly. */
	const CACHE_KEY = 'ultimate_store_kit_other_plugins';

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
				'path'                => '/other-plugins',
				'methods'             => 'GET',
				'callback'            => [$this, 'get_plugins'],
				'permission_callback' => [$this, 'can_view'],
			],
			[
				'path'                => '/other-plugins/install',
				'methods'             => 'POST',
				'callback'            => [$this, 'install_plugin'],
				'permission_callback' => [$this, 'can_install'],
				'args'                => [
					'slug' => [
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_key',
					],
				],
			],
		];
	}

	public function can_view() {
		return current_user_can('activate_plugins') || current_user_can('install_plugins');
	}

	public function can_install() {
		return current_user_can('install_plugins');
	}

	/**
	 * WordPress.org slugs of the BdThemes plugins offered on the page.
	 *
	 * @return string[]
	 */
	public static function slugs() {
		return [
			'bdthemes-element-pack-lite',
			'bdthemes-prime-slider-lite',
			'ultimate-post-kit',
			'pixel-gallery',
			'zoloblocks',
			'live-copy-paste',
			'spin-wheel',
			'ai-image',
			'dark-reader',
			'ar-viewer',
			'smart-admin-assistant',
			'website-accessibility',
		];
	}

	public function get_plugins(\WP_REST_Request $request) {
		$details = get_transient(self::CACHE_KEY);

		if (!is_array($details) || $request->get_param('refresh')) {
			$details = $this->fetch_details();

			if ($details) {
				set_transient(self::CACHE_KEY, $details, WEEK_IN_SECONDS);
			}
		}

		$plugins = [];

		foreach (self::slugs() as $slug) {
			$info      = isset($details[$slug]) ? $details[$slug] : ['slug' => $slug, 'name' => $slug];
			$file      = $this->plugin_file($slug);
			$plugins[] = array_merge($info, $this->local_state($slug, $file));
		}

		return $this->success([
			'plugins'    => $plugins,
			'canInstall' => current_user_can('install_plugins'),
		]);
	}

	public function install_plugin(\WP_REST_Request $request) {
		$slug = $request->get_param('slug');

		if (!in_array($slug, self::slugs(), true)) {
			return $this->error('invalid_plugin', __('This plugin cannot be installed from here.', 'ultimate-store-kit'), 400);
		}

		if ($this->plugin_file($slug)) {
			return $this->error('already_installed', __('The plugin is already installed.', 'ultimate-store-kit'), 400);
		}

		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$api = plugins_api('plugin_information', ['slug' => $slug, 'fields' => ['sections' => false]]);

		if (is_wp_error($api)) {
			return $this->error('not_found', $api->get_error_message(), 502);
		}

		$skin     = new \WP_Ajax_Upgrader_Skin();
		$upgrader = new \Plugin_Upgrader($skin);
		$result   = $upgrader->install($api->download_link);

		if (is_wp_error($result)) {
			return $this->error('install_failed', $result->get_error_message(), 500);
		}

		if ($skin->get_errors()->has_errors()) {
			return $this->error('install_failed', $skin->get_error_messages(), 500);
		}

		if (!$result) {
			return $this->error('install_failed', __('The plugin could not be installed. Check that WordPress can write to the plugins folder.', 'ultimate-store-kit'), 500);
		}

		wp_clean_plugins_cache();

		return $this->success([
			'message' => sprintf(
				/* translators: %s: plugin name. */
				__('%s installed.', 'ultimate-store-kit'),
				wp_strip_all_tags($api->name)
			),
			'plugin'  => $this->local_state($slug, $this->plugin_file($slug)),
		]);
	}

	/**
	 * Name, description, icon and version of each plugin from WordPress.org.
	 *
	 * @return array<string, array>
	 */
	private function fetch_details() {
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$details = [];

		foreach (self::slugs() as $slug) {
			$api = plugins_api('plugin_information', [
				'slug'   => $slug,
				'fields' => [
					'sections'          => false,
					'icons'             => true,
					'short_description' => true,
					'active_installs'   => true,
					'rating'            => true,
					'tags'              => false,
					'versions'          => false,
					'screenshots'       => false,
					'banners'           => false,
					'contributors'      => false,
					'reviews'           => false,
				],
			]);

			if (is_wp_error($api) || empty($api->name)) {
				continue;
			}

			$icons = isset($api->icons) ? (array) $api->icons : [];

			$details[$slug] = [
				'slug'           => $slug,
				'name'           => html_entity_decode(wp_strip_all_tags($api->name), ENT_QUOTES, 'UTF-8'),
				'description'    => html_entity_decode(wp_strip_all_tags(isset($api->short_description) ? $api->short_description : ''), ENT_QUOTES, 'UTF-8'),
				'version'        => isset($api->version) ? sanitize_text_field($api->version) : '',
				'icon'           => esc_url_raw(isset($icons['2x']) ? $icons['2x'] : (isset($icons['1x']) ? $icons['1x'] : (isset($icons['svg']) ? $icons['svg'] : ''))),
				'activeInstalls' => isset($api->active_installs) ? (int) $api->active_installs : 0,
				'rating'         => isset($api->rating) ? (int) $api->rating : 0,
				'url'            => 'https://wordpress.org/plugins/' . $slug . '/',
			];
		}

		return $details;
	}

	/**
	 * Installed plugin file for a slug (its folder name), or null.
	 *
	 * @param string $slug WordPress.org slug.
	 * @return string|null
	 */
	private function plugin_file($slug) {
		if (!function_exists('get_plugins')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		foreach (array_keys(get_plugins()) as $file) {
			if (0 === strpos($file, $slug . '/')) {
				return $file;
			}
		}

		return null;
	}

	/**
	 * Install status on this site, with the core activation link when allowed.
	 *
	 * @param string      $slug WordPress.org slug.
	 * @param string|null $file Installed plugin file.
	 * @return array
	 */
	private function local_state($slug, $file) {
		if (!function_exists('is_plugin_active')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Element Pack Pro replaces the free Element Pack.
		if ('bdthemes-element-pack-lite' === $slug && is_plugin_active('bdthemes-element-pack/bdthemes-element-pack.php')) {
			return ['status' => 'active', 'activateUrl' => ''];
		}

		if (!$file) {
			return ['status' => 'not_installed', 'activateUrl' => ''];
		}

		if (is_plugin_active($file)) {
			return ['status' => 'active', 'activateUrl' => ''];
		}

		return [
			'status'      => 'installed',
			'activateUrl' => current_user_can('activate_plugins')
				? wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . rawurlencode($file)), 'activate-plugin_' . $file)
				: '',
		];
	}
}
