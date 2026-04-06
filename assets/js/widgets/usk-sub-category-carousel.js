/******/ (() => { // webpackBootstrap
/*!*****************************************************!*\
  !*** ./src/js/widgets/usk-sub-category-carousel.js ***!
  \*****************************************************/
(function ($, elementor) {
  "use strict";
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
      var swiper = await new Swiper($SubCategoryCarouselContainer, $carouselSettings); // this is an example
      if ($carouselSettings.pauseOnHover) {
        $($SubCategoryCarouselContainer).hover(function () {
          this.swiper.autoplay.stop();
        }, function () {
          this.swiper.autoplay.start();
        });
      }
    }
    ;
    setTimeout(function () {
      var items = $SubCategoryCarousel.find(".usk-item");
      $(items).each(function (index) {
        var element = $(this).find(".usk-image-slider");
        const Swiper = elementorFrontend.utils.swiper;
        var $settings = $(this).data('settings');
        if ($settings.effect === 'creative') {
          if ($settings.creativeEffect === 'creative-1') {
            $settings.creativeEffect = {
              next: {
                shadow: true,
                translate: ["100%", 0, 0]
              },
              prev: {
                shadow: true,
                translate: ["0%", "0%", -400]
              },
              limitProgress: 5
            };
          } else if ($settings.creativeEffect === 'creative-2') {
            $settings.creativeEffect = {
              next: {
                shadow: true,
                translate: ["120%", 0, -500]
              },
              prev: {
                shadow: true,
                translate: ["-120%", 0, -500]
              },
              limitProgress: 5
            };
          } else if ($settings.creativeEffect === 'creative-3') {
            $settings.creativeEffect = {
              next: {
                shadow: true,
                translate: ["100%", 0, 0]
              },
              prev: {
                shadow: true,
                translate: ["-20%", 0, -1]
              },
              limitProgress: 5
            };
          } else if ($settings.creativeEffect === 'creative-4') {
            $settings.creativeEffect = {
              next: {
                rotate: [0, 0, 90],
                shadow: true,
                translate: ["120%", "0%", -800]
              },
              prev: {
                rotate: [0, 0, -90],
                shadow: true,
                translate: ["-120%", "0%", -800]
              },
              limitProgress: 5
            };
          } else if ($settings.creativeEffect === 'creative-5') {
            $settings.creativeEffect = {
              next: {
                rotate: [0, 100, 0],
                shadow: true,
                translate: ["70%", "0%", -400]
              },
              prev: {
                rotate: [0, -100, 0],
                shadow: true,
                translate: ["-70%", "0%", -400]
              },
              limitProgress: 5
            };
          }
        }
        initSwiper();
        async function initSwiper() {
          await new Swiper(element, $settings);
        }
      });
    }, 1000);
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-sub-category-carousel.default", SubCategoryCarousel);
  });
})(jQuery, window.elementorFrontend);
/******/ })()
;
//# sourceMappingURL=usk-sub-category-carousel.js.map