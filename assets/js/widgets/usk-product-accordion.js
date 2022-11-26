(function ($, elementor) {
  "use strict";
  var ProductAccordion = function ($scope, $) {
    $scope.find(".usk-product-accordion").each(function () {
      var AccordionContainer = $(this)[0];
      new Accordion(AccordionContainer);
    });
  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-product-accordion.default",
      ProductAccordion
    );
  });
})(jQuery, window.elementorFrontend);
