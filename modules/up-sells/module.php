<?php

namespace UltimateStoreKit\Modules\UpSells;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'up-sells';
	}

	public function get_widgets() {

		$widgets = [
			'Up_Sells',
		];

		return $widgets;
	}
}
