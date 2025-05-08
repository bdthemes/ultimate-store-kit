(function ($, elementor) {
  "use strict";

  // ===== GRID FILTER FUNCTIONALITY =====
  function setupGridFilter($scope) {
    $scope.find('*[data-filter="yes"]').each(function () {
      const $element = $(this);
      setupTabClickHandlers();
      loadSavedGridLayout($element);
    });
  }

  // Handle tab click events
  function setupTabClickHandlers() {
    $(".tab-option")
      .off("click")
      .on("click", function () {
        const gridColumn = $(this).data("grid-column");
        // Use sessionStorage instead of localStorage to persist across page loads
        localStorage.setItem("usk_grid_data", gridColumn);
        updateActiveTab($(this));
        updateGridLayout($(this), gridColumn);
      });
  }

  // Update which tab is active
  function updateActiveTab($clickedTab) {
    const $header = $clickedTab.closest(".usk-grid-header");
    $header.find("li").removeClass("usk-tabs-active");
    $clickedTab.parent().addClass("usk-tabs-active");
  }

  // Update the grid layout based on selected tab
  function updateGridLayout($clickedTab, gridColumn) {
    const $grid = $clickedTab.closest(".usk-grid-header").parent().find(".usk-grid");
    const baseClass = gridColumn !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
    $grid.removeClass().addClass(baseClass + " " + gridColumn);
  }

  // Load saved grid layout from localStorage
  function loadSavedGridLayout($element) {
    // Remove the elementor.isEditMode() check to ensure it works in all modes
    const savedGridData = localStorage.getItem("usk_grid_data");
    if (savedGridData) {
      // Find the tab with the saved grid column and make it active
      const $tab = $("[data-grid-column='" + savedGridData + "']");
      if ($tab.length) {
        $tab.parent().addClass("usk-tabs-active");
        const baseClass = savedGridData !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
        $element.find(".usk-grid").removeClass().addClass(baseClass + " " + savedGridData);
      }
    }
  }

  // ===== PRODUCT VARIATION FUNCTIONALITY =====
  function setupVariationButtons($scope) {
    $scope.find(".usk-variation-button").off("click").on("click", function (e) {
      e.preventDefault();
      const $this = $(this);
      const productId = $this.data("product-id");
      const attribute = $this.data("attribute");
      const value = $this.data("value");
      const variationId = $this.data("variation-id");
      const $productContainer = $(`.usk-item[data-product-id="${productId}"]`);

      updateActiveVariation($this, productId, attribute);
      const allAttributes = collectSelectedAttributes($productContainer);
      updateAddToCartButton($productContainer, productId, variationId, allAttributes);

      // Handle color variations specially
      if (attribute === "pa_color") {
        updateProductImage(productId, variationId, $productContainer);
        storeSelectedColor($this, value, $productContainer);
      }
    });
  }

  // Update which variation is active
  function updateActiveVariation($button, productId, attribute) {
    $(`.usk-variation-button[data-attribute="${attribute}"][data-product-id="${productId}"]`).removeClass("active");
    $button.addClass("active");
  }

  // Collect all selected attributes for a product
  function collectSelectedAttributes($productContainer) {
    const allAttributes = {};
    $productContainer.find(".usk-variation-button.active").each(function () {
      allAttributes[$(this).data("attribute")] = $(this).data("value");
    });
    return allAttributes;
  }

  // Update the add to cart button with variation data
  function updateAddToCartButton($productContainer, productId, variationId, allAttributes) {
    const $addToCartBtn = $productContainer.find(".usk-button");
    if (!$addToCartBtn.length) return;

    // Clear previous attributes
    $.each($addToCartBtn[0].attributes, function () {
      if (this.name.indexOf("data-attribute_") === 0) {
        $addToCartBtn.removeAttr(this.name);
      }
    });

    // Set new attributes
    $addToCartBtn.attr({
      "data-variation_id": variationId,
      "data-product_id": productId,
      href: "javascript:void(0)",
    });

    // Add attribute data
    Object.keys(allAttributes).forEach(attr => {
      $addToCartBtn.attr(`data-attribute_${attr}`, allAttributes[attr]);
    });

    // Update button classes
    $addToCartBtn
      .addClass("add_to_cart_button product_type_variation")
      .removeClass("product_type_variable")
      .html('Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>');
  }

  // Update product image for color variations
  function updateProductImage(productId, variationId, $productContainer) {
    $.ajax({
      url: woocommerce_params.ajax_url,
      type: "POST",
      data: {
        action: "get_variation_data",
        product_id: productId,
        variation_id: variationId,
      },
      success: function (response) {
        if (response.success && response.data?.image?.src) {
          $productContainer.find(".image-default, .image-hover").attr("src", response.data.image.src);
        }
      },
    });
  }

  // Store selected color information
  function storeSelectedColor($button, value, $productContainer) {
    const bgColor = $button.css("background-color");
    if (bgColor && bgColor !== "transparent" && bgColor !== "rgba(0, 0, 0, 0)") {
      $productContainer.attr("data-selected-color", value);
    }
  }

  // ===== ADD TO CART FUNCTIONALITY =====
  function setupAddToCartButtons() {
    $(document.body).off("click", ".usk-shiny-grid .usk-button.product_type_variation")
      .on("click", ".usk-shiny-grid .usk-button.product_type_variation", function (e) {
        e.preventDefault();

        const $button = $(this);
        if ($button.hasClass("processing")) return false;

        $button.addClass("processing loading");

        // Check for required data
        if (!$button.data("variation_id") || !$button.data("product_id")) {
          $button.removeClass("processing loading");
          return true;
        }

        const data = prepareCartData($button);
        sendAddToCartRequest($button, data);
        return false;
      });
  }

  // Prepare data for add to cart request
  function prepareCartData($button) {
    const data = {
      product_id: $button.data("product_id"),
      variation_id: $button.data("variation_id"),
      quantity: $button.data("quantity") || 1,
      "add-to-cart": $button.data("product_id"),
    };

    // Add attribute data
    $.each($button[0].attributes, function () {
      if (this.name.startsWith("data-attribute_")) {
        data[this.name.substring(5)] = this.value;
      }
    });

    return data;
  }

  // Send AJAX request to add product to cart
  function sendAddToCartRequest($button, data) {
    $.ajax({
      type: "POST",
      action: "usk_add_to_cart",
      data: data,
      success: function (response) {
        if (!response) {
          $button.removeClass("loading processing");
          return;
        }

        if (response.error) {
          window.location = $button.attr("href");
          return;
        }

        handleSuccessfulAddToCart($button, response);
      },
      error: function () {
        $button.removeClass("loading processing");
      },
    });
  }

  // Handle successful add to cart
  function handleSuccessfulAddToCart($button, response) {
    // Update cart fragments and trigger WooCommerce events
    $(document.body).trigger("wc_fragment_refresh");
    $(document.body).trigger("added_to_cart", [
      response.fragments,
      response.cart_hash,
      $button,
    ]);

    // showSuccessMessage($button);

  }

  // Show success message after adding to cart
  function showSuccessMessage($button) {
    const $notification = $('<div class="usk-cart-success-message">Product added to cart! ✓</div>');
    $button.closest(".usk-item").append($notification);

    // Auto remove notification
    setTimeout(function () {
      $notification.fadeOut(300, function () {
        $(this).remove();
        $button.removeClass("processing");
      });
    }, 2000);
  }

  // ===== MAIN INITIALIZATION FUNCTION =====
  function initializeGridFunctionality($scope) {
    setupGridFilter($scope);
    setupVariationButtons($scope);
    setupAddToCartButtons();
  }

  // Initialize on element ready
  function GridColumn($scope) {
    initializeGridFunctionality($scope);
  }

  // Re-initialize after AJAX content is loaded
  $(document).ajaxComplete(function (event, xhr) {
    if (
      xhr.responseText &&
      (xhr.responseText.indexOf("usk-shiny-grid") > -1 ||
       xhr.responseText.indexOf("usk-variation-button") > -1 ||
       xhr.responseText.indexOf("usk-grid") > -1)
    ) {
      initializeGridFunctionality($(document));
    }
  });

  // Register with Elementor
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-shiny-grid.default",
      GridColumn
    );
  });
})(jQuery, window.elementorFrontend);
