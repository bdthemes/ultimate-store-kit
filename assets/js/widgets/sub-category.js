/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./src/js/widgets/sub-category.js ***!
  \****************************************/
(function ($, elementor) {
  "use strict";
  var SubCategory = function ($scope, $) {
    var $SubCategory = $scope.find(".usk-sub-category");
    if (!$SubCategory.length) {
      return;
    }
    var items = $SubCategory.find(".usk-item");
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
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-sub-category.default", SubCategory);
  });
})(jQuery, window.elementorFrontend);
/******/ })()
;