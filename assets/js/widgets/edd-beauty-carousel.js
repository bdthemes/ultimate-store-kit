/******/ (() => { // webpackBootstrap
/*!***********************************************!*\
  !*** ./src/js/widgets/edd-beauty-carousel.js ***!
  \***********************************************/
(function ($, elementor) {
  "use strict";
  var BeautyCarousel = function ($scope, $) {
    var $gridCarousel = $scope.find(".usk-edd-beauty-carousel");
    if (!$gridCarousel.length) {
      return;
    }
    var $gridCarouselContainer = $gridCarousel.find(".swiper-carousel");
    var $settings = $gridCarousel.find(".usk-carousel").data("settings");
    const Swiper = elementorFrontend.utils.swiper;
    initSwiper();
    async function initSwiper() {
      var swiper = await new Swiper($gridCarouselContainer, $settings); // this is an example
      if ($settings.pauseOnHover) {
        $($gridCarouselContainer).hover(function () {
          this.swiper.autoplay.stop();
        }, function () {
          this.swiper.autoplay.start();
        });
      }
    }
    ;
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-edd-beauty-carousel.default", BeautyCarousel);
  });
})(jQuery, window.elementorFrontend);
/******/ })()
;