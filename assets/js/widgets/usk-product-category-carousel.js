/******/ (() => { // webpackBootstrap
/*!*********************************************************!*\
  !*** ./src/js/widgets/usk-product-category-carousel.js ***!
  \*********************************************************/
(function ($, elementor) {
  "use strict";
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
      var swiper = await new Swiper($ProductCategoryCarouselContainer, $carouselSettings); // this is an example
      if ($carouselSettings.pauseOnHover) {
        $($ProductCategoryCarouselContainer).hover(function () {
          this.swiper.autoplay.stop();
        }, function () {
          this.swiper.autoplay.start();
        });
      }
    }
    ;
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-product-category-carousel.default", ProductCategoryCarousel);
  });
})(jQuery, window.elementorFrontend);
/******/ })()
;
//# sourceMappingURL=usk-product-category-carousel.js.map