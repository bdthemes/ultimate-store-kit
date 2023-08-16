(function ($, elementor) {
  ("use strict");
  var EddCategoryCarousel = function ($scope, $) {
    var $eddCategoryCarousel = $scope.find(".usk-edd-category-carousel");
    if (!$eddCategoryCarousel.length) {
      return;
    }
    var $eddCategoryCarouselContainer = $eddCategoryCarousel.find(".swiper-carousel");
    var $settings = $eddCategoryCarousel.find(".usk-carousel").data("settings");

    const Swiper = elementorFrontend.utils.swiper;
    initSwiper();
    async function initSwiper() {
      var swiper = await new Swiper($eddCategoryCarouselContainer, $settings);
    }
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-edd-category-carousel.default",
      EddCategoryCarousel
    );
  });
})(jQuery, window.elementorFrontend);
