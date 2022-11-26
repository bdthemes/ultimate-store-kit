<?php
namespace UltimateStoreKit\Modules\FeaturedBox;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'featured-box';
	}

	public function get_widgets() {
		$widgets = [
			'Featured_Box',
		];

		return $widgets;
	}
}
