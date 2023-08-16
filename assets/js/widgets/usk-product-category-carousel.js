(function ($, elementor) {
  ("use strict");
  var ProductCategoryCarousel = function ($scope, $) {
    var $ProductCategoryCarousel = $scope.find(".usk-product-category-carousel");
    if (!$ProductCategoryCarousel.length) {
      return;
    }
    var $ProductCategoryCarouselContainer = $ProductCategoryCarousel.find(".swiper-carousel");
    var $carouselSettings = $ProductCategoryCarousel.find('.usk-carousel').data("settings");

    const Swiper = elementorFrontend.utils.swiper;
    initSwiper();


    async function initSwiper() {
      await new Swiper($ProductCategoryCarouselContainer, $carouselSettings);
    }
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-product-category-carousel.default",
      ProductCategoryCarousel
    );
  });
})(jQuery, window.elementorFrontend);
