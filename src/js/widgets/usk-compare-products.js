(function ($, elementor) {
  ("use strict");
  var widgetProductQuickView = {
    loadQuickViewHtml: function (_this, $scope) {
      var product_id = $(_this).data("id");
      $.ajax({
        type: "POST",
        dataType: "json",
        url: ultimate_store_kit_ajax_config.ajaxurl,
        data: {
          action: "ultimate_store_kit_compare_products_quick_view_content",
          product_id: product_id,
          security: $scope.find("#usk-compare-products-modal-sc").val(),
        },
        success: function (response) {
          $("#usk-grid-modal-response").html(response.data);
        },
      });
    },
  };
  var widgetWCQuickViewTrigger = function ($scope, $) {
    var $modalBody = '<div class="modal micromodal-slide" id="usk-grid-modal" aria-hidden="false"><div class="modal__overlay" tabindex="-1" data-custom-close=""><div id="usk-grid-modal-response" class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-btn-title"></div></div></div>';
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
    $scope.on("click", ".usk-view-btn", function (e) {
      e.preventDefault();
      widgetProductQuickView.loadQuickViewHtml(this, $scope);
    });
  };
  $(".ajax_remove_from_wishlist").click(function (e) {
    e.preventDefault();
    var $this = $(this);
    var $product_id = $this.data("product_id");
    $.ajax({
      url: ultimate_store_kit_ajax_config.ajaxurl,
      data: {
        action: "usk_add_to_wishlist",
        product_id: $product_id,
      },
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.action == "removed") {
          $this.closest("tr").remove();
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
  jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-compare-products.default", widgetWCQuickViewTrigger);
  });
})(jQuery, window.elementorFrontend);