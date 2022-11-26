<?php
namespace UltimateStoreKit\Modules\BrandCarousel;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'brand-carousel';
	}

	public function get_widgets() {
		$widgets = [
			'Brand_Carousel',
		];

		return $widgets;
	}
}
