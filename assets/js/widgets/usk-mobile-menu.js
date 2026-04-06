/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./src/js/widgets/usk-mobile-menu.js ***!
  \*******************************************/
/**
 * Start marker widget script
 */

(function ($, elementor) {
  'use strict';

  var widgetIconMobileMenu = function ($scope, $) {
    var $marker = $scope.find('.usk-mobile-menu-wrap');
    if (!$marker.length) {
      return;
    }
    var $tooltip = $marker.find('ul > li > .usk-tippy-tooltip'),
      widgetID = $scope.data('id');
    $tooltip.each(function (index) {
      tippy(this, {
        allowHTML: true,
        theme: 'usk-tippy-' + widgetID
      });
    });
  };
  jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/usk-mobile-menu.default', widgetIconMobileMenu);
  });
})(jQuery, window.elementorFrontend);

/**
 * End marker widget script
 */
/******/ })()
;
//# sourceMappingURL=usk-mobile-menu.js.map