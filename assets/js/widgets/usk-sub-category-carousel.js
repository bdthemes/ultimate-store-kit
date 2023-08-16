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
      await new Swiper($SubCategoryCarouselContainer, $carouselSettings);
    }
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-sub-category-carousel.default",
      SubCategoryCarousel
    );
  });
})(jQuery, window.elementorFrontend);
