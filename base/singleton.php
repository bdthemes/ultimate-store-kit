<?php

namespace UltimateStoreKit\Base;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}


trait Singleton {

	private static $instance;

	public static function instance() {
		if (!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function get_instance() {
		return self::instance();
	}

	public function __clone() {
		_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'ultimate-store-kit'), '1.0.0');
	}

	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'ultimate-store-kit'), '1.0.0');
	}
}
