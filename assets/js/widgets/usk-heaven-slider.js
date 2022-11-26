(function ($, elementor) {

	'use strict';

	var widgetHeavenSlider = function ($scope, $) {

		var $slider = $scope.find('.ultimate-store-kit'),
            $mainSlider = $scope.find('.usk-heaven-slider');
        if (!$slider.length) {
            return;
        }

        var $sliderContainer = $slider.find('.usk-main-slider'),
            $settings = $mainSlider.data('settings');
            
        const Swiper = elementorFrontend.utils.swiper;
        initSwiper();
        async function initSwiper() {
            var mainSlider = await new Swiper($sliderContainer, $settings);

            if ($settings.pauseOnHover) {
                $($sliderContainer).hover(function () {
                    (this).swiper.autoplay.stop();
                }, function () {
                    (this).swiper.autoplay.start();
                });
            }

            var  $thumbs          = $slider.find('.usk-thumbs-slider');

            var sliderThumbs = await new Swiper($thumbs, {
                parallax: true,
                direction: 'vertical',
                spaceBetween: 10,
                slideToClickedSlide: true,
                loop: ($settings.loop) ? $settings.loop : false,
                speed: ($settings.speed) ? $settings.speed : 800,
                loopedSlides: 4,
                centeredSlides: true,
                slidesPerView: 3,
                initialSlide: 0,
                keyboardControl: true,
                mousewheelControl: true,
                lazyLoading: true,
                preventClicks: false,
                preventClicksPropagation: false,
                lazyLoadingInPrevNext: true,
                breakpoints: {
                    768: {
                        slidesPerView: 5,
                    },
                }
            });
    
            mainSlider.controller.control = sliderThumbs;
            sliderThumbs.controller.control = mainSlider;
        };
	};


	jQuery(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/usk-heaven-slider.default', widgetHeavenSlider);
	});

}(jQuery, window.elementorFrontend));