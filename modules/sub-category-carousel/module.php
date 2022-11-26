<?php

namespace UltimateStoreKit\Modules\SubCategoryCarousel;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

    public function get_name() {
        return 'product-sub-category-carousel';
    }

    public function get_widgets() {

        $widgets = [
            'Sub_Category_Carousel',
        ];

        return $widgets;
    }
}
