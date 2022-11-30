<?php

namespace UltimateStoreKit\Base;

use UltimateStoreKit\Includes\Builder\Builder_Widget_Base;
use UltimateStoreKit\Ultimate_Store_Kit_Loader;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
//Ultimate_Woo_Kit_Widget_Base
abstract class Module_Base extends Builder_Widget_Base {

    protected function usk_is_edit_mode() {

        if (Ultimate_Store_Kit_Loader::elementor()->preview->is_preview_mode() || Ultimate_Store_Kit_Loader::elementor()->editor->is_edit_mode()) {
            return true;
        }

        return false;
    }
}
