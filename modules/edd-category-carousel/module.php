<?php

namespace UltimateStoreKit\Modules\EddCategoryCarousel;

use UltimateStoreKit\Base\Ultimate_Store_kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_kit_Module_Base {

	public function get_name() {
		return 'edd-category-carousel';
	}

	public function get_widgets() {

		$widgets = [
			'EDD_Category_Carousel',
		];

		return $widgets;
	}
}
