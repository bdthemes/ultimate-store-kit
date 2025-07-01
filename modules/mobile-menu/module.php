<?php
namespace UltimateStoreKit\Modules\MobileMenu;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'mobile-menu';
	}

	public function get_widgets() {
		$widgets = [
			'Mobile_Menu',
		];

		return $widgets;
	}
}
