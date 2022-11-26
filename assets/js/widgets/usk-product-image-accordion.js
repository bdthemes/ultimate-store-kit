/**
 * Start woocommerce widget script
 */

(function ($, elementor) {
  "use strict";
  // Quickviews
  var widgetProductQuickView = {
    loadQuickViewHtml: function (_this, $scope) {
      var product_id = $(_this).data("id");
      $.ajax({
        type: "POST",
        dataType: "json",
        url: ultimate_store_kit_ajax_config.ajaxurl,
        data: {
          action: "ultimate_store_kit_product_image_accordion_quick_view_content",
          product_id: product_id,
          security: $scope.find("#usk-product-image-accordion-modal-sc").val(),
        },
        success: function (response) {
          $("#usk-grid-modal-response").html(response.data);
        },
      });
    },
  };

  var widgetWCQuickViewTrigger = function ($scope, $) {
    var $modalBody =
      '<div class="modal micromodal-slide" id="usk-grid-modal" aria-hidden="false"><div class="modal__overlay" tabindex="-1" data-custom-close=""><div id="usk-grid-modal-response" class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="modal-btn-title"></div></div></div>';

    $("body").append($modalBody);

    MicroModal.init({
      openTrigger: "data-micromodal-trigger",
      closeTrigger: "data-micromodal-close",
      disableScroll: true,
      disableFocus: false,
      awaitOpenAnimation: false,
      awaitCloseAnimation: false,
      debugMode: true,
    });

    $scope.on("click", ".usk-view", function (e) {
      e.preventDefault();
      widgetProductQuickView.loadQuickViewHtml(this, $scope);
    });
  };

  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-product-image-accordion.default",
      widgetWCQuickViewTrigger
    );
  });
})(jQuery, window.elementorFrontend);
