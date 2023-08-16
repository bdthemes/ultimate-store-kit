(function ($, elementor) {
    ("use strict");
    var FlorenceCarousel = function ($scope, $) {
        var $gridCarousel = $scope.find(".usk-florence-carousel");
        if (!$gridCarousel.length) {
            return;
        }
        var $gridCarouselContainer = $gridCarousel.find(".swiper-carousel");
        var $settings = $gridCarousel.find('.usk-carousel').data("settings");

    const Swiper = elementorFrontend.utils.swiper;
      initSwiper();
      async function initSwiper() {
          var swiper = await new Swiper($gridCarouselContainer, $settings);
      };
    };
    jQuery(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/usk-florence-carousel.default", FlorenceCarousel);
    });
})(jQuery, window.elementorFrontend);