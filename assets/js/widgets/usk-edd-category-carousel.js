/******/ (() => { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./src/js/widgets/usk-edd-category-carousel.js ***!
  \*****************************************************/
(function ($, elementor) {
  "use strict";
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
      var swiper = await new Swiper($eddCategoryCarouselContainer, $settings); // this is an example
      if ($settings.pauseOnHover) {
        $($eddCategoryCarouselContainer).hover(function () {
          this.swiper.autoplay.stop();
        }, function () {
          this.swiper.autoplay.start();
        });
      }
    }
    ;
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-edd-category-carousel.default", EddCategoryCarousel);
  });
})(jQuery, window.elementorFrontend);
/******/ })()
;
//# sourceMappingURL=usk-edd-category-carousel.js.map