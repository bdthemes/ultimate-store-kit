(function ($, elementor) {
  ("use strict");
  var EDDProductReviewCarousel = function ($scope, $) {
    var $gridCarousel = $scope.find(".usk-edd-product-review-carousel");
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
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-edd-product-review-carousel.default", EDDProductReviewCarousel);
  });
})(jQuery, window.elementorFrontend);