(function ($, elementor) {
  ("use strict");
  var ShowcaseSlider = function ($scope, $) {
    var $gridCarousel = $scope.find(".usk-showcase-slider");
    if (!$gridCarousel.length) {
      return;
    }
    var $gridCarouselContainer = $gridCarousel.find(".swiper-carousel");
    var $settings = $gridCarousel.data("settings");

      const Swiper = elementorFrontend.utils.swiper;
      initSwiper();
      async function initSwiper() {
          var swiper = await new Swiper($gridCarouselContainer, $settings);
      };

  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-showcase-slider.default", ShowcaseSlider);
  });
})(jQuery, window.elementorFrontend);

