<?php

namespace UltimateStoreKit\Modules\EddCategoryGrid;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'edd-category-grid';
	}

	public function get_widgets() {

		$widgets = [
			'EDD_Category_Grid',
		];

		return $widgets;
	}
}
