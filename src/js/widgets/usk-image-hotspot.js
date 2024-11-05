(function ($, elementor) {

    'use strict';

    var widgetImageHotspot = function ($scope, $) {

        var $imageHotspot = $scope.find('.usk-image-hotspot'),
            $settings = $imageHotspot.data('settings');

        if (!$imageHotspot.length) {
            return;
        }

        var $imageHotspotContainer = $imageHotspot.find('.usk-image-hotspot-main');

        const Swiper = elementorFrontend.utils.swiper;
        initSwiper();
        async function initSwiper() {

            var $thumbs = $imageHotspot.find('.usk-image-hotspot-thumbs');

            var sliderThumbs = await new Swiper($thumbs, $settings);

            var mainSlider = await new Swiper($imageHotspotContainer, {
                slidesPerView: 1,
                thumbs: {
                    swiper: sliderThumbs,
                },
            });

        };

        var $tooltip = $imageHotspot.find('.bdt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				allowHTML: true,
				interactive: true,
				theme: 'bdt-tippy-' + $settings.id,
                appendTo: document.body,
			});				
		});

    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-image-hotspot.default', widgetImageHotspot);
    });

}(jQuery, window.elementorFrontend));