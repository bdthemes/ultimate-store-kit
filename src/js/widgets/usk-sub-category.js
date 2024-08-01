(function ($, elementor) {
  ("use strict");
  var SubCategory = function ($scope, $) {
    var $SubCategory = $scope.find(".usk-sub-category");
    if (!$SubCategory.length) {
      return;
    }
    var items = $SubCategory.find(".usk-sub-category-item");


$(items).each(function (index) {
  var element = $(this).find(".usk-image-slider");
      const Swiper = elementorFrontend.utils.swiper;
      var $settings = $(this).data('settings');
    initSwiper();
    async function initSwiper() {
   await new Swiper(element, $settings);
    }
    });

  };
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-sub-category.default",
      SubCategory
    );
  });
})(jQuery, window.elementorFrontend);
