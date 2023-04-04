(function ($, elementor) {
  "use strict";
  $(document).on("click", ".quick_view", function () {
    var product_id = $(this).data("id");
    get_product_details(product_id);
  });

  //woocommerce gallery
  $(document).on("click", ".thumbnails a", function (e) {
    var img_url = $(this).attr("data-href");
    $(".usk-modal-image-wrapper .images > a").attr("href", img_url);
    $(".usk-modal-image-wrapper .images > a > img").attr({
      src: img_url,
      srcset: img_url,
    });
  });
  $(document).on(
    "click",
    ".usk-modal-page .usk-modal-product .images a",
    function (e) {
      e.preventDefault();
      var img_url = $(this).attr("data-href");
      var img_src = $(this).find("img").attr("srcset");
      // $('.woocommerce-main-image').find('img').attr('src', img_url);
      // $('.woocommerce-main-image').find('img').attr('srcset', img_src);
      $(".woocommerce-main-image").closest("a").attr("href", img_url);

      $(".woocommerce-main-image").find("img").attr({
        src: img_url,
        srcset: img_src,
      });

      $("a.zoom").prettyPhoto({
        hook: "data-rel",
        social_tools: false,
        theme: "pp_woocommerce",
        horizontal_padding: 20,
        opacity: 0.8,
        deeplinking: false,
      });
      $("a[data-rel^='prettyPhoto']").prettyPhoto({
        hook: "data-rel",
        social_tools: false,
        theme: "pp_woocommerce",
        horizontal_padding: 20,
        opacity: 0.8,
        deeplinking: false,
      });
    }
  );

  function get_product_details(product_id) {
    if (product_id !== undefined) {
      jQuery.ajax({
        type: "POST",
        url: ultimate_store_kit_ajax_config.ajaxurl,
        data: {
          action: "ultimate_store_kit_wc_product_quick_view_content",
          product_id: product_id,
        },
        success: function (response) {
          setTimeout(function () {
            $("#quick-view-id").html(response);
          }, 1000);
        },
      });
    }
  }

  $(".elementor-widget-usk-florence-grid").on(
    "click",
    ".usk-pagination a",
    function (b) {
      b.preventDefault();
      const requestUrl = $(this).prop("href");
      $.ajax({
        url: requestUrl,
        success: function (d) {
          var data = $(d).find(".elementor-widget-usk-florence-grid");
          $(".elementor-widget-usk-florence-grid").html(data);
          if (window.history.pushState) {
            window.history.pushState({}, "", requestUrl);
          }
        },
      });
    }
  );

  // ========================================
  //                AJAX START
  // ========================================

  $(".ajax_add_to_wishlist").on("click", function (e) {
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
        if (response.action === "added") {
          $this.addClass("usk-active").attr("aria-label", response.message);
          $(".usk-wishlist-button")
            .find(".usk-wishlist-count")
            .html(response.count);
        } else {
          $this.removeClass("usk-active").attr("aria-label", response.message);
          $this.attr({
            href: "javascript:void(0);",
          });
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });
  $(".ajax_remove_from_wishlist").on("click", function (e) {
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
          $(".usk-wishlist-button")
            .find(".usk-wishlist-count")
            .html(response.count);
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });

  $(".ajax_add_to_compare").on("click", function (e) {
    var $this = $(this);
    var $product_id = $this.data("product_id");
    $.ajax({
      url: ultimate_store_kit_ajax_config.ajaxurl,
      data: {
        action: "usk_add_to_compare_products",
        product_id: $product_id,
      },
      type: "POST",
      dataType: "JSON",
      success: function (response) {
        if (response.action === "added") {
          $(".usk-compare-button")
            .find(".usk-compare-count")
            .html(response.count);
          $this.addClass("usk-active").attr({
            href: response.url,
            "aria-label": response.message,
          });
        } else {
          $this.attr({
            href: "javascript:void(0);",
            "aria-label": response.message,
          });
        }
      },
      error: function (response) {
        console.log(response);
      },
    });
  });

  $(".ajax_add_to_cart").on("click", function (e) {
    e.preventDefault();
    var $this = $(this);
    $this.attr("aria-label", "Added to cart");
  });
  // ========================================
  //                AJAX END
  // ========================================
  $(document).ready(function () {
    var loader = `<div class="usk-bouncing-loader"><div></div><div></div><div></div></div>`;
    var width = $(".product-quick-view").data("modal-width");
    var height = $(".product-quick-view").data("modal-height");
    var animation = $(".product-quick-view").data("animation");
    var close_btn = $(".product-quick-view").data("close-btn");
    var btn_style = $(".product-quick-view").data("btn-style");
    // var btn_place   = $('.product-quick-view').data('btn-place');
    var btn_text = $(".product-quick-view").data("btn-text");
    var modal_bg = $(".product-quick-view").data("modal-bg");
    var modal_overlay = $(".product-quick-view").data("modal-overlay");
    $(".product-quick-view").SlickModals({
      popup_reopenClass: "quick_view",
      popup_animation: animation,
      overlay_animation: animation,
      popup_closeButtonEnable: close_btn,
      popup_closeButtonStyle: btn_style,
      popup_closeButtonText: btn_text,
      popup_closeButtonPlace: "inside",
      popup_css: {
        width: width ? width + "px" : "800px",
        height: height ? height + "px" : "450px",
        background: modal_bg ? modal_bg : "#fff",
        "overflow-y": "auto",
        "animation-duration": "0.7s",
      },
      overlay_css: {
        background: modal_overlay,
      },
      mobile_breakpoint: "768px",
      mobile_position: "center",
      mobile_css: {
        width: "300px",
        padding: "30px",
        margin: "20px",
      },
      callback_afterClose: function () {
        $("#quick-view-id").html(loader);
      },
      callback_beforeOpen: function () {
        $("#quick-view-id").html(loader);
      },
    });
  });
})(jQuery, window.elementorFrontend);
