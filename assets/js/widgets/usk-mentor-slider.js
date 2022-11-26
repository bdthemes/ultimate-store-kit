(function ($, elementor) {

	'use strict';

	var widgetMentorSlider = function ($scope, $) {

		var $slider = $scope.find('.ultimate-store-kit'),
            $mainSlider = $scope.find('.usk-mentor-slider');
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
                spaceBetween: 10,
                slidesPerView: 4,
                touchRatio: 0.2,
                slideToClickedSlide: true,
                loop: ($settings.loop) ? $settings.loop : false,
                speed: ($settings.speed) ? $settings.speed : 800,
                loopedSlides: 4,
                breakpoints: {
                  768: {
                    slidesPerView: 4,
                  },
                  1024: {
                    slidesPerView: 4,
                  },
                }
            });
    
            mainSlider.controller.control = sliderThumbs;
            sliderThumbs.controller.control = mainSlider;
        };
	};


	jQuery(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/usk-mentor-slider.default', widgetMentorSlider);
	});

}(jQuery, window.elementorFrontend));