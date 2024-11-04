(function ($, elementor) {

    'use strict';

    var widgetImageHotspot = function ($scope, $) {

        var $imageHotspot = $scope.find('.usk-image-hotspot'),
            $settings = $imageHotspot.data('settings');

        if (!$imageHotspot.length) {
            return;
        }

        var $imageHotspotContainer = $imageHotspot.find('.usk-main-slider');

        const Swiper = elementorFrontend.utils.swiper;
        initSwiper();
        async function initSwiper() {

            var $thumbs = $imageHotspot.find('.usk-thumbs-slider');

            var sliderThumbs = await new Swiper($thumbs, $settings);

            var mainSlider = await new Swiper($imageHotspotContainer, {
                slidesPerView: 1,
                thumbs: {
                    swiper: sliderThumbs,
                },
            });

        };
    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-image-hotspot.default', widgetImageHotspot);
    });

}(jQuery, window.elementorFrontend));