<?php

namespace UltimateStoreKit\Modules\QrCode;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {
	public static function is_active() {
		return class_exists('woocommerce');
	}

	public function get_name() {
		return 'qr-code';
	}

	public function get_widgets() {
		return ['QR_Code'];
	}
}
