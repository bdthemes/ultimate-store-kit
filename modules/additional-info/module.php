<?php

namespace UltimateStoreKit\Modules\AdditionalInfo;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

	public function get_name() {
		return 'additional-info';
	}

	public function get_widgets() {

		$widgets = [
			'Additional_Info',
		];

		return $widgets;
	}
}
