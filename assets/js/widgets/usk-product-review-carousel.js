(function ($, elementor) {
  ("use strict");
  var ProductReviewCarousel = function ($scope, $) {
    var $gridCarousel = $scope.find(".usk-product-review-carousel");
    if (!$gridCarousel.length) {
      return;
    }
    var $ReviewCarouselContainer = $gridCarousel.find(".swiper-carousel");
    var $settings = $gridCarousel.find('.usk-carousel').data("settings");
    const Swiper = elementorFrontend.utils.swiper;
      initSwiper();
      async function initSwiper() {
          var swiper = await new Swiper($ReviewCarouselContainer, $settings);
      };
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-product-review-carousel.default", ProductReviewCarousel);
  });
})(jQuery, window.elementorFrontend);