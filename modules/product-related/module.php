<?php

namespace UltimateStoreKit\Modules\ProductRelated;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'product-related';
	}

	public function get_widgets() {
		$widgets = [
			'Product_Related',
		];

		return $widgets;
	}
}
