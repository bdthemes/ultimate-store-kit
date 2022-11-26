(function ($, elementor) {
  ("use strict");
  var SubCategoryCarousel = function ($scope, $) {
    var $SubCategoryCarousel = $scope.find(".usk-sub-category-carousel");
    if (!$SubCategoryCarousel.length) {
      return;
    }
    var $SubCategoryCarouselContainer = $SubCategoryCarousel.find(".swiper-container");
    var $carouselSettings = $SubCategoryCarousel.find('.usk-carousel').data("settings");
    // var $settings = $SubCategoryCarousel.find(".usk-sub-category-item").data("settings");
    // console.log($settings);

    const Swiper = elementorFrontend.utils.swiper;
    initSwiper();
    // async function initSwiper() {
    //   await new Swiper(".usk-image-slider", $settings);
    // }
    // initSwiper();
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
