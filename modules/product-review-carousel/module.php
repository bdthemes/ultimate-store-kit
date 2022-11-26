<?php

namespace UltimateStoreKit\Modules\ProductReviewCarousel;

use UltimateStoreKit\Base\Ultimate_Store_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Ultimate_Store_Kit_Module_Base {

    public function get_name() {
        return 'product-review-carousel';
    }

    public function get_widgets() {

        $widgets = [
            'Product_Review_Carousel',
        ];

        return $widgets;
    }
}
