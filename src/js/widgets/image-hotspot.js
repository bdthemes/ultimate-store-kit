(function ($, elementor) {

    'use strict';

    var widgetImageHotspot = function ($scope, $) {

        var $imageHotspot = $scope.find('.usk-image-hotspot'),
            $settings = uskSafeSwiperSettings($imageHotspot.data('settings'));

        if (!$imageHotspot.length) {
            return;
        }

        if ($settings.image_hotspot_layout === 'slider') {

            var $thumbs = $imageHotspot.find('.usk-image-hotspot-thumbs');
            
            const Swiper = elementorFrontend.utils.swiper;
            initSwiper();
            async function initSwiper() {
                
                var sliderThumbs = await new Swiper($thumbs, $settings);

                var $imageHotspotContainer = $imageHotspot.find('.usk-image-hotspot-main');

                var mainSlider = await new Swiper($imageHotspotContainer, {
                    slidesPerView: 1,
                    effect: $settings.sliderEffect,
                    fadeEffect: {
                        crossFade: true
                    },
                    thumbs: {
                        swiper: sliderThumbs,
                    },
                });

            };
            
        }

        var $tooltip = $imageHotspot.find('.bdt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			var props = {
				allowHTML: true,
				interactive: true,
				theme: 'bdt-tippy-' + $settings.id,
                appendTo: document.body,
			};

			// The product card is printed in a <template> inside the marker and
			// handed to tippy as nodes, so it is never re-parsed from a string.
			var cardTemplate = this.querySelector('template.usk-image-hotspot-tooltip-content');
			if (cardTemplate && cardTemplate.content) {
				props.content = cardTemplate.content.cloneNode(true);
			}

			uskSafeTippy( this, props );
		});

    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-image-hotspot.default', widgetImageHotspot);
    });

}(jQuery, window.elementorFrontend));