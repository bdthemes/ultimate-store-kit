(function ($, elementor) {
    ("use strict");
    var SubCategoryCarousel = function ($scope, $) {
        var $SubCategoryCarousel = $scope.find(".usk-sub-category-carousel");
        if (!$SubCategoryCarousel.length) {
            return;
        }
        var $SubCategoryCarouselContainer = $SubCategoryCarousel.find(".swiper-carousel");
        var $carouselSettings = $SubCategoryCarousel.find('.usk-carousel').data("settings");

        const Swiper = elementorFrontend.utils.swiper;
		initSwiper();
		async function initSwiper() {
			var swiper = await new Swiper($SubCategoryCarouselContainer, $carouselSettings); // this is an example
			if ($carouselSettings.pauseOnHover) {
				$($SubCategoryCarouselContainer).hover(function () {
					(this).swiper.autoplay.stop();
				}, function () {
					(this).swiper.autoplay.start();
				});
			}
		};
    };
    jQuery(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/usk-sub-category-carousel.default",
            SubCategoryCarousel
        );
    });
})(jQuery, window.elementorFrontend);
