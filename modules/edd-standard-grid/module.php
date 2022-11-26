<?php

namespace UltimateStoreKit\Modules\EddStandardGrid;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {
	public static function is_active() {
		return class_exists('woocommerce');
	}

	public function get_name() {
		return 'usk-edd-standard-grid';
	}

	public function get_widgets() {
		return ['EDD_Standard_Grid'];
	}

	public function add_product_post_class($classes) {
		$classes[] = 'product';

		return $classes;
	}
}
