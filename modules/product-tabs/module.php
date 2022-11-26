<?php

namespace UltimateStoreKit\Modules\ProductTabs;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'product-tabs';
	}

	public function get_widgets() {
		$widgets = [
			'Product_Tabs',
		];

		return $widgets;
	}
}
